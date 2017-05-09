<!DOCTYPE html>
<html>
<head>
	<title>Sửa người dùng</title>
	<style type="text/css">
		input, textarea, button, label {
			margin-top: 15px;
			display: inline-block;
		}
	</style>
</head>
<body>
	<?php
		$servername = 'localhost';
		$username = 'root';
		$password = '';
		$dbname = 'hoc_php';

		$id_user = $_GET['id'];

		try {
			
			$con = new PDO("mysql:host={$servername};dbname={$dbname}", $username, $password);
			$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			// Cap nhat thong tin nguoi dung khi nhan nut Sua nguoi dung
			if(isset($_POST['submit'])){
				// print_r($_POST);

				$str_query = '';

				foreach ($_POST as $key => $value) {
					// neu khoa la submit thi bo qua
					if($key == 'submit')
						continue;
					// new khoa la interesting thi can phai ghep mang
					if($key == 'interesting') {
						$value = implode(',', $value);
					}

					$str_query .= $key . "='" . $value . "', ";
				}

				$sql = "UPDATE users SET $str_query";
				$sql = substr($sql, 0, strlen($sql) - 2);
				$sql = $sql . " WHERE id = {$id_user}";
				// die($sql);
				$con->exec($sql);

				echo "<p><b>Cập nhật người dùng $name thành công</b></p>";
			}


			$sql = "SELECT * FROM users WHERE id = $id_user";
			
			$stmt = $con->prepare($sql);
			$stmt->execute();

			// Lay 1 ban ghi
			$user = $stmt->fetch();

			$con = null;
		}
		catch (PDOException $ex) {
			echo $ex->getMessage();
		}
	?>
	<h3>Thêm người dùng</h1>
	<form method="POST" action="<?= $_SERVER['REQUEST_URI'] ?>">
		<input type="text" name="name" placeholder="Tên của bạn" required="required" value="<?= $user['name'] ?>" /><br/>
		
		<input type="email" name="email" placeholder="Email" required="required" value="<?= $user['email'] ?>" /><br/>
		<input type="date" name="birthday" required="required" value="<?= $user['birthday'] ?>"/><br/>
		<textarea name="address" placeholder="Địa chỉ"><?= $user['address'] ?></textarea><br/>
		<label>Giới tính</label><br/>
		<input type="radio" name="gender" value="1" 
		<?php
			if($user['gender'] == 1) {
				echo "checked";
			}

		?>
		 />Nam
		<input type="radio" name="gender" value="0" <?= $user['gender'] == 0 ? 'checked' : '' ?> />Nữ<br/>
		<label>Sở thích</label> <br/>
		<input type="checkbox" name="interesting[]" value="Thể thao" 
		<?php
			if( strpos($user['interesting'],"Thể thao") !== false ) {
				echo "checked";
			}
		?> /> Thể thao

		<input type="checkbox" name="interesting[]" value="Ăn uống" 
		<?php
			if( strpos($user['interesting'],"Ăn uống") !== false ) {
				echo "checked";
			}
		?>
		/> Ăn uống
		<input type="checkbox" name="interesting[]" value="Du lịch"
		<?php
			if( strpos($user['interesting'],"Du lịch") !== false ) {
				echo "checked";
			}
		?>
		/> Du lịch <br/>

		<button type="submit" name="submit" value="submit">Sửa người dùng</button>
	</form>

	<a href="index.php">Quay trở lại</a>

</body>
</html>