<!--Header-->
<?php includes("backend.partials.header", ["page_title" => "Create role"]) ?>

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
            <div class="w-full flex items-center" style="justify-content: space-between">
                <h1 class="text-2xl font-bold">Role List</h1>
                <a href="<?= route('/role/list') ?>" class="btn btn-primary">Role List</a>
            </div>
            <form>
                <div class="flex items-end gap-2 flex-wrap">
                    <label class="form-control w-1/2 min-w-[200px]">
                        <div class="label">
                            <span class="label-text">Role Name</span>
                        </div>
                        <input
                                type="text"
                                placeholder="Enter role name"
                                class="custom-input"
                                id="name"
                                autocomplete="off"
                        />
                        <input
                                type="hidden"
                                class="custom-input"
                                id="edit_id"
                        />
                    </label>
                    <div class="flex gap-1 mt-3" style="margin-left: 10px">
                        <button id="handleSubmit" class="btn btn-primary" type="submit">Save</button>
                        <button id="reset" class="btn btn-neutral" type="reset">Clear</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="bg-base-100 p-3 sm:p-6 rounded-xl shadow-md mt-5">
            <div class="overflow-x-auto">
                <div class="form-group">
                    <div class="flex mb-2 w-full flex-end">
                        <h1 class="text-2xl mb-3 font-bold">Permission</h1>
                    </div>
                    <div>
                        <input type="checkbox" class="cursor-pointer" id="checkPermissionAll"
                               value="1">
                        <label style="font-size: 18px; margin-left: 5px" class="cursor-pointer"
                               for="checkPermissionAll">All</label>
                    </div>
                    <hr class="mb-4">
                    <?php
                    $i = 1;
                    foreach ($permission_groups as $group) {

                        ?>
                        <div class="w-full flex">
                            <div>
                                <div style="width: 175px">
                                    <input type="checkbox" class="cursor-pointer"
                                           id="<?= $i ?>Management"
                                           value="<?= $group['group_name'] ?>"
                                           onclick="checkPermissionByGroup('role-<?= $i ?>-management-checkbox','<?= $group['group_name'] ?>', this)">
                                    <label class="cursor-pointer"
                                           for="<?= $i ?>Management"><?= $group['group_name'] ?></label>
                                </div>
                            </div>

                            <div class="w4/6 role-<?= $i ?>-management-checkbox">
                                <?php
                                $j = 1;
                                foreach ($permissions as $permission) {
                                    if ($permission['group_name'] == $group['group_name']) {
                                        ?>
                                        <div>
                                            <input type="checkbox" class="cursor-pointer"
                                                   name="permissions[]"
                                                   id="checkPermission<?= $permission['id'] ?>"
                                                   value="<?= $permission['name'] ?>"
                                                   onclick="checkSinglePermission('role-<?= $i ?>-management-checkbox','<?= $i ?>Management','<?= $group['groupTotal'] ?>','<?= $permission['id'] ?>', this)">
                                            <label class="cursor-pointer"
                                                   for="checkPermission<?= $permission['id'] ?>"><?= $permission['name'] ?></label>
                                        </div>
                                        <?php
                                    }
                                    $j++;
                                }
                                ?>
                                <br>
                            </div>

                        </div>
                        <?php $i++;
                    } ?>
                </div>
            </div>

        </div>
    </div>
</div>

<!--Javascript script-->
<?php includes("backend.partials.script"); ?>

<script type="text/javascript">

    let allPermissions = <?= json_encode($permissions) ?>;
    let permissions = [];

    $(document).ready(function () {
        $('#alert').hide();
        $('#danger-alert').hide();

        $('#checkPermissionAll').click(function () {
            if ($(this).is(':checked')) {
                // check all the checkbox
                $('input[type=checkbox]').prop('checked', true);
                setPermission(<?= json_encode($permissions) ?>)
            } else {
                // un check all the checkbox
                $('input[type=checkbox]').prop('checked', false);
                setPermission([]);
            }
        });
    });

    const checkPermissionByGroup = (className, groupName, checkThis) => {
        const groupIdName = $("#" + checkThis.id);
        const classCheckBox = $('.' + className + ' input');

        if (groupIdName.is(':checked')) {
            classCheckBox.prop('checked', true);
            setGroupPermission(groupName, true);
        } else {
            classCheckBox.prop('checked', false);
            setGroupPermission(groupName, false);
        }
        implementAllChecked();
    }

    const checkSinglePermission = (groupClassName, groupID, countTotalPermission, id, checkThis) => {
        const classCheckbox = $('.' + groupClassName + ' input');
        const groupIDCheckBox = $("#" + groupID);
        const permissionIdName = $("#" + checkThis.id);

        if (permissionIdName.is(':checked')) {
            setSinglePermission(id, true);
        } else {
            setSinglePermission(id, false);
        }

        // if there is any occurance where something is not selected then make selected = false
        if ($('.' + groupClassName + ' input:checked').length == countTotalPermission) {
            groupIDCheckBox.prop('checked', true);
        } else {
            groupIDCheckBox.prop('checked', false);
        }
        implementAllChecked();
    }

    const implementAllChecked = () => {
        const countPermissions = <?= count($permissions)?>;
        const countPermissionGroups = <?=  count($permission_groups)?>;

        if ($('input[type="checkbox"]:checked').length >= (countPermissions + countPermissionGroups)) {
            $("#checkPermissionAll").prop('checked', true);
        } else {
            $("#checkPermissionAll").prop('checked', false);
        }
    }

    const setPermission = (value) => {
        let newVal = [];
        if (value) {
            value.forEach((el) => {
                newVal.push(el.id);
            })
        }
        permissions = newVal;
    }

    const setGroupPermission = (groupName, attach = false) => {
        if (attach) {
            allPermissions.forEach((el) => {
                if (el.group_name == groupName) {
                    if (!permissions.includes(el.id)) {
                        permissions.push(el.id);
                    }
                }
            });
        } else {
            allPermissions.forEach((el) => {
                if (el.group_name == groupName) {
                    permissions = permissions.filter(item => item != el.id);
                }
            });
        }
    }

    const setSinglePermission = (id, attach = false) => {
        if (attach) {
            if (!permissions.includes(id)) {
                permissions.push(id);
            }
        } else {
            permissions = permissions.filter(item => item != id);
        }
    }

    // Clear form input field
    const ClearFields = () => {
        $('#alert').hide();
        $('#danger-alert').hide();

        $('#name').val("");
        permissions = [];
        $('input[type=checkbox]').prop('checked', false);
    }

    // Handle reset function
    $('#reset').click(function (e) {
        e.preventDefault();
        ClearFields();
    });

    // Handle submit function
    $('#handleSubmit').click(function (e) {
        e.preventDefault();
        $('#alert').hide();
        $('#danger-alert').hide();
        $("#handleSubmit").prop("disabled", true);

        let name = $('#name').val();

        const formData = {
            "name": name,
            "permissions": permissions
        }

        if (name == "") {
            $("#handleSubmit").prop("disabled", false);
            $('#danger-alert').show();
            $('#danger-alert').html('Role name must not be empty!');
        } else if (permissions == "") {
            $("#handleSubmit").prop("disabled", false);
            $('#danger-alert').show();
            $('#danger-alert').html('Permission must not be empty!');
        } else {
            axios.post("<?= API_URL ?>/store/role-permission", formData).then(function (response) {
                if (response.data.status) {
                    $("#handleSubmit").prop("disabled", false);
                    ClearFields();
                    $('#danger-alert').hide();
                    $('#alert').show();
                    $('#alert').html(response.data.message);
                } else {
                    $("#handleSubmit").prop("disabled", false);
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
