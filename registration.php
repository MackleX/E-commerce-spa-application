<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8"/>
    <title>Registration</title>
    <link rel="stylesheet" href="./bootstrap.min.css" />
    <link rel="stylesheet" href="./style.css" />
</head>






<?php
require_once("../header.php");
if (isset($_POST['form1'])) {

    $valid = 1;

    if(empty($_POST['clientname'])) {
        $valid = 0;
        $error_message .= "Enter your name" ."<br>";
    }

    if(empty($_POST['clientemail'])) {
        $valid = 0;
        $error_message .= "enter your mail"."<br>";
    } else {
        if (filter_var($_POST['clientemail'], FILTER_VALIDATE_EMAIL ) === false) {
            $valid = 0;
            $error_message .= "enter a valid mail"."<br>";
        } else {
            $statement = $pdo->prepare("SELECT * FROM client WHERE clientemail=?");
            $statement->execute(array($_POST['clientemail']));
            $total = $statement->rowCount();                            
            if($total) {
                $valid = 0;
                $error_message .= "Aleardy existed mail"."<br>";
            }
        }
    }

    if(empty($_POST['clientphone'])) {
        $valid = 0;
        $error_message .= "Enter your phone"."<br>";
    }

    if(empty($_POST['clientaddress'])) {
        $valid = 0;
        $error_message .= "Enter your adresse"."<br>";
    }

    if(empty($_POST['clientcity'])) {
        $valid = 0;
        $error_message .= "Enter your city"."<br>";
    }

    if(empty($_POST['clientstate'])) {
        $valid = 0;
        $error_message .= "Enter your state"."<br>";
    }

    if(empty($_POST['clientzip'])) {
        $valid = 0;
        $error_message .= "Enter your zip postale"."<br>";
    }

    if( empty($_POST['clientpassword']) || empty($_POST['clientre_password']) ) {
        $valid = 0;
        $error_message .= "Enter your password"."<br>";
    }

    if( !empty($_POST['clientpassword']) && !empty($_POST['clientre_password']) ) {
        if($_POST['clientpassword'] != $_POST['clientre_password']) {
            $valid = 0;
            $error_message .= "Something went wrong whit password confirmation"."<br>";
        }
    }

    if($valid == 1) {

        $token = md5(time() * random_int(1,10 ) / random_int(1,10) );
        $clientdatetime = date('Y-m-d h:i:s');
        $clienttimestamp = time();

        // saving into the database
        $statement = $pdo->prepare("INSERT INTO client (
                                        clientname,
                                        clientcname,
                                        clientemail,
                                        clientphone,
                                        clientcountry,
                                        clientaddress,
                                        clientcity,
                                        clientstate,
                                        clientzip,
                                        clientb_name,
                                        clientb_cname,
                                        clientb_phone,
                                        clientb_country,
                                        clientb_address,
                                        clientb_city,
                                        clientb_state,
                                        clientb_zip,
                                        clients_name,
                                        clients_cname,
                                        clients_phone,
                                        clients_country,
                                        clients_address,
                                        clients_city,
                                        clients_state,
                                        clients_zip,
                                        clientpassword,
                                        clienttoken,
                                        clientdatetime,
                                        clienttimestamp,
                                        clientstatus
                                    ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
        $statement->execute(array(
                                        strip_tags($_POST['clientname']),
                                        strip_tags($_POST['clientcname']),
                                        strip_tags($_POST['clientemail']),
                                        strip_tags($_POST['clientphone']),
                                        1,
                                        strip_tags($_POST['clientaddress']),
                                        strip_tags($_POST['clientcity']),
                                        strip_tags($_POST['clientstate']),
                                        strip_tags($_POST['clientzip']),
                                        '',
                                        '',
                                        '',
                                        1,
                                        '',
                                        '',
                                        '',
                                        '',
                                        '',
                                        '',
                                        '',
                                        1,
                                        '',
                                        '',
                                        '',
                                        '',
                                        md5($_POST['clientpassword']),
                                        $token,
                                        $clientdatetime,
                                        $clienttimestamp,
                                        0
                                    ));

        // Send email for confirmation of the account

        $to = $_POST['clientemail'];
        $subject = "Please verify your account";
        $verify_link = "localhost/mywebsite/registration/".'verify.php?email='.$to.'&token='.$token;
        $message = '
        '."Brk Brk 3la link bach tactivih".'<br><br>

    <a href="'.$verify_link.'">'.$verify_link.'</a>';

        $headers = "From: noreply@" . "localhost/mywebsite/registration/" . "\r\n" .
                   "Reply-To: noreply@" . "localhost/mywebsite/registration/" . "\r\n" .
                   "X-Mailer: PHP/" . phpversion() . "\r\n" . 
                   "MIME-Version: 1.0\r\n" . 
                   "Content-Type: text/html; charset=ISO-8859-1\r\n";
        
        // Sending Email
        echo "i am here";
        mail('dark_vs_light@windowslive.com', 'Hi leokhoa', 'I like Mail Sender feature.');
        mail($to, $subject, $message, $headers);

        unset($_POST['clientname']);
        unset($_POST['clientcname']);
        unset($_POST['clientemail']);
        unset($_POST['clientphone']);
        unset($_POST['clientaddress']);
        unset($_POST['clientcity']);
        unset($_POST['clientstate']);
        unset($_POST['clientzip']);

        $success_message = "Everything went good";
    }
}
else{
    $error_message = "fill your data";
}
?>
    
<body>



    <div class="reg-page" style="background-color: lineare-gradient(to right top,#65dfc9,#6cdbeb)"> 
    <div class="circle1"></div>
    <div class="circle2"></div>
    <div class="registration-container glass">
        <div class="row centering">
            <div class="col-md-12 ">
                <div class="user-content">

                    

                    <form action="" method="post">
                    
                       
                        <div class="row ">
                            <div class="col-md-2"></div>
                            <div class="col-md-8">
                   


                            <?php
                                if($error_message != '') {
                                    echo "<div class='error' style='padding: 10px;background:#f1f1f1;margin-bottom:20px;'>".$error_message."</div>";
                                }
                                if($success_message != '') {
                                    echo "<div class='success' style='padding: 10px;background:#f1f1f1;margin-bottom:20px;'>".$success_message."</div>";
                                }
                                ?>


                                <div class="cards">
                                <div class="col-md-6 form-group card">
                                    <label for=""><?php echo "User name"; ?> *</label>

                                    <input type="text" class="form-control" name="clientname" value="<?php if(isset($_POST['clientname'])){echo $_POST['clientname'];} ?>">

                                </div>
                                <div class="col-md-6 form-group card">
                                    <label for=""><?php echo "Country"; ?></label>
                                    <input type="text" class="form-control" name="clientcname" value="<?php if(isset($_POST['clientcname'])){echo $_POST['clientcname'];} ?>">
                                </div>
                                <div class="col-md-6 form-group card">
                                    <label for=""><?php echo "E-mail"; ?> *</label>
                                    <input type="email" class="form-control" name="clientemail" value="<?php if(isset($_POST['clientemail'])){echo $_POST['clientemail'];} ?>">
                                </div>
                                <div class="col-md-6 form-group card">
                                    <label for=""><?php echo "Phone number"; ?> *</label>
                                    <input type="text" class="form-control" name="clientphone" value="<?php if(isset($_POST['clientphone'])){echo $_POST['clientphone'];} ?>">
                                </div>
                                <div class="col-md-12 form-group card">
                                    <label for=""><?php echo "Adresse"; ?> *</label>
                                    <textarea name="clientaddress" class="form-control" cols="30" rows="10" style="height:70px;"><?php if(isset($_POST['clientaddress'])){echo $_POST['clientaddress'];} ?></textarea>
                                </div>
                     
                                
                                <div class="col-md-6 form-group card">
                                    <label for=""><?php echo "City"; ?> *</label>
                                    <input type="text" class="form-control" name="clientcity" value="<?php if(isset($_POST['clientcity'])){echo $_POST['clientcity'];} ?>">
                                </div>
                                <div class="col-md-6 form-group card">
                                    <label for=""><?php echo "State"; ?> *</label>
                                    <input type="text" class="form-control" name="clientstate" value="<?php if(isset($_POST['clientstate'])){echo $_POST['clientstate'];} ?>">
                                </div>
                                <div class="col-md-6 form-group card">
                                    <label for=""><?php echo "Zip postal"; ?> *</label>
                                    <input type="text" class="form-control" name="clientzip" value="<?php if(isset($_POST['clientzip'])){echo $_POST['clientzip'];} ?>">
                                </div>
                                <div class="col-md-6 form-group card">
                                    <label for=""><?php echo "type your passwor"; ?> *</label>
                                    <input type="password" class="form-control" name="clientpassword">
                                </div>
                                <div class="col-md-6 form-group card">
                                    <label for=""><?php echo "confirm your password"; ?> *</label>
                                    <input type="password" class="form-control" name="clientre_password">
                                </div>
                                <div class="col-md-6 form-group card special">
                                    <label for=""></label>
                                    <input type="submit" class="btn btn-primary" value="<?php echo "submit results"; ?>" name="form1">
                                </div>

                                </div>
                            
                            </div>
                        </div>                        
                    </form>
                </div>                
            </div>
        </div>
    </div>
</div>
</body>
</html>
