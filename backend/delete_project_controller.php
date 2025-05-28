<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$user = $_SESSION['user'];

require_once '../connection.php';
$connection = new Connection();
$db = $connection->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['project_id'])) {
    try {
        $project_id = $_POST['project_id'];

        $db->beginTransaction();

        $stmt = $db->prepare("DELETE FROM subtasks WHERE task_id IN (SELECT task_id FROM tasks WHERE project_id = ?)");
        $stmt->execute([$project_id]);

        $stmt = $db->prepare("DELETE FROM tasks WHERE project_id = ?");
        $stmt->execute([$project_id]);

        $stmt = $db->prepare("DELETE FROM project_members WHERE project_id = ?");
        $stmt->execute([$project_id]);

        $stmt = $db->prepare("DELETE FROM kanban_columns WHERE project_id = ?");
        $stmt->execute([$project_id]);

        $stmt = $db->prepare("DELETE FROM projects WHERE project_id = ?");
        $stmt->execute([$project_id]);

        $db->commit();

        echo json_encode(['success' => true]);
    } catch (PDOException $e) {
        $db->rollBack();
        echo json_encode(['error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Некорректный запрос: отсутствует project_id']);
}
?>
