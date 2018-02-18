<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Region;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Template("@App/Default/index.html.twig")
     */
    public function indexAction(EntityManagerInterface $em)
    {
        $regions = $em->getRepository('AppBundle:Region')->findBy([], ['nom' => 'ASC']);

        return [
            'regions' => $regions,
        ];
    }

    /**
     * @Route("/region/{code}", name="region")
     * @Template("@App/Default/region.html.twig")
     * @ParamConverter("region", options={"mapping": {"code": "code"}})
     */
    public function regionAction(Region $region)
    {
        return [
            'region' => $region,
        ];
    }
}
