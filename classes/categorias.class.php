<?php 

class Categorias{
    public function getAll(){
        global $pdo;
        $categorias = [];

        $sql = $pdo->prepare("SELECT * FROM categorias");
        $sql->execute();

        if($sql->rowCount() > 0){
            $categorias = $sql->fetchAll();
        }
        
        return $categorias;
    }
}