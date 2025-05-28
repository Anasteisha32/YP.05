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
    $last_name = $_POST['last_name'];
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $email = $_POST['email'];
    $biography = $_POST['biography'];

    $stmt = $db->prepare("UPDATE users SET last_name = ?, first_name = ?, 
    middle_name = ?, email = ?, biography = ? WHERE user_id = ?");
    $stmt->execute([$last_name, $first_name, $middle_name, $email, $biography, $user['user_id']]);

    $_SESSION['user'] = [
        'user_id' => $user['user_id'],
        'last_name' => $last_name,
        'first_name' => $first_name,
        'middle_name' => $middle_name,
        'email' => $email,
        'biography' => $biography
    ];

    echo json_encode($_SESSION['user']);
    exit();
}

echo json_encode($user);
?>
