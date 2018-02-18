<?php

namespace AppBundle\Services;

use AppBundle\Entity\Departement;
use AppBundle\Entity\Election;
use AppBundle\Entity\Region;
use Doctrine\ORM\EntityManagerInterface;
use DOMElement;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\Validator\Validator\ValidatorInterface;


class DataImporter
{
    const DATA_FOLDER = "src/AppBundle/Resources/data";

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    public function __construct(EntityManagerInterface $em, ValidatorInterface $validator)
    {
        $this->em = $em;
        $this->validator = $validator;
    }

    private function getAvailableElections(): array {
        $finder = new Finder();
        $elections = [];

        /** @var SplFileInfo $file */
        foreach ($finder->in(self::DATA_FOLDER)->directories()->depth(0) as $file) {
            $elections[] = $file->getFilename();
        }

        return $elections;
    }

    private function getFirstFileResult(Finder $finder): SplFileInfo {
        if (!$finder->hasResults()) {
            throw new FileNotFoundException();
        }

        $iterator = $finder->getIterator();
        $iterator->rewind();

        return $iterator->current();
    }

    private function validateEntity($entity) {
        $errors = $this->validator->validate($entity);

        if (count($errors)) {
            throw new Exception(sprintf("Entity %s is invalid: %s", get_class($entity), (string) $errors));
        }
    }

    private function getTextOrNull(DOMElement $element = null): ?string {
        if (!$element) {
            return null;
        }

        $result = (string) $element->textContent;

        if (!$result) {
            return null;
        }

        return $result;
    }

    public function importElections() {
        $elections = $this->getAvailableElections();
        $electionObjs = [];

        foreach ($elections as $election) {
            $electionObj = new Election();
            $electionObj->setCode($election);
            $electionObjs[] = $electionObj;
            $this->validateEntity($electionObj);
            $this->em->persist($electionObj);
        }
        $this->em->flush();

        return $electionObjs;
    }

    public function importRegionsDepartementsCommunes(Election $election) {
        $finder = new Finder();
        $files = $finder->in(self::DATA_FOLDER)->path($election->getCode())->path("reference".mb_substr($election->getCode(), 0, 2))->name("listeregdptcom.xml")->files();

        try {
            $file = $this->getFirstFileResult($files);
        } catch (FileNotFoundException $e) {
            throw new FileNotFoundException(sprintf("Le fichier 'listeregdptcom.xml' est introuvable pour l'élection %s", $election->getCode()), $e);
        }

        $crawler = new Crawler($file->getContents());

        $regions = $crawler->filter('Election > Regions')->children();
        foreach ($regions as $region) {
            $codeRegion = $this->getTextOrNull($region->getElementsByTagName("CodReg")->item(0)) ?? Region::UNKNOWN_REGION_CODE;

            $regionObj = $this->em->getRepository("AppBundle:Region")->findOneBy(['code' => $codeRegion]);
            if (!$regionObj) {
                $regionObj = new Region();
                $regionObj->setCode($codeRegion);
            }
            if (!$regionObj->getCode3Car()) {
                $regionObj->setCode3Car($this->getTextOrNull($region->getElementsByTagName("CodReg3Car")->item(0)));
            }
            if (!$regionObj->getNom()) {
                $regionObj->setNom($this->getTextOrNull($region->getElementsByTagName("LibReg")->item(0)));
            }

            $this->validateEntity($regionObj);
            $this->em->persist($regionObj);

            $departements = $region->getElementsByTagName("Departements")->item(0)->getElementsByTagName("Departement");
            /** @var DOMElement $departement */
            foreach ($departements as $departement) {
                $codeDepartement = $this->getTextOrNull($departement->getElementsByTagName("CodDpt")->item(0));

                $departementObj = $this->em->getRepository("AppBundle:Departement")->findOneBy(['code' => $codeDepartement]);
                if (!$departementObj) {
                    $departementObj = new Departement();
                    $departementObj->setCode($codeDepartement);
                    $regionObj->addDepartement($departementObj);
                }

                if (!$departementObj->getCodeMin()) {
                    $departementObj->setCodeMin($this->getTextOrNull($departement->getElementsByTagName("CodMinDpt")->item(0)));
                }

                if (!$departementObj->getCode3Car()) {
                    $departementObj->setCode3Car($this->getTextOrNull($departement->getElementsByTagName("CodDpt3Car")->item(0)));
                }

                if (!$departementObj->getNumOrdre()) {
                    $departementObj->setNumOrdre((int) $this->getTextOrNull($departement->getElementsByTagName("NumOrdDpt")->item(0)));
                }

                if (!$departementObj->getNom()) {
                    $departementObj->setNom($this->getTextOrNull($departement->getElementsByTagName("LibDpt")->item(0)));
                }

                $this->validateEntity($departementObj);
                $this->em->persist($departementObj);
            }
        }

        $this->em->flush();
    }
}
