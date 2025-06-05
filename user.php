<?php 
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id']) && $_SESSION['role'] == "admin") {
    include "DB_connection.php";
    include "app/Model/User.php";

    $usuarios = get_all_users($conn);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Gerenciar Usuários</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <input type="checkbox" id="checkbox">
    <?php include "inc/header.php" ?>
    <div class="body">
        <?php include "inc/nav.php" ?>
        <section class="section-1">
            <h4 class="title">Gerenciar Usuários <a href="add-user.php">Adicionar Usuário</a></h4>
            <?php if (isset($_GET['success'])) { ?>
                <div class="success" role="alert">
                    <?php echo stripcslashes($_GET['success']); ?>
                </div>
            <?php } ?>
            <?php if ($usuarios != 0) { ?>
                <table class="main-table">
                    <tr>
                        <th>#</th>
                        <th>Nome Completo</th>
                        <th>Nome de Usuário</th>
                        <th>Função</th>
                        <th>Ação</th>
                    </tr>
                    <?php $i=0; foreach ($usuarios as $usuario) { ?>
                    <tr>
                        <td><?=++$i?></td>
                        <td><?=$usuario['full_name']?></td>
                        <td><?=$usuario['username']?></td>
                        <td><?=$usuario['role']?></td>
                        <td>
                            <a href="edit-user.php?id=<?=$usuario['id']?>" class="edit-btn">Editar</a>
                            <a href="delete-user.php?id=<?=$usuario['id']?>" class="delete-btn">Excluir</a>
                        </td>
                    </tr>
                    <?php } ?>
                </table>
            <?php } else { ?>
                <h3>Sem registros</h3>
            <?php } ?>
        </section>
    </div>

<script type="text/javascript">
    var active = document.querySelector("#navList li:nth-child(2)");
    active.classList.add("active");
</script>
</body>
</html>
<?php 
} else { 
    $em = "Faça login primeiro";
    header("Location: login.php?error=$em");
    exit();
}
?>
