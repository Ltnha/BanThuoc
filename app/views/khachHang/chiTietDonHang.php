<link rel="stylesheet" href="<?= ASSETROOT ?>/css/khachHang/donHang.css">

<div class="container mt-4">

<h2>Chi tiết đơn hàng</h2>

<table class="table table-bordered">

<tr>

<th>Thuốc</th>

<th>Số lượng</th>

<th>Đơn giá</th>

</tr>

<?php foreach($chiTiet as $ct){ ?>

<tr>

<td><?= $ct["tenThuoc"] ?></td>

<td><?= $ct["soLuong"] ?></td>

<td><?= number_format($ct["donGia"],0,",",".") ?> đ</td>

</tr>

<?php } ?>

</table>

</div>