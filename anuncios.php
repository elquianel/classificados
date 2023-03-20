<?php require 'pages/header.php'; ?>
<?php 
    if(empty($_SESSION['cLogin'])){
    ?>
        <script type="text/javascript">window.location.href="login.php";</script>
    <?php
    exit;
    }

    require 'classes/anuncios.class.php';
    $id_usuario = $_SESSION['cLogin'];
    $a = new Anuncios();
    $anuncios = $a->getMeusAnuncios();
?>

<div class="container">
    <h1>Meus Anúncios</h1>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Foto</th>
                <th>Título</th>
                <th>Valor</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if($anuncios): ?>
                <?php foreach($anuncios as $anuncio): ?>
                    <tr>
                        <td><img src="assets/img/anuncios/<?= $anuncio['url']; ?>" border="0"></td>
                        <td><?= $anuncio['titulo']; ?></td>
                        <td><?= $anuncio['valor']; ?></td>
                        <td></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>


<?php require 'pages/footer.php'; ?>