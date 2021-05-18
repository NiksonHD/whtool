<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controller;

use App\Form\TileType;
use App\Service\Accsess\AccessServiceInterface;
use App\Service\Daily\DailyServiceInterface;
use App\Service\Tile\TileServiceInterface;
use App\Service\User\UserServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Flex\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


/**
 * Description of DailyController
 *
 * @author nikson
 */
class DailyController extends AbstractController {
    /**
     * 
     * @var AccessServiceInterface
     */
        private $accessService;
    /**
     * 
     * @var TileServiceInterface
     */
    private $tileService;

    /**
     * 
     * @var DailyServiceInterface
     */
    private $dailyService;
    /**
     * 
     * @var UserServiceInterface
     * 
     */
    private $userService;
    public function __construct(
            AccessServiceInterface $accessService, 
            TileServiceInterface $tileService, 
            DailyServiceInterface $dailyService, 
            UserServiceInterface $userService) {
        $this->accessService = $accessService;
        $this->tileService = $tileService;
        $this->dailyService = $dailyService;
        $this->userService = $userService;
    }

            /**
     * @Route("/daily", name="daily")
     * 
     */
    public function showAll(Request $request) {

        $date = date('Y-m-d');
        $dailys = $this->dailyService->getAll($date);
        $access = $this->accessService->checkAccess($request->server->get('REMOTE_ADDR'));
        return $this->render('daily/daily.html.twig',
        [
          'dailys' => $dailys,  
           'form' => $this->createForm(TileType::class)->createView(),
           'access' => $access
         ]
        );
    }
    /**
     * @Security ("is_granted('IS_AUTHENTICATED_FULLY')")
     * 
     * @Route("/my-searches", name="my_searches", methods={"GET"})
     * 
     * @return Response 
     */
    public function mySearches(Request $request) {
        /** @var Daily $dailys */
        $access = $this->accessService->checkAccess($request->server->get('REMOTE_ADDR'));
        $currentUser = $this->userService->getCurrentUser();
        $dailys = $this->dailyService->getByUserId($currentUser);

        return $this->render('daily/daily.html.twig', [
                    'form' => $this->createForm(TileType::class)->createView(),
                    'dailys' => $dailys,
                    'access' => $access
        ]);
    }
    /**
     * 
     * @Route("/device-searches", name="device_searches", methods={"GET"})
     * 
     * @return Response 
     */
    public function deviceSearches(Request $request) {
        /** @var Daily $dailys */
        $access = $this->accessService->checkAccess($request->server->get('REMOTE_ADDR'));
        $dailys = $this->dailyService->getByIp($request->server->get('REMOTE_ADDR'));

        return $this->render('daily/daily.html.twig', [
                    'form' => $this->createForm(TileType::class)->createView(),
                    'dailys' => $dailys,
                    'access' => $access
        ]);
    }
}
