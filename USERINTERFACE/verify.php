<?php require_once('../config/config.php'); ?>
<head>
    <meta charset="utf-8"/>
    <title>Registration</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../assets/styles/styleglass.css" />
</head>

<?php
if ( (isset($_REQUEST['email'])) || (isset($_REQUEST['token'])) )
{
    $var = 1;

    // check if the token is correct and match with database.
    $statement = $pdo->prepare("SELECT * FROM client WHERE client_email=?");
    $statement->execute(array($_REQUEST['email']));
    $row = $statement->fetch(PDO::FETCH_ASSOC);                           
    if(empty($row)){$var = 0;}
    if($var != 0)
    {
        $statement = $pdo->prepare("UPDATE client SET client_token=?, client_status=? WHERE client_email=?");
        $statement->execute(array('',1,$_GET['email']));

        $message = '<p style="color:green; ">Your email is verified successfully, wait sometime you will get redirected to landing page in 5s.</p>';     
    }else{

        $message = '<p style="color:red; ">Are you kiiddin?</p>';     
    }

?>
<div class="reg-page" >
<div style="width:50%;" >
<div class="cards" style="margin: auto;">
   
    <div class="card">
        <h1 style="margin: auto;">Registration Successful</h1>
    </div>


    <div class="card">
        <div class="row" style="margin:auto;">
            <div class="col-md-12" >
                <div class="user-content">
                    <?php 
                        echo $message;
                    ?>
                </div>                
            </div>
        </div>
    </div>
    </div>
</div>
</div>
<?php

header( "refresh:5;url=../HOMEPAGE/index.php" );
}else{
    header("Location:". "../HOMEPAGE/index.php");
}?>
