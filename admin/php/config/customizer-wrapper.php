<div class="customizer-wrapper">
    <div class="customizer">
        <div class="customizer__head">
            <h4 class="customizer__title">Personalizează</h4>
            <span class="customizer__sub-title">Personalizați aspectul paginii</span>
            <a href="#" class="customizer-close">
                <img class="svg" src="img/svg/x2.svg" alt>
            </a>
        </div>
        <div class="customizer__body">

            <div class="customizer__single">
                <h4>Temă Pagină Administrator</h4>
                <ul class="customizer-list d-flex l_sidebar">
                    <li class="customizer-list__item">
                        <a href="#" data-layout="light" class="dark-mode-toggle <?php if ($_SESSION['theme'] == 'light')
                            echo 'active'; ?>" onclick="saveSession('light', '<?= $_SESSION['Navbar_type'] ?>');"
                            id="light">
                            <img src="img/light.png" alt>
                            <i class="fa fa-check-circle"></i>
                        </a>
                    </li>
                    <li class="customizer-list__item">
                        <a href="#" data-layout="dark" class="dark-mode-toggle <?php if ($_SESSION['theme'] == 'dark')
                            echo 'active'; ?>" onclick="saveSession('dark', '<?= $_SESSION['Navbar_type'] ?>');"
                            id="dark">
                            <img src="img/dark.png" alt>
                            <i class="fa fa-check-circle"></i>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="customizer__single">
                <h4>Tip Bara de navigare</h4>
                <ul class="customizer-list d-flex l_navbar">
                    <li class="customizer-list__item">
                        <a href="#" data-layout="side" class="<?php if ($_SESSION['Navbar_type'] == 'side')
                            echo 'active'; ?>" onclick="saveSession('<?= $_SESSION['theme'] ?>', 'side');" id="side">
                            <img src="img/side.png" alt>
                            <i class="fa fa-check-circle"></i>
                        </a>
                    </li>
                    <li class="customizer-list__item top">
                        <a href="#" data-layout="top" class="<?php if ($_SESSION['Navbar_type'] == 'top')
                            echo 'active'; ?>" onclick="saveSession('<?= $_SESSION['theme'] ?>', 'top');" id="top">
                            <img src="img/top.png" alt>
                            <i class="fa fa-check-circle"></i>
                        </a>
                    </li>
                    <li class="colors"></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
    function saveSession(theme, navbarType) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "php/session/save_session.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
            }
        };
        xhr.send("theme=" + theme + "&navbar_type=" + navbarType);
    }

    function triggerClickEvents() {
        var theme = "<?php echo isset($_SESSION['theme']) ? $_SESSION['theme'] : 'light'; ?>";
        var navbarType = "<?php echo isset($_SESSION['Navbar_type']) ? $_SESSION['Navbar_type'] : 'side'; ?>";

        if (theme === "dark") {
            document.getElementById('dark').click();
        } else if (theme === "light") {
            document.getElementById('light').click();
        }

        if (navbarType === "side") {
            document.getElementById('side').click();
        } else if (navbarType === "top") {
            document.getElementById('top').click();
        }
    }

    window.addEventListener('load', triggerClickEvents);
</script>
