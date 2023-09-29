<?php
require_once("header.php");
if ($id == '')
    header("Location: register.php");
?>

<!--//////////////////////////////////////////////////////////////////////////////////-->
            <!--JavaScript - действие, выполняющееся на кнопку-->

    <script>
    $(document).ready(function(){ //Ожидаем пока загрузится документ
        $('#project').submit(function(){ //Назначаем обработчик события на форму "project"
        name = document.getElementById("Name").value;//Сохраняем значения полей с формы
        zadacha = document.getElementById("Zadacha").value;
        slozhnost = document.getElementById("Slozhnost").value;
        ispol = document.getElementById("Ispol").value;
        date = document.getElementById("Data").value;
        kompetenciyaArray = document.getElementById("Kompetenciya").value;
        photo = document.getElementById("image").src;
        //Компетенции кидаем в массив
        kompetenciyaArray = kompetenciyaArray.split(";");
        //Удаляем пробелы, если они есть
        for (var i = 0; i < kompetenciyaArray.length; i++) 
            kompetenciyaArray[i] = kompetenciyaArray[i].trim();


        data = {photo:photo, name: name, zadacha: zadacha, slozhnost: slozhnost, ispol: ispol, date: date, kompetenciya:kompetenciyaArray, method: "project"};//Пакуем в массив все данные, добавляя метод регистрации
        
        $.ajax({            
                type: "POST", //Асинхронный POST-запрос
                url: "function/func.php", //к файлу "function/func.php" с помощью метода $.ajax().
                data: data, //В запросе передается объект data в качестве данных.

                success: function(html) //Если файл, получивший запрос отработал корректно
                {
                    /*if (html > 0)
                    {
                        form = document.getElementById("project");
                        form.reset();
                    }*/

                    alert(html);//Вывод сообщения - ответа от сервера
                    /*function openFile() {
                        if (html > 0)
                            window.open('profil.php', '_self');
                    }
                    openFile(); // Вызов функции открытия файла
                    */
                }
            });
            return false;

    });
});
    //Функция, ограничивающая ввод только 2 цифрами
    //Срабатывает при вводе значения в поле "Количество исполнителей"
    function limitInput(element, maxLength) 
    {
    element.value = element.value.replace(/[^0-9]/g, '').slice(0, maxLength);
    }

    function openFileExplorer() {
      var fileInput = document.getElementById("id_photo");// document.createElement('input');
      //fileInput.type = 'file';
      //fileInput.name = "photo";
      //document.getElementById("logo").appendChild(fileInput);
      fileInput.onchange = function(event) {
        var file = event.target.files[0];
        var photo = document.getElementById('logo');

        var reader = new FileReader();
        reader.onload = function(e) {
        photo.src = e.target.result;
        };
        reader.readAsDataURL(file);
      };
      fileInput.click();
    }

    function image_load()
    {
        $.ajax({            
                type: "POST", //Асинхронный POST-запрос
                url: "upload.php", //к файлу "function/func.php" с помощью метода $.ajax().
          //      data: data, //В запросе передается объект data в качестве данных.

                success: function(html) //Если файл, получивший запрос отработал корректно
                {
                    alert(html);
                }
            });
            return false;
    }
    function FindFile()
{
    document.getElementById('hidden_file').click();
}

function LoadFile()
{
    document.getElementById('hidden_load').click();
}
    </script>

<!--//////////////////////////////////////////////////////////////////////////////////-->

<body id="page-top">
    <div id="wrapper">
        <?php
        require_once("left_menu.php");
        ?>
        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">
                <?php
                require_once("top_menu.php");
                ?>

<!--//////////////////////////////////////////////////////////////////////////////////-->
            <!--Заполнение информации о проекте-->
            
                <!--Контейнер в котором лежат все поля для заполнения-->
                
                <div class="container row" style="align-items: center;">
                <?php
                    $id = $_GET['id'];
                    if (!empty($id))
                    {
                        require_once("model/data.php");
                        $prs=getOneProject($id);
                    }
                    ?>
    <img id="image" src="<?php echo $prs->logo ?>" style="width: 240px; height: 320px;"  onclick="FindFile()">
        
    <form action="upload.php" target="rFrame" method="post" enctype="multipart/form-data">
        <div class="hiddenInput" style="display:none">    
            <input type="file" id="hidden_file" name="myPhoto" onchange="LoadFile()">
            <input type="hidden" name="type" value="project">
            <input type="hidden" name="id_image" value="<?php echo $id;?>">
            <input type="submit" id="hidden_load" style="display:none" value="Загрузить">

        </form>
        <iframe id="rFrame" name="rFrame" style="display:none"></iframe>
    </div>
    <form class="project" id="project" method="POST" >
                    <div class=" col-6">  
                    
                    
                        <!--Название-->
                        <div class="input-field">   
                        <input class="form-control" type="text" id="Name" placeholder="Название" name="name" style="border-top-color: rgb(209, 211, 226);" value="<?php echo $prs->name; ?>">
                        </div>

                        <!--Задача-->
                        <div class="input-field mt-3">  
                        <textarea class="form-control" id="Zadacha" placeholder="Задача" name="zadacha" style="border-top-color: rgb(209, 211, 226);"><?php echo $prs->zadacha; ?></textarea>
                        </div>


                        <!--Сложность-->
                        <div class="input-field mt-3">  
                                <select class="form-control form-select" type="text" id="Slozhnost" placeholder=""         name="slozhnost" style="border-top-color: rgb(209, 211, 226);">
                                <option value="0" disabled selected>Выберите сложность</option>
                                    <?php
                                    require_once("model/data.php");
                                    $sl = getSlozhnost();
                                    foreach ($sl as $s)
                                    {
                                        echo '<option value="'.$s->id.'" ';
                                        if($prs->slozhnost->id == $s->id) echo 'selected';
                                        echo '>'.$s->name.'</option>';
                                    }
                                    ?>
                                </select>
                        </div>
                        
                        <!--Количество исполнителей-->
                        <div class="input-field mt-3">  
                        <input class="form-control" type="text" id="Ispol" placeholder="Количество исполнителей" name="ispol" style="border-top-color: rgb(209, 211, 226);" value="<?php echo $prs->ispol; ?>" oninput="limitInput(this, 2)">
                        </div>

                       <!--Компетенции-->
                        <div class="input-field mt-3">   
                            <input class="form-control" type="text" id="Kompetenciya" placeholder="Компетенции через точку с запятой" name="kompetenciya" style="border-top-color: rgb(209, 211, 226);" value="<?php
                                $comp = $prs->competention;
                                $count = count($comp); // Получаем количество элементов в массиве

                                foreach ($comp as $c) {
                                    $competention = $c->name; // Получаем значение поля 'name' компетенции
                                
                                    echo $competention; // Выводим значение компетенции
                                
                                    if ($key < $count - 1) {
                                        echo '; '; // Добавляем запятую и пробел, если это не последний элемент
                                    }
                                }
                            ?>">
                        </div>




                        <!--Плановая дата сдачи (календарь)-->
                        <div class="input-field mt-3">  
                            <label class="form-label" for="first_name"><strong>Дата сдачи</strong></label>
                            <input class="form-control" type="date" id="Data" name="data"value="<?php echo $prs->data_plan_sdach; ?>">
                        </div>

                        <!--Кнопка для отправки данных-->
                        <button class="btn btn-primary d-block btn-user w-100 mt-3" type="submit">Отправить проект на проверку</button>

                    </div>
                                </div>
                </form>
<!--//////////////////////////////////////////////////////////////////////////////////-->                  

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