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

try {
    $user_id = $user['user_id'];

    $stmt = $db->prepare("
        SELECT p.project_id, p.name, p.description, p.is_public, p.created_at, p.created_by,
               u.first_name as creator_first_name, u.last_name as creator_last_name, u.middle_name as creator_middle_name,
               pm.role as user_role
        FROM projects p
        JOIN project_members pm ON p.project_id = pm.project_id
        JOIN users u ON p.created_by = u.user_id
        WHERE pm.user_id = ? AND pm.role IN ('creator', 'admin', 'member')
    ");
    $stmt->execute([$user_id]);
    $projects = $stmt->fetchAll(PDO::FETCH_ASSOC);

    header('Content-Type: application/json');
    echo json_encode($projects);
} catch (PDOException $e) {

    header('Content-Type: application/json');
    echo json_encode(['error' => $e->getMessage()]);
}
?>
