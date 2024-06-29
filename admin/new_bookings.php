<?php
    require('inc/essentials.php');
    require('inc/db_config.php');
    adminLogin();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - New Bookings</title>
    <?php require('inc/link.php'); ?>
</head>
<body class="bg-light">
    <?php
        require('inc/header.php');
    ?>
    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4">
                <h3 class="mb-4 h-font">
                    ĐẶT PHÒNG MỚI
                </h3>
                <!-- ROOMS section -->
                <div class="card border-0 shadow-sm mb-4 overflow-hidden">
                    <div class="card-body">
                        <div class="text-end mb-4">
                            <input type="text" oninput="get_bookings(this.value)" class="form-control shadow-none w-25 ms-auto" placeholder="Nhập để tìm kiếm...">
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover border" style="min-width: 1200px;">
                                <thead>
                                    <tr class="bg-dark text-light">
                                        <th scope="col">#</th>
                                        <th scope="col">Người Dùng</th>
                                        <th scope="col">Phòng </th>
                                        <th scope="col">Chi Tiết Đặt Phòng</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="table-data">
                                   
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Assigh Room Modal -->
    <div class="modal fade" id="assigh-room" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
                <form id="assigh_room_form">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5">Xác Nhận</h1>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Số Phòng</label>
                                <input type="text" name="room_no" class="form-control shadow-none" required>
                            </div>
                            <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap lh-base">
                                Chú ý : Chỉ xác nhận phòng khi khách hàng đến.!
                            </span>
                            <input type="hidden" name="booking_id">
                        </div>
                        <div class="modal-footer">
                            <button type="reset" onclick="" class="btn text-secondary shadow-none" data-bs-dismiss="modal">HỦY</button>
                            <button type="submit" onclick="" class="btn custom-bg text-white shadow-none">XÁC NHẬN</button>
                        </div>
                    </div>
                </form>
        </div>
    </div>


<?php require('inc/scripts.php'); ?>
   
<script src="scripts/new_bookings.js"></script>

</body>
</html>