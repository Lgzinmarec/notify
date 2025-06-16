<?php
session_start();

if (isset($_POST['user_name']) && isset($_POST['password'])) {
    include "../DB_connection.php";
    require_once "app/Controller/LoginController.php";
    $data = login_controller();
    $error = $data['error'];
    $success = $data['success'];


    function validate_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $user_name = validate_input($_POST['user_name']);
    $password = validate_input($_POST['password']);

    if (empty($user_name)) {
        $em = "Nome de Usuario Requerido";
        header("Location: ../login.php?error=$em");
        exit();
    } else if (empty($password)) {
        $em = "Senha Necessaria";
        header("Location: ../login.php?error=$em");
        exit();
    } else {
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$user_name]);

        if ($stmt->rowCount() == 1) {
            $user = $stmt->fetch();
            $usernameDb = $user['username'];
            $passwordDb = $user['password'];
            $role = $user['role'];
            $id = $user['id'];

            if ($user_name === $usernameDb) {
                if (password_verify($password, $passwordDb)) {
                    $_SESSION['role'] = $role;
                    $_SESSION['id'] = $id;
                    $_SESSION['username'] = $usernameDb;
                    header("Location: ../index.php");
                    exit();
                } else {
                    $em = "Usuario ou Senha incorreta";
                    header("Location: ../login.php?error=$em");
                    exit();
                }
            } else {
                $em = "Usuario ou Senha incorreta";
                header("Location: ../login.php?error=$em");
                exit();
            }
        } else {
            $em = "Usuario ou Senha incorreta";
            header("Location: ../login.php?error=$em");
            exit();
        }
    }
} else {
    $em = "Usuario ou Senha incorreta";
    header("Location: ../login.php?error=$em");
    exit();
}
