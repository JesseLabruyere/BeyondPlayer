<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
/*use AppBundle\model\testModel;*/
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\Product;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Utility\UploadHandler;

class DefaultController extends Controller
{




    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        // whenevert a twig page is being rendered variabeles can be passed in an array
        return $this->render('default/index.html.twig', array( 'headerTitle' => 'MusicPlayer'));
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

    /**
     * @Route("app/uploadForm", name="uploadForm")
     */
    public function uploadForm()
    {
        return $this->render('html_templates/upload.html.twig', array());
    }

    /**
     * @Route("app/test", name="test")
     */
    public function test()
    {
        return $this->render('default/test.html.twig', array());
    }

    /**
     * @Route("app/upload/", name="upload")
     *
     * route for uploading files
     */
    public function upload()
    {
        error_reporting(E_ALL | E_STRICT);
        $rootURL = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/';

        /* script_url is the current route http://localhost.com/app/upload/ */
        /* upload_dir is the directory path were the images reside MusicPlayer/web/uploads/ */
        /* upload_url is the url to the folder with images http://localhost.com/uploads/ */
        $options = array ('script_url' =>  $rootURL . 'app/upload/', 'upload_dir' => $_SERVER['DOCUMENT_ROOT'] . '/uploads/', 'upload_url' => $rootURL . 'uploads/');

        $upload_handler = new UploadHandler($options);

        /* we have to return an response else symfony will throw errors */
        return new Response();
    }

    /**
     * @Route("app/upload/upload", name="deleteUpload")
     */
    public function deleteUpload()
    {

    }


    /**
     * @Route("app/checkPath", name="checkPath")
     */
    public function getUrl(){
        $root = $_SERVER['DOCUMENT_ROOT'];
        return new Response($root);
    }

}
