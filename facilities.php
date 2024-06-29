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
    <title><?php echo $settings_r['site_title'] ?> - Dịch Vụ và Tiện Ích</title>
    <style>
      .pop:hover{
        border-top-color:  var(--teal) !important;
        transform: scale(1.03);
        transition: all 0.3s;
      }
    </style>
   
  </head>
  <body class="bg-light">

   <?php require('inc/header.php'); ?>
   
    <div class="my-5 px-4">
        <h2 class="fw-bold h-font text-center">DỊCH VỤ & TIỆN ÍCH</h2>
        <div class="h-line bg-dark"></div>
        <p class="text-center mt-3">
        Tại TAI_HOTEL, chúng tôi luôn hướng tới dich vụ tốt nhất và chu đáo nhất với lòng hiếu khách
         - những người thực sự quý mến người khác và muốn làm cho kỳ nghỉ của họ với chúng tôi thực sự đáng nhớ.
          Đội ngũ chuyên nghiệp của chúng tôi đã xây dựng nên.
        </p>
    </div>
    <div class="container">
      <div class="row">
        <?php
            $res = selectAll('facilities');
            $path = FACILITIES_IMG_PATH;
            while($row = mysqli_fetch_assoc($res)){
              echo <<<data
                  <div class="col-lg-4 col-md-6 mb-5 px-4">
                      <div class="bg-white rounded shadow p-4 border-top border-4 border-dark pop">
                          <div class="d-flex align-items-center mb-2">
                            <img src="$path$row[icon]" width="40px">
                            <h5 class="m-0 ms-3">$row[name]</h5>
                          </div>
                          <p>$row[description]</p>
                      </div>
                  </div>
              data;
            }

        ?>
        <!-- html -->
        <!-- <div class="col-lg-4 col-md-6 mb-5 px-4">
          <div class="bg-white rounded shadow p-4 border-top border-4 border-dark pop">
            <div class="d-flex align-items-center mb-2">
              <img src="images/facilities/wifi.svg" width="40px">
              <h5 class="m-0 ms-3">Wifi</h5>
            </div>
            <p>
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Sunt ad sequi, quis eos accusantium nemo totam.
            </p>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 mb-5 px-4">
          <div class="bg-white rounded shadow p-4 border-top border-4 border-dark pop">
            <div class="d-flex align-items-center mb-2">
              <img src="images/facilities/wifi.svg" width="40px">
              <h5 class="m-0 ms-3">Wifi</h5>
            </div>
            <p>
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Sunt ad sequi, quis eos accusantium nemo totam.
            </p>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 mb-5 px-4">
          <div class="bg-white rounded shadow p-4 border-top border-4 border-dark pop">
            <div class="d-flex align-items-center mb-2">
              <img src="images/facilities/wifi.svg" width="40px">
              <h5 class="m-0 ms-3">Wifi</h5>
            </div>
            <p>
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Sunt ad sequi, quis eos accusantium nemo totam.
            </p>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 mb-5 px-4">
          <div class="bg-white rounded shadow p-4 border-top border-4 border-dark pop">
            <div class="d-flex align-items-center mb-2">
              <img src="images/facilities/wifi.svg" width="40px">
              <h5 class="m-0 ms-3">Wifi</h5>
            </div>
            <p>
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Sunt ad sequi, quis eos accusantium nemo totam.
            </p>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 mb-5 px-4">
          <div class="bg-white rounded shadow p-4 border-top border-4 border-dark pop">
            <div class="d-flex align-items-center mb-2">
              <img src="images/facilities/wifi.svg" width="40px">
              <h5 class="m-0 ms-3">Wifi</h5>
            </div>
            <p>
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Sunt ad sequi, quis eos accusantium nemo totam.
            </p>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 mb-5 px-4">
          <div class="bg-white rounded shadow p-4 border-top border-4 border-dark pop">
            <div class="d-flex align-items-center mb-2">
              <img src="images/facilities/wifi.svg" width="40px">
              <h5 class="m-0 ms-3">Wifi</h5>
            </div>
            <p>
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Sunt ad sequi, quis eos accusantium nemo totam.
            </p>
          </div>
        </div> -->
      </div>
    </div>
   

   <?php require('inc/footer.php');?>

  </body>
</html>