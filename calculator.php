<?php
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id']) && $_SESSION['role'] == 'user') {
    require_once "app/Controller/CalculatorController.php";
  $data = calculator_controller();

    $completed_tasks = $data['completed'] ?? [];
    $incomplete_tasks = $data['incomplete'] ?? [];
    $total_pontos = $data['total_pontos'] ?? 0;
    $quantidade_tarefas = $data['qtd'] ?? 0;
    $media = $data['media'] ?? 0;
    $total_pontos_perdidos = $data['perdidos'] ?? 0;
    $inicio = $data['inicio'] ?? '';
    $fim = $data['fim'] ?? '';

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
                    <label>De: <input type="date" name="inicio" value="<?= htmlspecialchars($inicio) ?>"></label>
                    <label>Até: <input type="date" name="fim" value="<?= htmlspecialchars($fim) ?>"></label>
                    <button type="submit">Filtrar</button>
                </form>

                <?php if (!empty($completed_tasks)) { ?>
                    <table class="main-table">
                        <tr>
                            <th>#</th>
                            <th>Título</th>
                            <th>Pontos</th>
                        </tr>
                        <?php foreach ($completed_tasks as $index => $task) { ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
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
                    <?php if (!empty($incomplete_tasks)) { ?>
                        <p><strong>Total de Pontos Perdidos:</strong> <?= $total_pontos_perdidos ?> pontos</p>
                    <?php } ?>
                <?php } ?>
            </section>
        </div>

        <script>
            var active = document.querySelector("#navList li:nth-child(6)");
            if (active) active.classList.add("active");
        </script>
    </body>

    </html>

<?php
} else {
    $em = "Acesso negado ou sessão expirada";
    header("Location: login.php?error=" . urlencode($em));
    exit();
}
?>