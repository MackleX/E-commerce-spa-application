<?php
require_once("../config/config.php");
require_once("../userinterface/authentfication.php");



$statement = $pdo->prepare("SELECT * FROM payment_details where seller_id = ?");
$statement->execute(array($_SESSION['customer']['client_id']));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);

if(isset($_REQUEST['id']) && isset($_REQUEST['name'])){
    
$statement = $pdo->prepare("UPDATE payment_details SET product_shipping_status=? where seller_id = ? AND payment_detail_id=? AND product_name=?");
$statement->execute(array($_REQUEST['status'],$_SESSION['customer']['client_id'],$_REQUEST['id'],$_REQUEST['name']));

}
?>



<div class="page">
    <div class="wrapper">

        <div class="sidebar " data-color="purple" data-background-color="white">

            <?php require_once('./client-sidebar.php'); ?>

        </div>

        <div class="main-panel">


            <?php require_once('../CROSSPAGESELEMENTS/nav-bar.php'); ?>

            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-header-primary">
                                    <h4 class="card-title ">Product management</h4>
                                    <p class="card-category"> Here you can modify your product and view some stats about it</p>
                                </div>
                                <div class="card-body">

                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead class=" text-primary">
                                                <th>
                                                    Buyed product name
                                                </th>

                                                <th>
                                                    Quantity
                                                </th>

                                                <th>
                                                    Choosed options
                                                </th>

                                                <th>
                                                    product shipping status
                                                </th>
                                                <th>
                                                    Shipped adresse
                                                </th>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if ($result) {
                                                    foreach ($result as $row) { ?>
                                                        <tr>
                                                            <td>
                                                                <?php echo $row["product_name"] ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $row["product_buyed_quantity"] ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $row["product_chosen_options"] ?>
                                                            </td>
                                                            <td>
                                                                <select id="status" class="<?php echo $row["payment_detail_id"]?>" onchange="myFunction(this,'<?php echo $row['product_name'] ?>')">
                                                                    <option value="<?php echo $row["product_shipping_status"] ?>" selected><?php echo $row["product_shipping_status"] ?></option>
                                                                    <option value="On traitemant">On traitemant</option>
                                                                    <option value="Shipped">Shipped</option>
                                                                    <option value="Sent">Sent</option> 
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <?php echo $row["Shipping adresse"] ?>
                                                            </td>
                                                        </tr>
                                                    <?php }
                                                } else { ?>
                                                    <tr>
                                                        <td>
                                                            <p>No product is found</p>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>



    </div>





</div>
<script src="../assets/js/core/jquery.min.js"></script>
<script>
function myFunction(elem,str){
    id = elem.classList[0]
    name = str
    var status = document.getElementById("status").value;
    $.ajax({
        type: 'POST',
        url: '../userpanel/productstatusmanagement.php',
        dataType: 'html',
        data: {id,name,status},
        success: function (data) {
            debugger;
        },
        error: function (data) {

            debugger;

        }
    })
}

</script>