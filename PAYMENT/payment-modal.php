<?php if($cartRequest){ ?>
<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Your Bill</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
<?php }?>


      <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead class="">
                                                    <th>
                                                        Product name
                                                    </th>
                                                    <th>
                                                        Product options
                                                    </th>
                                                    <th>
                                                        Quantity
                                                    </th>
                                                    <th>
                                                        Product total Price
                                                    </th>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $totalBill = 0;
                                                    if(isset($_SESSION["items_to_buy"])){
                                                    $_SESSION["items_to_buy"] = array_values($_SESSION["items_to_buy"]);
                                                    foreach ($_SESSION["items_to_buy"] as $index => $productRow) { ?>
                                                        <tr>
                                                            <td>
                                                                <?php echo $productRow['product_name']; ?>
                                                            </td>
                                                            
                                                            <td>
                                                                <?php if(isset($productRow['options'])){
                                                                    foreach ($productRow['options'] as $optionName => $optionValue) {
                                                                    echo $optionName . ": " . $optionValue . "<br />";
                                                                }}else{ echo "Produc have no options" ;} 
                                                                
                                                                ?>
                                                            </td>
                                                            <?php ?>
                                                            <td>
                                                                <?php echo $productRow['quantity']; ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $productRow['totalprice'] . "Dh"; 
                                                                $totalBill += $productRow['totalprice'];
                                                                ?>

                                                            </td>

                                                        </tr>
                                                    <?php }} ?>
                                                    <br>

                                                    <tr>
                                                    <br>
                                                      <td class="pull-left">Total of: <?php
                                                      $_SESSION["totalBill"] = $totalBill;
                                                      echo $totalBill." Dh"; 
                                                      echo "<br>";

                                                      ?></td>

                                                    </tr>

                                                </tbody>
                                            </table>
                                            <?php if($_SESSION["totalBill"] != 0){ ?> 
                                            <button id="payment-button" class="btn btn-primary pull-right" >Make Parchause</button>
                                            <?php }else{ ?>
                                                <button class="btn btn-primary pull-right" >Please select some items first</button>
                                                <?php }?>
                                        </div>
                                    </div>
                                    
      </div>



      <?php if($cartRequest){ ?>

      </div>

      <div class="modal-footer"><p id="parchause-response" class="pull-left">This is your bill please click on parchause to make the transaction</p>
      </div>
      
    </div>
  </div>
</div>
<?php }?>

<?php require_once("../payment/payment.php"); ?>