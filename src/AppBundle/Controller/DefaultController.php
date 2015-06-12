<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\model\testModel;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\Product;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{




    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        // whenevert a twig page is being rendered variabeles can be passed in an array
        return $this->render('default/index.html.twig', array( 'testTwigVariable' => 'Dit is een Twig Variable'));
    }

    /**
     * @Route("app/trol", name="nothomepage")
     */
    public function wow()
    {
        /*
         * The action's view can be rendered using render() method
         * or @Template annotation as demonstrated in DemoController.
         *          return $this->render('default/index.html.twig');
         */

        $product = new Product();
        $product->setName('A Foo Bar');
        $product->setPrice('19.99');
        $product->setDescription('Lorem ipsum dolor');

        $em = $this->getDoctrine()->getManager();

        $em->persist($product);
        $em->flush();

        return new Response('Created product id '.$product->getId());


    }


}
