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

.sidebar{
  display: flex;
    position:absolute;
    top:10px;
    left: 10px;
    width:400px;
    height:200px;
}


#game {
  display: flex;
  position: absolute;
  top: 35%;
  left: 45%;
  margin: -100px 0 0 -150px;
  border: 3px solid red;
  background-color: blue;
  border-radius: 15px;
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
<?php
  echo $_COOKIE['username'];
?>
<div class='container'>

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
            </tr>
            <tr >
                <td >2.1</td>
                <td >2.2</td>
                <td ></td>
                <td ></td>
                <td ></td>
                <td ></td>
              </tr>
              <tr >
                 <td >3</td><td ></td>
                <td ></td>
                <td ></td>
                <td ></td>
                <td ></td>
              </tr>
              <tr >
              <td >4</td><td ></td>
                <td ></td>
                <td ></td>
                <td ></td>
                <td ></td>
              </tr>
              <tr >
              <td ></td><td ></td>
                <td ></td>
                <td ></td>
                <td ></td>
                <td ></td>
              </tr>
              <tr >
              <td ></td><td ></td>
                <td ></td>
                <td ></td>
                <td ></td>
                <td ></td>
              </tr>
            </tbody>
          </table>
  </div>
</div>

   
</body>
</html>