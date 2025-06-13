<?php
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id']) && $_SESSION['role'] == 'user') {
    include "DB_connection.php";
    include "app/Model/Task.php";

    $inicio = $_GET['inicio'] ?? null;
    $fim = $_GET['fim'] ?? null;


    if ($inicio && $fim) {
        $completed_tasks = get_completed_tasks_by_user_in_date_range($conn, $_SESSION['id'], $inicio, $fim);
    } else {
        $completed_tasks = get_completed_tasks_by_user($conn, $_SESSION['id']);
    }

    $total_pontos = 0;
    $quantidade_tarefas = 0;

    if ($completed_tasks != 0) {
        foreach ($completed_tasks as $task) {
            $total_pontos += $task['points'];
            $quantidade_tarefas++;
        }
        $media = $quantidade_tarefas > 0 ? round($total_pontos / $quantidade_tarefas, 2) : 0;
    } else {
        $media = 0;
    }


    if ($inicio && $fim) {
        $incomplete_tasks = get_incomplete_tasks_by_user_in_date_range($conn, $_SESSION['id'], $inicio, $fim);
    } else {
        $incomplete_tasks = get_incomplete_tasks_by_user($conn, $_SESSION['id']);
    }

    $total_pontos_perdidos = 0;
    if ($incomplete_tasks != 0) {
        foreach ($incomplete_tasks as $task) {
            $total_pontos_perdidos += $task['points'];
        }
    }
?>
    <!DOCTYPE html>
    <html>

    <head>
        <title>Calculadora de Pontos</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="css/style.css">
    </head>

    <body>
        <input type="checkbox" id="checkbox">
        <?php include "inc/header.php" ?>
        <div class="body">
            <?php include "inc/nav.php" ?>
            <section class="section-1">
                <h4 class="title">Calculadora de Pontos</h4>

                <form method="GET" style="margin-bottom: 20px;">
                    <label>De: <input type="date" name="inicio" value="<?= htmlspecialchars($_GET['inicio'] ?? '') ?>"></label>
                    <label>Até: <input type="date" name="fim" value="<?= htmlspecialchars($_GET['fim'] ?? '') ?>"></label>
                    <button type="submit">Filtrar</button>
                </form>

                <?php if ($completed_tasks != 0) { ?>
                    <table class="main-table">
                        <tr>
                            <th>#</th>
                            <th>Título</th>
                            <th>Pontos</th>
                        </tr>
                        <?php $i = 0;
                        foreach ($completed_tasks as $task) { ?>
                            <tr>
                                <td><?= ++$i ?></td>
                                <td><?= htmlspecialchars($task['title']) ?></td>
                                <td><?= $task['points'] ?? 0 ?></td>
                            </tr>
                        <?php } ?>
                    </table>

                    <div style="margin-top: 20px;">
                        <p><strong>Total de Tarefas Concluídas:</strong> <?= $quantidade_tarefas ?></p>
                        <p><strong>Total de Pontos Ganhos:</strong> <?= $total_pontos ?> pontos</p>
                        <p><strong>Total de Pontos Perdidos:</strong> <?= $total_pontos_perdidos ?> pontos</p>
                        <p><strong>Média por Tarefa Concluída:</strong> <?= $media ?> pontos</p>
                    </div>

                <?php } else { ?>
                    <h3>Você ainda não concluiu nenhuma tarefa.</h3>
                    <?php if ($incomplete_tasks != 0) { ?>
                        <p><strong>Total de Pontos Perdidos:</strong> <?= $total_pontos_perdidos ?> pontos</p>
                    <?php } ?>
                <?php } ?>
            </section>
        </div>

        <script type="text/javascript">
            var active = document.querySelector("#navList li:nth-child(6)");
            if (active) active.classList.add("active");
        </script>
    </body>

    </html>

<?php
} else {
    $em = "Acesso negado ou sessão expirada";
    header("Location: login.php?error=$em");
    exit();
}
?>