<?php

namespace App\Controller;

use App\Service\Accsess\AccessServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController {

    /**
     * @var  AccessServiceInterface
     */
    private $accessService;

    public function __construct(AccessServiceInterface $accessService) {
        $this->accessService = $accessService;
    }

    /**
     * @Route("/login", name="login" , methods={"GET", "POST"})
     */

    public function login(AuthenticationUtils $authenticationUtils = null, Request $request) {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        $access = $this->accessService->checkAccess($request->server->get('REMOTE_ADDR'));
        return $this->render('security/login.html.twig',
                        [
                            'error' => $error,
                            'access' => $access
        ]);
    }

    /**
     * @Route("/logout" , name="logout")
     */
    public function logout() {
        throw new Exception('Logout failed!');
    }

}
