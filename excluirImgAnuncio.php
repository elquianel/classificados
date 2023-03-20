<?php
    require 'config.php';

    if(empty($_SESSION['cLogin'])){
        header("Location: login.php");
    }

    require 'classes/anuncios.class.php';

    $a = new Anuncios();

    if(isset($_GET['idImg']) && !empty($_GET['idImg'])){

        $id_anuncio = $a->deletarImgAnuncio($_GET['idImg']);

        if($id_anuncio){
            header("Location: editarAnuncio.php?id=".$id_anuncio);
        }else{
            header("Location: anuncios.php");
        }
        
    }
