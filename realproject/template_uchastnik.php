<?php
function print_uchastnik($id, $name, $last_name, $logo)
{
echo '<div class="media" style="display: flex; align-items: center; margin-bottom: 15px;padding-left: 30px;"> 
        <img src="'.($logo? $logo : 'assets/img/no_img.jpg').'" alt="Фото отправителя" class="rounded-circle mr-3" style="width: 50px; height: 50px;">
        <!--Отображаем имя с фамилией ссылочного типа, чтобы можно было перейти в профиль участника-->
        <div class="row" style="padding-left: 10px;">
            <a href="profil.php?id='.$id.'">'.$name.' '.$last_name.'</a>                              
        </div>
    </div>'; 
}
?>