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
    $khoahoc = $_POST["khoahoc"];

    $stmt = $conn->prepare("UPDATE student SET hoten=?, email=?, sdt=?, ngaysinh=?, diachi=?, gioitinh=?, khoahoc=? WHERE id=?");
    $stmt->bind_param("sssssssi", $hoten, $email, $sdt, $ngaysinh, $diachi, $gioitinh, $khoahoc, $id);

    if ($stmt->execute()) {
        echo "<script>alert('Cập nhật thành công!'); window.location='StudentList.php';</script>";
    } else {
        echo "<script>alert('Cập nhật thất bại!');</script>";
    }
    exit();
}

// Load dữ liệu cũ
$stmt = $conn->prepare("SELECT * FROM student WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();
?>
<link rel="stylesheet" href="style_register.css">

<form method="post">
    <h2>Cập nhật thông tin</h2>
    <p>Họ và tên (*)</p>
    <input type="text" name="hoten" value="<?= $student['hoten'] ?>" required><br>
    <p>Email (*)</p>
    <input type="text" name="email" value="<?= $student['email'] ?>" required><br>
    <p>Số điện thoại</p>
    <input type="text" name="sdt" value="<?= $student['sdt'] ?>"><br>
    <p>Ngày sinh (*)</p>
    <input type="date" name="ngaysinh" value="<?= $student['ngaysinh'] ?>" required><br>
    <p>Địa chỉ</p>
    <input type="text" name="diachi" value="<?= $student['diachi'] ?>"><br>
    <p>Giới tính (*)</p>
    <label><input type="radio" name="gioitinh" value="nam" <?= ($student['gioitinh'] == 'nam') ? 'checked' : '' ?>> Nam</label>
    <label><input type="radio" name="gioitinh" value="nu" <?= ($student['gioitinh'] == 'nu') ? 'checked' : '' ?>> Nữ</label>
    <label><input type="radio" name="gioitinh" value="khac" <?= ($student['gioitinh'] == 'khac') ? 'checked' : '' ?>> Khác</label><br>
    <p>Khóa học (*)</p>
    <select name="khoahoc">
        <option value="web" <?= ($student['khoahoc'] == 'web') ? 'selected' : '' ?>>Phát triển Web</option>
        <option value="khdl" <?= ($student['khoahoc'] == 'khdl') ? 'selected' : '' ?>>Khoa học Dữ liệu</option>
        <option value="uddd" <?= ($student['khoahoc'] == 'uddd') ? 'selected' : '' ?>>Phát triển Ứng dụng Di động</option>
    </select><br>

    <button type="submit">Cập nhật</button>
</form>
