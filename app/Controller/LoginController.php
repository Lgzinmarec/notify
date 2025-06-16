
<?php
require_once __DIR__ . "/../init.php";
require_once __DIR__ . "/../Model/User.php";

function login_controller() {
    $error = "";
    $success = "";

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $user = $_POST['user_name'] ?? '';
        $pass = $_POST['password'] ?? '';

        if ($user === "" || $pass === "") {
            $error = "Preencha todos os campos!";
        } else {
            global $conn;
            $sql = "SELECT * FROM users WHERE username = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$user]);

            if ($stmt->rowCount() == 1) {
                $u = $stmt->fetch();
                if (password_verify($pass, $u['password'])) {
                    $_SESSION['role'] = $u['role'];
                    $_SESSION['id'] = $u['id'];
                    $_SESSION['username'] = $u['username'];
                    header("Location: index.php");
                    exit();
                } else {
                    $error = "Usuário ou senha incorretos";
                }
            } else {
                $error = "Usuário ou senha incorretos";
            }
        }
    }

    return [
        'error' => $error,
        'success' => $success
    ];
}
