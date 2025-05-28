<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

require_once '../connection.php';
$connection = new Connection();
$db = $connection->getConnection();

if (isset($_POST['task_id']) && isset($_POST['column_id'])) {
    try {
        $taskId = $_POST['task_id'];
        $columnId = $_POST['column_id'];

        $stmt = $db->prepare("UPDATE tasks SET column_id = ? WHERE task_id = ?");
        $stmt->execute([$columnId, $taskId]);

        header('Content-Type: application/json');
        echo json_encode(['success' => true]);
    } catch (PDOException $e) {

        header('Content-Type: application/json');
        echo json_encode(['error' => $e->getMessage()]);
    }
} else {

    header('Content-Type: application/json');
    echo json_encode(['error' => 'Некорректный запрос: отсутствует task_id или column_id']);
}
?>
