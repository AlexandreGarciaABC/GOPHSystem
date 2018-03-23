<?php
session_start();
if(isset($_SESSION['username']))
{
	header("Location:index.php");

}

if(isset($_GET['action']))
{

	$action = $_GET['action'];
}
else{
	$action = "";
}

if($action == 'register')
{
	$user = $_POST['signup-user'];
	$email = $_POST['signup-email'];
	$passwd = $_POST['signup-password'];
	$cpass = $_POST['signup-cpassword'];

	if(empty ($user) || empty($email) || empty($passwd) || empty($cpass))
	{
		$msg = "<p class='authalert'>É dificil fazer o registro sem dados, não acha? Preencha todos os campos!</p>";
	}
	elseif($passwd != $cpass)
	{
		$msg = "<p class='authalert'>As passwords inseridas não correspondem. Tente novamente!</p>";
	}
	elseif(!filter_var($email, FILTER_VALIDATE_EMAIL))
	{
		$msg = "<p class='authalert'>Preencha o e-mail com a formatação correta!</p>";
	}
	else{
		$msg = register($user, $email, $passwd);
	}
}

function mailExiste($email)
{
	include("database/config.php");
	$query="SELECT * FROM users WHERE email = '$email' LIMIT  1"; 	
	$resultado=mysqli_query($conn,$query);
	$contar=mysqli_num_rows($resultado);
	if($contar != 0) {return true;}
	else {return false;}
}

function register($user, $email, $passwd)
{
		$mailExiste = mailExiste($email);
		if($mailExiste)
		{
			$msg = "<p class='authalert'>Este e-mail já existe. Tente outro!</p>";
		}
		else
		{
			$pass = md5($passwd);
			include("database/config.php");
			$query = "INSERT INTO users(username, email, password) VALUES('$user', '$email', '$pass');";
			$resultado=mysqli_query($conn,$query);
			if($resultado)
			{
                $msg = "<p class='authalert' style='background-color: #009900; border-color: #006600;'>Registro efetuado com sucesso!</p>";				
			}
			else
			{
				$msg = "<p class='authalert'>ERROR !!</p>";
			}
		
		}
	return $msg;
}
?>

<!DOCTYPE html>
<html lang="pt-pt" class="fullscreen-bg">

<head>
	<title>GOPH System - Registrar</title>
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
	    $('frmReg').each(function() {
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
				<div class="auth-box" style="padding: 30px 0; height: auto;">
					<div class="header">
						<div class="logo text-center">GOPH System</div>
						<p class="lead">Crie a sua conta e junte-se a nós!</p>
					</div>
					<form class="form-auth-small" action="?action=register" method="post" id="frmReg">
						<div class="left" style="width: 50%; margin-bottom: 15px;">
							<div class="content">
								<div class="form-group">
									<label for="signup-user" class="control-label sr-only">Username</label>
									<input type="text" class="form-control" id="signup-user" name="signup-user" placeholder="Nome de utilizador" autofocus>
									<p class="desc">Deve inserir o seu nickname do Habbo Hotel para que seja identificado mais facilmente.</p>
								</div>
								<div class="form-group">
									<label for="signup-email" class="control-label sr-only">Email</label>
									<input type="email" class="form-control" id="signup-email" name="signup-email" placeholder="Email do utilizador">
									<p class="desc">Deve inserir um email existente para que, caso perca a sua senha, possa recuperá-la.</p>
								</div>
							</div>
						</div>
						<div class="right" style="width: 50%; padding: 0 30px; margin-bottom: 15px;">
							<div class="content">
								<div class="form-group">
									<label for="signup-password" class="control-label sr-only">Password</label>
									<input type="password" class="form-control" id="signup-password" name="signup-password" placeholder="Password">
									<p class="desc">A sua password deve ter, pelo menos, 6 caracteres.</p>
								</div>
								<div class="form-group">
									<label for="signup-cpassword" class="control-label sr-only">Password</label>
									<input type="password" class="form-control" id="signup-cpassword" name="signup-cpassword" placeholder="Confirmar Password">
									<p class="desc">Deve inserir a mesma password que colocou no campo acima.</p>
								</div>
							</div>
						</div>
						<div class="bottom" style="padding: 0 70px;">
							<button type="submit" class="btn btn-primary btn-lg btn-block" style="margin-bottom: 20px;">REGISTRAR CONTA</button>
							<span class="helper-text"><a href="login.php">Voltar ao Login</a></span>
						</div>
					</form>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
	</div>
	<!-- END WRAPPER -->
</body>

</html>