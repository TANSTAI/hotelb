<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    
    <!--swiperjs  -->
    <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css"/>
    
    <style>
      .pop:hover{
        border-top-color:  var(--teal) !important;
        transform: scale(1.03);
        transition: all 0.3s;
      }
    </style>
    <?php require('inc/link.php');?>
    <title><?php echo $settings_r['site_title'] ?> - ROOMS</title>
   
  </head>
  <body class="bg-light">

   <?php 
   require('inc/header.php'); 

   // xử lý tìm từ home 
    $checkin_default = "";
    $checkout_default = "";
    $adult_default = "";
    $children_default = "";
    if(isset($_GET['check_availability']))
    {
      $frm_data = filteration($_GET);

      $checkin_default = $frm_data['checkin'];
      $checkout_default = $frm_data['checkout'];
      $adult_default = $frm_data['adult'];
      $children_default = $frm_data['children'];
    }
    
   ?>
   
    <div class="my-5 px-4">
        <h2 class="fw-bold h-font text-center">PHÒNG CỦA CHÚNG TÔI</h2>
        <div class="h-line bg-dark"></div>
    </div>
    
   <div class="container-fluid">
    <div class="row">
        <div class="col-lg-3 col-md-12 mb-lg-0 mb-4 ps-4">
            <nav class="navbar navbar-expand-lg navbar-light bg-white rounded shadow">
              <div class="container-fluid flex-lg-column align-items-stretch">
                  <h4 class="mt-2">BỘ LỌC TÌM KIẾM</h4>
                  <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#filterDropdown" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                  </button>
                  <div class="collapse navbar-collapse flex-column align-items-stretch mt-2" id="filterDropdown">
                    <!-- check availability -->
                    <div class="border bg-light p-3 rounded mb-3">
                        <h5 class="d-flex align-items-center justify-content-between mb-3" style="font-size: 18px;">
                          <span>PHÒNG KHẢ DỤNG</span>
                          <button id="chk_avail_btn" onclick="chk_avail_clear()" class="btn shadow-none btn-sm text-sencondary d-none">Reset</button>
                        </h5>
                        <label class="form-label" style="font-weight: 500;">Check-in</label>
                        <input type="date" class="form-control shadow-none" value="<?php echo $checkin_default ?>" id="checkin" onchange="chk_avail_filter()">
                        <label class="form-label" style="font-weight: 500;">Check-out</label>
                        <input type="date" class="form-control shadow-none" value="<?php echo $checkout_default ?>" id="checkout" onchange="chk_avail_filter()">
                    </div>
                    <!-- Facilities  -->
                    <div class="border bg-light p-3 rounded mb-3">
                        <h5 class="d-flex align-items-center justify-content-between mb-3" style="font-size: 18px;">
                          <span>DỊCH VỤ</span>
                          <button id="facilities_btn" onclick="facilities_clear()" class="btn shadow-none btn-sm text-sencondary d-none">Reset</button>
                        </h5>
                        <?php

                        $facilities_q = selectAll('facilities');
                        while($row = mysqli_fetch_assoc($facilities_q))
                        {
                          echo<<<facilities
                            <div class="mb-2">
                              <input type="checkbox" onclick="fetch_rooms()" name="facilities" value="$row[id]" class="form-check-input shadow-none me-1" id="$row[id]">
                              <label class="form-check-label" for="$row[id]" style="font-weight: 500;">$row[name]</label>
                            </div>
                          facilities;
                        }
                        
                        ?>
                        <!-- <div class="mb-2">
                          <input type="checkbox" id="f1" class="form-check-input shadow-none me-1">
                          <label class="form-check-label" for="f1" style="font-weight: 500;">Facility one</label>
                        </div>
                        <div class="mb-2">
                          <input type="checkbox" id="f1" class="form-check-input shadow-none me-1">
                          <label class="form-check-label" for="f2" style="font-weight: 500;">Facility two</label>
                        </div>
                        <div class="mb-2">
                          <input type="checkbox" id="f1" class="form-check-input shadow-none me-1">
                          <label class="form-check-label" for="f3" style="font-weight: 500;">Facility three</label>
                        </div> -->
                    </div>
                    <!-- Guest -->
                    <div class="border bg-light p-3 rounded mb-3">
                        <h5 class="d-flex align-items-center justify-content-between mb-3" style="font-size: 18px;">
                          <span>KHÁCH</span>
                          <button id="guests_btn" onclick="guests_clear()" class="btn shadow-none btn-sm text-sencondary d-none">Reset</button>
                        </h5>
                        <div class="d-flex">
                          <div class="me-3">
                            <div class="mb-2">
                              <label class="form-label" style="font-weight: 500;">Người Lớn</label>
                              <input type="number" min="1" id="adults" value="<?php echo $adult_default ?>" oninput="guests_filter()" class="form-control shadow-none">  
                            </div>
                          </div>
                          <div class="">
                            <div class="mb-2">
                              <label class="form-label" style="font-weight: 500;">Trẻ Em</label>
                              <input type="number" min="1" id="children" value="<?php echo $children_default ?>" oninput="guests_filter()" class="form-control shadow-none">  
                            </div>
                          </div>
                        </div>
                    </div>
                  </div>
              </div>
            </nav>
        </div>
        <div class="col-lg-9 col-md-12 px-4" id="rooms-data">

          <!-- <div class="card mb-4 border-0 shadow">
            <div class="row g-0 p-3 align-items-center">
              <div class="col-md-5 mb-lg-0 mb-md-0 mb-3">
                <img src="images/rooms/1.jpg" class="img-fluid rounded">
              </div>
              <div class="col-md-5 px-lg-3 px-md-3 px-0">
                  <h5 class="mb-3">Simple Room Name</h5>
                  <div class="features mb-3">
                          <h6 class="mb-1">Features</h6>
                          <span class="badge rounded-pill bg-light text-dark text-wrap">
                            2 Rooms
                          </span>
                          <span class="badge rounded-pill bg-light text-dark text-wrap">
                            1 Bathroom
                          </span>
                          <span class="badge rounded-pill bg-light text-dark text-wrap">
                            1 Bacolny
                          </span>
                          <span class="badge rounded-pill bg-light text-dark text-wrap">
                            3 Sofa
                          </span>
                  </div>
                  <div class="facilities mb-3">
                            <h6 class="mb-1">Facilities</h6>
                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                              Wifi
                            </span>
                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                              Television
                            </span>
                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                              AC
                            </span>
                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                              Room heater
                            </span>
                  </div>
                  <div class="guests">
                            <h6 class="mb-1">Guests</h6>
                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                              5 Adults
                            </span>
                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                              4 Children
                            </span>
                  </div>
              </div>
              <div class="col-md-2 mt-lg-0 mt-md-0 mt-4 text-center">
                <h6 class="mb-4">₫ 200.000  per night</h6>
                  <a href="#" class="btn btn-sm w-100 text-white custom-bg shadow-none mb-2">Book Now</a>
                  <a href="#" class="btn btn-sm w-100 btn-outline-dark shadow-none">More Details</a>
              </div>
            </div>
          </div> -->
        </div>
    </div>
   </div>

   <script>
    //filter room
    let rooms_data = document.getElementById('rooms-data');
    let checkin = document.getElementById('checkin');
    let checkout = document.getElementById('checkout');

    let chk_avail_btn = document.getElementById('chk_avail_btn');

    let adults = document.getElementById('adults');
    let children = document.getElementById('children');
    let guests_btn = document.getElementById('guests_btn');

    let facilities_btn = document.getElementById('facilities_btn');
    

    function fetch_rooms()
    {
      let chk_avail = JSON.stringify({
        checkin: checkin.value,
        checkout: checkout.value
      });

      let guests = JSON.stringify({
        adults: adults.value,
        children: children.value
      });

      let facility_list = {"facilities":[]};
      let get_facilities = document.querySelectorAll('[name="facilities"]:checked');

      if(get_facilities.length>0)
      {
        get_facilities.forEach((facility)=>{
          facility_list.facilities.push(facility.value);
        });
        facilities_btn.classList.remove('d-none');
      }
      else{
        facilities_btn.classList.add('d-none');
      }
      facility_list = JSON.stringify(facility_list);

      let xhr = new XMLHttpRequest();
      xhr.open("GET", "ajax/rooms.php?fetch_rooms&chk_avail="+chk_avail+"&guests="+guests+"&facility_list="+facility_list, true);

      xhr.onprogress = function(){
        rooms_data.innerHTML = `<div class="spinner-border text-info mb-3 d-block mx-auto" id="loader" role="status">
              <span class="visually-hidden">Loading...</span>
          </div>`;
      }

      xhr.onload = function(){
        rooms_data.innerHTML = this.responseText;
      }
      xhr.send();
    }

    function chk_avail_filter(){
      if(checkin.value!='' && checkout.value!='')
      {
        fetch_rooms();
        chk_avail_btn.classList.remove('d-none');
      }
    }

    function chk_avail_clear(){
      checkin.value='';
      checkout.value='';
      chk_avail_btn.classList.add('d-none');
      fetch_rooms();
        
    }

    function guests_filter()
    {
      if(adults.value > 0 || children.value > 0 ){
        fetch_rooms();
        guests_btn.classList.remove('d-none');
      }
    }
    function guests_clear()
    {
      adults.value='';
      children.value='';
      guests_btn.classList.add('d-none');
      fetch_rooms();
    }
    function facilities_clear()
    {
      let get_facilities = document.querySelectorAll('[name="facilities"]:checked');
      get_facilities.forEach((facility)=>{
        facility.checked = false;
      });
      facilities_btn.classList.add('d-none');

      fetch_rooms();
    }

    window.onload = function(){
      fetch_rooms();
    }

   </script>
   

   <?php require('inc/footer.php');?>

  </body>
</html>