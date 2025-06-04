<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["dangky"])) {
    require_once "dbconnect.php";

    $hoten = trim($_POST["hoten"]);
    $email = trim($_POST["email"]);
    $sdt = trim($_POST["sdt"]);
    $ngaysinh = $_POST["ngaysinh"];
    $diachi = trim($_POST["diachi"]);
    $gioitinh = $_POST["gioitinh"] ?? '';
    $khoahoc = $_POST["khoahoc"];
    
    // Kiểm tra các trường bắt buộc
    if ($hoten == "" || $email == "" || $ngaysinh == "" || $gioitinh == "" || $khoahoc == "") {
        
    } else {
        // Sử dụng Prepared Statement để chống SQL injection
        $stmt = $conn->prepare("INSERT INTO student (hoten, email, sdt, ngaysinh, diachi, gioitinh, khoahoc) 
                                VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $hoten, $email, $sdt, $ngaysinh, $diachi, $gioitinh, $khoahoc);

        if ($stmt->execute()) {
            echo "<script>alert('Đăng ký thành công!');</script>";
        } else {
            echo "<script>alert('Đăng ký thất bại!');</script>";
        }
        $stmt->close();
        $conn->close();
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Form Đăng Ký</title>
    <link rel="stylesheet" href="style_register.css">
</head>
<body>
    <form method="post" action="">
        <h2>Đăng ký</h2>
        <p>Họ và tên (*)</p>
        <input type="text" name="hoten" placeholder="Nhập họ tên" required>
        <p>Email (*)</p>
        <input type="text" name="email" placeholder="Nhập email" required>
        <p>Số điện thoại</p>
        <input type="text" name="sdt" placeholder="Nhập số điện thoại">
        <p>Ngày sinh (*)</p>
        <input type="date" name="ngaysinh" required>
        <p>Địa chỉ</p>
        <input type="text" name="diachi" placeholder="Nhập địa chỉ">
        <p>Giới tính (*)</p>
        <div class="gender-options">
            <label><input type="radio" name="gioitinh" value="nam" required> Nam</label>
            <label><input type="radio" name="gioitinh" value="nu"> Nữ</label>
            <label><input type="radio" name="gioitinh" value="khac"> Khác</label>
        </div>
        <p>Khóa học (*)</p>
        <select name="khoahoc" required>
            <option value="">-- Chọn khóa học --</option>
            <option value="web">Phát triển Web</option>
            <option value="khdl">Khoa học Dữ liệu</option>
            <option value="uddd">Phát triển Ứng dụng Di động</option>
        </select>
        <div class="btn-group">
            <button type="submit" name="dangky">Đăng ký</button>
            <button type="reset" name="xoa">Xóa Form</button>
        </div>
    </form>
</body>
</html>