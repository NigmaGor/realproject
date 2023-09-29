<?php
function select_list_project($id, $name, $org, $task, $data_time, $logo)
{
echo '<div class="col">
    <div class="d-flex flex-column flex-lg-row">
    <div class="col">
        <img class="rounded img-fluid d-block w-100 fit-cover" style="height: 200px;" src="'.($logo!=''? $logo: 'assets/img/no_img.jpg').'">';
        if ($data_time >= 0)
        echo '<div class="text-center mt-2">
        Осталось дней: '.$data_time.'</div>';
    echo '</div>
    <div class="col py-4 py-lg-0 px-lg-4" style="text-align: center;">
        <a class="small" href="map_project.php?pr='.$id.'" style="font-size: 24px;text-align: center;">'.$name.'</a>
        <h4 style="font-size: 22px;">'.$org.' </h4>
        <p style="text-align: center;font-size: 16px;">'.mb_substr($task,0,150).'...</p>
    </div>
</div></div>';
}
?>