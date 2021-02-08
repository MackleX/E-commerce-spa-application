<script src="https://use.fontawesome.com/84f86b1832.js"></script>



<?php
require_once("../config/config.php");
// Check if the customer is logged in or not
require_once("../userinterface/authentfication.php");
?>


<?php

require_once "../assets/bulletproof-master/bulletproof.php";
    require "../assets/bulletproof-master/utils/func.image-resize.php";

    $image = new Bulletproof\Image($_FILES);


    if (isset($_FILES["pictures"])) {
        $image = new Bulletproof\Image($_FILES["pictures"]);
        $image->setName($_SESSION['customer']['client_id'])
        ->setLocation("../assets/images/users");
      
        if ($image->upload()) {           //upload succeed?
          bulletproof\utils\resize(     //you are still playing with $image
            $image->getFullPath(),
            $image->getMime(),
            $image->getWidth(),
            $image->getHeight(),
            190,
            175
          );

          $type = $image->getMime();

          $statement = $pdo->prepare("UPDATE client SET photo_name = ? WHERE client_id = ?");
          $statement->execute(array($_SESSION['customer']['client_id'].".".$type,$_SESSION['customer']['client_id']));
          $_SESSION['customer']['photo_name'] = $_SESSION['customer']['client_id'].".".$type;
        }else{
            $statement = $pdo->prepare("UPDATE client SET photo_name = ? WHERE client_id = ?");
            $statement->execute(array("default.jpeg",$_SESSION['customer']['client_id']));
            $_SESSION['customer']['photo_name'] = "default.jpeg";
        }

    
    }

if (isset($_POST['form1'])) {   


        $valid = 1;
    if (empty($_POST['client_name'])) {
        $valid = 0;
        $error_message .= "name is empty" . "<br>";
    }

    if (empty($_POST['client_phone'])) {
        $valid = 0;
        $error_message .= "phone is empty" . "<br>";
    }

    if (empty($_POST['client_address'])) {
        $valid = 0;
        $error_message .= "adresse not valid" . "<br>";
    }

    if (empty($_POST['client_country'])) {
        $valid = 0;
        $error_message .= "client is empty" . "<br>";
    }

    if (empty($_POST['client_city'])) {
        $valid = 0;
        $error_message .= "city is empty" . "<br>";
    }

    if (empty($_POST['client_state'])) {
        $valid = 0;
        $error_message .= "state is empty" . "<br>";
    }

    if (empty($_POST['client_zip'])) {
        $valid = 0;
        $error_message .= "zip is empty" . "<br>";
    }

    if ($valid == 1) {

        // update data into the database
        $statement = $pdo->prepare("UPDATE client SET client_name=?, client_cname=?, client_phone=?, client_country=?, client_address=?, client_city=?, client_state=?, client_zip=? WHERE client_id=?");
        $statement->execute(array(
            strip_tags($_POST['client_name']),
            strip_tags($_POST['client_cname']),
            strip_tags($_POST['client_phone']),
            strip_tags($_POST['client_country']),
            strip_tags($_POST['client_address']),
            strip_tags($_POST['client_city']),
            strip_tags($_POST['client_state']),
            strip_tags($_POST['client_zip']),
            $_SESSION['customer']['client_id']
        ));

        $success_message = "Changes are applied";

        $_SESSION['customer']['client_name'] = $_POST['client_name'];
        $_SESSION['customer']['client_cname'] = $_POST['client_cname'];
        $_SESSION['customer']['client_phone'] = $_POST['client_phone'];
        $_SESSION['customer']['client_country'] = $_POST['client_country'];
        $_SESSION['customer']['client_address'] = $_POST['client_address'];
        $_SESSION['customer']['client_city'] = $_POST['client_city'];
        $_SESSION['customer']['client_state'] = $_POST['client_state'];
        $_SESSION['customer']['client_zip'] = $_POST['client_zip'];
    }
}


if (isset($_POST['form2'])) {


    // update data into the database
    $statement = $pdo->prepare("UPDATE client SET 
                            client_s_phone=?, 
                            client_s_country=?, 
                            client_s_address=?, 
                            client_s_city=?, 
                            client_s_state=?, 
                            client_s_zip=? 

                            WHERE client_id=?");
    $statement->execute(array(
        strip_tags($_POST['client_phone']),
        strip_tags($_POST['client_country']),
        strip_tags($_POST['client_address']),
        strip_tags($_POST['client_city']),
        strip_tags($_POST['client_state']),
        strip_tags($_POST['client_zip']),
        $_SESSION['customer']['client_id']
    ));

    $success_message = "changes are applied";

    $_SESSION['customer']['client_s_phone'] = strip_tags($_POST['client_phone']);
    $_SESSION['customer']['client_s_country'] = strip_tags($_POST['client_country']);
    $_SESSION['customer']['client_s_address'] = strip_tags($_POST['client_address']);
    $_SESSION['customer']['client_s_city'] = strip_tags($_POST['client_city']);
    $_SESSION['customer']['client_s_state'] = strip_tags($_POST['client_state']);
    $_SESSION['customer']['client_s_zip'] = strip_tags($_POST['client_zip']);
} {
    
    $adjacents = 5;

    $statement = $pdo->prepare("SELECT * FROM payment WHERE customer_id=? ORDER BY id DESC");
    $statement->execute(array($_SESSION['customer']['client_id']));
    $total_pages = $statement->rowCount();

    $targetpage = '../userpanel/client-profile-update.php';

    echo $targetpage;


    $limit = 5;
    if(isset($_GET['page'])){
    $page = $_GET['page'];
    }else{
        $page = 1;
    }

    if ($page)
        $start = ($page - 1) * $limit;
    else
        $start = 0;


    $statement = $pdo->prepare("SELECT * FROM payment_details JOIN payment ON payment_id = id WHERE customer_id=? ORDER BY payment_id DESC LIMIT $start, $limit");
    $statement->execute(array($_SESSION['customer']['client_id']));
    $resultofpayment = $statement->fetchAll(PDO::FETCH_ASSOC);

    if ($page == 0) $page = 1;
    $prev = $page - 1;
    $next = $page + 1;
    $lastpage = ceil($total_pages / $limit);
    $lpm1 = $lastpage - 1;
    $pagination = "";
    if ($lastpage > 1) {
        $pagination .= "<div class=\"pagination\">";
        if ($page > 1)
            $pagination .= "<a href=\"$targetpage?page=$prev\">&#171; previous</a>";
        else
            $pagination .= "<span class=\"disabled\">&#171; previous</span>";
        if ($lastpage < 7 + ($adjacents * 2)) {
            for ($counter = 1; $counter <= $lastpage; $counter++) {
                if ($counter == $page)
                    $pagination .= "<span class=\"current\">$counter</span>";
                else
                    $pagination .= "<a href=\"$targetpage?page=$counter\">$counter</a>";
            }
        } elseif ($lastpage > 5 + ($adjacents * 2)) {
            if ($page < 1 + ($adjacents * 2)) {
                for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {
                    if ($counter == $page)
                        $pagination .= "<span class=\"current\">$counter</span>";
                    else
                        $pagination .= "<a href=\"$targetpage?page=$counter\">$counter</a>";
                }
                $pagination .= "...";
                $pagination .= "<a href=\"$targetpage?page=$lpm1\">$lpm1</a>";
                $pagination .= "<a href=\"$targetpage?page=$lastpage\">$lastpage</a>";
            } elseif ($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
                $pagination .= "<a href=\"$targetpage?page=1\">1</a>";
                $pagination .= "<a href=\"$targetpage?page=2\">2</a>";
                $pagination .= "...";
                for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
                    if ($counter == $page)
                        $pagination .= "<span class=\"current\">$counter</span>";
                    else
                        $pagination .= "<a href=\"$targetpage?page=$counter\">$counter</a>";
                }
                $pagination .= "...";
                $pagination .= "<a href=\"$targetpage?page=$lpm1\">$lpm1</a>";
                $pagination .= "<a href=\"$targetpage?page=$lastpage\">$lastpage</a>";
            } else {
                $pagination .= "<a href=\"$targetpage?page=1\">1</a>";
                $pagination .= "<a href=\"$targetpage?page=2\">2</a>";
                $pagination .= "...";
                for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
                    if ($counter == $page)
                        $pagination .= "<span class=\"current\">$counter</span>";
                    else
                        $pagination .= "<a href=\"$targetpage?page=$counter\">$counter</a>";
                }
            }
        }
        if ($page < $counter - 1)
            $pagination .= "<a href=\"$targetpage?page=$next\">next &#187;</a>";
        else
            $pagination .= "<span class=\"disabled\">next &#187;</span>";
        $pagination .= "</div>\n";
    }
}



?>

<body class="">
    <div class="wrapper ">

        <div class="sidebar" data-color="purple" data-background-color="white">

            <?php require_once('../USERPANEL/client-sidebar.php'); ?>

        </div>


        <div class="main-panel">

            <?php require_once('../CROSSPAGESELEMENTS/nav-bar.php'); ?>

            <div class="content">
                <div class="container-fluid">
                    <div class="row">

                        <div class="card col-md-9">

                            <div class="card-header card-header-tabs card-header-primary">
                        
                                <div class="nav-tabs-navigation">

                                    <div class="nav-tabs-wrapper">

                                        <span class="nav-tabs-title">Change Info:</span>

                                        <ul class="nav nav-tabs" data-tabs="tabs">

                                            <li class="nav-item">

                                                <a class="nav-link" href="#user_info" data-toggle="tab">
                                                    <i class="material-icons">cloud</i>User Informations
                                                    <div class="ripple-container"></div>
                                                </a>

                                            </li>


                                            <li class="nav-item">
                                                <a class="nav-link" href="#shipping_info" data-toggle="tab">
                                                    <i class="material-icons">cloud</i> Shipping Informations
                                                    <div class="ripple-container"></div>
                                                </a>
                                            </li>


                                            </li>

                                            <li class="nav-item">
                                                <a class="nav-link active" href="#user-commands-info" data-toggle="tab">
                                                    <i class="material-icons">cloud</i> My Commands
                                                    <div class="ripple-container"></div>
                                                </a>
                                            </li>



                                        </ul>
                                    </div>
                                </div>
                            </div>


                            <div class="card-body">
                                <div class="tab-content">

                                    <div class="tab-pane" id="user_info">
                                        <form id="form1" action="./client-profile-update.php" method="post">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="bmd-label-floating">User name</label>
                                                        <input type="text" class="form-control" name="client_name" value="<?php echo $_SESSION['customer']['client_name']; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="bmd-label-floating">Company name</label>
                                                        <input type="text" class="form-control" name="client_cname" value="<?php echo $_SESSION['customer']['client_cname']; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="bmd-label-floating">E-mail</label>
                                                        <input type="text" class="form-control" name="client_email" value="<?php echo $_SESSION['customer']['client_email']; ?>" disabled>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="bmd-label-floating">Phone number</label>
                                                        <input type="text" class="form-control" name="client_phone" value="<?php echo $_SESSION['customer']['client_phone']; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="bmd-label-floating">State *</label>
                                                        <input type="text" class="form-control" name="client_state" value="<?php echo $_SESSION['customer']['client_state']; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="bmd-label-floating">City*</label>
                                                        <input type="text" class="form-control" name="client_city" value="<?php echo $_SESSION['customer']['client_city']; ?>">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <label class="bmd-label-floating" style="margin:auto;">Adresse *</label>
                                                        <textarea name="client_address" class="form-control" cols="30" rows="10" style="height:70px;"><?php echo $_SESSION['customer']['client_address']; ?></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                    <label class="bmd-label-floating">County *</label>
                                                    <input type="text" class="form-control" name="client_country" value="<?php echo $_SESSION['customer']['client_country']; ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">


                                                <div class="col-md-11">
                                                    <div class="form-group">
                                                        <label class="bmd-label-floating">Zip Postale *</label>
                                                        <input type="text" class="form-control" name="client_zip" value="<?php echo $_SESSION['customer']['client_zip']; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <input type="submit" class="btn btn-primary pull-right" value="Change" name="form1">
                                                    <div class="clearfix"></div>

                                                </div>

                                            </div>
                                        </form>
                                    </div>

                                    <div class="tab-pane" id="shipping_info">
                                        <form action="" method="post">


                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="bmd-label-floating">Phone number for shipping</label>
                                                        <input type="text" class="form-control" name="client_phone" value="<?php echo $_SESSION['customer']['client_s_phone']; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="bmd-label-floating">State for shipping*</label>
                                                        <input type="text" class="form-control" name="client_state" value="<?php echo $_SESSION['customer']['client_s_state']; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="bmd-label-floating">City for shipping*</label>
                                                        <input type="text" class="form-control" name="client_city" value="<?php echo $_SESSION['customer']['client_s_city']; ?>">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <label class="bmd-label-floating" style="margin:auto;">Adresse for shipping *</label>
                                                        <textarea name="client_address" class="form-control" cols="30" rows="10" style="height:70px;"><?php echo $_SESSION['customer']['client_s_address']; ?></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                <div class="form-group">
                                                        <label class="bmd-label-floating" style="margin:auto;">Country *</label>
                                                        <textarea name="client_country" class="form-control" cols="30" rows="10" style="height:70px;"><?php echo $_SESSION['customer']['client_s_country']; ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">


                                                <div class="col-md-11">
                                                    <div class="form-group">
                                                        <label class="bmd-label-floating">Zip Postale for shipping*</label>
                                                        <input type="text" class="form-control" name="client_zip" value="<?php echo $_SESSION['customer']['client_s_zip']; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <input type="submit" class="btn btn-primary pull-right" value="Change" name="form2">
                                                    <div class="clearfix"></div>

                                                </div>

                                            </div>
                                        </form>
                                    </div>


                                    <div class="tab-pane active" id="user-commands-info">

                                        <div class="col-lg-12 col-md-12">
                                            <div class="card">
                                                <div class="card-header card-header-warning">
                                                    <h4 class="card-title">Commands informations</h4>
                                                </div>
                                                <div class="card-body table-responsive">
                                                    <table class="table table-hover">

                                                        <thead class="text-warning">
                                                            <th>Serial</th>
                                                            <th>Payment date</th>
                                                            <th>Buyed Quantity</th>
                                                            <th>Chosen options</th>
                                                            <th>Total Price</th>
                                                            <th>Demande status</th>
                                                            <th>Seller profile</th>
                                                        </thead>

                                                        <tbody>

                                                            <?php
                                                            $tip = ($page * $limit) - $limit;
                                                            foreach ($resultofpayment as $row) {
                                                                $tip++;
                                                            ?>
                                                                <tr>
                                                                    <td><?php echo $tip ?></td>
                                                                    <td><?php echo $row['product_name']; ?></td>
                                                                    <td><?php echo $row['product_buyed_quantity'] ; ?></td>
                                                                    <td><?php echo $row['product_chosen_options']; ?></td>
                                                                    <td><?php echo $row['product_total_price']. " Dh"; ?></td>
                                                                    <td><?php echo $row['product_shipping_status']; ?></td>

                                                                    <td><a href="../profile/profile_container.php?id=<?php echo $row["seller_id"]?>">Seller</a></td>
                                                                </tr>
                                                            <?php } ?>

                                                        </tbody>
                                                    </table>
                                                    <div class="pagination" style="overflow: hidden;">
                                                        <?php
                                                        echo $pagination;
                                                        ?>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>














                        </div>




                        <div class="col-md-3">

                            <div class="card card-profile">
                                <div class="card-header card-header-primary" style="z-index:1;">


                                    <div class="card-avatar" style="position:relative; z-index:999;">
                                        <label for="updatePic" style="cursor: pointer;">
                                            <a>


                                                <img class="img" src="../assets/images/users/<?php echo $_SESSION['customer']['photo_name'] ?>" style="display:block;" />

                                                <i class="fas fa-camera" style="position:absolute; top:80%; left:45%; color:blueviolet;text-align:center; transition:all 0.5s; " onmouseover="
                                            this.style.fontSize ='20px';
            
                         
                                    " onmouseout="
                          this.style.fontSize ='15px' "></i>


                                    </div>
                                    </a>
                                    </label>

                                    <form id="uploadform" method="POST" enctype="multipart/form-data" style="display:none;">

                                        <input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
                                        <input id="updatePic" type="file" onchange="autoUpload()" name="pictures" accept="image/*" />
                                        <input type="submit" value="upload" />

                                    </form>




                                </div>
                                <div class="card-body">
                                    <h6 class="card-category text-gray">Seller</h6>
                                    <h4 class="card-title"><?php echo $_SESSION['customer']['client_name'] ?></h4>
                                    <p class="card-description">
                                        <?php echo $_SESSION['customer']['description'] ?>
                                    </p>
                                    <a href="javascript:;" class="btn btn-primary btn-round">Follow</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>











    <!--   Core JS Files   -->
    <script src="../assets/js/core/jquery.min.js"></script>
    <script src="../assets/js/core/popper.min.js"></script>
    <script src="../assets/js/core/bootstrap-material-design.min.js"></script>
    <script src="../assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
    <!-- Plugin for the momentJs  -->
    <script src="../assets/js/plugins/moment.min.js"></script>
    <!--  Plugin for Sweet Alert -->
    <script src="../assets/js/plugins/sweetalert2.js"></script>
    <!-- Forms Validations Plugin -->
    <script src="../assets/js/plugins/jquery.validate.min.js"></script>
    <!-- Plugin for the Wizard, full documentation here: https://github.com/VinceG/twitter-bootstrap-wizard -->
    <script src="../assets/js/plugins/jquery.bootstrap-wizard.js"></script>
    <!--	Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
    <script src="../assets/js/plugins/bootstrap-selectpicker.js"></script>
    <!--  Plugin for the DateTimePicker, full documentation here: https://eonasdan.github.io/bootstrap-datetimepicker/ -->
    <script src="../assets/js/plugins/bootstrap-datetimepicker.min.js"></script>
    <!--  DataTables.net Plugin, full documentation here: https://datatables.net/  -->
    <script src="../assets/js/plugins/jquery.dataTables.min.js"></script>
    <!--	Plugin for Tags, full documentation here: https://github.com/bootstrap-tagsinput/bootstrap-tagsinputs  -->
    <script src="../assets/js/plugins/bootstrap-tagsinput.js"></script>
    <!-- Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
    <script src="../assets/js/plugins/jasny-bootstrap.min.js"></script>
    <!--  Full Calendar Plugin, full documentation here: https://github.com/fullcalendar/fullcalendar    -->
    <script src="../assets/js/plugins/fullcalendar.min.js"></script>
    <!-- Vector Map plugin, full documentation here: http://jvectormap.com/documentation/ -->
    <script src="../assets/js/plugins/jquery-jvectormap.js"></script>
    <!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
    <script src="../assets/js/plugins/nouislider.min.js"></script>
    <!-- Include a polyfill for ES6 Promises (optional) for IE11, UC Browser and Android browser support SweetAlert -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>
    <!-- Library for adding dinamically elements -->
    <script src="../assets/js/plugins/arrive.min.js"></script>
    <!--  Google Maps Plugin    -->
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
    <!-- Chartist JS -->
    <script src="../assets/js/plugins/chartist.min.js"></script>
    <!--  Notifications Plugin    -->
    <script src="../assets/js/plugins/bootstrap-notify.js"></script>
    <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="../assets/js/material-dashboard.js?v=2.1.2" type="text/javascript"></script>


    <script>
        function autoUpload() {
            document.getElementById("uploadform").submit();
        }
        $(document).ready(function() {
            $().ready(function() {
                $sidebar = $('.sidebar');

                $sidebar_img_container = $sidebar.find('.sidebar-background');

                $full_page = $('.full-page');

                $sidebar_responsive = $('body > .navbar-collapse');

                window_width = $(window).width();

                fixed_plugin_open = $('.sidebar .sidebar-wrapper .nav li.active a p').html();

                if (window_width > 767 && fixed_plugin_open == 'Dashboard') {
                    if ($('.fixed-plugin .dropdown').hasClass('show-dropdown')) {
                        $('.fixed-plugin .dropdown').addClass('open');
                    }

                }

                $('.fixed-plugin a').click(function(event) {
                    // Alex if we click on switch, stop propagation of the event, so the dropdown will not be hide, otherwise we set the  section active
                    if ($(this).hasClass('switch-trigger')) {
                        if (event.stopPropagation) {
                            event.stopPropagation();
                        } else if (window.event) {
                            window.event.cancelBubble = true;
                        }
                    }
                });

                $('.fixed-plugin .active-color span').click(function() {
                    $full_page_background = $('.full-page-background');

                    $(this).siblings().removeClass('active');
                    $(this).addClass('active');

                    var new_color = $(this).data('color');

                    if ($sidebar.length != 0) {
                        $sidebar.attr('data-color', new_color);
                    }

                    if ($full_page.length != 0) {
                        $full_page.attr('filter-color', new_color);
                    }

                    if ($sidebar_responsive.length != 0) {
                        $sidebar_responsive.attr('data-color', new_color);
                    }
                });

                $('.fixed-plugin .background-color .badge').click(function() {
                    $(this).siblings().removeClass('active');
                    $(this).addClass('active');

                    var new_color = $(this).data('background-color');

                    if ($sidebar.length != 0) {
                        $sidebar.attr('data-background-color', new_color);
                    }
                });

                $('.fixed-plugin .img-holder').click(function() {
                    $full_page_background = $('.full-page-background');

                    $(this).parent('li').siblings().removeClass('active');
                    $(this).parent('li').addClass('active');


                    var new_image = $(this).find("img").attr('src');

                    if ($sidebar_img_container.length != 0 && $('.switch-sidebar-image input:checked').length != 0) {
                        $sidebar_img_container.fadeOut('fast', function() {
                            $sidebar_img_container.css('background-image', 'url("' + new_image + '")');
                            $sidebar_img_container.fadeIn('fast');
                        });
                    }

                    if ($full_page_background.length != 0 && $('.switch-sidebar-image input:checked').length != 0) {
                        var new_image_full_page = $('.fixed-plugin li.active .img-holder').find('img').data('src');

                        $full_page_background.fadeOut('fast', function() {
                            $full_page_background.css('background-image', 'url("' + new_image_full_page + '")');
                            $full_page_background.fadeIn('fast');
                        });
                    }

                    if ($('.switch-sidebar-image input:checked').length == 0) {
                        var new_image = $('.fixed-plugin li.active .img-holder').find("img").attr('src');
                        var new_image_full_page = $('.fixed-plugin li.active .img-holder').find('img').data('src');

                        $sidebar_img_container.css('background-image', 'url("' + new_image + '")');
                        $full_page_background.css('background-image', 'url("' + new_image_full_page + '")');
                    }

                    if ($sidebar_responsive.length != 0) {
                        $sidebar_responsive.css('background-image', 'url("' + new_image + '")');
                    }
                });

                $('.switch-sidebar-image input').change(function() {
                    $full_page_background = $('.full-page-background');

                    $input = $(this);

                    if ($input.is(':checked')) {
                        if ($sidebar_img_container.length != 0) {
                            $sidebar_img_container.fadeIn('fast');
                            $sidebar.attr('data-image', '#');
                        }

                        if ($full_page_background.length != 0) {
                            $full_page_background.fadeIn('fast');
                            $full_page.attr('data-image', '#');
                        }

                        background_image = true;
                    } else {
                        if ($sidebar_img_container.length != 0) {
                            $sidebar.removeAttr('data-image');
                            $sidebar_img_container.fadeOut('fast');
                        }

                        if ($full_page_background.length != 0) {
                            $full_page.removeAttr('data-image', '#');
                            $full_page_background.fadeOut('fast');
                        }

                        background_image = false;
                    }
                });

                $('.switch-sidebar-mini input').change(function() {
                    $body = $('body');

                    $input = $(this);

                    if (md.misc.sidebar_mini_active == true) {
                        $('body').removeClass('sidebar-mini');
                        md.misc.sidebar_mini_active = false;

                        $('.sidebar .sidebar-wrapper, .main-panel').perfectScrollbar();

                    } else {

                        $('.sidebar .sidebar-wrapper, .main-panel').perfectScrollbar('destroy');

                        setTimeout(function() {
                            $('body').addClass('sidebar-mini');

                            md.misc.sidebar_mini_active = true;
                        }, 300);
                    }

                    // we simulate the window Resize so the charts will get updated in realtime.
                    var simulateWindowResize = setInterval(function() {
                        window.dispatchEvent(new Event('resize'));
                    }, 180);

                    // we stop the simulation of Window Resize after the animations are completed
                    setTimeout(function() {
                        clearInterval(simulateWindowResize);
                    }, 1000);

                });
            });
        });
    </script>
</body>

</html>