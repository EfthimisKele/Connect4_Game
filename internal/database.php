<?php
    session_start();
    error_reporting(E_ALL);
    ini_set('display_errors', TRUE);
    ob_start();
        
    

    function dbconnect() {
    $host = 'localhost';
    $user = 'root';
    $password = '';
    $database = 'score4';
    $errors = array();

    $conn = new mysqli($host, $user, $password, $database);
    mysqli_set_charset($conn,"utf8");

    if ($conn->connect_error) die("Η σύνδεση απέτυχε: " . $conn->connect_error);
    return $conn;
    }


    function register(){
        //make connection
        $conn = dbconnect();

        $query_insert = $conn->prepare("INSERT INTO users (username, email, password, name, surname, study) VALUES (?, ?, ?, ?, ?, ?)");
        $query_insert->bind_param("ssssss", $username , $email, $pass, $name, $surname, $faculty);
        

        //ensure the form is correctly filled, adding error to $error array 
        if(empty($username)) { array_push($errors, "Δεν έβαλες όνομα χρήστη!");}
        if(empty($pass)) { array_push($errors, "Δεν έβαλες κωδικό!");}
        if(empty($email)) { array_push($errors, "Δεν έβαλες email!");}
        if(empty($name)) { array_push($errors, "Δεν έβαλες όνομα!");}
        if(empty($surname)) { array_push($errors, "Δεν έβαλες επίθετο!");}
        if(empty($faculty)) { array_push($errors, "Δεν έβαλες σχολή !");}

        //save all input values from form
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $surname = mysqli_real_escape_string($conn, $_POST['surname']);
        $faculty = mysqli_real_escape_string($conn, $_POST['faculty']);

        $query_insert->execute();
        $query_insert->close();

        header('Location: register.php');
    }

    function login(){

        $conn = dbconnect();

        $stmt = $conn->prepare("SELECT username FROM users WHERE username=?");
        $stmt->bind_param("s", $username);

        $username = mysqli_real_escape_string($conn, $_POST['username']);

        $stmt->execute();
        $result = mysqli_fetch_assoc($stmt->get_result());
        if($result && password_verify($_POST['password'], $result['password'])) {
            //problem
            header('Location: index.php'); 
            $_SESSION['username'] = $username; 
            print json_encode(array('success'=>'ok'));
           // echo "<script type='text/javascript'> document.location = 'index.php'; </script>";                   
        } else {
            echo 'Λάθος username ή κωδικός πρόσβασης';
        }
        exit();
    }












    ob_end_flush();
?>
<?php

    if (isset($_POST['register'])) {
        register();
    }

    if (isset($_POST['login'])) {
        login();
    }
?>