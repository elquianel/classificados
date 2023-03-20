<?php

class Anuncios{
    public function getMeusAnuncios(){
        global $pdo;
        $anuncios = [];

        $sql = $pdo->prepare("SELECT a.*, ai.* FROM anuncio a LEFT JOIN anuncios_imagens ai ON a.id = ai.id_anuncio WHERE id_usuario = :id_usuario");
        $sql->bindValue(":id_usuario", $_SESSION['cLogin']);
        $sql->execute();

        if($sql->rowCount() > 0){
            $anuncios = $sql->fetchAll();
        }

        return $anuncios;
    }
}