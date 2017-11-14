<?php
    $dsn = 'mysql:host=localhost;dbname=strand';
    $DBusername = 'root';
    $DBpassword = '';

    try {
        $db = new PDO($dsn, $DBusername, $DBpassword);
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        include('../index.php');
        exit();
    }
?>