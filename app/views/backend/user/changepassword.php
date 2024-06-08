<!--Header-->
<?php includes("backend.partials.header", ["page_title" => "Change password"]) ?>

<div class="flex">
    <?php includes("backend.partials.nav"); ?>
    <div class="main-sec">
        <div class="flex w-full justify-center">
            <div class="w-5/6 md:w-4/6 lg:w-3/6 bg-base-100 p-4 sm:p-4 md:p-6 rounded-xl shadow-md">
                <div id="danger-alert" style="display: none"
                     class="flex items-center p-4 mb-7 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800"
                     role="alert">

                </div>

                <div id="alert" style="display: none"
                     class="flex items-center p-4 mb-4 text-sm text-green-800 border border-green-300 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 dark:border-green-800"
                     role="alert">

                </div>
                <h1 class="text-2xl mb-3 font-bold">Change Password</h1>

                <div class="flex items-center gap-2 flex-wrap">

                    <label class="form-control w-full ">
                        <div class="label">
                            <span class="label-text">Current password</span>
                        </div>
                        <input
                                type="password"
                                placeholder="Type here"
                                class="custom-input"
                                id="current_password"
                        />
                    </label>

                    <label class="form-control w-full ">
                        <div class="label">
                            <span class="label-text">New password</span>
                        </div>
                        <input
                                type="password"
                                placeholder="Type here"
                                class="custom-input"
                                id="new_password"
                        />
                    </label>
                    <label class="form-control w-full ">
                        <div class="label">
                            <span class="label-text">Confirm password</span>
                        </div>
                        <input
                                type="password"
                                placeholder="Type here"
                                class="custom-input"
                                id="confirm_password"
                        />
                    </label>

                    <div class="flex w-full gap-1 mt-3">
                        <button class="btn btn-primary" id="handleSubmit" type="button">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!--Javascript script-->
<?php includes("backend.partials.script"); ?>

<script>

    // Handle submit function
    $('#handleSubmit').click(function (e) {
        e.preventDefault();
        $('#alert').hide();
        $('#danger-alert').hide();

        let current_password = $('#current_password').val();
        let new_password = $('#new_password').val();
        let confirm_password = $('#confirm_password').val();

        const formData = {
            "current_password": current_password,
            "new_password": new_password,
            "confirm_password": confirm_password,
            "user_id": userData.user_id,
        }


        if (userData.user_id == "") {
            $('#danger-alert').show();
            $('#danger-alert').html('Login first!');
        }

        if (current_password == "" || new_password == "" || confirm_password == "") {
            $('#danger-alert').show();
            $('#danger-alert').html('Field must not be empty!');
        } else {
            axios.post("<?= API_URL ?>/change/user/password", formData).then(function (response) {
                if (response.data.status) {
                    $('#danger-alert').hide();
                    $('#current_password').val("");
                    $('#new_password').val("");
                    $('#confirm_password').val("");
                    Swal.fire({
                        title: "Success!",
                        text: response.data.message,
                        icon: "success"
                    });
                } else {
                    $('#alert').hide();
                    $('#danger-alert').show();
                    $('#danger-alert').html(response.data.message);
                }
            })
        }
        return false;

    });

</script>

<!--Footer-->
<?php includes("backend.partials.footer"); ?>
