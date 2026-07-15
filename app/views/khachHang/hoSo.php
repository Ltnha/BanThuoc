<div class="container mt-4">

    <h2>Hồ sơ cá nhân</h2>

    <form
        action="<?= URLROOT ?>/khachHang/KhachHang/capNhat"
        method="POST">

        <div class="mb-3">

            <label>Họ tên</label>

            <input
                type="text"
                class="form-control"
                name="hoTen"
                value="<?= htmlspecialchars($thongTin["hoTen"]) ?>">

        </div>

        <div class="mb-3">

            <label>Email</label>

            <input
                type="email"
                class="form-control"
                value="<?= htmlspecialchars($thongTin["email"]) ?>"
                readonly>

        </div>

        <div class="mb-3">

            <label>Số điện thoại</label>

            <input
                type="text"
                class="form-control"
                name="soDienThoai"
                value="<?= htmlspecialchars($thongTin["soDienThoai"]) ?>">

        </div>

        <div class="mb-3">

            <label>Ngày sinh</label>

            <input
                type="date"
                class="form-control"
                name="ngaySinh"
                value="<?= $thongTin["ngaySinh"] ?>">

        </div>

        <div class="mb-3">

            <label>Địa chỉ giao hàng</label>

            <textarea
                class="form-control"
                name="diaChi"
                rows="3"><?= htmlspecialchars($thongTin["diaChiGiaoHang"]) ?></textarea>

        </div>

        <div class="mb-3">

            <label>Điểm tích lũy</label>

            <input
                type="text"
                class="form-control"
                value="<?= $thongTin["diemTichLuy"] ?>"
                readonly>

        </div>

        <button
            class="btn btn-success">

            Cập nhật

        </button>

    </form>

</div>