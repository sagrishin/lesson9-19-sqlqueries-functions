<?php

	/**
	 *
	 * создает новое подключение к базе данных
	 * тип результата функции: mysqli_connect
	 *
	 */
	function mysqli() {
		$mysqli = new mysqli("localhost", "root", "", "testing");
		$mysqli->query("SET NAMES 'UTF8'");
		$mysqli->query("SET lc_time_names = 'uk_UA'");
		return $mysqli;
	}
	/**
	 *
	 * добавляет нового абонента
	 * тип результата функции: int:
	 *                              если добавление успешно -- 1,
	 *                              если неправильное имя -- 2,
	 *                              если неправильный номер телефона -- 3,
	 *                              если такой абонент уже есть -- 4
	 * параметры:
	 * $name          Имя абонента
	 * $phoneNumber   Телефон в международном формате
	 * $date          Дата добавления (устанавливается внутри функции)
	 *
	 */
	function insertAbonent($name, $phoneNumber) {
		if (!isValidPhoneNuber($phoneNumber))
			return 3;
		if (!isValidName($name))
			return 2;
		$mysqli = mysqli();
		$res = $mysqli->query("INSERT INTO `phones` (`name`, `phone`) VALUES ('$name', '$phoneNumber')");
		$mysqli->close();
		return ($res) ? 1 : 4;
	}
	/**
	 *
	 * выбирает все данные об абоненте из БД у которого поле name == $name и
	 * phone_number == $phoneNumber.
	 * тип реузультата -- массив
	 * параметры:
	 * $name          Имя абонента
	 * $phoneNumber   Телефон в международном формате
	 *
	 */
	function selectAbonent($name, $phoneNumber) {
		if (!isValidPhoneNuber($phoneNumber) || !isValidName($name))
			return array();
		$mysqli = mysqli();
		$res = $mysqli->query("SELECT * FROM `phones` WHERE `name` = '$name' AND `phone` = '$phoneNumber'");
		$mysqli->close();
		return $res->fetch_assoc();
	}
	/**
	 *
	 * возвращает массив с несколькими абонентами сети. Результат -- массив
	 *
	 * параметры:
	 * Все параметры данной функции не обязательны.
	 * $where        массив с 1 полем "ключ-значение". Ключ -- название поля, значение -- значение в этом поле.
	 *                       В данном массиве содержатся данные для выборки по условию.
	 * $sortField    Необязательный параметр. Содержит поле, по которому ведется сортировка.
	 * $order        Если передан $sortField, то, может быть передан и $order, направление сортировки:
	 *                       прямая\инверсная (1\2).
	 *
	 */
	function selectAbonents($where = array(), $sortField = '', $order = 0) {
		if ($sortField == '' && $order != false)
			return false;
		$whereStr = '';
		if (($count = count($where)) !== 0) {
			foreach ($where as $key => $value)
				$whereStr .= "`$key` = '$value'";
			$whereStr = "WHERE " . $whereStr;
		}
		$orderStr = '';	
		if ($sortField != '') {
			$orderStr = "ORDER by `$sortField`";
			if ($order == 1) {
				$orderStr = " ASC";
			}
			elseif ($order == 2) {
				$orderStr = " DESC";
			}
		}
		$mysqli = mysqli();
		$res = $mysqli->query("SELECT * FROM `abonents` $whereStr $orderStr");
		$mysqli->close();
		return $res;
	}
	/**
	 *
	 * Возвращает массив из выборки из базы данных
	 * параметры:
	 * mysqli_result $mysqlResult     ресурс базы данных, который переводится в массив.
	 *
	 */
	function setResultToArray($mysqlResult) {
		$array = array();
		while ($row = $mysqlResult->fetch_assoc())
			$array[] = $row;
		return $array;
	}
	/**
	 *
	 * обновляет данные об абоненте. Возвращает true -- если обновление успешно и false -- если нет.
	 * параметры:
	 * $name           Имя абонента
	 * $phoneNumber    Телефон в международном формате
	 * $data           Массив пар "ключ-значение": ключ -- поле в таблице,
	 *                                             значение -- новое значение для поля
	 *
	 */
	function updateAbonent($name, $phoneNumber, $data) {
		if (!isValidPhoneNuber($phoneNumber) || !isValidName($name) || !is_array($data) || empty($data))
			return false;
		$update = "";
		foreach ($data as $key => $value)
			$update .= "`$key` = '$value', ";
		$update = substr($update, 0, -2);
		$mysqli = mysqli();
		$res = $mysqli->query("UPDATE `phones` SET $update WHERE `name` = '$name' AND `phone` = '$phoneNumber'");
		$mysqli->close();
		return $res;
	}
	/**
	 *
	 * удаляет абонента из БД. Возвращает true -- если удаление успешно и false -- если нет.
	 * параметры:
	 * $name          Имя абонента
	 * $phoneNumber   Телефон в международном формате
	 *
	 */
	function deleteAbonent($name, $phoneNumber) {
		if (!isValidPhoneNuber($phoneNumber) || !isValidName($name))
			return false;
		$mysqli = mysqli();
		$res = $mysqli->query("DELETE FROM `phones` WHERE `name` = '$name' AND `phone` = '$phoneNumber'");
		$mysqli->close();
		return $res;
	}
	/**
	 *
	 * Предикат. Возвращает true -- если имя задано правильно и false -- если нет.
	 * параметры:
	 * $name          Имя абонента
	 *
	 */
	function isValidName($name) {
		return preg_match("/[а-яА-Я]{3,10}/", $name);
	}
	/**
	 *
	 * Предикат. Возвращает true -- если номер задан правильно и false -- если нет.
	 * параметры:
	 * $phoneNumber   Телефон в международном формате
	 *
	 */
	function isValidPhoneNuber($phoneNumber) {
		return preg_match("/^(\+380)\d{2}[-]?\d{3}[-]?\d{4}/", $phoneNumber);
	}

?>