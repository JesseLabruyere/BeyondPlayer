<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
/*use AppBundle\model\testModel;*/
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\Audio;
use AppBundle\Entity\User;
use AppBundle\Entity\Playlist;
use AppBundle\Entity\Genre;
use AppBundle\Entity\Album;
use AppBundle\Entity\Artist;
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
     * @Route("app/removeAudio/{audioId}", name="removeAudio")
     */
    public function removeAudio($audioId)
    {
        if(!isset($audioId))
        {
            return new Response( json_encode( array('success' => false, 'reason' => 'no audioId parameter was given') ) );
        }

        $user = $this->getUser();
        $uploadList = $user->getUploads();
        $audio = $uploadList->getListItemById($audioId);

        if(!isset($audio))
        {
            return new Response( json_encode( array('success' => false, 'reason' => 'audio with id: ' . $audioId . ' not found') ) );
        }

        /* persist the objects */
        $em = $this->getDoctrine()->getManager();
        $em->remove($audio);
        $em->flush();

        return new Response( json_encode( array('success' => true) ) );
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
            $user->setUploads($defaultPlaylist);

            /* persist the objects */
            $em = $this->getDoctrine()->getManager();
            $em->persist($defaultPlaylist);
            $em->persist($user);
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

        /* get current User object*/
        $user = $this->getUser();
        $playlists = $user->getPlaylistPickerData();
        $albums = $user->getAlbumsPickerData();

        $artists = $user->getArtistsPickerData();

    /*        $this->getDoctrine()
                        ->getRepository('AppBundle:Artist')
                        ->getAllArtistsPickerData();*/

        /* setAction is needed because we will embed the form in a page, so the url wont match */
        /* property_path tells the formbuilder that its not a variable bound to the Audio entity*/
        $form = $this->createFormBuilder($audio)
            ->setAction($this->generateUrl('getUploadForm'))
            ->add('name', 'text')
            ->add('file', 'file', array('label' => false))
            ->add('playlist', 'choice',
            array(  'choices'  => $playlists,
                    'required' => false,
                    'mapped' => false ))
            ->add('album', 'choice',
                array(  'choices'  => $albums,
                    'required' => false,
                    'mapped' => false ))
            ->add('artist', 'choice',
                array(  'choices'  => $artists,
                    'required' => false,
                    'mapped' => false))
            ->add('submit', 'submit', array('label' => 'Upload'))
            ->getForm();

        /* this code will check if the form was submitted if not it will do nothing */
        $form->handleRequest($request);

        /* isValid() returns false if the form was not submitted */
        if ($form->isValid()) {

            /* get current user */
            /*$user = $this->get('security.token_storage')->getToken()->getUser();*/
            $user = $this->getUser();

            /* get the optional playlist value */
            $playlist = $form->get('playlist')->getData();
            /* get the optional artist value */
            $artist = $form->get('artist')->getData();
            /* get the optional album value */
            $album = $form->get('album')->getData();

            /* get the right playlist form the db */
            $uploadList = $user->getUploads();

            /* add the listItem to the PlayList*/
            $uploadList->addAudio($audio);

            /* doctrine manager to persist objects with */
            $em = $this->getDoctrine()->getManager();

            /* check if the optional playlist was set*/
            if(isset($album)){
                $optionalAlbum = $user->getAlbumById($album);
                if(isset($optionalAlbum)) {

                    $optionalAlbum->addAudio($audio);
                    /*persist object*/
                    $em->persist($optionalAlbum);

                    $albumSet = true;
                }
            }

            if( isset($artist)){
                $optionalArtist = $user->getArtistById($artist);
                if(isset($optionalArtist)) {
                    $audio->addArtist($optionalArtist);
                    /*persist object*/
                    $em->persist($optionalArtist);
                }
            }
            /* check if the optional playlist was set*/
            if(isset($playlist)){
                $optionalList = $user->getPlayListById($playlist);
                if(isset($optionalList)) {
                    $optionalList->addAudio($audio);
                    /*persist object*/
                    $em->persist($optionalList);
                }
            }

            /* persist the objects */
            $em->persist($audio);
            $em->persist($uploadList);
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

    /**
     * @Route("app/getPlaylist/{name}", name="getPlaylist")
     *
     * returns a playlist with all its Audio objects based on a name
     */
    public function getPlaylist($name) {

        if(!isset($name)) {
            return new Response(json_encode( array('success' => false, 'reason' => 'no name parameter given') ));
        }

        /* get current User object*/
        $user = $this->getUser();
        /* get the right playlist*/
        $playList = $user->getPlayListByName($name);
        if(!isset($playList)) {
            return new Response(json_encode( array('success' => false, 'reason' => 'no results') ));
        }

        return new Response(json_encode( array('success' => true, 'playlist' => $playList) ));
    }

    /**
     * @Route("app/getPlaylists", name="getPlaylists")
     *
     * returns a playlist with all its Audio objects based on a name
     */
    public function getPlaylists() {

        /* get current User object*/
        $user = $this->getUser();
        /* get the right playlist*/
        $playLists = $user->getPlayLists()->getValues();

        if(!isset($playLists)) {
            return new Response(json_encode( array('success' => false, 'reason' => 'no results') ));
        }

        return new Response(json_encode( array('success' => true, 'playlists' => $playLists ) ));
    }

    /**
     * @Route("app/addToPlaylist/{listId}/{audioId}", name="addToPlaylist")
     *
     * returns a playlist with all its Audio objects based on a name
     */
    public function addToPlaylist($listId, $audioId) {

        /* check the parameters*/
        if(!isset($listId)) {
            return new Response(json_encode( array('success' => false, 'reason' => 'no listId given') ));
        }
        if(!isset($audioId)) {
            return new Response(json_encode( array('success' => false, 'reason' => 'no audioId given') ));
        }

        /* get current User object*/
        $user = $this->getUser();
        /* get the uploads */
        $uploads = $user->getUploads();

        /* get the right playlist*/
        $playList = $user->getPlayListById($listId);
        if(!isset($playList)) {
            return new Response(json_encode( array('success' => false, 'reason' => 'playList with id: '. $listId .' not found') ));
        }

        /* check if the playList does not contain this respective audio already */
        $duplicate = $playList->getListItemById($audioId);
        if(isset($duplicate)) {
            return new Response(json_encode( array('success' => false, 'reason' => 'duplicate') ));
        }

        /* find the audio using the id*/
        $audio = $uploads->getListItemById($audioId);
        if(!isset($audio)) {
            return new Response(json_encode( array('success' => false, 'reason' => 'audio with id: '. $audioId .' not found') ));
        }

        /* add the audio to the playList */
        $playList->addAudio($audio);

        /* persist the objects */
        $em = $this->getDoctrine()->getManager();
        $em->persist($playList);
        $em->flush();

        return new Response(json_encode( array('success' => true) ));
    }

    /**
     * @Route("app/getAlbum/{name}", name="getAlbum")
     *
     * returns an album with all its Audio objects based on a name
     */
    public function getAlbum($name) {

        if(!isset($name)) {
            return new Response(json_encode( array('success' => false, 'reason' => 'no name parameter given') ));
        }

        /* get current User object*/
        $user = $this->getUser();
        /* get the right playlist*/
        $album = $user->getAlbumByName($name);

        if(!isset($album)) {
            return new Response(json_encode( array('success' => false, 'reason' => 'no results') ));
        }

        return new Response(json_encode( array('success' => true, 'album' => $album) ));
    }

    /**
     * @Route("app/getAlbums", name="getAlbums")
     *
     * returns a playlist with all its Audio objects based on a name
     */
    public function getAlbums() {

        /* get current User object*/
        $user = $this->getUser();
        /* get the right playlist*/
        $albums = $user->getAlbums()->getValues();

        if(!isset($albums)) {
            return new Response(json_encode( array('success' => false, 'reason' => 'no results') ));
        }

        return new Response(json_encode( array('success' => true, 'albums' => $albums ) ));
    }

    /**
     * @Route("app/getUploads", name="getUploads")
     *
     * returns a playlist with all its Audio objects based on a name
     */
    public function getUploads() {

        /* get current User object*/
        $user = $this->getUser();
        /* get the right playlist*/
        $uploads = $user->getUploads();

        if(!isset($uploads)) {
            return new Response(json_encode( array('success' => false, 'reason' => 'no results') ));
        }

        return new Response(json_encode( array('success' => true, 'uploads' => $uploads) ));
    }



    /**
     * @Route("app/getPlaylistsView", name="getPlaylistsView")
     *
     * returns the playlist view
     */
    public function getPlaylistsView() {
        return $this->render('html_templates/playlists_view.html.twig');
    }

    /**
     * @Route("app/getPlaylistView", name="getPlaylistView")
     *
     * returns the playlist view
     */
    public function getPlaylistView() {
        return $this->render('html_templates/playlist_view.html.twig');
    }

    /**
     * @Route("app/getAlbumsView", name="getAlbumsView")
     *
     * returns the playlist view
     */
    public function getAlbumsView() {
        return $this->render('html_templates/albums_view.html.twig');
    }

    /**
     * @Route("app/getAlbumView", name="getAlbumView")
     *
     * returns the playlist view
     */
    public function getAlbumView() {
        return $this->render('html_templates/album_view.html.twig');
    }

    /**
     * @Route("app/getUploadsView", name="getUploadsView")
     *
     * returns the playlist view
     */
    public function getUploadsView() {
        return $this->render('html_templates/uploads_view.html.twig');
    }

    /**
     * @Route("app/empty", name="getEmpty")
     *
     * returns the playlist view
     */
    public function getEmpty() {
        return new response('');
    }

    /**
     * @Route("app/getArtists", name="getArtists")
     *
     * returns artists
     */
    public function getArtists(){
        $artists = $this->getDoctrine()
            ->getRepository('AppBundle:Artist')
            ->getAllArtistsPickerData();

        return new Response(json_encode( array('success' => true, 'artists' => $artists) ));
    }


}
