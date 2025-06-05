<nav class="side-bar">
    <div class="user-p">
        <img src="img/user.jpg">
        <h4>@<?= $_SESSION['username'] ?></h4>
    </div>

    <?php
    if ($_SESSION['role'] == "employee") {
    ?>
        <!-- Estudante -->
        <ul id="navList">
            <li>
                <a href="index.php">
                    <i class="fa fa-tachometer" aria-hidden="true"></i>
                    <span>Painel</span>
                </a>
            </li>
            <li>
                <a href="my_task.php">
                    <i class="fa fa-tasks" aria-hidden="true"></i>
                    <span>Minhas Tarefas</span>
                </a>
            </li>
            <li>
                <a href="create_task.php">
                    <i class="fa fa-plus" aria-hidden="true"></i>
                    <span>Criar Tarefa</span>
                </a>
            </li>
            <li>
                <a href="profile.php">
                    <i class="fa fa-user" aria-hidden="true"></i>
                    <span>Perfil</span>
                </a>
            </li>
            <li>
                <a href="notifications.php">
                    <i class="fa fa-bell" aria-hidden="true"></i>
                    <span>Notificações</span>
                </a>
            </li>
            <li>
                <a href="calculator.php">
                    <i class="fa fa-calculator" aria-hidden="true"></i>
                    <span>Calculadora</span>
                </a>
            </li>

            <li>
                <a href="logout.php">
                    <i class="fa fa-sign-out" aria-hidden="true"></i>
                    <span>Sair</span>
                </a>
            </li>
        </ul>
    <?php } else { ?>
        <!-- Admin -->
        <ul id="navList">
            <li>
                <a href="index.php">
                    <i class="fa fa-tachometer" aria-hidden="true"></i>
                    <span>Painel</span>
                </a>
            </li>
            <li>
                <a href="user.php">
                    <i class="fa fa-users" aria-hidden="true"></i>
                    <span>Gerenciar Usuários</span>
                </a>
            </li>
            <li>
                <a href="create_task.php">
                    <i class="fa fa-plus" aria-hidden="true"></i>
                    <span>Criar Tarefa</span>
                </a>
            </li>
            <li>
                <a href="tasks.php">
                    <i class="fa fa-tasks" aria-hidden="true"></i>
                    <span>Todas as Tarefas</span>
                </a>
            </li>
            <li>
                <a href="logout.php">
                    <i class="fa fa-sign-out" aria-hidden="true"></i>
                    <span>Sair</span>
                </a>
            </li>
        </ul>
    <?php } ?>
</nav>