<?php
require_once('databaseConnect.php');

function getUserVerification($email)
{
    global $db;
    
    $query = 'SELECT email, password, status FROM employee WHERE email = :email';
    $statement = $db->prepare($query);
    $statement->bindValue(':email', $email);
    $statement->execute();
    $returnedUser = $statement->fetch();
    $statement->closeCursor();
    return $returnedUser;
    
}

function verifyLogin($email, $password)
{
    $email = strtoupper($email);
    $returnedUser = getUserVerification($email);
    
    if ($returnedUser)
    {
        $returnedPassword = $returnedUser['password'];
        $passwordCheck = password_verify($password, $returnedPassword);
    
        if($passwordCheck)
        {
            $userPrivileges = $returnedUser['status'];
            return $userPrivileges;
        }
        else
        {
            $userPrivileges = "loginNotMatch";
            return $userPrivileges;
        }
    }
    else
        {
            $userPrivileges = "userNotFound";
            return $userPrivileges;
        }
}

function getUserInformation($email)
{
    global $db;
    
    $query = 'SELECT email, emp_id, status FROM employee WHERE email = :email';
    $statement = $db->prepare($query);
    $statement->bindValue(':email', $email);
    $statement->execute();
    $returnedUser = $statement->fetch();
    $statement->closeCursor();
    return $returnedUser;  
}

function forgotUserSearch($email)
{
    global $db;
    
    $query = 'SELECT f_name, l_name, emp_id, email FROM employee WHERE email = :email';
    $statement = $db->prepare($query);
    $statement->bindValue(':email', $email);
    $statement->execute();
    $returnedUser = $statement->fetch();
    $statement->closeCursor();
    return $returnedUser;
}

/*function forgotUserVerification($email)
{
    $returnedUser = forgotUserSearch($email);
    $forgotUserCheck = false;
    
    if ($returnedUser)
    {

        $returnedEmail = $returnedUser['email'];
    
        if($returnedUsername == $username && $returnedEmail == $email)
        {
            $forgotUserCheck = true;
        }
        else
        {
            $forgotUserCheck = false;
        }
    }
    else
    {
        $forgotUserCheck = false;
    }
    return $forgotUserCheck;
}*/

function passwordReset($emp_id, $password)
{
    global $db;
    $password = password_hash($password, PASSWORD_DEFAULT);

    $query = 'UPDATE employee 
                SET password = :password
                WHERE emp_id = :emp_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':emp_id', $emp_id);
    $statement->bindValue(':password', $password);
    $success = $statement->execute();
    $statement->closeCursor();
    return $success;
}

?>