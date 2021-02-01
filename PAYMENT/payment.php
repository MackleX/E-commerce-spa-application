<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Ajax Stripe</title>

  <!-- These styles are for demo purpose can be put in an external stylesheet
  or completely removed -->
  <style media="screen" type="text/css">
    html {
      background-color: #e8ebef;
    }

    #payment-container {
      width: 600px;
      margin-left: auto;
      margin-right: auto;
      border: 1px solid #d9dce3;
      box-shadow: 0 0 1px 1px rgba(80, 84, 92, .1), 0 1px 2px rgba(80, 84, 92, .5);
      border-radius: 5px;
      background: #ffffff;
      color: #444;
      font-family: proxima-nova, "Helvetica Neue", Helvetica, Arial, sans-serif;
    }

    #payment-title {
      font-size: 1.5em;
      font-weight: 500;
      padding: 10px;
    }

    #payment-button {
      margin: 10px;
      padding: 10px;
      font-size: 15px;
    }

    #ajax-response {
      border-top: 1px solid #d9dce3;
      margin-top: 40px;
      margin-bottom: 0px;
      padding: 10px;
      color: #6c767f;
      background: #fafbfc;
    }
  </style>

</head>

<body>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
  <script src="https://checkout.stripe.com/checkout.js"></script>
  <?php if($cartRequest){?> 
  <script>

    var handler = StripeCheckout.configure({
      // Put you publishable API key here. I can be found at https://dashboard.stripe.com/account/apikeys
      key: 'pk_test_51IGPGkIZi3lujjoDcBgO8WklHxXYPC6q5dJq6vAsvYSacU6e7fU80wmxGu6vLUUj2E81pHjnr0dwbVTF4gJA48GF00xSj6NwQN',
      image: 'https://stripe.com/img/documentation/checkout/marketplace.png',
      locale: 'auto',
      token: function(token) {
        $.ajax({
            method: 'POST',
            // Put the path of your server side script here
            url: '../payment/ajax.php',
            data: {
              stripeToken: token.id,
              stripeEmail: token.email
            }
          })
          .done(function(msg) {
            $('#ajax-response').html(msg);
            console.log(msg);
            $(".my_content_table").get(0).innerHTML = `<thead class="">
                                                    <th>
                                                        Serial
                                                    </th>
                                                    <th>
                                                        Product name
                                                    </th>
                                                    <th>
                                                        Product photo
                                                    </th>
                                                    <th>
                                                        Product options
                                                    </th>
                                                    <th>
                                                        Quantity
                                                    </th>
                                                    <th>
                                                        Total Price
                                                    </th>
                                                </thead>";`
          })
          .fail(function(jqXHR, textStatus) {
            $('ajax-response').html('Something went wrong with the Ajax Call:' + textStatus);
          })
      }
    });
  
    
      $('#payment-button').on('click', function(e) {
        // Open Checkout with further options:
        console.log("YO MAN WORKING")
        handler.open({
          name: 'StripeApi.com',
          description: 'Attention: transaction will be made see charge bellow',
          amount: <?php echo $_SESSION["totalBill"] * 10; ?>
        });
        e.preventDefault();
      });
   
    // Close Checkout on page navigation:
    $(window).on('popstate', function() {
      handler.close();
    });

  </script>
  <?php }?>
</body>

</html>