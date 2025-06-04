<?php
require_once "dbconnect.php";

$result = $conn->query("SELECT * FROM customer");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Danh sách khách hàng</title>
    <style>
        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ccc;
            text-align: center;
        }
        a {
            text-decoration: none;
            color: #007bff;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h2 style="text-align:center;">Danh sách khách hàng</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Họ tên</th>
            <th>Email</th>
            <th>SĐT</th>
            <th>Ngày sinh</th>
            <th>Địa chỉ</th>
            <th>Giới tính</th>
            <th>Loại khách hàng</th>
            <th>Hành động</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) : ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['hoten']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td><?= htmlspecialchars($row['sdt']) ?></td>
            <td><?= $row['ngaysinh'] ?></td>
            <td><?= htmlspecialchars($row['diachi']) ?></td>
            <td><?= $row['gioitinh'] ?></td>
            <td><?= htmlspecialchars($row['loaikhachhang']) ?></td>
            <td>
                <a href="UpdateCustomer.php?id=<?= $row['id'] ?>">Sửa</a> | 
                <a href="DeleteCustomer.php?id=<?= $row['id'] ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>

<?php $conn->close(); ?>
