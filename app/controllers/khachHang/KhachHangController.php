<?php

class KhachHangController extends Controller
{
    private $khachHangModel;

    public function __construct()
    {
        $this->khachHangModel = $this->model("KhachHangModel");
    }

    /**
     * Hồ sơ cá nhân
     */
    public function hoSo()
    {
        if (!isset($_SESSION["user"]))
        {
            header("Location: " . URLROOT . "/khachHang/XacThuc/dangNhap");
            exit();
        }

        $idNguoiDung = $_SESSION["user"]["idNguoiDung"];

        $thongTin = $this->khachHangModel->getThongTin($idNguoiDung);

        $data = [

            "title" => "Hồ sơ cá nhân",

            "content" => "khachHang/hoSo",

            "thongTin" => $thongTin

        ];

        $this->view("layouts/khachHangLayout", $data);
    }

    /**
     * Cập nhật hồ sơ
     */
    public function capNhat()
    {
        if (!isset($_SESSION["user"]))
        {
            header("Location: " . URLROOT . "/khachHang/XacThuc/dangNhap");
            exit();
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST")
        {
            $data = [

                "idNguoiDung" => $_SESSION["user"]["idNguoiDung"],

                "hoTen" => trim($_POST["hoTen"]),

                "soDienThoai" => trim($_POST["soDienThoai"]),

                "ngaySinh" => $_POST["ngaySinh"],

                "diaChi" => trim($_POST["diaChi"])

            ];

            $this->khachHangModel->capNhat($data);

            header("Location: " . URLROOT . "/khachHang/KhachHang/hoSo");
            exit();
        }
    }
}