
<?php 

require_once("../config/config.php");
?>

<?php
 
 if (isset($_POST["form1"])){  
   
    $email = $_POST['email'];
    $tag1 = $_POST['tag1'];
    $tag2 = $_POST['tag2'];
    $tag3 = $_POST['tag3'];
    $statement = $pdo->prepare("select client_id from client  where client_email=?");
    $statement->execute(array($email));
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);  
    
    $id=$result[0]['client_id'];
    if (isset($_POST["tag1"])){  
        $statement = $pdo->prepare("INSERT INTO tags VALUES(?,?)");
        $statement->execute(array($id,$tag1));
}
if (isset($_POST["tag2"]) && !empty($_POST["tag3"])){  
    $statement = $pdo->prepare("INSERT INTO tags VALUES(?,?)");
    $statement->execute(array($id,$tag2));
}
if (isset($_POST["tag3"]) && !empty($_POST["tag2"])){  
    $statement = $pdo->prepare("INSERT INTO tags VALUES(?,?)");
    $statement->execute(array($id,$tag3));
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
                            
                            <form action="" method="post">            
                                <div class="col-md-12">
                                <div class="form-group card">
                                    <label for="">Email</label>
                                    <input type="email" class="form-control" name="email">
                                </div> 
                                <div class="form-group card">
                                    <label for="">tag 1</label>
                                    <input type="text" class="form-control" name="tag1" required>
                                </div> 
                                <div class="form-group card">
                                    <label for="">tag 2</label>
                                    <input type="text" class="form-control" name="tag2">
                                </div> 
                                <div class="form-group card">
                                    <label for="">tag 3</label>
                                    <input type="text" class="form-control" name="tag3">
                                </div>
                                <div class="form-group card"style="width:20%; margin:auto;" >
                                    <label for=""></label>
                                    <input type="submit" class="btn btn-primary" value="add" name="form1" style=" width:100%; height:100%">
                                </div>
                            </form>
                                        
                     

                                        
                                        
                                                              
                                                               
                                              

                                                

                                            
                                        
                                
                            
                            

                </div>



            </div>




        </div>


    </div>

</div>
