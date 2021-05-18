<?php


namespace App\Service\Encryption;

class EncryptionService implements EncryptionInterface{
    
    
    public function hash(string $password) {
        $hash = password_hash($password, PASSWORD_ARGON2I);
        return $hash;

        
    }

    public function verify(string $password, string $hash) {
        return password_verify($password, $hash);
    }

}
