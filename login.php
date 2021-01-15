<?php 
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once($root."/mywebsite/header.php");
?>

<?php

if(isset($_POST['form1'])) {
        
    if(empty($_POST['clientemail']) || empty($_POST['clientpassword'])) {
        $error_message = " password or e-mail are empty ";
    } else {
        
        $clientemail = strip_tags($_POST['clientemail']);
        $clientpassword = strip_tags($_POST['clientpassword']);
        $statement = $pdo->prepare("SELECT * FROM client WHERE client_email=?");
        $statement->execute(array($clientemail));
        $total = $statement->rowCount();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach($result as $row) {
            $clientstatus = $row['client_status'];
            $row_password = $row['client_password'];
        }

        if($total==0) {

            $error_message .= "no email have been found".'<br>';

        } else {
            //using MD5 form
            if( $row_password != md5($clientpassword) ) {
                $error_message .= "Wrong password".'<br>';
            } else {
                if($clientstatus == 0) {
                    $error_message .= "Your account is susspended try to contact our support".'<br>';
                } else {
                    $_SESSION['customer'] = $row;
                    header("location: "."/mywebsite/index.php");
                }
            }
            
        }
    }
}
?>

<head>
    <meta charset="utf-8"/>
    <title>Registration</title>
    <link rel="stylesheet" href="./bootstrap.min.css" />
    <link rel="stylesheet" href="./style.css" />
</head>

<div class="log-page">
    <div class="container cards">
        <div class="row">
            <div class="col-md-12">
                <div class="user-content">

                    
                    <form action="" method="post">            
                        <div class="row">
                            <div class="col-md-4"></div>
                            <div class="col-md-4">
                                <?php
                                if($error_message != '') {
                                    echo "<div class='error' style='padding: 10px;background:#f1f1f1;margin-bottom:20px;'>".$error_message."</div>";
                                }
                                if($success_message != '') {
                                    echo "<div class='success' style='padding: 10px;background:#f1f1f1;margin-bottom:20px;'>".$success_message."</div>";
                                }
                                ?>
                                <div class="form-group card">
                                    <label for="">Email*</label>
                                    <input type="email" class="form-control" name="clientemail">
                                </div>
                                <div class="form-group card">
                                    <label for="">Password *</label>
                                    <input type="password" class="form-control" name="clientpassword">
                                    <a href="forget-password.php" style="display:inline">Passwod forget</a>
                                </div>
                                
                                <div class="form-group card"style="width:20%; margin:auto;" >
                                    <label for=""></label>
                                    <input type="submit" class="btn btn-primary" value="Login" name="form1" style=" width:100%; height:100%">
                                </div>
                               
                            </div>
                        </div>                        
                    </form>
                </div>                
            </div>
        </div>
    </div>
</div>

