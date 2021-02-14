<?php

$mysqli = new mysqli('localhost','root','123456','aseds') ;
if (isset ($_GET['mass'])){
    $id = $_GET['mass'];
    $mysqli->query("UPDATE reports SET report_is_seen = 1 WHERE report_id= $id");
}
if (!isset($_GET['page'])) {
    $page = 1;
} else {
    $page = $_GET['page'];
}
?>
<style>
details summary::-webkit-details-marker {
  display: none;
}

</style>

<div>
    <div class="page">
        <div class="sidebar " data-color="purple" data-background-color="white">
            <?php require_once('sidebar.php'); ?>
        </div>
        <div class="main-panel">
            <?php require_once('nav-bar.php'); ?>
            <div class="content">
                <div class="container-fluid">
                    <div class="row my_content">
                        <div class="col-md-12">
                            <div class="card card-plain">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover my_content_table">
                                            <thead >
                                                <th>
                                                    REPORTER's EMAIL
                                                </th>
                                                <th>
                                                    REPORTED's EMAIL
                                                </th>
                                                <th>
                                                    REPORT TYPE
                                                </th>
                                                <th>
                                                    REPORT
                                                </th>
                                                <th>
                                                    ACTION
                                                </th>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $statment=$mysqli->prepare("
                                                SELECT C.client_email as reportermail,reported_item_id,reported_item_type,report_content,report_id 
                                                from (REPORTS JOIN CLIENT C ON C.client_id=reporter_id) where report_is_seen=0 "
                                                );
                                                $statment->execute();
                                                $results=$statment->get_result();
                                                $number_of_results = mysqli_num_rows($results);
                                                $results_per_page = 5;
                                                $number_of_pages = ceil($number_of_results/$results_per_page);
                                                $this_page_first_result = ($page-1)*$results_per_page;
                                                $statment=$mysqli->prepare('
                                                SELECT C.client_email as reportermail,reported_item_id,reported_item_type,report_content,report_id 
                                                from (REPORTS JOIN CLIENT C ON C.client_id=reporter_id) where report_is_seen=0 
                                                LIMIT ' . $this_page_first_result . ',' .  $results_per_page );
                                                $statment->execute();
                                                $results=$statment->get_result();
                                                while($row=$results->fetch_assoc()) {

                                                    if($row['reported_item_type'] == 0){

                                                        $statment=$mysqli->prepare("SELECT client_email from client where client_id = ?");
                                                     


                                                        $type = "s";
                                                        $names = array($row['reported_item_id']);
                                                        $params = array(&$type, &$names[0]);
                                                        call_user_func_array(array($statment, 'bind_param'), $params);



                                                        $statment->execute();
                                                        $result=$statment->get_result();
                                                        $result=$result->fetch_assoc();
                                                        $row['reportedmail'] = $result['client_email'];

                                                        
                                                    }else{

                                                        $statment=$mysqli->prepare("SELECT client_email from client join product on product_seller_id=client_id 
                                                        where product_id = ?");

                                                        $type = "s";
                                                        $names = array($row['reported_item_id']);
                                                        $params = array(&$type, &$names[0]);
                                                        call_user_func_array(array($statment, 'bind_param'), $params);



                                                        $statment->execute();
                                                        $result=$statment->get_result();
                                                        $result=$result->fetch_assoc();
                                                        $row['reportedmail'] = $result['client_email'];


                                                    }

                                                    ?>
                                                <tr>
                                                    <td> <?php echo $row['reportermail']; ?> </td>
                                                    <td> <?php echo $row['reportedmail']; ?> </td>
                                                    <td> <?php if ($row['reported_item_type']==1) { echo 'product report'; } else { echo 'seller report'; } ?> </td>
                                                    <td width=20%>
                                                    <section><details ><summary><b>READ</b></summary><?php echo $row['report_content']; ?></details></section>
                                                    </td>
                                                    <td><a href="unsreport.php?mass=<?php echo $row['report_id']; ?>">MARK AS SEEN</a></td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                        <?php
                                        if ($number_of_pages>1){ ?>
                                        <nav aria-label="...">
                                            <ul class="pagination justify-content-center">
                                            <?php
                                            for ($p=1;$p<=$number_of_pages;$p++) {
                                                if ($p==$page) {?>
                                                    <li class="page-item active"> <?php 
                                                    echo '<a class="page-link" href="TEST UNS REPORTS.php?page=' . $p . '" >' .  $p . '</a> ';}
                                                    else { ?> 
                                                        <li class="page-item "> <?php 
                                                        echo '<a class="page-link" href="TEST UNS REPORTS.php?page=' . $p . '" >' .  $p . '</a> ' ;} ?>
                                                    </li>
                                            <?php } ?>
                                            </ul>
                                        </nav>
                                        <?php } ?>
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