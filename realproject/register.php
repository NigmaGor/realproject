<?php
require_once("header.php");
?>

<script> //JavaScript

function change_select(sel)
{
    const inputField = document.getElementById('Rol');//Здесь мы получаем ссылку на элемент ввода по его id Rol с помощью метода getElementById    
    inputField.hidden = false;
    switch (sel.value)
    {
        case "1":
            inputField.value='';
            inputField.placeholder  = 'Организация';
            inputField.removeEventListener('input', inputHandler);
            break;
        case "2": 
            inputField.value='';
            inputField.placeholder  = 'Должность';
            inputField.removeEventListener('input', inputHandler);
            break;
        case "3":            
            
            inputField.value='';
            inputField.placeholder  = 'Год зачисления';

             //Добавляем обработчик события input к полю ввода (inputField).
            //Событие input возникает, когда пользователь вводит текст в поле ввода.
            inputField.addEventListener('input', inputHandler);
            break;
    }
}

function inputHandler() 
                {
                    this.value = this.value.replace(/\D/g, '');//Удаляем все символы, кроме цифр
                    if (this.value.length > 4) //Для ввода даты разрешаем не более 4 цифр
                        this.value = this.value.slice(0, 4);
                }

$(document).ready(function(){ //Ожидаем пока загрузится документ
   
    // Обработка события изменения значения в списке
    //Мы добавляем обработчик события change к элементу списка выбора (selectField).
    //Когда происходит изменение значения в списке выбора, срабатывает функция-обработчик.

    /*selectField.addEventListener('change', function() {
    if (this.value === '1')
        {inputField.value='';
        inputField.placeholder  = 'Организация';
        }
     else if (this.value === '2') 
     {inputField.value='';
        inputField.placeholder  = 'Должность';   }      
    else {
        inputField.value='';
        inputField.placeholder  = 'Год зачисления';
        
        }
    });*/

    $('#user').submit(function(){ //Назначаем обработчик события на форму "user"

        name = document.getElementById("FirstName").value;//Сохраняем значения полей с формы
        fam = document.getElementById("SecondName").value;
        mail = document.getElementById("Email").value;
        pass = document.getElementById("Password").value;
        pass2 = document.getElementById("Password2").value;

        val = document.getElementById('Rol').value;//Здесь мы получаем ссылку на элемент ввода по его id Rol с помощью метода getElementById    
        
        list = document.getElementById('Sel').value;//Список ролей
        
        if (pass != pass2)//Проверка совпадает ли пароль с повторением пароля
            alert("Пароли не совпадают"); //Вывод ошибки
        else if(list == "3" && val.length != 4)
           { 
                alert("Год зачисления указан неверно"); //Вывод ошибки
           }
           else
        {
            data = {name: name, fam: fam, mail: mail, pass: pass, role: list, val: val, method: "reg"};//Пакуем в массив все данные, добавляя метод регистрации
            $.ajax({ 
                type: "POST", //Асинхронный POST-запрос
                url: "function/func.php", //к файлу "function/func.php" с помощью метода $.ajax().
                data: data, //В запросе передается объект data в качестве данных.

                success: function(html) //Если файл, получивший запрос отработал корректно
                {
                    //if (html > 0)

                    //alert(html);//Вывод сообщения - ответа от сервера
                    function openFile() {
                        if (html > 0)
                            window.open('profil.php', '_self');
                    }
                    openFile(); // Вызов функции открытия файла
                    
                }
            });
            return false;
        }
    });
});
</script>

<body class="bg-gradient-primary">
    <div class="container" style="margin-top: 150px;     max-width: 720px;">
        <div class="card shadow-lg o-hidden border-0 my-5">
            <div class="card-body p-0">
                <div class="row">
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h4 class="text-dark mb-4">Регистрация</h4>
                            </div>
                            <form class="user" id="user" method="POST">
                                <div class="row mb-3">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input class="form-control form-control-user" type="text" id="FirstName" placeholder="Имя" name="first_name">
                                    </div>
                                    <div class="col-sm-6">
                                        <input class="form-control form-control-user" type="text" id="SecondName" placeholder="Фамилия" name="last_name">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input class="form-control form-control-user" type="email" id="Email" aria-describedby="emailHelp" placeholder="Электронный адрес" name="email">
                                    </div>
                                    <div class="col-sm-6">
                                        <select class="form-select form-control form-control-user" id = "Sel" onchange="change_select(this)">
                                            <option value="0" disabled selected>Выберите роль</option>
                                            <option value="1">Заказчик</option>
                                            <option value="2">Куратор</option>
                                            <option value="3">Студент</option>
                                        </select>                                 
                                    </div>                                      
                                </div>  

                                    <div class="row mb-3">                                    
                                        <div class="col-sm-6"></div><div class="col-sm-6"><input class="form-control form-control-user" type="text" id="Rol" placeholder="" hidden=""></div>
                                    </div> 

                                <div class="row mb-3">
                                    <div class="col-sm-6 mb-3 mb-sm-0"><input class="form-control form-control-user" type="password" id="Password" placeholder="Пароль" name="password"></div>
                                    <div class="col-sm-6"><input class="form-control form-control-user" type="password" id="Password2" placeholder="Подтверждение пароля"></div>
                                </div><button class="btn btn-primary d-block btn-user w-100" type="submit">Регистрация</button>
                            </form>
                            <div class="text-center"></div>
                            <div class="text-center" style="margin: 10px;"><a class="small" href="login.php" style="margin: 0px;">Войти</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/theme.js"></script>
</body>

</html>