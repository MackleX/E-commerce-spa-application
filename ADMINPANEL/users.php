<?php



require_once("../config/config.php");



    if(isset($_REQUEST['client_id'])){
        $clientId = $_REQUEST['client_id'];
        $status = $_REQUEST['status'];



        $statement = $pdo->prepare("update client set client_status=? where client_id= ?"); 
        $statement->execute(array($status,$clientId));

        ob_clean();
        echo "SUCCESS";
        exit;
    }  
    if(isset($_POST['search'])){
        $valueToSearch = $_POST['valueToSearch'];
        // search in all table columns
        
        $query = "SELECT * FROM client WHERE CONCAT(`client_id`, `client_name`, `client_address`, `client_email`) LIKE '%".$valueToSearch."%'";
        
    
    }
    else {
        $query = "SELECT * FROM client";
        
        }


?>

<head>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <style>
        td,
        th {
            border: 1px solid rgb(190, 190, 190);
            padding: 10px;
        }

        td {
            text-align: center;
        }

        tr:nth-child(even) {
            background-color: #eee;
        }

        th[scope="col"] {
            background-color: #696969;
            color: #fff;
        }

        th[scope="row"] {
            background-color: #d7d9f2;
        }

        caption {
            padding: 10px;
            caption-side: bottom;
        }

        table {
            border-collapse: collapse;
            border: 2px solid rgb(200, 200, 200);
            letter-spacing: 1px;
            font-family: sans-serif;
            font-size: .8rem;
        }
        input[type=text] {
        float: right;
        padding: 6px;
        border: none;
        margin-top: 8px;
        margin-right: 16px;
        font-size: 17px;
        }
        .formSearch{
            display:flex;
            justify-content:center;  
            position:relative;
            right:100px;
        }
        .abs{
            position:absolute;
            left:200px;
        }
        
    </style>

</head>



<body class="">

    <div class="wrapper ">
    <div class="sidebar " data-color="purple" data-background-color="white">

<?php require_once('sidebar.php'); ?>

</div>



        <div class="main-panel">
        <?php require_once('nav-bar.php'); ?>


            <div class="content">

                <div class="container-fluid">
                    <div class="formSearch">
                    <form action="users.php" method="post" class="formSearch">
                    <input type="text" name="valueToSearch" placeholder="Search a user" class="form-control rounded" >
                    <div class="abs"><input class="btn btn-outline-primary" type="submit" name="search" value="Filter"></div>
                    </div>
                    

                    <table class="">
                        <caption style="text-align : center">Liste des utilisateurs</caption>
                        <tr>
                            <th scope="col" class="text-center">Seller id</th>
                            <th scope="col" class="text-center">Seller name</th>
                            <th scope="col" class="text-center">Seller mail</th>
                            <th scope="col" class="text-center">Seller adress</th>
                            <th scope="col" class="text-center">Ammout sold items</th>
                            <th scope="col" class="text-center">Total reports number</th>
                            <th scope="col" class="text-center">Seller status</th>

                        </tr>


                        <?php
                        $statement = $pdo->prepare($query);
                        $statement->execute();
                        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($result as $row) {

                            $buyedProduct = 0;
                            $reportedTimes = 0;

                            $statement = $pdo->prepare("SELECT product_buyed_quantity FROM payment_details WHERE seller_id=? ");
                            $statement->execute(array($row['client_id']));
                            $Result = $statement->fetchAll(PDO::FETCH_ASSOC);


                            foreach ($Result as $roww) {
                                $buyedProduct += $roww['product_buyed_quantity'];
                            }


                            $statement = $pdo->prepare("SELECT count(*) FROM reports WHERE reported_item_id=? AND reported_item_type = '0' ");
                            $statement->execute(array($row['client_id']));
                            $result1 = $statement->fetchColumn();
                            if ($result1) {
                                $reportedTimes = $result1;
                            }

                            $row['reported_times'] = $reportedTimes;
                            $row['selled_item_count'] = $buyedProduct;
                            ?>
                            <tr><th scope="row" style="text-align:center"  ><?php   echo$row['client_id'] ;?></td>
                            <td  ><?php   echo$row['client_name'] ;?></td>
                            <td  ><?php   echo$row['client_email'] ;?></td>
                            <td  ><?php   echo$row['client_address'] ;?></td>
                            <td  ><?php   echo$row['selled_item_count'] ;?></td>
                            <td  ><?php   echo$row['reported_times'] ;?></td>
                            <td>
                              <?php      


                            if ($row['client_status'] == 0) {
                             ?>

                             <a class='statusButton btn btn-success _<?php echo $row['client_id'] ?>' onclick="stateChange(true,this)">Enable</a>

                            <?php

                            } else {

                            ?>

                                <a class='statusButton btn btn-danger _<?php echo $row['client_id'] ?>' onclick="stateChange(false,this)">Disable</a>

                        <?php

                            }




                            echo "</td></tr>";
                        }

                        ?>













                    </table>









                </div>



            </div>




        </div>


    </div>



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
    <script src="./../assets/js/plugins/bootstrap-tagsinput.js"></script>
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
    <!-- Chartist JS -->
    <script src="../assets/js/plugins/chartist.min.js"></script>
    <!--  Notifications Plugin    -->
    <script src="../assets/js/plugins/bootstrap-notify.js"></script>
    <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="../assets/js/material-dashboard.js?v=2.1.2" type="text/javascript"></script>
    <!-- Material Dashboard DEMO methods, don't include it in your project! -->
    <script src="../Regstration/assets/demo/demo.js"></script>





    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
    <!-- Material Kit CSS -->
    <link href="../assets/css/material-dashboard.css?v=2.1.2" rel="stylesheet" />


    <script>
        function stateChange(isEnabled, elem) {
            client_id = elem.classList[3].substr(1);

            if (isEnabled) {
                sendObject = {
                    client_id: client_id,
                    status: 0
                }
            } else {
                sendObject = {
                    client_id: client_id,
                    status: 1
                }
            }


            $.ajax({
                type: 'POST',
                url: 'users.php',
                dataType: 'html',
                data: sendObject,
                success: function(data) {
                    debugger
                    if(data == "SUCCESS"){ 
                        if(isEnabled){
                        elem.innerHTML = "Disable"
                        elem.setAttribute('onclick','stateChange(false,this)')
                        elem.classList.remove("btn-success");
                        elem.classList.add("btn-danger");

                        }else{
                        elem.innerHTML = "Enable"
           

                        elem.classList.remove("btn-danger");
                        elem.classList.add("btn-success");
                        elem.setAttribute('onclick','stateChange(true,this)')
                        }
                    }else{
                        alert("error in php");
                    }
                    
                },
                error: function(data) {
                    alert("error on request")
                    debugger;

                }
            })


        }
    </script>
    