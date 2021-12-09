<?php
    //Start a Session
    session_start();

    //If User is logged in go to profile
    if (isset($_SESSION['loggedIn'])) {
        header('Location: Profile.php');
        exit();
    }

    //If var Login has be POSTed 
    if(isset($_POST['login'])) {
        //Make connection to DB
        $connection = new mysqli(hostname: "localhost", username: "root", password: "", database: "loginsystemdb");

        //Set Variables to POSTed data and remove sql commands
        $username = $connection->real_escape_string($_POST['usernamePHP']);
        $password = $connection->real_escape_string($_POST['passwordPHP']);

        //Try select id for username and password combo
        $data = $connection->query(query: "SELECT id FROM users WHERE username = '$username' AND password = '$password'");

        //If username and pw matched a DB entry
        if($data->num_rows > 0) {
            //Loop return data and set Variable id to id of user    
            while($row = $data->fetch_assoc()) { 
                $id = $row["id"];
            }
            //Set session var logged in 
            $_SESSION['loggedIn'] = true;
            //Set session var id to user id
            $_SESSION['id'] = $id;
            //Exit and return True
            exit(true);
        } 
        else {
            //Exit and return False
            exit(false);
        }     
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Login System</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="App.css">
    </head>
    <body>
        <h1>Login</h1>
        <form method="POST" action="Main.php">
            <div>
                <label>Username: </label>
                <input id="username" type="text" placeholder="Username.." /> 
            </div>
            <div>
                <label>Password: </label>
                <input id="password" type="password" placeholder="Password.." /> 
            </div>
            <div>
                <input id="submit" type="button" value="Login"/> 
            </div>
        </form>

        <div>
            <p id="status"></p>
        </div>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

        <script type="text/javascript">
            $(document).ready(function () {
                $("#submit").click(function () {
                    var username = $("#username").val().trim();
                    var password = $("#password").val().trim();                  

                    if(username == "" || password == ""){
                        alert("Fields are emty");
                    }
                    else{
                        $.ajax(
                            {
                                url: "Login.php",
                                method: "POST",
                                data: {
                                    login: 1,
                                    usernamePHP: username,
                                    passwordPHP: password
                                },
                                success: function(loggedIn) {
                                    if(loggedIn == true){
                                        $("#status").html("Login Successful");
                                        window.location = "Profile.php";
                                    } else {
                                        $("#status").html("Login Failed");
                                    }
                                },
                                dataType: "text"
                            }
                        )
                    }           
                })
            });   
        </script>

    </body>
</html>