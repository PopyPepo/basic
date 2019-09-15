<?php include("connect.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Car Rent | ยืม-คืน รถยนต์ส่วนบุคคล</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fontawesome/css/all.min.css">
    <link href="https://fonts.googleapis.com/css?family=Bai+Jamjuree:400,400i,600,600i&display=swap" rel="stylesheet">
    <style>html * {font-family: 'Bai Jamjuree', sans-serif;}
        nav.navbar{margin-bottom: 3rem;}
    </style>
</head>
<body>

<?php 
    $PAGE = isset($_GET['page']) ? $_GET['page'] : "home/home";
    $str_pathFile = $PAGE.".php";

    include 'home/menu.php';
   
    if (file_exists($str_pathFile)){
        include_once($str_pathFile);
    }else{
        include_once("error/404.php");
    }
?>



<script src="assets/bootstrap/js/jquery-3.3.1.min.js"></script>
<script src="assets/bootstrap/js/popper.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>