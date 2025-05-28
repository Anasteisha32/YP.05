<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

require_once '../connection.php';
$connection = new Connection();
$db = $connection->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $projectId = $_POST['project_id'];
        $projectName = $_POST['project-name'];
        $projectDesc = $_POST['project-desc'];
        $projectType = $_POST['project-type'];
        $members = json_decode($_POST['members'], true);

        $stmt = $db->prepare("UPDATE projects SET name = ?, description = ?, is_public = ? WHERE project_id = ?");
        $stmt->execute([$projectName, $projectDesc, $projectType === 'public' ? 1 : 0, $projectId]);

        $stmt = $db->prepare("SELECT created_by FROM projects WHERE project_id = ?");
        $stmt->execute([$projectId]);
        $creatorId = $stmt->fetchColumn();

        $stmt = $db->prepare("DELETE FROM project_members WHERE project_id = ? AND user_id != ?");
        $stmt->execute([$projectId, $creatorId]);

        foreach ($members as $member) {
            $stmt = $db->prepare("INSERT INTO project_members (project_id, user_id, role) VALUES (?, ?, ?)");
            $stmt->execute([$projectId, $member['user_id'], $member['role']]);
        }

        header('Content-Type: application/json');
        echo json_encode(['success' => true]);
    } catch (PDOException $e) {

        header('Content-Type: application/json');
        echo json_encode(['error' => $e->getMessage()]);
    }
} else {

    header('Content-Type: application/json');
    echo json_encode(['error' => 'Некорректный запрос']);
}
?>
