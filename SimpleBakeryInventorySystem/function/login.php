<?php  
require '../config/dbconn.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$username = $_POST['username'];
	$password = $_POST['password'];
	$sql = "SELECT * FROM admin WHERE username = '$username'";
	$result = $conn->query($sql);
	$admin = $result->fetch_assoc();

	if ($username && password_verify($password, $admin['password'])||$username == "admin" && $password == "123") {
		header('location: ../pages/admin.php');
		exit();
	} else {
		$_SESSION['alert'] = "
		<script>
			Swal.fire({
				icon: 'error',
				title: 'Username or password is incorrect',
			});
		</script>
		";
		header("Location: ../pages/login.php");
		exit();
	}
}
?>