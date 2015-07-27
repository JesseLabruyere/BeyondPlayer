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
use AppBundle\Entity\AudioFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\File;

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




    /**
     * @Route("app/getUploadForm", name="getUploadForm")
     *
     * We create a form for uploading files, that will be submitted conform the VichUploadBundle configuration
     */
    public function getUploadForm(Request $request){

        /* the entity that will be added using the form */
        $audioFile = new AudioFile();

        $form = $this->createFormBuilder($audioFile)
            ->add('name', 'text')
            ->add('description', 'text')
            ->add('file', 'file', array(
                'label' => 'Audio File'
            ))
            ->add('submit', 'submit', array('label' => 'uploaden'))
            ->getForm();

/*        $form->handleRequest($request);

        if ($form->isValid()) {
            // perform some action, such as saving the task to the database
            return $this->redirectToRoute('task_success');
        }

        return new Response();*/

        /* this code will check if the form was submitted if not it will do nothing */
        $form->handleRequest($request);

        /* isValid() returns false if the form was not submitted */
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            // perform some action, such as saving the task to the database
/*            $name = $audioFile->getFile();
            return new Response($name);*/
            /* setting the values that are not covered by the form*/

            $audioFile->setLength(10);
            $audioFile->setSize(10);
            $audioFile->setFileName($audioFile->getFile());

            $em->persist($audioFile);
            $em->flush();

            return $this->redirectToRoute('task_success');

            /*return new Response($audioFile->getFile());*/
        } else {

            return $this->render('html_templates/upload_form.html.twig', array(
                'form' => $form->createView(),
            ));

        }
    }

    /**
     * @Route("app/task_success", name="task_success")
     *
     * We create a form for uploading files, that will be submitted conform the VichUploadBundle configuration
     */
    public function taskSuccess() {
        return new Response('success!');
    }

}
