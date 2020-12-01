<?php
    require 'internal/database.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eγγραφή - Σκορ4</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
<div class="container">
    
        <div class="logo">
            <img src="img/logo.png" alt="" style="border-radius: 15px; width:250px">
        </div>   
        <div class="form-container">
            <h2>Εγγραφή</h2>
            <form method="post">
                <input type="text" name="username" placeholder="Όνομα Χρήστη">
                <input type="password" name="password" placeholder="Κωδικός">
                <input type="email" name="email" placeholder="Email">
                <input type="text" name="name" placeholder="Όνομα ">
                <input type="text" name="surname" placeholder="Επίθετο">
                <input type="text" name="faculty" placeholder="Σχολή">               
                <input type="submit" name="register" value="Εγγραφή" >
                <a href="./login.php"><input type="button" name="return" value="Επιστροφή στην Αρχική"></a>
            </form>
        </div>
    </div>
    
</body>
</html>