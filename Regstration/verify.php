<?php require_once('../header.php'); ?>
<head>
    <meta charset="utf-8"/>
    <title>Registration</title>
    <link rel="stylesheet" href="./bootstrap.min.css" />
    <link rel="stylesheet" href="./style.css" />
</head>

<?php
if ( (!isset($_REQUEST['email'])) || (isset($_REQUEST['token'])) )
{
    $var = 1;

    // check if the token is correct and match with database.
    $statement = $pdo->prepare("SELECT * FROM client WHERE clientemail=?");
    $statement->execute(array($_REQUEST['email']));
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);                           
    foreach ($result as $row) {
    }

    // everything is correct. now activate the user removing token value from database.
    if($var != 0)
    {
        $statement = $pdo->prepare("UPDATE client SET clienttoken=?, clientstatus=? WHERE clientemail=?");
        $statement->execute(array('',1,$_GET['email']));

        $success_message = '<p style="color:green; ">Your email is verified successfully. You can now login to our website.</p><p><a href="'.BASE_URL.'login.php" style="color:#167ac6;font-weight:bold;">Click here to login</a></p>';     
    }
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
                        echo $error_message;
                        echo $success_message;
                    ?>
                </div>                
            </div>
        </div>
    </div>
    </div>
</div>
</div>

