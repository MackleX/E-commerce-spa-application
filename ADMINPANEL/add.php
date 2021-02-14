<?php
require_once("../config/config.php");



$statement = $pdo->prepare("SELECT * FROM tbl_top_category");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);

if (isset($_REQUEST['topcat']) && isset($_REQUEST['midcat']) && isset($_REQUEST['endcat'])  && !empty($_REQUEST['endcat'])) {

    $statement = $pdo->prepare("SELECT tcat_id FROM tbl_top_category WHERE tcat_name=?");
    $statement->execute(array($_REQUEST['topcat']));
    $id = $statement->fetchColumn();

    if ($id) {

        $message = "";
        $statement = $pdo->prepare("SELECT mcat_id FROM tbl_mid_category WHERE mcat_name=?");
        $statement->execute(array($_REQUEST['midcat']));
        $mid = $statement->fetchColumn();




        if (isset($_REQUEST['add'])) {
            if ($mid) {
                $message .= "The chosen mid catogry aleardy exist your added end catogry will be a child of that end catogry" . "<br>";
            } else {


                $statement = $pdo->prepare("INSERT INTO `tbl_mid_category` (`mcat_id`, `mcat_name`, `tcat_id`) VALUES (NULL, ?, ?)");
                $statement->execute(array($_REQUEST['midcat'], $id));
                $mid = $pdo->lastInsertId();
                $message .= "You choosen mid category dont exsist, the one you added have been added to the database." . "<br>";
            }


            $statement = $pdo->prepare("SELECT ecat_id FROM tbl_end_category WHERE ecat_name=?");
            $statement->execute(array($_REQUEST['endcat']));
            $eid = $statement->fetchColumn();


            if ($eid) {
                $message .= "You chosen end category aleardy exist in the database." . "<br>";
            } else {
                $statement = $pdo->prepare("INSERT INTO `tbl_end_category` (`ecat_id`, `ecat_name`, `mcat_id`) VALUES (NULL, ?, ?)");
                $statement->execute(array($_REQUEST['endcat'], $mid));
                $message .= "You chosen end category have been added to the database." . "<br>";
            }
        } elseif (isset($_REQUEST['deleteEnd'])) {

            if ($mid) {

                $statement = $pdo->prepare("SELECT ecat_id FROM tbl_end_category WHERE ecat_name=?");
                $statement->execute(array($_REQUEST['endcat']));
                $eid = $statement->fetchColumn();


                if ($eid) {
                    $statement = $pdo->prepare("DELETE FROM tbl_end_category WHERE ecat_name=?");
                    $statement->execute(array($_REQUEST['endcat']));

                    $message .= "The end catogry: " . $_REQUEST['endcat'] . " Have been deleted" . "<br>";
                } else {
                    $message .= "Ther is no such end category in the databse." . "<br>";
                }
            } else {
                $message .= "Please choose a valide mid catogery that is a parent to your end category, see suggestions." . "<br>";
            }
        }
    } else {

        $message = "Ther is no such Top cetogry in the database and top cetogry are added manualy" . "<br>";
    }
} elseif (isset($_REQUEST['topcat']) && isset($_REQUEST['midcat'])) {
    $statement = $pdo->prepare("SELECT tcat_id FROM tbl_top_category WHERE tcat_name=?");
    $statement->execute(array($_REQUEST['topcat']));
    $id = $statement->fetchColumn();


    if (isset($_REQUEST['add'])) {

        if ($id) {
            $message = "";
            $statement = $pdo->prepare("SELECT mcat_id FROM tbl_mid_category WHERE mcat_name=?");
            $statement->execute(array($_REQUEST['midcat']));
            $mid = $statement->fetchColumn();

            if ($mid) {

                $message .= "The chosen mid catogry aleardy exist " . "<br>";
            } else {


                $statement = $pdo->prepare("INSERT INTO `tbl_mid_category` (`mcat_id`, `mcat_name`, `tcat_id`) VALUES (NULL, ?, ?)");
                $statement->execute(array($_REQUEST['midcat'], $id));
                $mid = $pdo->lastInsertId();
                $message .= "You choosen mid category dont exist, the one you added have been added to the database." . "<br>";
            }
        } else {

            $message = "Ther is no such Top category in the database and top cetogry are added manualy" . "<br>";
        }
    } elseif (isset($_REQUEST['deleteMid'])) {



        if ($id) {

            $message = "entred the delete";
            $statement = $pdo->prepare("SELECT mcat_id FROM tbl_mid_category WHERE mcat_name=?");
            $statement->execute(array($_REQUEST['midcat']));
            $mid = $statement->fetchColumn();

            if ($mid) {



                $statement = $pdo->prepare("DELETE FROM tbl_mid_category WHERE mcat_id=?");
                $statement->execute(array($mid));

                $statement = $pdo->prepare("DELETE FROM tbl_end_category WHERE mcat_id=?");
                $statement->execute(array($mid));



                $message .= "The mid category and it's childs are removed " . "<br>";
            } else {

                $message .= "Ther is no such mid category." . "<br>";
            }
        } else {

            $message = "Ther is no such Top cetogry in the database" . "<br>";
        }
    } elseif (isset($_REQUEST['deleteEnd'])) {
        $message .= "please select enter an end category while deleting an end category";
    }
}




















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

<style>
    .select-wrapper input.select-dropdown {
        height: 40px;
    }
</style>
<div class="page">
    <div class="wrapper">

        <div class="sidebar " data-color="purple" data-background-color="white">

            <?php require_once('sidebar.php'); ?>

        </div>

        <div class="main-panel">



            <?php require_once('nav-bar.php'); ?>



            <div class="content">
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-header-danger">
                                    <h4 class="card-title">Adding a category</h4>
                                </div>
                                <div class="card-body">
                                    <?php if (!empty($message)) { ?>
                                        <div class="row">
                                            <div class="col-md-12 text-center">
                                                <p><?php echo $message ?></p>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <div class="row">
                                        <div class="col-md-12">

                                            <form id="catform" action="./add.php" method="GET">

                                                <div class="input-group">
                                                    <input form="catform" name="topcat" id="topcatinput" type="text" class="form-control" aria-label="Text input with dropdown button" placeholder="select a mid category" value="Clothing" required>

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
                                                    <input form="catform" name="midcat" id="midcatinput" type="text" class="form-control" aria-label="Text input with dropdown button" placeholder="select or add a top category" required>
                                                    <div class="input-group-append">
                                                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Mid categories</button>
                                                        <div class="dropdown-menu">
                                                            <div id="mid_cat_container">

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>





                                                <div class="input-group">
                                                    <input form="catform" name="endcat" id="endcatinput" type="text" class="form-control" aria-label="Text input with dropdown button" placeholder="select or add an end category">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">end categories</button>
                                                        <div class="dropdown-menu">
                                                            <div id="end_cat_container">

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="input-group">
                                                    <div class="row">
                                                        <button for="catform" type="submit" name="add" class="btn btn-outline-primary">add categories</button>
                                                        <button for="catform" type="submit" name="deleteMid" class="btn btn-outline-primary" value="delete mid category">delete mid category</button>

                                                        <button for="catform" type="submit" name="deleteEnd" class="btn btn-outline-primary" value="delete mid category">delete end category</button>
                                                    </div>
                                                </div>
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
    </div>
</div>

</div>

<script>
    function topcatSet(selectedTopcat) {
        $('#topcatinput').val(selectedTopcat)
        $('#midcatinput').val('')
        $('#endcatinput').val('')
        sendRequest('html', updateMidCat, {
            topCatName: selectedTopcat
        })
    }

    function midcatSet(selectedMidcat) {
        $('#midcatinput').val(selectedMidcat)

        debugger;
        sendRequest('html', updateEndCat, {
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

    function sendRequest(dataTpye, callback, data) {



        $.ajax({
            type: 'POST',
            url: 'add.php',
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