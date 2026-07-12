<?php

class GioHangController extends Controller
{
    private $gioHangModel;
    private $thuocModel;

    public function __construct()
    {
        $this->gioHangModel = $this->model("GioHangModel");
        $this->thuocModel   = $this->model("ThuocModel");
    }

    /**
     * Hiển thị giỏ hàng
     */
    public function index()
    {
        if (!isset($_SESSION["user"]))
        {
            header("Location: " . URLROOT . "/khachHang/XacThuc/dangNhap");
            exit();
        }

        $idKhachHang = $_SESSION["user"]["idNguoiDung"];

        $gioHang = $this->gioHangModel->getByKhachHang($idKhachHang);

        $danhSachThuoc = [];

        if ($gioHang)
        {
            $danhSachThuoc = $this->gioHangModel->getDanhSachThuoc(
                $gioHang["idGioHang"]
            );
        }

        $tongTien = 0;

        foreach ($danhSachThuoc as $thuoc)
        {
            $tongTien += $thuoc["soLuong"] * $thuoc["donGia"];
        }

        $data = [

            "title" => "Giỏ hàng",

            "content" => "khachHang/gioHang",

            "danhSachThuoc" => $danhSachThuoc,

            "tongTien" => $tongTien

        ];

        $this->view("layouts/khachHangLayout", $data);
    }

    /**
     * Thêm thuốc vào giỏ hàng
     */
    public function them($idThuoc)
    {
        //====================================
        // 1. Kiểm tra đăng nhập
        //====================================

        if (!isset($_SESSION["user"]))
        {
            header("Location: " . URLROOT . "/khachHang/XacThuc/dangNhap");
            exit();
        }

        //====================================
        // 2. Lấy ID khách hàng
        //====================================

        $idKhachHang = $_SESSION["user"]["idNguoiDung"];

        //====================================
        // 3. Lấy thông tin thuốc
        //====================================

        $thuoc = $this->thuocModel->getById($idThuoc);

        if(!$thuoc)
        {
            die("Không tìm thấy thuốc.");
        }

        //====================================
        // 4. Lấy giỏ hàng
        //====================================

        $gioHang = $this->gioHangModel->getByKhachHang($idKhachHang);

        //====================================
        // 5. Nếu chưa có thì tạo
        //====================================

        if(!$gioHang)
        {
            $this->gioHangModel->taoGioHang($idKhachHang);

            $gioHang = $this->gioHangModel->getByKhachHang($idKhachHang);
        }

        //====================================
        // 6. Kiểm tra thuốc đã tồn tại chưa
        //====================================

        $chiTiet = $this->gioHangModel->getChiTiet(
            $gioHang["idGioHang"],
            $idThuoc
        );

        //====================================
        // 7. Nếu có thì tăng số lượng
        //====================================

        if($chiTiet)
        {
            $this->gioHangModel->tangSoLuong($chiTiet["id"]);
        }
        else
        {
            $this->gioHangModel->themThuoc(
                $gioHang["idGioHang"],
                $idThuoc,
                1,
                $thuoc["giaBan"]
            );
        }

        //====================================
        // 8. Chuyển sang giỏ hàng
        //====================================

        header("Location: " . URLROOT . "/khachHang/GioHang");

        exit();
    }

    public function tang($id)
    {
        $chiTiet = $this->gioHangModel->getChiTietById($id);

        if(!$chiTiet)
        {
            header("Location: ".URLROOT."/khachHang/GioHang");
            exit();
        }

        $thuoc = $this->thuocModel->getById($chiTiet["idThuoc"]);

        if(!$thuoc)
        {
            header("Location: ".URLROOT."/khachHang/GioHang");
            exit();
        }

        /*
        * -1 = Không giới hạn
        */

        if(
            $thuoc["gioiHanMua"] != -1
            &&
            $chiTiet["soLuong"] >= $thuoc["gioiHanMua"]
        )
        {
            $_SESSION["error"] =
                "Bạn chỉ được mua tối đa "
                .$thuoc["gioiHanMua"].
                " sản phẩm này.";

            header("Location: ".URLROOT."/khachHang/GioHang");
            exit();
        }

        $this->gioHangModel->tangSoLuong($id);

        header("Location: ".URLROOT."/khachHang/GioHang");
        exit();
    }

    public function giam($id)
    {
        $chiTiet = $this->gioHangModel->getChiTietById($id);

        if(!$chiTiet)
        {
            header("Location: " . URLROOT . "/khachHang/GioHang");
            exit();
        }

        if($chiTiet["soLuong"] <= 1)
        {
            $this->gioHangModel->xoa($id);
        }
        else
        {
            $this->gioHangModel->giamSoLuong($id);
        }

        header("Location: " . URLROOT . "/khachHang/GioHang");

        exit();
    }

    public function xoa($id)
    {
        $this->gioHangModel->xoaThuoc($id);

        header("Location: " . URLROOT . "/khachHang/GioHang");

        exit();
    }
}