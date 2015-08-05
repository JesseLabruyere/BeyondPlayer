<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
/*use AppBundle\model\testModel;*/
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\Product;
use AppBundle\Entity\Audio;
use AppBundle\Entity\User;
use AppBundle\Entity\Playlist;
use AppBundle\Entity\ListItem;
use Symfony\Component\HttpFoundation\Response;
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
        return $this->render('page_template/index.html.twig', array( 'headerTitle' => 'MusicPlayer'));
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
     * @Route("app/getRegistrationForm", name="getRegistrationForm")
     *
     * We create a form for registering new users, that will also be submitted to this route
     */
    public function getRegistrationForm(Request $request){

        /* the entity that will be added using the form */
        $user = new User();

        /* setAction is needed because we will embed the form in a page, so the url wont match */
        $form = $this->createFormBuilder($user)
            ->setAction($this->generateUrl('getRegistrationForm'))
            ->add('email', 'text', array('label' => 'Email'))
            ->add('username', 'text', array('label' => 'Username'))
            ->add('password', 'repeated', array(
                'first_name'  => 'password',
                'second_name' => 'confirm',
                'type'        => 'password',
                'label' => 'Password'
            ))
            ->add('submit', 'submit', array('label' => 'Confirm'))
            ->getForm();

        /* this code will check if the form was submitted if not it will do nothing */
        $form->handleRequest($request);

        /* isValid() returns false if the form was not submitted */
        if ($form->isValid()) {

            /* We check if the username and email do not exist in the database */
            $repository = $this->getDoctrine()->getRepository('AppBundle:User');
            $userByName = $repository->findOneBy( array('username' => $user->getUsername()) );

            if (!$userByName) {
                /* no results with this username where found */
            } else {
                return new Response( json_encode( array('success' => false, 'reason' => 'username already exists') ) );
            }

            $userByEmail = $repository->findOneBy( array('email' => $user->getEmail()) );

            if (!$userByEmail) {
                /* no results with this email where found */
            } else {
                return new Response( json_encode( array('success' => false, 'reason' => 'email already exists') ) );
            }

            /* we will encode the password */
            $plainPassword = $user->getPassword();
            $encoder = $this->container->get('security.password_encoder');
            $encoded = $encoder->encodePassword($user, $plainPassword);
            $user->setPassword($encoded);

            // we create the default playlist
            $defaultPlaylist = new Playlist();
            $defaultPlaylist->setListName("Uploads");
            // adding/relating the playlist to the user
            // we still have to persist them individually
            $user->addPlayList($defaultPlaylist);

            /* persist the objects */
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->persist($defaultPlaylist);
            $em->flush();

            return new Response( json_encode( array('success' => true) ) );
            /*return $this->redirectToRoute('task_success');*/

            /*return new Response((string)print_r($product));*/
        } else {

            return $this->render('html_templates/registration_form.html.twig', array(
                'form' => $form->createView(),
            ));

        }

    }


    /**
     * @Route("app/getUploadForm", name="getUploadForm")
     *
     * We create a form for uploading files, that will also be submitted to this route
     */
    public function getUploadForm(Request $request){

        /* the entity that will be added using the form */
        $audio = new Audio();

        /* setAction is needed because we will embed the form in a page, so the url wont match */
        $form = $this->createFormBuilder($audio)
            ->setAction($this->generateUrl('getUploadForm'))
            ->add('name', 'text')
            ->add('file', 'file')
            ->add('submit', 'submit', array('label' => 'uploaden'))
            ->getForm();

        /* this code will check if the form was submitted if not it will do nothing */
        $form->handleRequest($request);

        /* isValid() returns false if the form was not submitted */
        if ($form->isValid()) {

            /* get current user */
            /*$user = $this->get('security.token_storage')->getToken()->getUser();*/
            $user = $this->getUser();

            /* create a new ListItem and add the audio to it*/
            $listItem = new ListItem();
            $listItem->setAudio($audio);

            /* get the right playlist form the db */
            $playlistRepository = $this->getDoctrine()->getRepository('AppBundle:Playlist');
            $uploadList = $playlistRepository->findOneBy( array('user' => $user, 'listName' => 'Uploads') );

            /* add the listItem to the PlayList*/
            $uploadList->addListItem($listItem);


            /* persist the objects */
            $em = $this->getDoctrine()->getManager();
            $em->persist($audio);
            $em->persist($uploadList);
            $em->persist($listItem);
            $em->flush();

            return new Response( json_encode( array('success' => true) ) );

            /*return $this->redirectToRoute('task_success');*/
            /*return new Response((string)print_r($product));*/
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


    public function coupleAudioToPlaylist() {
       //..
    }
}
