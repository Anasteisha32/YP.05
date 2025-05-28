<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}


require_once '../connection.php';
$connection = new Connection();
$db = $connection->getConnection();

if (isset($_POST['task_id'])) {
    try {
        $taskId = $_POST['task_id'];

        $db->beginTransaction();

        $stmt = $db->prepare("DELETE FROM subtasks WHERE task_id = ?");
        $stmt->execute([$taskId]);

        $stmt = $db->prepare("DELETE FROM tasks WHERE task_id = ?");
        $stmt->execute([$taskId]);

        $db->commit();

        header('Content-Type: application/json');
        echo json_encode(['success' => true]);
    } catch (PDOException $e) {

        $db->rollBack();

 
        header('Content-Type: application/json');
        echo json_encode(['error' => $e->getMessage()]);
    }
} else {

    header('Content-Type: application/json');
    echo json_encode(['error' => 'Некорректный запрос: отсутствует task_id']);
}
?>
