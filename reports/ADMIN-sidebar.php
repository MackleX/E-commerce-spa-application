<?php 
$pagee = basename($_SERVER["REQUEST_URI"]);
?>

<body>

    

    

      <div class="logo" >
      <a href="" class="simple-text logo-normal">
        REPORTS SECTION
      </a>
      </div>


      <div class="sidebar-wrapper">
        <ul class="nav">


          <li class="nav-item <?php if($pagee == "profile_container.php"){echo "active";}?>">
            <a class="nav-link" href="TEST S REPORTS.php">
              <i class="material-icons">visibility</i>
              <p>SEEN REOPRTS</p>
            </a>
          </li>


          <li class="nav-item <?php if($pagee == "client-profile-update.php"){echo "active";} ?>">
            <a class="nav-link" href="TEST UNS REPORTS.php">
            <i class="material-icons">visibility_off</i>
              <p>UNSEEN REOPRTS</p>
            </a>
          </li>




        </ul>
      </div>
