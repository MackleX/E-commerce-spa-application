<?php
require_once("../config/config.php");
require_once("../userinterface/authentfication.php");




$statement = $pdo->prepare("SELECT * FROM tbl_top_category");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);



if (isset($_REQUEST['topCatName'])) {

    $statement = $pdo->prepare("SELECT * FROM tbl_mid_category tc JOIN tbl_top_category te ON tc.tcat_id= te.tcat_id AND te.tcat_name = ?");
    $statement->execute(array($_REQUEST['topCatName']));
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

    ob_clean();
    foreach ($result as $row) {  ?>


        <a class="dropdown-item" onclick="midcatSet(this.innerText)"><?php echo $row['mcat_name'] ?></a>

    <?php
    }
    exit;
}


if (isset($_REQUEST['midCatName'])) {

    $statement = $pdo->prepare("SELECT * FROM tbl_end_category te JOIN tbl_mid_category tm ON te.mcat_id= tm.mcat_id AND tm.mcat_name = ?");
    $statement->execute(array($_REQUEST['midCatName']));
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

    ob_clean();
    foreach ($result as $row) {  ?>


        <a class="dropdown-item" onclick="endcatSet(this.innerText)"><?php echo $row['ecat_name'] ?></a>


<?php
    }


    exit;
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
                        <div class="card col-md-12">

                            <div class="card-header card-header-tabs card-header-primary">
                                <h4 class="card-title">Adding a product</h4>
                            </div>
                            <div class="card-body">
                                <form id="productForm" onsubmit="submitProduct()" enctype="multipart/form-data">
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="ProdName">Product name</label>
                                            <input type="text" class="form-control" id="ProdName" placeholder="Write your product name" name="productName" required>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="prodSlog">Product slogan</label>
                                            <input type="text" class="form-control" id="prodSlog" placeholder="Write your product Slogan" name="productSlogan" required>
                                        </div>

                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="prodPrice">Product price</label>
                                            <input type="number" class="form-control" id="prodPrice" placeholder="Write your product price" name="productPrice" required>
                                        </div>
                                        <div class="form-group col-md-4">

                                            <div class="form-group form-file-upload form-file-simple">
                                                <input type="text" class="form-control inputFileVisible" placeholder="Add  your product principale image">
                                                <input type="file" class="inputFileHidden" name="fileso" required>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="prodQty">Product quantity</label>
                                            <input type="number" class="form-control" id="prodQty" placeholder="Add your availabe product quantity" name="productAvailableQuantity" required>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <div class="form-group form-file-upload form-file-multiple">
                                                <input type="file" multiple="" class="inputFileHidden" name="files[]" multiple required>
                                                <div class="input-group">
                                                    <input type="text" class="form-control inputFileVisible" placeholder="Add your gallery images">
                                                    <span class="input-group-btn">
                                                        <button type="button" class="btn btn-fab btn-round btn-info">
                                                            <i class="material-icons">layers</i>
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                    </div>




                                    <div class="form-group">
                                        <label for="exampleFormControlTextarea1">Product Description</label>
                                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="productDescription"></textarea>
                                    </div>



                                    <div class="row">
                                        <div class="col-md-12">


                                            <div class="input-group">
                                                <input form="productForm" name="topcat" id="topcatinput" type="text" class="form-control" aria-label="Text input with dropdown button" placeholder="select a mid category" value="Clothing" required>

                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Top categories</button>
                                                    <div class="dropdown-menu">
                                                        <?php foreach ($result as $row) { ?>
                                                            <a class="dropdown-item" onclick="topcatSet(this.innerText)"><?php echo $row['tcat_name'] ?></a>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="input-group">
                                                <input form="productForm" name="midcat" id="midcatinput" type="text" class="form-control" aria-label="Text input with dropdown button" placeholder="select or add a top category" required>
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Mid categories</button>
                                                    <div class="dropdown-menu">
                                                        <div id="mid_cat_container">

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>





                                            <div class="input-group">
                                                <input form="productForm" name="endcat" id="endcatinput" type="text" class="form-control" aria-label="Text input with dropdown button" placeholder="select or add an end category" required>
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">end categories</button>
                                                    <div class="dropdown-menu">
                                                        <div id="end_cat_container">

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>



                                        </div>
                                    </div>


                                </form>

                                <div class="row">
                                    <div>
                                        <label for="addTable">Add an option</label>
                                        <input type="text" class="form-control" id="addTable" aria-describedby="textHelp" placeholder="Enter option name">
                                        <small id="textHelp" class="form-text text-muted">Please write an option name and hit enter, suggested options will give the usesr possibity to find your product using filter by option. Custom options are not shown in the search bar</small>
                                        <small>
                                            <p>Suggestions: <span id="txtHint"></span></p>
                                        </small>
                                    </div>




                                </div>


                                <div id="cont">

                                </div>

                                <button type="button" class="btn btn-success" onclick="submitt()">Registre options</button>


                                <button type="submit" form="productForm" class="btn btn-primary">Submit your product</button>


                            </div>

                        </div>
                    </div>
                </div>
            </div>


        </div>


    </div>

    <script>
        // FileInput
        $('.form-file-simple .inputFileVisible').click(function() {
            $(this).siblings('.inputFileHidden').trigger('click');
        });

        $('.form-file-simple .inputFileHidden').change(function() {
            var filename = $(this).val().replace(/C:\\fakepath\\/i, '');
            $(this).siblings('.inputFileVisible').val(filename);
        });

        $('.form-file-multiple .inputFileVisible, .form-file-multiple .input-group-btn').click(function() {
            $(this).parent().parent().find('.inputFileHidden').trigger('click');
            $(this).parent().parent().addClass('is-focused');
        });

        $('.form-file-multiple .inputFileHidden').change(function() {
            var names = '';
            for (var i = 0; i < $(this).get(0).files.length; ++i) {
                if (i < $(this).get(0).files.length - 1) {
                    names += $(this).get(0).files.item(i).name + ',';
                } else {
                    names += $(this).get(0).files.item(i).name;
                }
            }
            $(this).siblings('.input-group').find('.inputFileVisible').val(names);
        });

        $('.form-file-multiple .btn').on('focus', function() {
            $(this).parent().siblings().trigger('focus');
        });

        $('.form-file-multiple .btn').on('focusout', function() {
            $(this).parent().siblings().trigger('focusout');
        });
    </script>




    <script>
        let registredOptions;


        function submitProduct() {
            submitt()
            var frm = document.getElementById("productForm")
            return false


        }
        var input = document.getElementById("addTable");

        input.addEventListener("keyup", function(event) {
            showHint(this.value);
            if (event.keyCode === 13) {


                event.preventDefault();
                addoption(this);

            }
        });


        function addoption(elem) {
            if (event.keyCode === 13) {

                optionname = elem.value;
                let mytable = new option(optionname);
                mytable.createTable()

            }
        }
        class option {
            constructor(name) {
                this.arrayHead = ["Option_name:" + name, 'Possible' + ' ' + name, 'The More the better, Options Price.'];
                this.name = name;

            }

            createTable() {
                optionChanges(true, this.name)
                var myTableDiv = document.createElement('div')
                myTableDiv.setAttribute('id', this.name + "_Container")
                var empTable = document.createElement('table');
                empTable.setAttribute('id', this.name);
                empTable.classList.add("myOptions", "table");
                var tr = empTable.insertRow(-1);

                for (var h = 0; h < this.arrayHead.length; h++) {
                    var th = document.createElement('th');
                    th.innerHTML = this.arrayHead[h];
                    if (h != 0) {
                        empTable.classList.add("text-center");
                    }
                    tr.appendChild(th);
                }

                var div = document.getElementById('cont');
                myTableDiv.appendChild(empTable);
                let mybuttonHtml = ` 
                <div class="col-md-12 text-center">
                <button class="btn btn-warning btn-fab btn-fab-mini btn-round" type="button" id="addRow_${this.name}" value="Add New Row" onclick="addRow('${this.name}',${this.arrayHead.length})">
  <i class="material-icons">queue
</i>
</button>
                </div>
                `

                let myRemoveButtonHtml = ` <div class="col-md-12 text-center">  <button class="btn btn-info btn-round" id="removeTable_${this.name}" value="RemoveTable" onclick="removeTable('${this.name}_Container')">
  <i class="material-icons">favorite</i>Remove ${this.name} Option
</button> </div>`


                myTableDiv.insertAdjacentHTML('beforeend', mybuttonHtml);
                myTableDiv.insertAdjacentHTML('afterbegin', myRemoveButtonHtml)
                div.appendChild(myTableDiv);
                submitt()

            }




            // function to extract and submit table data.

        }


        function submitt() {
            var optionsObject = [];
            var options = document.getElementsByClassName("myOptions");
            for (var i = 0; i < options.length; i++) {
                id = options[i].id;
                var arrObj = new Array();
                var object = {
                    [id]: []
                }
                var myTab = document.getElementById(id);
                for (row = 1; row < myTab.rows.length - 1; row++) {
                    // loop through each cell in a row.
                    var obj = {};
                    for (c = 1; c < myTab.rows[row].cells.length; c++) {
                        var element = myTab.rows.item(row).cells[c];
                        if (element.childNodes[0].getAttribute('type') == 'text') {
                            classname = element.childNodes[0].classList[0];
                            if (classname == "value_name") {

                                obj['value_name'] = element.childNodes[0].value;
                            } else if (classname == "value_price") {

                                obj['value_price'] = element.childNodes[0].value;
                            }
                        }
                    }
                    if (obj['value_name'] != "" && obj.hasOwnProperty('value_name')) {
                        if (obj['value_price'] == '' || isNaN(obj['value_price'])) {
                            obj['value_price'] = 0
                        }
                        arrObj.push(obj);
                    }


                }
                if (arrObj.length != 0) {
                    object[id] = arrObj;
                    optionsObject.push(object);
                }


            }

            registredOptions = optionsObject;


        }

        function removeRow(oButton, rainbow) {

            var empTab = document.getElementById(rainbow);
            empTab.deleteRow(oButton.parentNode.parentNode.rowIndex); // buttton -> td -> tr
            submitt()
        }

        function addRow(name, length) {
            var empTab = document.getElementById(name);
            var rowCnt = empTab.rows.length; // get the number of rows.
            var tr = empTab.insertRow(rowCnt); // table row.
            tr = empTab.insertRow(rowCnt);
            for (var c = 0; c < length; c++) {
                var td = document.createElement('td'); // TABLE DEFINITION.
                td = tr.insertCell(c);

                if (c == 0) { // if its the first column of the table.
                    // add a button control.
                    var button = document.createElement('button');

                    // set the attributes.
                    button.setAttribute('type', 'button');

                    // add button's "onclick" event.
                    button.setAttribute('onclick', `removeRow(this,"${name}")`);
                    button.setAttribute('onclick', `removeRow(this,"${name}")`);
                    button.classList.add("btn", "btn-fab", "btn-round", "btn-primary", "btn-fab-mini", "btn-warning")
                    button.innerHTML = `<i class="material-icons">delete</i> `
                    td.appendChild(button);
                    td.appendChild(button);
                } else {
                    // the 2nd, 3rd and 4th column, will have textbox.
                    var ele = document.createElement('input');
                    ele.setAttribute('type', 'text');
                    ele.setAttribute('value', '');
                    if (c == 1) {
                        ele.classList.add("value_name");
                    } else if (c == 2) {
                        ele.classList.add("value_price");
                    }
                    td.appendChild(ele);
                }
            }
            submitt()
        }

        function removeTable(name) {
            let l = name.length - 10;

            optionChanges(false, name.substring(0, l))
            var Tab = document.getElementById(name);
            Tab.parentNode.removeChild(Tab);
            submitt()
        }

        let optionsAdded = []

        function optionChanges(isAdd, element) {
            debugger;
            if (isAdd) {
                if (!optionsAdded.includes(element)) {
                    optionsAdded.push(element);
                } else {
                    alert("Option Aleardy exists");
                    throw new Error("Something went badly wrong!");
                }
            } else {

                const index = optionsAdded.indexOf(element);
                if (index > -1) {
                    optionsAdded.splice(index, 1);
                }

            }
        }
    </script>


    <script>
        $(document).ready(function() {

            $("#productForm").on('submit', function(e) {
                e.preventDefault();
                formData = new FormData(this),
                    formData.append('jsondata', JSON.stringify(registredOptions))
                $.ajax({
                    type: 'POST',
                    url: './uploadhandler.php',
                    data: formData,
                    dataType: 'json',
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function() {
                        debugger;
                        $('.submitBtn').attr("disabled", "disabled");
                        $('#productForm').css("opacity", ".5");
                    },
                    success: function(response) {
                        if (response.status == 1) {
                            $('#productForm')[0].reset();
                            alert("Your product have been added");
                        } else {
                            alert("Problem")
                        }
                    },
                    error: function(response) {
                        $('#productForm')[0].reset();
                         lert("Your product have been added");
                    }
                });
            });

        });
    </script>



    <script>
        function showHint(str) {
            if (str.length == 0) {
                document.getElementById("txtHint").innerHTML = "";
                return;
            } else {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("txtHint").innerHTML = this.responseText;
                    }
                };
                xmlhttp.open("GET", "gethint.php?q=" + str, true);
                xmlhttp.send();
            }
        }
    </script>



    <script>
        function topcatSet(selectedTopcat) {
            $('#topcatinput').val(selectedTopcat)
            $('#midcatinput').val('')
            $('#endcatinput').val('')
            sendRequestCat('html', updateMidCat, {
                topCatName: selectedTopcat
            })
        }

        function midcatSet(selectedMidcat) {
            $('#midcatinput').val(selectedMidcat)

            debugger;
            sendRequestCat('html', updateEndCat, {
                midCatName: selectedMidcat
            })
        }

        function endcatSet(selectedEndcat) {
            $('#endcatinput').val(selectedEndcat)


        }




        function updateMidCat(data) {

            $('#mid_cat_container').get(0).innerHTML = data;
            debugger;


        }

        function updateEndCat(data) {
            $('#end_cat_container').get(0).innerHTML = data;
            debugger
        }



        function sendRequestCat(dataTpye, callback, data) {



            $.ajax({
                type: 'POST',
                url: '../userpanel/add-product.php',
                dataType: dataTpye,
                data: data,
                success: function(data) {
                    callback(data);
                    debugger
                },
                error: function(data) {
                    console.log("error");
                    console.log(data);
                    debugger
                }
            })

        }
    </script>