<!DOCTYPE html>
<html>
	<head>
		<title>HomeTask 9</title>
		<meta http-equiv="content-type" content="text/html" charset="utf-8" />
	</head>
	<body>
		<?php

			require_once('hometask9.php');


			var_dump(insertAbonent('Ирина', '+380971111111')); // success
			var_dump(insertAbonent('Ирина111', '+380972222222')); // success
			var_dump(insertAbonent('Ирина', '+380973333333')); // error
			var_dump(selectAbonent('Ирина111', '+380971111111'));
			// array(
			// 	"name" => "Ирина111",
			// 	"phone" => "+380972222222"
			// )


			var_dump(selectAbonents(array(), "name", 2));
			// array(
			// 	array(
			// 		"name" => "Ирина111",
			// 		"phone" => "+380972222222"
			// 	),
			// 	array(
			// 		"name" => "Ирина",
			// 		"phone" => "+380971111111"
			// 	)
			// )

			var_dump(updateAbonent('Ирина', '+380971111111', array(
				"name" => "Ирина123",
				"phone" => "+380973333333"
			)));
			// succeess

			var_dump(deleteAbonent('Ирина', '+3809710107')); // error
			var_dump(deleteAbonent('Ирина123', '+380973333333')); // success

		?>
	</body>
</html>