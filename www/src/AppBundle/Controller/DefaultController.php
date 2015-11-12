<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        $filters = array(
            'status' => true,
        );

        $order = array(
            'publishedAt' => 'DESC',
        );

        $em = $this->getDoctrine()->getManager();

        $posts = $em->getRepository('AppBundle:Post')->findBy($filters, $order, 3);

        $response = $this->render(
            'default/index.html.twig',
            array(
                'posts' => $posts,
            )
        );

        $response->setPublic();
        $response->setMaxAge(900); // 15 minutes

        return $response;
    }


}
