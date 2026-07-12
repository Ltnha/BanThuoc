<link rel="stylesheet" href="<?= ASSETROOT ?>/css/khachHang/gioHang.css">

<div class="container mt-4">

    <div class="giohang-box">

        <h2>Giỏ hàng</h2>

        <?php
        if(isset($_SESSION["error"]))
        {
        ?>

        <div class="alert alert-warning">

            <?= $_SESSION["error"] ?>

        </div>

        <?php

        unset($_SESSION["error"]);

        }
        ?>

        <hr>

        <?php if(empty($danhSachThuoc)){ ?>

            <div class="alert alert-warning">

                Chưa có sản phẩm nào trong giỏ hàng.

            </div>

        <?php }else{ ?>

            <table class="table table-bordered">

                <thead>

                    <tr>

                        <th>Tên thuốc</th>

                        <th>Hàm lượng</th>

                        <th>Đơn vị</th>

                        <th>Số lượng</th>

                        <th>Đơn giá</th>

                        <th>Thành tiền</th>

                        <th>Thao tác</th>

                    </tr>

                </thead>

                <tbody>

                <?php foreach($danhSachThuoc as $thuoc){ ?>

                    <tr>

                        <td><?= $thuoc["tenThuoc"] ?></td>

                        <td><?= $thuoc["hamLuong"] ?></td>

                        <td><?= $thuoc["donViTinh"] ?></td>

                        <td>
                            <a
                                class="btn btn-warning btn-sm"
                                href="<?= URLROOT ?>/khachHang/GioHang/giam/<?= $thuoc["id"] ?>">
                                -
                            </a>
                            <strong class="mx-2">
                                <?= $thuoc["soLuong"] ?>
                            </strong>
                            <a
                                class="btn btn-success btn-sm"
                                href="<?= URLROOT ?>/khachHang/GioHang/tang/<?= $thuoc["id"] ?>">
                                +
                            </a>
                        </td>

                        <td><?= number_format($thuoc["donGia"],0,",",".") ?> đ</td>

                        <td>

                            <?= number_format(
                                $thuoc["soLuong"] * $thuoc["donGia"],
                                0,
                                ",",
                                "."
                            ) ?>

                            đ

                        </td>

                        <td>

                            <a
                                class="btn btn-danger btn-sm"

                                href="<?= URLROOT ?>/khachHang/GioHang/xoa/<?= $thuoc["id"] ?>">

                                Xóa

                            </a>

                        </td>

                    </tr>

                <?php } ?>

                </tbody>

            </table>

            <div class="tongTien">

                <h4>

                    Tổng tiền:

                    <span class="text-danger">

                        <?= number_format($tongTien,0,",",".") ?> đ

                    </span>

                </h4>

            </div>

            <div class="text-end mt-3">

                <a
                    href="<?= URLROOT ?>/khachHang/DonHang/datHang"
                    class="btn btn-success btn-lg">

                    Đặt hàng

                </a>

            </div>

        <?php } ?>

    </div>

</div>