<html>
<?php require_once('header.php');
if ($id == '')
header("Location: register.php");
$id2 = $_GET['id'];//id пользователя, на которого нажали
                                                            
require_once('model/data.php');
$flag = $id==$id2 || $id2=='';
if(!$flag)
    $id = $id2;
?>

<script>
document.addEventListener('DOMContentLoaded', function()// это способ привязать функцию к событию DOMContentLoaded, которое происходит, когда весь HTML-документ был полностью загружен и разобран браузером.
 {
    //var label = document.getElementById('label_role');
    //var condition = true; // Здесь задайте ваше условие
    /*
    id сессии - это и есть id пользователя в таблице Анкета
    Нужно по этому id обратиться к таблице Анкета и вытащить столбец роль 
    Если роль = 01 то это заказчик, значит лейбл должен быть Организация
    Если роль = 10 то экто куратор, значит лейбл должен быть Должность
    Если роль = 11 то это студент, значит лейбл должен быть Год поступления
    */
    //if (condition) {
   //   label.innerHTML = '<strong>Организация</strong><br>';
    //} else {
    //  label.innerHTML = '<strong>Должность</strong><br>';
    //}
  });

function setActive(a)
{
    var a2;
    a.classList.add("active");
    if (a.id == "active-tab")
    {
        a2 = document.getElementById("archive-tab");
        $("#data_project").load("profil.php?id="+<?php echo $id; ?>+"&type=1 #d_pr");
    }
    else
    {
        a2 = document.getElementById("active-tab");
        $("#data_project").load("profil.php?id="+<?php echo $id; ?>+"&type=0 #d_pr");
    }
    a2.classList.remove("active");
}
function makeFieldsReadOnly() {
  var name = document.getElementById("Name");
  var email = document.getElementById("Email");
  var last_name = document.getElementById("Last_Name");
  var organization = document.getElementById("Organization");
  document.getElementById("but_save").hidden = true;
   // document.getElementById("but_photo").hidden=true;
    document.getElementById("but_pr").hidden=true;
    document.getElementById("image").onclick="";

  name.readOnly = true;
  email.readOnly = true;
  last_name.readOnly = true;
  organization.readOnly = true;
}
//Обновление данных профиля
//Получаем данные с формы и через ajax отправляем на func.php, который вызывает функцию для запроса к БД, обновляя данные профиля в базе

$(document).ready(function(){ //Ожидаем пока загрузится документ

   $('#Update_Password').submit(function(){ //Назначаем обработчик события на форму "Update_Password" и сохраняем значения полей с формы
       name = document.getElementById("Name").value;//Имя
       email = document.getElementById("Email").value;//Почта
       last_name = document.getElementById("Last_Name").value;//Фамилия
       pass = document.getElementById("Password").value;//Пароль
       organization = document.getElementById("Organization").value;//Организация
       pass2 = document.getElementById("Password2").value;//Подтверждение пароля
       photo = document.getElementById("image").src;

        // Получаем ссылку на элемент блока с сообщением
         alertDanger = document.getElementById("alert_danger");

        // Функция для изменения текста в блоке
        function changeAlertText(newText, type) {
        // Находим элемент span внутри блока и изменяем его содержимое
        alertDanger.querySelector("span").innerHTML = "<strong>" + newText + "</strong>";
        if (type)
        {
            alertDanger.classList = "alert alert-success";
        }
        else alertDanger.classList = "alert alert-danger";
        alertDanger.hidden = false;
        }     
        
        if (name == "" || email == "" || last_name == "")
        {
        changeAlertText("Указаны некорректные данные", 0);
        //alertDanger.hidden = false;//Отображаем сообщение
        }

       else if (pass != pass2)//Проверка совпадает ли пароль с повторением пароля
        {
            changeAlertText("Пароли не совпадают", 0);
            //alertDanger.hidden = false;//Отображаем сообщение
        }
          else
        {
           data = {photo:photo,name: name, email: email, last_name: last_name, pass: pass, organization: organization, method: "update"};//Пакуем в массив все данные, добавляя метод обновления профиля
           $.ajax({ 
               type: "POST", //Асинхронный POST-запрос
               url: "function/func.php", //к файлу "function/func.php" с помощью метода $.ajax().
               data: data, //В запросе передается объект data в качестве данных.

               success: function(html) //Если файл, получивший запрос отработал корректно
               {
                   if (html>0)
                   changeAlertText("Профиль обновлен", 1);
                   else
                   changeAlertText("Ошибка сервера", 0);
               }
           });
           
       }
       return false;
   });
});

function FindFile()
{
    document.getElementById('hidden_file').click();
}

function LoadFile()
{
    document.getElementById('hidden_load').click();
}

</script>

<body id="page-top">
    <div id="wrapper">
    <?php
    $title_page = "profile";
    require_once('left_menu.php');
    ?>
        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">
            <?php
            require_once('top_menu.php');
            ?>
                <div class="container-fluid">
                <div class="row">
  <div class="col-md-6">
    <h3 class="text-dark mb-4">Профиль</h3>
  </div>
  <div class="col-md-6">
    <div class="mb-3 d-flex justify-content-end">
      <a class="btn btn-primary btn-lg ml-auto" id="but_pr" href="project_create.php">Создать проект</a>
    </div>
  </div>
</div>



                    <div class="row mb-3">
                    <div class="col-lg-4">
                    <div class="card" style="height:100%"> <!---->
    <?php
    //id сессии (тот, кто нажал)
    $profile = getProfile($id);
    ?>
    <div class="card-body text-center shadow" style="height: 100%; margin-top: 0px;">
    <img id="image" src="<?php echo ($profile->foto ? $profile->foto : 'assets/img/no_img.jpg');?>" style="width: 100%;height: 100%;object-fit: cover;"  onclick="FindFile()">
        
    <form action="upload.php" target="rFrame" method="post" enctype="multipart/form-data">
        <div class="hiddenInput" style="display:none">    
            <input type="file" id="hidden_file" name="myPhoto" onchange="LoadFile()">
            <input type="submit" id="hidden_load" style="display:none" value="Загрузить">
            <input type="hidden" name="type" value="profile">
            <input type="hidden" name="id_image" value="<?php echo $id;?>">
            <!--<label for="fileInput">-->
                <!--<input type="file" id="myPhoto"> class="rounded-circle mb-3 mt-4" src="<?php echo $profile->foto ?>" width="160" height="160" > style="width: 240px; height: 320px; cursor: pointer;"-->
            <!--</label>-->
            
            <!--<input id="fileInput" type="file" style="display: none;">-->
            <!--<div class="mb-3">
                <input type="submit" name="image" value="Загрузить">-->
                <!--<button class="btn btn-primary btn-sm" id="uploadBtn" type="submit" style="padding: 5px 4px;">Установить фото</button>
            </div>-->
        </div>
    </form>
    <iframe id="rFrame" name="rFrame" style="display:none"></iframe>
    </div>
</div>
</div>

                        <div class="col-lg-8">
                            <div class="row">
                                <div class="col">
                                    <div class="card shadow">
                                        <div class="card-header py-3" style="color: rgb(133, 135, 150);background: rgb(248, 249, 252);">
                                            <p class="text-primary m-0 fw-bold">Пользовательские данные</p>
                                        </div>
                                        <div class="card-body">
                                        <form class="user" id="Update_Password" method="POST">
                                                <div class="row">
                                                
                                                                                                        
                                                    <div class="col">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="first_name">
                                                                <strong>Имя</strong>
                                                                <br>
                                                            </label>
                                                            <input class="form-control" type="text" id="Name" placeholder="" name="first_name" style="border-top-color: rgb(209, 211, 226);" value="<?php echo $profile -> name ?>" >
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label" for="last_name">
                                                                <strong>Фамилия</strong>
                                                                <br>
                                                            </label>
                                                            <input class="form-control" type="text" id="Last_Name" placeholder="" name="last_name" value="<?php echo $profile -> family; ?>">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label" for="first_name" id="label_role">
                                                                <strong>
                                                                    <?php switch ($profile->role){ case 1: echo 'Организация'; break; case 2: echo 'Должность'; break; case 3: echo 'Год поступления'; break;}?>
                                                                </strong>
                                                                <br>
                                                            </label>
                                                            <input class="form-control" readOnly="true" type="text" value='<?php echo $profile->value;?>' id="Organization" placeholder="" name="first_name" style="border-top-color: rgb(209, 211, 226);">
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="email">
                                                                <strong>Электронный адрес</strong>
                                                                <br>
                                                            </label>
                                                            <input class="form-control" type="email" id="Email" placeholder="" name="email" value="<?php echo $profile -> mail; ?>">
                                                        </div>
                                                        <?php if ($flag) {?>
                                                        <div class="mb-3">
                                                            <label class="form-label" for="last_name">
                                                                <strong>Пароль</strong>
                                                                <br>
                                                            </label>
                                                            <input class="form-control" type="text" id="Password" placeholder="" name="last_name">
                                                        </div> 
                                                        <div class="mb-3">
                                                            <label class="form-label" "for="last_name">
                                                                <strong>Подтверждение пароля</strong>
                                                                <br>
                                                            </label>
                                                            <input class="form-control" type="text" id="Password2" placeholder="" name="last_name">
                                                        </div>  
                                                        <?php }?>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <!--
                                                        <div class="col"><label class="col-form-label" for="first_name"><strong>Роль</strong><select class="form-select">
                                                                <option value="12" selected="">Заказчик</option>
                                                                <option value="13">Куратор</option>
                                                                <option value="14">Студент</option>
                                                            </select><br></label></div>
                                                    -->
                                                </div>
                                                <div class="mb-3"><button class="btn btn-primary btn-sm" id="but_save" type="submit">Сохранить</button></div>
                                            </form>
                                            <div class="alert alert-danger" id="alert_danger" hidden role="alert"><span><strong>Введены некорректные данные</strong></span></div>
                                            <?php if (!$flag) {?><script>makeFieldsReadOnly();</script><?php }?>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container-fluid">
    <div class="p-5 bg-white rounded shadow mb-5" >
        <ul id="myTab" class="nav nav-tabs nav-pills flex-column flex-sm-row text-center bg-light border-0 rounded-nav" role="tablist">
            <li class="nav-item flex-sm-fill"><a id="active-tab" class="nav-link border-0 text-uppercase font-weight-bold active" data-toggle="tab" onclick="setActive(this)" role="tab">Активные проекты</a></li>
            <li class="nav-item flex-sm-fill"><a id="archive-tab" class="nav-link border-0 text-uppercase font-weight-bold" data-toggle="tab" onclick="setActive(this)" role="tab">Архивные проекты</a></li>
        </ul>
        <div id="data_project">
        <div class="row gy-4 row-cols-1 row-cols-md-2 mt-3" id="d_pr" >
 
        <?php
        require_once('temp_list_projects.php');
        require_once("model/data.php");
        $type = $_GET['type'] == ''? 1:  $_GET['type'];
        $prs = getProjectMy($id, $type);
    
                                
                                //$prs = getProject();
                                foreach ($prs as $pr)
                                select_list_project($pr->id, $pr->name, $pr->organization, $pr->zadacha, $pr->data_time, $pr->logo);
                                ?>
    </div>
                                                        </div>
    </div>
</div>

            </div>
            <footer class="bg-white sticky-footer">
                <div class="container my-auto">
                    <div class="text-center my-auto copyright"><span>Copyright © Brand 2022</span></div>
                </div>
            </footer>
        </div><a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a>
    </div>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/theme.js"></script>
</body>

</html>