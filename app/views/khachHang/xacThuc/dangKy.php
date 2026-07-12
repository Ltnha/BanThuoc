<link class="sub-css" rel="stylesheet" href="<?php echo ASSETROOT; ?>/css/khachHang/xacThuc.css">

<div class="row justify-content-center align-items-center register-container">
    <div class="col-md-6">
        <div class="card shadow border-0 rounded-3">
            <div class="card-body p-4">
                <h3 class="text-center fw-bold mb-4 text-success">ĐĂNG KÝ TÀI KHOẢN</h3>

                <!-- Thông báo lỗi đăng ký -->
                <?php if (isset($_SESSION["error"])): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php 
                            echo $_SESSION["error"]; 
                            unset($_SESSION["error"]); 
                        ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <form method="POST" action="<?php echo URLROOT; ?>/khachHang/XacThuc/xuLyDangKy">
                    
                    <div class="mb-3">
                        <label class="form-label form-label-custom">Họ và tên</label>
                        <div class="position-relative">
                            <input type="text" name="hoTen" id="reg_name" class="form-control pe-5" placeholder="Nhập họ tên..." required>
                            <span class="clear-input-btn" onclick="clearInput('reg_name')">&times;</span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label form-label-custom">Email</label>
                        <div class="position-relative">
                            <input type="email" name="email" id="reg_email" class="form-control pe-5" placeholder="Nhập email..." required>
                            <span class="clear-input-btn" onclick="clearInput('reg_email')">&times;</span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label form-label-custom">Số điện thoại</label>
                        <div class="position-relative">
                            <input type="text" name="soDienThoai" id="reg_phone" class="form-control pe-5" placeholder="Nhập số điện thoại..." required>
                            <span class="clear-input-btn" onclick="clearInput('reg_phone')">&times;</span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label form-label-custom">Mật khẩu</label>
                        <div class="position-relative">
                            <input type="password" name="matKhau" id="reg_pass" class="form-control pe-5" placeholder="Tối thiểu 6 ký tự..." required>
                            <span class="clear-input-btn" onclick="clearInput('reg_pass')">&times;</span>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label form-label-custom">Xác nhận mật khẩu</label>
                        <div class="position-relative">
                            <input type="password" name="xacNhanMatKhau" id="reg_vpass" class="form-control pe-5" placeholder="Nhập lại mật khẩu..." required>
                            <span class="clear-input-btn" onclick="clearInput('reg_vpass')">&times;</span>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success w-100 py-2 fw-bold mb-3">
                        ĐĂNG KÝ
                    </button>

                    <div class="text-center">
                        <span class="text-muted">Đã có tài khoản?</span>
                        <a href="<?php echo URLROOT; ?>/khachHang/XacThuc/dangNhap" class="text-success fw-bold text-decoration-none">Đăng nhập</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        var inputs = document.querySelectorAll(".position-relative input");
        for (var i = 0; i < inputs.length; i++) {
            inputs[i].addEventListener("input", function () {
                var clearBtn = this.nextElementSibling;
                clearBtn.style.display = this.value.length > 0 ? "block" : "none";
            });
        }
    });

    function clearInput(id) {
        var input = document.getElementById(id);
        input.value = "";
        input.focus();
        input.nextElementSibling.style.display = "none";
    }
</script>