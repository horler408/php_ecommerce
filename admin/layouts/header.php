<!DOCTYPE html>
<html lang="en">
<head>
 
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
 
    <title><?php echo isset($page_title) ? strip_tags($page_title) : "Store Admin"; ?></title>
 
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" media="screen" />
 
    <!-- admin custom CSS -->
    <link href="<?php echo $home_url . "libs/css/admin.css" ?>" rel="stylesheet" />
 
</head>
<!-- custom css -->
<style>
    .m-r-1em{ 
        margin-right:1em; 
    }
    .m-b-1em{ 
        margin-bottom:1em; 
    }
    .m-l-1em{ 
        margin-left:1em; 
    }
    .mt0{ 
        margin-top:0;
    }
    </style>
<body>
 
    <?php
    // include top navigation bar
    include_once "navigation.php";
    ?>
 
    <!-- container -->
    <div class="container">
 
        <!-- display page title -->
        <div class="col-md-12">
            <div class="page-header">
                <h1><?php echo isset($page_title) ? $page_title : "The Code of a Ninja"; ?></h1>
            </div>
        </div>