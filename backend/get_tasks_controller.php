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

if (isset($_GET['project_id'])) {
    try {
        $projectId = $_GET['project_id'];

        $stmt = $db->prepare("
            SELECT t.task_id, t.name as title, t.description, t.due_date, t.column_id,
                   u.user_id as creator_id, u.first_name as creator_first_name, u.last_name as creator_last_name, u.middle_name as creator_middle_name,
                   GROUP_CONCAT(DISTINCT ua.last_name, ' ', ua.first_name, ' ', ua.middle_name SEPARATOR ', ') as assignees,
                   (SELECT COUNT(*) FROM subtasks WHERE task_id = t.task_id) as subtasks_count
            FROM tasks t
            LEFT JOIN users u ON t.created_by = u.user_id
            LEFT JOIN task_assignees ta ON t.task_id = ta.task_id
            LEFT JOIN users ua ON ta.user_id = ua.user_id
            WHERE t.project_id = ?
            GROUP BY t.task_id
        ");
        $stmt->execute([$projectId]);
        $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);


        header('Content-Type: application/json');
        echo json_encode($tasks);
    } catch (PDOException $e) {

        header('Content-Type: application/json');
        echo json_encode(['error' => $e->getMessage()]);
    }
} else {

    header('Content-Type: application/json');
    echo json_encode(['error' => 'Некорректный запрос: отсутствует project_id']);
}



?>
