<?php

namespace AppBundle\Command;

use AppBundle\Entity\Election;
use AppBundle\Services\DataImporter;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ImportData extends ContainerAwareCommand
{
    /**
     * @var DataImporter
     */
    private $dataImporter;

    public function __construct(DataImporter $dataImporter)
    {
        parent::__construct();
        $this->dataImporter = $dataImporter;
    }


    protected function configure()
    {
        $this
            ->setName('import:data')
            ->setDescription('Importe résultats.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("Importation des élections...");
        $elections = $this->dataImporter->importElections();
        $output->writeln(sprintf("%s élection(s) trouvée(s) !", count($elections)));

        /** @var Election $election */
        foreach ($elections as $election) {
            $output->writeln(sprintf("Importation des régions, départements et communes pour de %s", $election->getCode()));
            $this->dataImporter->importRegionsDepartementsCommunes($election);
            $output->writeln(sprintf("Importation des régions, départements et communes finie pour %s", $election->getCode()));

        }
    }
}
