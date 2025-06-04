<?php
require_once "dbconnect.php";

$id = $_GET['id'] ?? 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $hoten = $_POST["hoten"];
    $email = $_POST["email"];
    $sdt = $_POST["sdt"];
    $ngaysinh = $_POST["ngaysinh"];
    $diachi = $_POST["diachi"];
    $gioitinh = $_POST["gioitinh"];
    $loaikhachhang = $_POST["loaikhachhang"];

    $stmt = $conn->prepare("UPDATE customer SET hoten=?, email=?, sdt=?, ngaysinh=?, diachi=?, gioitinh=?, loaikhachhang=? WHERE id=?");
    $stmt->bind_param("sssssssi", $hoten, $email, $sdt, $ngaysinh, $diachi, $gioitinh, $loaikhachhang, $id);

    if ($stmt->execute()) {
        echo "<script>alert('Cập nhật thành công!'); window.location='CustomerList.php';</script>";
    } else {
        echo "<script>alert('Cập nhật thất bại!');</script>";
    }
    exit();
}

// Load dữ liệu cũ
$stmt = $conn->prepare("SELECT * FROM customer WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$customer = $result->fetch_assoc();
?>
<link rel="stylesheet" href="style.css">

<form method="post">
    <h2>Cập nhật thông tin</h2>
    <p>Họ và tên (*)</p>
    <input type="text" name="hoten" value="<?= $customer['hoten'] ?>" required><br>
    <p>Email (*)</p>
    <input type="text" name="email" value="<?= $customer['email'] ?>" required><br>
    <p>Số điện thoại</p>
    <input type="text" name="sdt" value="<?= $customer['sdt'] ?>"><br>
    <p>Ngày sinh (*)</p>
    <input type="date" name="ngaysinh" value="<?= $customer['ngaysinh'] ?>" required><br>
    <p>Địa chỉ</p>
    <input type="text" name="diachi" value="<?= $customer['diachi'] ?>"><br>
    <p>Giới tính (*)</p>
    <label><input type="radio" name="gioitinh" value="nam" <?= ($customer['gioitinh'] == 'nam') ? 'checked' : '' ?>> Nam</label>
    <label><input type="radio" name="gioitinh" value="nu" <?= ($customer['gioitinh'] == 'nu') ? 'checked' : '' ?>> Nữ</label>
    <label><input type="radio" name="gioitinh" value="khac" <?= ($customer['gioitinh'] == 'khac') ? 'checked' : '' ?>> Khác</label><br>
    <p>Khóa học (*)</p>
    <select name="loaikhachhang">
        <option value="thuong" <?= ($customer['loaikhachhang'] == 'thuong') ? 'selected' : '' ?>>Thường</option>
        <option value="vip" <?= ($customer['loaikhachhang'] == 'vip') ? 'selected' : '' ?>>Vip</option>
        <option value="doanhnghiep" <?= ($customer['loaikhachhang'] == 'doanhnghiep') ? 'selected' : '' ?>>Doanhnghiệp</option>
    </select><br>

    <button type="submit">Cập nhật</button>
</form>
