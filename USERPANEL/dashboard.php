<?php
require_once("../config/config.php");
require_once("../userinterface/authentfication.php");
?>


<div class="page">
    <div class="wrapper">

        <div class="sidebar " data-color="purple" data-background-color="white">

            <?php require_once('./client-sidebar.php'); ?>

        </div>

        <div class="main-panel">

            <?php require_once('../CROSSPAGESELEMENTS/nav-bar.php'); ?>  
    

            <div class="user-content">
                <h3 class="text-center">
                    <?php echo "Welcom  to dash Board" ?>
                </h3>
            </div>
        </div>


    </div>