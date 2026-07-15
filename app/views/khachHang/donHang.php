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

                <th>Thao tác</th>
                
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

                    <?php if($donHang["trangThai"]=="CHO_XAC_NHAN"){ ?>

                        <a
                            href="<?= URLROOT ?>/khachHang/donHang/huy/<?= $donHang["idDonHang"] ?>"
                            class="btn btn-danger btn-sm"
                            onclick="return confirm('Bạn có chắc muốn hủy đơn hàng?')">

                            Hủy

                        </a>

                    <?php } ?>
                </td>

            </tr>

        <?php } ?>

        </tbody>

    </table>

</div>