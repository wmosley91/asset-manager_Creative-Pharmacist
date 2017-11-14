<?php  
//LOGIN INDEX FILE
if(empty($_SESSION) && (!isset($_SESSION)))
{
    session_set_cookie_params(0, '/');
    session_start();
}
//variables
$message = '';

//filters the action from the request to decide how to handle it. If no action was set, redirects to the login

$action = filter_input(INPUT_POST, 'action');

if ($action == NULL)
{
    $action = filter_input(INPUT_GET, 'action');
    if ($action == NULL)
    {
        $action = 'login';
    }
}

switch($action)
{
    case 'login':
        if($email == null && $password == null)
        {
            include('\view\login\login.php');
            break;
        }
        else
        {
            //Filters the Text Inputs from the login screen to ensure they don't include unnecessary characters

            if($email == false && $initialLoad == 'false')
            {
                $message = $message . "\n Please enter a valid email";
                $_SESSION['message'] = $message;
                $email = filter_input(INPUT_POST, 'email');
                $password = filter_input(INPUT_POST, 'password');
                include('\view\login\login.php');
                break;
            }
            else if($password == null && $initialLoad == 'false')
            {
                $message = $message . "\n Password must be between 5 and 10 characters and cannot contain spaces, {}, or an =";
                $_SESSION['message'] = $message;
                include('\view\login\login.php');
                break;
            }
            else
            {
                if($email && $password)
                {
                    require_once('model/loginDB.php');

                    $password = trim($password);
                    $loginVerificationResult = strtolower(verifyLogin($email, $password));


                    if($loginVerificationResult == "admin")
                    {
                        $_SESSION['user'] = getUserInformation($email);
                        $action = "adminLand";
                        include('admin/index.php');
                        break;
                    }
                    else if($loginVerificationResult == "basic")
                    {
                        $_SESSION['user'] = getUserInformation($email);
                        include('view/user/user.php');
                        break;
                    }
                    else if($loginVerificationResult == "loginnotmatch")
                    {
                        $message = $message . "\n Email and Password did not match, please check the information entered and try again.";
                        $_SESSION['message'] = $message;
                        $email = filter_input(INPUT_POST, 'email');
                        $password = filter_input(INPUT_POST, 'password');
                        include('\view\login\login.php');
                        break;
                    }
                    else if($loginVerificationResult == "usernotfound")
                    {
                        $message = $message . "\n User account was not found, please check the information entered and try again.";
                        $_SESSION['message'] = $message;
                        $email = filter_input(INPUT_POST, 'email');
                        $password = filter_input(INPUT_POST, 'password');
                        include('\view\login\login.php');
                        break;
                    }
                }
            }
         }

        break;
    
        
    case 'forgot':
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_REGEXP,
                array("options" => array("regexp"=>"/[A-Za-z0-9\_\.]+\@[A-Za-z0-9]+\.[A-Za-z]{3}/")));
        
        $email = trim($email);

        if($email == null || $email == false)
        {
            $message = $message . "\n Please enter a valid email";
            include('\view\login\login.php');
        }
        else
        {
            if($email)
            {
                require_once('/model/loginDB.php');
                require_once('/login/emailHandler.php');
                
                $email = strtoupper($email);
                $userVerificationResult = forgotUserSearch($email);
                

                if($userVerificationResult)
                {
                    $user = $userVerificationResult;
                    $userFullName = $user['f_name'] . ' ' . $user['l_name'];
                    $userEmail = $user['email'];
                    $userEmpID = $user['emp_id'];
                    sendEmail($userEmail, $userFullName, $userEmpID);
                    $message = "An email with instructions on how to reset your account was sent to the profile provided.";
                    include('\view\login\login.php');
                }
                else
                {
                    $message = "Username was not found, please check the information entered and try again.";
                    include('\view\login\login.php');
                }
            }
        }
        break;
        
        
    case 'passwordReset':
        $newPassword = filter_input(INPUT_POST, 'newPassword');
        $newPasswordConfirm = filter_input(INPUT_POST, 'newPasswordConfirm');
        $employeeID = filter_input(INPUT_POST, 'employeeID');

        if($newPassword == $newPasswordConfirm)
        {
            require_once('/model/loginDB.php');
            
            
            $success = passwordReset($employeeID, $newPassword);
            
            if($success)
            {
                $message = "Your password has been updated. Please login with your new password.";
                //$_SESSION['message'] = $message;
                include('\view\login\login.php');
            }
            else
            {
                $message = "Your password could not be updated at this time.";
                //$_SESSION['message'] = $message;
                include('\view\login\login.php');
            }
        }
        else
        {
            $message = $message . "Passwords did not matach. Please try again.";
            //$_SESSION['message'] = $message;
            include('\view\login\login.php');
        }
        break;
}
?>