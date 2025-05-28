<?php
session_start();

// Проверяем авторизацию
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

// Подключение к базе данных
require_once '../connection.php';
$connection = new Connection();
$db = $connection->getConnection();

try {
    // Получаем список всех пользователей
    $stmt = $db->prepare("SELECT user_id, first_name, last_name, middle_name FROM users");
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Возвращаем данные о пользователях в формате JSON
    header('Content-Type: application/json');
    echo json_encode($users);
} catch (PDOException $e) {
    // Возвращаем ошибку в формате JSON
    header('Content-Type: application/json');
    echo json_encode(['error' => $e->getMessage()]);
}
?>
