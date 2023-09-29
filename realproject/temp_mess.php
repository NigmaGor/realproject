<?php
function chat($mess,$id)
{
              $arr = [
                'января',
                'февраля',
                'марта',
                'апреля',
                'мая',
                'июня',
                'июля',
                'августа',
                'сентября',
                'октября',
                'ноября',
                'декабря'
              ];
              
              // Поскольку от 1 до 12, а в массиве, как мы знаем, отсчет идет от нуля (0 до 11),
              // то вычитаем 1 чтоб правильно выбрать уже из нашего массива.
              
              //$month = date('n')-1;
              //echo $arr[$month].' '.date('d, Y');
              $dat='';
              foreach ($mess as $m)
              {
                  if ($m->data != $dat)
                  {
                      $dat = $m->data;
                      $d = strtotime($dat);
                      echo '<p class="small text-center">'.date('d',$d).' '.$arr[date('m',$d)-1].' '.date('Y',$d).'</p>';
                  }
                  if ($m->id_anketa == $id)
                  {
                    $profile = getProfile($id);
                    vis_mess_my($profile->foto, $profile->name.' '.$profile->family, $m->text, $m->time, $m->docs);
                  }
                  else
                  {
                      $profile=getProfile($m->id_anketa);
                      vis_mess_not_my($profile->foto, $profile->name.' '.$profile->family, $m->text, $m->time, $m->docs);
                  }
              }
}

function vis_mess_my($foto, $name, $text, $time, $docs)
{
    echo '<div class="row w-100">
    <div class="media w-150 mb-3">
    <div class="media-body ml-3" style="float: right;">
      <div class="media" style="display: flex; align-items: center;">
      <img src="'.($foto ? $foto : 'assets/img/no_img.jpg').'" alt="Фото отправителя" class="rounded-circle mr-3" style="width: 50px; height: 50px;">
        <div class="bg-primary rounded py-2 px-3 mb-2">
        <p class="text-small mb-0 text-white">'.$name.'</p>
          <p class="text-small mb-0 text-white">'.$text.'</p>
          <p class="text-small mb-0 text-white">'.$time.'</p>';
          foreach ($docs as $url => $name)
          {
            echo '<a class="text-white" href="'.$url.'" target="_blank">'.$name.'</a>';
          }
        echo '</div>
      </div>
    </div>
    </div>
    </div>';
}

function vis_mess_not_my($foto, $name, $text, $time, $docs)
{
    echo ' <div class="row">
    <div class="media w-75 mb-3">
    <div class="media-body ml-3">
      <div class="media" style="display: flex; align-items: center;">
        <img src="'.($foto ? $foto : 'assets/img/no_img.jpg').'" alt="Фото отправителя" class="rounded-circle mr-3" style="width: 50px; height: 50px;">
        <div class="bg-light rounded py-2 px-3 mb-2">
          <p class="text-small mb-0 text-muted">'.$name.'</p>
          <p class="text-small mb-0 text-muted">'.$text.'</p>
          <p class="text-small mb-0 text-muted">'.$time.'</p>';
          foreach ($docs as $url => $name)
          {
            echo '<a class="text-white" href="'.$url.'" target="_blank">'.$name.'</a>';
          }
        echo ' <!-- Add the time here -->
        </div>
      </div>
    </div>
    </div>
    </div>';
}
?>
