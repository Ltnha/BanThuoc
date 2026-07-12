<nav class="navbar navbar-expand-lg navbar-dark bg-success shadow-sm">
    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand fw-bold" href="<?php echo URLROOT; ?>">
            PharmaStore
        </a>

        <!-- Mobile Toggle Button -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarMain">
            <!-- Search Form -->
            <form class="d-flex mx-auto w-50" method="GET" action="<?php echo URLROOT; ?>/khachHang/TrangChu/timKiem">
                <input class="form-control me-2" type="search" name="tuKhoa" placeholder="Tìm kiếm thuốc...">
                <button class="btn btn-light" type="submit">
                    <i class="bi bi-search"></i>
                </button>
            </form>

            <!-- Menu Điều Hướng -->
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item">
                    <a class="nav-link active" href="<?php echo URLROOT; ?>">Trang chủ</a>
                </li>

                <li class="nav-item active ms-lg-3">
                    <a class="nav-link" href="<?= URLROOT ?>/khachHang/GioHang">
                        <i class="bi bi-cart3"></i> Giỏ hàng
                    </a>
                </li>

                <!-- Phân vùng Logic Xác Thực (Đã sửa đổi) -->
                <li class="nav-item ms-lg-3">
                    <?php if (isset($_SESSION["user"])): ?>
                        <div class="dropdown">
                            <a class="btn btn-outline-light dropdown-toggle btn-sm px-3" href="#" role="button" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle"></i> <?php echo $_SESSION["user"]["hoTen"]; ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
                                <li><a class="dropdown-menu-item p-2 text-dark text-decoration-none d-block" href="<?php echo URLROOT; ?>/khachHang/CaNhan">Trang cá nhân</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-menu-item p-2 text-danger text-decoration-none d-block" href="<?php echo URLROOT; ?>/khachHang/XacThuc/dangXuat">Đăng xuất</a></li>
                            </ul>
                        </div>
                    <?php else: ?>
                        <div class="text-white">
                            <a href="<?php echo URLROOT; ?>/khachHang/XacThuc/dangNhap" class="text-white text-decoration-none fw-semibold">Đăng nhập</a>
                            <span class="mx-1">|</span>
                            <a href="<?php echo URLROOT; ?>/khachHang/XacThuc/dangKy" class="text-white text-decoration-none fw-semibold">Đăng ký</a>
                        </div>
                    <?php endif; ?>
                </li>
            </ul>
        </div>
    </div>
</nav>