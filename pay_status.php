<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!--swiperjs  -->
    <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css"/>
    <?php require('inc/link.php');?>
    <style>
      .pop:hover{
        border-top-color:  var(--teal) !important;
        transform: scale(1.03);
        transition: all 0.3s;
      }
    </style>
    <title><?php echo $settings_r['site_title'] ?> - BOOKING STATUS</title>
   
  </head>
  <body class="bg-light">

   <?php require('inc/header.php'); ?>
     
   <div class="container">
    <div class="row">
        <div class="col-12 mb-4 my-5 px-4">
            <h2 class="fw-bold">STATUS THANH TOÁN</h2>
        </div>
        <?php 


          $frm_data = filteration($_GET);
          if(!(isset($_SESSION['login']) && $_SESSION['login'] == true)){
            redirect('index.php');
          }

          $booking_q = "SELECT bo.*, bd.* FROM `booking_order` bo
          INNER JOIN `booking_detail` bd ON bo.booking_id = bd.booking_id
          WHERE bo.order_id=? AND bo.user_id=? AND bo.booking_status!=?";

          $booking_res = select($booking_q,[$frm_data['order'],$_SESSION['uId'],'pending'],'sis');
          if(mysqli_num_rows($booking_res)==0)
          {
            redirect('index.php');
          }

          $booking_fetch = mysqli_fetch_array($booking_res);

          if($booking_fetch['trans_status']=="TXN_SUCCESS")
          {
            echo<<<data
              <div class="col-12 px-4">
                <p class="fw-bold alert alert-success">
                  <i class="bi bi-check-circle-fill"></i>
                  Thanh Toán Thành Công! Đặt phòng Thành công.
                  <br></br>
                  <a href="bookings.php">Đi Tới Hồ Sơ Đặt Phòng</a>
                </p>
              </div>
            data;
          }
          else{
            echo<<<data
              <div class="col-12 px-4">
                <p class="fw-bold alert alert-danger">
                <i class="bi bi-exclamation-triangle-fill"></i>
                  Thanh Toán Thất Bại! $booking_fetch[trans_resp_msg]
                  <br></br>
                  <a href="bookings.php">Đi Tới Hồ Sơ Đặt Phòng</a>
                </p>
              </div>
            data;
          }

        ?>

    </div>
   </div>

   <?php require('inc/footer.php');?>

  </body>
</html>