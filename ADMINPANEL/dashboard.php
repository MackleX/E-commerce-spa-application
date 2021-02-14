<?php
require_once("../config/config.php");
session_start();
?>
        

<div class="page">
    <div class="wrapper">

        <div class="sidebar " data-color="purple" data-background-color="white">

            <?php require_once('sidebar.php'); ?>

        </div>

        <div class="main-panel">

            <?php require_once('nav-bar.php'); ?>  
    

            <div class="user-content">
                <h3 class="text-center-x">
                     WELCOME  TO DASH BOARD
                     <?php echo "Mr " . strtoupper($_SESSION["admin"]["name"]); ?>

                </h3>
            </div>
        </div>


    </div>
    <head>
    <style>
    .text-center-x{
        position:absolute;
        top:40%;
        left:30%;
    }
    </style>
    

    </head>
   