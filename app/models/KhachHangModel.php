<?php

class KhachHangModel extends Model
{
    /**
     * Lấy hồ sơ khách hàng
     */
    public function getThongTin($idNguoiDung)
    {
        $this->db->query("
            SELECT
                nd.idNguoiDung,
                nd.hoTen,
                nd.email,
                nd.soDienThoai,
                kh.ngaySinh,
                kh.diaChiGiaoHang,
                kh.diemTichLuy
            FROM NguoiDung nd
            INNER JOIN KhachHang kh
                ON nd.idNguoiDung = kh.idNguoiDung
            WHERE nd.idNguoiDung = :idNguoiDung
            LIMIT 1
        ");

        $this->db->bind(":idNguoiDung",$idNguoiDung);

        return $this->db->single();
    }

        /**
     * Cập nhật hồ sơ
     */
    public function capNhat($data)
    {
        $this->db->query("
            UPDATE NguoiDung

            SET
                hoTen = :hoTen,
                soDienThoai = :soDienThoai

            WHERE
                idNguoiDung = :idNguoiDung
        ");

        $this->db->bind(":hoTen",$data["hoTen"]);
        $this->db->bind(":soDienThoai",$data["soDienThoai"]);
        $this->db->bind(":idNguoiDung",$data["idNguoiDung"]);

        $this->db->execute();

        $this->db->query("
            UPDATE KhachHang

            SET
                ngaySinh = :ngaySinh,
                diaChiGiaoHang = :diaChi

            WHERE
                idNguoiDung = :idNguoiDung
        ");

        $this->db->bind(":ngaySinh",$data["ngaySinh"]);
        $this->db->bind(":diaChi",$data["diaChi"]);
        $this->db->bind(":idNguoiDung",$data["idNguoiDung"]);

        return $this->db->execute();
    }
}