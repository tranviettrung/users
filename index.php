<!DOCTYPE html>
<html>
<head>
	<title>Form</title>
	<style type="text/css">
		table {
			margin-top: 20px;
			border-collapse: collapse;
		}
	</style>
</head>
<body>
	<?php
		$name = isset($_GET['name']) ? $_GET['name'] : '';

		$servername = '127.0.0.1';
		$username = 'root';
		$password = '';
		$dbname = 'hoc_php';

		try {
			$con = new PDO("mysql:host={$servername};dbname={$dbname}", $username, $password);
			$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			// echo "Kết nối thành công";

			$sql = "SELECT * FROM users";

			$stmt = $con->prepare($sql);
			$stmt->execute();

			$stmt->setFetchMode(PDO::FETCH_ASSOC);

			$results = $stmt->fetchAll();

			$con = null;
		}
		catch (PDOException $ex) {
			echo $ex->getMessage();
		}
	?>

	<form method="GET" action="index .php">
		<input type="text" name="name" placeholder="Tên của bạn" value="<?= $name ?>" />
		<button type="submit" name="submit" value="submit">Tìm kiếm</button>
	</form>

	<a href="create-user.php">Tạo người dùng</a>

	<table border="1">
		<thead>
			<tr>
				<th>Tên</td>
				<th>Giới tính</th>
				<th>Email</th>
				<th>Ngày sinh</th>
				<th>Địa chỉ</th>
				<th>Hành động</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($results as $user): ?>
				
			<tr>
				<td><?php echo $user['name'] ?></td>
				<td>
					<?php 
						if($user['gender'] == 1) 
							echo 'Nam';
						else 
							echo 'Nữ';
					?>
				</td>
				<td><?= $user['email'] ?></td>
				<td><?= $user['birthday'] ?></td>
				<td><?= $user['address'] ?></td>
				<td>
					<a href="edit-user.php?id=<?= $user['id'] ?>">Sửa</a>
				</td>
			</tr>

			<?php endforeach; ?>
		</tbody>

	</table>

</body>
</html>