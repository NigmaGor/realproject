<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Login - Brand</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/css/card-3-column-animation-shadows-images.css">
    <link rel="stylesheet" href="assets/css/Filter.css">
    <link rel="stylesheet" href="assets/css/Projects-Grid-Horizontal.css">
    <link rel="stylesheet" href="assets/css/untitled-1.css">
    <link rel="stylesheet" href="assets/css/untitled-2.css">
    <link rel="stylesheet" href="assets/css/untitled.css">
    <script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
</head>

<script> //JavaScript

$(document).ready(function(){ //Ожидаем пока загрузится документ
    $('#user').submit(function(){ //Назначаем обработчик события на форму "user"
        mail = document.getElementById("Email").value;
        pass = document.getElementById("Password").value;
        al = document.getElementById("alert_danger");
        if (mail =='' || pass=='')//Проверка введены ли данные
        {     
            al.hidden = false;
        }         
        else
        {
            data = {mail: mail, pass: pass, method: "log"};//Пакуем в массив все данные, добавляя метод регистрации
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
                            else
                            {
                                al.hidden = false;
                            }
                    }
                    openFile(); // Вызов функции открытия файла
                }
            });
            
        }
        return false;
    });
});
</script>

<body class="bg-gradient-primary">
    <div class="container">
        <div class="row justify-content-center" style="margin-top: 150px;">
            <div class="col-md-4 col-lg-4 col-xl-4">
                <div class="card shadow-lg o-hidden border-0 my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h4 class="text-dark mb-4">Вход</h4>
                                    </div>
                                    <form class="user" id="user" method="POST">
                                        <div class="mb-3"><input class="form-control form-control-user" type="email" id="Email" aria-describedby="emailHelp" placeholder="Электронный адрес" name="email"></div>
                                        <div class="mb-3"><input class="form-control form-control-user" type="password" id="Password" placeholder="Пароль" name="password"></div>
                                        <div class="mb-3">
                                            <div class="custom-control custom-checkbox small"></div>
                                        </div><button class="btn btn-primary d-block btn-user w-100" type="submit">Вход</button>
                                    </form>
                                    <div class="text-center"></div>
                                    <div class="text-center" style="margin: 10px;"><a class="small" href="register.php">Зарегистрироваться</a></div>
                                    <div class="alert alert-danger" id="alert_danger" hidden role="alert"><span><strong>Введены некорректные данные</strong></span></div>
                                </div>
                            </div>
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