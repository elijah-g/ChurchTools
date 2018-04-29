<?php ob_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Leschenault Ward - <?php echo $pageTitle; ?></title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <!--Font Awesome CSS-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">
    <!-- jQuery library -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
    <link rel="stylesheet" href="cssOne.css" type="text/css">
    <script src="js.js"></script>
    <link rel="shortcut icon" href="//edge.ldscdn.org/cdn2/common/images/logos/favicon-lds-1.ico">
</head>
<body onload="countchecker()">
<div class="container">
<?php include ("nav.php");?>
<div class="panel panel-primary" style="border: none;">
    <div class="panel-heading">
        <h1><?php echo $pageTitle; ?></h1>
    </div>
    <div class="panel-body">
