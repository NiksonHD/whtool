<?php

namespace App\Controller;

use App\Entity\Lists;
use App\Entity\Tile;
use App\Form\ListsType;
use App\Service\Accsess\AccessServiceInterface;
use App\Service\Email\EmailServiceInterface;
use App\Service\Lists\ListsService;
use App\Service\Tile\TileServiceInterface;
use Swift_Mailer;
use Swift_Message;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use function dump;

class ListController extends AbstractController {

    /**
     * @var AccessServiceInterface
     */
    private $accessService;

    /**
     * 
     * @var ListsService
     */
    private $listsService;

    /**
     * 
     * @var TileServiceInterface
     */
    private $tileService;

    /**
     * 
     * @var EmailServiceInterface
     */
    private $emailService;

    public function __construct(
            AccessServiceInterface $accessService,
            ListsService $listsService,
            TileServiceInterface $tileService,
            EmailServiceInterface $emailService) {
        $this->accessService = $accessService;
        $this->listsService = $listsService;
        $this->tileService = $tileService;
        $this->emailService = $emailService;
    }

    /**
     * @Route("/make_list", name="make_list",methods="GET")
     */
    public function create(Request $request): Response {
        $list = new Lists();
        $access = $this->accessService->checkAccess($request->server->get('REMOTE_ADDR'));
        return $this->render('list/create.html.twig', [
                    'access' => $access,
                    'errors' => true,
                    'form' => $this->createForm(ListsType::class)->createView(),
                    'list' => $list,
        ]);
    }

    /**
     * @Route("/make_list", methods="POST")
     */
    public function createProcess(Request $request, ValidatorInterface $validator): Response {
        $access = $this->accessService->checkAccess($request->server->get('REMOTE_ADDR'));
        $list = new Lists();
        ;
        $form = $this->createForm(ListsType::class, $list);
        $form->handleRequest($request);
        $errors = $validator->validate($list);

        if (isset($errors[0])) {

            return $this->render('list/create.html.twig', [
                        'access' => $access,
                        'errors' => $errors,
                        'form' => $form->createView(),
                        'list' => $list]);
        }
        $deviceZone = 'WH';
        if (!$access) {
            $deviceZone = 'ZL';
        }
        $list->setDeviceZone($deviceZone);
        $this->listsService->create($list);
        if (!$list->getSapList()) {
            return $this->render('list/create.html.twig', [
                        'access' => $access,
                        'errors' => true,
                        'form' => $form->createView(),
                        'list' => $list,
            ]);
        }
        $lastList = $this->listsService->getLastInsert();
        $id = $lastList->getId();
        return $this->redirectToRoute('view-one', ['id' => $id]);
    }

    /**
     *
     * @Route("/lists/view-one", name="view-one", methods={"GET"})
     * 
     * @return Response 
     */
    public function viewOne(Request $request, Swift_Mailer $mailer) {

        $access = $this->accessService->checkAccess($request->server->get('REMOTE_ADDR'));
        $id = $request->query->get('id');

        $list = $this->listsService->getOneById($id);
        $tileString = $list->getSapList();
        $tilesArray = explode(' ', $tileString);
        if (count($tilesArray) % 2 == 1) {
            array_push($tilesArray, '0');
        }
        for ($index = 0; $index <= count($tilesArray) - 1; $index += 2) {
            $sapNum = $tilesArray[$index];
            $order = $tilesArray[$index + 1];
            $tileTemp = new Tile();
            $tileTemp->setArticleNum($sapNum);
            $tile = $this->tileService->getTileInfoForList($tileTemp)[0];
            $tile->setOrder($order);

            $tiles [] = $tile;
        }
        if ($list->getSendEmail() === false) {
            $emails = $this->emailService->findAll();
            
            $emailsToCC = [];
            foreach ($emails as $email) {
                if ($email->getRole() === 'sender') {
                    $sender = $email->getAddress();
                }
            
                elseif ($email->getRole() === 'recipient') {
                    $recipient = $email->getAddress();
                }else{
                $emailsToCC [] = $email->getAddress();
            }
            }
            $list->setSendEmail(true);

            $message = (new Swift_Message())
                    ->setFrom($sender, 'Плочки')
                    ->setSubject($list->getComment() . ',' . $list->getDeviceZone() . ';' . $list->getNameList()->format('"d/m/Y - H:i:s"'))
                    ->setTo($recipient)
//                    ->setCc($emailsToCC)
                    ->setBody(
                    $this->renderView('list/view-one-toemail.html.twig',
                            [
                                'form' => $this->createForm(ListsType::class)->createView(),
                                'access' => $access,
                                'list' => $list,
                                'tiles' => $tiles
                            ]
                    ),
                    'text/html'
            );
            $mailer->send($message);
            $this->listsService->edit($list);
        }
        return $this->render('list/view-one.html.twig',
                        [
                            'form' => $this->createForm(ListsType::class)->createView(),
                            'access' => $access,
                            'list' => $list,
                            'tiles' => $tiles
        ]);
    }

    /**
     *
     * @Route("/lists/find-lists-date", name="find-lists-date", methods={"GET"})
     * 
     * @return Response 
     */
    public function findListsDate(Request $request) {

        $access = $this->accessService->checkAccess($request->server->get('REMOTE_ADDR'));
        $date = date('Y-m-d');
        $lists = $this->listsService->getAllByDate($date);

        return $this->render('list/view-all.html.twig',
                        [
                            'form' => $this->createForm(ListsType::class)->createView(),
                            'access' => $access,
                            'lists' => $lists
        ]);
    }

    /**
     *
     * @Route("/lists/find-lists-date", methods={"POST"})
     * 
     * @return Response 
     */
    public function findListsDateCustom(Request $request) {

        $access = $this->accessService->checkAccess($request->server->get('REMOTE_ADDR'));
        $date = $request->request->get('date_search');


        $lists = $this->listsService->getAllByDate($date);

        return $this->render('list/view-all.html.twig',
                        [
                            'form' => $this->createForm(ListsType::class)->createView(),
                            'access' => $access,
                            'lists' => $lists
        ]);
    }

}
