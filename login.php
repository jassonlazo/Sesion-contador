<?php
//if query string contains expired var & it = true, set loggedin cookie to false
//else if loggedin cookie exists and is set to true, send to index page
if (isset($_GET['expired']) && $_GET['expired'] == 'true')
    {
        setcookie("loggedin", "false", time()+30);
    }
elseif (isset($_COOKIE['loggedin']) && $_COOKIE['loggedin'] == 'true')
    {
        header("Location: index.php");
        exit;
    }
//log in logic    
if (isset($_POST['username']) && isset($_POST['pw']) && $_POST['username'] == "session" && $_POST['pw'] == "test")
    {
        setcookie("loggedin", "true", time()+30);
        header("Location: index.php");
        exit;
    }
?>
<!DOCTYPE html>
<html>
<head>
<title>PHP Login </title>
<link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>

<div class="container">
<?php
//Mensaje de alerta
if (isset($_GET['expired']) && $_GET['expired'] == 'true')
	{
  print  "<p><span  style=\"color: red; font-weight: bold\">Se le ha cerrado la sesion o su sesion ha finalizado.</span> Entre para reiniciar la sesion.</p>";

    }
?>
<form id="testsession" name="testsession" action="login.php" method="post">
<fieldset>
<legend>Login Usuario</legend>
<p><label for="username">Usuario:</label><br />
<input id="username" type="text" name="username" value="session" /></p>
<p><label for="pw">Password:</label><br />
<input id="pw" type="password" name="pw" value="test" /></p>
<p><input type="submit" value="Entrar"  /></p>
</fieldset>
</form>

<p>Cookies:<br />
<?php
// all cookies
print_r($_COOKIE);
?>

</body>
</html>
