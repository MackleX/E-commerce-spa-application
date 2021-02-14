<?php 
$pagee = basename($_SERVER["REQUEST_URI"]);
?>

<body>

    

    

<div class="logo">
        <a href="http://www.creative-tim.com" class="simple-text logo-mini">
          CT
        </a>
        <a href="http://www.creative-tim.com" class="simple-text logo-normal">
          Creative Tim
        </a>
      </div>


      <div class="sidebar-wrapper">
        <ul class="nav">


          <li class="nav-item <?php if($pagee == "dashboard.php"){echo "active";}?>">
            <a class="nav-link" href="dashboard.php">
              <i class="material-icons">dashboard</i>
              <p>Dashboard</p>
            </a>
          </li>


          <li class="nav-item <?php if($pagee == "product.php"){echo "active";} ?>">
            <a class="nav-link" href="product.php">
            <i class="fa fa-product-hunt" aria-hidden="true"></i>
              <p>product</p>
            </a>
          </li>


          <li class="nav-item <?php if($pagee == "users.php"){echo "active";} ?>">
            <a class="nav-link" href="users.php">
            <i class="fa fa-user" aria-hidden="true"></i>
              <p>users</p>
            </a>
          </li>
          <li class="nav-item <?php if($pagee =="sreport.php"){echo "active";} ?>">
            <a class="nav-link" href="sreport.php">
            <i class="material-icons">visibility</i>
              <p>seen report</p>
            </a>
          </li>
          <li class="nav-item <?php if($pagee == "unsreport.php"){echo "active";} ?>">
          <a class="nav-link" href="unsreport.php">
          <i class="material-icons">visibility_off</i>        
              <p>unseen report</p>
            </a>
          </li>
          <li class="nav-item <?php if($pagee == "search.php"){echo "active";} ?>">
          <a class="nav-link" href="search.php">
          <i class="fa fa-search" aria-hidden="true"></i>
              <p>search</p>
            </a>
          </li> 
          <li class="nav-item <?php if($pagee == "add.php"){echo "active";} ?>">
          <a class="nav-link" href="add.php">
          <i class="fa fa-plus" aria-hidden="true"></i>           
              <p>add</p>
            </a>
          </li>
          <li class="nav-item <?php if($pagee == "tag.php"){echo "active";} ?>">
          <a class="nav-link" href="tag.php">
          <i class="fa fa-tags" aria-hidden="true"></i>            
              <p>tags</p>
            </a>
          </li>





        </ul>
      </div>
