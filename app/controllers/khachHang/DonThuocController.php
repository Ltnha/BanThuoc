<?php

class DonThuocController extends Controller
{
    private $donThuocModel;

    public function __construct()
    {
        $this->donThuocModel = $this->model("DonThuocModel");
    }

    /**
     * Danh sách đơn thuốc
     */
    public function index()
    {
        if(!isset($_SESSION["user"]))
        {
            header("Location: ".URLROOT."/khachHang/XacThuc/dangNhap");
            exit();
        }

        $idKhachHang = $_SESSION["user"]["idNguoiDung"];

        $danhSach = $this->donThuocModel->getByKhachHang($idKhachHang);

        $data = [

            "title" => "Đơn thuốc",

            "content" => "khachHang/donThuoc",

            "danhSach" => $danhSach

        ];

        $this->view("layouts/khachHangLayout",$data);
    }

    /**
     * Upload đơn thuốc
     */
    public function them()
    {
        if(!isset($_SESSION["user"]))
        {
            header("Location: ".URLROOT."/khachHang/XacThuc/dangNhap");
            exit();
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST")
        {
            if ($_FILES["hinhAnh"]["error"] != 0)
            {
                $_SESSION["error"] = "Vui lòng chọn ảnh.";

                header("Location: " . URLROOT . "/khachHang/donThuoc");

                exit();
            }

            // Đường dẫn lưu ảnh
            $uploadDir = dirname(APPROOT) . "/public/assets/images/donThuoc/";

            // Nếu thư mục chưa có thì tự tạo
            if (!is_dir($uploadDir))
            {
                mkdir($uploadDir, 0777, true);
            }

            // Lấy đuôi file
            $extension = strtolower(
                pathinfo(
                    $_FILES["hinhAnh"]["name"],
                    PATHINFO_EXTENSION
                )
            );

            // Chỉ cho phép upload
            $allow = ["jpg", "jpeg", "png"];

            if (!in_array($extension, $allow))
            {
                $_SESSION["error"] = "Chỉ chấp nhận file JPG, JPEG hoặc PNG.";

                header("Location: " . URLROOT . "/khachHang/donThuoc");

                exit();
            }

            // Đặt tên file mới
            $tenFile = date("YmdHis") . "_" . uniqid() . "." . $extension;

            // Upload
            if (
                !move_uploaded_file(
                    $_FILES["hinhAnh"]["tmp_name"],
                    $uploadDir . $tenFile
                )
            )
            {
                $_SESSION["error"] = "Upload thất bại.";

                header("Location: " . URLROOT . "/khachHang/donThuoc");

                exit();
            }

            $data = [

                "idKhachHang" => $_SESSION["user"]["idNguoiDung"],

                "ghiChu" => trim($_POST["ghiChu"]),

                "hinhAnh" => $tenFile

            ];

            if($this->donThuocModel->them($data))
            {
                $_SESSION["success"] = "Gửi đơn thuốc thành công.";
            }
            else
            {
                $_SESSION["error"] = "Không thể lưu đơn thuốc.";
            }

            header("Location: " . URLROOT . "/khachHang/donThuoc");

            exit();
        }
    }
}