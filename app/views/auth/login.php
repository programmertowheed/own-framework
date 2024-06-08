<!--Header-->
<?php includes("backend.partials.header", ["page_title" => "Login"]) ?>

<div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">

    <div
            class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
        <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
            <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                Sign in to your account
            </h1>
            <form class="space-y-4 md:space-y-6" id="handleLogin">
                <div>
                    <label for="Email"
                           class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                    <input type="email" name="email" id="email"
                           class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                           placeholder="Email address" value="">
                </div>
                <div>
                    <label for="password"
                           class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                    <input type="password" name="password" id="password" placeholder="••••••••" autocomplete=""
                           value=""
                           class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    >
                </div>
                <div>
                    <button type="submit" id="login"
                            class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                        Sign in
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--Javascript script-->
<?php includes("backend.partials.script"); ?>

<script>
    // User login
    const loginForm = document.getElementById('handleLogin');
    loginForm.onsubmit = (event) => {
        event.preventDefault();

        let email = $('#email').val();
        let password = $('#password').val();

        axios.post("<?= API_URL ?>/login", {email: email, pass: password})
            .then(function (response) {
                if (response.data.status) {
                    setCookie("<?= USER_COOKIE_NAME ?>", JSON.stringify(response.data.data), "<?= USER_COOKIE_TIME ?>");
                    Swal.fire({
                        icon: "success",
                        title: response.data.message,
                        showConfirmButton: false,
                        timer: 1500
                    });
                    setTimeout(function () {
                        window.location.href = "<?= url(DASHBOARD) ?>";
                    }, 500)

                } else {
                    Swal.fire({
                        icon: "error",
                        title: response.data.message,
                        showConfirmButton: false,
                        timer: 1500
                    });
                }

            }).catch(function (err) {
            console.log(err.response);
        });
        return false;

    }

</script>

<!--Footer-->
<?php includes("backend.partials.footer"); ?>

