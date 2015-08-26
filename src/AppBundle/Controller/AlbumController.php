<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\Audio;
use AppBundle\Entity\User;
use AppBundle\Entity\Playlist;
use AppBundle\Entity\Album;
use Symfony\Component\HttpFoundation\File\File;

class AlbumController extends Controller
{

    /**
     * get a selection of items from a playlist
     * if amount = NULL we take all items in the list starting at the position
     * @param \AppBundle\Entity\Album $album
     * @param int $position
     * @param int $amount
     * @param string $orderBy
     *
     * @return array
     */
    public function getSelection($album, $position, $amount, $orderBy = 'DESC')
    {
        $listItems = $album->getAudioItems();
        $listCount = $listItems->count();

        if(isset($orderBy)){
            if(strcmp('DESC', $orderBy) == 0 ) {
                /* we calculate the new position since the position will be mirrored  (starting at the back of the array)*/

                /* check if the requested amount at this position is bigger than the array, decrease the amount accordingly */

                if(isset($amount)) {
                    $newPosition = (($listCount - $position - $amount) > 0 ? $listCount - $position - $amount : 0);
                    $newAmount = ($newPosition == 0 ? $listCount - $position : $amount);
                } else {
                    $newPosition = 0;
                    $newAmount = ($listCount - $position);
                }
                $listItems = $listItems->slice($newPosition, $newAmount);

                /* we resort the order so that the last item comes first */
                rsort($listItems);
            } else if (strcmp('ASC', $orderBy) == 0) {
                $newPosition = $position;

                /* check if the requested amount at this position is bigger than the array, decrease the amount accordingly */
                if(isset($amount)) {
                    $newAmount = (($position + $amount) > $listCount ? $listCount - $position  : $amount);
                } else {
                    $newAmount = ($listCount - $newPosition);
                }
                $listItems = $listItems->slice($newPosition, $newAmount);
            }

        } else {
            $listItems = $listItems->slice($position, $amount);
        }

        return array('id' => $album->getId(),'listName' => $album->getName(), 'listCount' => $listCount, 'position' => $position, 'amount' => $amount, 'listItems' => $listItems);
    }

}
