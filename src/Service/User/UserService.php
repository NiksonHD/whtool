<?php

namespace App\Service\User;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\Encryption\EncryptionInterface;
use App\Service\User\UserServiceInterface;
use Symfony\Component\Security\Core\Security;



class UserService implements UserServiceInterface{
    
    /**
     *
     * @var EncryptionInterface
     */
        private $encryption;

    /**
     * 
     * @var UserRepository
     */   
     private $userRepository;
     /**
      * 
      * @var Security
      */
     private $security;
        
     public function __construct(EncryptionInterface $encryption, UserRepository $userRepository, Security $security) {
         $this->encryption = $encryption;
         $this->userRepository = $userRepository;
         $this->security = $security;
     }

     
    
    
    
    
    public function getCurrentUser() {
        return $this->security->getUser();
    }

    public function save(User $user) {
            $password = $user->getPassword();
            $passwordhash = $this->encryption->hash($password);
            $user->setPassword($passwordhash);
            return $this->userRepository->insert($user);
    }

}
