<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Service\Accsess;

use App\Repository\AccessRepository;

/**
 * Description of AccsessService
 *
 * @author nikson
 */
class AccsessService implements AccessServiceInterface {
    
    private $accessRepository;
    public function __construct(AccessRepository $accessRepository) {
        $this->accessRepository = $accessRepository;
    }

    
    
    public function checkAccess(string $ip) {
        
        return $this->accessRepository->findBy(['blacklistIp' => $ip]);
        
    }

}
