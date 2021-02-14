<?php require_once('./header.php') ?>

<?php
ob_end_clean();



if (isset($_REQUEST['suggestions_id'])) {

    $suggestions_id = $_REQUEST['suggestions_id'];
    $statement = $pdo->prepare("SELECT * FROM option_values WHERE option_values_id = :id");
    $statement->execute([':id' => $suggestions_id]);
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    echo json_encode($result);
    exit;
}


if (isset($_REQUEST['sellerId'])) {

    $statement = $pdo->prepare("SELECT * FROM product WHERE product_seller_id = :id ");
    $statement->execute([':id' => $_REQUEST['sellerId']]);
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $row) {

        $buffer[] = $row;
    }
    echo json_encode($result);
    exit;
}


$chosen_ids = (array) null;

if (isset($_REQUEST['jsondata'])) {
    $arrayo = array();
    $arrayo = json_decode($_REQUEST['jsondata']);
    $chosen_ids = (array) null;

    foreach ($arrayo as $key => $value) {

        if ($key == 'topCat' || $key == 'midCat' || $key == 'endCat') {
            $arr1_ = array();
            $arr2_ = array();


            if ($key == 'topCat' && !empty($value) && empty($arrayo->midCat) && empty($arrayo->endCat)) {

                foreach ($value as $id) {
                    for ($i = 0; $i < count($mid_cat_id); $i++) {

                        if ($mid_to_top_cat_id[$i] == $id) {


                            array_push($arr1_, $mid_cat_id[$i]);


                            for ($j = 0; $j < count($end_to_mid_cat_id); $j++) {
                                if ($end_to_mid_cat_id[$j] == $mid_cat_id[$i]) {



                                    if (!(in_array($end_cat_id[$j], $chosen_ids))) {
                                        array_push($chosen_ids, $end_cat_id[$j]);
                                    }




                                }
                            }
                        }
                    }
                }
                if(empty($chosen_ids)){$chosen_ids = array(0);}
            } elseif ($key == 'midCat' && !empty($value) && empty($arrayo->endCat)) {
                $chosen_ids = (array) null;
                foreach ($value as $id) {
                    for ($j = 0; $j < count($end_to_mid_cat_id); $j++) {
                        if ($end_to_mid_cat_id[$j] == $id) {
                            if (!in_array($end_cat_id[$j], $chosen_ids)) {
                                array_push($chosen_ids, $end_cat_id[$j]);
                            }
                        }
                    }
                }
                if(empty($chosen_ids)){$chosen_ids = array(0);}
            } elseif ($key == "endCat" && !empty($value)) {
                $chosen_ids = $value;
            }
        }
    }



    if (empty($chosen_ids)) {

        $chosen_ids = $end_cat_id;
    }

    $buffer = (array) null;


    $anOptionIsSelected = false;

    foreach ($arrayo as $key => $value) {

        if ($key == 'filtreOption') {

            foreach ($value as $option) {
                $option_id = $option->option_id;
                $selectedOptions = $option->array;
                if (!empty($selectedOptions)) {
                    $anOptionIsSelected = true;
                }

                foreach ($selectedOptions as $value_name) {

                    foreach ($chosen_ids as $id) {

                        $statement = $pdo->prepare("SELECT * FROM product JOIN product_options ON product_option_values_id = product_id JOIN option_values ON option_values_id = option_id WHERE ecat_id = :id AND option_id = :o_id AND value_name = :v_name ;");
                        $statement->execute([':id' => $id, 'o_id' => $option_id, 'v_name' => $value_name]);
                        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($result as $row) {

                            $buffer[] = $row;
                        }
                    }
                }
            }
        }
    }

    if ($anOptionIsSelected == false) {

        $buffer = (array) null;


        foreach ($chosen_ids as $id) {
            $statement = $pdo->prepare("SELECT * FROM product WHERE ecat_id = :id ");
            $statement->execute([':id' => $id]);
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            foreach ($result as $row) {

                $buffer[] = $row;
            }
        }
    }

    echo json_encode($buffer);
} elseif (isset($_REQUEST['prodId'])) {


    $id = $_REQUEST['prodId'];
    $_SESSION["prod_id"] = $id;
    $statement = $pdo->prepare("SELECT * FROM product WHERE product_id = ?");
    $statement->execute(array($id));
    $product_info = $statement->fetch(PDO::FETCH_ASSOC);

    $statement = $pdo->prepare("SELECT * FROM options");
    $statement->execute();
    $options = $statement->fetchAll(PDO::FETCH_ASSOC);



    $statement = $pdo->prepare("SELECT * FROM product_options WHERE product_option_values_id = :id");
    $statement->execute([':id' => $id]);
    $oldvalue = 0;
    $optionsBuffer = (array) null;



    function getOptionName($option_id, $option_value)
    {
        global $pdo;

        $statement = $pdo->prepare("SELECT value_name,option_added_price FROM option_values WHERE option_values_id =? and value_id= ?");
        $statement->execute(array($option_id, $option_value));
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        return array($result['value_name'], $result['option_added_price']);
    }

    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {


        if ($oldvalue == 0 || $oldvalue != $row['option_id']) {

            $oldvalue = $row['option_id'];

            foreach ($options as $option) {




                if ($option['option_id'] == $row['option_id']) {

                    $optionsBuffer[$option['option_name']] = array(getOptionName($row['option_id'], $row['option_value']));
                    $tempo = $option['option_name'];
                }
            }
        } elseif ($oldvalue == $row['option_id']) {

            $optionsBuffer[$tempo][] = getOptionName($row['option_id'], $row['option_value']);
        }
    }


    $options_buffer['options'] = $optionsBuffer;


    $statement = $pdo->prepare("SELECT images FROM images_table WHERE p_id=? ");
    $statement->execute(array($product_info['product_id']));

    $images_name = $statement->fetchAll(PDO::FETCH_ASSOC);

    foreach ($images_name as $imagename) {
        $images['images'][] = $imagename['images'];
    }

    $statement = $pdo->prepare('SELECT client_name,client_id FROM client WHERE client_id=? ;');
    $statement->execute(array($product_info['product_seller_id']));
    $seller_name = $statement->fetch(PDO::FETCH_ASSOC);
    $Response = array_merge($product_info, $options_buffer, $images, $seller_name);

    $statement = $pdo->prepare('UPDATE product SET product_total_view = product_total_view + 1 WHERE product_id = ?');
    $statement->execute(array(($product_info['product_id'])));
    echo json_encode($Response);
}






?>