<?php
require_once("../config/config.php");
require_once("../USERINTERFACE/authentfication.php")
?>

<?php
if (isset($_REQUEST['index'])) {
    $index = $_REQUEST['index'];
    unset($_SESSION["cart_items"][$index]);
?>

    <?php if (isset($_SESSION["cart_items"])) {

        $_SESSION["cart_items"] = array_values($_SESSION["cart_items"]);
        $_SESSION["items_to_buy"] = $_SESSION["cart_items"];

        foreach ($_SESSION["cart_items"] as $index => $productRow) { ?>

            <tr>
                <td>
                    <?php echo $index + 1; ?>
                </td>
                <td>
                    <?php echo $productRow['product_name']; ?>
                </td>
                <td>
                    photo here later
                </td>
                <td>
                    <?php foreach ($productRow['options'] as $optionName => $optionValue) {
                        if ($optionName != "buyProduct") {
                            echo $optionName . ": " . $optionValue . "<br />";
                        }
                    ?>
                    <?php } ?>
                </td>
                <td>
                    <?php echo $productRow['quantity']; ?>
                </td>
                <td>
                    <?php echo $productRow['totalprice'] . "Dh"; ?>
                </td>
                <td>
                    <i class="material-icons <?php echo $index ?>" onclick="removeCart(this)">remove_shopping_cart</i>
                </td>

            </tr>
        <?php }
    } else {  ?>
        <tr class="warning">
            <p class="text-warning"> NO ELEMENT IS SELECTED</p>

        </tr>
    <?php } ?>


<?php

} else {
?>

    <div>
        <div class="page">
            <div class="wrapper">

                <div class="sidebar " data-color="purple" data-background-color="white">

                    <?php require_once('../USERPANEL/client-sidebar.php'); ?>

                </div>

                <div class="main-panel">


                    <?php require_once('../CROSSPAGESELEMENTS/nav-bar.php'); ?>

                    <div class="content">

                        <div class="container-fluid">
                            <div class="row my_content">
                                <div class="col-md-12">
                                    <div class="card card-plain">

                                        <div class="card-header card-header-primary">
                                            <h4 class="card-title mt-0"> Customer cart </h4>
                                            <p class="card-category"> Go ahead and parchause dont be a morron </p>
                                        </div>

                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-hover my_content_table">
                                                    <thead class="">
                                                        <th>
                                                            Serial
                                                        </th>
                                                        <th>
                                                            Product name
                                                        </th>
                                                        <th>
                                                            Product photo
                                                        </th>
                                                        <th>
                                                            Product options
                                                        </th>
                                                        <th>
                                                            Quantity
                                                        </th>
                                                        <th>
                                                            Total Price
                                                        </th>
                                                    </thead>
                                                    <tbody class="my_contentx">
                                                        <?php if (isset($_SESSION["cart_items"])) {

                                                            $_SESSION["cart_items"] = array_values($_SESSION["cart_items"]);
                                                            $_SESSION["items_to_buy"] = $_SESSION["cart_items"];

                                                            foreach ($_SESSION["cart_items"] as $index => $productRow) { ?>

                                                                <tr>
                                                                    <td>
                                                                        <?php echo $index + 1; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo $productRow['product_name']; ?>
                                                                    </td>
                                                                    <td>
                                                                        photo here later
                                                                    </td>
                                                                    <td>
                                                                        <?php foreach ($productRow['options'] as $optionName => $optionValue) {
                                                                            if ($optionName != "buyProduct") {
                                                                                echo $optionName . ": " . $optionValue . "<br />";
                                                                            }
                                                                        ?>
                                                                        <?php } ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo $productRow['quantity']; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo $productRow['totalprice'] . "Dh"; ?>
                                                                    </td>
                                                                    <td>
                                                                        <i class="material-icons <?php echo $index ?>" onclick="removeCart(this)">remove_shopping_cart</i>
                                                                    </td>

                                                                </tr>
                                                            <?php }
                                                        } else {  ?>
                                                            <tr class="warning">
                                                                <p class="text-warning"> NO ELEMENT IS SELECTED</p>

                                                            </tr>
                                                        <?php } ?>

                                                    </tbody>
                                                </table>

                                                <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#exampleModalLong">
                                                    Make Parchause
                                                </button>

                                                <?php
                                                $cartRequest = true;
                                                require_once('../payment/payment-modal.php');
                                                ?>



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
    <?php } ?>
    <script>
        function removeCart(element) {
            console.log(element)

            $.ajax({
                type: "POST",
                url: "../KART/client-cart.php",
                data: {
                    index: element.classList[1]
                },

                success: function(msg) {
                    console.log(msg);
                    $(".my_contentx").get(0).innerHTML = msg;
                },
                error: function(msg) {
                    alert("Something Went Wrong")

                }
            })


        }
    </script>

    </div>