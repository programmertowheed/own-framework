<nav class="sidebar" id="sidebar">
    <button id="sidebar-toggle" class="sidebar-toggle">
        <i class="fa-solid fa-bars"></i>
    </button>
    <?php
    $cookie = getCookie(USER_COOKIE_NAME);
    ?>
    <h1 class="sidebar-logo">Elephant</h1>
    <div class="inline-flex items-center mt-5">
        <img src="<?= assets("backend/assets/avatar.png") ?>" alt="avatar" class="sidebar-avatar"/>
        <div class="sidebar-user"
             style="font-size:16px"><?= isset($cookie->name) ? $cookie->name : "" ?></div>
    </div>
    <ul class="mt-6 px-1">
        <?php //if (canAccess("view.dashboard")) { ?>
        <li class="mb-1">
            <a href="<?= url("/dashboard") ?>" class="sidebar-item act">
                <div class="sidebar-icon">
                    <i class="fa-solid fa-gauge"></i>
                </div>
                <div class="sidebar-item-text">Dashboard</div>
            </a>
        </li>
        <?php //} ?>
        <li class="mb-1 dd-toggle">
            <button class="sidebar-item px-2">
                <div class="sidebar-icon">
                    <i class="fa-solid fa-fingerprint"></i>
                </div>
                <div class="sidebar-item-text">
                    <div>Privacy</div>
                    <div class="dd-icon">
                        <i class="fa-solid fa-chevron-right"></i>
                    </div>
                </div>
            </button>
            <ul class="dd-item">
                <!--                                <li>-->
                <!--                                    <a href="-->
                <? // //= url("/create/user") ?><!--" class="dd-link">-->
                <!--                                        <i class="fa-solid fa-plus"></i>Create User</a-->
                <!--                                    >-->
                <!--                                </li>-->
                <?php if (canAccess("change.password")) { ?>
                    <li>
                        <a
                                href="<?= url("/change/password") ?>"
                                class="dd-link"
                        >
                            <i class="fa-solid fa-key"></i>Change Password</a
                        >
                    </li>
                <?php } ?>
                <li>
                    <a
                            href="<?= url("/permission/list") ?>"
                            class="dd-link"
                    >
                        <i class="fa-solid fa-key"></i>Permission</a
                    >
                </li>
                <li>
                    <a
                            href="<?= url("/role/list") ?>"
                            class="dd-link"
                    >
                        <i class="fa-solid fa-key"></i>Role</a
                    >
                </li>
                <li>
                    <a
                            href="<?= url("/add/user/role") ?>"
                            class="dd-link"
                    >
                        <i class="fa-solid fa-key"></i>User Role</a
                    >
                </li>
                <li>
                    <a
                            href="<?= url("/add/user/permission") ?>"
                            class="dd-link"
                    >
                        <i class="fa-solid fa-key"></i>User permission</a
                    >
                </li>
            </ul>
        </li>
        <li class="mb-1">
            <a href="#" onclick="return false" id="handleLogout" class="sidebar-item">
                <div class="sidebar-icon">
                    <i class="fa-solid fa-right-from-bracket"></i>
                </div>
                <div class="sidebar-item-text">Logout</div>
            </a>
        </li>
    </ul>
    <div class="mt-auto">
        <div class="mb-1 dd-toggle">
            <div class="dd-item-bottom">
                <div class="change-theme-box">
                    <button
                            class="theme-color-icon"
                            title="light"
                            onclick="setTheme('light', event)"
                    >
                        <div class="bg-[#4A00FF] w-1/2 h-full"></div>
                        <div class="bg-[#fff] w-1/2 h-full"></div>
                    </button>
                    <button
                            class="theme-color-icon"
                            title="emerald"
                            onclick="setTheme('emerald', event)"
                    >
                        <div class="bg-[#66CC8A] w-1/2 h-full"></div>
                        <div class="bg-[#fff] w-1/2 h-full"></div>
                    </button>
                    <button
                            class="theme-color-icon"
                            title="cmyk"
                            onclick="setTheme('cmyk', event)"
                    >
                        <div class="bg-[#45AEEE] w-1/2 h-full"></div>
                        <div class="bg-[#fff] w-1/2 h-full"></div>
                    </button>
                    <button
                            class="theme-color-icon"
                            title="bumblebee"
                            onclick="setTheme('bumblebee', event)"
                    >
                        <div class="bg-[#FFD900] w-1/2 h-full"></div>
                        <div class="bg-[#fff] w-1/2 h-full"></div>
                    </button>
                    <button
                            class="theme-color-icon"
                            title="lofi"
                            onclick="setTheme('lofi', event)"
                    >
                        <div class="bg-[#0D0D0D] w-1/2 h-full"></div>
                        <div class="bg-[#fff] w-1/2 h-full"></div>
                    </button>
                    <button
                            class="theme-color-icon"
                            title="dark"
                            onclick="setTheme('dark', event)"
                    >
                        <div class="bg-[#4A00FF] w-1/2 h-full"></div>
                        <div class="bg-[#000] w-1/2 h-full"></div>
                    </button>
                    <button
                            class="theme-color-icon"
                            title="coffee"
                            onclick="setTheme('coffee', event)"
                    >
                        <div class="bg-[#DB924B] w-1/2 h-full"></div>
                        <div class="bg-[#181017] w-1/2 h-full"></div>
                    </button>
                    <button
                            class="theme-color-icon"
                            title="dracula"
                            onclick="setTheme('dracula', event)"
                    >
                        <div class="bg-[#FF79C6] w-1/2 h-full"></div>
                        <div class="bg-[#000] w-1/2 h-full"></div>
                    </button>
                    <button
                            class="theme-color-icon"
                            title="synthwave"
                            onclick="setTheme('synthwave', event)"
                    >
                        <div class="bg-[#E779C1] w-1/2 h-full"></div>
                        <div class="bg-[#170D36] w-1/2 h-full"></div>
                    </button>
                    <button
                            class="theme-color-icon"
                            title="forest"
                            onclick="setTheme('forest', event)"
                    >
                        <div class="bg-[#1EB854] w-1/2 h-full"></div>
                        <div class="bg-[#110C0C] w-1/2 h-full"></div>
                    </button>
                    <button
                            class="theme-color-icon"
                            title="aqua"
                            onclick="setTheme('aqua', event)"
                    >
                        <div class="bg-[#09ECF3] w-1/2 h-full"></div>
                        <div class="bg-[#294B88] w-1/2 h-full"></div>
                    </button>
                </div>
            </div>
            <button class="sidebar-item px-2">
                <div class="sidebar-icon">
                    <i class="fa-solid fa-paint-roller"></i>
                </div>
                <div class="sidebar-item-text">
                    <div>Change Theme</div>
                    <div class="dd-icon-bottom">
                        <i class="fa-solid fa-chevron-right"></i>
                    </div>
                </div>
            </button>
        </div>
    </div>
</nav>

<script>
    // User logout
    const logout = document.getElementById('handleLogout');
    const handleLogout = () => {
        deleteCookie("<?= USER_COOKIE_NAME ?>")
        Swal.fire({
            icon: "success",
            title: "Successfully logout",
            showConfirmButton: false,
            timer: 1500
        });
        setTimeout(function () {
            window.location.href = "<?= url(HOME) ?>";
        }, 500)
    }
    logout.addEventListener("click", handleLogout)
</script>