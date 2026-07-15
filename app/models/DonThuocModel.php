<?php

class DonThuocModel extends Model
{
    /**
     * Thêm đơn thuốc
     */
    public function them($data)
    {
        $this->db->query("
            INSERT INTO DonThuoc
            (
                idKhachHang,
                ghiChu,
                hinhAnhDonThuoc
            )

            VALUES
            (
                :idKhachHang,
                :ghiChu,
                :hinhAnh
            )
        ");

        $this->db->bind(":idKhachHang",$data["idKhachHang"]);
        $this->db->bind(":ghiChu",$data["ghiChu"]);
        $this->db->bind(":hinhAnh",$data["hinhAnh"]);

        return $this->db->execute();
    }
    /**
     * Danh sách đơn thuốc
     */
    public function getByKhachHang($idKhachHang)
    {
        $this->db->query("
            SELECT *

            FROM DonThuoc

            WHERE idKhachHang=:idKhachHang

            ORDER BY idDonThuoc DESC
        ");

        $this->db->bind(":idKhachHang",$idKhachHang);

        return $this->db->resultSet();
    }
}