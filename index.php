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

.sign_out{
  margin: 70px;
}

th, td { 
    padding: 8px;
    background: #E8ECE0;
    text-align: center;
    border: 1px solid #444;
    border-bottom-width: 0px;
    cursor:  pointer;
}

td {
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

<body>
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
  <div id="game">
    <table >
        <tbody>
            <tr>
                <td >1.1</td>
                <td >1.2</td>
                <td >1.3</td>
                <td >1.4</td>
                <td >1.5</td>
                <td >1.6</td>
                <td >1.7</td>
            </tr>
            <tr >
                <td >2.1</td>
                <td >2.2</td>
                <td ></td>
                <td ></td>
                <td ></td>
                <td ></td>
                <td ></td>
              </tr>
              <tr >
                 <td >3.1</td>
                 <td ></td>
                <td >3.3</td>
                <td ></td>
                <td ></td>
                <td ></td>
                <td ></td>
              </tr>
              <tr >
                <td >4.1</td>
                <td ></td>
                <td ></td>
                <td >4.4</td>
                <td ></td>
                <td ></td>
                <td ></td>
              </tr>
              <tr >
                <td >5.1</td>
                <td ></td>
                <td ></td>
                <td ></td>
                <td >5.5</td>
                <td ></td>
                <td ></td>
              </tr>
              <tr >
                <td >6.1</td>
                <td ></td>
                <td ></td>
                <td ></td>
                <td ></td>
                <td >6.6</td>
                <td >6.7</td>
              </tr>
            </tbody>
          </table>
  </div>
</div>

   
</body>
</html>