<?php
require_once("../config/config.php");
require_once("../userinterface/authentfication.php");



$statement = $pdo->prepare("SELECT * FROM product where product_seller_id = ?");
$statement->execute(array($_SESSION['customer']['client_id']));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);

if(isset($_REQUEST['p_name'])){
    $statement = $pdo->prepare("SELECT * FROM product where product_seller_id = ? AND product_name=? ");
    $statement->execute(array($_SESSION['customer']['client_id'],$_REQUEST['p_name']));
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
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
                                    <p class="card-category">Here you can modify your product and view some stats about it</p>
                                </div>
                                <div class="card-body">
                                    <div>
                                        <form>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Email address</label>
                                                <input type="text" class="form-control" id="p_name" aria-describedby="emailHelp" name="p_name" placeholder="Enter product name">
                                            </div>
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </form>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead class=" text-primary">
                                                <th>
                                                    ID
                                                </th>

                                                <th>
                                                    Name
                                                </th>

                                                <th>
                                                    Actions
                                                </th>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                if($result){
                                                foreach ($result as $row) { ?>
                                                    <tr>
                                                        <td>
                                                            <?php echo $row["product_id"] ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $row["product_name"] ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $row["product_name"] ?>
                                                        </td>
                                                        <td>
                                                            <button id="showProduct" class='btn btn-primary btn-round <?php echo "p_id_" . $row["product_id"] ?> productShow' onclick="prodOpClick(this)" data-toggle="modal" data-target="#exampleModal">
                                                                <i class="material-icons">settings</i> Change product informations
                                                            </button>
                                                        </td>
                                                    </tr>
                                                <?php }}else{ ?>
                                                    <tr>
                                                    <td>
                                                    <p>No product is found</p>
                                                    </td>
                                                    </tr>
                                                <?php }?>
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

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg " role="document">
            <div class="modal-content ">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body product-modal">




                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                    <button form="productChange" type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>





</div>
<script src="../assets/js/core/jquery.min.js"></script>
<script src="../assets/js/productManagment.js"></script>
<script>
    function productChange() {
        alert("changing");
        debugger;
        var formData = new FormData(document.querySelector("#productChange"))
        for (var pair of formData.entries()) {
            if (pair[0] == "price") {
                var price = pair[1]
            } else if (pair[0] == "name") {
                var name = pair[1]
            } else if (pair[0] == "qty") {
                var qty = pair[1]
            }
        }
        debugger
        sendRequest('html', changeOptionsBackend, {
            price,
            name,
            qty
        })

        return false;
    }






    function prodOpClick(elem) {
        p_id = elem.classList[3].substr(5);
        alert(p_id);
        sendRequest('json', updateMgProductModal, {
            prodId: p_id
        });

    };





































    $(document).on('click', '.deleteValueButton', function() {
        optionName = this.parentElement.classList[1];
        optionValue = this.parentElement.classList[2];

        sendRequest('html', deleteValueBackend, {
            optionName: optionName,
            optionValue: optionValue
        }, this);
        debugger;



    });


    function addValue(elem) {
        debugger
        formData = new FormData(elem)
        debugger
        for (var pair of formData.entries()) {
            if (pair[0] == "valName") {
                var valName = pair[1]
            } else if (pair[0] == "valPrice") {
                var valPrice = pair[1]
            }
        }

        id = elem.id;
        debugger
        var table = $("table." + id).get(0).getElementsByTagName('tbody')[0];
        var row = table.insertRow(table.rows.length - 1);
        debugger
        row.innerHTML =
            `
        <td class="text-center">
        ${valName} : ${valPrice}
        </td>
        `;
        optionName = elem.id
        debugger

        sendRequest('html', addValueBackend, {
            optionName: optionName,
            valName: valName,
            valPrice: valPrice
        });
        return false;
    }
</script>