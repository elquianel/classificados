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

    <a href="novoAnuncio.php" class="btn btn-default">Novo anúncio</a><br>

    <?php if($anuncios): ?>
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
                <?php foreach($anuncios as $anuncio): ?>
                    <tr>
                        <td><img src="assets/img/anuncios/<?= ($anuncio['url_img']) ? $anuncio['url_img']:"default.png"; ?>" border="0" width="30"></td>
                        <td><?= $anuncio['titulo']; ?></td>
                        <td><?= $anuncio['valor']; ?></td>
                        <td>
                            <a href="editarAnuncio.php?id=<?= $anuncio['id']; ?>" class="btn btn-default">Editar</a>
                            <a href="excluirAnuncio.php?id=<?= $anuncio['id']; ?>" class="btn btn-danger">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
        <hr>
        <h4>Você não possui anúncios no momento!</h4>
    <?php endif; ?>
</div>


<?php require 'pages/footer.php'; ?>