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
    <title><?php echo $settings_r['site_title'] ?> - BOOKINGS</title>
   
  </head>
  <body class="bg-light">

   <?php require('inc/header.php'); 
   
   if(!(isset($_SESSION['login']) && $_SESSION['login'] == true)){
    redirect('index.php');
    }

   ?>

   <div class="container">
    <div class="row">
        <div class="col-12 mb-4 px-4">
            <h2 class="fw-bold mt-4">CÁC ĐƠN ĐẶT PHÒNG</h2>
            <div style="font-size: 14px;">
              <a href="index.php" class="text-secondary text-decoration-none">TRANG CHỦ</a>
              <span class="text-secondary"> > </span>
              <a href="bookings.php" class="text-secondary text-decoration-none">BOOKINGS</a>
            </div>
        </div>

        <?php
        
          $query = "SELECT bo.*, bd.* FROM `booking_order` bo
            INNER JOIN `booking_detail` bd ON bo.booking_id = bd.booking_id
            WHERE ((bo.booking_status = 'booked') 
            OR (bo.booking_status = 'cancelled')
            OR (bo.booking_status = 'payment failed'))
            AND (bo.useR_id = ?)
            ORDER BY bo.booking_id DESC";
          $result = select($query,[$_SESSION['uId']],'i');

          while($data = mysqli_fetch_assoc($result))
          {
            $date = date("d-m-Y",strtotime($data['datetime']));
            $checkin = date("d-m-Y",strtotime($data['check_in']));
            $checkout = date("d-m-Y",strtotime($data['check_out']));

            $status_bg = "";
            $btn = "";

            if($data['booking_status'] == 'booked')
            {
              $status_bg = "bg-success";
              
              if($data['arrival']==1){
                $btn="<a href='generate_pdf.php?gen_pdf&id=$data[booking_id]' class='btn btn-dark btn-sm shadow-none'>Download PDF</a>
                     
                ";
                if($data['rate_review']==0){
                  $btn.="<button type='button' onclick='review_room($data[booking_id],$data[room_id])' data-bs-toggle='modal' data-bs-target='#reviewModal' class='btn btn-dark btn-sm shadow-none ms-2'>Xếp Hạng & Đánh Giá</button>
                  ";
                }
              }
              else{
                $btn="
                      <button onclick='cancel_booking($data[booking_id])' type='button' class='btn btn-danger btn-sm shadow-none'>Cancel</button>
                ";
              }
            }
            else if($data['booking_status'] == 'cancelled')
            {
              $status_bg = "bg-danger";

              if($data['refund']==0){
                $btn = "<span class='badge bg-primary'>Refund in Process!</span>";
              }
              else{
                $btn = "<a href='generate_pdf.php?gen_pdf&id=$data[booking_id]' class='btn btn-dark btn-sm shadow-none'>Download PDF</a>";
              }
            }
            else{
              $status_bg = "bg-warning";
              $btn = "<a href='generate_pdf.php?gen_pdf&id=$data[booking_id]' class='btn btn-dark btn-sm shadow-none'>Download PDF</a>";
            }
            echo<<<bookings
              <div class='col-md-4 px-4 mb-4'>
                <div class='bg-white p-3 rounded shadow-sm'>
                  <h5 class='fw-bold'>$data[room_name]</h5>
                  <p>$data[price]₫/Ngày</p>
                  <p>
                    <b>Check-in: </b> $checkin <br>
                    <b>Check-out: </b> $checkout
                  </p>
                  <p>
                    <b>Thành tiền: </b> $data[trans_amt] <br>
                    <b>Order ID: </b> $data[order_id] <br>
                    <b>Ngày: </b> $date
                  </p>
                  <p>
                    <span class='badge $status_bg'>$data[booking_status]</span>
                  </p>
                  $btn
                </div>
              </div>
            bookings;

          }

        ?>

    </div>
   </div>

       <!-- Modal -->
    <div class="modal fade" id="reviewModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="review-form">
                    <div class="modal-header">
                        <h5 class="modal-title d-flex align-items-center">
                            <i class="bi bi-chat-square-heart-fill fs-3 me-2"></i> Xếp Hạng & Đánh Giá
                        </h5>
                        <button type="reset" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Xếp hạng</label>
                            <select class="form-select shadow-none" name="rating">
                              <option value="5">Excellent</option>
                              <option value="4">Good</option>
                              <option value="3">Trung Bình</option>
                              <option value="2">Bad</option>
                              <option value="1">Very Bad</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Đánh Giá</label>
                            <textarea name="review" type="password" rows="3" class="form-control shadow-none" required></textarea>                 
                        </div>

                        <input type="hidden" name="booking_id">
                        <input type="hidden" name="room_id">

                        <div class="text-end">
                            <button type="submit" class="btn custom-bg text-white shadow-none">ĐÁNH GIÁ</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--  -->

   <?php
   
      if(isset($_GET['cancel_status']))
      {
        alert('success',"Đơn đã bị hủy!");
      }
      else if(isset($_GET['review_status']))
      {
        alert('success',"Cảm ơn bài đánh giá của bạn!");
      }

   ?>

   <?php require('inc/footer.php');?>

   <script>
      function cancel_booking(id){
        if(confirm('Bạn có chắc muốn Hủy Đặt Phòng này ?'))
        {
          let xhr = new XMLHttpRequest();
          xhr.open("POST", "ajax/cancel_booking.php", true);
          xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

          xhr.onload = function () {
            if(this.responseText == 1){
              window.location.href = "bookings.php?cancel_status=true";
            }
            else{
              alert('error',"Cancelation Failed!");
            }
          };
          xhr.send("cancel_booking&id="+id);
        }
      }
      // đánh giá
      let review_form = document.getElementById('review-form');
      function review_room(bid,rid){
        review_form.elements['booking_id'].value = bid;
        review_form.elements['room_id'].value = rid;
      }

      review_form.addEventListener('submit',function(e){
        e.preventDefault();

        let data = new FormData();
        data.append('review_form','');
        data.append('rating',review_form.elements['rating'].value);
        data.append('review',review_form.elements['review'].value);
        data.append('booking_id',review_form.elements['booking_id'].value);
        data.append('room_id',review_form.elements['room_id'].value);

            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/review_room.php", true);
            xhr.onload = function () {
              if(this.responseText == 1){
                window.location.href = 'bookings.php?review_status=true';
              }
              else{
                var myModal = document.getElementById("reviewModal");
                var modal = bootstrap.Modal.getInstance(myModal);
                modal.hide();
                alert('error',"Rating & Review Failed!");
                
              }
            }
            xhr.send(data);
      });



   </script>

  </body>
</html>