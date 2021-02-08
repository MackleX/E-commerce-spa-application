<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8" />
    <title>Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../assets/styles/styleglass.css" />
</head>






<?php
require_once("../config/config.php");
$success_message = '';
$error_message = '';
if (isset($_POST['form1'])) {

    $valid = 1;

    if (empty($_POST['client_name'])) {
        $valid = 0;
        $error_message .= "Enter your name" . "<br>";
    }

    if (empty($_POST['client_email'])) {
        $valid = 0;
        $error_message .= "enter your mail" . "<br>";
    } else {
        if (filter_var($_POST['client_email'], FILTER_VALIDATE_EMAIL) === false) {
            $valid = 0;
            $error_message .= "enter a valid mail" . "<br>";
        } else {
            $statement = $pdo->prepare("SELECT * FROM client WHERE client_email=?");
            $statement->execute(array($_POST['client_email']));
            $total = $statement->rowCount();
            if ($total) {
                $valid = 0;
                $error_message .= "Aleardy existed mail" . "<br>";
            }
        }
    }

    if (empty($_POST['client_phone'])) {
        $valid = 0;
        $error_message .= "Enter your phone" . "<br>";
    }

    if (empty($_POST['client_address'])) {
        $valid = 0;
        $error_message .= "Enter your adresse" . "<br>";
    }

    if (empty($_POST['client_city'])) {
        $valid = 0;
        $error_message .= "Enter your city" . "<br>";
    }

    if (empty($_POST['client_state'])) {
        $valid = 0;
        $error_message .= "Enter your state" . "<br>";
    }

    if (empty($_POST['client_zip'])) {
        $valid = 0;
        $error_message .= "Enter your zip postale" . "<br>";
    }

    if (empty($_POST['client_password']) || empty($_POST['client_re_password'])) {
        $valid = 0;
        $error_message .= "Enter your password" . "<br>";
    }

    if (!empty($_POST['client_password']) && !empty($_POST['client_re_password'])) {
        if ($_POST['client_password'] != $_POST['client_re_password']) {
            $valid = 0;
            $error_message .= "Something went wrong whit password confirmation" . "<br>";
        }
    }

    if (!empty($_POST['client_password']) && !empty($_POST['client_re_password'])) {
        if ($_POST['client_password'] != $_POST['client_re_password']) {
            $valid = 0;
            $error_message .= "Something went wrong whit password confirmation" . "<br>";
        }
    }
    if (empty($_POST['country'])) {
            $valid = 0;
            $error_message .= "Please select your country" . "<br>";
    }

    if(!empty($_POST['sellerOption'])){
            if($_POST['sellerOption'] == "isSeller"){
                $seller = 1;
            }else{
                $seller = 2;
            }
    }


    if ($valid == 1) {

        $token = md5(time());
        $client_datetime = date('Y-m-d h:i:s');
        $client_timestamp = time();

        // saving into the database
        $statement = $pdo->prepare("INSERT INTO client (
                                        client_name,
                                        client_cname,
                                        client_email,
                                        client_phone,
                                        client_country,
                                        client_address,
                                        client_city,
                                        client_state,
                                        client_zip,
                                        client_s_name,
                                        client_s_phone,
                                        client_s_country,
                                        client_s_address,
                                        client_s_city,
                                        client_s_state,
                                        client_s_zip,
                                        client_password,
                                        client_token,
                                        client_datetime,
                                        client_timestamp,
                                        client_status,
                                        account_flag
                                    ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
        $statement->execute(array(
            strip_tags(htmlentities($_POST['client_name'])),
            strip_tags(htmlentities($_POST['client_cname'])),
            strip_tags(htmlentities($_POST['client_email'])),
            strip_tags(htmlentities($_POST['client_phone'])),
            strip_tags(htmlentities($_POST['country'])),
            strip_tags(htmlentities($_POST['client_address'])),
            strip_tags(htmlentities($_POST['client_city'])),
            strip_tags(htmlentities($_POST['client_state'])),
            strip_tags(htmlentities($_POST['client_zip'])),
            strip_tags(htmlentities($_POST['client_name'])),
            strip_tags(htmlentities($_POST['client_phone'])),
            strip_tags(htmlentities($_POST['country'])),
            strip_tags(htmlentities($_POST['client_address'])),
            strip_tags(htmlentities($_POST['client_city'])),
            strip_tags(htmlentities($_POST['client_state'])),
            strip_tags(htmlentities($_POST['client_zip'])),
            md5($_POST['client_password']),
            $token,
            $client_datetime,
            $client_timestamp,
            0,
            htmlentities($seller)
        ));

        // Send email for confirmation of the account

        $to = $_POST['client_email'];
        $verify_link = "localhost/mywebsite/registration/" . 'verify.php?email=' . $to . '&token=' . $token;

        unset($_POST['client_name']);
        unset($_POST['client_cname']);
        unset($_POST['client_email']);
        unset($_POST['client_phone']);
        unset($_POST['client_address']);
        unset($_POST['client_city']);
        unset($_POST['client_state']);
        unset($_POST['client_zip']);

        $success_message = "Everything went good, now please check your mail to verify your account.";
    }
} else {
    $error_message = "fill your data";
}
?>

<body>



    <div class="reg-page" style="background-color: lineare-gradient(to right top,#65dfc9,#6cdbeb)">
        <div class="circle1"></div>
        <div class="circle2"></div>
        <div class="registration-container glass">
            <div class="row centering">
                <div class="col-md-12 ">
                    <div class="user-content">



                        <form action="" method="post">


                            <div class="row ">
                                <div class="col-md-2"></div>
                                <div class="col-md-8">



                                    <?php
                                    if ($error_message != '') {
                                        echo "<div class='alert alert-danger text-center'  role='alert' >" . $error_message . "</div>";
                                    }
                                    if ($success_message != '') {
                                        echo "<div class='success' style='padding: 10px;background:#f1f1f1;margin-bottom:20px;'>" . $success_message . "</div>";
                                    }
                                    ?>


                                    <div class="cards">
                                        <div class="col-md-6 form-group card">
                                            <label for="" class="text-center"><?php echo "User name"; ?> *</label>

                                            <input type="text" class="form-control" name="client_name" value="<?php if (isset($_POST['client_name'])) {
                                                                                                                    echo $_POST['client_name'];
                                                                                                                } ?>">

                                        </div>
                                        <div class="col-md-6 form-group card">
                                            <label for="" class="text-center"><?php echo "Company Name"; ?></label>
                                            <input type="text" class="form-control" name="client_cname" value="<?php if (isset($_POST['client_cname'])) {
                                                                                                                    echo $_POST['client_cname'];
                                                                                                                } ?>">
                                        </div>
                                        <div class="col-md-6 form-group card">
                                            <label for="" class="text-center"><?php echo "E-mail"; ?> *</label>
                                            <input type="email" class="form-control" name="client_email" value="<?php if (isset($_POST['client_email'])) {
                                                                                                                    echo $_POST['client_email'];
                                                                                                                } ?>">
                                        </div>
                                        <div class="col-md-6 form-group card">
                                            <label for="" class="text-center"><?php echo "Phone number"; ?> *</label>
                                            <input type="text" class="form-control" name="client_phone" value="<?php if (isset($_POST['client_phone'])) {
                                                                                                                    echo $_POST['client_phone'];
                                                                                                                } ?>">
                                        </div>
                                        <div class="col-md-12 form-group card">
                                            <label for="" class="text-center"><?php echo "Adresse"; ?> *</label>
                                            <textarea name="client_address" class="form-control" cols="30" rows="10" style="height:70px;"><?php if (isset($_POST['client_address'])) {
                                                                                                                                                echo $_POST['client_address'];
                                                                                                                                            } ?></textarea>
                                        </div>


                                        <div class="col-md-6 form-group card">
                                            <label for="" class="text-center"><?php echo "City"; ?> *</label>
                                            <input type="text" class="form-control" name="client_city" value="<?php if (isset($_POST['client_city'])) {
                                                                                                                    echo $_POST['client_city'];
                                                                                                                } ?>">
                                        </div>
                                        <div class="col-md-6 form-group card">
                                            <label for="" class="text-center"><?php echo "State"; ?> *</label>
                                            <input type="text" class="form-control" name="client_state" value="<?php if (isset($_POST['client_state'])) {
                                                                                                                    echo $_POST['client_state'];
                                                                                                                } ?>">
                                        </div>
                                        <div class="col-md-6 form-group card">
                                            <label for="" class="text-center"><?php echo "Zip postal"; ?> *</label>
                                            <input type="text" class="form-control" name="client_zip" value="<?php if (isset($_POST['client_zip'])) {
                                                                                                                    echo $_POST['client_zip'];
                                                                                                                } ?>">
                                        </div>
                                        <div class="col-md-6 form-group card">
                                            <label for="" class="text-center"><?php echo "type your password"; ?> *</label>
                                            <input type="password" class="form-control" name="client_password">
                                        </div>

                                        <div class="col-md-6 form-group card">
                                            <label for="" class="text-center"><?php echo "confirm your password"; ?> *</label>
                                            <input type="password" class="form-control" name="client_re_password">
                                        </div>

                                        <div class="col-md-6 form-group card">
                                            <label for="" class="text-center"><?php echo "Choose your country"; ?> *</label>

                                            <select id="country" name="country">

                                                <option value="Afganistan">Afghanistan</option>
                                                <option value="Albania">Albania</option>
                                                <option value="Algeria">Algeria</option>
                                                <option value="American Samoa">American Samoa</option>
                                                <option value="Andorra">Andorra</option>
                                                <option value="Angola">Angola</option>
                                                <option value="Anguilla">Anguilla</option>
                                                <option value="Antigua & Barbuda">Antigua & Barbuda</option>
                                                <option value="Argentina">Argentina</option>
                                                <option value="Armenia">Armenia</option>
                                                <option value="Aruba">Aruba</option>
                                                <option value="Australia">Australia</option>
                                                <option value="Austria">Austria</option>
                                                <option value="Azerbaijan">Azerbaijan</option>
                                                <option value="Bahamas">Bahamas</option>
                                                <option value="Bahrain">Bahrain</option>
                                                <option value="Bangladesh">Bangladesh</option>
                                                <option value="Barbados">Barbados</option>
                                                <option value="Belarus">Belarus</option>
                                                <option value="Belgium">Belgium</option>
                                                <option value="Belize">Belize</option>
                                                <option value="Benin">Benin</option>
                                                <option value="Bermuda">Bermuda</option>
                                                <option value="Bhutan">Bhutan</option>
                                                <option value="Bolivia">Bolivia</option>
                                                <option value="Bonaire">Bonaire</option>
                                                <option value="Bosnia & Herzegovina">Bosnia & Herzegovina</option>
                                                <option value="Botswana">Botswana</option>
                                                <option value="Brazil">Brazil</option>
                                                <option value="British Indian Ocean Ter">British Indian Ocean Ter</option>
                                                <option value="Brunei">Brunei</option>
                                                <option value="Bulgaria">Bulgaria</option>
                                                <option value="Burkina Faso">Burkina Faso</option>
                                                <option value="Burundi">Burundi</option>
                                                <option value="Cambodia">Cambodia</option>
                                                <option value="Cameroon">Cameroon</option>
                                                <option value="Canada">Canada</option>
                                                <option value="Canary Islands">Canary Islands</option>
                                                <option value="Cape Verde">Cape Verde</option>
                                                <option value="Cayman Islands">Cayman Islands</option>
                                                <option value="Central African Republic">Central African Republic</option>
                                                <option value="Chad">Chad</option>
                                                <option value="Channel Islands">Channel Islands</option>
                                                <option value="Chile">Chile</option>
                                                <option value="China">China</option>
                                                <option value="Christmas Island">Christmas Island</option>
                                                <option value="Cocos Island">Cocos Island</option>
                                                <option value="Colombia">Colombia</option>
                                                <option value="Comoros">Comoros</option>
                                                <option value="Congo">Congo</option>
                                                <option value="Cook Islands">Cook Islands</option>
                                                <option value="Costa Rica">Costa Rica</option>
                                                <option value="Cote DIvoire">Cote DIvoire</option>
                                                <option value="Croatia">Croatia</option>
                                                <option value="Cuba">Cuba</option>
                                                <option value="Curaco">Curacao</option>
                                                <option value="Cyprus">Cyprus</option>
                                                <option value="Czech Republic">Czech Republic</option>
                                                <option value="Denmark">Denmark</option>
                                                <option value="Djibouti">Djibouti</option>
                                                <option value="Dominica">Dominica</option>
                                                <option value="Dominican Republic">Dominican Republic</option>
                                                <option value="East Timor">East Timor</option>
                                                <option value="Ecuador">Ecuador</option>
                                                <option value="Egypt">Egypt</option>
                                                <option value="El Salvador">El Salvador</option>
                                                <option value="Equatorial Guinea">Equatorial Guinea</option>
                                                <option value="Eritrea">Eritrea</option>
                                                <option value="Estonia">Estonia</option>
                                                <option value="Ethiopia">Ethiopia</option>
                                                <option value="Falkland Islands">Falkland Islands</option>
                                                <option value="Faroe Islands">Faroe Islands</option>
                                                <option value="Fiji">Fiji</option>
                                                <option value="Finland">Finland</option>
                                                <option value="France">France</option>
                                                <option value="French Guiana">French Guiana</option>
                                                <option value="French Polynesia">French Polynesia</option>
                                                <option value="French Southern Ter">French Southern Ter</option>
                                                <option value="Gabon">Gabon</option>
                                                <option value="Gambia">Gambia</option>
                                                <option value="Georgia">Georgia</option>
                                                <option value="Germany">Germany</option>
                                                <option value="Ghana">Ghana</option>
                                                <option value="Gibraltar">Gibraltar</option>
                                                <option value="Great Britain">Great Britain</option>
                                                <option value="Greece">Greece</option>
                                                <option value="Greenland">Greenland</option>
                                                <option value="Grenada">Grenada</option>
                                                <option value="Guadeloupe">Guadeloupe</option>
                                                <option value="Guam">Guam</option>
                                                <option value="Guatemala">Guatemala</option>
                                                <option value="Guinea">Guinea</option>
                                                <option value="Guyana">Guyana</option>
                                                <option value="Haiti">Haiti</option>
                                                <option value="Hawaii">Hawaii</option>
                                                <option value="Honduras">Honduras</option>
                                                <option value="Hong Kong">Hong Kong</option>
                                                <option value="Hungary">Hungary</option>
                                                <option value="Iceland">Iceland</option>
                                                <option value="Indonesia">Indonesia</option>
                                                <option value="India">India</option>
                                                <option value="Iran">Iran</option>
                                                <option value="Iraq">Iraq</option>
                                                <option value="Ireland">Ireland</option>
                                                <option value="Isle of Man">Isle of Man</option>
                                                <option value="Israel">Israel</option>
                                                <option value="Italy">Italy</option>
                                                <option value="Jamaica">Jamaica</option>
                                                <option value="Japan">Japan</option>
                                                <option value="Jordan">Jordan</option>
                                                <option value="Kazakhstan">Kazakhstan</option>
                                                <option value="Kenya">Kenya</option>
                                                <option value="Kiribati">Kiribati</option>
                                                <option value="Korea North">Korea North</option>
                                                <option value="Korea Sout">Korea South</option>
                                                <option value="Kuwait">Kuwait</option>
                                                <option value="Kyrgyzstan">Kyrgyzstan</option>
                                                <option value="Laos">Laos</option>
                                                <option value="Latvia">Latvia</option>
                                                <option value="Lebanon">Lebanon</option>
                                                <option value="Lesotho">Lesotho</option>
                                                <option value="Liberia">Liberia</option>
                                                <option value="Libya">Libya</option>
                                                <option value="Liechtenstein">Liechtenstein</option>
                                                <option value="Lithuania">Lithuania</option>
                                                <option value="Luxembourg">Luxembourg</option>
                                                <option value="Macau">Macau</option>
                                                <option value="Macedonia">Macedonia</option>
                                                <option value="Madagascar">Madagascar</option>
                                                <option value="Malaysia">Malaysia</option>
                                                <option value="Malawi">Malawi</option>
                                                <option value="Maldives">Maldives</option>
                                                <option value="Mali">Mali</option>
                                                <option value="Malta">Malta</option>
                                                <option value="Marshall Islands">Marshall Islands</option>
                                                <option value="Martinique">Martinique</option>
                                                <option value="Mauritania">Mauritania</option>
                                                <option value="Mauritius">Mauritius</option>
                                                <option value="Mayotte">Mayotte</option>
                                                <option value="Mexico">Mexico</option>
                                                <option value="Midway Islands">Midway Islands</option>
                                                <option value="Moldova">Moldova</option>
                                                <option value="Monaco">Monaco</option>
                                                <option value="Mongolia">Mongolia</option>
                                                <option value="Montserrat">Montserrat</option>
                                                <option value="Morocco">Morocco</option>
                                                <option value="Mozambique">Mozambique</option>
                                                <option value="Myanmar">Myanmar</option>
                                                <option value="Nambia">Nambia</option>
                                                <option value="Nauru">Nauru</option>
                                                <option value="Nepal">Nepal</option>
                                                <option value="Netherland Antilles">Netherland Antilles</option>
                                                <option value="Netherlands">Netherlands (Holland, Europe)</option>
                                                <option value="Nevis">Nevis</option>
                                                <option value="New Caledonia">New Caledonia</option>
                                                <option value="New Zealand">New Zealand</option>
                                                <option value="Nicaragua">Nicaragua</option>
                                                <option value="Niger">Niger</option>
                                                <option value="Nigeria">Nigeria</option>
                                                <option value="Niue">Niue</option>
                                                <option value="Norfolk Island">Norfolk Island</option>
                                                <option value="Norway">Norway</option>
                                                <option value="Oman">Oman</option>
                                                <option value="Pakistan">Pakistan</option>
                                                <option value="Palau Island">Palau Island</option>
                                                <option value="Palestine">Palestine</option>
                                                <option value="Panama">Panama</option>
                                                <option value="Papua New Guinea">Papua New Guinea</option>
                                                <option value="Paraguay">Paraguay</option>
                                                <option value="Peru">Peru</option>
                                                <option value="Phillipines">Philippines</option>
                                                <option value="Pitcairn Island">Pitcairn Island</option>
                                                <option value="Poland">Poland</option>
                                                <option value="Portugal">Portugal</option>
                                                <option value="Puerto Rico">Puerto Rico</option>
                                                <option value="Qatar">Qatar</option>
                                                <option value="Republic of Montenegro">Republic of Montenegro</option>
                                                <option value="Republic of Serbia">Republic of Serbia</option>
                                                <option value="Reunion">Reunion</option>
                                                <option value="Romania">Romania</option>
                                                <option value="Russia">Russia</option>
                                                <option value="Rwanda">Rwanda</option>
                                                <option value="St Barthelemy">St Barthelemy</option>
                                                <option value="St Eustatius">St Eustatius</option>
                                                <option value="St Helena">St Helena</option>
                                                <option value="St Kitts-Nevis">St Kitts-Nevis</option>
                                                <option value="St Lucia">St Lucia</option>
                                                <option value="St Maarten">St Maarten</option>
                                                <option value="St Pierre & Miquelon">St Pierre & Miquelon</option>
                                                <option value="St Vincent & Grenadines">St Vincent & Grenadines</option>
                                                <option value="Saipan">Saipan</option>
                                                <option value="Samoa">Samoa</option>
                                                <option value="Samoa American">Samoa American</option>
                                                <option value="San Marino">San Marino</option>
                                                <option value="Sao Tome & Principe">Sao Tome & Principe</option>
                                                <option value="Saudi Arabia">Saudi Arabia</option>
                                                <option value="Senegal">Senegal</option>
                                                <option value="Seychelles">Seychelles</option>
                                                <option value="Sierra Leone">Sierra Leone</option>
                                                <option value="Singapore">Singapore</option>
                                                <option value="Slovakia">Slovakia</option>
                                                <option value="Slovenia">Slovenia</option>
                                                <option value="Solomon Islands">Solomon Islands</option>
                                                <option value="Somalia">Somalia</option>
                                                <option value="South Africa">South Africa</option>
                                                <option value="Spain">Spain</option>
                                                <option value="Sri Lanka">Sri Lanka</option>
                                                <option value="Sudan">Sudan</option>
                                                <option value="Suriname">Suriname</option>
                                                <option value="Swaziland">Swaziland</option>
                                                <option value="Sweden">Sweden</option>
                                                <option value="Switzerland">Switzerland</option>
                                                <option value="Syria">Syria</option>
                                                <option value="Tahiti">Tahiti</option>
                                                <option value="Taiwan">Taiwan</option>
                                                <option value="Tajikistan">Tajikistan</option>
                                                <option value="Tanzania">Tanzania</option>
                                                <option value="Thailand">Thailand</option>
                                                <option value="Togo">Togo</option>
                                                <option value="Tokelau">Tokelau</option>
                                                <option value="Tonga">Tonga</option>
                                                <option value="Trinidad & Tobago">Trinidad & Tobago</option>
                                                <option value="Tunisia">Tunisia</option>
                                                <option value="Turkey">Turkey</option>
                                                <option value="Turkmenistan">Turkmenistan</option>
                                                <option value="Turks & Caicos Is">Turks & Caicos Is</option>
                                                <option value="Tuvalu">Tuvalu</option>
                                                <option value="Uganda">Uganda</option>
                                                <option value="United Kingdom">United Kingdom</option>
                                                <option value="Ukraine">Ukraine</option>
                                                <option value="United Arab Erimates">United Arab Emirates</option>
                                                <option value="United States of America">United States of America</option>
                                                <option value="Uraguay">Uruguay</option>
                                                <option value="Uzbekistan">Uzbekistan</option>
                                                <option value="Vanuatu">Vanuatu</option>
                                                <option value="Vatican City State">Vatican City State</option>
                                                <option value="Venezuela">Venezuela</option>
                                                <option value="Vietnam">Vietnam</option>
                                                <option value="Virgin Islands (Brit)">Virgin Islands (Brit)</option>
                                                <option value="Virgin Islands (USA)">Virgin Islands (USA)</option>
                                                <option value="Wake Island">Wake Island</option>
                                                <option value="Wallis & Futana Is">Wallis & Futana Is</option>
                                                <option value="Yemen">Yemen</option>
                                                <option value="Zaire">Zaire</option>
                                                <option value="Zambia">Zambia</option>
                                                <option value="Zimbabwe">Zimbabwe</option>

                                            </select>

                                        </div>

                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="isSeller" id="defaultCheck1" name="sellerOption">
                                            <label class="form-check-label" for="defaultCheck1">
                                                Seller Account
                                            </label>
                                        </div>
                                        <div class="col-md-6 form-group card special text-center">
                                            <label for=""></label>
                                            <input type="submit" class="btn btn-danger" value="<?php echo "submit results"; ?>" name="form1">
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>