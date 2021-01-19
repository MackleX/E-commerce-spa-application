<?php require_once(__DIR__ . "/header.php");
$is_online = true;
if (!isset($_SESSION['customer'])) {
    $is_online = false;
} else {
    // If customer is logged in, but admin make him inactive, then force logout this user.
    $statement = $pdo->prepare("SELECT * FROM client WHERE client_id=? AND client_status=?");
    $statement->execute(array($_SESSION['customer']['client_id'], 0));
    $total = $statement->rowCount();
    if ($total) {
        $is_online = false;
    }
}

?>


<nav class="navbar navbar-expand bg-primary navbar-absolute fixed-top ">

    <div class="collapse navbar-collapse flex-grow-1 text-right" id="myNavbar">

        <a href="/" class="navbar-brand">Logo</a>


        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                
                <button class="btn btn-warning" type="submit">Sell on our web Site</button>
               
            </li>
            <li class="nav-item">
                <button class="btn btn-warning" type="submit" href="/mywebsite/regstration/login.php">Register as client or Seller</button>
            </li>
            <li class="nav-item">
            <form action="/mywebsite/index.php">
                <button class="btn btn-warning" type="submit">Go Shopping</button>
            </form>
            </li>
        </ul>




        <div class="navbar-nav ml-auto flex-nowrap">

            <ul class="navbar-nav">
                

                <li class="nav-item dropdown">
                    <a class="nav-link" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="material-icons">shopping_cart</i>
                        <span class="notification">0</span>
                        <p class="d-lg-none d-md-block">
                            Some Actions
                        </p>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="#">Mike John responded to your email</a>
                        <a class="dropdown-item" href="#">You have 5 new tasks</a>
                        <a class="dropdown-item" href="#">You're now friend with Andrew</a>
                        <a class="dropdown-item" href="#">Another Notification</a>
                        <a class="dropdown-item" href="#">Another One</a>
                    </div>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link" href="javascript:;" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="material-icons">person</i>
                <?php if($is_online){?>
                <span class="badge badge-primary"><?php echo "Loged as ".$_SESSION["customer"]["client_name"] ; ?> </span>
                <?php }?>
 
                        <p class="d-lg-none d-md-block">
                            Account
                        </p>
                    </a>
                    
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">

                        <?php if ($is_online) { ?>

                            <a class="dropdown-item" href="/mywebsite/regstration/dashboard.php">Profile</a>

                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="/mywebsite/regstration/logout.php">Log out</a>

                        <?php } else { ?>
                            <a class="dropdown-item" href="/mywebsite/regstration/login.php">Log in</a>
                        <?php } ?>
                    </div>



                </li>


            </ul>
        </div>
    </div>

</nav>



<script src="/mywebsite/Regstration/assets/js/core/jquery.min.js"></script>
<script src="/mywebsite/Regstration/assets/js/core/popper.min.js"></script>
<script src="/mywebsite/Regstration/assets/js/core/bootstrap-material-design.min.js"></script>
<script src="/mywebsite/Regstration/assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
<!-- Plugin for the momentJs  -->
<script src="/mywebsite/Regstration/assets/js/plugins/moment.min.js"></script>
<!--  Plugin for Sweet Alert -->
<script src="/mywebsite/Regstration/assets/js/plugins/sweetalert2.js"></script>
<!-- Forms Validations Plugin -->
<script src="/mywebsite/Regstration/assets/js/plugins/jquery.validate.min.js"></script>
<!-- Plugin for the Wizard, full documentation here: https://github.com/VinceG/twitter-bootstrap-wizard -->
<script src="/mywebsite/Regstration/assets/js/plugins/jquery.bootstrap-wizard.js"></script>
<!--	Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
<script src="/mywebsite/Regstration/assets/js/plugins/bootstrap-selectpicker.js"></script>
<!--  Plugin for the DateTimePicker, full documentation here: https://eonasdan.github.io/bootstrap-datetimepicker/ -->
<script src="/mywebsite/Regstration/assets/js/plugins/bootstrap-datetimepicker.min.js"></script>
<!--  DataTables.net Plugin, full documentation here: https://datatables.net/  -->
<script src="/mywebsite/Regstration/assets/js/plugins/jquery.dataTables.min.js"></script>
<!--	Plugin for Tags, full documentation here: https://github.com/bootstrap-tagsinput/bootstrap-tagsinputs  -->
<script src="/mywebsite/Regstration/assets/js/plugins/bootstrap-tagsinput.js"></script>
<!-- Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
<script src="/mywebsite/Regstration/assets/js/plugins/jasny-bootstrap.min.js"></script>
<!--  Full Calendar Plugin, full documentation here: https://github.com/fullcalendar/fullcalendar    -->
<script src="/mywebsite/Regstration/assets/js/plugins/fullcalendar.min.js"></script>
<!-- Vector Map plugin, full documentation here: http://jvectormap.com/documentation/ -->
<script src="/mywebsite/Regstration/assets/js/plugins/jquery-jvectormap.js"></script>
<!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
<script src="/mywebsite/Regstration/assets/js/plugins/nouislider.min.js"></script>
<!-- Include a polyfill for ES6 Promises (optional) for IE11, UC Browser and Android browser support SweetAlert -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>
<!-- Library for adding dinamically elements -->
<script src="/mywebsite/Regstration/assets/js/plugins/arrive.min.js"></script>
<!--  Google Maps Plugin    -->
<script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
<!-- Chartist JS -->
<script src="/mywebsite/Regstration/assets/js/plugins/chartist.min.js"></script>
<!--  Notifications Plugin    -->
<script src="/mywebsite/Regstration/assets/js/plugins/bootstrap-notify.js"></script>
<!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
<script src="/mywebsite/Regstration/assets/js/material-dashboard.js?v=2.1.2" type="text/javascript"></script>
<!-- Material Dashboard DEMO methods, don't include it in your project! -->
<script src="/mywebsite/Regstration/assets/demo/demo.js"></script>