<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Service\User\UserServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     *
     * @var UserServiceInterface
     * 
     */
    private $userService;
    
    function __construct(UserServiceInterface $userService) {
        $this->userService = $userService;
    }

    
    
    
    /**
     * @Route("/register", name="register", methods="GET")
     */
    public function register(): Response
    {
        
        return $this->render('user/register.html.twig', [
            'form' => $this->createForm(UserType::class )->createView()
        ]);
    }
    /**
     * @Route("/register", methods="POST")
     */
    public function registerProcess(Request $request){
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        $user->setRoles(['ROLE_USER']);
        $this->userService->save($user);
        
        return $this->redirect('login');
        
    }
}
