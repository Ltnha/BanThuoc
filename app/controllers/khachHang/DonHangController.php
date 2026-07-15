<?php

class DonHangController extends Controller
{

    private $donHangModel;
    private $gioHangModel;

    public function __construct()
    {
        $this->donHangModel=$this->model("DonHangModel");
        $this->gioHangModel=$this->model("GioHangModel");
    }


    public function index()
    {
        if(!isset($_SESSION["user"]))
        {
            header("Location: ".URLROOT."/khachHang/XacThuc/dangNhap");
            exit();
        }

        $idKhachHang=$_SESSION["user"]["idNguoiDung"];

        $danhSachDonHang=
            $this->donHangModel
            ->getDanhSachDonHang($idKhachHang);

        $data=[

            "title"=>"Đơn hàng",

            "content"=>"khachHang/donHang",

            "danhSachDonHang"=>$danhSachDonHang

        ];

        $this->view("layouts/khachHangLayout",$data);
    }

    public function datHang()
    {
        if (!isset($_SESSION["user"]))
        {
            header("Location: " . URLROOT . "/khachHang/XacThuc/dangNhap");
            exit();
        }

        $idKhachHang = $_SESSION["user"]["idNguoiDung"];

        $gioHang = $this->gioHangModel->getByKhachHang($idKhachHang);

        if (!$gioHang)
        {
            header("Location: " . URLROOT . "/khachHang/gioHang");
            exit();
        }

        $danhSachThuoc = $this->gioHangModel->getDanhSachThuoc($gioHang["idGioHang"]);

        if (empty($danhSachThuoc))
        {
            header("Location: " . URLROOT . "/khachHang/donHang");
            exit();
        }
        $tongTien = 0;

        foreach ($danhSachThuoc as $thuoc)
        {
            $tongTien += $thuoc["soLuong"] * $thuoc["donGia"];
        }

        $this->donHangModel->taoDonHang(
            $idKhachHang,
            $tongTien
        );

        $idDonHang = $this->donHangModel->getLastId();

        foreach ($danhSachThuoc as $thuoc)
        {
            $this->donHangModel->themChiTiet(
                $idDonHang,
                $thuoc["idThuoc"],
                $thuoc["soLuong"],
                $thuoc["donGia"]
            );
        }

        $this->gioHangModel->xoaTatCa(
            $gioHang["idGioHang"]
        );

        header("Location: " . URLROOT . "/khachHang/donHang");
        exit();
    }

    public function chiTiet($idDonHang)
    {
        $chiTiet=
            $this->donHangModel
            ->getChiTietDonHang($idDonHang);

        $data=[

            "title"=>"Chi tiết đơn hàng",

            "content"=>"khachHang/chiTietDonHang",

            "chiTiet"=>$chiTiet

        ];

        $this->view("layouts/khachHangLayout",$data);
    }

    public function huy($idDonHang)
    {
        if(!isset($_SESSION["user"]))
        {
            header("Location: ".URLROOT."/khachHang/XacThuc/dangNhap");
            exit();
        }

        $this->donHangModel->huyDonHang($idDonHang);

        header("Location: ".URLROOT."/khachHang/donHang");
        exit();
    }
}