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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Получаем данные из формы
        $taskId = $_POST['task_id'] ?? null;
        $taskName = $_POST['task-name'] ?? null;
        $taskDesc = $_POST['task-desc'] ?? null;
        $taskDueDate = $_POST['task-due'] ?? null;
        $taskDueTime = $_POST['task-due-time'] ?? null;
        $assignees = $_POST['assignees'] ?? [];
        $projectId = $_POST['project_id'] ?? null;

        if (!$taskId) {
            throw new Exception("Некорректный запрос: отсутствует task_id");
        }

        // Проверяем, что задача существует и пользователь имеет право на её редактирование
        $stmt = $db->prepare("SELECT * FROM tasks WHERE task_id = ?");
        $stmt->execute([$taskId]);
        $task = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$task) {
            throw new Exception("Задача не найдена");
        }

        // Проверяем, является ли текущий пользователь создателем задачи или администратором проекта
        $isCreatorOrAdmin = $_SESSION['user']['user_id'] === $task['created_by'] || $_SESSION['user']['role'] === 'admin';

        if (!$isCreatorOrAdmin) {
            throw new Exception("У вас нет прав для редактирования этой задачи");
        }

        // Обновляем данные задачи
        $stmt = $db->prepare("UPDATE tasks SET name = ?, description = ?, due_date = ? WHERE task_id = ?");
        $dueDateTime = $taskDueDate . ' ' . $taskDueTime;
        $stmt->execute([$taskName, $taskDesc, $dueDateTime, $taskId]);

        // Обновляем ответственных за задачу
        $stmt = $db->prepare("DELETE FROM task_assignees WHERE task_id = ?");
        $stmt->execute([$taskId]);

        if (is_array($assignees)) {
            foreach ($assignees as $userId) {
                if (!empty($userId)) {
                    $stmt = $db->prepare("INSERT INTO task_assignees (task_id, user_id) VALUES (?, ?)");
                    $stmt->execute([$taskId, $userId]);
                }
            }
        }

        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'project_id' => $projectId]);
    } catch (PDOException $e) {
        header('Content-Type: application/json');
        echo json_encode(['error' => $e->getMessage()]);
    } catch (Exception $e) {
        header('Content-Type: application/json');
        echo json_encode(['error' => $e->getMessage()]);
    }
} else {
    // GET запрос - отображение формы редактирования
    if (isset($_GET['task_id'])) {
        try {
            $taskId = $_GET['task_id'];

            // Получаем данные задачи
            $stmt = $db->prepare("
                SELECT t.task_id, t.name, t.description, t.due_date, t.project_id,
                       GROUP_CONCAT(DISTINCT ta.user_id) as assignee_ids
                FROM tasks t
                LEFT JOIN task_assignees ta ON t.task_id = ta.task_id
                WHERE t.task_id = ?
                GROUP BY t.task_id
            ");
            $stmt->execute([$taskId]);
            $task = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$task) {
                throw new Exception("Задача не найдена");
            }

            // Получаем участников проекта
            $stmt = $db->prepare("
                SELECT u.user_id, u.first_name, u.last_name, u.middle_name
                FROM project_members pm
                JOIN users u ON pm.user_id = u.user_id
                WHERE pm.project_id = ?
            ");
            $stmt->execute([$task['project_id']]);
            $members = $stmt->fetchAll(PDO::FETCH_ASSOC);

            header('Content-Type: application/json');
            echo json_encode([
                'task' => $task,
                'members' => $members
            ]);
        } catch (PDOException $e) {
            header('Content-Type: application/json');
            echo json_encode(['error' => $e->getMessage()]);
        } catch (Exception $e) {
            header('Content-Type: application/json');
            echo json_encode(['error' => $e->getMessage()]);
        }
    } else {
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Некорректный запрос: отсутствует task_id']);
    }
}
?>