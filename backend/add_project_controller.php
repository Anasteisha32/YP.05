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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $projectName = $_POST['project-name'];
        $projectDesc = $_POST['project-desc'];
        $projectType = $_POST['project-type'];
        $isPublic = ($projectType === 'public') ? 1 : 0;
        $createdBy = $user['user_id'];

        $db->beginTransaction();

        $stmt = $db->prepare("INSERT INTO projects (name, description, is_public, created_by) VALUES (?, ?, ?, ?)");
        $stmt->execute([$projectName, $projectDesc, $isPublic, $createdBy]);
        $projectId = $db->lastInsertId();

        $stmt = $db->prepare("INSERT INTO project_members (project_id, user_id, role) VALUES (?, ?, 'creator')");
        $stmt->execute([$projectId, $createdBy]);

        if (isset($_POST['members'])) {
            $members = json_decode($_POST['members'], true);
            foreach ($members as $member) {
                if (isset($member['user_id']) && isset($member['role'])) {
                    $stmt = $db->prepare("INSERT INTO project_members (project_id, user_id, role) VALUES (?, ?, ?)");
                    $stmt->execute([$projectId, $member['user_id'], $member['role']]);
                }
            }
        }

        $db->commit();

        echo json_encode(['success' => true, 'project_id' => $projectId]);
    } catch (PDOException $e) {

        $db->rollBack();
        echo json_encode(['error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Некорректный запрос']);
}
?>
