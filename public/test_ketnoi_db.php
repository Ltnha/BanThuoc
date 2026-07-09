<?php

require_once '../app/config/database.php';
require_once '../app/core/Database.php';

$db = new Database();

// thực hiện truy vấn SQL để lấy dữ liệu từ bảng Thuoc
$db->query("SELECT * FROM Thuoc");

// nếu muốn lấy dữ liệu 1 bản ghi duy nhất, có thể sử dụng phương thức single() thay vì resultSet()
// app\core\Database.php vào public function single() {
$data = $db->resultSet();

// kiểm tra có kết nối với cơ sở dữ liệu hay không
if ($db->rowCount() > 0) {
    echo "Kết nối với cơ sở dữ liệu thành công";
} else {
    echo "Kết nối với cơ sở dữ liệu thất bại";
}

// hiển thị dữ liệu ra màn hình để kiểm tra
echo "<pre>";
print_r($data);
echo "</pre>";


