<?php
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id'])) {


    if (isset($_POST['title']) && isset($_POST['description']) && isset($_POST['due_date'])) {
        include "../DB_connection.php";

        function validar_dado($dado)
        {
            $dado = trim($dado);
            $dado = stripslashes($dado);
            $dado = htmlspecialchars($dado);
            return $dado;
        }

        $titulo = validar_dado($_POST['title']);
        $descricao = validar_dado($_POST['description']);
        $prazo = validar_dado($_POST['due_date']);

        if ($_SESSION['role'] === 'admin') {

            if (!isset($_POST['assigned_to'])) {
                $erro = "Selecione um aluno";
                header("Location: ../create_task.php?error=$erro");
                exit();
            }
            $atribuido_para = validar_dado($_POST['assigned_to']);
            if ($atribuido_para == 0) {
                $erro = "Selecione um aluno válido";
                header("Location: ../create_task.php?error=$erro");
                exit();
            }
        } else {

            $atribuido_para = $_SESSION['id'];
        }


        if (empty($titulo)) {
            $erro = "O título é obrigatório";
            header("Location: ../create_task.php?error=$erro");
            exit();
        } else if (empty($descricao)) {
            $erro = "A descrição é obrigatória";
            header("Location: ../create_task.php?error=$erro");
            exit();
        }
        $points = validar_dado($_POST['points']);
        if (!is_numeric($points) || $points < 0) {
            $points = 0;
        }



        include "Model/Task.php";
        include "Model/Notification.php";

        $dados_tarefa = array($titulo, $descricao, $atribuido_para, $prazo, $points);

        insert_task($conn, $dados_tarefa);

        $mensagem_notificacao = "'$titulo' foi atribuída a você. Por favor, revise e inicie o trabalho";
        $dados_notificacao = array($mensagem_notificacao, $atribuido_para, 'Nova Tarefa Atribuída');
        insert_notification($conn, $dados_notificacao);

        $sucesso = "Tarefa criada com sucesso";
        header("Location: ../create_task.php?success=$sucesso");
        exit();
    } else {
        $erro = "Ocorreu um erro desconhecido";
        header("Location: ../create_task.php?error=$erro");
        exit();
    }
} else {
    $erro = "Faça login primeiro";
    header("Location: ../create_task.php?error=$erro");
    exit();
}
