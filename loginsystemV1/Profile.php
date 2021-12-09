<?php 
    //Start a Session
    session_start();

    //If User is logged in go to profile
    if (!isset($_SESSION['loggedIn'])) {
        header('Location: Login.php');
        exit();
    }

?>

<h1>User Profile</h1>

<a href="Logout.php">Logout</a>