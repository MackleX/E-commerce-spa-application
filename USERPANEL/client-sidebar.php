<?php 
$pagee = basename($_SERVER["REQUEST_URI"]);
require_once("../config/config.php");
require_once("../userinterface/authentfication.php");
if(!$isOnline ){

  header("location: ../userinterface/login.php");
}
?>

<body>

    



      <div class="sidebar-wrapper">
        <ul class="nav">


          <li class="nav-item <?php if($pagee == "profile_container.php?id=76"){echo "active";}?>">
            <a class="nav-link" href="../profile/profile_container.php?id=<?php echo $_SESSION['customer']['client_id'];?>">
              <i class="material-icons">person</i>
              <p>See my profile</p>
            </a>
          </li>


          <li class="nav-item <?php if($pagee == "client-profile-update.php"){echo "active";} ?>">
            <a class="nav-link" href="../userpanel/client-profile-update.php">
              <i class="material-icons">person</i>
              <p>Update My Profile</p>
            </a>
          </li>


          <li class="nav-item <?php if($pagee == "client-cart.php"){echo "active";} ?>">
            <a class="nav-link" href="../kart/client-cart.php">
              <i class="material-icons">shopping_cart</i>
              <p>Check My cart</p>
            </a>
          </li>


          <li class="nav-item <?php if($pagee == "add-product.php"){echo "active";} ?>">
            <a class="nav-link" href="../userpanel/add-product.php">
              <i class="material-icons">inventory</i>
              <p>Add a product</p>
            </a>
          </li>

          
          <li class="nav-item <?php if($pagee == "productusermanagement.php"){echo "active";} ?>">
            <a class="nav-link" href="../userpanel/productusermanagement.php">
              <i class="material-icons">touch_app</i>
              <p>Manage product</p>
            </a>
          </li>

          <li class="nav-item <?php if($pagee == "productstatusmanagement.php"){echo "active";} ?>">
            <a class="nav-link" href="../userpanel/productstatusmanagement.php">
              <i class="material-icons">feedback</i>
              <p>Sells feedback</p>
            </a>
          </li>



        </ul>
      </div>
