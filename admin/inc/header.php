<div class="container-fluid text-dark p-3 d-flex bg-warning-subtle align-items-center justify-content-between sticky-top border-bottom border-3 border-warning">
        <h3 class="mb-0 h-font">TAI_HOTEL</h3>
        <a href="logout.php" class="btn text-white custom-bg btn-sm">ĐĂNG XUẤT</a>
    </div>

    <div class="col-lg-2 bg-warning-subtle border-top border-3 border-warning" id="dashboard-menu">
        <nav class="navbar navbar-expand-lg navbar-light bg-warning-subtle">
            <div class="container-fluid flex-lg-column align-items-stretch">
                  <h4 class="mt-2 text-dark">BẢNG QUẢN TRỊ</h4>
                  <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#adminDropdown" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon bg-light"></span>
                  </button>
                  <div class="collapse navbar-collapse flex-column align-items-stretch mt-2" id="adminDropdown">
                    <ul class="nav nav-pills flex-column">
                        <li class="nav-item">
                            <a class="nav-link text-dark" href="dashboard.php">Bảng Điều kiển</a>
                        </li>
                        <li class="nav-item">
                            <button class="btn text-dark w-100 shadow-none text-start d-flex align-items-center justify-content-between" 
                            type="button" data-bs-toggle="collapse" data-bs-target="#bookingLinks">
                                <span>Đơn Đặt Phòng</span>
                                <i class="bi bi-caret-down-fill"></i>
                            </button>
                            <div class="collapse show px-3 small mb-1" id="bookingLinks">
                                <ul class="nav nav-pills flex-column rounded border border-warning">
                                    <li class="nav-item">
                                        <a class="nav-link text-dark" href="new_bookings.php">Đơn Mới</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-dark" href="refund_bookings.php">Đơn Hoàn Tiền</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-dark" href="booking_records.php">Hồ Sơ Đặt Phòng</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-dark" href="users.php">Người Dùng</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-dark" href="user_queries.php">Người Dùng Hỏi Đáp</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-dark" href="rate_review.php">Xếp Hạng & Đánh Giá</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-dark" href="rooms.php">Phòng</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-dark" href="features_facilities.php">Tính Năng & Tiện ích</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-dark" href="carousel.php">Carousel</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-dark" href="settings.php">Cài Đặt</a>
                        </li>
                    </ul>
                  </div>
            </div>
        </nav>
    </div>