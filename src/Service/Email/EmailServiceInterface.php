<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Service\Email;

use App\Entity\Email;

/**
 *
 * @author nikson
 */
interface EmailServiceInterface {
   
    public function findAll();
    
    public function addEmail(Email $email);
    
    public function deleteEmail(Email $email);
    
    
    
    
    
}
