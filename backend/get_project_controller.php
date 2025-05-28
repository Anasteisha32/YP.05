<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
require_once '../connection.php';
$connection = new Connection();
$db = $connection->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['project_id'])) {
    try {
        $projectId = $_POST['project_id'];

        $stmt = $db->prepare("
            SELECT p.project_id, p.name, p.description, p.is_public,
                   u.user_id as creator_id, u.first_name as creator_first_name, 
                   u.last_name as creator_last_name, u.middle_name as creator_middle_name
            FROM projects p
            JOIN users u ON p.created_by = u.user_id
            WHERE p.project_id = ?
        ");
        $stmt->execute([$projectId]);
        $project = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$project) {
            echo json_encode(['error' => 'Проект не найден']);
            exit();
        }
        $stmt = $db->prepare("
            SELECT u.user_id, u.first_name, u.last_name, u.middle_name, pm.role
            FROM project_members pm
            JOIN users u ON pm.user_id = u.user_id
            WHERE pm.project_id = ?
        ");
        $stmt->execute([$projectId]);
        $members = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $project['members'] = $members;

        header('Content-Type: application/json');
        echo json_encode($project);
    } catch (PDOException $e) {

        header('Content-Type: application/json');
        echo json_encode(['error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Некорректный запрос: отсутствует project_id']);
}
?>
