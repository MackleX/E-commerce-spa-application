<?php
require_once("../config/config.php");
// Check if the customer is logged in or not
require_once("../userinterface/authentfication.php");
?>
<?php if (isset($_REQUEST['graph'])) {
}
?>
<?php if (isset($_REQUEST['id'])) {


  $id = $_REQUEST['id'];
  $isAdminRequest = false;
  $isClientRequest = false;
  $isHimSelfRequest = false;
  $profileInfo = (array) null;
}
if (isset($id)) {

  if ($id == $_SESSION['customer']['client_id']) {
    $isHimSelfRequest = true;


    $profileInfo = $_SESSION['customer'];
  } else {


    $isClientRequest = true;
    $statement = $pdo->prepare("SELECT * FROM client WHERE client_id=? ");
    $statement->execute(array($id));
    $customerInfo = $statement->fetch(PDO::FETCH_ASSOC);
    $profileInfo = $customerInfo;
  }


  $statement = $pdo->prepare("SELECT product_buyed_quantity FROM payment_details WHERE seller_id=? ");
  $statement->execute(array($profileInfo['client_id']));
  $Result = $statement->fetchAll(PDO::FETCH_ASSOC);

  $totalProductCount = 0;

  foreach ($Result as $row) {
    $totalProductCount += $row['product_buyed_quantity'];
  }


  $statement = $pdo->prepare("SELECT count(*) FROM followers WHERE followed_id=? ");
  $statement->execute(array($profileInfo['client_id']));
  $count = $statement->fetchColumn();


  $totalFollowerCount = $count;


  $statement = $pdo->prepare("SELECT tag FROM tags WHERE seller_id = ?");
  $statement->execute(array($profileInfo['client_id']));
  $tags = $statement->fetchAll(PDO::FETCH_ASSOC);



  $statement = $pdo->prepare("SELECT count(*) FROM followers WHERE followed_id = ? AND following_id = ?; ");
  $statement->execute(array($profileInfo['client_id'], $_SESSION['customer']['client_id']));
  $count = $statement->fetchColumn();
  if ($count == 0) {
    $isFollower = false;
  } else {
    $isFollower = true;
  }


?>


  <div class="main-panel">
    <?php require_once('../CROSSPAGESELEMENTS/nav-bar.php'); ?>
    <div class="content">
      <div class="container-fluid">



        <div class="card" style="background-color: whitesmoke;">
          <div class="card-header card-header-primary">
            <?php if($isHimSelfRequest){?>
            <h4 class="card-title">My profile</h4>
            <?php }else if($isClientRequest){ ?>
              <h4 class="card-title"> <?php echo $profileInfo['client_name']; ?> profile</h4>
            <?php } ?>
          </div>
          <div class="card-body ">
          <br>
          <br>
            <div class="row">

              <div class="col-md-9">
                <div class="row">
                  <div class="col-md-6">
                    <div class="card card-stats">
                      <div class="card-header card-header-warning card-header-icon">
                        <div class="card-icon">
                          <i class="material-icons">content_copy</i>
                        </div>
                        <p class="card-category">Sellled Product</p>

                        <h3 class="card-title"><?php echo $totalProductCount ?>
                          <small>Units Selled</small>
                        </h3>
                      </div>
                      <div class="card-footer">
                        <div class="stats">
                          <a href="../HOMEPAGE/index.php?sellerId=<?php echo $profileInfo['client_id'] ?>" class="btn btn-warning btn-round">Show all user products</a>
                        </div>
                      </div>
                    </div>
                  </div>


                  <div class="col-md-6">
                    <div class="card card-stats">
                      <div class="card-header card-header-info card-header-icon">
                        <div class="card-icon">
                          <i class="fa fa-twitter"></i>
                        </div>
                        <p class="card-category">Followers</p>
                        <h3 id="followerCount" class="card-title">+<?php echo $totalFollowerCount ?></h3>
                      </div>
                      <div class="card-footer">
                        <div class="stats">
                          <?php if ($isClientRequest) {
                            if ($isFollower) { ?>
                              <a id="followButton" href="javascript:follow();" class="btn btn-info btn-round">Unfollow</a>
                            <?php } else { ?>
                              <a id="followButton" href="javascript:follow();" class="btn btn-info btn-round">follow</a>
                            <?php } ?>
                          <?php } ?>

                        </div>
                      </div>
                    </div>

                  </div>
                </div>


                <div class="col-md-12">
                  <div class="card card-chart">
                    <div class="card-header card-header-warning">
                      <div class="ct-chart" id="websiteViewsChart"></div>
                    </div>
                    <div class="card-body">
                      <h4 class="card-title">Email Subscriptions</h4>
                      <p class="card-category">Last Campaign Performance</p>
                    </div>
                    <div class="card-footer">
                      <div class="stats">
                        <i class="material-icons">access_time</i> campaign sent 2 days ago
                      </div>

                    </div>
                  </div>
                </div>


              </div>



              <div class="col-md-3">
                <div class="card card-profile">
                  <div class="card-avatar">
                    <img src="" alt="">
                    <a href="javascript:;">
                      <img class="img" src="../assets/images/users/<?php echo $profileInfo['photo_name'] ?>">
                    </a>
                  </div>
                  <div class="card-body">
                    <h6 class="card-category text-gray">role</h6>
                    <h4 class="card-title"><?php echo $profileInfo['client_name']; ?></h4>
                    <p class="card-description">

                      <?php echo $profileInfo['description'] ?>

                    </p>

                    <?php if ($isClientRequest) { ?>


                      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#reportModal">
                        Report seller
                      </button>

                    <?php } elseif ($isHimSelfRequest) { ?>
                      <a href="../USERPANEL/client-profile-update.php" class="btn btn-primary btn-round">Update</a>
                    <?php }?>


                    <p class="card">
                      <?php if ($isClientRequest || $isHimSelfRequest) { ?>
                    <h4 class="card-title">Tags:</h4>
                    <div class="card-body">
                      <?php foreach ($tags as $row) { ?>
                        <div><?php echo $row['tag'] ?></div>
                      <?php } ?>
                    </div>
                    </p>
                  <?php } ?>
                  </div>

                </div>





              </div>




            </div>
          </div>
        </div>
      </div>
    </div>




  </div>


  </div>





  </div>
  <footer class="footer">
    <div class="container-fluid">
      <nav class="float-left">
        <ul>
          <li>
            <a href="https://www.creative-tim.com">
              Creative Tim
            </a>
          </li>
          <li>
            <a href="https://creative-tim.com/presentation">
              About Us
            </a>
          </li>
          <li>
            <a href="http://blog.creative-tim.com">
              Blog
            </a>
          </li>
          <li>
            <a href="https://www.creative-tim.com/license">
              Licenses
            </a>
          </li>
        </ul>
      </nav>
      <div class="copyright float-right">
        &copy;
        <script>
          document.write(new Date().getFullYear())
        </script>, made with <i class="material-icons">favorite</i> by
        <a href="https://www.creative-tim.com" target="_blank">Creative Tim</a> for a better web.
      </div>
    </div>
  </footer>


  <!-- Modal -->
  <div class="modal fade" id="reportModal" tabindex="-1" role="dialog" aria-labelledby="reportModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="reportModalLabel">Report</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="exampleFormControlTextarea1">Write your reports</label>
            <br>
            <textarea class="form-control" id="report_text" rows="5"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button id="close" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" onclick="submitReport(0)"> Submit report</button>
        </div>
      </div>
    </div>
  </div>

  <script>
    function submitReport(itemType) {
      let params = new URLSearchParams(location.search);
      let reportedProfile = params.get('id');
      let text = $("#report_text").val();
      $.ajax({
        type: 'POST',
        url: '../profile/php-profile-process.php',
        dataType: 'html',
        data: {
          reportedProfileId: reportedProfile,
          reportText: text,
          itemType: itemType
        },
        success: function(data) {
          alert(data);
          $("#close").click();
        },
        error: function(data) {
          console.log("error");
          alert(data);

        }
      })


    }

    function follow(isFollower) {
      let params = new URLSearchParams(location.search);
      let followedProfile = params.get('id');
      $.ajax({
        type: 'POST',
        url: '../profile/php-profile-process.php',
        dataType: 'html',
        data: {
          followedProfile: followedProfile
        },
        success: function(data) {
          debugger;
          count = $('#followerCount').text().substr(1);
          count = parseInt(count, 10)
          if (data == 'followed') {
            count = count + 1
            debugger;
            $('#followerCount').text("+" + count)
            $('#followButton').get(0).innerHTML = "Unfollow"
          } else if (data == 'unfollowed') {
            count = count - 1;
            $('#followerCount').text("+" + count)
            $('#followButton').get(0).innerHTML = "follow"
          }
        },
        error: function(data) {
          console.log("error");

        }
      })

    }
  </script>






<?php } else {
  header('location' . '../homepage/index.php');
} ?>