<?php 

require_once("../config/config.php");
?>

<?php
 if(isset($_REQUEST['client_id'])){
    $clientid = $_REQUEST['client_id'];
    $tag = $_REQUEST['tag'];



    $statement = $pdo->prepare("delete from tags where seller_id=? and tag=?"); 
    $statement->execute(array($clientid,$tag));

    ob_clean();
    echo "SUCCESS";
    exit;
}  




$total=0;
if(isset($_POST['form1'])) {
    
    if(isset($_POST['email'])){
    
        $email = strip_tags($_POST['email']);
        $statement = $pdo->prepare("SELECT client_id,tag,client_name,client_email from tags inner join  client on client.client_id=tags.seller_id where client.client_email=?");
        $statement->execute(array($email));
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
                                    <label for="">user email*</label>
                                    <input type="email" class="form-control" name="email" >
                                  
                                </div>
                                <div class="col-md-3" >
                                    <label for=""></label>
                                    <input type="submit" class="btn btn-primary" value="search" name="form1" style=" width:100%; height:100%">
                               
                                </div>
                                <div class="col-md-3" >
                                    
                               
                                </div>
                                
                               
                               
                                <div class=" col-md-3" >
                                <label for=""></label>


                            <a  class=" btn btn-primary" style=" width:100%; height:100%;"  href="add_tag.php" >add tags</a>
                                </div>
                        </div>
                    </from>                        
                    
                     </div>

                                        <div class="card-body">
                                         <div class="table-responsive ">
                                          <table class="table table-hover my_content_table">
                                                    <thead class="">
                                                        <th>
                                                        client id
                                                        </th>
                                                        <th>
                                                        client name
                                                        </th>
                                                        <th>
                                                       email
                                                        </th>
                                                        <th>
                                                        tag
                                                        </th>
                                                       
                                                        
                                                    </thead>
                                                    <tbody class="my_contentx">

                                                        <?php if($total) {
                                                            foreach ($result as $index => $row) { ?>
                                                            
                                                                <tr>
                                                                    <td>
                                                                        <?php echo $row['client_id']; ?>
                                                                    </td>
                                                                    <td>
                                                                   <?php echo  $row['client_name'];?>
                                                                    </td>
                                                                    <td>
                                                                   <?php echo  $row['client_email'];?>
                                                                    </td>
                                                                    <td>
                                                                   <?php echo  $row['tag'];?>
                                                                    </td>
                                                                    
                                                                   
                            <td>
                             <a class='statusButton btn btn-danger _<?php echo $row['client_id']?> _<?php echo $row['tag']?>' onclick="stateChange(this)">delete</a>




                            </td></tr>
                            
                                                                   
                                                               
                                                                 
                                                                 
                                                                 
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
        function stateChange( elem) {
            client_id = elem.classList[3].substr(1);
            tag = elem.classList[4].substr(1);
          
                sendObject = {
                    client_id: client_id,
                    tag: tag
                }
            
            $.ajax({
                type: 'POST',
                url: 'tag.php',
                dataType: 'html',
                data: sendObject,
                success: function(data) {
                    debugger
                    if(data == "SUCCESS"){ 
                        
                        elem.innerHTML = "deleted"
                        elem.classList.remove("btn-danger");
                        elem.classList.add("btn-success");

                      
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
    