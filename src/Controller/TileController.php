<?php

namespace App\Controller;

use App\Entity\DailyInputs;
use App\Entity\Map;
use App\Entity\Tile;
use App\Form\MapType;
use App\Form\TileType;
use App\Service\Accsess\AccessServiceInterface;
use App\Service\Daily\DailyServiceInterface;
use App\Service\Map\MapServiceInterface;
use App\Service\Tile\TileServiceInterface;
use App\Service\User\UserServiceInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TileController extends AbstractController {

    /**
     *
     * @var TileServiceInterface
     */
    private $tileService;

    /**
     *
     * @var MapServiceInterface
     */
    private $mapService;

    /**
     *
     * @var AccessServiceInterface
     */
    private $accessService;

    /**
     * 
     * @var DailyServiceInterface
     */
    private $dailyService;

    /**
     * 
     * @var UserServiceInterface
     */
    private $userService;

    public function __construct(TileServiceInterface $tileService,
            MapServiceInterface $mapService,
            AccessServiceInterface $accessService,
            DailyServiceInterface $dailyService,
            UserServiceInterface $userService) {
        $this->tileService = $tileService;
        $this->mapService = $mapService;
        $this->accessService = $accessService;
        $this->dailyService = $dailyService;
        $this->userService = $userService;
    }

    /**
     * @Route("/tile", name="tile", methods="GET")
     */
    public function find(Request $request): Response {
        $sapNum = '';
        $sapNum = $request->query->get('sapNum');
        $access = $this->accessService->checkAccess($request->server->get('REMOTE_ADDR'));
        if ($sapNum != '') {
            $tileTemp = new Tile();
            $tileTemp->setArticleNum($sapNum);
            $tiles = $this->tileService->findTileInfo($tileTemp);
            $access = $this->accessService->checkAccess($request->server->get('REMOTE_ADDR'));
            return $this->render('tile/find.html.twig', [
                        'errors' => null,
                        'form' => $this->createForm(TileType::class)->createView(),
                        'error' => null,
                        'tiles' => $tiles,
                        'access' => $access
            ]);
        }
        $id = $request->query->get('id');
        if ($id != '') {
//            $tileTemp = new Tile();
//            $tileTemp->setArticleNum($sapNum);
            $tiles = $this->tileService->getTileInfoById($id);
            return $this->render('tile/find.html.twig', [
                        'errors' => null,
                        'form' => $this->createForm(TileType::class)->createView(),
                        'error' => null,
                        'tiles' => $tiles,
                        'access' => $access
            ]);
        }
        return $this->render('tile/find.html.twig', [
                    'errors' => null,
                    'form' => $this->createForm(TileType::class)->createView(),
                    'error' => null,
                    'tiles' => null,
                    'access' => $access
        ]);
    }

    /**
     * @Route("/tile", methods="POST")
     */
    public function findProcces(Request $request): Response {
        $access = $this->accessService->checkAccess($request->server->get('REMOTE_ADDR'));
        try {
            $tile = new Tile();
            $form = $this->createForm(TileType::class, $tile);
            $form->handleRequest($request);
            if(strlen($tile->getArticleNum()) == 1){
            return $this->navigate($tile);
            }
            $tiles = $this->tileService->findTileInfo($tile);

            $article = $tiles[0];
            $daily = new DailyInputs();
            $daily->setArticle($article);
            $daily->setUser($this->userService->getCurrentUser());
            $daily->setIpAdress($request->server->get('REMOTE_ADDR'));
            $deviceZone = 'WH';
            if (!$access) {
                $deviceZone = 'ZL';
            }
            $daily->setDeviceZone($deviceZone);

            $this->dailyService->create($daily);

            return $this->render('tile/find.html.twig', [
                        'errors' => null,
                        'form' => $this->createForm(TileType::class)->createView(),
                        'error' => null,
                        'tiles' => $tiles,
                        'access' => $access
            ]);
        } catch (Exception $ex) {
            $error = $ex->getMessage();
            return $this->render('tile/find.html.twig', [
                        'errors' => null,
                        'form' => $this->createForm(TileType::class)->createView(),
                        'error' => $error,
                        'tiles' => null,
                        'access' => $access,
            ]);
        }
    }

    /**
     * 
     * @Route("/tile-change", name="changeCellFromFind", methods="GET")
     * 
     */
    public function changeCellFromFind(Request $request) {
        $cell = $request->query->get('cell');
        $map = $this->mapService->findOneByCell($cell);
        $tileTemp = new Tile();
        $tileTemp->setArticleNum($cell);
        $tiles = $this->tileService->findTileInfo($tileTemp);
        $access = $this->accessService->checkAccess($request->server->get('REMOTE_ADDR'));
        return $this->render('tile/changeArticle.html.twig',
                        [
                            'map' => $map,
                            'tile' => $tiles,
                            'error' => null,
                            'form' => $this->createForm(MapType::class)->createView(),
                            'access' => $access,
        ]);
    }

    /**
     * 
     * @Route("/tile-change", methods="POST")
     * 
     */
    public function changeCellFromFindFinal(Request $request) {
                $access = $this->accessService->checkAccess($request->server->get('REMOTE_ADDR'));
        $map = new Map();
        $form = $this->createForm(MapType::class, $map);
        $form->handleRequest($request);
        $tile = new Tile();
        $tile->setArticleNum($map->getSapNum());
        try{
        $tileObj = $this->tileService->getTileInfoForChange($tile);
        $map->setSapNum($tileObj[0]->getArticleNum());

        $this->mapService->updateTileAdress($map);

        return $this->redirectToRoute('tile',
                        ["sapNum" => $map->getSapNum()]);
        } catch (Exception $ex){
            return $this->render('tile/changeArticle.html.twig',
                        [
                            'map' => $map,
                            'tile' => $tile,
                            'error' => $ex->getMessage(),
                            'form' => $this->createForm(MapType::class)->createView(),
                            'access' => $access,
        ]);
        }
    }

    /**
     * 
     * @Route("/change-Article", name="changeArticleFromFind", methods="GET")
     */
    public function changeArticleFromFind(Request $request) {
        $sapNum = '';
        $sapNum = $request->query->get('article');
        if ($sapNum != '') {
            $tileTemp = new Tile();
            $tileTemp->setArticleNum($sapNum);
            $tiles = $this->tileService->findTileInfo($tileTemp);
            $access = $this->accessService->checkAccess($request->server->get('REMOTE_ADDR'));

            return $this->render('tile/changeCellFromFind.html.twig',
                            [
                                'tiles' => $tiles,
                                'error' => null,
                                'form' => $this->createForm(MapType::class)->createView(),
                                'access' => $access
            ]);
        }
    }

    /**
     * 
     * @Route("/change-Article", methods="POST")
     */
    public function changeArticleFromFindFinal(Request $request) {
        $access = $this->accessService->checkAccess($request->server->get('REMOTE_ADDR'));
        $map = new Map();
        $form = $this->createForm(MapType::class, $map);
        $form->handleRequest($request);
        try{
        $mapTemp = $this->mapService->findOneByCell($map->getTileCell());
        $cellId = $mapTemp->getId();
        $map->setTileCell($mapTemp->getTileCell());
        $map->setId($cellId);
        $this->mapService->updateTileAdress($map);

        return $this->redirectToRoute('tile',
                        ["sapNum" => $map->getSapNum()]);
        } catch (Exception $ex){
            return $this->render('tile/changeCellFromFind.html.twig',
                            [
                                'tiles' => null,
                                'error' => $ex->getMessage(),
                                'form' => $this->createForm(MapType::class)->createView(),
                                'access' => $access
            ]);
        }
    }

    /**
     * @Route("/",name="special-menus", methods={"GET"})
     * 
     * @return Response 
     */
    public function special(Request $request) {
        $access = $this->accessService->checkAccess($request->server->get('REMOTE_ADDR'));
        return $this->render('tile/specialMenus.html.twig',
                        [
                            'access' => $access
        ]);
    }

    /**
     * @Route("/multi-change-cell",name="multi-change-cell", methods={"GET"})
     * 
     * @return Response 
     */
    public function multiChange(Request $request) {
        $access = $this->accessService->checkAccess($request->server->get('REMOTE_ADDR'));
        return $this->render('tile/changeCellMulti.html.twig',
                        [
                            'form' => $this->createForm(MapType::class)->createView(),
                            'access' => $access
        ]);
    }

    /**
     * @Route("/multi-change-cell", methods={"POST"})
     * 
     * @return Response 
     */
    public function multiChangeFinal(Request $request) {
        $access = $this->accessService->checkAccess($request->server->get('REMOTE_ADDR'));
        $map = new Map();
        $form = $this->createForm(MapType::class, $map);
        $form->handleRequest($request);

        $tile = new Tile();
        $cell = $map->getTileCell();
        $map = $this->mapService->findOneByCell($cell);

        return $this->render('tile/changeArticleMulti.html.twig',
                        [
                            'form' => $this->createForm(MapType::class)->createView(),
                            'access' => $access,
                            'error' => null,
                            'map' => $map,
                            'tile' => null
        ]);
    }

    /**
     * @Route("/change-article-multi",name="change-article-multi", methods={"GET"})
     * 
     * @return Response 
     */
    public function multiChangeArticle(Request $request) {


        $access = $this->accessService->checkAccess($request->server->get('REMOTE_ADDR'));
        $cell = $request->query->get('cell');
        $map = $this->mapService->findOneByCell($cell);
        $form = $this->createForm(MapType::class, $map);
        return $this->render('tile/changeArticleMulti.html.twig', [
                    'form' => $this->createForm(MapType::class)->createView(),
                    'map' => $map,
                    'access' => $access,
                    'tile' => null,
                    'error' => null
        ]);
    }

    /**
     * @Route("/change-article-multi", methods={"POST"})
     * 
     * @return Response 
     */
    public function multiChangeArticleProcces(Request $request) {


        $access = $this->accessService->checkAccess($request->server->get('REMOTE_ADDR'));
        $map = new Map();
        $form = $this->createForm(MapType::class, $map);
        $form->handleRequest($request);
        $tileTemp = new Tile();
        $tileTemp->setArticleNum($map->getSapNum());
        $tile = $this->tileService->findTileInfo($tileTemp);
        $oldCell = $this->mapService->findOneByCell($map->getTileCell());
        $oldSapString = $oldCell->getSapNum();
        $map->setSapNum($oldSapString . ' ' . $tile[0]->getArticleNum());
        $this->mapService->updateTileAdress($map);

        return $this->render('tile/changeArticleMulti.html.twig', [
                    'form' => $this->createForm(MapType::class)->createView(),
                    'map' => $map,
                    'access' => $access,
                    'tile' => $tile,
                    'error' => null
        ]);
    }

    /**
     * @Route("/remove-cell",name="remove-cell", methods={"GET"})
     * 
     * @return Response 
     */
    public function delete(Request $request) {
        $access = $this->accessService->checkAccess($request->server->get('REMOTE_ADDR'));
        return $this->render('tile/removeCell.html.twig',
                        [
                            'form' => $this->createForm(MapType::class)->createView(),
                            'access' => $access
        ]);
    }

    /**
     * @Route("/remove-cell", methods={"POST"})
     * 
     * @return Response 
     */
    public function deleteProcces(Request $request) {
        $map = new Map();
        $form = $this->createForm(MapType::class, $map);
        $form->handleRequest($request);
        $access = $this->accessService->checkAccess($request->server->get('REMOTE_ADDR'));

        if ($form->isSubmitted()) {
            if ($map->getTileCell() == null) {
                return $this->render('tile/removeCell.html.twig', [
                            'map' => null,
                            'form' => $this->createForm(MapType::class)->createView(),
                            'access' => $access
                ]);
            }
            return $this->redirectToRoute('remove-article', ['cell' => $map->getTileCell()]);
        }
    }

    /**
     * @Route("/remove-article",name="remove-article", methods={"GET"})
     * 
     * @return Response 
     */
    public function deleteArticle(Request $request) {


        $access = $this->accessService->checkAccess($request->server->get('REMOTE_ADDR'));
        $cell = $request->query->get('cell');
        $map = $this->mapService->findOneByCell($cell);
        $form = $this->createForm(MapType::class, $map);
        return $this->render('tile/removeArticle.html.twig', [
                    'form' => $this->createForm(MapType::class)->createView(),
                    'map' => $map,
                    'access' => $access,
                    'tile' => null,
                    'error' => null
        ]);
    }

    /**
     * @Route("/remove-article",methods={"POST"})
     * 
     * @return Response 
     */
    public function deleteArticleProcess(Request $request) {

        $map = new Map();
        $access = $this->accessService->checkAccess($request->server->get('REMOTE_ADDR'));

        $form = $this->createForm(MapType::class, $map);
        $form->handleRequest($request);
        $sapNum = $map->getSapNum();
        $tileObj = new Tile();
        $tileObj->setArticleNum($map->getSapNum());
        $tileString = $this->mapService->findOneByCell($map->getTileCell())->getSapNum();
        $tile = $this->tileService->findTileInfo($tileObj);
        $stringWithSpace = ' ' . $tile[0]->getArticleNum();
        $stringWithoutSpace = $tile[0]->getArticleNum();
        $stringsToReplace = [$stringWithSpace, $stringWithoutSpace];
        $tileString = str_replace($stringsToReplace, '', $tileString);
//        $tileString = $tileString. ' ' . $tile[0]->getSapNum();
        $map->setSapNum($tileString);
        $this->mapService->updateTileAdress($map);
        return $this->render('tile/removeArticle.html.twig', [
                    'form' => $this->createForm(MapType::class)->createView(),
                    'map' => $map,
                    'access' => $access,
                    'tile' => $tile,
                    'error' => null
        ]);
    }

    function navigate(Tile $tile) {
        $navCode = $tile->getArticleNum();
        if ($navCode == '3') {
            return $this->redirect('daily');
        }
                if ($navCode == '1') {
                                return $this->redirect('tile');
                }
        if ($navCode == '2') {
                        return $this->redirect('lists/find-lists-date');
        }

    }
    
    /**
     *
     * @Route("last-changes", name="last-changes", methods={"GET"})
     * 
     * @return Response 
     */
    function showLastCnanges(Request $request){
          $access = $this->accessService->checkAccess($request->server->get('REMOTE_ADDR'));
        $date = date('Y-m-d');
        $map = $this->mapService->findByDate($date);
        return $this->render('tile/viewChanges.html.twig',
                        [
                            'form' => $this->createForm(MapType::class)->createView(),
                            'access' => $access,
                            'maps' => $map
                ]);
        
    }
    /**
     *
     * @Route("last-changes", methods={"POST"})
     * 
     * @return Response 
     */
    public function showLastChangesCustom(Request $request) {

        $access = $this->accessService->checkAccess($request->server->get('REMOTE_ADDR'));
        $date = $request->request->get('date_search');

        $map = $this->mapService->findByDate($date);
//        dump($map);exit;
        return $this->render('tile/viewChanges.html.twig',
                        [
                            'form' => $this->createForm(MapType::class)->createView(),
                            'access' => $access,
                            'maps' => $map
        ]);
    }

}
