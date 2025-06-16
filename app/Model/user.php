<?php 

if (!function_exists('get_all_users')) {
    function get_all_users($conn){
        $sql = "SELECT * FROM users WHERE role =? ";
        $stmt = $conn->prepare($sql);
        $stmt->execute(["user"]);

        if($stmt->rowCount() > 0){
            $users = $stmt->fetchAll();
        } else {
            $users = 0;
        }

        return $users;
    }
}

if (!function_exists('insert_user')) {
    function insert_user($conn, $data){
        $sql = "INSERT INTO users (full_name, username, password, role) VALUES(?,?,?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute($data);
    }
}

if (!function_exists('update_user')) {
    function update_user($conn, $data){
        $sql = "UPDATE users SET full_name=?, username=?, password=?, role=? WHERE id=? AND role=?";
        $stmt = $conn->prepare($sql);
        $stmt->execute($data);
    }
}

if (!function_exists('delete_user')) {
    function delete_user($conn, $data){
        $sql = "DELETE FROM users WHERE id=? AND role=?";
        $stmt = $conn->prepare($sql);
        $stmt->execute($data);
    }
}

if (!function_exists('get_user_by_id')) {
    function get_user_by_id($conn, $id){
        $sql = "SELECT * FROM users WHERE id =? ";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$id]);

        if($stmt->rowCount() > 0){
            $user = $stmt->fetch();
        } else {
            $user = 0;
        }

        return $user;
    }
}

if (!function_exists('update_profile')) {
    function update_profile($conn, $data){
        $sql = "UPDATE users SET full_name=?,  password=? WHERE id=? ";
        $stmt = $conn->prepare($sql);
        $stmt->execute($data);
    }
}

if (!function_exists('count_users')) {
    function count_users($conn){
        $sql = "SELECT id FROM users WHERE role='user'";
        $stmt = $conn->prepare($sql);
        $stmt->execute([]);

        return $stmt->rowCount();
    }
}
