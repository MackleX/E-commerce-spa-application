<?php require_once('header.php'); ?>
<?php require_once('index-php-process.php'); ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.2.4/css/simple-line-icons.min.css">
  <link rel="stylesheet" href="../assets/styles/item-grid.css">
  <link rel="stylesheet" href="../assets/styles/index.css">
  <link rel="stylesheet" href="../assets/styles/button.css">
  <link rel="stylesheet" href="../assets/styles/search-bar.css">
  <link rel="stylesheet" href="../assets/styles/banner.css">
  <link rel="stylesheet" href="../assets/styles/nav-bar.css">
  <link rel="stylesheet" href="../assets/styles/product-parchause.css">
  <link rel="stylesheet" href="../assets/side-nav-bar.css" />


  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://use.fontawesome.com/84f86b1832.js"></script>
    <script src="https://kit.fontawesome.com/524716f144.js" crossorigin="anonymous"></script>




    <script src="../assets/js/menu.js"></script>






    <title>Landing page</title>
  </head>
  <style>
    html {
      overflow: hidden;
    }
  </style>

<body class="body-no-reset">



  <header class="my-header" style="width:100%;">
    <?php require_once("../CROSSPAGESELEMENTS/nav-bar.php"); ?>
  </header>


  <div class="my-banner">
  </div>

  <script src="./js/banner.js"></script>

  <div style="width:100%;">

    <?php require_once("./nav-bar.php"); ?>

  </div>


  <main class="main container-fluid" style="overflow:visible;">
    <?php require_once("./side-nav-bar.php"); ?>

    <div class="grid-container-index container-fluid">
      <?php require_once("./item-grid.php") ?>
    </div>

    </aside>
    <section class="section">
      <article>
        <div>
          <nav>

          </nav>
        </div>
      </article>
    </section>
  </main>


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



<script src="../assets/js/filtre.js"></script>


<script src="../assets/js/RequestState.js"></script>





<script>



  let params = new URLSearchParams(location.search);


  $linkId = params.get('id')
  
  $sellerId = params.get('sellerId')






  if ($linkId != null) {
    globalRequestState.sendRequest("json", updategrid, {
      jsondata: JSON.stringify(globalRequestState)
    })
    globalRequestState.sendRequest("json", updateModal, {
      prodId: ($linkId)
    });
    $(document).ready(() => {
      $(".bg-modal").css('display', "flex");

      $(".bg-modal").css('z-index', "9999");


      $(".side-nav-bar").css('display', 'none');

    })



  } else if ($sellerId != null) {
    debugger;
    globalRequestState.sendRequest("json", updategrid, {
      sellerId: ($sellerId)
    });


  } else {
    globalRequestState.sendRequest("json", updategrid, {
      jsondata: JSON.stringify(globalRequestState)
    })
  }
</script>