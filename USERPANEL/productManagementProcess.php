<?php
require_once("../config/config.php");
require_once("../USERINTERFACE/authentfication.php");
$sellerTest = $_SESSION['customer']['client_id'];


if (isset($_REQUEST['optionName']) && isset($_REQUEST['valName']) && isset($_REQUEST['valPrice'])) {

    $optionName = $_REQUEST['optionName'];
    $valueName = $_REQUEST['valName'];
    $valuePrice = $_REQUEST['valPrice'];
    if (isset($_SESSION['optionTestBuffer'][$optionName])) {
        $option_id = $_SESSION['optionTestBuffer'][$optionName];
        addValue($valueName, $valuePrice, $option_id);
    }
}



function addValue($valueName, $valuePrice, $optionId)
{

    global $pdo;

    $statement = $pdo->prepare("SELECT MAX(value_id) FROM `option_values` WHERE option_values_id = ? ");
    $statement->execute(array($optionId));
    $result = $statement->fetchColumn();

    var_dump($result);

    if ($result != 0) {

        $result = (int)$result;
        $result = $result + 1;

        $statement = $pdo->prepare("INSERT INTO `option_values` (`option_values_id`,`value_id`,`value_name`,`option_added_price`) VALUES (?,?,?,?)");
        $statement->execute(array($optionId, $result, $valueName, $valuePrice));
    } else {

        $result = 1;
        echo "condition is false:" . $result . '\n';
        $statement = $pdo->prepare("INSERT INTO `option_values` (`option_values_id`,`value_id`,`value_name`,`option_added_price`) VALUES (?,?,?,?)");
        $statement->execute(array($optionId, $result, $valueName, $valuePrice));
    }


    $statement = $pdo->prepare("INSERT INTO `product_options` (`product_option_values_id`,`option_id`,`option_value`,`is_unified`) VALUES (?,?,?,?)");
    $statement->execute(array($_SESSION['prodId'], $optionId, $result, '0'));
}

if (isset($_REQUEST['prodId'])) {

    $_SESSION['optionTestBuffer'] = (array) null;
    $_SESSION['valueTestBuffer'] = (array) null;
    $_SESSION['prodId'] = $_REQUEST['prodId'];
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

                    $optionsBuffer[$option['option_name']][] = getOptionName($row['option_id'], $row['option_value']);

                    $_SESSION['optionTestBuffer'][$option['option_name']] = $option['option_id'];

                    $name = getOptionName($row['option_id'], $row['option_value']);
                    $_SESSION['valueTestBuffer'][$name[0]] = $row['option_value'];

                    $tempo = $option['option_name'];
                }
            }
        } elseif ($oldvalue == $row['option_id']) {

            $optionsBuffer[$tempo][] = getOptionName($row['option_id'], $row['option_value']);

            $name = getOptionName($row['option_id'], $row['option_value']);
            $_SESSION['valueTestBuffer'][$name[0]] = $row['option_value'];
        }
    }


    $options_buffer['options'] = $optionsBuffer;

    $optionTestBuffer = $optionsBuffer;


    $statement = $pdo->prepare('SELECT client_name,client_id FROM client WHERE client_id=? ;');
    $statement->execute(array($product_info['product_seller_id']));
    $seller_name = $statement->fetch(PDO::FETCH_ASSOC);


    $Response = array_merge($product_info, $options_buffer, $seller_name);
    ob_clean();
    echo json_encode($Response);
}

if (isset($_REQUEST['optionValue'])) {
    $valueName = $_REQUEST['optionValue'];
    $optionName = $_REQUEST['optionName'];
    var_dump($_SESSION['valueTestBuffer']);
    if(count($_SESSION['valueTestBuffer']) > 1){
    if (isset($_SESSION['valueTestBuffer'][$valueName]) && isset($_SESSION['optionTestBuffer'][$optionName])) {
        $value_id = $_SESSION['valueTestBuffer'][$valueName];
        $option_id = $_SESSION['optionTestBuffer'][$optionName];
        $statment = $pdo->prepare('DELETE FROM product_options WHERE option_id = ? and option_value = ?');
        $statment->execute(array($option_id, $value_id));

        $statment = $pdo->prepare('DELETE FROM option_values WHERE option_values_id = ? and value_id = ?');
        $statment->execute(array($option_id, $value_id));
        ob_clean();
        echo "SUCCESS";
    }else{
        var_dump($_SESSION['valueTestBuffer']);
    }
}else{
    ob_clean();
    echo "You cant delete last element";
}
}


if(isset($_REQUEST['name'])){
    $p_id = $_SESSION['prodId'];
    $name = $_REQUEST['name'];
    $qty = $_REQUEST['qty'];
    $price = $_REQUEST['price'];
    $statment = $pdo->prepare('UPDATE product SET product_name=?,product_qty=?,product_price=? WHERE product_id = ?');
    $statment->execute(array($name, $qty,$price, $p_id));
    ob_clean();
    echo "SUCCES";
}