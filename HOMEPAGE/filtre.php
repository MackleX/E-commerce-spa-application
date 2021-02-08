<?php require_once("./header.php") ?>

<?php

$statement = $pdo->prepare("SELECT * FROM options where is_unified = 1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);



?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../assets/styles/filtre.css">
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"> </script>
  <title>Document</title>
</head>

<body>




  <div class="tag-search-container">

  <?php foreach ($result as $row) { ?>

    <div id="tag-container-holder<?php echo "_" . $row['option_id'] ?>" class="search-input">
      <label id="tag-holder<?php echo "_" . $row['option_id'] ?>" for="tag-typer<?php echo "_" . $row['option_id'] ?>" class="my-input">
        <div class="tags">

          <input type="text" id=" tag-typer<?php echo "_" . $row['option_id'] ?>" class="my-input" type="text" placeholder=" <?php echo "Add a: " . $row['option_name'] ?> " />
          <div class="autocom-box">
            <!-- here list are inserted from javascript -->
          </div>
        </div>
      </label>
    </div>
 

  <?php } ?>
  </div>
  <script type='module'>



  </script>

</body>

</html>