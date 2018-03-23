<?php
session_start();
if(isset($_SESSION['username']))
{
	header("Location:index.php");
}

if(isset($_POST['login']))
{
	$user = filter_var($_POST['signin-user'], FILTER_SANITIZE_STRING);
	$passwd = filter_var($_POST['signin-password'], FILTER_SANITIZE_STRING);
	
	if(empty($user) || empty($passwd))
	{
	  //verifica se os campos estão preenchidos
	  $msg = "<p class='authalert'>É dificil fazer login sem dados, não acha? Preencha todos os campos!</p>";
	}
	else
	{
		//pesquisa utilizador 
		include('database/config.php');
		$pass = md5($passwd);
		
		$query= "SELECT * FROM users WHERE username = '$user' AND password='$pass' LIMIT 1";
		
		$resultado = mysqli_query($conn,$query);
	
		if(mysqli_num_rows($resultado) != 0)
		{
			$dados = mysqli_fetch_assoc($resultado);
			$_SESSION['iduser'] = $dados['iduser'];
			$_SESSION['username'] = $dados['username'];
			header("Location: index.php");
		}
		else
		{
			$msg="<p class='authalert'>O seu nome de utilizador e a password não correspondem. Tente novamente!</p>";
		}
	}
}
?>

<!DOCTYPE html>
<html lang="pt-pt" class="fullscreen-bg">

<head>
	<title>GOPH System - Login</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<!-- EXTERNAL CSS -->
	<link rel="stylesheet" href="assets/ext/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/ext/font-awesome/css/font-awesome.min.css">
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Oswald:400,300,700" rel="stylesheet">
	<!-- MAIN CSS -->
	<link rel="stylesheet" href="assets/css/authpage.css">

	<script type="text/javascript">
	// Using jQuery.

	$(function() {
	    $('frmLogin').each(function() {
	        $(this).find('input').keypress(function(e) {
	            // Enter pressed?
	            if(e.which == 10 || e.which == 13) {
	                this.form.submit();
	            }
	        });
	    });
	});
	</script>
</head>

<body>
	<!-- WRAPPER -->
	<div id="wrapper">
		<?php echo isset( $msg) ? $msg: null; ?>
		<div class="vertical-align-wrap">
			<div class="vertical-align-middle">
				<div class="auth-box">
					<div class="left">
						<div class="content">
							<div class="header">
								<div class="logo text-center">GOPH System</div>
								<p class="lead">Faça o login na sua conta</p>
							</div>
							<form class="form-auth-small" action="" method="post" id="frmLogin">
								<div class="form-group">
									<label for="signin-user" class="control-label sr-only">Username</label>
									<input type="text" class="form-control" id="signin-user" name="signin-user" placeholder="Nome de utilizador" autocomplete="off" autofocus>
								</div>
								<div class="form-group">
									<label for="signin-password" class="control-label sr-only">Password</label>
									<input type="password" class="form-control" id="signin-password" name="signin-password" placeholder="Password" autocomplete="off">
								</div>
								<button type="submit" name="login" class="btn btn-primary btn-lg btn-block">LOGIN</button>
								<div class="bottom">
									<span class="helper-text"><i class="fa fa-lock"></i> <a href="fgpass.php">Esqueceu-se da password?</a></span>
								</div>
							</form>
						</div>
					</div>
					<div class="right" style="background-image: url('assets/img/pascoa.png');">
						<div class="overlay"></div>
						<div class="content campaign">Feliz Páscoa!</div>
						<div class="content text">
							<h1 class="heading">Organização GOPH</h1>
							<p>A Organização GOPH é uma das mais antigas do Habbo Hotel, criada em 2007. Temos o objetivo de melhorar a jogabilidade dos membros do ramo policial e dos usuários do Habbo com paz, harmonia e segurança.</p>
							<a href="register.php"><button class="btn btn-default btn-lg btn-block">REGISTRAR-SE</button></a>
						</div>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
	</div>
	<!-- END WRAPPER -->
</body>

</html>