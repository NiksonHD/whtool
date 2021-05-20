<?php

namespace App\Controller;

use App\Entity\Email;
use App\Form\EmailType;
use App\Service\Accsess\AccessServiceInterface;
use App\Service\Email\EmailServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class EmailController extends AbstractController {

    /**
     * 
     * @var AccessServiceInterface
     */
    private $accessService;

    /**
     * 
     * @var EmailServiceInterface
     */
    private $emailService;

    public function __construct(AccessServiceInterface $accessService, EmailServiceInterface $emailService) {
        $this->accessService = $accessService;
        $this->emailService = $emailService;
    }

    /**
     * @Route("/email-add", name="email-add", methods="GET")
     */
    public function addEmail(Request $request) {
        $access = $this->accessService->checkAccess($request->server->get('REMOTE_ADDR'));
        return $this->render('email/add-mail.html.twig', [
                    'access' => $access,
                    'form' => $this->createForm(EmailType::class)->createView(),
                    'error' => null
        ]);
    }

    /**
     * @Route("/email-add", methods="POST")
     */
    public function addEmailProcces(Request $request, ValidatorInterface $validator): Response {
        $access = $this->accessService->checkAccess($request->server->get('REMOTE_ADDR'));
        $email = new Email();
        $form = $this->createForm(EmailType::class, $email);
        $form->submit($request->request->all());
        $form->handleRequest($request);
        $error = $validator->validate($email);
        if (isset($error[0])) {

            return $this->render('email/add-mail.html.twig', [
                        'access' => $access,
                        'error' => $error,
                        'form' => $form->createView()
            ]);
        }

        $this->emailService->addEmail($email);
        return $this->redirectToRoute('email-delete');
    }

    /**
     * 
     * @Route("/email-delete", name="email-delete", methods="GET")
     */
    public function delete(Request $request) {
        $access = $this->accessService->checkAccess($request->server->get('REMOTE_ADDR'));
        $emails = $this->emailService->findAll();
        return $this->render('email/delete-mail.html.twig',
                        ['access' => $access,
                            'emails' => $emails,
                            'form' => $this->createForm(EmailType::class)->createView()
        ]);
    }

    /**
     * 
     * @Route("/email-delete", methods="POST")
     */
    public function deleteProcces(Request $request) {
        $access = $this->accessService->checkAccess($request->server->get('REMOTE_ADDR'));
        $email = new Email();
        $form = $this->createForm(EmailType::class, $email);
        $form->submit($request->request->all());
        $form->handleRequest($request);
        $this->emailService->deleteEmail($email);
        return $this->redirectToRoute('email-add');
    }

}
