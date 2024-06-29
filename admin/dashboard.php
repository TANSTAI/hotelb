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
    <title>Admin Panel - Dashboard</title>
    <?php require('inc/link.php'); ?>
</head>
<body class="bg-light">
    <?php
        require('inc/header.php');

        $is_shutdown = mysqli_fetch_assoc(mysqli_query($con,"SELECT `shutdown` FROM `settings`"));

        $current_bookings = mysqli_fetch_assoc(mysqli_query($con,"SELECT
            COUNT(CASE WHEN booking_status = 'booked' AND arrival = 0 THEN 1 END) AS `new_bookings`,
            COUNT(CASE WHEN booking_status = 'cancelled' AND refund = 0 THEN 1 END) AS `refund_bookings`
            FROM `booking_order`"));

        $unread_queries =  mysqli_fetch_assoc(mysqli_query($con,"SELECT COUNT(sr_no) AS `count` 
            FROM `user_queries` WHERE `seen`=0"));
        $unread_reviews =  mysqli_fetch_assoc(mysqli_query($con,"SELECT COUNT(sr_no) AS `count` 
            FROM `rating_review` WHERE `seen`=0"));

        $current_users = mysqli_fetch_assoc(mysqli_query($con,"SELECT
            COUNT(id) AS `total`,
            COUNT(CASE WHEN `status` = 1 THEN 1 END) AS `active`, 
            COUNT(CASE WHEN `status` = 0 THEN 1 END) AS `inactive`,
            COUNT(CASE WHEN `is_verified` = 0 THEN 1 END) AS `unverified`
            FROM `user_cred`"));
    ?>
   

    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h3 class="h-font">BẢNG ĐIỀU KIỂN</h3>
                    <?php 
                        if($is_shutdown['shutdown'])
                        {
                            echo<<<data
                            <h6 class="bagde bg-danger py-2 px-3 rounded text-white">Chế độ Shutdown đã bật!</h6>
                            data;
                        }
                    ?>
                </div>

                <div class="row mb-4">
                    <div class="col-md-3 mb-4">
                        <a href="new_bookings.php" class="text-decoration-none">
                            <div class="card text-center text-success p-3">
                                <h6>Booking Mới</h6>
                                <h1 class="mt-2 mb-0"><?php echo $current_bookings['new_bookings'] ?></h1>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3 mb-4">
                        <a href="refund_bookings.php" class="text-decoration-none">
                            <div class="card text-center text-warning p-3">
                                <h6>Hoàn Tiền</h6>
                                <h1 class="mt-2 mb-0"><?php echo $current_bookings['refund_bookings'] ?></h1>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3 mb-4">
                        <a href="user_queries.php" class="text-decoration-none">
                            <div class="card text-center text-info p-3">
                                <h6>Liên Hệ</h6>
                                <h1 class="mt-2 mb-0"><?php echo $unread_queries['count'] ?></h1>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3 mb-4">
                        <a href="rate_review.php" class="text-decoration-none">
                            <div class="card text-center text-info-subtle p-3">
                                <h6>Đánh Giá</h6>
                                <h1 class="mt-2 mb-0"><?php echo $unread_reviews['count'] ?></h1>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h3 class="h-font">ĐƠN ĐẶT PHÒNG</h3>
                    <select class="form-select shadow-none bg-light w-auto" onchange="bookings(this.value)">
                        <option value="1">30 ngày trước</option>
                        <option value="2">90 ngày trước</option>
                        <option value="3">1 năm trước</option>
                        <option value="4">Tất cả</option>
                    </select>
                </div>

                <div class="row mb-3">
                    <div class="col-md-3 mb-4">
                        <div class="card text-center text-primary p-3">
                            <h6>Tổng Số</h6>
                            <h1 class="mt-2 mb-0" id="total_bookings">0</h1>
                            <h4 class="mt-2 mb-0" id="total_amt">0vn₫</h4>
                        </div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="card text-center text-success p-3">
                            <h6>Đang Hoạt Động</h6>
                            <h1 class="mt-2 mb-0" id="active_bookings">0</h1>
                            <h4 class="mt-2 mb-0" id="active_amt">0vn₫</h4>
                        </div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="card text-center text-danger p-3">
                            <h6>Bị Hủy</h6>
                            <h1 class="mt-2 mb-0" id="cancelled_bookings">0</h1>
                            <h4 class="mt-2 mb-0" id="cancelled_amt">0vn₫</h4>
                        </div>
                    </div>
                </div>
             
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h3 class="h-font">Người Dùng, Liên hệ, Reviews</h3>
                    <select class="form-select shadow-none bg-light w-auto" onchange="users(this.value)">
                        <option value="1">30 ngày trước</option>
                        <option value="2">90 ngày trước</option>
                        <option value="3">1 năm trước</option>
                        <option value="4">Tất cả</option>
                    </select>
                </div>

                <div class="row mb-3">
                    <div class="col-md-3 mb-4">
                        <div class="card text-center text-success p-3">
                            <h6>Đăng Ký</h6>
                            <h1 class="mt-2 mb-0" id="total_new_reg">0</h1>
                        </div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="card text-center text-primary p-3">
                            <h6>Liên Hệ</h6>
                            <h1 class="mt-2 mb-0" id="total_queries">0</h1>
                        </div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="card text-center text-primary p-3">
                            <h6>Đánh Gía</h6>
                            <h1 class="mt-2 mb-0" id="total_review">0</h1>
                        </div>
                    </div>
                </div>

                <h3 class="h-font">Người Dùng</h3>
                <div class="row mb-3">
                    <div class="col-md-3 mb-4">
                        <div class="card text-center text-info p-3">
                            <h6>Tổng</h6>
                            <h1 class="mt-2 mb-0"><?php echo $current_users['total'] ?></h1>
                        </div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="card text-center text-success p-3">
                            <h6>Hoạt Động</h6>
                            <h1 class="mt-2 mb-0"><?php echo $current_users['active'] ?></h1>
                        </div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="card text-center text-warning p-3">
                            <h6>Không Hoạt Động</h6>
                            <h1 class="mt-2 mb-0"><?php echo $current_users['inactive'] ?></h1>
                        </div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="card text-center text-danger p-3">
                            <h6>Chưa Xác Minh</h6>
                            <h1 class="mt-2 mb-0"><?php echo $current_users['unverified'] ?></h1>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
<?php require('inc/scripts.php'); ?>
<script src="scripts/dashboard.js"></script>
</body>
</html>