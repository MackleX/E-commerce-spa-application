<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="./styles/side-nav-bar.css">
  <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</head>

<body>
  <nav class="side-nav-bar">


    <div class="drop-btn">
      Categories <span class="fas fa-caret-down"></span>
    </div>


    <div class="tooltip">
    </div>



    <div class="wrapper">

      <ul class="menu-bar">

      <?php
      for ($i = 0; $i < count($mid_cat_id); $i++){  

        ?>
        <!-- parents containers -->

        <li class="nav-item-parent <?php echo  "_" . $mid_cat_id[$i]; ?>" onclick="navigate(this.classList,true)">
        
        <a>
            <div class="icon" >
            </div>
            <?php echo $mid_cat_name[$i]; ?>
          </a>
        
        </li>
        
      <?php if($i == count($mid_cat_id) - 1) {echo "</ul>"; } }  ?>
    
      <?php
      for ($ii = 0; $ii < count($mid_cat_id); $ii++){
        ?>

      <ul class="nav-item-child <?php echo  "_" . $mid_cat_id[$ii]; ?>">

        <li class="arrow back-setting-btn" onclick="navigate(this.parentElement.classList,false)" ><span class="fas fa-arrow-left"></span>All</li>



        <?php
        for ($i = 0; $i < count($end_cat_id); $i++){

          if($end_to_mid_cat_id[$i] == $mid_cat_id[$ii]){
        ?>

        
        <li class=' _<?php echo $end_cat_id[$i]?> '><a>
            <div class="icon">
            </div>
            <?php echo $end_cat_name[$i]; ?>
          </a>
        </li>
        
         
        <?php }} ?>




      </ul>

      <?php }?>
      
    </div>
  </nav>

</body>

</html>