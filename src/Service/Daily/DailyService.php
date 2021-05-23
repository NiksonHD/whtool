<?php


namespace App\Service\Daily;

use App\Repository\DailyRepository;



class DailyService implements DailyServiceInterface {
 
    private $dailyRepository;
    public function __construct(DailyRepository $dailyRepository) {
        $this->dailyRepository = $dailyRepository;
    }

    
    
    public function getAll($date) {

      $dailys =  $this->dailyRepository->findDailyByDate($date);
      $output = [];
      foreach ($dailys as $key => $daily){
          $tile = $daily[0]->getArticle();
          $tile->setArticleNum($daily['articleNum']);
          array_pop($dailys[$key]);
          array_pop($dailys[$key]);
         $dailys[$key] = $daily[0];
          
      }
        
      return  $dailys;
        
    }

    public function create($daily) {
        $article = $daily->getArticle();
        if($article->getId()){
        return $this->dailyRepository->insert($daily);
        }
        return true;
    }

    public function getByUserId($user) {
        return $this->dailyRepository->findBy(['userId' => $user], ['inputDate'=> 'DESC']);
    }

    public function getByIp(string $ip) {
        return $this->dailyRepository->findBy(['ipAdress' => $ip], ['inputDate'=> 'DESC']);
    }

}
