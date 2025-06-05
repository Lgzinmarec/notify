<?php

function insert_task($conn, $data)
{
	$sql = "INSERT INTO tasks (title, description, assigned_to, due_date, points) VALUES(?,?,?,?,?)";
	$stmt = $conn->prepare($sql);
	$stmt->execute($data);
}


function get_all_tasks($conn)
{
	$sql = "SELECT * FROM tasks ORDER BY id DESC";
	$stmt = $conn->prepare($sql);
	$stmt->execute([]);

	if ($stmt->rowCount() > 0) {
		$tasks = $stmt->fetchAll();
	} else $tasks = 0;

	return $tasks;
}
function get_all_tasks_due_today($conn)
{
	$sql = "SELECT * FROM tasks WHERE due_date = CURDATE() AND status != 'completed' ORDER BY id DESC";
	$stmt = $conn->prepare($sql);
	$stmt->execute([]);

	if ($stmt->rowCount() > 0) {
		$tasks = $stmt->fetchAll();
	} else $tasks = 0;

	return $tasks;
}
function count_tasks_due_today($conn)
{
	$sql = "SELECT id FROM tasks WHERE due_date = CURDATE() AND status != 'completed'";
	$stmt = $conn->prepare($sql);
	$stmt->execute([]);

	return $stmt->rowCount();
}

function get_all_tasks_overdue($conn)
{
	$sql = "SELECT * FROM tasks WHERE due_date < CURDATE() AND status != 'completed' ORDER BY id DESC";
	$stmt = $conn->prepare($sql);
	$stmt->execute([]);

	if ($stmt->rowCount() > 0) {
		$tasks = $stmt->fetchAll();
	} else $tasks = 0;

	return $tasks;
}
function count_tasks_overdue($conn)
{
	$sql = "SELECT id FROM tasks WHERE due_date < CURDATE() AND status != 'completed'";
	$stmt = $conn->prepare($sql);
	$stmt->execute([]);

	return $stmt->rowCount();
}


function get_all_tasks_NoDeadline($conn)
{
	$sql = "SELECT * FROM tasks WHERE status != 'completed' AND due_date IS NULL OR due_date = '0000-00-00' ORDER BY id DESC";
	$stmt = $conn->prepare($sql);
	$stmt->execute([]);

	if ($stmt->rowCount() > 0) {
		$tasks = $stmt->fetchAll();
	} else $tasks = 0;

	return $tasks;
}
function count_tasks_NoDeadline($conn)
{
	$sql = "SELECT id FROM tasks WHERE status != 'completed' AND due_date IS NULL OR due_date = '0000-00-00'";
	$stmt = $conn->prepare($sql);
	$stmt->execute([]);

	return $stmt->rowCount();
}



function delete_task($conn, $data)
{
	$sql = "DELETE FROM tasks WHERE id=? ";
	$stmt = $conn->prepare($sql);
	$stmt->execute($data);
}


function get_task_by_id($conn, $id)
{
	$sql = "SELECT * FROM tasks WHERE id =? ";
	$stmt = $conn->prepare($sql);
	$stmt->execute([$id]);

	if ($stmt->rowCount() > 0) {
		$task = $stmt->fetch();
	} else $task = 0;

	return $task;
}
function count_tasks($conn)
{
	$sql = "SELECT id FROM tasks";
	$stmt = $conn->prepare($sql);
	$stmt->execute([]);

	return $stmt->rowCount();
}

function update_task($conn, $dados)
{
	// $dados = [title, description, assigned_to, due_date, points, id]
	$sql = "UPDATE tasks SET title = ?, description = ?, assigned_to = ?, due_date = ?, points = ? WHERE id = ?";
	$stmt = $conn->prepare($sql);
	return $stmt->execute($dados);
}



function update_task_status($conn, $data)
{
	$sql = "UPDATE tasks SET status=? WHERE id=?";
	$stmt = $conn->prepare($sql);
	$stmt->execute($data);
}


function get_all_tasks_by_id($conn, $id)
{
	$sql = "SELECT * FROM tasks WHERE assigned_to=?";
	$stmt = $conn->prepare($sql);
	$stmt->execute([$id]);

	if ($stmt->rowCount() > 0) {
		$tasks = $stmt->fetchAll();
	} else $tasks = 0;

	return $tasks;
}



function count_pending_tasks($conn)
{
	$sql = "SELECT id FROM tasks WHERE status = 'pending'";
	$stmt = $conn->prepare($sql);
	$stmt->execute([]);

	return $stmt->rowCount();
}

function count_in_progress_tasks($conn)
{
	$sql = "SELECT id FROM tasks WHERE status = 'in_progress'";
	$stmt = $conn->prepare($sql);
	$stmt->execute([]);

	return $stmt->rowCount();
}

function count_completed_tasks($conn)
{
	$sql = "SELECT id FROM tasks WHERE status = 'completed'";
	$stmt = $conn->prepare($sql);
	$stmt->execute([]);

	return $stmt->rowCount();
}


function count_my_tasks($conn, $id)
{
	$sql = "SELECT id FROM tasks WHERE assigned_to=?";
	$stmt = $conn->prepare($sql);
	$stmt->execute([$id]);

	return $stmt->rowCount();
}

function count_my_tasks_overdue($conn, $id)
{
	$sql = "SELECT id FROM tasks WHERE due_date < CURDATE() AND status != 'completed' AND assigned_to=? AND due_date != '0000-00-00'";
	$stmt = $conn->prepare($sql);
	$stmt->execute([$id]);

	return $stmt->rowCount();
}

function count_my_tasks_NoDeadline($conn, $id)
{
	$sql = "SELECT id FROM tasks WHERE assigned_to=? AND status != 'completed' AND due_date IS NULL OR due_date = '0000-00-00'";
	$stmt = $conn->prepare($sql);
	$stmt->execute([$id]);

	return $stmt->rowCount();
}

function count_my_pending_tasks($conn, $id)
{
	$sql = "SELECT id FROM tasks WHERE status = 'pending' AND assigned_to=?";
	$stmt = $conn->prepare($sql);
	$stmt->execute([$id]);

	return $stmt->rowCount();
}

function count_my_in_progress_tasks($conn, $id)
{
	$sql = "SELECT id FROM tasks WHERE status = 'in_progress' AND assigned_to=?";
	$stmt = $conn->prepare($sql);
	$stmt->execute([$id]);

	return $stmt->rowCount();
}

function count_my_completed_tasks($conn, $id)
{
	$sql = "SELECT id FROM tasks WHERE status = 'completed' AND assigned_to=?";
	$stmt = $conn->prepare($sql);
	$stmt->execute([$id]);

	return $stmt->rowCount();
}
function sum_completed_points_by_user($conn, $user_id)
{
	$sql = "SELECT SUM(points) AS total FROM tasks WHERE assigned_to = ? AND status = 'completed'";
	$stmt = $conn->prepare($sql);
	$stmt->execute([$user_id]);
	$row = $stmt->fetch();
	return $row['total'] ?? 0;
}

function average_points_by_user($conn, $user_id)
{
	$sql = "SELECT AVG(points) AS average FROM tasks WHERE assigned_to = ? AND status = 'completed'";
	$stmt = $conn->prepare($sql);
	$stmt->execute([$user_id]);
	$row = $stmt->fetch();
	return round($row['average'], 2) ?? 0;
}
function get_completed_tasks_by_user($conn, $id)
{
	$sql = "SELECT * FROM tasks WHERE assigned_to=? AND status='completed'";
	$stmt = $conn->prepare($sql);
	$stmt->execute([$id]);

	if ($stmt->rowCount() > 0) {
		return $stmt->fetchAll();
	}
	return 0;
}
function get_completed_tasks_by_user_in_date_range($conn, $user_id, $start_date, $end_date)
{
	$sql = "SELECT * FROM tasks 
            WHERE assigned_to = ? 
              AND status = 'completed' 
              AND updated_at BETWEEN ? AND ?";
	$stmt = $conn->prepare($sql);
	$stmt->execute([$user_id, $start_date . ' 00:00:00', $end_date . ' 23:59:59']);

	if ($stmt->rowCount() > 0) {
		return $stmt->fetchAll();
	}
	return 0;
}
function get_all_tasks_with_points_by_user($conn, $user_id)
{
	$sql = "SELECT points, status FROM tasks WHERE assigned_to = ?";
	$stmt = $conn->prepare($sql);
	$stmt->execute([$user_id]);

	return $stmt->rowCount() > 0 ? $stmt->fetchAll() : 0;
}

function get_incomplete_tasks_by_user($conn, $user_id)
{
	$sql = "SELECT points, title FROM tasks WHERE assigned_to = ? AND status != 'completed'";
	$stmt = $conn->prepare($sql);
	$stmt->execute([$user_id]);
	if ($stmt->rowCount() > 0) {
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	} else {
		return 0;
	}
}


function get_incomplete_tasks_by_user_in_date_range($conn, $user_id, $inicio, $fim)
{
	$sql = "SELECT points, title FROM tasks WHERE assigned_to = ? AND status != 'completed' AND due_date BETWEEN ? AND ?";
	$stmt = $conn->prepare($sql);
	$stmt->execute([$user_id, $inicio, $fim]);
	if ($stmt->rowCount() > 0) {
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	} else {
		return 0;
	}
}
function get_tasks_assigned_to_user($conn, $userId)
{
	$sql = "SELECT id, title, points, status FROM tasks WHERE assigned_to = :userId";
	$stmt = $conn->prepare($sql);
	$stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
	$stmt->execute();
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

	if ($result) {
		return $result;
	}
	return 0;
}


function get_total_points_completed_by_user($conn, $userId)
{
	$sql = "SELECT SUM(points) as total FROM tasks WHERE assigned_to = :userId AND status = 'completed'";
	$stmt = $conn->prepare($sql);
	$stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
	$stmt->execute();
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	return $row['total'] ?? 0;
}
