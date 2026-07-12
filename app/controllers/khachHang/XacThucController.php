<?php

class XacThucController extends Controller
{
    private $taiKhoanModel;

    public function __construct()
    {
        $this->taiKhoanModel = $this->model("TaiKhoanModel");
    }

    /**
     * Hiển thị form đăng ký
     */
    public function dangKy()
    {
        if (isset($_SESSION["user"])) {
            $this->redirect("khachHang/TrangChu");
        }

        $data = array(
            "title"   => "Đăng ký",
            "content" => "khachHang/xacThuc/dangKy"
        );

        $this->view("layouts/khachHangLayout", $data);
    }

    /**
     * Xử lý đăng ký tài khoản
     */
    public function xuLyDangKy()
    {
        if ($_SERVER["REQUEST_METHOD"] != "POST") {
            $this->redirect("khachHang/XacThuc/dangKy");
        }

        $hoTen       = isset($_POST["hoTen"]) ? trim($_POST["hoTen"]) : "";
        $email       = isset($_POST["email"]) ? trim($_POST["email"]) : "";
        $soDienThoai = isset($_POST["soDienThoai"]) ? trim($_POST["soDienThoai"]) : "";
        $matKhau     = isset($_POST["matKhau"]) ? $_POST["matKhau"] : "";
        $xacNhanMK   = isset($_POST["xacNhanMatKhau"]) ? $_POST["xacNhanMatKhau"] : "";

        // Sao lưu dữ liệu người dùng đã điền (Không sao lưu mật khẩu vì lý do bảo mật)
        $_SESSION["old"] = array(
            "hoTen"       => $hoTen,
            "email"       => $email,
            "soDienThoai" => $soDienThoai
        );

        /* ==================================================
            Kiểm tra dữ liệu chi tiết (Bám sát yêu cầu mới)
        ================================================== */
        if (empty($hoTen) || empty($email) || empty($soDienThoai) || empty($matKhau) || empty($xacNhanMK)) {
            $_SESSION["error"] = "Vui lòng điền đầy đủ tất cả các trường thông tin.";
            $this->redirect("khachHang/XacThuc/dangKy");
        }

        if ($matKhau != $xacNhanMK) {
            $_SESSION["error"] = "Mật khẩu nhập lại và mật khẩu gốc không trùng khớp với nhau.";
            $this->redirect("khachHang/XacThuc/dangKy");
        }

        if (strlen($matKhau) < 8) {
            $_SESSION["error"] = "Mật khẩu không hợp lệ: Độ dài phải có ít nhất 8 ký tự.";
            $this->redirect("khachHang/XacThuc/dangKy");
        }

        if (!preg_match('/[A-Z]/', $matKhau)) {
            $_SESSION["error"] = "Mật khẩu không hợp lệ: Phải chứa ít nhất 1 ký tự chữ HOA (A-Z).";
            $this->redirect("khachHang/XacThuc/dangKy");
        }

        if (!preg_match('/[a-z]/', $matKhau)) {
            $_SESSION["error"] = "Mật khẩu không hợp lệ: Phải chứa ít nhất 1 ký tự chữ thường (a-z).";
            $this->redirect("khachHang/XacThuc/dangKy");
        }

        if (!preg_match('/[0-9]/', $matKhau)) {
            $_SESSION["error"] = "Mật khẩu không hợp lệ: Phải chứa ít nhất 1 ký tự chữ số (0-9).";
            $this->redirect("khachHang/XacThuc/dangKy");
        }

        if (!preg_match('/[\W_]/', $matKhau)) {
            $_SESSION["error"] = "Mật khẩu không hợp lệ: Phải chứa ít nhất 1 ký tự đặc biệt (ví dụ: @, #, $, %,...).";
            $this->redirect("khachHang/XacThuc/dangKy");
        }

        if ($this->taiKhoanModel->checkEmail($email)) {
            $_SESSION["error"] = "Địa chỉ email này đã tồn tại trên hệ thống.";
            $this->redirect("khachHang/XacThuc/dangKy");
        }

        if ($this->taiKhoanModel->checkSoDienThoai($soDienThoai)) {
            $_SESSION["error"] = "Số điện thoại này đã được đăng ký trước đó.";
            $this->redirect("khachHang/XacThuc/dangKy");
        }

        /* ==================================================
            Đăng ký thành công -> Xóa dữ liệu tạm nháp
        ================================================== */
        unset($_SESSION["old"]);

        // Mã hóa mật khẩu trước khi lưu vào cơ sở dữ liệu
        $matKhauHash = password_hash($matKhau, PASSWORD_DEFAULT);

        $insertData = array(
            "hoTen"       => $hoTen,
            "email"       => $email,
            "soDienThoai" => $soDienThoai,
            "matKhau"     => $matKhauHash,
            "vaiTro"      => "KHACH_HANG",
            "trangThai"   => 1
        );

        if ($this->taiKhoanModel->insert($insertData)) {
            $nguoiDung = $this->taiKhoanModel->getByEmail($email);
            $_SESSION["user"] = $nguoiDung;
            $this->redirect("khachHang/TrangChu");
        }

        $_SESSION["error"] = "Lỗi hệ thống. Không thể tạo tài khoản lúc này.";
        $this->redirect("khachHang/XacThuc/dangKy");
    }

    /**
     * Hiển thị trang đăng nhập
     */
    public function dangNhap()
    {
        if (isset($_SESSION["user"])) {
            $this->redirect("khachHang/TrangChu");
        }

        // Tương thích PHP 5.6: Dùng array() thay vì []
        $data = array(
            "title"   => "Đăng nhập",
            "content" => "khachHang/xacThuc/dangNhap"
        );

        $this->view("layouts/khachHangLayout", $data);
    }

    /**
     * Xử lý đăng nhập an toàn chống Brute-Force
     */
    public function xuLyDangNhap()
    {
        if ($_SERVER["REQUEST_METHOD"] != "POST") {
            $this->redirect("khachHang/XacThuc/dangNhap");
        }

        $email   = isset($_POST["email"]) ? trim($_POST["email"]) : "";
        $matKhau = isset($_POST["matKhau"]) ? $_POST["matKhau"] : "";

        if (empty($email) || empty($matKhau)) {
            $_SESSION["error"] = "Vui lòng nhập đầy đủ thông tin.";
            $this->redirect("khachHang/XacThuc/dangNhap");
        }

        // Kiểm tra xem có đang trong thời gian bị khóa 15 phút không
        if (isset($_SESSION["lock_until"]) && $_SESSION["lock_until"] > time()) {
            $timeLeft = ceil(($_SESSION["lock_until"] - time()) / 60);
            $_SESSION["error"] = "Tài khoản đang bị khóa tạm thời. Vui lòng thử lại sau " . $timeLeft . " phút.";
            $this->redirect("khachHang/XacThuc/dangNhap");
        }

        $nguoiDung = $this->taiKhoanModel->getByEmail($email);

        // Bảo mật thông tin: Trả ra chung 1 câu thông báo để tránh rò rỉ tài khoản tồn tại
        if (!$nguoiDung || !password_verify($matKhau, $nguoiDung["matKhau"])) {
            $this->handleFailedLogin();
            $_SESSION["error"] = "Thông tin đăng nhập không chính xác.";
            $this->redirect("khachHang/XacThuc/dangNhap");
        }

        if ($nguoiDung["trangThai"] != 1) {
            $_SESSION["error"] = "Tài khoản của bạn đã bị vô hiệu hóa.";
            $this->redirect("khachHang/XacThuc/dangNhap");
        }

        // Xóa bộ đếm lỗi khi đăng nhập thành công
        unset($_SESSION["login_attempts"]);
        unset($_SESSION["lock_until"]);

        $_SESSION["user"] = $nguoiDung;

        // Chuyển thẳng về trang chủ theo yêu cầu mới
        $this->redirect("khachHang/TrangChu");
    }

    /**
     * Thuật toán đếm lỗi đăng nhập
     */
    private function handleFailedLogin()
    {
        if (!isset($_SESSION["login_attempts"])) {
            $_SESSION["login_attempts"] = 1;
        } else {
            $_SESSION["login_attempts"]++;
        }

        if ($_SESSION["login_attempts"] >= 5) {
            $_SESSION["lock_until"] = time() + (15 * 60); // Khóa 15 phút
            unset($_SESSION["login_attempts"]);
        }
    }

    /**
     * Đăng xuất hệ thống chuẩn xác
     */
    public function dangXuat()
    {
        // Xóa biến session user cụ thể
        unset($_SESSION["user"]);
        
        // Hủy toàn bộ phiên làm việc rác
        session_destroy();
        
        // Khởi động lại để không bị lỗi ứng dụng cho các trang sau
        session_start();

        $this->redirect("khachHang/TrangChu");
    }
}