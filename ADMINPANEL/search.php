<?php 

require_once("../config/config.php");
?>

<?php
 if(isset($_REQUEST['option_id'])){
    $optionid = $_REQUEST['option_id'];
    $is_unified = $_REQUEST['is_unified'];



    $statement = $pdo->prepare("update options set is_unified=? where option_id= ?"); 
    $statement->execute(array($is_unified,$optionid));

    ob_clean();
    echo "SUCCESS";
    exit;
}  




$total=0;
if(isset($_POST['form1'])) {
    
    if(isset($_POST['option'])){
    
        $option_name = strip_tags($_POST['option']);
        $statement = $pdo->prepare("SELECT option_id,option_name,is_unified from options  where option_name=?");
        $statement->execute(array($option_name));
        $total = $statement->rowCount();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
       
       
       
        
        
            
        }
    }


?>


<body class="">
    <div class="wrapper ">
        <div class="sidebar " data-color="purple" data-background-color="white">

            <?php require_once('sidebar.php'); ?>

        </div>


        <div class="main-panel">


            <div class="content">
                <?php require_once('nav-bar.php'); ?>  


                <div class="container-fluid new">
                            <div class="row my_content">
                                <div class="col-md-12">
                                    <div class="card card-plain">

                                        <div class="card-header card-header-primary">
                     <form action="" method="post">            
                        <div class="row">
                               
                                <div class="col-md-3">
                                    <label for="">option name*</label>
                                    <input type="text" class="form-control" name="option" >
                                  
                                </div>
                                <div class="col-md-3" >
                                    <label for=""></label>
                                    <input type="submit" class="btn btn-primary" value="search" name="form1" style=" width:100%; height:100%">
                               
                                </div>
                                       
                        </div>
                    </from>                        
                    
                     </div>

                                        <div class="card-body">
                                         <div class="table-responsive ">
                                          <table class="table table-hover my_content_table">
                                                    <thead class="">
                                                        <th>
                                                        option id
                                                        </th>
                                                        <th>
                                                        option name
                                                        </th>
                                                        
                                                        
                                                    </thead>
                                                    <tbody class="my_contentx">

                                                        <?php if($total) {
                                                            foreach ($result as $index => $row) { ?>
                                                            
                                                                <tr>
                                                                    <td>
                                                                        <?php echo $row['option_id']; ?>
                                                                    </td>
                                                                    <td>
                                                                   <?php echo  $row['option_name'];?>
                                                                    </td>
                                                                    
                                                                   
                                                                    <td>
                              <?php      


                            if ($row['is_unified'] == 0) {
                             ?>

                             <a class='statusButton btn btn-success _<?php echo $row['option_id'] ?>' onclick="stateChange(true,this)">Enable</a>

                            <?php

                            } else {

                            ?>

                                <a class='statusButton btn btn-danger _<?php echo $row['option_id'] ?>' onclick="stateChange(false,this)">Disable</a>

                        <?php

                            }




                            echo "</td>";
                        

                        ?>
                                                                   
                                                               
                                                                 
                                                                 
                                                                 
                                                            <?php }
                                                        } else {  ?>
                                                        
                                                            <tr class="warning">
                                                                <p class="text-warning"> NO ELEMENT IS SELECTED</p>
                                                               

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

    


    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
    <!-- Material Kit CSS -->
    <link href="../assets/css/material-dashboard.css?v=2.1.2" rel="stylesheet" />


    <script>
        function stateChange(Enable, elem) {
            option_id = elem.classList[3].substr(1);

            if (Enable) {
                sendObject = {
                    option_id: option_id,
                    is_unified: 1
                }
            } else {
                sendObject = {
                    option_id: option_id,
                    is_unified: 0
                }
            }


            $.ajax({
                type: 'POST',
                url: 'search.php',
                dataType: 'html',
                data: sendObject,
                success: function(data) {
                    debugger
                    if(data == "SUCCESS"){ 
                        if(Enable){
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
    