<?php require_once('./database/connection.php'); ?>

<?php
session_start();
$_POST = json_decode(file_get_contents('php://input'), true);
if (isset($_POST['submit'])) {
    $text = htmlspecialchars($_POST['text']);

    if (empty($text)) {
        echo json_encode([
            'taskError' => 'Please provide the task!'
        ]);
    } else {
        $id = $_SESSION['user']['id'];

        $sql = "INSERT INTO `tasks`(`text`, `user_id`) VALUES ('$text','$id')";
        $is_created = $conn->query($sql);
        if ($is_created) {
            echo json_encode([
                'success' => 'Magic has been spelled!'
            ]);
        } else {
            echo json_encode([
                'error' => 'Magic has become shopper!'
            ]);
        }
    }
}
