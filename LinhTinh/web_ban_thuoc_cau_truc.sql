CREATE DATABASE IF NOT EXISTS HeThongBanThuoc CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE HeThongBanThuoc;

CREATE TABLE NguoiDung (
    idNguoiDung INT AUTO_INCREMENT PRIMARY KEY,
    hoTen VARCHAR(255) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    soDienThoai VARCHAR(15) UNIQUE,
    matKhau VARCHAR(255) NOT NULL,
    trangThai BOOLEAN DEFAULT TRUE,
    vaiTro ENUM('KHACH_HANG', 'DUOC_SI', 'QUAN_TRI_VIEN') NOT NULL
);

CREATE TABLE KhachHang (
    idNguoiDung INT PRIMARY KEY,
    diemTichLuy INT DEFAULT 0,
    diaChiGiaoHang VARCHAR(500),
    ngaySinh DATE,
    FOREIGN KEY (idNguoiDung) REFERENCES NguoiDung(idNguoiDung) ON DELETE CASCADE
);

CREATE TABLE DuocSi (
    idNguoiDung INT PRIMARY KEY,
    chungChiHanhNghe VARCHAR(100) NOT NULL,
    noiCap NVARCHAR(255) NOT NULL, -- Nơi cấp chứng chỉ hoặc bằng cấp
    trinhDo NVARCHAR(100) NOT NULL, -- Trình độ (VD: Đại học, Cao đẳng, Thạc sĩ,...)
    FOREIGN KEY (idNguoiDung) REFERENCES NguoiDung(idNguoiDung) ON DELETE CASCADE
);

CREATE TABLE QuanTriVien (
    idNguoiDung INT PRIMARY KEY,
    FOREIGN KEY (idNguoiDung) REFERENCES NguoiDung(idNguoiDung) ON DELETE CASCADE
);


CREATE TABLE DanhMucThuoc (
    idDanhMuc INT AUTO_INCREMENT PRIMARY KEY,
    tenDanhMuc NVARCHAR(255) NOT NULL,
    moTa NVARCHAR(255)
);

CREATE TABLE Thuoc (
    idThuoc INT AUTO_INCREMENT PRIMARY KEY,
    idDanhMuc INT,
    tenThuoc NVARCHAR(255) NOT NULL,
    thanhPhan NVARCHAR(255) NOT NULL,
    hamLuong VARCHAR(100),
    congDung NVARCHAR(255) NOT NULL,
    donViTinh NVARCHAR(50),
    giaBan DECIMAL(12, 2) NOT NULL,
    hinhAnh VARCHAR(500),
    yeuCauKeDon ENUM('Kê đơn', 'Không kê đơn') NOT NULL DEFAULT 'Không kê đơn',
    gioiHanMua INT DEFAULT -1, -- -1: Không giới hạn, >0: Giới hạn tối đa
    trangThai BOOLEAN DEFAULT TRUE,
    FOREIGN KEY (idDanhMuc) REFERENCES DanhMucThuoc(idDanhMuc) ON DELETE SET NULL
);

CREATE TABLE LoThuoc (
    idLo INT AUTO_INCREMENT PRIMARY KEY,
    idThuoc INT NOT NULL,
    maLo VARCHAR(100) NOT NULL,
    ngaySanXuat DATE,
    hanSuDung DATE NOT NULL,
    soLuongTon INT DEFAULT 0,
    giaNhap DECIMAL(12, 2) NOT NULL,
    FOREIGN KEY (idThuoc) REFERENCES Thuoc(idThuoc) ON DELETE CASCADE
);

CREATE TABLE GioHang (
    idGioHang INT AUTO_INCREMENT PRIMARY KEY,
    idKhachHang INT UNIQUE NOT NULL, 
    ngayTao DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (idKhachHang) REFERENCES KhachHang(idNguoiDung) ON DELETE CASCADE
);

CREATE TABLE ChiTietGioHang (
    id INT AUTO_INCREMENT PRIMARY KEY,
    idGioHang INT NOT NULL,
    idThuoc INT NOT NULL,
    soLuong INT NOT NULL CHECK (soLuong > 0),
    donGia DECIMAL(12, 2) NOT NULL,
    FOREIGN KEY (idGioHang) REFERENCES GioHang(idGioHang) ON DELETE CASCADE,
    FOREIGN KEY (idThuoc) REFERENCES Thuoc(idThuoc) ON DELETE CASCADE
);

CREATE TABLE DonHang (
    idDonHang INT AUTO_INCREMENT PRIMARY KEY,
    idKhachHang INT NOT NULL,
    ngayDat DATETIME DEFAULT CURRENT_TIMESTAMP,
    tongTien DECIMAL(12, 2) NOT NULL DEFAULT 0.00,
    phiVanChuyen DECIMAL(12, 2) DEFAULT 0.00,
    trangThai ENUM('CHO_XAC_NHAN','DA_XAC_NHAN','DANG_GIAO','DA_GIAO','DA_HUY') DEFAULT 'CHO_XAC_NHAN',
    lyDoHuy VARCHAR(500) NULL,
    FOREIGN KEY (idKhachHang) REFERENCES KhachHang(idNguoiDung) ON DELETE RESTRICT
);

CREATE TABLE ChiTietDonHang (
    id INT AUTO_INCREMENT PRIMARY KEY,
    idDonHang INT NOT NULL,
    idThuoc INT NOT NULL,
    soLuong INT NOT NULL CHECK (soLuong > 0),
    donGia DECIMAL(12, 2) NOT NULL,
    giamGia DECIMAL(12, 2) DEFAULT 0.00,
    FOREIGN KEY (idDonHang) REFERENCES DonHang(idDonHang) ON DELETE CASCADE,
    FOREIGN KEY (idThuoc) REFERENCES Thuoc(idThuoc) ON DELETE RESTRICT
);

CREATE TABLE DonThuoc (
    idDonThuoc INT AUTO_INCREMENT PRIMARY KEY,
    idKhachHang INT NOT NULL,
    idDuocSi INT NULL,              
    idDonHang INT UNIQUE,      
    ngayGui DATETIME DEFAULT CURRENT_TIMESTAMP,
    ghiChu NVARCHAR(500),
    trangThai ENUM('CHO_DUYET','DA_DUYET','TU_CHOI') DEFAULT 'CHO_DUYET',
    hinhAnhDonThuoc VARCHAR(255) NOT NULL,
    FOREIGN KEY (idKhachHang) REFERENCES KhachHang(idNguoiDung) ON DELETE RESTRICT,
    FOREIGN KEY (idDuocSi) REFERENCES DuocSi(idNguoiDung) ON DELETE SET NULL,
    FOREIGN KEY (idDonHang) REFERENCES DonHang(idDonHang) ON DELETE SET NULL
);

CREATE TABLE ChiTietDonThuoc (
    id INT AUTO_INCREMENT PRIMARY KEY,
    idDonThuoc INT NOT NULL,
    tenThuoc VARCHAR(255) NOT NULL,
    lieuDung TEXT,
    soLuong INT NOT NULL CHECK (soLuong > 0),
    FOREIGN KEY (idDonThuoc) REFERENCES DonThuoc(idDonThuoc) ON DELETE CASCADE
);

CREATE TABLE ThanhToan (
    idThanhToan INT AUTO_INCREMENT PRIMARY KEY,
    idDonHang INT UNIQUE NOT NULL, 
    phuongThuc VARCHAR(50) NOT NULL,
    soTien DECIMAL(12, 2) NOT NULL,
    ngayThanhToan DATETIME DEFAULT CURRENT_TIMESTAMP,
    trangThai VARCHAR(50) DEFAULT 'CHUA_THANH_TOAN',
    FOREIGN KEY (idDonHang) REFERENCES DonHang(idDonHang) ON DELETE CASCADE
);

CREATE TABLE BaoCaoThongKe (
    idBaoCao INT AUTO_INCREMENT PRIMARY KEY,
    idQuanTriVien INT NOT NULL,
    thoiGianBatDau DATE NOT NULL,
    thoiGianKetThuc DATE NOT NULL,
    loaiBaoCao VARCHAR(100),
    FOREIGN KEY (idQuanTriVien) REFERENCES QuanTriVien(idNguoiDung) ON DELETE RESTRICT
);