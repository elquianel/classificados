<?php require 'pages/header.php'; ?>
<div class="container">
    <h1>Cadastre-se</h1>
    <?php
        require 'classes/usuarios.class.php';
        $u = new Usuario();
        if(isset($_POST['nome']) && !empty($_POST['nome'])){
            $nome = addslashes($_POST['nome']);
            $email = addslashes($_POST['email']);
            $telefone = addslashes($_POST['telefone']);
            $senha = $_POST['senha'];

            if(!empty($nome) && !empty($email) && !empty($telefone) && !empty($senha)){
                if($u->cadastrar($nome, $email, $telefone, $senha) == true){
                    ?>
                    <div class="alert alert-success">
                        <strong>Parabéns</strong> Cadastrado ocm sucesso. <a href="login.php" class="alert-link">Faça o login agora</a>
                    </div>   
                    <?php
                }else{
                    ?>
                    <div class="alert alert-danger">
                        Este usuário já existe! <a href="login.php" class="alert-link">Faça o login agora</a>
                    </div>   
                    <?php
                }
            }else{
                ?>
                <div class="alert alert-warning">
                    Preencha todos os campos
                </div>
                <?php
            }
        }else{

        }
    ?>
    <form method="POST">
	<div class="form-group">
        <label>Nome: </label>
	    <input class="form-control" type="text" name="nome">
    </div>
	
    <div class="form-group">
        <label>Email: </label>
	    <input class="form-control" type="text" name="email">
    </div>
	
	<div class="form-group">
        <label>Telefone: </label>
	    <input class="form-control" type="text" name="telefone">
    </div>
	
	<div class="form-group">
        <label>Senha: </label>
	    <input class="form-control" type="password" name="senha">
    </div>
	
	<input class="btn btn-default" type="submit" value="Cadastrar">
</form>
</div>
<?php require 'pages/footer.php'; ?>