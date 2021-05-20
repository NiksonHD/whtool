<?php

namespace App\Service\Email;

use App\Entity\Email;
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
    return $this->emailRepository->findBy([], ['id' => 'DESC']);
    }

    public function addEmail(Email $email) {
        $email->setRole('user');
        return $this->emailRepository->insert($email);
    }

    public function deleteEmail(Email $email) {
        return $this->emailRepository->delete($email);
    }

}
