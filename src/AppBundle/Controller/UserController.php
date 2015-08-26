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
use AppBundle\Controller\PlaylistController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpKernel\Profiler\RedisProfilerStorage;

class UserController extends Controller
{
    /**
     * @Route("app/user/getUploads/{page}/{amount}", name="getUploads")
     *
     * returns data from the Uploads list
     */
    public function getUploads($page = 1, $amount = NULL){
        /* we want to remember this value for later*/
        $givenAmount = $amount;

        /* this makes it easier when doing calculations*/
        $page = $page -1;
        $user = $this->getUser();
        $playlist = $user->getUploads();

        $listSize = $playlist->countItems();

        /* check how many pages there can be made with the list and for given amount,
        * we round up to not miss a half filled page
        */
        $numberOfPages = (isset($amount) ? ceil($listSize / $amount) : 1);

        /* we calculate the position within the playlist*/
        $position = (isset($amount) ? $page * $amount : 0 );


        /* the requested page does not fall within the list*/
        if(isset($amount)) {
            if ($listSize < ($page * $amount)) {
                return new Response(json_encode(array('success' => false, 'playlist' => 'page does not exist')));

                /* check if the page falls at the end of the list */
            } else if ($listSize < (($page * $amount) + $amount)) {
                /* we set the amount to the last items of the array */
                $amount = ($listSize - ($page * $amount));
            }
        }



        $controller = new PlaylistController();
        $results = $controller->getSelection($playlist, $position, $amount);
        $results['pages'] = $numberOfPages;
        $results['itemsPerPage'] = $givenAmount;
        return new Response( json_encode( array('success' => true, 'playlist' =>$results) ) );
    }

    /**
     * @Route("app/user/getPlaylistResults/{listId}/{page}/{amount}", name="getPlaylistResults")
     *
     * returns data from a Playlist
     */
    public function getPlaylistResults($listId, $page = 1, $amount = NULL){
        /* we want to remember this value for later*/
        $givenAmount = $amount;

        if(! isset($listId)){
            return new Response(json_encode(array('success' => false, 'reason' => 'no listId found')));
        }

        $playlist = $this->getUser()->getPlayListById($listId);

        if(! isset($playlist)){
            return new Response( json_encode(array('success' => false, 'reason' => 'list not found')));
        }

        /* this makes it easier when doing calculations*/
        $page = $page -1;
        $listSize = $playlist->countItems();

        /* check how many pages there can be made with the list and for given amount,
         * we round up to not miss a half filled page
         */
        $numberOfPages = (isset($amount) ? ceil($listSize / $amount) : 1);

        /* we calculate the position within the playlist*/
        $position = (isset($amount) ? $page * $amount : 0 );

        if(isset($amount)) {
            if ($listSize < ($page * $amount)) {
                return new Response(json_encode(array('success' => false, 'playlist' => 'page does not exist')));

                /* check if the page falls at the end of the list */
            } else if ($listSize < (($page * $amount) + $amount)) {
                /* we set the amount to the last items of the array */
                $amount = ($listSize - ($page * $amount));
            }
        }

        $controller = new PlaylistController();

        $results = $controller->getSelection($playlist, $position, $amount);
        $results['pages'] = $numberOfPages;
        $results['itemsPerPage'] = $givenAmount;
        return new Response( json_encode( array('success' => true, 'playlist' => $results) ) );
    }

    /**
     * @Route("app/user/getPlaylists", name="getPlaylists")
     *
     * returns Playlist array
     */
    public function getPlaylists()
    {
        $results = $this->getUser()->getPlaylistData();
        return new Response( json_encode( array('success' => true, 'playlists' => $results) ) );
    }


    /**
     * @Route("app/user/getAlbumResults/{albumId}/{page}/{amount}", name="getAlbumResults")
     *
     * returns data from an Album
     */
    public function getAlbumResults($albumId, $page = 1, $amount = NULL){
        /* we want to remember this value for later*/
        $givenAmount = $amount;

        if(! isset($albumId)){
            return new Response(json_encode(array('success' => false, 'reason' => 'no albumId found')));
        }

        $album = $this->getUser()->getAlbumById($albumId);

        if(! isset($album)){
            return new Response( json_encode(array('success' => false, 'reason' => 'album not found')));
        }

        /* this makes it easier when doing calculations*/
        $page = $page -1;
        $albumSize = $album->countItems();

        /* check how many pages there can be made with the album and for given amount,
         * we round up to not miss a half filled page
         */
        $numberOfPages = (isset($amount) ? ceil($albumSize / $amount) : 1);

        /* we calculate the position within the album*/
        $position = (isset($amount) ? $page * $amount : 0 );

        /* the requested page does not fall within the list*/
        if(isset($amount)) {
            if ($albumSize < ($page * $amount)) {
                return new Response(json_encode(array('success' => false, 'playlist' => 'page does not exist')));

                /* check if the page falls at the end of the list */
            } else if ($albumSize < (($page * $amount) + $amount)) {
                /* we set the amount to the last items of the array */
                $amount = ($albumSize - ($page * $amount));
            }
        }

        $controller = new AlbumController();

        $results = $controller->getSelection($album, $position, $amount);
        $results['pages'] = $numberOfPages;
        $results['itemsPerPage'] = $givenAmount;
        return new Response( json_encode( array('success' => true, 'album' => $results) ) );
    }

    /**
     * @Route("app/user/getAlbums", name="getAlbums")
     *
     * returns Album array
     */
    public function getAlbums()
    {
        $results = $this->getUser()->getAlbumData();
        return new Response( json_encode( array('success' => true, 'albums' => $results) ) );
    }
}
