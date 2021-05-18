<?php


namespace App\Service\Daily;


interface DailyServiceInterface {
    
public function create($daily);    
public function getAll($date);

public function getByUserId($user);

public function getByIp(string $ip);
    
    
    
}
