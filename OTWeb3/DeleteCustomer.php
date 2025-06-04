<?php
require_once "dbconnect.php";

$id = $_GET['id'] ?? 0;

$stmt = $conn->prepare("DELETE FROM customer WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo "<script>alert('Xóa thành công!'); window.location='CustomerList.php';</script>";
} else {
    echo "<script>alert('Xóa thất bại!'); window.location='CustomerList.php';</script>";
}
?>
