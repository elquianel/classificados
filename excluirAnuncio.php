<?php
    require 'config.php';

    if(empty($_SESSION['cLogin'])){
        header("Location: login.php");
    }

    require 'classes/anuncios.class.php';

    $a = new Anuncios();

    if(isset($_GET['id']) && !empty($_GET['id'])){
        $id = addslashes($_GET['id']);

        $a->deletarAnuncio($_GET['id']);
        header("Location: anuncios.php");
        
    }
