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
    

    <script src='./theme.js'></script>
    <link rel="stylesheet"
	href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.2.4/css/simple-line-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
    
	<link rel="stylesheet" href="./styles/item-grid.css">
    <link rel="stylesheet" href="./styles/index.css">
    <link rel="stylesheet" href="./styles/button.css">
    <link rel="stylesheet" href="./styles/search-bar.css">
    <link rel="stylesheet" href="./styles/banner.css">
    <link rel="stylesheet" href="./styles/nav-bar.css  ">
	<link rel="stylesheet" href="./styles/product-parchause.css  ">



    <head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<script src="https://code.jquery.com/jquery-3.5.1.min.js"
		integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="./side-nav-bar.css" />

	<script src="https://use.fontawesome.com/84f86b1832.js"></script>



    <title>Landing page</title>
</head>
<body class="body-no-reset">
    <header class="my-header">
    <?php require_once("./top-nav-bar.php") ?>
    </header>

    <div class="my-banner">
    </div>

    <script  src="./js/banner.js"></script>

    <?php require_once("./nav-bar.php"); ?>
    
    
    <main class="main">
    <?php require_once("./side-nav-bar.php"); ?>
    <div class="grid-container-index" style="display:flex; flex-direction:column; flex-grow:1;">
    <?php require_once("./item-grid.php"); ?>
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