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

		$servername = 'localhost';
		$username = 'root';
		$password = '';
		$dbname = 'hocphp';

		try {
			$con = new PDO("mysql:host={$servername};dbname={$dbname}", $username, $password);
			$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			// echo "Kết nối thành công";

			$sql = "SELECT * FROM users WHERE name like '%$name%'";

			$stmt = $con->prepare($sql);
			$stmt->execute();
			
			$stmt->setFetchMode(PDO::FETCH_ASSOC);

			$results = $stmt->fetchAll();

			// print_r($results);

			$con = null;
		}
		catch (PDOException $ex) {
			echo $ex->getMessage();
		}
	?>

	<form method="GET" action="search-user.php">
		<input type="text" name="name" placeholder="Tên của bạn" value="<?= $name ?>" />
		<button type="submit" name="submit" value="submit">Tìm kiếm</button>
	</form>

	<h1>Kết quả tìm kiếm cho: <?= $name ?></h1>

	<table border="1">
		<thead>
			<tr>
				<th>Tên</td>
				<th>Giới tính</th>
				<th>Email</th>
				<th>Ngày sinh</th>
				<th>Địa chỉ</th>

			</tr>
		</thead>
		<tbody>
			<?php foreach($results as $user) { ?>
			<tr>
				<td><?= $user['name'] ?></td>
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
			</tr>
			<?php } ?>
		</tbody>

	</table>

</body>
</html>