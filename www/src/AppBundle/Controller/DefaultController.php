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
        $em = $this->getDoctrine()->getManager();

        // Posts
        $filters = array(
            'status' => true,
        );

        $order = array(
            'publishedAt' => 'DESC',
        );

        $posts = $em->getRepository('AppBundle:Post')->findBy($filters, $order, 3);

        // Blocks
        $filters = array(
            'status' => true,
            'promoted' => true,
        );

        $order = array(
            'weight' => 'ASC',
        );

        $blocks = $em->getRepository('AppBundle:Block')->findBy($filters, $order);


        $response = $this->render(
            'default/index.html.twig',
            array(
                'posts' => $posts,
                'blocks' => $blocks,
            )
        );

        $response->setPublic();
        $response->setMaxAge(900); // 15 minutes

        return $response;
    }

    /**
     * @Route("/shuwee", name="shuwee")
     */
    public function shuweeAction()
    {
        $em = $this->getDoctrine()->getManager();

        $filters = array(
            'status' => true,
        );

        $order = array(
            'promoted' => 'DESC',
            'weight' => 'ASC',
        );

        $blocks = $em->getRepository('AppBundle:Block')->findBy($filters, $order);

        $response = $this->render(
            'default/shuwee.html.twig',
            array(
                'blocks' => $blocks,
            )
        );

        $response->setPublic();
        $response->setMaxAge(900); // 15 minutes

        return $response;
    }
}
