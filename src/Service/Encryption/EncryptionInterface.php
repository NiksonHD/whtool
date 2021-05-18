<?php

namespace App\Service\Encryption;



interface EncryptionInterface {

    public function hash(string $password);
    
    
    public function verify(string $password, string $hash);
    

}
