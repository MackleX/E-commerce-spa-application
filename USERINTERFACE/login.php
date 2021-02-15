<?php 
require_once("../config/config.php");
require_once("../userinterface/authentfication.php")
?>

<?php
    $error_message = "";
if($isOnline){
    header('location' . '../homepage/index.php');
}
if(isset($_POST['form1'])) {
        
    if(empty($_POST['client_email']) || empty($_POST['client_password'])) {
        $error_message = " password or e-mail are empty ";
    } else {
        
        $client_email = strip_tags($_POST['client_email']);
        $client_password = strip_tags($_POST['client_password']);
        $statement = $pdo->prepare("SELECT * FROM client WHERE client_email=?");
        $statement->execute(array($client_email));
        $total = $statement->rowCount();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach($result as $row) {
            $client_status = $row['client_status'];
            $row_password = $row['client_password'];
        }

        if($total==0) {

            $error_message .= "no email have been found".'<br>';

        } else {
            //using MD5 form
            if( $row_password != md5($client_password) ) {
                $error_message .= "Wrong password".'<br>';
            } else {
                if($client_status == 0) {
                    $error_message .= "Your account is susspended try to contact our support".'<br>';
                } else {

                    $_SESSION['customer'] = $row;
                    header("location: "."../HOMEPAGE/index.php");
                    
                }
            }
            
        }
    }
}

?>

<head>
    <meta charset="utf-8"/>
    <title>Login</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../assets/styles/styleglass.css" />
</head>

<div class="log-page">

    <div class="circle1"></div>
    <div class="circle2"></div>
    
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
                                ?>
                                <div class="form-group card">
                                    <label for="">Email*</label>
                                    <input type="email" class="form-control" name="client_email">
                                </div>
                                <div class="form-group card">
                                    <label for="">Password *</label>
                                    <input type="password" class="form-control" name="client_password">
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

