<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://checkout.stripe.com/checkout.js"></script>
    <title>Document</title>

</head>

<body>
    <div class="bg-modal">

        <section class="productCard myproductmodalcontainer">


            <div class="container" style="position:relative; ">

                <i class="fas fa-times-circle closeButton" style="position:absolute; top:0px; right:10px; z-index:1600; font-size:2em; cursor:pointer;"></i>
                <div class="info">
                    <h3 id="name" class="name 76">Gosh Donoderm Hand & Nail Cream</h3>
                    <h1 class="slogan">Performance with comfort RUN</h1>
                    <p class="price">30</p>




                    <div class="attribs">

                        <div class="attrib">
                            <p class="header"> Description </p>
                            <p></p>



                        </div>

                        <form name="product" onsubmit="return validateForm()">

                            <label for="quantity">Quantity (between 1 and 99):</label>
                            <input type="number" id="quantity" name="quantity" min="1" max="99" required>


                            <div class="attrib size">
                                <p class="header">Brand</p>
                                <div class="options">

                                    <input id="Lenovo" type="radio" name=">Brand" value="Lenovo" style="display:none;" checked>
                                    <label for="Lenovo">
                                        <div class="option activ">Lenovo</div>
                                    </label>

                                </div>
                            </div>

                            <div class="attrib size">
                                <p class="header">Size</p>
                                <div class="options">

                                    <input id="RED" type="radio" name=">Size" value="RED" style="display:none;" checked>
                                    <label for="RED">
                                        <div class="option activ">RED</div>
                                    </label>


                                    <input id="GREEN" type="radio" name=">Size" value="GREEN" style="display:none;">
                                    <label for="GREEN">
                                        <div class="option">GREEN</div>
                                    </label>



                                </div>
                            </div>


                            <input id="submitButton" type="submit" value="isCart" name="submitProduct" style="display:none;">
                            <input id="submitButton2" type="submit" value="isNotCart" name="submitProduct" style="display:none;">

                            <div class="buttons">
                                <label for="submitButton">
                                    <div type="button" class="button">Add to cart</div>
                                </label>
                                <label for="submitButton2">
                                    <div type="button" class="button colored" data-toggle="modal" data-target="#exampleModalLong">Buy now</div>
                                </label>
                            </div>
                    </div>

                    </form>






                    <div class="preview">
                        <div class="imgs">

                            <div class="imgs"><img class="activ" src="assets/uploads/product_photos/op.jpeg" alt="img 1"><img src="assets/uploads/product_photos/opp.jpeg" alt="img 2"></div>

                            <div class="zoomControl"></div>
                            <div class="closePreview"></div>
                            <div class="movControls">
                                <div class="movControl left"></div>
                                <div class="movControl right"></div>
                            </div>
                        </div>

                    </div>

        </section>

        <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Your Bill</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body myParchauseContainer">

                    </div>




                    <div class="modal-footer">
                        <p id="parchause-response" class="pull-left">This is your bill please click on parchause to make the transaction</p>

                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" id="reportModal" tabindex="-1" role="dialog" aria-labelledby="reportModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="reportModalLabel">Report</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">Write your reports</label>
                            <br>
                            <textarea class="form-control" id="report_text" rows="5"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="close" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="submitReport(1)"> Submit report</button>
                    </div>
                </div>
            </div>
        </div>


</body>
</div>


</html>
<script>
function submitReport(itemType) {
      let params = new URLSearchParams(location.search);
      let text = $("#report_text").val();
      $.ajax({
        type: 'POST',
        url: '../profile/php-profile-process.php',
        dataType: 'html',
        data: {
          reportText: text,
          itemType: itemType
        },
        success: function(data) {
          alert(data);
          $("#close").click();
        },
        error: function(data) {
          console.log("error");
          alert(data);

        }
      })


    }

    </script>