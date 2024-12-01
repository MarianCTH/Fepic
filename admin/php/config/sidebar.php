<div class="sidebar-wrapper">
    <div class="sidebar sidebar-collapse" id="sidebar">
        <div class="sidebar__menu-group">
            <ul class="sidebar_nav">
                <li>
                    <a href="index.php" <?php if ($current_page == 'Panou Principal')
                        echo 'class="active"'; ?>>
                        <span class="nav-icon uil uil-create-dashboard"></span>
                        <span class="menu-text">Panou Principal</span>
                    </a>
                </li>
                <li>
                    <a href="changelog.php" <?php if ($current_page == 'Changelog')
                        echo 'class="active"'; ?>>
                        <span class="nav-icon uil uil-arrow-growth"></span>
                        <span class="menu-text">Actualizări</span>
                        <?php
                        $query = "SELECT Version FROM changelog ORDER BY Date DESC LIMIT 1";
                        $result = mysqli_query($db, $query);

                        if ($result && mysqli_num_rows($result) > 0) {
                            $row = mysqli_fetch_assoc($result);
                            $latestVersion = $row['Version'];
                            echo '<span class="badge badge-info-10 menuItem rounded-pill">' . $latestVersion . '</span>';
                        }
                        ?>
                    </a>
                </li>
                <li>
                    <a href="activity.php" <?php if ($current_page == 'Activitate')
                        echo 'class="active"'; ?>>
                        <span class="nav-icon uil uil-clipboard"></span>
                        <span class="menu-text">Activitate</span>
                    </a>
                </li>

                <li class="menu-title mt-30">
                    <span>CRUD</span>
                </li>

                <li>
                    <a href="users.php" <?php if ($current_page == 'Listă Utilizatori')
                        echo 'class="active"'; ?>>
                        <span class="nav-icon uil uil-users-alt"></span>
                        <span class="menu-text">Utilizatori</span>
                    </a>
                </li>
                <li>
                    <a href="admin_list.php" <?php if ($current_page == 'Listă Administratori')
                        echo 'class="active"'; ?>>
                        <span class="nav-icon uil uil-user-md"></span>
                        <span class="menu-text">Administratori</span>
                    </a>
                </li>
                <li class="has-child">
                    <a href="#" class>
                        <span class="nav-icon uil uil-envelope"></span>
                        <span class="menu-text">Cereri</span>
                        <span class="toggle-icon"></span>
                    </a>
                    <ul>
                        <li <?php if ($current_page == 'Requests')
                            echo 'class="active"'; ?>>
                            <a href="requests.php">Cereri de contact</a>
                        </li>
                    </ul>
                </li>
                <li class="has-child">
                    <a href="#" class>
                        <span class="nav-icon uil uil-calendar-alt"></span>
                        <span class="menu-text">Evenimente</span>
                        <span class="toggle-icon"></span>
                    </a>
                    <ul>
                        <li <?php if ($current_page == 'Events')
                            echo 'class="active"'; ?>>
                            <a href="events">Listă evenimente</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="chat.php" <?php if ($current_page == 'Chat')
                        echo 'class="active"'; ?>>
                        <span class="nav-icon uil uil-chat"></span>
                        <span class="menu-text">Chat BOT</span>
                    </a>
                </li>
                <li class="menu-title mt-30">
                    <span>Blog</span>
                </li>
                <li>
                    <a href="blogs.php" <?php if ($current_page == 'Postări')
                        echo 'class="active"'; ?>>
                        <span class="nav-icon uil uil-document-layout-left"></span>
                        <span class="menu-text">Postări</span>
                    </a>
                </li>
                <li>
                    <a href="new-post.php" <?php if ($current_page == 'Postare Nouă')
                        echo 'class="active"'; ?>>
                        <span class="nav-icon uil uil-plus-square"></span>
                        <span class="menu-text">Postare nouă</span>
                    </a>
                </li>
                <li class="menu-title mt-30">
                    <span>Pagini</span>
                </li>
                <li>
                    <a href="terms.php" <?php if ($current_page == 'Terms')
                        echo 'class="active"'; ?>>
                        <span class="nav-icon uil uil-question-circle"></span>
                        <span class="menu-text">Termeni și condiții</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>