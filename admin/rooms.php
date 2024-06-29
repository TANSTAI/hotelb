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
    <title>Admin Panel - Rooms</title>
    <?php require('inc/link.php'); ?>
</head>
<body class="bg-light">
    <?php
        require('inc/header.php');
    ?>
    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <h3 class="mb-4 h-font">
                    CÁC PHÒNG
                </h3>
                <!-- ROOMS section -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="text-end mb-4">
                            <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#add-room">
                            <i class="bi bi-plus-square"></i> Thêm
                            </button>
                        </div>
                        <div class="table-reponsive-lg" style="height: 450px; overflow-y: scroll;">
                            <table class="table table-hover border text-center">
                                <thead>
                                    <tr class="bg-dark text-light">
                                        <th scope="col">#</th>
                                        <th scope="col">Tên</th>
                                        <th scope="col">Diện Tích </th>
                                       
                                        <th scope="col">Khách</th>
                                        <th scope="col">Giá</th>
                                        <th scope="col">Số Lượng Phòng</th>
                                        <th scope="col">Trạng Thái</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="room-data">
                                   
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- add ROOMS Modal -->
    <div class="modal fade" id="add-room" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
                <form id="add_room_form" autocomplete="off">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5">Thêm Phòng</h1>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Tên</label>
                                    <input type="text" name="name" class="form-control shadow-none" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Diện Tích</label>
                                    <input type="number" min="1" name="area" class="form-control shadow-none" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Giá</label>
                                    <input type="number" min="1" name="price" class="form-control shadow-none" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Số lượng Phòng</label>
                                    <input type="number" min="1" name="quantity" class="form-control shadow-none" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Người lớn (Max.)</label>
                                    <input type="number" min="1" name="adult" class="form-control shadow-none" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Trẻ em (Max.)</label>
                                    <input type="number" min="1" name="children" class="form-control shadow-none" required>
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label fw-bold">Các Tính Năng</label>
                                    <div class="row">
                                        <?php
                                            $res = selectAll('features');
                                            while($otp = mysqli_fetch_assoc($res)){
                                                echo "
                                                <div class='col-md-3 mb-1'>
                                                    <label>
                                                        <input type='checkbox' name='features' value='$otp[id]' class='form-check-input shadow-none'>
                                                        $otp[name]
                                                    </label>
                                                </div>
                                                ";
                                            }
                                        ?>
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label fw-bold">Các Tiện Ích</label>
                                    <div class="row">
                                        <?php
                                            $res = selectAll('facilities');
                                            while($otp = mysqli_fetch_assoc($res)){
                                                echo "
                                                <div class='col-md-3 mb-1'>
                                                    <label>
                                                        <input type='checkbox' name='facilities' value='$otp[id]' class='form-check-input shadow-none'>
                                                        $otp[name]
                                                    </label>
                                                </div>
                                                ";
                                            }
                                        ?>
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label fw-bold">Mô Tả</label>
                                    <textarea name="desc" rows="4" class="form-control shadow-none" required></textarea>
                                </div>
                            </div>
                            
                        </div>
                        <div class="modal-footer">
                            <button type="reset" onclick="" class="btn text-secondary shadow-none" data-bs-dismiss="modal">HỦY</button>
                            <button type="submit" onclick="" class="btn custom-bg text-white shadow-none">XÁC NHẬN</button>
                        </div>
                    </div>
                </form>
        </div>
    </div>

     <!-- edit ROOMS Modal -->
     <div class="modal fade" id="edit-room" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
                <form id="edit_room_form" autocomplete="off">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5">Sửa Phòng</h1>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Tên</label>
                                    <input type="text" name="name" class="form-control shadow-none" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Diện Tích</label>
                                    <input type="number" min="1" name="area" class="form-control shadow-none" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Giá</label>
                                    <input type="number" min="1" name="price" class="form-control shadow-none" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Số lượng Phòng</label>
                                    <input type="number" min="1" name="quantity" class="form-control shadow-none" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Người lớn (Max.)</label>
                                    <input type="number" min="1" name="adult" class="form-control shadow-none" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Trẻ em (Max.)</label>
                                    <input type="number" min="1" name="children" class="form-control shadow-none" required>
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label fw-bold">Các Tính Năng</label>
                                    <div class="row">
                                        <?php
                                            $res = selectAll('features');
                                            while($otp = mysqli_fetch_assoc($res)){
                                                echo "
                                                <div class='col-md-3 mb-1'>
                                                    <label>
                                                        <input type='checkbox' name='features' value='$otp[id]' class='form-check-input shadow-none'>
                                                        $otp[name]
                                                    </label>
                                                </div>
                                                ";
                                            }
                                        ?>
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label fw-bold">Các Tiện Ích</label>
                                    <div class="row">
                                        <?php
                                            $res = selectAll('facilities');
                                            while($otp = mysqli_fetch_assoc($res)){
                                                echo "
                                                <div class='col-md-3 mb-1'>
                                                    <label>
                                                        <input type='checkbox' name='facilities' value='$otp[id]' class='form-check-input shadow-none'>
                                                        $otp[name]
                                                    </label>
                                                </div>
                                                ";
                                            }
                                        ?>
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label fw-bold">Mô Tả</label>
                                    <textarea name="desc" rows="4" class="form-control shadow-none" required></textarea>
                                </div>
                                <input type="hidden" name="room_id">
                            </div>
                            
                        </div>
                        <div class="modal-footer">
                            <button type="reset" onclick="" class="btn text-secondary shadow-none" data-bs-dismiss="modal">HỦY</button>
                            <button type="submit" onclick="" class="btn custom-bg text-white shadow-none">LƯU THAY ĐỔI</button>
                        </div>
                    </div>
                </form>
        </div>
    </div>

    <!-- Manage Room images Modal -->
    <div class="modal fade" id="room-images" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tên Phòng</h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="image-alert">

                    </div>
                    <div class="border-bottom border-3 pb-3 mb-3">
                        <form id="add_image_form">                      
                            <label class="form-label fw-bold">Thêm Ảnh</label>
                            <input type="file" name="image" accept="[.jpg, .png, .webp, .jpeg]" class="form-control shadow-none mb-3" required>
                            <button onclick="" class="btn custom-bg text-white shadow-none">Thêm</button>
                            <input type="hidden" name="room_id">
                        </form>
                    </div>
                    <div class="table-responsive-lg" style="height: 350px; overflow-y: scroll;">
                            <table class="table table-hover border text-center">
                                <thead>
                                    <tr class="bg-dark text-light sticky-top">
                                        <th scope="col" width="60%">Ảnh</th>
                                        <th scope="col">Đại Diện</th>
                                        <th scope="col">Xóa</th>
                                    </tr>
                                </thead>
                                <tbody id="room-image-data">
                                   
                                </tbody>
                            </table>
                        </div>
                </div>
            </div>
        </div>
    </div>

<?php require('inc/scripts.php'); ?>
   
<script src="scripts/rooms.js"></script>

</body>
</html>