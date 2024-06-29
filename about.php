<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <?php require('inc/link.php');?>
    <title><?php echo $settings_r['site_title'] ?> - About</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
    <style>
      .box{
        border-top-color: var(--teal) !important;
      }
     
    </style>
   
  </head>
  <body class="bg-light">

   <?php require('inc/header.php'); ?>
    <div class="my-5 px-4">
          <h2 class="fw-bold h-font text-center">VỀ CHÚNG TÔI</h2>
          <div class="h-line bg-dark"></div>
          <p class="text-center mt-3">
            <?php echo $settings_r['site_about'] ?>
          </p>
    </div>

    <div class="container">
      <div class="row justify-content-between align-items-center ">
        <div class="col-lg-6 col-md-5 mb-4 order-lg-1 order-md-1 order-2">
          <h3 class="mb-3">TỔNG GIÁM ĐỐC</h3>
          <p> Với niềm đam mê đam mê nghề nghiệp, TAI_HOTEL cam kết mang lại sản phẩm 
            - dịch vụ trên cả mong đợi hướng tới khách hàng, tận tụy với khách hàng, 
            tâm huyết với công việc, luôn quan tâm thể hiện những chuẩn mực Bề ngoài đạo đức đối với khách hàng, 
            đối tác, những mối quan hệ xung quanh, cộng đồng và xã hội. TAI_HOTEL xây dựng các mối quan hệ với khách hàng, 
            đối tác, đồng nghiệp và xã hội bằng sự thiện chí, tình thân ái, tinh thần nhân văn.
          </p>
        </div>
        <div class="col-lg-5 col-md-5 mb-4 order-lg-2 order-md-2 order-1">
          <img src="images/about/tantai.jpg" class="w-100 rounded-start-circle">
        </div>
      </div>
    </div>
    
    <div class="container mt-5">
      <div class="row">
        <div class="col-lg-3 col-md-6 mb-4 px-4">
          <div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
              <img src="images/about/hotel.svg" width="70px">
              <h4 class="mt-3">100+ PHÒNG</h4>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4 px-4">
          <div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
              <img src="images/about/customers.svg" width="70px">
              <h4 class="mt-3">200+ KHÁCH HÀNG</h4>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4 px-4">
          <div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
              <img src="images/about/rating.svg" width="70px">
              <h4 class="mt-3">150+ ĐÁNH GIÁ</h4>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4 px-4">
          <div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
              <img src="images/about/staff.svg" width="70px">
              <h4 class="mt-3">200+ NHÂN VIÊN</h4>
          </div>
        </div>
      </div>
    </div>
    
    <h3 class="my-5 fw-bold h-font text-center">ĐỘI NHÓM</h3>
    <div class="container px-4">
        <div class="swiper mySwiper">
          <div class="swiper-wrapper mb-5">
            <?php 
              $about_r = selectAll('team_details');
              $path = ABOUT_IMG_PATH;
              while($row = mysqli_fetch_assoc($about_r)){
                echo <<<data
                <div class="swiper-slide bg-wite text-center overflow-hidden rounded">
                  <img src="$path$row[picture]" class="w-100">
                  <h5 class="mt-2">$row[name]</h5>
                </div>

                data;
              }
            
            ?>

            <!-- <div class="swiper-slide bg-wite text-center overflow-hidden rounded">
              <img src="images/about/people.jpg" class="w-100">
              <h5 class="mt-2">RANDOM NAME</h5>
            </div>
            <div class="swiper-slide bg-wite text-center overflow-hidden rounded">
              <img src="images/about/people.jpg" class="w-100">
              <h5 class="mt-2">RANDOM NAME</h5>
            </div>
            <div class="swiper-slide bg-wite text-center overflow-hidden rounded">
              <img src="images/about/people.jpg" class="w-100">
              <h5 class="mt-2">RANDOM NAME</h5>
            </div>
            <div class="swiper-slide bg-wite text-center overflow-hidden rounded">
              <img src="images/about/people.jpg" class="w-100">
              <h5 class="mt-2">RANDOM NAME</h5>
            </div>
            <div class="swiper-slide bg-wite text-center overflow-hidden rounded">
              <img src="images/about/people.jpg" class="w-100">
              <h5 class="mt-2">RANDOM NAME</h5>
            </div>
            <div class="swiper-slide bg-wite text-center overflow-hidden rounded">
              <img src="images/about/people.jpg" class="w-100">
              <h5 class="mt-2">RANDOM NAME</h5>
            </div> -->
            
           
          </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>

   <?php require('inc/footer.php');?>

    
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>

    <script>
      var swiper = new Swiper(".mySwiper", {
        slidesPerView: 4,
        spaceBetween: 40,
        pagination: {
          el: ".swiper-pagination",
        },
        breakpoints: {
        320: {
            slidesPerView: 1,
        },
        640: {
            slidesPerView: 1,
        },
        768: {
            slidesPerView: 2,
        },
        1024: {
            slidesPerView: 3,
        }
      }
      });
    </script>

  </body>
</html>