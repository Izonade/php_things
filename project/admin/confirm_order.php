<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}
include '../includes/db.php';

$order_id = $_GET['id'];

// Обновление статуса заказа
$query = "UPDATE orders SET status = 'confirmed' WHERE id = :order_id";
$statement = $pdo->prepare($query);
$statement->execute(['order_id' => $order_id]);

header("Location: orders.php");
exit();
?>
