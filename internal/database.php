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
        //save all input values from form

        

        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $surname = mysqli_real_escape_string($conn, $_POST['surname']);
        $faculty = mysqli_real_escape_string($conn, $_POST['faculty']);

        //find  if a user does not already exist with the same username and/or email
        $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
        $result = mysqli_query($conn, $user_check_query);
        $user = mysqli_fetch_assoc($result);


        //ensure the form is correctly filled
        if(empty($username)){ 
            echo '<script language="javascript">';
            echo 'alert("Δεν έβαλες όνομα χρήστη!")';
            echo '</script>';
        }
        else if(empty(isset($pass))) { 
            echo "Δεν έβαλες κωδικό!";
            echo '<script language="javascript">';
            echo 'alert("Δεν έβαλες κωδικό!")';
            echo '</script>';
        }
        else if(empty($email)) { 
            echo '<script language="javascript">';
            echo 'alert("Δεν έβαλες email!")';
            echo '</script>';
        }
        else if(empty($name)) { 
            echo '<script language="javascript">';
            echo 'alert("Δεν έβαλες όνομα!")';
            echo '</script>';
        }
        else if(empty($surname)) { 
            echo '<script language="javascript">';
            echo 'alert("Δεν έβαλες επίθετο!")';
            echo '</script>';
        }
        else if(empty($faculty)) { 
            echo '<script language="javascript">';
            echo 'alert("Δεν έβαλες σχολή !")';
            echo '</script>';
        }
        else if($user){ //if user exists
            if ($user['username'] === $username) {
                echo '<script language="javascript">';
                echo 'alert("Αυτό το όνομα χρήστη υπάρχει ήδη!")';
                echo '</script>';
            }
            if ($user['email'] === $email) {
                array_push($errors, "Αυτό το email υπάρχει ήδη!");
              }

        }
        else {
            $query_insert->execute();
            $query_insert->close();

            header('Location: register.php');
        }
    }

    function login(){

        $conn = dbconnect();

        $stmt = $conn->prepare("SELECT username,password FROM users WHERE username=?");
        $stmt->bind_param("s", $username);

        $username = mysqli_real_escape_string($conn, $_POST['username']);

        $stmt->execute();
        $result = mysqli_fetch_assoc($stmt->get_result());
        if($result && password_verify($_POST['password'], $result['password'])) {
            setcookie('username', $username, $expire = 0, "/");
            $_SESSION['username'] = $result['username'];
            header('Location: index.php'); 
            print json_encode(array('success'=>'ok'));                   
        } else {
            echo 'Λάθος username ή κωδικός πρόσβασης';
        }
        exit();
    }

    function logout() {
        if(isset($_SESSION['username'])){
            session_unset();
            session_destroy();
            header('Location: login.php');
        } else {
            header('Location: login.php');
        }
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