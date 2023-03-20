<?php require 'pages/header.php'; ?>
<?php 
    if(empty($_SESSION['cLogin'])){
    ?>
        <script type="text/javascript">window.location.href="login.php";</script>
    <?php
    exit;
    }

    require 'classes/anuncios.class.php';
    require 'classes/categorias.class.php';

    //ANUNCIOS
    $a = new Anuncios();
    if(isset($_POST['titulo']) && !empty($_POST['titulo'])){
        $id_categoria = $_POST['id_categoria'];
        $titulo = addslashes($_POST['titulo']);
        $valor = $_POST['valor'];
        $descricao = addslashes($_POST['descricao']);
        $status_produto = $_POST['status_produto'];

        if(!empty($titulo) && !empty($id_categoria) && !empty($valor) && !empty($status_produto)){
            if($a->novoAnuncio($id_categoria, $titulo, $descricao, $valor, $status_produto)){
                ?>
                <div class="alert alert-success">
                    <strong>Parabéns</strong> novo anúncio cadastrado ocm sucesso.
                </div>   
                <script type="text/javascript">window.location.href="anuncios.php";</script>
                <?php
            }
        }
    }

    //CATEGORIAS
    $c = new Categorias();
    $categorias = $c->getAll();
?>
<div class="container">
    <h1>Novo Anúncio</h1>

    <form method="POST" enctype="multipart/form-data">
    <div class="form-group">
        <label for="">Categoria</label>
        <select name="id_categoria" class="form-control">
            <?php foreach($categorias as $categoria): ?>
                <option value="<?= $categoria['id']; ?>"><?= $categoria['nome']; ?></option>
            <?php endforeach; ?>
        </select>
    </div>
	<div class="form-group">
        <label>Titulo: </label>
	    <input class="form-control" type="text" name="titulo">
    </div>
	
	<div class="form-group">
        <label>Valor: </label>
	    <input class="form-control" type="text" name="valor">
    </div>

    <div class="form-group">
        <label>Descrição: </label>
	    <textarea name="descricao" id="" cols="30" rows="10" class="form-control"></textarea>
    </div>

    <div class="form-group">
        <label>Estado de conservação: </label>
	    <select name="status_produto" id="" class="form-control">
            <option value="0">Ruim</option>
            <option value="1">Bom</option>
            <option value="2">Ótimo</option>
        </select>
    </div>
	
	<input class="btn btn-default" type="submit" value="Adicionar">
</form>
</div>
<?php require 'pages/footer.php'; ?>