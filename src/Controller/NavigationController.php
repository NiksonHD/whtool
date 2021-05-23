<?php

namespace App\Controller;

use App\Entity\Tile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class NavigationController extends AbstractController {

    static function navigate(Tile $tile) {
        $navCode = $tile->getArticleNum();
        
        if($navCode == '4'){
            
            return $this->redirectToRoute('daily');
            
        }
    }

}
