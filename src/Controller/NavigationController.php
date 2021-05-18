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
//        switch ($navCode) {
//            case '1':
//                $output = "Location:find_location.php";
//                break;
//            case '2':
//                $output = "Location:edit_location.php";
//                break;
//            case '3':
//                $output = "Location:lists.php";
//                break;
//            case '4':
//                $output = $this->redirect('daily');
//                break;
//        }
//        return $output;
    }

}
