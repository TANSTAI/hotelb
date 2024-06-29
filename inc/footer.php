 
    <div class="container-fluid bg-warning-subtle mt-5">
        <div class="row">
            <div class="col-lg-4 p-4">
                <h3 class="h-font fw-bold fs-3 mb-2"><?php echo $settings_r['site_title'] ?></h3>
                <p>
                    <?php echo $settings_r['site_about'] ?>
                </p>
            </div>
            <div class="col-lg-4 p-4">
                <h5 class="mb-3">Các Trang</h5>
                <a href="index.php" class="d-inline-block mb-2 text-dark text-decoration-none">Trang chủ</a> <br>
                <a href="rooms.php" class="d-inline-block mb-2 text-dark text-decoration-none">Đặt Phòng</a> <br>
                <a href="facilities.php" class="d-inline-block mb-2 text-dark text-decoration-none">Tiện ích</a> <br>
                <a href="contact.php" class="d-inline-block mb-2 text-dark text-decoration-none">Liên Hệ</a> <br>
                <a href="about.php" class="d-inline-block mb-2 text-dark text-decoration-none">Thông tin</a> <br>
            </div>
            <div class="col-lg-4 p-4">
                <h5 class="mb-3">Theo Dõi</h5>
                <?php
                 if($contact_r['tw']!=''){
                    echo <<<data
                    <a href="$contact_r[tw]" class="d-inline-bock text-dark text-decoration-none mb-2 "> 
                        <i class="bi bi-twitter me-1"></i> Twitter
                    </a>
                    <br>
                    data;
                  }
                ?>
               
                <a href="<?php echo $contact_r['fb'] ?>" class="d-inline-bock text-dark text-decoration-none mb-2 "> 
                    <i class="bi bi-facebook me-1"></i> Facebook
                </a>
                <br>
                <a href="<?php echo $contact_r['insta'] ?>" class="d-inline-bock text-dark text-decoration-none"> 
                    <i class="bi bi-instagram me-1"></i> Instagram
                </a>
            </div>
        </div>
    </div>
    <h6 class="text-center bg-dark text-white p-3 m-0">Website Được Phát Triển và Thiết Kế Bởi TAI_HOTEL</h6>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">

    </script>
    

    <script>
        function alert(type,msg,position='body')
        {
            let bs_class = (type == 'success') ? 'alert-success' : 'alert-danger';
            let element = document.createElement('div');
            element.innerHTML = `
                <div class="alert ${bs_class} alert-dismissible fade show" role="alert">
                    <strong class="me-3">${msg}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `;
            if(position=='body'){
                document.body.append(element);
                element.classList.add('custom-alert');
            }
            else{
                document.getElementById(position).appendChild(element);
            }
        
            setTimeout(remAlert,2000);//set time alert
        }
        function remAlert(){
            document.getElementsByClassName('alert')[0].remove();
        }
        //set class "active" vào các class của nav khi load trang tương ứng
        function setActive()
        {
            let navbar = document.getElementById('nav-bar');
            let a_tags = navbar.getElementsByTagName('a');

            for(i=0; i<a_tags.length; i++){
               let file = a_tags[i].href.split('/').pop();
               let file_name = file.split('.')[0];

               if(document.location.href.indexOf(file_name)>=0){
                a_tags[i].classList.add('active');
               }
            }
        }
        //
        let register_form = document.getElementById('register-form');
        register_form.addEventListener('submit', (e)=>{
            e.preventDefault();

            let data = new FormData();
            //chèn dư liệu
            data.append('name',register_form.elements['name'].value);
            data.append('email',register_form.elements['email'].value);
            data.append('phonenum',register_form.elements['phonenum'].value);
            data.append('address',register_form.elements['address'].value);
            data.append('pincode',register_form.elements['pincode'].value);
            data.append('dob',register_form.elements['dob'].value);
            data.append('pass',register_form.elements['pass'].value);
            data.append('cpass',register_form.elements['cpass'].value);
            data.append('profile',register_form.elements['profile'].files[0]);
            data.append('register','');
            
            var myModal = document.getElementById("RegisterModal");
            var modal = bootstrap.Modal.getInstance(myModal);
            modal.hide();

            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/login_register.php", true);

            xhr.onload = function () {
               
                if(this.responseText == 2)//'pass_mismatch'
                {
                    alert('error',"Mật Khẩu Không Trung Khớp!");
                }
                else if(this.responseText == 3){//'email_already'
                    alert('error',"Email đã được sử dụng!");
                }
                else if(this.responseText == 4){//'phone_already'
                    alert('error',"Điện thoại đã được sử dụng!");
                }
                else if(this.responseText == 5){//'inv_img'
                    alert('error',"Chỉ JPG, WEBP & PNG file được phép!");
                }
                else if(this.responseText == 6){//'upd_failed'
                    alert('error',"Ảnh tải lên không thành công!");
                }
                else if(this.responseText == 7){//'mail_failed'
                    alert('error',"Cannot send confirmation email!, Server down!");
                }
                else if(this.responseText == 8){//'ins_failed'
                    alert("error","Đăng ký không thành công! vui lòng đăng ký lại!");
                }
                else{
                    alert('success',"Đăng ký thành công. Link đã gửi đến Email của bạn!");
                    
                    register_form.reset();

                }
            };
            xhr.send(data);


        });
        //
        let login_form = document.getElementById('login-form');
        login_form.addEventListener('submit', (e)=>{
            e.preventDefault();

            let data = new FormData();

            data.append('email_mob',login_form.elements['email_mob'].value);
            data.append('pass',login_form.elements['pass'].value);
            data.append('login','');

            var myModal = document.getElementById("LoginModal");
            var modal = bootstrap.Modal.getInstance(myModal);
            modal.hide();

            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/login_register.php", true);

            xhr.onload = function () {
                if(this.responseText == 2)//'inv_email_mob'
                {
                    alert('error',"Email hoặc Số Điện Thoại Không Hợp Lệ!");
                }
                else if(this.responseText == 3){//'is_verified'
                    alert('error',"Email Chưa Xác Minh!");
                }
                else if(this.responseText == 4){//'inactive'
                    alert('error',"Tài khoản bị cấm! Vui Lòng Liên Hệ với Quản trị viên.");
                }
                else if(this.responseText == 5){//'invalid_pass'
                    alert('error',"Mật khẩu không hợp lệ!");
                }
                else{
                    window.location = window.location.pathname;
                }
            };
            xhr.send(data);
        });
        //
        let forgot_form = document.getElementById('forgot-form');
        forgot_form.addEventListener('submit', (e)=>{
            e.preventDefault();

            let data = new FormData();

            data.append('email',forgot_form.elements['email'].value);
            data.append('forgot_pass','');

            var myModal = document.getElementById("forgotModal");
            var modal = bootstrap.Modal.getInstance(myModal);
            modal.hide();

            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/login_register.php", true);

           

            xhr.onload = function () {
                if(this.responseText == 2)//inv_email
                {
                    alert('error',"Email không hợp lệ!");
                }
                else if(this.responseText == 3){//'not_verified'
                    alert('error',"Email chưa xác minh! Vui lòng liên hệ với Quản trị viên.");
                }
                else if(this.responseText == 4){
                    alert('error',"Tài khoản bị cấm! Vui Lòng Liên Hệ với Quản trị viên.");
                }
                else if(this.responseText == 5){//echo 'mail_failed';
                    alert('error',"Không thể gửi Email. Server down!");
                }
                else if(this.responseText == 6){//'up_failed'
                    alert('error',"Tài Khoản Khôi Phục Thất Bại. Server down!");
                }
                else{
                    alert('success',"Nhập Mật Khẩu Mới ! Qua link xác nhận được gửi đến Email của bạn");
                    forgot_form.reset();
                }
            };
            xhr.send(data);
        });

        function checkLoginToBook(status,room_id){
            if(status){
                window.location.href = 'confirm_booking.php?id='+room_id;
            }
            else{
                alert('error','Vui lòng Đăng Nhập để đặt phòng!');
            }
        }

        setActive();
    </script>