<?php require_once('header.php'); ?>
<?php require_once('index-php-process.php'); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <script src="https://kit.fontawesome.com/524716f144.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>



    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.2.4/css/simple-line-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">

    <link rel="stylesheet" href="./styles/item-grid.css">
    <link rel="stylesheet" href="./styles/index.css">
    <link rel="stylesheet" href="./styles/button.css">
    <link rel="stylesheet" href="./styles/search-bar.css">
    <link rel="stylesheet" href="./styles/banner.css">
    <link rel="stylesheet" href="./styles/nav-bar.css">
    <link rel="stylesheet" href="./styles/product-parchause.css">



    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="./side-nav-bar.css" />

        <script src="https://use.fontawesome.com/84f86b1832.js"></script>

        <script src="./js/menu.js"></script>



        <title>Landing page</title>
    </head>

<body class="body-no-reset">

    <header class="my-header">
        <?php require_once("./top-nav-bar.php") ?>
    </header>

    <div class="my-banner">
    </div>

    <script src="./js/banner.js"></script>

    <?php require_once("./nav-bar.php"); ?>


    <main class="main">
        <?php require_once("./side-nav-bar.php"); ?>
        <div class="grid-container-index" style="display:flex; flex-direction:column; flex-grow:1;">
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
        <footer></footer>
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
                console.log('error dzbi');
                console.log(data);

            }
        })

    }



    //SIDEBAR END



    //GRID ITEM HANDLER
    function gridItemResponseHandler(data) {

        const grid = document.getElementById("grid");
        grid.innerHTML = '';

        let html = '';

        console.log(data);

        for (var prop in data) {

            if (data.hasOwnProperty) {
                obj = data[prop];
                product_name = obj['p_name'];
                console.log(obj);
                product_id = obj['p_id']
                product_price = obj['p_current_price'];
                product_featured_photo = obj['p_featured_photo']
                html +=

                    `
    <div class="product id_${product_id}" >
<div class="info-large">
    <h4>${product_name}></h4>

    <div class="price-big">
        <span>${product_price} Dh</span>
    </div>

    <button class="add-cart-large">Add To Cart</button>
    <button class="description-button-large">description</button>
</div>
<div class="make3D">
    <div class="product-front">
        <div class="shadow"></div>
        <img src="assets/uploads/${product_featured_photo}" alt="" />
        <div class="image_overlay"></div>
        <div class="add_to_cart">Add to cart</div>
        <div class="view_gallery">View gallery</div>
        <div class="description-button">description</div>
        <div class="stats">
            <div class="stats-container">
                <span class="product_price">${product_price} Dh</span>
                <span class="product_name">${product_name}</span>
                <p>
                   default
                </p>

                <div class="product-options">

                </div>
            </div>
        </div>
    </div>

    <div class="product-back">
        <div class="shadow"></div>
        <div class="carousel">
            <ul class="carousel-container">
                <li><img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/245657/1.jpg" alt="" /></li>
                <li><img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/245657/1.jpg" alt="" /></li>
                <li><img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/245657/1.jpg" alt="" /></li>
            </ul>
            <div class="arrows-perspective">
                <div class="carouselPrev">
                    <div class="y"></div>
                    <div class="x"></div>
                </div>
                <div class="carouselNext">
                    <div class="y"></div>
                    <div class="x"></div>
                </div>
            </div>
        </div>
        <div class="flip-back">
            <div class="cy"></div>
            <div class="cx"></div>
        </div>
    </div>
</div>
</div>
`

                grid.innerHTML = html;


                menu();

            }
        }
    }


    //GRID ITEM HANDLER
</script>


<script src="./js/RequestState.js"></script>
<script src="./js/filtre.js"></script>