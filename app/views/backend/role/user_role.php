<!--Header-->
<?php includes("backend.partials.header", ["page_title" => "Assign user role"]) ?>

<div class="flex">
    <?php includes("backend.partials.nav"); ?>
    <div class="main-sec">
        <div class="bg-base-100 p-6 rounded-xl shadow-md">

            <div id="danger-alert" style="display: none"
                 class="flex items-center p-4 mb-7 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800"
                 role="alert">

            </div>

            <div id="alert" style="display: none"
                 class="flex items-center p-4 mb-4 text-sm text-green-800 border border-green-300 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 dark:border-green-800"
                 role="alert">

            </div>
            <h3 class="font-bold text-lg">Edit user role</h3>
            <form>
                <div class="flex flex-wrap items-end gap-2">
                    <label class="form-control w-full min-w-[150px] flex-1">
                        <div class="label">
                            <span class="label-text">User</span>
                        </div>
                        <input
                                type="text"
                                placeholder="User"
                                class="custom-input"
                                id="user"
                                readonly
                                value=""
                        />
                        <input
                                type="hidden"
                                id="userid"
                                value=""
                        />
                    </label>
                    <label class="form-control w-full min-w-[100px] flex-1 select2Parent">
                        <div class="label">
                            <span class="label-text">Roles</span>
                        </div>
                        <select class="custom-select roles" id="roles" multiple="multiple">
                            <?php foreach ($allroles as $role) { ?>
                                <option value="<?= $role['id'] ?>"><?= $role['name'] ?></option>
                            <?php } ?>
                        </select>
                    </label>
                    <button class="btn btn-primary" style="margin-left: 10px" id="handleSubmit" type="button">Update
                    </button>
                </div>
            </form>
        </div>
        <div class="bg-base-100 p-2 sm:p-4 md:p-6 rounded-xl shadow-md mt-5">
            <div class="flex mb-2 w-full flex-end">
                <div class="join sm:mr-0 gap-3 flex items-center">
                    <h1 class="text-2xl font-bold">User List</h1>
                </div>
                <div class="join shadow-md ml-auto mr-auto sm:mr-0">
                    <label class="input input-bordered flex items-center gap-2">
                        <input type="text" class="grow" onkeyup="userRoleList()" id="search" placeholder="Search"/>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor"
                             class="w-4 h-4 opacity-70" style="width: 25px">
                            <path fill-rule="evenodd"
                                  d="M9.965 11.026a5 5 0 1 1 1.06-1.06l2.755 2.754a.75.75 0 1 1-1.06 1.06l-2.755-2.754ZM10.5 7a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0Z"
                                  clip-rule="evenodd"/>
                        </svg>
                    </label>
                </div>
            </div>

            <div class="overflow-x-auto" id="userList">
                <table class="table table-zebra">
                    <!-- head -->
                    <thead class="bg-base-200 text-base">
                    <tr>
                        <th>SL</th>
                        <th>User</th>
                        <th>Role</th>
                        <th class="text-center">Option</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td colspan="4" class="text-center">No record found</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="flex mb-2 w-full flex-end mt-2">
                <input type="hidden" id="frm" value=""/>
                <input type="hidden" id="to" value=""/>
                <input type="hidden" id="pno" value=""/>
                <div class="join shadow-md ml-auto mr-auto sm:mr-0" id="paginationList">

                </div>
            </div>
        </div>
    </div>
</div>

<!--Javascript script-->
<?php includes("backend.partials.script"); ?>

<script type="text/javascript">

    let users = [];

    // Get user role list
    const userRoleList = (frm = "", to = "", pno = "") => {
        let search = $('#search').val();

        const formData = {
            "search": search,
            "from": frm,
            "to": to,
            "page_no": pno
        }

        axios.post("<?= API_URL ?>/get/user-role/list", formData).then(function (response) {
            if (response.data.status) {
                $('#userList').html(response.data.data.html)
                $('#paginationList').html(response.data.data.pagination);
                users = response.data.data.users;

                $('#danger-alert').hide();
            }
        })
    }

    $(document).ready(function () {
        $('#alert').hide();
        $('#danger-alert').hide();

        userRoleList();
        $('.roles').select2({
            width: '100%',
            dropdownParent: $('.select2Parent')
        });
    });

    /* Pagination Next Page */
    const nextPage = (frm, to, pno) => {
        $('#frm').val(frm);
        $('#to').val(to);
        $('#pno').val(pno);
        userRoleList(frm, to, pno);
        return false;
    }

    // Edit user role
    const handleEdit = (userid) => {
        const user = users.find((u) => u.id == userid);
        $("#userid").val(user.id);
        $("#user").val(user.name);

        let selectRole = [];
        user.roles.forEach(el => {
            selectRole.push(el.role_id);
        });

        $('#roles').val(selectRole).trigger('change');
    }

    // Clear field
    const clearField = () => {
        $("#userid").val("");
        $("#user").val("");

        $('#roles').val([]).trigger('change');
    }

    // Handle submit function
    $('#handleSubmit').click(function (e) {
        e.preventDefault();
        $('#alert').hide();
        $('#danger-alert').hide();

        let userid = $('#userid').val();
        let roles = $('#roles').val();

        let frm = $('#frm').val();
        let to = $('#to').val();
        let pno = $('#pno').val();

        const formData = {
            "userid": userid,
            "roles": roles,
            "from": frm,
            "to": to,
            "page_no": pno
        }

        if (userid == "") {
            $('#danger-alert').show();
            $('#danger-alert').html('Please select a user!');
        } else if (roles.length == 0) {
            $('#danger-alert').show();
            $('#danger-alert').html('Please select a role!');
        } else {
            axios.post("<?= API_URL ?>/update-user-role", formData).then(function (response) {
                if (response.data.status) {
                    $('#userList').html(response.data.data.html)
                    $('#paginationList').html(response.data.data.pagination);
                    users = response.data.data.users;

                    clearField();

                    $('#danger-alert').hide();
                    $('#alert').show();
                    $('#alert').html(response.data.message);
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
