<!DOCTYPE html>
<html>
<?php 
    // Execute PHP script
    exec('php -f echo-server.php');
    
    // Include header file
    require_once('header.php');
?>
<body>
    <div id="wrapper">
        <?php
            // Set page title
            $title_page = "chat";
            
            // Include left menu
            require_once('left_menu.php');
        ?>

<script>
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

  
/*$(document).ready(function() {
  var socket = new WebSocket("ws://127.0.0.1:7777");
  //var socket = new WebSocket("ws://127.0.0.1", 8000);

socket.onopen = function(){
  alert("Соединение ");
};
  $(".input-group-text").mouseenter(function() {
    $(".dropdown-menu").show();
  });

  $(".dropdown-menu").mouseleave(function() {
    $(".dropdown-menu").hide();
  });
});*/

  $(document).ready(function(){
    var element = $("#root_chat");
    element.scrollTop(element[0].scrollHeight);
});

function FindFile()
{
    document.getElementById('hidden_file').click();
}

function LoadFile()
{
  document.getElementById('hidden_load').click();
  var fileInput = document.getElementById('hidden_file');
  var count_doc = document.getElementById('count_doc');
  var fileName = fileInput.value; // получаем имя выбранного файла
  var attachedDocumentsContainer = document.getElementById('attached_documents');
  
  // Создаем новый элемент списка для отображения выбранного файла
  var listItem = document.createElement('li');
  listItem.innerHTML = fileName;
  
  // Создаем кнопку-крестик для открепления файла
  var removeButton = document.createElement('button');
  removeButton.innerHTML = 'x';
  removeButton.id = 'x_'+count_doc.value;
  removeButton.onclick = function() {
    // Ваш код для удаления файла
    var c_d = document.getElementById('count_doc');
    var curr_doc = this.id;
    curr_doc = curr_doc.split('_')[1];
    for (i=Number(curr_doc)+1; i<c_d.value; i++)
      {
        document.getElementById("doc_"+i).id = "doc_"+ curr_doc;
        document.getElementById("x_"+i).id = "x_"+ curr_doc;
        documnet.getElementById("name_doc_"+i).id = "name_doc_"+ curr_doc;
      }
    listItem.remove();
    c_d.value--;

  };
  
  // Добавляем кнопку-крестик к элементу списка
  listItem.appendChild(removeButton);

  var id_elem = document.createElement('input');
  id_elem.type = "hidden";
  id_elem.id = "doc_"+count_doc.value;
  listItem.appendChild(id_elem);

  id_elem = document.createElement('input');
  id_elem.type = "hidden";
  id_elem.id = "name_doc_"+count_doc.value;
  count_doc.value++;
  listItem.appendChild(id_elem);

  // Добавляем элемент списка к контейнеру для прикрепленных документов
  attachedDocumentsContainer.appendChild(listItem);
  
  // Очищаем значение поля выбора файла
  fileInput.value = '';
}

  var socket;
window.addEventListener('DOMContentLoaded', function () {
    // показать сообщение в #socket-info
    function showMessage(){//message) {
      
      //обновление блока
      $("#root_chat").load("chat.php"+" #chat_children");
        //var div = document.createElement('div');
        //div.appendChild(document.createTextNode(message));
        //document.getElementById('socket-info').appendChild(div);
    }

    /*
     * Установить соединение с сервером и назначить обработчики событий
     */
    //document.getElementById('connect').onclick = function () {
        // новое соединение открываем, если старое соединение закрыто
        if (socket === undefined || socket.readyState !== 1) {
            socket = new WebSocket('ws://127.0.0.1:7777');
        } else {
            //showMessage();//'Надо закрыть уже имеющееся соединение');
        }

        /*
         * четыре функции обратного вызова: одна при получении данных и три – при изменениях в состоянии соединения
         */
        socket.onmessage = function (event) { // при получении данных от сервера
            showMessage();//'Получено сообщение от сервера: ' + event.data);
        }
        socket.onopen = function () { // при установке соединения с сервером
            //showMessage();//'Соединение с сервером установлено');
        }
        socket.onerror = function(error) { // если произошла какая-то ошибка
          
          //location.reload();  
          //showMessage();//'Произошла ошибка: ' + error.message);
        };
        socket.onclose = function(event) { // при закрытии соединения с сервером
            //showMessage();//'Соединение с сервером закрыто');
            if (event.wasClean) {
                //showMessage();//'Соединение закрыто чисто');
            } else {
                //showMessage();//'Обрыв соединения'); // например, «убит» процесс сервера
            }
            //showMessage();//'Код: ' + event.code + ', причина: ' + event.reason);
        };
    //};

    /*
     * Отправка сообщения серверу
     */

/*    document.getElementById('send-msg').onclick = function () {
        if (socket !== undefined && socket.readyState === 1) {
            var message = document.getElementById('message').value;
            socket.send(message);
            showMessage('Отправлено сообщение серверу: ' + message);
        } else {
            showMessage('Невозможно отправить сообщение, нет соединения');
        }
    };*/

    /*
     * Закрыть соединение с сервером
     */
    /*document.getElementById('disconnect').onclick = function () {
        if (socket !== undefined && socket.readyState === 1) {
            socket.close();
        } else {
            showMessage('Соединение с сервером уже было закрыто');
        }
    };*/

});

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
  //id_project = getProjectIdFromUrl();
  //alert(id_project);
  //Получаем сегодняшнюю дату в формате 2023-07-27
  //date = getFormattedDate();
  //alert(date);
  var count_doc = document.getElementById('count_doc').value;
  var docs_puth = {}; // {} will create an object

  //var docs_puth=Array();
  for (i=0;i<count_doc;i++)
  {
    var doc = document.getElementById("doc_"+i).value;
    var name = document.getElementById("name_doc_"+i).value;
    docs_puth[name] = doc;
  }
  
  //Передаем сообщение, id проекта, сегодняшнюю дату и метод mess //date:date, 
  data = {message:message, docs_puth:docs_puth, method: "mess"};//Пакуем в массив все данные, добавляя метод регистрации
        
        $.ajax({            
                type: "POST", //Асинхронный POST-запрос
                url: "function/func.php", //к файлу "function/func.php" с помощью метода $.ajax().
                data: data, //В запросе передается объект data в качестве данных.

                success: function(html) //Если файл, получивший запрос отработал корректно
               {
                
                //if (socket !== undefined && socket.readyState === 1) {
                //    //var message = document.getElementById('message').value;
                //    socket.send('');
                //    //showMessage('Отправлено сообщение серверу: ' + message);
                //} 
                $("#root_chat").load("chat.php"+" #chat_children",()=>{
                  var element = $("#root_chat");
                element.scrollTop(element[0].scrollHeight);
                });
                
                }
            });
            return false;
  }
  
</script>

<div class="d-flex flex-column" id="content-wrapper">
  <div id="content">
    <?php
    require_once('top_menu.php');
    ?>
    <style>
    .class_message_box{
      overflow: auto;
    height: 71vh;
    }
    </style>
      <div class="container">
        <div class="row rounded-lg overflow-hidden shadow">
          <div class=" px-5 py-3 row-6 bg-white" >
            <div id="root_chat" class="class_message_box">
            <div  class="px-2 py-4 chat-box col-auto" id="chat_children" style="width: 99%;">
              <?php
              require_once("model/data.php");
              $dat='';        
              $id = $_SESSION['id'];
              $mess = getMessageAll();
              require_once('temp_mess.php');
              echo chat($mess,$id);

              //print_r(get_loaded_extensions() );

                /*$dat='';        
                $mess = getMessageAll();
                require_once('temp_mess.php');

                foreach ($mess as $m)
                {
                    if ($m->data != $dat)
                    {
                        $dat = $m->data;
                        echo '<p class="small text-center">'.$dat.'</p>';
                    }
                    
                        $profile=getProfile($m->id_anketa);
                        vis_mess_not_my($profile->foto, $profile->name.' '.$profile->family, $m->text, $m->time);
                    
                } */   
              ?>  
              
            </div>
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

<?php
  if($_SESSION['id'] != '')
    {echo
    '
      <div class="message-input-container">
      <div class="bg-light">
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text" onclick="FindFile()">
              <i class="fas fa-paperclip"></i>
            </span>
            <form action="upload.php" target="rFrame" method="post" enctype="multipart/form-data">
              <div class="hiddenInput" style="display:none">    
                <input type="file" id="hidden_file" name="myPhoto" onchange="LoadFile()">
                <input type="submit" id="hidden_load" style="display:none" value="Загрузить">
                <input type="hidden" name="type" value="chat">
                <input type="hidden" name="count_doc" id="count_doc" value="0">
              </div>
            </form>
            <iframe id="rFrame" name="rFrame" style="display:none"></iframe>
            <div class="dropdown-menu" aria-labelledby="attachmentDropdown">
              <a class="dropdown-item" href="#">Прикрепить фото</a>
              <a class="dropdown-item" href="#">Прикрепить документ</a>
            </div>
          </div>
          <input id="Input_Mess" type="text" placeholder="Написать сообщение..." aria-describedby="button-addon2" class="form-control rounded-0 border-0 py-4 bg-light">
          <button class="btn btn-primary btn-lg" onclick="Message()">Отправить</button>
        </div>
      </div>
      <div id="attached_documents"></div>
    </div>
    ';
    }
?>


      </div>
    </div>
                                        </div>
<footer class="bg-white sticky-footer">
    <div class="container my-auto">
        <div class="text-center my-auto copyright"><span>Copyright © Brand 2023</span></div>
    </div>
</footer>
</div><a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i>
</a>
</div>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/js/theme.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/js/theme.js"></script>


</body></html>