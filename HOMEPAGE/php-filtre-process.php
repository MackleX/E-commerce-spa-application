<?php require_once('./header.php') ?>

<?php
ob_end_clean();



if (isset($_REQUEST['suggestions_id'])) {

    $suggestions_id = $_REQUEST['suggestions_id'];
    $statement = $pdo->prepare("SELECT * FROM option_values WHERE option_values_id = :id");
    $statement->execute([':id' => $suggestions_id]);
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    echo json_encode($result);
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
                        if ($mid_top_cat_id[$i] == $id) {
                            array_push($arr1_, $mid_cat_id[$i]);
                            for ($j = 0; $j < count($end_mid_cat_id); $j++) {
                                if ($end_mid_cat_id[$j] == $mid_cat_id[$i]) {
                                    if (!in_array($end_cat_id[$i], $chosen_ids)) {
                                        array_push($chosen_ids, $mid_cat_id[$i]);
                                    }
                                }
                            }
                        }
                    }
                }
            } elseif ($key == 'midCat' && !empty($value) && empty($arrayo->endCat)) {
                $chosen_ids = (array) null;
                foreach ($value as $id) {
                    for ($j = 0; $j < count($end_mid_cat_id); $j++) {
                        if ($end_mid_cat_id[$j] == $id) {
                            if (!in_array($end_cat_id[$j], $chosen_ids)) {
                                array_push($chosen_ids, $end_cat_id[$j]);
                            }
                        }
                    }
                }
            } elseif ($key == "endCat" && !empty($value)) {
                $chosen_ids = $value;
            }
        }
    }



    if (empty($chosen_ids)) {

        $chosen_ids = $end_cat_id;
    }

    $buffer = (array) null;

    foreach ($chosen_ids as $id) {

        $statement = $pdo->prepare("SELECT * FROM product WHERE ecat_id = :id");
        $statement->execute([':id' => $id]);
        while ($row = $result = $statement->fetchAll(PDO::FETCH_ASSOC)) {
            $buffer[] = $row;
        }
    }

    echo json_encode($buffer);
} elseif (isset($_REQUEST['prodId'])) {


    $id = $_REQUEST['prodId'];

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

        $statement = $pdo->prepare("SELECT value_name FROM option_values WHERE option_values_id =? and value_id= ?");
        $statement->execute(array($option_id, $option_value));
        $value_name = $statement->fetch(PDO::FETCH_ASSOC);

        return $value_name['value_name'];
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
    $statement->execute(array($product_info['product_images']));

    $images_name = $statement->fetchAll(PDO::FETCH_ASSOC);

    foreach ($images_name as $imagename) {
        $images['images'][] = $imagename['images'];
    }

    $statement = $pdo->prepare('SELECT client_name,client_id FROM client WHERE client_id=? ;');
    $statement->execute(array($product_info['product_seller_id']));
    $seller_name = $statement->fetch(PDO::FETCH_ASSOC);
    $Response = array_merge($product_info,$options_buffer,$images,$seller_name);

    $statement = $pdo->prepare('UPDATE product SET product_total_view = product_total_view + 1 WHERE product_id = ?');
    $statement->execute(array(($product_info['product_id'])));
    echo json_encode($Response);
}






?>