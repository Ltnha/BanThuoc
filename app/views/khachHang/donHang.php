<link rel="stylesheet" href="<?= ASSETROOT ?>/css/khachHang/donHang.css">

<div class="container mt-4">

    <h2>Đơn hàng của tôi</h2>

    <table class="table table-bordered table-hover mt-4">

        <thead class="table-primary">

            <tr>

                <th>Mã đơn</th>

                <th>Ngày đặt</th>

                <th>Tổng tiền</th>

                <th>Trạng thái</th>

                <th></th>

            </tr>

        </thead>

        <tbody>

        <?php foreach($danhSachDonHang as $donHang){ ?>

            <tr>

                <td>

                    #<?= $donHang["idDonHang"] ?>

                </td>

                <td>

                    <?= $donHang["ngayDat"] ?>

                </td>

                <td>

                    <?= number_format($donHang["tongTien"],0,",",".") ?>

                    đ

                </td>

                <td>

                    <?= $donHang["trangThai"] ?>

                </td>

                <td>

                    <a

                    href="<?= URLROOT ?>/khachHang/DonHang/chiTiet/<?= $donHang["idDonHang"] ?>"

                    class="btn btn-primary btn-sm">

                    Xem

                    </a>

                </td>

            </tr>

        <?php } ?>

        </tbody>

    </table>

</div>