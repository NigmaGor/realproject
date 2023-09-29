<!DOCTYPE html>
<html>
<?php require_once('header.php');?>
<script>
    function change_value(tag, type) {
    var get_page = document.getElementById("get_page").value;
    var get_org = document.getElementById("get_org").value;
    var get_sl = document.getElementById("get_sl").value;
    var get_date = document.getElementById("get_date").value;
    var url = 'projects.php?';
    switch(type) {
        case 1: url += 'org=' + tag.value; break;
        case 2: url += 'sl=' + tag.value; break;
        case 3: if (tag.value!='') url += 'dat=' + encodeURIComponent(tag.value); break;
        case 4: url += 'page=' + tag; break;
    }
    if (get_page != '' && type!=4) {
        url += '&page=' + get_page;
    }
    if (get_org != '' && type!=1) {
        url += '&org=' + get_org;
    }
    if (get_sl != '' && type!= 2) {
        url += '&sl=' + get_sl;
    }
    if (get_date != '3000-01-01' && type!= 3) {
        url += '&dat=' + encodeURIComponent(get_date);
    }
    $("#RootProject").load(url + " #block_project");
    alert(url + " #block_project");
}
</script>
<body id="page-top">
    <div id="wrapper">
    <?php
    $title_page = "projects";
    require_once('left_menu.php');
    ?>
        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">
            <?php
            require_once('top_menu.php');
            require_once('temp_list_projects.php');
            require_once("model/data.php");
            $page = 1;
            $count = 4;
            ?>
                <section>
                        <div class="container py-4 py-xl-5">
                            <div class="row mb-3">
                                <div class="col text-center mx-auto">
                                <div class="d-flex justify-content-left" style="position: absolute;right: 25px;">
                        <a class="btn btn-primary btn-lg" href="project_create.php" <?php if ($_SESSION['id'] == '') echo "hidden";?>>Создать проект</a>
                    </div>
                    <h2>Проекты</h2>
                                    <div class="filter">
                                        <form>
                                            <select onchange="change_value(this,1)">
                                            <option value="0" selected>Все организации</option>
                                                <?php
                                                $org = getOrganizations();                                
                                                foreach ($org as $o)
                                                {
                                                    echo '<option value="'.$o->id.'" ';
                                                    echo '>'.$o->name.'</option>';
                                                }
                                                ?>                                                
                                            </select>
                                        <select onchange="change_value(this,2)">
                                                <option value="0">Любая сложность</option>
                                                <?php
                                                $sl = getSlozhnost();                                            
                                                foreach ($sl as $s)
                                                {
                                                    echo '<option value="'.$s->id.'" ';
                                                    echo '>'.$s->name.'</option>';
                                                }
                                                ?>
                                            </select>
                                            <label style="margin-left: 15px; margin-right: -20px;">Дата сдачи</label>                                            
                                            <input type="date" onchange="change_value(this,3)" style="width: 170px;">
                                        </form>
                                </div>
                            </div>
                        </div>
                        <div id="RootProject">
                            <div id="block_project">
                                <?php                                
                                if ($_GET['page']) $page=$_GET['page'];
                                $org = 0;
                                if ($_GET['org']) $org=$_GET['org'];
                                $sl = 0;
                                if ($_GET['sl']) $sl=$_GET['sl'];
                                $dat = '3000-01-01';
                                if ($_GET['dat']) $dat=$_GET['dat'];
                                $max = getCount($org,$sl,$dat);
                                ?>
                                <input type="hidden" value="<?php echo $_GET['page'];?>" id="get_page">
                                <input type="hidden" value="<?php echo $_GET['org'];?>" id="get_org">
                                <input type="hidden" value="<?php echo $_GET['sl'];?>" id="get_sl">
                                <input type="hidden" value="<?php echo $_GET['dat'];?>" id="get_date">
                                <div class="pagination mb-3">
                                    <span class="arrow" <?php if ($page <= 1) echo 'hidden';?> onclick="change_value('<?php echo ($page-1);?>', 4)">&laquo;</span>
                                    <?php                                    
                                    $prs = getProject($page, $count,$org,$sl,$dat);
                                    for ($i=0; $i<$max/$count; $i++)
                                    {
                                        echo '<button '.($i==$page-1? 'class="active"': '').' onclick="change_value('.($i+1).', 4)">'.($i+1).'</button>';
                                    } 
                                    ?>
                                    <span class="arrow" <?php if ($page >= $max/$count) echo 'hidden';?> onclick="change_value('<?php echo ($page+1);?>', 4)">&raquo;</span>
                                </div>
                        <div class="row gy-4 row-cols-1 row-cols-md-2" >                           
                                <?php
                                foreach ($prs as $pr)
                                    select_list_project($pr->id, $pr->name, $pr->organization, $pr->zadacha, $pr->data_time, $pr->logo);
                                ?>
                        </div>
</div></div>
                    </div>
                </section>
                <style>
    .pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 20px;
        font-size: 16px;
    }
    .pagination button {
        background-color: var(--bs-blue);
        color: white;
        border: none;
        padding: 8px 16px;
        margin: 0 4px;
        cursor: pointer;
    }
    .pagination button:hover {
        background-color: #0654ba;
    }
    .pagination button.active {
        background-color: #0654ba;
        font-weight: bold;
    }
    .pagination .arrow {
        font-weight: bold;
        padding: 8px;
        cursor: pointer;
    }
</style>
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