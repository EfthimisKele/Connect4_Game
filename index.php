<?php

    require 'internal/database.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Σκορ 4</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/index.css">
    <script
			  src="https://code.jquery.com/jquery-3.5.1.min.js"
			  integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
			  crossorigin="anonymous">
                  
              </script>
    <script type="text/javascript" src="js/create.js"></script>
<style>
html, body {
    width: 100%;
    height: 100%;
    margin: 0;
    background-color: lightgoldenrodyellow;
    font-family: 'Roboto', sans-serif;
}

.container{
  display: flex;
  justify-content: center;
}

#header{
  height:80px;
  line-height:80px;
  margin:0;
  padding-left:10px;
}

#game {
  display: flex;
  position: absolute;
  top: 35%;
  left: 45%;
  margin: -80px 0 0 -200px;
  border: 3px solid red;
  background-color: blue;
  border-radius: 15px;
}

#names{
  position: fixed;
  left:0;
  top:50%;
  margin-top: 50%;
}

.sign_out{
  margin: 70px;
}

td.score_circle { 
    padding: 8px;
    background: #E8ECE0;
    text-align: center;
    border: 1px solid #444;
    border-bottom-width: 0px;
    cursor:  pointer;
    height: 60px;
    width: 70px;
    border-top-right-radius: 100px;
    border-top-left-radius: 100px;
    border-bottom-right-radius: 100px;
    border-bottom-left-radius: 100px;
    border-bottom-width: 4px;
}

table { 
    border-spacing: 0; 
    border: 0; 
    margin:3px; 
    padding:20px
}
 
 
</style>    
</head>

<body onload="draw_board()">
<div class='container'>
  <div id="header">
  <?php
  echo "Καλως όρισες ξανά ".$_COOKIE['username']." !";

  if(isset($_SESSION['username'])) {
    echo '<a href="logout.php">' .
        '<i class="sign_out"></i>' .  
        'Αποσύνδεση</a>';
} 
  ?>
  </div>
  <div id=names>
    <h1>YOLOOO</h1><br>
    <h2>DF</h2>
  </div>
  <div id="game">  
  </div>
</div>

   
</body>
</html>