<?php
//MAIN INDEX FILE
//Starts a new session or grabs the current session
if(empty($_SESSION) && (!isset($_SESSION)))
{
    session_set_cookie_params(0, '/');
    session_start();
}


//We'll start off trying to pull the action to utilized agains the switch statement
$action = filter_input(INPUT_POST, 'action');

if ($action == NULL)
{
    $action = filter_input(INPUT_GET, 'action');
    if ($action == NULL)
    {
        $action = 'login';
    }
}

//Start of the switch that will run the application
switch($action)
{
    case 'login':
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_REGEXP,
                        array("options" => array("regexp"=>"/[A-Za-z0-9\_\.]+\@[A-Za-z0-9]+\.[A-Za-z]{3}/")));
        $password = filter_input(INPUT_POST, 'password', FILTER_VALIDATE_REGEXP, 
                array("options" => array("regexp"=>"/(?:[^\s;{}=]+){1,10}/")));
        $initialLoad = filter_input(INPUT_POST, 'initialLoad', FILTER_VALIDATE_REGEXP, 
                array("options" => array("regexp"=>"/(?:false|true)/i")));

        include('login/index.php');
    break;

    case 'forgot':
        include('login/index.php');
    break;
    
    case 'addItem':
        include('admin/index.php');
    break;

    case 'updateItem':
        include('admin/index.php');
    break;

    case 'deleteItem':
        include('admin/index.php');
    break;

    case 'addUser':
        include('admin/index.php');
    break;

    case 'updateUser':
        include('admin/index.php');
    break;

    case 'deleteUser':
        include('admin/index.php');
    break;

    case 'assignItem':
        include('admin/index.php');
    break;

    case 'viewUser':
        $empID = filter_input(INPUT_GET, 'empID');
        include('admin/index.php');
    break;
    
    case 'passwordReset':
        include('login/index.php');
    break;
    
    case 'home':
        include('view/admin/admin.php');
    break;

    case 'logout':
        if(!empty($_SESSION) || (isset($_SESSION)))
        {
            $_SESSION = array();
            session_destroy();
            $name = session_name();
            $expire = strtotime('-1 year');
            setcookie($name, '', $expire);
            include('/view/login/login.php');
        }
        else
        {
            include('/view/login/login.php');
        }
    break;
}
?>