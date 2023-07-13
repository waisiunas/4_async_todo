<?php require_once('./database/connection.php'); ?>

<?php

$_POST = json_decode(file_get_contents('php://input'), true);
if (isset($_POST['submit'])) {
    $text = htmlspecialchars($_POST['text']);
    $id = htmlspecialchars($_POST['id']);

    if (empty($text)) {
        echo json_encode([
            'taskError' => 'Please provide the task!'
        ]);
    } else {
        $sql = "UPDATE `tasks` SET `text` = '$text' WHERE `id` = $id";
        $is_updated = $conn->query($sql);
        if ($is_updated) {
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
