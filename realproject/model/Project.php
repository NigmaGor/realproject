<?
require_once 'Sloznost.php'; // Подключение класса Сложность
require_once 'Uchastnik.php'; // Подключение класса Участник
class Project//Класс проект
{
	public $id;
    public $name; //Название
	public $zadacha; //Задача (описание)
	public $slozhnost; // Сложность (объект класса Slozhnost)
	public $ispol; //Количество исполнителей
	public $data_prin; //Ставится тогда, когда комиссия утвердит проект
	public $data_plan_sdach; //Заполняется заказчиком
    public $fact_data_sdach; //Ставится тогда, когда заказчик примет выполненный проект
    public $logo; //Картинка проекта
	public $organization;
	public $competention = array();//Массив компетенций
	public $data_time; //Количество дней до конца сдачи проекта
	public $uchastnik = array();//Массив участников

	function getProject($db, $id)//Получаем данные Проекта из БД
	{
		$query = "SELECT * FROM Project WHERE id = $id";//Пишем запрос
		$data = mysqli_query($db, $query);//Выполняем запрос
		$result = mysqli_fetch_array($data);//Извлекаем первую строку результата запроса
		$this -> name = $result['name'];//Сохраняем в классе информацию из БД
		$this -> zadacha = $result['zadacha'];
		
		//Из предыдущего запроса получили данные таблицы Project
		//В данной таблице есть только id сложности
		//А так как у нас сложность это объект класса, а для его создания нужен не только id но и название (конструктор класса Сложность), тогда нужен еще один запрос для получения названия сложности по полученному id
		$query = "SELECT name FROM Slozhnost WHERE id = $result[id_slozhnost]";//Запрашиваем Название сложности по тому id который получили с предыдущего запроса
		$data = mysqli_query($db, $query);//Выполняем запрос
		$result2 = mysqli_fetch_array($data);//Извлекаем первую строку результата запроса
		$this -> slozhnost = new Slozhnost($result['id_slozhnost'],$result2['name']);//Создаем объект класса сложность, указывая в конструкторе id и полученное название из запроса
		$this -> ispol = $result['kol-vo_ispol'];
		$this -> data_prin = $result['data_prin'];
		$this -> data_plan_sdach = $result['data_plan_sdach'];
		$this -> fact_data_sdach = $result['fact_data_sdach'];
		$this -> logo = $result['logo'];

		require_once("Competention.php");
		$query_c = "SELECT k.id as id, k.name as name FROM Kompetenciya k 
					INNER JOIN Kompetenciya_project kp ON k.id = kp.id_kompenetciya
					WHERE kp.id_project = $id";
		$data_c = mysqli_query($db, $query_c);
		while ($row = mysqli_fetch_array($data_c))
		{
			array_push($this->competention, new Competention($row['id'], $row['name']));
		}
		require_once('Uchastnik.php');
		$query = "SELECT o.name as name, a.id as id_uch, a.name as name_uch, a.phamiliya as phamiliya_uch, pa.role, a.logo FROM Anketa a INNER JOIN Project_Anketa pa ON pa.id_anketa = a.id LEFT JOIN Organization o ON o.id = a.id_organize WHERE id_project = ".$id."";//Пишем запрос
		$data = mysqli_query($db, $query);//Выполняем запрос
		while ($row = mysqli_fetch_array($data))
		{
			if ($row['role'] == 1)
				$this -> organization = $row['name'];
			array_push($this->uchastnik, new Uchastnik($row['id_uch'],$row['name_uch'],$row['phamiliya_uch'],$row['role'],$row['logo']));
		}
		//$org = mysqli_fetch_array($data_org)['name'];//Получаем из запроса только название 
		//$this -> organization = $org;


		return $this; //Возвращаем заполненный объект класса
	}

	function getAllProject($i, $n, $z, $id_sl, $n_sl, $ispol, $data_prin, $data_pl, $fact_data, $org, $data, $logo)//Получаем данные Профиля из БД
	{
		$this-> id = $i;
		$this -> name = $n;//Сохраняем в классе информацию из БД
		$this -> zadacha = $z;
		$this -> slozhnost = new Slozhnost($id_sl,$n_sl);//Создаем объект класса сложность, указывая в конструкторе id и полученное название из запроса
		$this -> ispol = $ispol;
		$this -> data_prin = $data_prin;
		$this -> data_plan_sdach = $data_pl;
		$this -> fact_data_sdach = $fact_data;
		$this -> organization = $org;
		$this -> data_time = $data;
		$this -> logo = $logo;
		return $this; //Возвращаем заполненный объект класса
	}

	function setProject($db,$post,$id_session)
	{
		$query = "INSERT INTO Project (name, zadacha, id_slozhnost, `kol-vo_ispol`, `data_plan_sdach`, logo) VALUES ('".$post['name']."', '".$post['zadacha']."', ".$post['slozhnost'].", ".$post['ispol'].", '".$post['date']."','".$post['photo']."')";
		$data = mysqli_query($db, $query);
		$id_pr = mysqli_insert_id($db);//Получили id созданного проекта

		$query = "INSERT INTO Project_Anketa (id_project, id_anketa, role) VALUES ($id_pr, $id_session, 1)";
		$data = mysqli_query($db, $query);//в таблицу Project_Anketa добавляем id созданного проекта и id анкеты (id сессии)

		//Записываем каждый элемент массива как новую запись в таблицу Kompetenciya
		foreach ($post['kompetenciya'] as $word) 
		{
			$query = "INSERT INTO Kompetenciya (name) VALUES ('$word')";
			mysqli_query($db, $query);
			$id_k = mysqli_insert_id($db);
			$query = "INSERT INTO Kompetenciya_project (id_kompenetciya, id_project) VALUES ($id_k, $id_pr)";
			mysqli_query($db, $query);
			
		}
		return $id_pr;

	}
}
?>