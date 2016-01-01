<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class PostController
 * @package AppBundle\Controller
 */
class PostController extends Controller
{
    /**
     * @Route("/posts", name="posts_index")
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getPostsAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $query = $em->getRepository('AppBundle:Post')
            ->createQueryBuilder('p')
            ->where('p.status = :status')
            ->setParameter('status', true)
            ->orderBy('p.publishedAt', 'DESC')
            ->getQuery();

        $paginator  = $this->get('knp_paginator');
        $paginatedPosts = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            5
        );

        $response = $this->render(
            'post/index.html.twig',
            array(
                'posts' => $paginatedPosts,
            )
        );

        $response->setPublic();
        $response->setMaxAge(900); // 15 minutes

        return $response;
    }

    /**
     * @Route("/posts/{slug}", name="post_details")
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param string $slug
     *
     * @return JsonResponse|NotFoundHttpException
     */
    public function getPostAction(Request $request, $slug)
    {
        $em = $this->getDoctrine()->getManager();

        $post = $em->getRepository('AppBundle:Post')->findOneBy(array('slug' => $slug));

        if (!$post) {
            throw $this->createNotFoundException();
        }

        $response = $this->render(
            'post/details.html.twig',
            array(
                'post' => $post,
            )
        );

        $response->setPublic();
        $response->setMaxAge(900); // 15 minutes

        return $response;
    }

    /**
     * @Route("/api/posts")
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getPostsJSONAction(Request $request)
    {
        // load all posts
        $filters = array(
            'status' => true,
        );

        $order = array(
            'publishedAt' => 'DESC',
        );

        $em = $this->getDoctrine()->getManager();

        $posts = $em->getRepository('AppBundle:Post')->findBy($filters, $order);

        // Return as associative array to avoid JSON Hijacking
        $response = new JsonResponse(array('posts' => $posts));

        // allow JSONP
        $callback = $request->query->get('callback');
        if (!is_null($callback)) {
            $response->setCallback($callback);
        }

        $response->setPublic();
        $response->setMaxAge(900); // 15 minutes

        $response->headers->set('Access-Control-Allow-Methods', 'GET');

        return $response;
    }

    /**
     * @Route("/api/posts/{slug}")
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param string $slug
     *
     * @return JsonResponse|NotFoundHttpException
     */
    public function getPostJSONAction(Request $request, $slug)
    {
        $em = $this->getDoctrine()->getManager();

        $post = $em->getRepository('AppBundle:Post')->findOneBy(array('slug' => $slug));

        if (!$post) {
            throw $this->createNotFoundException();
        }

        // Return as associative array to avoid JSON Hijacking
        $response = new JsonResponse(array('value' => $post));

        // allow JSONP
        $callback = $request->query->get('callback');
        if (!is_null($callback)) {
            $response->setCallback($callback);
        }

        $response->setPublic();
        $response->setMaxAge(900); // 15 minutes

        $response->headers->set('Access-Control-Allow-Methods', 'GET');

        return $response;
    }

}
