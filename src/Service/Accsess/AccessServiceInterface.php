<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Service\Accsess;

/**
 *
 * @author nikson
 */
interface AccessServiceInterface {
    
    /**
     * 
     * @param string $ip
     */
    
    public function checkAccess(string $ip);
}
