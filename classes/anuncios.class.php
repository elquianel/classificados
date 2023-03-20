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

    public function getAnuncio($id_anuncio){
        global $pdo;
        $anuncio = [];

        $sql = $pdo->prepare("SELECT * FROM anuncio WHERE id = :id_anuncio");
        $sql->bindValue(":id_anuncio", $id_anuncio);
        $sql->execute();

        if($sql->rowCount() > 0){
            $anuncio = $sql->fetch();
            $sql = $pdo->prepare("SELECT * FROM anuncios_imagens WHERE id_anuncio = :id_anuncio");
            $sql->bindValue(":id_anuncio", $id_anuncio);
            $sql->execute();

            if($sql->rowCount() > 0){
                $anuncio['fotos'] = $sql->fetchAll();
            }
        }

        return $anuncio;
    }

    public function novoAnuncio($id_categoria, $titulo, $descricao, $valor, $status_produto){
        global $pdo;

        $sql = $pdo->prepare("INSERT INTO anuncio SET id_usuario = :id_usuario, id_categoria = :id_categoria, titulo = :titulo, descricao = :descricao, valor = :valor, status_produto = :status_produto");
        $sql->bindValue(":id_usuario", $_SESSION['cLogin']);
        $sql->bindValue(":id_categoria", $id_categoria);
        $sql->bindValue(":titulo", $titulo);
        $sql->bindValue(":descricao", $descricao);
        $sql->bindValue(":valor", $valor);
        $sql->bindValue(":status_produto", $status_produto);
        $sql->execute();
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

    public function deletarImgAnuncio($id){
        global $pdo;
        $id_anuncio = 0;

        $sql = $pdo->prepare("SELECT id_anuncio FROM anuncios_imagens WHERE id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();

        if($sql->rowCount() > 0){
            $row = $sql->fetch();
            $id_anuncio = $row['id_anuncio'];
        }

        $sql = $pdo->prepare("DELETE FROM anuncios_imagens WHERE id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();

        return $id_anuncio;

    }

    public function deletarFotoAnuncio($id_foto, $id_anuncio){
        global $pdo;
        $sql = $pdo->prepare("DELETE FROM anuncios_imagens WHERE id = :id_foto AND id_anuncio = :id_anuncio");
        $sql->bindValue(":id_foto", $id_foto);
        $sql->bindValue(":id_anuncio", $id_anuncio);
        $sql->execute();
    }

    public function editarAnuncio($id_anuncio, $id_categoria, $titulo, $descricao, $valor, $status_produto, $fotos = null){
        global $pdo;

        $sql = $pdo->prepare("UPDATE anuncio SET id_categoria = :id_categoria, titulo = :titulo, descricao = :descricao, valor = :valor, status_produto = :status_produto WHERE id = :id_anuncio");
        $sql->bindValue(":id_anuncio", $id_anuncio);
        $sql->bindValue(":id_categoria", $id_categoria);
        $sql->bindValue(":titulo", $titulo);
        $sql->bindValue(":descricao", $descricao);
        $sql->bindValue(":valor", $valor);
        $sql->bindValue(":status_produto", $status_produto);
        $sql->execute();

        if(count($fotos) > 0){
            for($i=0; $i<count($fotos['tmp_name']); $i++){
                $tipo = $fotos['type'][$i];
                if(in_array($tipo, ['image/jpeg', 'image/png'])){
                    $tmpname = md5(time().rand(0,9999)).'.jpg';
                    move_uploaded_file($fotos['tmp_name'][$i], 'assets/img/anuncios/'.$tmpname);

                    list($width_orig, $height_orig) = getimagesize('assets/img/anuncios/'.$tmpname);
                    $ratio = $width_orig/$height_orig;

                    $width = 500;
                    $height = 500;

                    if($width/$height > $ratio){
                        $width = $height * $ratio;
                    }else{
                        $height = $width/$ratio;
                    }

                    $img = imagecreatetruecolor($width, $height);
                    if($tipo == 'image/jpeg'){
                        $origi = imagecreatefromjpeg('assets/img/anuncios/'.$tmpname);
                    }elseif($tipo == 'image/png'){
                        $origi = imagecreatefrompng('assets/img/anuncios/'.$tmpname);
                    }

                    imagecopyresampled($img, $origi, 0,0,0,0, $width, $height, $width_orig, $height_orig);

                    imagejpeg($img, 'assets/img/anuncios/'.$tmpname, 80);

                    $sql = $pdo->prepare("INSERT INTO anuncios_imagens SET id_anuncio = :id_anuncio, url_img = :url_img");
                    $sql->bindValue(":id_anuncio", $id_anuncio);
                    $sql->bindValue(":url_img", $tmpname);
                    $sql->execute();

                }
            }
        }

    }

    public function editarFotoAnuncio($id_img, $url_img){
        global $pdo;

        $sql = $pdo->prepare("UPDATE anuncios_imagens SET url_img = :url_img WHERE id = :id_img");
        $sql->bindValue(":id_img", $id_img);
        $sql->bindValue(":url_img", $url_img);
        $sql->execute();

    }
}