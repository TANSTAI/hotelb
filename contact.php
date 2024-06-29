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
    <title><?php echo $settings_r['site_title'] ?> - CONTACT</title>
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
        <h2 class="fw-bold h-font text-center">LIÊN HỆ</h2>
        <div class="h-line bg-dark"></div>
        <p class="text-center mt-3">
          Để biết thêm thông tin về khách sạn TAI_HOTEL Sài Gòn, vui lòng điền vào mẫu dưới đây:
        </p>
    </div>

    <div class="container">
      <div class="row">
        <div class="col-lg-6 col-md-6 mb-5 px-4">
          <div class="bg-white rounded shadow p-4">
                  <iframe class="w-100 rounded mb-4" src="<?php echo $contact_r['iframe'] ?>" 
                    height="450" loading="lazy">
                  </iframe>
                  <h5>Địa chỉ</h5>
                  <a href="<?php echo $contact_r['gmap'] ?>" target="_blank" class="d-inline-block text-decoration-none text-dark mb-2">
                    <i class="bi bi-geo-alt-fill"></i> <?php echo $contact_r['address'] ?>
                  </a>
                  <h5 class="mt-4">Điện Thoại</h5>
                  <a href="tel: +<?php echo $contact_r['pn1'] ?>" class="d-inline-block mb-2 text-decoration-none text-dark">
                    <i class="bi bi-telephone-fill"></i> +<?php echo $contact_r['pn1'] ?>
                  </a>
                  <br>

                  <?php
                    //if pn2 exist
                    if($contact_r['pn2']!=''){
                      echo <<<data
                        <a href="tel: +$contact_r[pn2]" class="d-inline-bock text-decoration-none text-dark">
                        <i class="bi bi-telephone-fill"></i> +$contact_r[pn2]
                        </a>
                      data;
                    }
                    ?>

                  <h5 class="mt-4">Email</h5>
                  <a href="mailto: <?php echo $contact_r['email'] ?>" class="d-inline-block text-decoration-none text-dark">
                  <i class="bi bi-envelope-fill"></i> <?php echo $contact_r['email'] ?>
                  </a>

                  <h5 class="mt-4">Follow us</h5>
                    
                    <a href="<?php echo $contact_r['tw'] ?>" class="d-inline-block text-dark fs-5 me-2">
                       <i class="bi bi-twitter me-1"></i>
                    </a>
                    <a href="<?php echo $contact_r['fb'] ?>" class="d-inline-block text-dark fs-5 me-2">
                       <i class="bi bi-facebook me-1"></i>
                    </a>
                    <a href="<?php echo $contact_r['insta'] ?>" class="d-inline-block text-dark fs-5">
                       <i class="bi bi-instagram me-1"></i>
                    </a>
          </div>
        </div>

        <div class="col-lg-6 col-md-6 px-4">
          <div class="bg-white rounded shadow p-4">
                <form method="POST">
                  <h5 class="mb-3">Gửi Yêu Cầu</h5>
                  <div class="mb-3">
                        <label class="form-label" style="font-weight: 500;">Họ & Tên</label>
                        <input name="name" required type="text" class="form-control shadow-none">   
                  </div>
                  <div class="mb-3">
                        <label class="form-label" style="font-weight: 500;">Email</label>
                        <input name="email" required type="email" class="form-control shadow-none">   
                  </div>
                  <div class="mb-3">
                        <label class="form-label" style="font-weight: 500;">Chủ Đề</label>
                        <input name="subject" required type="text" class="form-control shadow-none">   
                  </div>
                  <div class="mb-3">
                        <label class="form-label" style="font-weight: 500;">Soạn Tin</label>
                        <textarea name="message" required class="form-control shadow-none" rows="5" style="resize: none;"></textarea>
                  </div>
                  <button type="submit" name="send" class="btn text-white custom-bg mt-3">Gửi</button>
                </form>
          </div>
        </div>
        
      </div>
    </div>

    <?php
    if(isset($_POST['send']))
    {
      $frm_data = filteration($_POST);

      $q = "INSERT INTO `user_queries`(`name`, `email`, `subject`, `message`) VALUES (?,?,?,?)";
      $values = [$frm_data['name'],$frm_data['email'],$frm_data['subject'],$frm_data['message']];
      $res = insert($q,$values,'ssss');
      if($res == 1){
        alert('success','Đã gửi Về hệ thống của chúng tôi');
      }
      else{
        alert('error','Server down!, Vui lòng thử lại.');
      }
    }
    ?>
   
   <?php require('inc/footer.php');?>
  </body>
</html>