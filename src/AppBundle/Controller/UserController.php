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
     * @Route("app/user/getUploads/{position}/{amount}", name="getUploads")
     *
     * returns data from the Uploads list
     */
    public function getUploads($position = 0, $amount = 25){

        $user = $this->getUser();
        $playlist = $user->getUploads();

        $controller = new PlaylistController();

        $results = $controller->getSelection($playlist, $position, $amount);

        return new Response( json_encode( array('success' => true, 'playlist' =>$results) ) );
    }

    /**
     * @Route("app/user/getPlaylistResults/{listId}/{position}/{amount}", name="getPlaylistResults")
     *
     * returns data from a Playlist
     */
    public function getPlaylistResults($listId, $position = 0, $amount = 25){

        if(! isset($listId)){
            return new Response(json_encode(array('success' => false, 'reason' => 'no listId found')));
        }

        $playlist = $this->getUser()->getPlayListById($listId);

        if(! isset($playlist)){
            return new Response( json_encode(array('success' => false, 'reason' => 'list not found')));
        }

        $controller = new PlaylistController();

        $results = $controller->getSelection($playlist, $position, $amount);

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
     * @Route("app/user/getAlbumResults/{albumId}/{position}/{amount}", name="getAlbumResults")
     *
     * returns data from an Album
     */
    public function getAlbumResults($albumId, $position = 0, $amount = 25){

        if(! isset($albumId)){
            return new Response(json_encode(array('success' => false, 'reason' => 'no albumId found')));
        }

        $album = $this->getUser()->getAlbumById($albumId);

        if(! isset($album)){
            return new Response( json_encode(array('success' => false, 'reason' => 'album not found')));
        }

        $controller = new AlbumController();

        $results = $controller->getSelection($album, $position, $amount);

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
