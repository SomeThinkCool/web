<?php
require_once "dbconnect.php";

// Lấy danh sách khóa học để đưa vào combobox
$khoaHocResult = $conn->query("SELECT DISTINCT khoahoc FROM student");

// Xử lý tìm kiếm và lọc
$search = isset($_GET['search']) ? trim($_GET['search']) : "";
$khoahoc = isset($_GET['khoahoc']) ? trim($_GET['khoahoc']) : "";

$sql = "SELECT * FROM student WHERE 1=1";
$params = [];
$types = "";

// Tìm kiếm theo tên/email/khóa học
if ($search !== "") {
    $sql .= " AND (hoten LIKE ? OR email LIKE ? OR khoahoc LIKE ?)";
    $likeSearch = "%$search%";
    $params[] = &$likeSearch;
    $params[] = &$likeSearch;
    $params[] = &$likeSearch;
    $types .= "sss";
}

// Lọc theo khóa học nếu được chọn
if ($khoahoc !== "") {
    $sql .= " AND khoahoc = ?";
    $params[] = &$khoahoc;
    $types .= "s";
}

// Chuẩn bị truy vấn
$stmt = $conn->prepare($sql);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Danh sách sinh viên</title>
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
        form {
            width: 90%;
            margin: 20px auto;
            text-align: center;
        }
        input[type="text"], select {
            padding: 8px;
            width: 220px;
            border-radius: 4px;
            border: 1px solid #ccc;
            margin: 5px;
        }
        input[type="submit"] {
            padding: 8px 16px;
            border-radius: 4px;
            border: none;
            background-color: #007bff;
            color: white;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
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
    <h2 style="text-align:center;">Danh sách sinh viên</h2>

    <form method="GET" action="">
        <input type="text" name="search" placeholder="Tìm theo tên, email..." value="<?= htmlspecialchars($search) ?>">
        
        <select name="khoahoc">
            <option value="">-- Tất cả khóa học --</option>
            <?php while ($rowKH = $khoaHocResult->fetch_assoc()): ?>
                <option value="<?= htmlspecialchars($rowKH['khoahoc']) ?>" <?= ($khoahoc == $rowKH['khoahoc']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($rowKH['khoahoc']) ?>
                </option>
            <?php endwhile; ?>
        </select>

        <input type="submit" value="Lọc / Tìm kiếm">
    </form>

    <table>
        <tr>
            <th>ID</th>
            <th>Họ tên</th>
            <th>Email</th>
            <th>SĐT</th>
            <th>Ngày sinh</th>
            <th>Địa chỉ</th>
            <th>Giới tính</th>
            <th>Khóa học</th>
            <th>Hành động</th>
        </tr>
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()) : ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['hoten']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><?= htmlspecialchars($row['sdt']) ?></td>
                <td><?= $row['ngaysinh'] ?></td>
                <td><?= htmlspecialchars($row['diachi']) ?></td>
                <td><?= $row['gioitinh'] ?></td>
                <td><?= htmlspecialchars($row['khoahoc']) ?></td>
                <td>
                    <a href="UpdateStudent.php?id=<?= $row['id'] ?>">Sửa</a> | 
                    <a href="DeleteStudent.php?id=<?= $row['id'] ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</a>
                </td>
            </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="9">Không tìm thấy sinh viên nào.</td>
            </tr>
        <?php endif; ?>
    </table>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
