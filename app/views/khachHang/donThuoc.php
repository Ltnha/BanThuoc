<div class="container mt-4">

    <h2>Đơn thuốc</h2>
    <?php if(isset($_SESSION["success"])): ?>

        <div class="alert alert-success">

            <?= $_SESSION["success"]; ?>

        </div>

    <?php unset($_SESSION["success"]); endif; ?>


    <?php if(isset($_SESSION["error"])): ?>

        <div class="alert alert-danger">

            <?= $_SESSION["error"]; ?>

        </div>

    <?php unset($_SESSION["error"]); endif; ?>

    <form
        action="<?= URLROOT ?>/khachHang/donThuoc/them"
        method="POST"
        enctype="multipart/form-data">

        <div class="mb-3">

            <label>Ảnh đơn thuốc</label>

            <input
                type="file"
                class="form-control"
                name="hinhAnh"
                required>

        </div>

        <div class="mb-3">

            <label>Ghi chú</label>

            <textarea
                class="form-control"
                name="ghiChu"
                rows="4"></textarea>

        </div>

        <button
            class="btn btn-success">

            Gửi đơn thuốc

        </button>

    </form>

    <hr>

    <h3>Danh sách đơn thuốc</h3>

    <table class="table table-bordered">

        <thead>

            <tr>

                <th>ID</th>

                <th>Ảnh</th>

                <th>Ngày gửi</th>

                <th>Trạng thái</th>

            </tr>

        </thead>

        <tbody>

        <?php foreach($danhSach as $donThuoc){ ?>

            <tr>

                <td><?= $donThuoc["idDonThuoc"] ?></td>

                <<td>

                    <img
                        src="<?= ASSETROOT ?>/images/donThuoc/<?= $donThuoc["hinhAnhDonThuoc"] ?>"
                        width="120"
                        style="border-radius:8px;">

                </td>

                <td><?= $donThuoc["ngayGui"] ?></td>

                <td><?= $donThuoc["trangThai"] ?></td>

            </tr>

        <?php } ?>

        </tbody>

    </table>

</div>