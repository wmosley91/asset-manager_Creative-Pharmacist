<?php

function setEmailMessage($employeeID){
    $url = "http://localhost/Strand/view/login/resetLogin.php?eid=" . $employeeID;

    $messageHTML = '
    <!DOCTYPE html>
    <html>
    <head>
    <title>HTML email</title>
    </head>
    <body>
    <p>Please click the link below to reset your password. You may have to copy the link <br> 
    and paste it into your broswer if the link does not allow you to click on it.</p>
    <p><a href="' . $url . '">Reset your password here</a></p>
    </body>
    </html>'
    ;

    $message =  "Please copy and paste this link into your browser to reset your password. \n" . $url;
    
    $toEmailMessage = array('message' => $messageHTML,
                            'altMessage' => $message);
    return $toEmailMessage;
}


function sendEmail($toEmail, $toName, $employeeID) {

    require_once('/PHPMailer.php');

    set_time_limit(0);
    
    $toMessage = setEmailMessage($employeeID);
    $email = new PHPMailer();

    $email->IsSMTP();
    // $email->IsSendmail();
    $email->Host       = 'smtp.gmail.com';   //Will need to be modified
    $email->SMTPAuth   = true;  
    $email->Port       = 465;
    $email->SMTPDebug  = 1; 
    $email->Username   = 'mfridaytester@gmail.com';
    $email->Password   = 'fridaytester';  
    //$email->SMTPSecure = 'tls';  
    $email->SMTPSecure = 'ssl';  

    $email->From      = 'NOREPLYSTRAND@gmail.com';
    $email->FromName  = 'Strand Helpdesk'; //Will need to be modified – identifies email of sender
    $email->SetFrom('NOREPLYSTRAND@gmail.com', 'Strand Helpdesk');  //Will need to be modified – identifies email of sender
    // $email->MsgHTML($message);
    
    $email->AddAddress($toEmail, $toName);

    $email->Subject   = 'Strand Password Reset'; // appears in subject of email
    $email->Body      = $toMessage['message'] ;  // the body will interpret HTML - $messageHTML identified above
    $email->AltBody = $toMessage['altMessage'];            // the AltBody will not interpret HTML - $message identified above
    //$email->Send();



    //AddAddress method identifies destination and sends email	
     if(!$email->Send()) {
     echo "Mailer Error: " . $email->ErrorInfo;
      } else {
       echo "Message sent!";
      }

    }

?>
