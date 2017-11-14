<?php

if(empty($_SESSION['message'])){$_SESSION['message'] = '';}
if (!isset($email)){$email = '';}
if (!isset($password)){$password = '';}
if (!isset($message)){$message = $_SESSION['message'];}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Strand Assets Login</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="styles/login.css">
        <link href="https://fonts.googleapis.com/css?family=Droid+Sans" rel="stylesheet">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <script src="scripts/jquery.js"></script>
        <script src="scripts/login.js"></script>
        <script src="scripts/rememberMe.js"></script>
    </head>
<main>
    <body>
        <div id="loginForm" style="">
            <div id="logoBanner">
                <img src="images/logo.png">
                <p>Assets Manager</p>
                <p><?php echo $message; $_SESSION['message']; ?></p>
            </div>
            <form action="." method="post" class="center" id="form1">    
                <input type="hidden" name="action" value="login">
                <input type="hidden" name="initialLoad" value="false">
                <div class="padded"><input type="text" placeholder="EMAIL" name="email" id="user"  value="<?php echo $email ?>" required/></div>
                <div class="padded"><input type="text" placeholder="PASSWORD" name="password" id="pass"  value="<?php echo $password ?>" required /></div>
                <div class="padded"><input type="submit" value="LOGIN" name="login" id="loginButton" /></div>
                <p style="vertical-align: middle">Remember Me<input type="checkbox" name="remember" id="remember_me"/></p>
                <div class="wrap_button"><button type="button" id="forgot">I forgot my password</button></div>
            </form>
        </div>
        
        <div id="forgotten" style="">
            <div id="logoBanner">
                <img src="images/logo.png">
                <p>Forgotten Password?</p>
            </div>
            <form action="." method="post" class="center" id="form2">
                <input type="hidden" name="action" value="forgot">
                <!--<div class="padded"><input type="text" placeholder="USERNAME" name="username" required /></div>-->
                <div class="padded"><input type="text" placeholder="EMAIL" name="email" required /></div>
                <div class="padded"><input type="submit" value="REQUEST RESET" name="login" id="loginButton" /></div>
                <div class="wrap_button"><button type="button" id="remember">I remember now</button></div>
            </form>
        </div>
    </body>
</main>
<?php include 'view/footer.php'; ?>