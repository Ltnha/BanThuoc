<?php

class TrangChuController extends Controller
{
    private $thuocModel;

    public function __construct()
    {
        $this->thuocModel = $this->model("ThuocModel");
    }

    public function index()
    {
        $data = array();

        $data["thuoc"] = $this->thuocModel->getAll();

        $this->view("khachHang/trangChu/index",$data);
    }
}