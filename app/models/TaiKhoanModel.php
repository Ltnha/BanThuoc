<?php

class TaiKhoanModel extends Model
{
    /**
     * Kiểm tra Email đã tồn tại
     */
    public function checkEmail($email)
    {
        $this->db->query("
            SELECT idNguoiDung
            FROM NguoiDung
            WHERE email = :email
            LIMIT 1
        ");

        $this->db->bind(":email", $email);

        return $this->db->single();
    }

    /**
     * Kiểm tra SĐT đã tồn tại
     */
    public function checkSoDienThoai($soDienThoai)
    {
        $this->db->query("
            SELECT idNguoiDung
            FROM NguoiDung
            WHERE soDienThoai = :soDienThoai
            LIMIT 1
        ");

        $this->db->bind(":soDienThoai", $soDienThoai);

        return $this->db->single();
    }

    /**
     * Thêm tài khoản mới
     */
    public function insert($data)
    {
        //=========================
        // Thêm vào bảng NguoiDung
        //=========================

        $this->db->query("
            INSERT INTO NguoiDung
            (
                hoTen,
                email,
                soDienThoai,
                matKhau,
                vaiTro,
                trangThai
            )

            VALUES
            (
                :hoTen,
                :email,
                :soDienThoai,
                :matKhau,
                :vaiTro,
                :trangThai
            )
        ");

        $this->db->bind(":hoTen", $data["hoTen"]);
        $this->db->bind(":email", $data["email"]);
        $this->db->bind(":soDienThoai", $data["soDienThoai"]);
        $this->db->bind(":matKhau", $data["matKhau"]);
        $this->db->bind(":vaiTro", $data["vaiTro"]);
        $this->db->bind(":trangThai", $data["trangThai"]);

        if (!$this->db->execute())
        {
            return false;
        }

        //=========================
        // Lấy ID vừa tạo
        //=========================

        $idNguoiDung = $this->db->lastInsertId();

        //=========================
        // Nếu là khách hàng
        //=========================

        if ($data["vaiTro"] == "KHACH_HANG")
        {
            $this->db->query("
                INSERT INTO KhachHang
                (
                    idNguoiDung
                )

                VALUES
                (
                    :idNguoiDung
                )
            ");

            $this->db->bind(":idNguoiDung", $idNguoiDung);

            return $this->db->execute();
        }

        return true;
    }

    /**
     * Lấy thông tin theo Email
     */
    public function getByEmail($email)
    {
        $this->db->query("
            SELECT *
            FROM NguoiDung
            WHERE email = :email
            LIMIT 1
        ");

        $this->db->bind(":email", $email);

        return $this->db->single();
    }

    /**
     * Lấy thông tin theo ID
     */
    public function getById($idNguoiDung)
    {
        $this->db->query("
            SELECT *
            FROM NguoiDung
            WHERE idNguoiDung = :idNguoiDung
        ");

        $this->db->bind(":idNguoiDung", $idNguoiDung);

        return $this->db->single();
    }
}