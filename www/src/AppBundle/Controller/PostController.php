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
     * @Route("/posts")
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getPostsAction(Request $request)
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
     * @Route("/posts/{slug}")
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
