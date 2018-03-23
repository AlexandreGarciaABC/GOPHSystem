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

if($action == 'send')
{
	$email = $_POST['user-email'];

	if (empty ($email))
	{
		$msg = "<p class='authalert'>É dificil recuperar sem o email, não acha? Preencha o campo!</p>";
		exit;
	}
	elseif(!filter_var($email, FILTER_VALIDATE_EMAIL))
	{
		$msg = "<p class='authalert'>Preencha o e-mail com a formatação correta!</p>";
		exit;
	}
	else{
		$msg = createCode($email);
	}
}

function mailExiste($email)
{
	include("database/config.php");
	$query="SELECT username FROM users WHERE email = '$email' LIMIT  1"; 	
	$resultado=mysqli_query($conn,$query);
	$contar=mysqli_num_rows($resultado);
	if($contar != 0){
		$dados = mysqli_fetch_assoc($resultado);
		return $dados['username'];
	}
	else {return NULL;}
}

function createCode($email)
{
		$mailExiste = mailExiste($email);
		if($mailExiste == NULL)
		{
			$msg = "<p class='authalert'>Este e-mail não pertence a nenhuma conta. Tente outro!</p>";
		}
		else
		{
			$key = md5(rand(999,99999));
			include("database/config.php");
			$query = "UPDATE users SET recover = '$key' WHERE email = '$email';";
			$resultado=mysqli_query($conn,$query);
			if($resultado)
			{
                $msg = "<p class='authalert' style='background-color: green; border-color: green;'>Entrou e vai enviar o email!</p>";				
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
	<title>GOPH System - Recuperar Password</title>
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
	    $('frmPassRec').each(function() {
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
		<?php echo isset($msg) ? $msg: null; ?>
		<div class="vertical-align-wrap">
			<div class="vertical-align-middle">
				<div class="auth-box" style="width: 30%;">
					<div class="left" style="width: 100%;">
						<div class="content">
							<div class="header">
								<div class="logo text-center">GOPH System</div>
								<p class="lead">Coloque o email da sua conta para recuperar a password</p>
							</div>
							<form class="form-auth-small" action="?action=send" method="post" id="frmPassRec">
								<div class="form-group">
									<label for="user-email" class="control-label sr-only">Email</label>
									<input type="text" class="form-control" id="user-email" name="user-email" placeholder="E-mail da conta" autofocus>
								</div>
								<button type="submit" class="btn btn-primary btn-lg btn-block">Seguinte</button>
								<div class="bottom">
									<span class="helper-text"><a href="login.php">Voltar ao Login</a></span>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- END WRAPPER -->
</body>

</html>