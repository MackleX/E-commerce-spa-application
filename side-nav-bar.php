<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="./side-nav-bar.css">
  <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</head>

<body>
  <nav class="side-nav-bar" style="max-width:40%; display:flexbox; flex-direction: column;">

    <div class="drop-btn">
      Search By filter <span class="fas fa-caret-down"></span>
    </div>


    <div class="tooltip">
    </div>



    <div class="wrapper" style="height: 100%">

      <div class="drop-btn">
        Search By filter
      </div>
      <ul class="menu-bar">

        <?php
        for ($i = 0; $i < count($mid_cat_id); $i++) {

        ?>
          <!-- parents containers -->

          <li class="nav-item-parent <?php echo  "_" . $mid_cat_id[$i]; ?>" onclick="navigate(this.classList,true)">

            <a>
              <div class="icon sideNavElement">
              </div>
              <?php echo $mid_cat_name[$i]; ?>
            </a>

          </li>

        <?php if ($i == count($mid_cat_id) - 1) {
            echo "</ul>";
          }
        }  ?>

        <?php
        for ($ii = 0; $ii < count($mid_cat_id); $ii++) {
        ?>

          <ul class="nav-item-child <?php echo  "_" . $mid_cat_id[$ii]; ?>">

            <li class="arrow back-setting-btn" onclick="navigate(this.parentElement.classList,false)"><span class="fas fa-arrow-left"></span>All</li>



            <?php
            for ($i = 0; $i < count($end_cat_id); $i++) {
              if (isset($mid_cat_id[$ii]) && isset($end_to_mid_cat_id[$i])) {

                if ($end_to_mid_cat_id[$i] == $mid_cat_id[$ii]) {

            ?>


                  <li class=''><a>
                      <div class="icon">
                      </div>
                      <?php echo $end_cat_name[$i]; ?>
                    </a>
                  </li>


            <?php }
              }
            } ?>




          </ul>

        <?php } ?>

    </div>
    </div>


  </nav>

</body>

</html>


<script type="text/javascript">
  //SIDEBARSCRIPT
  const drop_btn = document.querySelector(".drop-btn span");
  const tooltip = document.querySelector(".tooltip");
  const menu_wrapper = document.querySelector(".wrapper");

  drop_btn.onclick = (() => {
    menu_wrapper.classList.toggle("show");
    tooltip.classList.toggle("show");
  });


  function navigate(classes, isParent) {
    const parentContainer = document.querySelector(".menu-bar")
    const child = document.querySelector(".nav-item-child" + "." + classes[1])
    if (isParent) {
      midCategoryRefresh(classes[1]);
      parentContainer.style.display = "none";
      child.style.display = "block";
    } else {
      parentContainer.style.display = "block";
      child.style.display = "none";
    }
  }



  function midCategoryRefresh(par) {
    id = par.substr(1);
    $.ajax({
      type: 'POST',
      url: 'update_item_grid.php',
      dataType: "json",
      data: {
        id: id
      },
      success: function(data) {
        console.log('SUCCESS BLOCK');
        gridItemResponseHandler(data)
      },
      error: function(data) {
        console.log(data);

      }
    })

  }

  //CALLING ALL PRODUCT:
</script>
<script>



</script>
<script src="./side_nav_bar.js"></script>