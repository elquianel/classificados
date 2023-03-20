<?php require 'pages/header.php'; ?>
<div class="container">
    <h1>Login</h1>
    <?php
        require 'classes/usuarios.class.php';
        $u = new Usuario();
        if(isset($_POST['email']) && !empty($_POST['email'])){
            $email = addslashes($_POST['email']);
            $senha = $_POST['senha'];

            if($u->login($email, $senha)){
                //se usar header aqui, vai dar erro, pq já existe um header sendo chamado
                //usaremos js para redirecionar o querido que fizer login
                ?>
                    <script type="text/javascript">window.location.href="./";</script>
                <?php
            }
        }else{
            ?>
                <div class="alert alert-danger">
                    Email ou senha errados!!
                </div>   
            <?php
        }
    ?>
    <form method="POST">
    <div class="form-group">
        <label>Email: </label>
	    <input class="form-control" type="text" name="email">
    </div>

	<div class="form-group">
        <label>Senha: </label>
	    <input class="form-control" type="password" name="senha">
    </div>
	
	<input class="btn btn-default" type="submit" value="Entrar">
</form>
</div>
<?php require 'pages/footer.php'; ?>