<?php

namespace App\Service\Email;

use App\Repository\EmailRepository;

class EmailService implements EmailServiceInterface {

    /**
     * 
     * @var EmailRepository
     */
    private $emailRepository;
    public function __construct(EmailRepository $emailRepository) {
        $this->emailRepository = $emailRepository;
    }

    public function findAll() {

        return $this->emailRepository->findAll();
    }

}
