<pre>
<?php
//
	// получить данные с портала только по витебску
$json = file_get_contents('http://portal.topgas.by/classifier/get_data');
$arr = json_decode($json, true);
//print_r(count($arr));
//echo "<br>";

$f = fopen("import_consumers.log", "a");
fwrite($f, "\n\n".date('d-m-Y H:i:s').'');

$mysqli = new mysqli('localhost','root','amihuh15', "gasb");
if ($mysqli->connect_errno) {
	echo "Не удалось подключиться к MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	fwrite($f, "\n"."Не удалось подключиться к MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
	fclose($f);
	return;
}

$mysqli->set_charset('utf8');
//echo $mysqli->character_set_name();
$c = 0;     //  новых строк
$ca = 0;    //  всего строк
$ir = 0;    //  вставлено строк
$ur = 0;    //  обновлено строк
$err_arr = array(); // ошибки

	// выбрать существующих потребителей в массив
//$idCons = array();
//$res = $mysqli->query("SELECT codeConsumer FROM consumer");
//while( $tmp=$res->fetch_array(MYSQLI_NUM)) {
//	$idCons[] = $tmp[0];
//}

//var_dump(array_search(334, $idCons));
//print_r($idCons);

//return;

foreach ($arr as $id => $row) {

		//  проверка на пустые значения
	foreach ($row as $key => $r) {
		if ($r==NULL) {
//			var_dump($r);
			$row[$key] = "NULL";
		}
//		echo "<br>$key=>#{$row[$key]}#";
	}

//	print_r($id);
//	echo "<br>";
//	print_r($row);
	$ca++;

//	echo $id.")";
		// проверяем, есть ли уже такой потребитель в базе
	$count = $mysqli->query("SELECT count(idConsumer) as c FROM consumer WHERE codeConsumer=".$row['codeConsumer'])->fetch_assoc();

	if ( $count['c'] == 0) {
//	if (!array_search($row['codeConsumer'], $idCons)) {
//		echo " - new - ".++$c;
		$c++;
			// создаём объект
		$resi = $mysqli->query("call createObj('consumer')");
		$last_id = $resi->fetch_assoc()['id_obj'];
//		print_r($last_id);
		while($mysqli->next_result()) $mysqli->store_result();
			// добавляем потребителя
		$sql_i = "INSERT INTO consumer (
                            `id_obj`, `idConsumer`, `idOwnership`, `idSubjHoz`, `idArea`, `idMinRB`, `idTap`, `idIndustry`, `nameConsumer`, `address`, `note`, `gasified`, `lastUpdate`,
                            `dateClose`, `str1`, `str2`, `str3`, `str4`, `nrt`, `vxr`, `edr`, `tex`, `passport`, `largeUser`, `codeConsumer`, `idTown`, `combyt`, `privileged`, `budgetary`,
                            `ownNeeds`, `isKolhoz`
                        ) VALUES (".$last_id.","
                        .$row['idConsumer'].","
                        .$row['idOwnership'].","
                        .$row['idSubjHoz'].","
                        .$row['idArea'].","
                        .$row['idMinRB'].","
                        .$row['idTap'].","
                        .$row['idIndustry'].","
                        ."'".$row['nameConsumer']."',"
						."'".($row['address']=='NULL'?NULL:$row['address'])."',"
						."'".($row['note']=='NULL'?NULL:$row['note'])."',"
                        .$row['gasified'].","
                        .$row['lastUpdate'].","
                        .$row['dateClose'].","
                        .$row['str1'].","
                        .$row['str2'].","
                        .$row['str3'].","
                        .$row['str4'].","
						."'".($row['nrt']=='NULL'?NULL:$row['nrt'])."',"
                        .$row['vxr'].","
						."'".($row['edr']=='NULL'?NULL:$row['edr'])."',"
                        .$row['tex'].","
                        .$row['passport'].","
                        .$row['largeUser'].","
                        .$row['codeConsumer'].","
                        .$row['idTown'].","
                        .$row['combyt'].","
                        .$row['privileged'].","
                        .$row['budgetary'].","
                        .$row['ownNeeds'].","
                        .$row['isKolhoz'].")";
//		echo " - ".$mysqli->affected_rows." - ";
//		echo "#### - $sql_i - ####";
		$mysqli->query($sql_i);
//		echo '##-'.$mysqli->error.'-##';

		if ($mysqli->affected_rows) {
			$ir++;
		}

//		echo '##-'.$mysqli->error.'-##';
		if ($mysqli->error) {
			$err_arr['i'][$id.','.$row['codeConsumer']] = $mysqli->error;
		}
	} else {
//		echo " - exist";
			// обновляем существующего потребителя
		$sql_u = "UPDATE consumer SET
                       idConsumer=".$row['idConsumer'].",
                       idOwnership = ".$row['idOwnership'].",
                       idSubjHoz = ".$row['idSubjHoz'].",
                       idArea = ".$row['idArea'].",
                       idMinRB = ".$row['idMinRB'].",
                       idTap = ".$row['idTap'].",
                       idIndustry = ".$row['idIndustry'].",
                       nameConsumer = '".$row['nameConsumer']."',
                       address = '".($row['address']=='NULL'?NULL:$row['address'])."',
                       note = '".($row['note']=='NULL'?NULL:$row['note'])."',
                       gasified = ".$row['gasified'].",
                       lastUpdate = ".$row['lastUpdate'].",
                       dateClose = ".$row['dateClose'].",
                       str1 = ".$row['str1'].",
                       str2 = ".$row['str2'].",
                       str3 = ".$row['str3'].",
                       str4 = ".$row['str4'].",
                       nrt = '".($row['nrt']=='NULL'?NULL:$row['nrt'])."',
                       vxr = ".$row['vxr'].",
                       edr = '".($row['edr']=='NULL'?NULL:$row['edr'])."',
                       tex = ".$row['tex'].",
                       passport = ".$row['passport'].",
                       largeUser = ".$row['largeUser'].",
                       idTown = ".$row['idTown'].",
                       combyt = ".$row['combyt'].",
                       privileged = ".$row['privileged'].",
                       budgetary = ".$row['budgetary'].",
                       ownNeeds = ".$row['ownNeeds'].",
                       isKolhoz = ".$row['isKolhoz']." WHERE codeConsumer=".$row["codeConsumer"]."
            ";
		$mysqli->query($sql_u);

//		echo " - ".$mysqli->affected_rows." - ";
		if ($mysqli->affected_rows) {
			$ur++;
		}

//		echo '##-'.$mysqli->error.'-##';
		if ($mysqli->error) {
			$err_arr['u'][$id.','.$row['codeConsumer']] = $mysqli->error;
		}
	}

}
$mysqli->close();

//$f = fopen("import_consumers.log", "a");


fwrite($f, "\nПолучено строк : ".$ca);
fwrite($f, "\nНовых строк    : ".$c);
if ($c) {
	fwrite($f, "\nДобавлено строк: " . $ir);
}
fwrite($f, "\nОбновлено строк: " . $ur);

if (count($err_arr)) {
	fwrite($f, "\nОшибки: ");
	fwrite($f, print_r($err_arr, true));
}
fwrite($f, "\n".date('d-m-Y H:i:s').'-------------------------------------');

fclose($f);

echo "\n\nПолучено строк: ".$ca;
echo "\nНовых строк    : ".$c;
if ($c) {
	echo "\nДобавлено строк: " . $ir;
}
echo "\nОбновлено строк: ".$ur;
if (count($err_arr)) {
	echo "\nОшибки:";
	print_r($err_arr);
}
?>
