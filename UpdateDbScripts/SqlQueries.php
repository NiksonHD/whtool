<?php


class SqlQueries {

private $db;
public function __construct($db) {
    $this->db = $db;
}

public function selectSapNum($sapNum){
    $result = $this->db->prepare('SELECT * FROM map WHERE sap_num = :sapNum');
        $result->bindParam('sapNum', $sapNum);
        $result->execute();
        return $result->fetch(PDO::FETCH_ASSOC);
    
    
}
public function updateQuantityAndEan($sapNum,$ean, $quantity) {
        $result = $this->db->prepare(
                'UPDATE articles_info
            SET ean = :ean, quantity = :quantity
            WHERE article_num = :sap_num');
        $result->bindParam('quantity', $quantity);
        $result->bindParam('ean', $ean);
        $result->bindParam('sap_num', $sapNum);
        $result->execute();
    }
    
    public function getArticleInfoBySap($sapNum) {
        $result = $this->db->prepare('SELECT * FROM articles_info  WHERE article_num = :sap_num');
        $result->bindParam('sap_num', $sapNum);
        $result->execute();
        return $result->fetch(PDO::FETCH_ASSOC);
    }
    
    public function createArticleInfo($sapNum, $name, $ean, $quantity) {
        $result = $this->db->prepare(
                'INSERT INTO articles_info ( article_num, article_name, ean,quantity)
            VALUES (:sap_num,:article_name, :ean, :quantity)');
        $result->bindParam('sap_num', $sapNum);
        $result->bindParam('article_name', $name);
        $result->bindParam('ean', $ean);
        $result->bindParam('quantity', $quantity);
        $result->execute();
    }
    public function createMapCells($cell, $sapNum, $updateDate) {
        $result = $this->db->prepare(
                'INSERT INTO map (tile_cell, sap_num, update_date ) 
            VALUES (:tile_cell,:sap_num, :update_date)');
        $result->bindParam('tile_cell', $cell);
        $result->bindParam('sap_num', $sapNum);
        $result->bindParam('update_date', $updateDate);
        $result->execute();
    }

    
    
    public function updateMapCells($tileCell, $sapNum, $updateDate) {
        $result = $this->db->prepare(
                'UPDATE tile_map
            SET sap_num = :sap_num, update_date = :update_date
            WHERE TILE_CELL = :tile_cell');
        $result->bindParam('tile_cell', $tileCell);
        $result->bindParam('sap_num', $sapNum);
        $result->bindParam('update_date', $updateDate);
        $result->execute();
    }
}
