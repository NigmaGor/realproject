<nav class="navbar navbar-dark align-items-start sidebar sidebar-dark accordion bg-gradient-primary p-0">
            <div class="container-fluid d-flex flex-column p-0">
                <hr class="sidebar-divider my-0">
                <ul class="navbar-nav text-light" id="accordionSidebar">
                    <li class="nav-item"><a class="nav-link" id="chat" href="chat.php"><i class="far fa-comments"></i><span>Чат</span></a></li>
                    <li class="nav-item"><a class="nav-link" id="profile" href="profil.php"><i class="fas fa-user"></i><span>Профиль</span></a></li>
                    <li class="nav-item"><a class="nav-link" id="projects" href="projects.php"><i class="fas fa-table"></i><span>Проекты</span></a></li>
                    <li class="nav-item"></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php"><i class="fas fa-user-circle"></i><span>Выход</span></a></li>
                </ul>
                <div class="text-center d-none d-md-inline"></div>
            </div>
        </nav>
<script>
function getActive(title)
{
    el = document.getElementById(title);
    el.classList.add("active");
}
getActive("<?php echo $title_page;?>");
</script>