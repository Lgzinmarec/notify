<?php
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id'])) {
    include "../DB_connection.php";
    include "Model/Notification.php";

    $notifications = get_all_my_notifications($conn, $_SESSION['id']);

    if ($notifications == 0) { ?>
        <li>
            <a href="#">
                Você não possui notificações
            </a>
        </li>
        <?php } else {
        foreach ($notifications as $notification) {

            $tipo = htmlspecialchars($notification['type']);
            $mensagem = htmlspecialchars($notification['message']);
            $data = htmlspecialchars($notification['date']);
            $id = intval($notification['id']);
        ?>
            <li>
                <a href="app/notification-read.php?notification_id=<?= $id ?>">
                    <?php
                    if ($notification['is_read'] == 0) {
                        echo "<mark>$tipo</mark>: ";
                    } else {
                        echo "$tipo: ";
                    }
                    ?>
                    <?= $mensagem ?>
                    &nbsp;&nbsp;<small><?= $data ?></small>
                </a>
            </li>
<?php
        }
    }
} else {
    echo "";
}
?>