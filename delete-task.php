<?php require_once('./database/connection.php'); ?>

<?php
$_POST = json_decode(file_get_contents('php://input'), true);
if (isset($_POST['submit'])) {
    $id = htmlspecialchars($_POST['id']);

    $sql = "DELETE FROM `tasks` WHERE `id` = $id";
    $is_deleted = $conn->query($sql);
    if ($is_deleted) {
        echo json_encode([
            'success' => 'Magic has been spelled!'
        ]);
    } else {
        echo json_encode([
            'error' => 'Magic has become shopper!'
        ]);
    }
}
