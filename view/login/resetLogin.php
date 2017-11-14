<?php
session_start();
if(empty($_SESSION) && (!isset($_SESSION)))
{
    session_set_cookie_params(0, '/');
    session_start();
}
$employeeID = filter_input(INPUT_GET, 'eid', FILTER_VALIDATE_INT);
if (!isset($employeeID)){$employeeID = '';}
if(empty($_SESSION['message'])){$_SESSION['message'] = '';}
$message = $_SESSION['message'];
?>
<head>
        <title>Strand Assets Login</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" type="text/css" href="../../styles/login.css">
		<link href="https://fonts.googleapis.com/css?family=Droid+Sans" rel="stylesheet">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<script src="../../scripts/jquery.js"></script>
		<script src="../../scripts/login.js"></script>
</head>
<main>
    <body>
        <div id="loginForm" style="">
            <div id="logoBanner">
                <img src="../../images/logo.png">
                <p>Reset Password</p>
                <p><?php echo $message; $_SESSION['message'] = ''; ?></p>
            </div>
            <form action="../../index.php" method="post" class="center" id="">    
                <input type="hidden" name="action" value="passwordReset">
                <input type="hidden" name="employeeID" value="<?php echo $employeeID ?>">
                <div class="padded"><input type="text" placeholder="NEW PASSWORD" name="newPassword" id="user" required /></div>
                <div class="padded"><input type="text" placeholder="CONFIRM PASSWORD" name="newPasswordConfirm" id="pass" required /></div>
                <div class="padded"><input type="submit" value="RESET" name="reset" id="resetButton" /></div>
            </form>
        </div>
	</body>
</main>
