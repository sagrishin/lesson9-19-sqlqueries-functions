<!DOCTYPE html>
<html>
	<head>
		<title>Queries to DataBase</title>
		<meta http-equiv="content-type" content="text/html" charset="utf-8" />
	</head>
	<body>
		<?
		
			function setResultToArray($result) {
				$array = [];
				while ($row = $result->fetch_assoc())
					$array[] = $row;
				return $array;
			}
		
			/* Подробнее про MySQLi: http://php.net/manual/ru/book.mysqli.php */
			$mysqli = new MySQLi('localhost', 'root', '', 'lessons');
			$mysqli->set_charset('UTF8');
		
			/* Insert */
			// echo 'Insert Query', "<br />";
			// $result = $mysqli->query("INSERT INTO `articles` (`title`, `link`, `catID`) VALUES ('Статья 13', '/article/13', '3')");
			// if ($result)
				// echo 'Вставлена новая сторка со значениями: title = "Статья 13", link = "/article/13", catID = 3', "<br />";
		
			/* Select */
			// echo 'Select Query', "<br />";
			// $result = setResultToArray($mysqli->query("SELECT * FROM `articles`"));
			// print_r($result);
			// echo "<br />";
			
			/* Update */
			echo 'Update Query', "<br />";
			$result = $mysqli->query("UPDATE `articles` SET `title` = 'Измененная статья 2' WHERE `id` = '14'");
			if ($result)
				echo 'Запись с id = 14 обновлена', "<br />";
			echo 'Поверка Update-запроса:', "<br />";
			$result = setResultToArray($mysqli->query("SELECT * FROM `articles` WHERE `id` = '14'"));
			print_r($result);
			echo "<br />";
			
			/* Delete */
			// echo 'Delete Query', "<br />";
			// $result = $mysqli->query("DELETE FROM `articles` WHERE `id` = '8'");
			// if ($result)
				// echo 'Запись с id = 8 удалена', "<br />";
			// echo 'Поверка Delete-запроса:', "<br />";
			// $result = setResultToArray($mysqli->query("SELECT * FROM `articles` WHERE `id` > '7' AND `id` < '10'"));
			// print_r($result);
			
			$mysqli->close();
		
		?>
	</body>
</html>