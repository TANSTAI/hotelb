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
    <title><?php echo $settings_r['site_title'] ?> - PROFILE</title>
   
  </head>
  <body class="bg-light">

   <?php require('inc/header.php'); 
   
   if(!(isset($_SESSION['login']) && $_SESSION['login'] == true)){
    redirect('index.php');
    }

    $u_exist = select("SELECT * FROM `user_cred` WHERE `id`=? LIMIT 1",[$_SESSION['uId']],'s');
    if(mysqli_num_rows($u_exist)==0){
      redirect('index.php');
    } 
    
    $u_fetch = mysqli_fetch_assoc($u_exist);

   ?>

   <div class="container">
    <div class="row">

        <div class="col-12 my-5 px-4">
            <h2 class="fw-bold">THÔNG TIN CÁ NHÂN</h2>
            <div style="font-size: 14px;">
              <a href="index.php" class="text-secondary text-decoration-none">TRANG CHỦ</a>
              <span class="text-secondary"> > </span>
              <a href="profile.php" class="text-secondary text-decoration-none">PROFILE</a>
            </div>
        </div>
        <!-- profile -->
        <div class="col-12 mb-5 px-4">
            <div class="bg-white p-3 p-md-4 rounded shadow-sm">
              <form id="info-form">
                <h5 class="fw-bold mb-3">Thông Tin Cơ Bản</h5>
                <div class="row">
                  <div class="col-md-4 mb-3">
                    <label class="form-label">Họ & Tên</label>
                    <input name="name" type="text" value="<?php echo $u_fetch['name'] ?>" class="form-control shadow-none" required>
                  </div>
                  <div class="col-md-4 mb-3">
                    <label class="form-label">Điện Thoại</label>
                    <input name="phonenum" type="number" value="<?php echo $u_fetch['phonenum'] ?>" class="form-control shadow-none" required>
                  </div>
                  <div class="col-md-4 mb-3">
                    <label class="form-label">Ngày Sinh</label>
                    <input name="dob" type="date" value="<?php echo $u_fetch['dob'] ?>" class="form-control shadow-none" required>
                  </div>
                  <div class="col-md-4 mb-3">
                    <label class="form-label">Pincode</label>
                    <input name="pincode" type="number" value="<?php echo $u_fetch['pincode'] ?>" class="form-control shadow-none">
                  </div>
                  <div class="col-md-8 mb-4">
                    <label class="form-label">Địa chỉ</label>
                    <textarea name="address" class="form-control shadow-none" rows="1" required><?php echo $u_fetch['address'] ?></textarea>
                  </div>
                </div>
                <button type="submit" class="btn text-white custom-bg shadow-none">Lưu Thay đổi</button>
              </form>
            </div>
        </div>
        <!-- picture -->
        <div class="col-md-4 mb-5 px-4">
            <div class="bg-white p-3 p-md-4 rounded shadow-sm">
              <form id="profile-form">
                <h5 class="fw-bold mb-3">Avatar</h5>
                <img src="<?php echo USERS_IMG_PATH.$u_fetch['profile'] ?>" class="rounded-circle img-fluid mb-3">
                <br>
                <label class="form-label">Ảnh</label>
                <input name="profile" type="file" accept=".jpg, .jpeg, .png, .webp" class="mb-4 form-control shadow-none" required>

                <button type="submit" class="btn text-white custom-bg shadow-none">Lưu Thay đổi</button>
              </form>
            </div>
        </div>
        <!--  -->
        <div class="col-md-8 mb-5 px-4">
            <div class="bg-white p-3 p-md-4 rounded shadow-sm">
              <form id="pass-form">
                <h5 class="fw-bold mb-3">Thay Đổi Mật Khẩu</h5>
                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label class="form-label">Mật Khẩu Mới</label>
                    <input name="new_pass" type="password" class="form-control shadow-none" required>
                  </div>
                  <div class="col-md-6 mb-4">
                    <label class="form-label">Xác Nhận Mật Khẩu</label>
                    <input name="confirm_pass" type="password" class="form-control shadow-none" required>
                  </div>
                </div>
                <button type="submit" class="btn text-white custom-bg shadow-none">Lưu Thay đổi</button>
              </form>
            </div>
        </div>

    </div>
   </div>

   <?php require('inc/footer.php');?>

   <script>
    let info_form = document.getElementById('info-form');

    info_form.addEventListener('submit',function(e){
      e.preventDefault();

      let data = new FormData();
      data.append('info_form','');
      data.append('name',info_form.elements['name'].value);
      data.append('phonenum',info_form.elements['phonenum'].value);
      data.append('address',info_form.elements['address'].value);
      data.append('pincode',info_form.elements['pincode'].value);
      data.append('dob',info_form.elements['dob'].value);

      let xhr = new XMLHttpRequest();
      xhr.open("POST", "ajax/profile.php", true);
          
          xhr.onload = function () {
            if(this.responseText == 2){//'phone_already'
              alert('error',"Điện thoại đã được đăng ký!");
            }
            else if(this.responseText == 0){
              alert('error',"Không có thay đổi được lưu!");
            }
            else{
              alert('success',"Đã lưu thay đổi!");
            }
            
          }
          xhr.send(data);
    });

    let profile_form = document.getElementById('profile-form');

    profile_form.addEventListener('submit',function(e){
      e.preventDefault();

      let data = new FormData();
      data.append('profile_form','');
      data.append('profile',profile_form.elements['profile'].files[0]);
    
      let xhr = new XMLHttpRequest();
      xhr.open("POST", "ajax/profile.php", true);
          
          xhr.onload = function () {
            if(this.responseText == 5){//'inv_img'
              alert('error',"Chỉ file JPG,PNG,SVG là hợp lệ!");
            }
            else if(this.responseText == 6){//'upd_failed'
              alert('error',"Tải ảnh lên thất bại!");
            }
            else if(this.responseText == 0){
              alert('error',"Cập nhật thất bại!");
            }
            else{
              window.location.href = window.location.pathname;
            }
            
          }
          xhr.send(data);
    });

    let pass_form = document.getElementById('pass-form');
    pass_form.addEventListener('submit',function(e){
      e.preventDefault();

      let new_pass = pass_form.elements['new_pass'].value;
      let confirm_pass = pass_form.elements['confirm_pass'].value;

      if(new_pass!=confirm_pass){
        alert('error',"Mật khẩu không trùng khớp!");
        return false;
      }

      let data = new FormData();
      data.append('pass_form','');
      data.append('new_pass',new_pass);
      data.append('confirm_pass',confirm_pass);

      let xhr = new XMLHttpRequest();
      xhr.open("POST", "ajax/profile.php", true);
          
          xhr.onload = function () {
            if(this.responseText == 2){//'mismatch'
              alert('error',"Mật khẩu không trùng khớp!");
            }
            else if(this.responseText == 0){
              alert('error',"Updation Failed!");
            }
            else{
              alert('success',"Đã Lưu Thay Đổi!");
              pass_form.reset();
            }
            
          }
          xhr.send(data);
    });


   </script>

  </body>
</html>