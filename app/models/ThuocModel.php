<?php

class ThuocModel extends Model
{
    /**
     * Lấy danh sách thuốc
     */
    public function getAll()
    {
        $sql = "
            SELECT
                t.idThuoc,
                t.tenThuoc,
                t.thanhPhan,
                t.hamLuong,
                t.congDung,
                t.donViTinh,
                t.giaBan,
                t.hinhAnh,
                t.yeuCauKeDon,
                t.gioiHanMua,
                d.tenDanhMuc
            FROM Thuoc t
            LEFT JOIN DanhMucThuoc d
                ON t.idDanhMuc = d.idDanhMuc
            WHERE t.trangThai = 0
            ORDER BY t.idThuoc DESC
        ";

        $this->db->query($sql);

        return $this->db->resultSet();
    }
}