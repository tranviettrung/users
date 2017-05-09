<!DOCTYPE html>
<html>
<head>
	<title>Thêm người dùng</title>
	<style type="text/css">
		input, textarea, button, label {
			margin-top: 15px;
			display: inline-block;
		}
	</style>
</head>
<body>
	<?php
		
		
		// Chỉ xu lý khi người dùng nhấn nút submit
		if(isset($_POST['submit'])) {

			$servername = 'localhost';
			$username = 'root';
			$password = '';
			$dbname = 'hoc_php';
	
			try {
				$con = new PDO("mysql:host={$servername};dbname={$dbname}", $username, $password);
				$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

				extract($_POST);

				$interesting = implode(',', $interesting);

				$sql = "INSERT INTO users(name, email, birthday, gender, address, interesting) VALUES('$name', '$email', '$birthday', $gender, '$address', '$interesting')";

				$con->exec($sql);

				echo "<p><b>Thêm người dùng $name thành công</b></p>";
	
				$con = null;
			}
			catch (PDOException $ex) {
				echo $ex->getMessage();
			}

		}
	?>
	<h3>Thêm người dùng</h1>
	<form method="POST" action="create-user.php">
		<input type="text" name="name" placeholder="Tên của bạn" required="required" /><br/>
		
		<input type="email" name="email" placeholder="Email" required="required" /><br/>
		<input type="date" name="birthday" required="required" /><br/>
		<textarea name="address" placeholder="Địa chỉ"></textarea><br/>
		<label>Giới tính</label><br/>
		<input type="radio" name="gender" value="1">Nam
		<input type="radio" name="gender" value="0">Nữ<br/>
		<label>Sở thích</label> <br/>
		<input type="checkbox" name="interesting[]" value="Thể thao" /> Thể thao
		<input type="checkbox" name="interesting[]" value="Ăn uống" /> Ăn uống
		<input type="checkbox" name="interesting[]" value="Du lịch" /> Du lịch <br/>

		<button type="submit" name="submit" value="submit">Thêm người dùng</button>
	</form>

	<a href="index.php">Quay trở lại</a>
	
	

</body>
</html>