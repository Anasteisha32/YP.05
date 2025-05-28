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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete_account') {
    try {
        $user_id = $user['user_id'];
        $db->beginTransaction();

        $stmt = $db->prepare("DELETE FROM task_assignees WHERE user_id = ?");
        $stmt->execute([$user_id]);

        $stmt = $db->prepare("DELETE FROM project_members WHERE user_id = ?");
        $stmt->execute([$user_id]);

        $stmt = $db->prepare("DELETE FROM subtasks WHERE assigned_to = ?");
        $stmt->execute([$user_id]);

        $stmt = $db->prepare("DELETE FROM tasks WHERE created_by = ?");
        $stmt->execute([$user_id]);

        $stmt = $db->prepare("DELETE FROM projects WHERE created_by = ?");
        $stmt->execute([$user_id]);

        $stmt = $db->prepare("DELETE FROM users WHERE user_id = ?");
        $stmt->execute([$user_id]);

        $db->commit();

        session_destroy();
        echo json_encode(['success' => true]);
        exit();
    } catch (PDOException $e) {
        
        $db->rollBack();
        echo json_encode(['error' => $e->getMessage()]);
        exit();
    }
}

header('Content-Type: application/json');
echo json_encode($user);
?>
