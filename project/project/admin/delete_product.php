<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}
include '../includes/db.php';

$id = $_GET['id'];

// Удаление товара
$query = "DELETE FROM products WHERE id = :id";
$statement = $pdo->prepare($query);
$statement->execute(['id' => $id]);

header("Location: products.php");
exit();
?>
