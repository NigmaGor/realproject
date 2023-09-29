<!DOCTYPE html>
<html>
<!--Блок PHP-->
<?php
    //Подключаем стили
    require_once('header.php');
?>
<script>
    function getInWork()
    {
        id_pr = document.getElementById("id_pr").value;
        
        data = {id_pr: id_pr, method: "set_uchastnik"};//Пакуем в массив все данные, добавляя метод участник
        $.ajax({ 
            type: "POST", //Асинхронный POST-запрос
            url: "function/func.php", //к файлу "function/func.php" с помощью метода $.ajax().
            data: data, //В запросе передается объект data в качестве данных.

            success: function(html) //Если файл, получивший запрос отработал корректно
            {
                //if (html > 0)
                document.getElementById('but_inwork').hidden = true;
                $("#root_card").load("map_project.php?pr="+id_pr+" #card_uchastnik");
                //alert(html);//Вывод сообщения - ответа от сервера
                /*function openFile() {
                    if (html > 0)
                        window.open('profil.php', '_self');
                }
                openFile(); // Вызов функции открытия файла
                */
            }
        });
        return false;
    }
  //Функция получения id проекта из url
  function getProjectIdFromUrl() 
  {
  var url = window.location.href; // Получаем текущий URL страницы
  var id = ""; // Переменная для хранения ID проекта

  // Используем регулярное выражение для извлечения ID из URL
  var regex = /pr=(\d+)/; // Извлекаем последовательность цифр после "pr="

  var matches = regex.exec(url);
  if (matches && matches.length > 1) {
    id = matches[1]; // Получаем ID из совпадения
  }
  return id;
  }

  //Функция получения сегодняшней даты в формате 2023-07-27
  function getFormattedDate() 
  {
  var currentDate = new Date();
  var year = currentDate.getFullYear();
  var month = ('0' + (currentDate.getMonth() + 1)).slice(-2);
  var day = ('0' + currentDate.getDate()).slice(-2);
  var formattedDate = year + '-' + month + '-' + day;
  return formattedDate;
  }

  //Функция отправки сообщения в БД 
  function Message() 
  {    
  //Получаем поле для ввода
  input = document.getElementById("Input_Mess");
  //Извлекаем текст из поля для ввода
  message = input.value;
  //alert(message);

  //После отправки сообщения поле для ввода очищаем
  input.value = ""; // Очистить значение поля ввода
  
  //Получаем из url id проекта
  id_project = getProjectIdFromUrl();
  //alert(id_project);
  //Получаем сегодняшнюю дату в формате 2023-07-27
  //date = getFormattedDate();
  //alert(date);

  //Передаем сообщение, id проекта, сегодняшнюю дату и метод mess //date:date, 
  data = {message:message,id_project:id_project, method: "mess"};//Пакуем в массив все данные, добавляя метод регистрации
        
        $.ajax({            
                type: "POST", //Асинхронный POST-запрос
                url: "function/func.php", //к файлу "function/func.php" с помощью метода $.ajax().
                data: data, //В запросе передается объект data в качестве данных.

                success: function(html) //Если файл, получивший запрос отработал корректно
               {
                if(html>0)
                   alert(html);
                   
                    /*if (html > 0)
                    {
                        form = document.getElementById("project");
                        form.reset();
                    }*/
                }
            });
            return false;
  }
  



    $(document).ready(function() {
  $(".input-group-text").mouseenter(function() {
    $(".dropdown-menu").show();
  });

  $(".dropdown-menu").mouseleave(function() {
    $(".dropdown-menu").hide();
  });
});
</script>

<!--Тело страницы-->
<body id="page-top">

    <!--Контейнер всей страницы (вся страница внутри этого контейнера)-->
    <div id="wrapper">

        <!--Блок PHP-->
        <?php
            $title_page = "projects";
            //Подключаем Боковое меню 
            require_once('left_menu.php');
        ?>

        <!-- Контейнер -->
        <div class="d-flex flex-column" id="content-wrapper">
            <!-- Основная часть страницы -->
            <div id="content">
                <!--Блок PHP-->
                <?php
                    //Подключаем Верхнее меню
                    require_once('top_menu.php');
                ?>                
                <?php
                    $id_pr = $_GET['pr'];
                    echo '<input type="text" id="id_pr" value="'.$id_pr.'" hidden>';
                    //require_once('temp_card_project.php');
                    //Подключаем файл со всеми функциями
                    require_once("model/data.php");
                    $prs = getOneProject($id_pr);
                    //foreach ($prs as $pr)
                    //select_list_project($pr->id, $pr->name, $pr->organization, $pr->zadacha);
                ?>
                <!--Блок - Название проекта и Кнопка (взять в работу/закрепиться за проектом)-->
                
                <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="mb-3 d-flex justify-content-left" style="position: absolute;right: 25px;">
                        <?php 
                        if($prs->data_plan_sdach >= date('Y-m-d'))
                            {
                                if (!tryProject($_SESSION['id'], $id_pr)) 
                            {
                                ?>
                                <a class="btn btn-primary btn-lg ml-auto" id="but_inwork" onclick="getInWork()" 
                                    <?php 
                                    if ($_SESSION['role']==3) echo ' >Взять в работу'; 
                                    else if ($_SESSION['role'] == 2) echo ' >Прикрепиться'; 
                                    else echo "hidden >"?></a>
                                    <?php 
                            }
                            else if($_SESSION['role']==1)
                            {
                                ?>
                                <a class="btn btn-primary btn-lg ml-auto" href="project_create.php?id=<?php echo $id_pr?>">Редактировать</a>
                                <?php 
                            }
                        }
                            else{
                                echo '<div class="alert alert-danger" id="alert_danger"  role="alert"><span><strong>Проект завершен</strong></span></div>';
                            }
                        ?>
                        </div>
                        <h2 style="text-align: center;font-size: 40px;"><?php echo $prs->name;?></h2>
                    </div>
                </div>
                </div>
                <!--Название организации-->
                <h3 class="text-center"><?php echo $prs->organization;?></h3>
                <!--Блок - Фото и Постановка задачи-->
                <div class="container">
                    <div class="row">
                        <div class="col-md-6" style="height: 450px;">
                            <img class="rounded img-fluid d-block w-100 fit-cover" style="height: 450px;" src="<?php echo ($prs->logo!=''? $prs->logo: 'assets/img/no_img.jpg')?>">
                        </div>
                        <div class="col-md-6" style="height: 450px;">
                            <h4 style="font-size: 24px;text-align: center;color: var(--bs-blue);font-weight: bold;">Постановка задачи</h4>
                            <p style="text-align: justify;font-size: 18px;"><?php echo $prs->zadacha;?></p>
                        </div>
                    </div>
                </div>
                <!--Блок - Компетенции и Доп.Информация-->
                <div class="container">
                    <div class="row">
                        <!--Компетенции-->
                        <div class="col-md-6">
                            <h4 style="font-size: 24px;text-align: center;color: var(--bs-blue);font-weight: bold;">Компетенции</h4>
                            <p style="font-size: 18px;">
                            <!--Блок PHP-->
                            <?php
                                foreach ($prs->competention as $comp)
                                echo $comp->name.'<br>';
                            ?>
                            </p>
                        </div>
                        <!--Доп.Информация-->
                        <div class="col-md-6">
                            <h4 style="font-size: 24px;text-align: center;color: var(--bs-blue);font-weight: bold;">Доп.информация</h4>
                            <p style="font-size: 18px;">
                            <!--Блок PHP-->
                            Количество исполнителей: <?php echo $prs->ispol;?><br>
                            Сложность: <?php echo $prs->slozhnost->name;?><br>
                            Дата принятия: <?php echo $prs->data_prin;?><br>
                            Дата сдачи: <?php echo $prs->data_plan_sdach;?>
                            </p>
                        </div>
                    </div>
                </div>                            
                <!--Таблица Участников проекта-->
                <div class="container">
                    <!--Заголовок-->
                    <h4 style="font-size: 30px;text-align: center;color: var(--bs-blue);font-weight: bold;">Участники проекта</h4>
                    <!-- Используем класс card для обводки всех блоков-->
                    <div id="root_card" class="card mb-3">  
                        <!--Создаем общий блок с двумя колонками, но в первой колонке 2 строки-->
                        <div id="card_uchastnik" class="row m-3">
                            <!--Первая колонка 1 строка - Заказчик-->
                            <div class="col">
                                <h4 style="font-size: 25px;text-align: center;color: var(--bs-blue);font-weight: bold;">Заказчик</h4>
                                <div class="row">
                                    <div class="col">
                                        <!--У каждого участника отображаем фото с именем и фамилией-->                 
                                        <?php
                                                function getUchastnik($array, $r)
                                                {
                                                    $res = array();
                                                    foreach ($array as $ar)
                                                    {
                                                        if ($ar->role == $r)
                                                        array_push($res, $ar);
                                                    }
                                                    return $res;
                                                }

                                                $zakazchik = getUchastnik($prs->uchastnik,1);
                                                require_once('template_uchastnik.php');
                                                print_uchastnik($zakazchik[0]->id, $zakazchik[0]->name, $zakazchik[0]->last_name, $zakazchik[0]->logo);
                                                ?>
                                    </div>  
                                </div>

                                <!--Вторая строка в первой колонке - кураторы-->            
                                <div class="row">
                                        <h4 style="font-size: 25px;text-align: center;color: var(--bs-blue);font-weight: bold;">Кураторы</h4>
                                        <div class="row">
                                        <?php
                                            $curators = getUchastnik($prs->uchastnik,2);
                                            foreach ($curators as $c)
                                            {
                                                echo '<div class="col">';
                                                print_uchastnik($c->id, $c->name, $c->last_name, $c->logo); 
                                                echo '</div>'; 
                                            }
                                                ?>
                                            
                                        </div> 
                                </div>
                            </div>

                            <!--Вторая колонка - Исполнители-->
                            <div class="col">
                                <h4 style="font-size: 25px;text-align: center;color: var(--bs-blue);font-weight: bold;">Исполнители</h4>
                                    <div class="row">
                                       
                                            <!--У каждого участника отображаем фото с именем и фамилией-->                 
                                            <?php
                                            $students = getUchastnik($prs->uchastnik,3);
                                            foreach ($students as $s)
                                            {
                                                echo '<div class="col">';
                                                print_uchastnik($s->id, $s->name, $s->last_name, $s->logo); 
                                                echo '</div>'; 
                                            }
                                                ?>
                                                
                            </div>
                        </div>
                    </div>
                    </div>
                </div>   
    <?php
    if (tryProject($_SESSION['id'], $prs->id))// session_status() != PHP_SESSION_NONE)
       {
         echo '<div class="container">
        <div class="row rounded-lg overflow-hidden shadow">
            <div class=" px-5 py-3 row-6 bg-white">
                <div  class="px-2 py-4 chat-box col-auto" >';
                        $dat='';        
                        $profile = getProfile($id);
                        $mess = getMessage($id_pr);
                        require_once('temp_mess.php');

                        foreach ($mess as $m)
                        {
                            if ($m->data != $dat)
                            {
                                $dat = $m->data;
                                echo '<p class="small text-center">'.$dat.'</p>';
                            }
                            if ($m->id_anketa == $id)
                            vis_mess_my($profile->foto, $profile->name.' '.$profile->family, $m->text, $m->time);
                            else
                            {
                                $profile=getProfile($m->id_anketa);
                                vis_mess_not_my($profile->foto, $profile->name.' '.$profile->family, $m->text, $m->time);
                            }
                        }        
                   echo'
                </div>
                <style>
                    .dropdown-menu 
                    {
                        display: none;
                        position: absolute;
                        top: auto;
                        bottom: 100%;
                    }
                    .dropdown:hover .dropdown-menu 
                    {
                        display: block;
                    }
                </style>
                <form action="#" class="bg-light">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-paperclip"></i>
                            </span>
                            <div class="dropdown-menu" aria-labelledby="attachmentDropdown">
                                <a class="dropdown-item" href="#">Прикрепить фото</a>
                                <a class="dropdown-item" href="#">Прикрепить документ</a>
                            </div>
                        </div>
                        <input id="Input_Mess" type="text" placeholder="Написать сообщение..." aria-describedby="button-addon2" class="form-control rounded-0 border-0 py-4 bg-light">
                        <button type="button" class="btn btn-primary btn-lg" onclick="Message()">Отправить</button>
                    </div>
                </form>
            </div>
        </div>
        </div>';
                }
    ?>


            <!--Блок - подвал (самый низ страницы)-->
            <footer class="bg-white sticky-footer">
                <div class="container my-auto">
                    <div class="text-center my-auto copyright"><span>Copyright © Brand 2023</span></div>
                </div>
            </footer>
        </div>

        <!-- Кнопка возврата в самый верх страницы (в виде стрелки) -->
        <a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a>
    </div>

    <!--Подключение js.файлов-->
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/theme.js"></script>
</body>
</html>