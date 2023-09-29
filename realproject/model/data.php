<?
require_once($_SERVER['DOCUMENT_ROOT'].'/model/db.php');
$GLOBALS['dbc'] = $db;
function getProfile($id)
{
	require_once($_SERVER['DOCUMENT_ROOT'].'/model/profile.php');//Подключение класса Профиль 
	$profile = new profile(); //Создаем объект класса Профиль
	$profile = $profile -> getPr($GLOBALS['dbc'], $id);//Получаем профиль из БД
	return $profile;//Возвращаем полученный профиль
}
function login($mail, $pass)
{
	require_once($_SERVER['DOCUMENT_ROOT'].'/model/profile.php');//Подключение класса Профиль 
	$profile = new profile(); //Создаем объект класса Профиль
	session_start();
	$data = $profile->logPr($GLOBALS['dbc'], $mail, $pass);
	if($data[0]>0)
	{
		$_SESSION['id'] = $data[0];			
		$_SESSION['name'] = $data[1];
		$_SESSION['role'] = $data[2];
		$_SESSION['logo'] = $data[3];
	}
	return $data[0];
}
function setProfile($post)
{
	require_once('Profile.php');//Подключение класса Профиль 
	$profile = new profile();//Создаем объект класса Профиль
	$id= $profile -> setPr($GLOBALS['dbc'], $post);//Сохраняем профиль в БД 
		$profile = $profile -> getPr($GLOBALS['dbc'], $id);//Получаем профиль из БД
		session_start();
		$_SESSION['id'] = $id;
		$_SESSION['name'] = $profile -> name;
		$_SESSION['role'] = $profile -> role;
		$_SESSION['logo'] = $profile -> foto;
		return $id;
}
function getSlozhnost()
{
	$array_sl = array();
	require_once('Sloznost.php');
	$query = "SELECT * FROM Slozhnost";//Пишем запрос
	$data = mysqli_query($GLOBALS['dbc'], $query);//Выполняем запрос
	while($row = mysqli_fetch_array($data))
	{
		array_push($array_sl, new slozhnost($row['id'], $row['name']));
	}
	return $array_sl;
}
function getOrganizations()
{
	$array_sl = array();
	require_once('Sloznost.php');
	$query = "SELECT * FROM Organization";//Пишем запрос
	$data = mysqli_query($GLOBALS['dbc'], $query);//Выполняем запрос
	while($row = mysqli_fetch_array($data))
	{
		array_push($array_sl, new slozhnost($row['id'], $row['name']));
	}
	return $array_sl;
}
function setProject($post,$id_session)
{
	require_once('Project.php');//Подключение класса Профиль 
	$profile = new Project();//Создаем объект класса Профиль
	$id= $profile -> setProject($GLOBALS['dbc'], $post,$id_session);//Сохраняем профиль в БД 
	return $id;
}
function getCount($org2,$sl,$dat)
{
	$query = "SELECT COUNT(pr.id) as c FROM Project pr 
	INNER JOIN Slozhnost sl ON sl.id = pr.id_slozhnost 
	LEFT JOIN Project_Anketa pa ON pa.id_project = pr.id
	LEFT JOIN Anketa a ON pa.id_anketa = a.id
	LEFT JOIN Organization o ON o.id = a.id_organize
	WHERE pa.role = 1 ";
	if ($org2 != 0)
		$query.= " AND id_organize = ".$org2;
	if ($sl != 0)
		$query.= " AND id_slozhnost = ".$sl;
	if ($dat != '3000-01-01')
		$query.= " AND data_plan_sdach > '".$dat."'";
	$data = mysqli_query($GLOBALS['dbc'], $query);
	return mysqli_fetch_array($data)['c'];
}
function getProject($page, $count, $org2,$sl,$dat)//Функция, возвращающая массив проектов
{
	$array_pr = array();//массив
	require_once('Project.php');//подключаем класс
	$query = "SELECT pr.id as id, pr.name as name, o.name as organization, zadacha, id_slozhnost,sl.name as slozh, `kol-vo_ispol`, data_prin, data_plan_sdach, fact_data_sdach, pr.logo as logo 
			FROM Project pr 
			INNER JOIN Slozhnost sl ON sl.id = pr.id_slozhnost 
			LEFT JOIN Project_Anketa pa ON pa.id_project = pr.id
			LEFT JOIN Anketa a ON pa.id_anketa = a.id
			LEFT JOIN Organization o ON o.id = a.id_organize
			 WHERE pa.role = 1 ";
	if ($org2 != 0)
		$query.= " AND id_organize = ".$org2;
	if ($sl != 0)
		$query.= " AND id_slozhnost = ".$sl;
	if ($dat != '3000-01-01')
		$query.= " AND data_plan_sdach > '".$dat."'";
	$query.=" ORDER BY data_prin DESC LIMIT ".($page-1)*$count.", $count";//Пишем запрос
		$data = mysqli_query($GLOBALS['dbc'], $query);//Выполняем запрос
		if (mysqli_num_rows($data) > 0)
		while ($row = mysqli_fetch_array($data))//Обход встех строк результата запроса
		{
			$planDate = $row['data_plan_sdach']; // Плановая дата из базы данных
			$currentDate = date('Y-m-d'); // Текущая дата
			$dateDiff = strtotime($planDate) - strtotime($currentDate); // Разница в секундах
			$data_time = floor($dateDiff / (60 * 60 * 24)); // Разница в днях
			$pr = new Project();//Создаем объект класса
			array_push($array_pr, $pr->getAllProject($row['id'], $row['name'],$row['zadacha'], $row['id_slozhnost'],$row['slozh'], $row['kol-vo_ispol'], $row['data_prin'], $row['data_plan_sdach'], $row['fact_data_sdach'], $row['organization'],$data_time, $row['logo']));
		}
		return $array_pr;
}
function getProjectMy($id_pr, $type)//Функция, возвращающая массив проектов
{
	$array_pr = array();//массив
	require_once('Project.php');//подключаем класс
	$query = "SELECT pr.id as id, pr.name as name, zadacha, id_slozhnost,sl.name as slozh, `kol-vo_ispol`, data_prin, data_plan_sdach, fact_data_sdach, logo FROM Project pr INNER JOIN Slozhnost sl ON sl.id = pr.id_slozhnost INNER JOIN Project_Anketa pa ON pa.id_project = pr.id WHERE pa.id_anketa = $id_pr AND ". ($type? "pr.fact_data_sdach IS NULL": "pr.fact_data_sdach IS NOT NULL");//Пишем запрос
	$data = mysqli_query($GLOBALS['dbc'], $query);//Выполняем запрос
	while ($row = mysqli_fetch_array($data))//Обход встех строк результата запроса
	{
		$query_org = "SELECT o.name as name FROM Anketa a INNER JOIN Project_Anketa pa ON pa.id_anketa = a.id INNER JOIN Organization o ON o.id = a.id_organize WHERE id_project = ".$row['id']."";//Пишем запрос
		$data_org = mysqli_query($GLOBALS['dbc'], $query_org);//Выполняем запрос
		$org = mysqli_fetch_array($data_org)['name'];//Получаем из запроса только название Организации
		// Вычисляем разницу между плановой датой и текущей датой
		$planDate = $row['data_plan_sdach']; // Плановая дата из базы данных
		$currentDate = date('Y-m-d'); // Текущая дата
		$dateDiff = strtotime($planDate) - strtotime($currentDate); // Разница в секундах
		$data_time = floor($dateDiff / (60 * 60 * 24)); // Разница в днях
		$pr = new Project();//Создаем объект класса
		array_push($array_pr, $pr->getAllProject($row['id'], $row['name'],$row['zadacha'], $row['id_slozhnost'],$row['slozh'], $row['kol-vo_ispol'], $row['data_prin'], $row['data_plan_sdach'], $row['fact_data_sdach'], $org, $data_time, $row['logo']));
	}
	return $array_pr;
}
function getOneProject($id)
{
	require_once('Project.php');
	$pr = new Project();
	return $pr->getProject($GLOBALS['dbc'], $id);
}
function tryProject($id_anketa, $id_project)
{
	if ($id_anketa == '') return false;
	$query = "SELECT * FROM Project_Anketa WHERE id_anketa = $id_anketa AND id_project = $id_project";
	echo $query;
	$data = mysqli_query($GLOBALS['dbc'], $query);
	return mysqli_num_rows($data) > 0;
}
function updateProfile($post,$id_session)
{
	require_once('Profile.php');//Подключение класса Профиль 
	$profile = new profile();//Создаем объект класса Профиль
	return $profile -> updateProfile($GLOBALS['dbc'], $post,$id_session);//Обновляем профиль в БД
}
function setUchastnik($id_pr,$session)
{
	$query = "INSERT INTO Project_Anketa (id_project,id_anketa,role) VALUES ($id_pr, ".$session['id'].", ".$session['role'].")";
	mysqli_query($GLOBALS['dbc'], $query);
	return mysqli_insert_id($GLOBALS['dbc']);
}
function setMessage($mes,$session,$d)
{
	if (isset($mes['id_project'])) 
	{
		$query = "INSERT INTO Message (text, date, id_anketa, id_project) VALUES ('".$mes['message']."', '".$d."', $session, ".$mes['id_project'].")";
	}
	else 
	{
		$query = "INSERT INTO Message (text, date, id_anketa) VALUES ('".$mes['message']."', '".$d."', $session)";
	}
	mysqli_query($GLOBALS['dbc'], $query);
	$id = mysqli_insert_id($GLOBALS['dbc']);
	if (is_array($mes['docs_puth'])) {
		foreach ($mes['docs_puth'] as $name => $doc) {
			$query = "INSERT INTO Document (url_document, name, id_project, id_anketa, id_message) VALUES ('".$doc."', '".$name."', null, $session, $id)";
			mysqli_query($GLOBALS['dbc'], $query);
			//echo $query;
		}
	};
	return mysqli_insert_id($GLOBALS['dbc']); // Добавляем идентификатор в массив
}  
function getMessage($id)
{
	require_once('Message.php');
    $query = "SELECT * FROM Message WHERE id_project = $id";
	$result = mysqli_query($GLOBALS['dbc'], $query);
	$messages = array();
    while($row = mysqli_fetch_assoc($result))
	{
		$query_docs = "SELECT * FROM Document WHERE id_message = ".$row['id'];
		$data_docs = mysqli_query($GLOBALS['dbc'],$query_docs);
		$docs = array();
		foreach($data_docs as $doc)
		{
			$docs[$doc['url_document']] = $doc['name'];
		}
		array_push($messages, new Message($row['id'], $row['text'], $row['date'], $row['id_anketa'],$docs));
	}
    return $messages;
}
function getMessageAll()
{
	require_once('Message.php');
    $query = "SELECT * FROM Message WHERE id_project IS NULL";
	$result = mysqli_query($GLOBALS['dbc'], $query);
	$messages = array();
    while($row = mysqli_fetch_assoc($result))
	{
		$query_docs = "SELECT * FROM Document WHERE id_message = ".$row['id'];
		$data_docs = mysqli_query($GLOBALS['dbc'],$query_docs);
		$docs = array();
		foreach($data_docs as $doc)
		{
			$docs[$doc['url_document']] = $doc['name'];
		}
		array_push($messages, new Message($row['id'], $row['text'], $row['date'], $row['id_anketa'],$docs));
	}
    return $messages;
}
?>