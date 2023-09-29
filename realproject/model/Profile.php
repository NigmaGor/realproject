<?
class Profile
{
	public $foto;
	public $nick;
	public $name;
	public $family;
	public $mail;
	public $role;
	public $projects = array();
	public $value;
	
	function __construct()
	{

	}

	function getPr($db, $id)//Получаем данные Профиля из БД
	{
		$query = "SELECT * FROM Anketa WHERE id = $id";//Пишем запрос
		$data = mysqli_query($db, $query);//Выполняем запрос
		$result = mysqli_fetch_array($data);//Извлекаем первую строку результата запроса
		$this -> foto = $result['logo'];//Сохраняем в классе информацию из БД
		$this -> nick = $result['nick'];
		$this -> name = $result['name'];
		$this -> family = $result['phamiliya'];
		$this -> mail = $result['login'];
		$this -> role = $result['role'];
		switch ($this -> role)
		{
			case 1: 
				$query ="SELECT name FROM Organization WHERE id = ".$result['id_organize'];
				$data = mysqli_query($db, $query);//Выполняем запрос
				$org = mysqli_fetch_array($data)['name'];
				$this->value = $org;
				break;
			case 2: 
				$query ="SELECT dolzhnost FROM Dolzhnost WHERE id = ".$result['id_dolzhnost'];
				$data = mysqli_query($db, $query);//Выполняем запрос
				$d = mysqli_fetch_array($data)['dolzhnost'];
				$this->value = $d;
				break;
				case 3: 
					$this->value = $result['year_begin'];
					break;
		}

		return $this; //Возвращаем заполненный объект класса
	}

	/*function getPrRole($db, $id)//Получаем данные Профиля из БД
	{
		$query = "SELECT * FROM Anketa WHERE id = $id";//Пишем запрос
		$data = mysqli_query($db, $query);//Выполняем запрос
		$result = mysqli_fetch_array($data);//Извлекаем первую строку результата запроса
		return $result['role']; //Возвращаем заполненный объект класса
	}*/

	function logPr($db, $mail, $pass)
	{
		$result = array();
		$query = "SELECT * FROM Anketa WHERE login = '$mail' AND password = SHA('$pass')";//Пишем запрос
		$data = mysqli_query($db, $query);//Выполняем запрос
		$row = mysqli_fetch_array($data);//Извлекаем первую строку результата запроса
		$result[0] = $row['id'];
		$result[1] = $row['name'];
		$result[2] = $row['role'];
		$result[3] = $row['logo'];
		return $result;
	}

	function setPr($db, $post) //Записываем Профиль в БД
	{
		$id = 0;
		$val = $post['val'];
		switch ($post['role'])
		{
			case "1":
				//echo '111';
				
				$query = "SELECT id FROM Organization WHERE `name` = '$val'";
				
				$data = mysqli_query($db, $query);
				if (mysqli_num_rows($data))
					$id_org = mysqli_fetch_array($data)['id'];
				else
				{
					$query = "INSERT INTO Organization (`name`) VALUES ('".$val."')";
					$data = mysqli_query($db, $query);//Выполняем запрос
					$id_org = mysqli_insert_id($db);//Запоминаем id, куда вставляли данные о профиле
				}
				$query = "INSERT INTO Anketa (name, phamiliya, login, password, role, id_organize) VALUES ('".$post['name']."', '".$post['fam']."', '".$post['mail']."', SHA('".$post['pass']."'), ".$post['role'].", $id_org)";//Пишем запрос
				
					$data = mysqli_query($db, $query);//Выполняем запрос
					$id = mysqli_insert_id($db);//Запоминаем id, куда вставляли данные о профиле
				break;

			case "2":

				// Проверяем наличие данных в таблице Dolzhnost
				$query = "SELECT id FROM Dolzhnost WHERE 'dolzhnost' = '$val'";
				$data = mysqli_query($db, $query);

				if (mysqli_num_rows($data))
				{
					// Если данные есть, получаем id
					$id_dolzhnost = mysqli_fetch_array($data)['id'];
				} else {
					// Если данных нет, добавляем запись и получаем id
					$query = "INSERT INTO Dolzhnost (`dolzhnost`) VALUES ('".$val."')";
					$data = mysqli_query($db, $query);
					$id_dolzhnost = mysqli_insert_id($db);
				}

				// Вставляем полученный id_dolzhnost в поле id_dolzhnost таблицы Anketa
				$query = "INSERT INTO Anketa (name, phamiliya, login, password, role, id_dolzhnost) 
						VALUES ('".$post['name']."', '".$post['fam']."', '".$post['mail']."', SHA('".$post['pass']."'), ".$post['role'].", $id_dolzhnost)";
				$data = mysqli_query($db, $query);
				$id = mysqli_insert_id($db);

				break;
			case "3":
				$query = "INSERT INTO Anketa (name, phamiliya, login, password, role, year_begin) 
						VALUES ('".$post['name']."', '".$post['fam']."', '".$post['mail']."', SHA('".$post['pass']."'), ".$post['role'].", $val)";
				$data = mysqli_query($db, $query);
				$id = mysqli_insert_id($db);
				break;
		}
		//$query = "INSERT INTO Anketa (name, phamiliya, login, password) VALUES ('$name', '$fam', '$mail', SHA('$pass'))";//Пишем запрос
		//$data = mysqli_query($db, $query);//Выполняем запрос
		//$result = mysqli_fetch_array($data);//Извлекаем первую строку результата запроса
		//$id = mysqli_insert_id($db);//Запоминаем id, куда вставляли данные о профиле
		return $id;//Возвращаем id
	}

	function updateProfile($db, $post, $id)
	{
		if ($post['pass'] != null) {
			$query = "UPDATE Anketa SET name = '".$post['name']."', logo = '".$post['photo']."', login = '".$post['email']."', phamiliya = '".$post['last_name']."', password = SHA('".$post['pass']."') WHERE id = $id";
		} else {
			$query = "UPDATE Anketa SET name = '".$post['name']."', logo = '".$post['photo']."', login = '".$post['email']."', phamiliya = '".$post['last_name']."' WHERE id = $id";
		}
		$data = mysqli_query($db, $query);//Выполняем запрос
		return $data;
	}
}
?>