<?php
function jsOnResponse($obj, $count_doc, $fileName)
{
  if ($count_doc != '')
  echo '<script type="text/javascript">
    window.parent.document.getElementById("doc_'.$count_doc.'").value = "'.$obj.'";
    window.parent.document.getElementById("name_doc_'.$count_doc.'").value = "'.$fileName.'";
    </script>';
    else
  echo '<script type="text/javascript">
    window.parent.document.getElementById("image").src = "'.$obj.'";
    </script>';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Проверяем, был ли загружен файл
  echo $_FILES['myPhoto']['tmp_name'];
  if (isset($_FILES['myPhoto']) && $_FILES['myPhoto']['error'] === UPLOAD_ERR_OK) {
    // Получаем информацию о файле
    $fileName = $_FILES['myPhoto']['name'];
    $fileTmpPath = $_FILES['myPhoto']['tmp_name'];
  
    // Указываем путь к директории, в которую нужно сохранить файл
    $type=$_POST['type'];
    switch ($type)
    {
      case "profile":
        $uploadDirectory = 'photo/profile/';
        break;
      case "project":
        $uploadDirectory = 'photo/project/';
        break;
      case "chat":
        $uploadDirectory = 'doc/';
        $count_doc = $_POST['count_doc'];
    }
  
    // Полный путь к файлу на сервере
    $extention = explode('/', $_FILES['myPhoto']['type'])[1];
    $uploadFilePath = $uploadDirectory . $_POST['id_image'].date("H_i_s").'.'.$fileName;
  
    // Перемещаем загруженный файл в нужную директорию
    if (move_uploaded_file($fileTmpPath, $uploadFilePath)) {
      // Файл успешно сохранен
      echo "Файл успешно сохранен: " . $uploadFilePath;
      jsOnResponse($uploadFilePath, $count_doc, $fileName);
    } else {
      // Ошибка при сохранении файла
      echo "Ошибка при сохранении файла.";
    }
  } else {
    // Ошибка при загрузке файла
    echo "Ошибка при загрузке файла. Код ошибки: " . $_FILES['myPhoto']['error'];
  }
}
?>