<?php
session_start();

// Проверяем авторизацию
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$user = $_SESSION['user'];

require_once '../connection.php';
$connection = new Connection();
$db = $connection->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $taskName = $_POST['task-name'];
        $taskDesc = $_POST['task-desc'];
        $taskDueDate = $_POST['task-due'];
        $taskDueTime = $_POST['task-due-time'];
        $projectId = $_POST['project_id'];
        $createdBy = $user['user_id'];

        // Объединяем дату и время
        $taskDueDateTime = $taskDueDate . ' ' . $taskDueTime;

        // Устанавливаем column_id для столбца "Новые"
        $columnId = 1; // Предполагаем, что column_id для столбца "Новые" равен 1

        // Начинаем транзакцию
        $db->beginTransaction();

        // Вставляем новую задачу с column_id
        $stmt = $db->prepare("INSERT INTO tasks (name, description, due_date, project_id, created_by, column_id) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$taskName, $taskDesc, $taskDueDateTime, $projectId, $createdBy, $columnId]);
        $taskId = $db->lastInsertId();

        // Добавляем ответственных
        if (isset($_POST['assignees'])) {
            $assignees = json_decode($_POST['assignees'], true);
            foreach ($assignees as $assignee) {
                if (isset($assignee)) {
                    $stmt = $db->prepare("INSERT INTO task_assignees (task_id, user_id) VALUES (?, ?)");
                    $stmt->execute([$taskId, $assignee]);
                }
            }
        }

        // Фиксируем транзакцию
        $db->commit();

        echo json_encode(['success' => true, 'task_id' => $taskId]);
    } catch (PDOException $e) {
        // Откатываем транзакцию в случае ошибки
        $db->rollBack();
        echo json_encode(['error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Некорректный запрос']);
}
?>
