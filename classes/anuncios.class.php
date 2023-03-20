<?php

class Anuncios{
    public function getMeusAnuncios(){
        global $pdo;
        $anuncios = [];

        $sql = $pdo->prepare("SELECT a.*, ai.id as id_foto, ai.id_anuncio as id_anuncio_foto, ai.url_img FROM anuncio a LEFT JOIN anuncios_imagens ai ON a.id = ai.id_anuncio WHERE id_usuario = :id_usuario");
        $sql->bindValue(":id_usuario", $_SESSION['cLogin']);
        $sql->execute();

        if($sql->rowCount() > 0){
            $anuncios = $sql->fetchAll();
        }

        return $anuncios;
    }

    public function novoAnuncio($id_categoria, $titulo, $descricao, $valor, $status_produto, $url = null){
        global $pdo;

        $sql = $pdo->prepare("INSERT INTO anuncio SET id_usuario = :id_usuario, id_categoria = :id_categoria, titulo = :titulo, descricao = :descricao, valor = :valor, status_produto = :status_produto");
        $sql->bindValue(":id_usuario", $_SESSION['cLogin']);
        $sql->bindValue(":id_categoria", $id_categoria);
        $sql->bindValue(":titulo", $titulo);
        $sql->bindValue(":descricao", $descricao);
        $sql->bindValue(":valor", $valor);
        $sql->bindValue(":status_produto", $status_produto);
        if($sql->execute()){
            if($url != null){
                $sql = $pdo->prepare("INSERT INTO anuncios_imagens SET id_anuncio = :id_anuncio, url_img = :url_img");
                $sql->bindValue(":id_anuncio", $pdo->lastInsertId());
                $sql->bindValue(":url", $url);
                $sql->execute();
            }
            return true;
        }else{
            return false;
        }

    }

    public function deletarAnuncio($id_anuncio){
        global $pdo;

        $sql = $pdo->prepare("DELETE FROM anuncios_imagens WHERE id_anuncio = :id_anuncio");
        $sql->bindValue(":id_anuncio", $id_anuncio);
        $sql->execute();

        $sql = $pdo->prepare("DELETE FROM anuncio WHERE id = :id_anuncio");
        $sql->bindValue(":id_anuncio", $id_anuncio);
        $sql->execute();

    }

    public function deletarFotoAnuncio($id_foto, $id_anuncio){
        global $pdo;
        $sql = $pdo->prepare("DELETE FROM anuncios_imagens WHERE id = :id_foto AND id_anuncio = :id_anuncio");
        $sql->bindValue(":id_foto", $id_foto);
        $sql->bindValue(":id_anuncio", $id_anuncio);
        $sql->execute();
    }

    public function editarAnuncio($id_anuncio, $id_categoria, $titulo, $descricao, $valor, $status_produto){
        global $pdo;

        $sql = $pdo->prepare("UPDATE anuncio SET id_usuario = :id_usuario, id_categoria = :id_categoria, titulo = :titulo, descricao = :descricao, valor = :valor, status_produto = :status_produto WHERE id = :id_anuncio");
        $sql->bindValue(":id_anuncio", $id_anuncio);
        $sql->bindValue(":id_categoria", $id_categoria);
        $sql->bindValue(":titulo", $titulo);
        $sql->bindValue(":descricao", $descricao);
        $sql->bindValue(":valor", $valor);
        $sql->bindValue(":status_produto", $status_produto);
        $sql->execute();

    }

    public function editarFotoAnuncio($id_img, $url_img){
        global $pdo;

        $sql = $pdo->prepare("UPDATE anuncios_imagens SET url_img = :url_img WHERE id = :id_img");
        $sql->bindValue(":id_img", $id_img);
        $sql->bindValue(":url_img", $url_img);
        $sql->execute();

    }
}