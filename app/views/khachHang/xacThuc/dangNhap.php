<!-- Nhúng file CSS dành riêng cho module Xác thực vào trang -->
<link rel="stylesheet" href="<?php echo ASSETROOT; ?>/css/khachHang/xacThuc.css">

<div class="row justify-content-center align-items-center login-container">
    <div class="col-md-5">
        <div class="card shadow border-0 rounded-3">
            <div class="card-body p-4">
                <h3 class="text-center fw-bold mb-4 text-success">ĐĂNG NHẬP</h3>

                <!-- Hiển thị thông báo lỗi từ Session -->
                <?php if (isset($_SESSION["error"])): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php 
                            echo $_SESSION["error"]; 
                            unset($_SESSION["error"]); 
                        ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <form method="POST" action="<?php echo URLROOT; ?>/khachHang/XacThuc/xuLyDangNhap">
                    
                    <!-- Ô nhập Email -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email</label>
                        <div class="position-relative">
                            <input type="email" name="email" id="login_email" class="form-control pe-5" placeholder="Nhập email..." required>
                            <span class="clear-input-btn" onclick="clearInput('login_email')">&times;</span>
                        </div>
                    </div>

                    <!-- Ô nhập Mật khẩu -->
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Mật khẩu</label>
                        <div class="position-relative">
                            <input type="password" name="matKhau" id="login_pass" class="form-control pe-5" placeholder="Nhập mật khẩu..." required>
                            <span class="clear-input-btn" onclick="clearInput('login_pass')">&times;</span>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success w-100 py-2 fw-bold mb-3">
                        ĐĂNG NHẬP
                    </button>

                    <div class="text-center">
                        <span class="text-muted">Chưa có tài khoản?</span>
                        <a href="<?php echo URLROOT; ?>/khachHang/XacThuc/dangKy" class="text-success fw-bold text-decoration-none">Đăng ký tại đây</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Xử lý sự kiện hiển thị nút X khi có chữ
    document.addEventListener("DOMContentLoaded", function () {
        var inputs = document.querySelectorAll(".position-relative input");
        for (var i = 0; i < inputs.length; i++) {
            inputs[i].addEventListener("input", function () {
                var clearBtn = this.nextElementSibling;
                clearBtn.style.display = this.value.length > 0 ? "block" : "none";
            });
        }
    });

    // Hàm xóa nhanh text của riêng input đó
    function clearInput(id) {
        var input = document.getElementById(id);
        input.value = "";
        input.focus();
        input.nextElementSibling.style.display = "none";
    }
</script>