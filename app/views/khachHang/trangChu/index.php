<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Danh sách thuốc</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container mt-5">

    <h2>Danh sách thuốc</h2>

    <table class="table table-bordered table-hover mt-3">

        <thead class="table-dark">

            <tr>

                <th>ID</th>

                <th>Tên thuốc</th>

                <th>Danh mục</th>

                <th>Hàm lượng</th>

                <th>Đơn vị</th>

                <th>Giá bán</th>

                <th>Yêu cầu kê đơn</th>

            </tr>

        </thead>

        <tbody>

        <?php foreach($data["thuoc"] as $thuoc){ ?>

            <tr>

                <td><?= $thuoc["idThuoc"] ?></td>

                <td><?= $thuoc["tenThuoc"] ?></td>

                <td><?= $thuoc["tenDanhMuc"] ?></td>

                <td><?= $thuoc["hamLuong"] ?></td>

                <td><?= $thuoc["donViTinh"] ?></td>

                <td><?= number_format($thuoc["giaBan"],0,",",".") ?> đ</td>

                <td><?= $thuoc["yeuCauKeDon"] ?></td>

            </tr>

        <?php } ?>

        </tbody>

    </table>

</div>

</body>

</html>