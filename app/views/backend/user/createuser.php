<!--Header-->
<?php includes("backend.partials.header", ["page_title" => "Create user"]) ?>

<div class="flex">
    <?php includes("backend.partials.nav"); ?>
    <div class="main-sec">
        <div class="bg-base-100 p-2 sm:p-4 md:p-6 rounded-xl shadow-md">
            <h1 class="text-2xl mb-3 font-bold">View User List</h1>
            <div class="w-full flex flex-wrap gap-3 items-center mb-3 sm:px-5">
                <button
                        class="btn btn-primary sm:ml-auto"
                        onclick="add_user_modal.showModal()"
                >
                    Add User
                </button>
                <input type="hidden" id="frm" value=""/>
                <input type="hidden" id="to" value=""/>
                <input type="hidden" id="pno" value=""/>
                <div class="join sm:ml-3 shadow-md" id="paginationList">
                </div>
            </div>
            <div class="overflow-x-auto" id="userList">
                <table class="table table-zebra">
                    <!-- head -->
                    <thead class="bg-base-200 text-base">
                    <tr>
                        <th>Name</th>
                        <th>User Name</th>
                        <th>User Type</th>
                        <th class="text-center">Option</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>Some User</td>
                        <td>UserName 122</td>
                        <td>Sales</td>
                        <td>
                            <div class="flex gap-1 items-center justify-center">
                                <button
                                        class="btn bg-base-100 text-sm text-base-content border border-base-300"
                                        type="button"
                                        title="Edit"
                                >
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                <button
                                        class="btn bg-base-100 text-sm text-base-content border border-base-300"
                                        type="button"
                                        title="Delete"
                                >
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <dialog id="add_user_modal" class="modal">
            <div class="modal-box">
                <div id="danger-alert" style="display: none"
                     class="flex items-center p-4 mb-7 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800"
                     role="alert">

                </div>

                <div id="alert" style="display: none"
                     class="flex items-center p-4 mb-4 text-sm text-green-800 border border-green-300 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 dark:border-green-800"
                     role="alert">

                </div>
                <h3 class="font-bold text-lg">Add User</h3>
                <div class="flex items-center gap-2 flex-wrap">
                    <label class="form-control w-full">
                        <div class="label">
                            <span class="label-text">Full Name</span>
                        </div>
                        <input
                                type="text"
                                placeholder="Type here"
                                class="custom-input"
                                id="full_name"
                        />
                    </label>
                    <label
                            class="form-control w-full"
                    >
                        <div class="label">
                            <span class="label-text">Branch Name</span>
                        </div>
                        <select class="custom-select branch_list" id="branch_id">
                            <option disabled selected value="">Pick Branch</option>
                        </select>
                    </label>
                    <label
                            class="form-control w-full relative"
                    >
                        <div class="label">
                            <span class="label-text">Delivery Store</span>
                        </div>
                        <input
                                type="text"
                                placeholder="Type here"
                                class="custom-input"
                                id="delivery-point-input"
                        />
                        <input
                                type="hidden"
                                id="delivery-point-id"
                        />

                        <div class="input-suggestions-dd" id="deliveryPointList">
                            <!-- add all the batch list -->
                            <div class="input-suggestion">Store not found</div>
                        </div>
                    </label>
                    <label class="form-control w-full">
                        <div class="label">
                            <span class="label-text">User Name</span>
                        </div>
                        <input
                                type="text"
                                placeholder="Type here"
                                class="custom-input"
                                id="user_name"
                                onKeyUp="chkUserName(this.value)"
                        />
                        <div id="user_success" style="display: none"
                             class="flex items-center mt-4 text-md text-green-600 dark:text-green-400"
                             role="alert">

                        </div>
                        <div id="user_error" style="display: none"
                             class="flex items-center mt-4 text-md text-red-600 dark:text-red-400"
                             role="alert">

                        </div>
                    </label>
                    <label class="form-control w-full">
                        <div class="label">
                            <span class="label-text">Password</span>
                        </div>
                        <input
                                type="password"
                                placeholder="Type here"
                                class="custom-input"
                                id="user_password"
                        />
                    </label>
                    <label
                            class="form-control w-full"
                    >
                        <div class="label">
                            <span class="label-text">User Type</span>
                        </div>
                        <select class="custom-select user_type_list" id="user_type">
                            <option disabled selected value="">Pick User Type</option>
                        </select>
                    </label>
                    <label
                            class="form-control w-full"
                    >
                        <div class="label">
                            <span class="label-text">User Status</span>
                        </div>
                        <select class="custom-select" id="user_status">
                            <option disabled selected value="">Pick User Status</option>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                        <input type="hidden" name="u_id" class="form-control" id="u_id">
                        <input type="hidden" name="isValid" class="form-control" id="isValid">
                    </label>
                    <div class="flex w-full gap-1 mt-3">
                        <button class="btn btn-primary" id="handleSubmit" type="button">Save</button>
                        <form method="dialog">
                            <button class="btn btn-neutral" onclick="ClearFields()">Cancel</button>
                        </form>
                    </div>
                </div>
            </div>
            <form method="dialog" class="modal-backdrop">
                <button>close</button>
            </form>
        </dialog>
    </div>
</div>

<!--Javascript script-->
<?php includes("backend.partials.script"); ?>

<script type="text/javascript">

    const delivery_point_input = document.getElementById("delivery-point-input");
    var delivery_point_list = document.getElementById("deliveryPointList");
    const delivery_point_id = document.getElementById("delivery-point-id");

    // get all delivery point
    const getAllDeliveryPoint = () => {
        let searchText = delivery_point_input.value;
        axios.post("<?= API_URL ?>/getdeliverypointlist", {
            "searchText": searchText,
            "project_id": userData.project_id
        }).then(function (response) {
            if (response.data.data !== "") {
                delivery_point_list.innerHTML = response.data.data;
            }
        })
    }

    // set delivery point id in input field
    const setDeliveryPointID = (id) => {
        delivery_point_id.value = id;
    }

    // add EventListener on delivery point input
    delivery_point_input.addEventListener("keyup", getAllDeliveryPoint);
    delivery_point_input.addEventListener("click", getAllDeliveryPoint);

    //Get branch list
    const getBranchList = () => {
        axios.post("<?= API_URL ?>/get/branch/list", {
            "project_id": userData.project_id
        }).then(function (response) {
            if (response.data.status) {
                $(".branch_list").html(response.data.data)
            }
        })

    }

    //Get user type list
    const getUserTypeList = () => {
        axios.post("<?= API_URL ?>/get/user/type/list").then(function (response) {
            if (response.data.status) {
                $(".user_type_list").html(response.data.data)
            }
        })

    }

    // Get user list
    const getUserList = (frm = "", to = "", pno = "") => {

        const formData = {
            "project_id": userData.project_id,
            "from": frm,
            "to": to,
            "page_no": pno
        }

        axios.post("<?= API_URL ?>/get/user/list", formData).then(function (response) {
            if (response.data.status) {
                $('#userList').html(response.data.data.html)
                $('#paginationList').html(response.data.data.pagination);
                $('#danger-alert').hide();
            }
        })
    }

    $(document).ready(function () {
        $('#alert').hide();
        $('#danger-alert').hide();
        getUserList();
        getBranchList();
        getUserTypeList();
    });

    // Edit user
    const editUser = (id) => {
        add_user_modal.show();
        if (id != "") {
            axios.post("<?= API_URL ?>/get/user/info", {
                "userid": id
            }).then(function (response) {
                if (response.data.status) {
                    const user = response.data.data;
                    $('#full_name').val(user.fullname);
                    $('#branch_id').val(user.branch_id);
                    $('#delivery-point-id').val(user.store_id);
                    $('#delivery-point-input').val(user.delivery_point_name);
                    $('#user_name').val(user.userid);
                    $('#user_password').val(user.my_key);
                    $('#user_type').val(user.u_type_id);
                    $('#user_status').val(user.status);
                    $('#u_id').val(user.userid);
                    $('#isValid').val(1);
                    $('#alert').show();
                    $('#alert').html('Ready to Edit!');
                }
            })
        } else {
            $('#danger-alert').show();
            $('#danger-alert').html('User ID missing!');
        }
        return false;
    }

    // Clear form input field
    const ClearFields = () => {
        $('#alert').hide();
        $('#danger-alert').hide();
        $('#user_error').hide();
        $('#user_success').hide();

        $('#full_name').val("");
        $('#branch_id').val("");
        $('#delivery-point-id').val("");
        $('#delivery-point-input').val('');
        $('#deliveryPointList').html('');
        $('#user_name').val("");
        $('#user_password').val("");
        $('#user_type').val("");
        $('#user_status').val("");
        $('#isValid').val("");
        $('#u_id').val("");
    }

    // check username
    const chkUserName = (user_name) => {
        const u_id = $('#u_id').val();
        if (user_name != "") {
            axios.post("<?= API_URL ?>/check/user/username", {
                user_name: user_name,
                u_id: u_id
            }).then(function (response) {
                if (response.data.status) {
                    if (response.data.data != "") {
                        $('#user_success').hide();
                        $('#user_error').show();
                        $('#user_error').html("The user name is not available");
                        $('#isValid').val("0");
                    } else {
                        $('#user_error').hide();
                        $('#user_success').show();
                        $('#user_success').html("The user name is available");
                        $('#isValid').val("1");
                    }
                } else {
                    $('#user_success').hide();
                    $('#user_error').show();
                    $('#user_error').html(response.data.message);
                    $('#isValid').val("0");
                }
            })
        } else {
            $('#user_success').hide();
            $('#user_error').hide();
        }
        return false;
    }

    // Handle submit function
    $('#handleSubmit').click(function (e) {
        e.preventDefault();
        $('#alert').hide();
        $('#danger-alert').hide();

        let full_name = $('#full_name').val();
        let branch_id = $('#branch_id').val();
        let store_id = $('#delivery-point-id').val();
        let user_name = $('#user_name').val();
        let user_password = $('#user_password').val();
        let user_type = $('#user_type').val();
        let user_status = $('#user_status').val();
        let isValid = $('#isValid').val();
        let u_id = $('#u_id').val();

        let frm = $('#frm').val();
        let to = $('#to').val();
        let pno = $('#pno').val();

        const formData = {
            "project_id": userData.project_id,
            "created_by": userData.user_id,
            "full_name": full_name,
            "branch_id": branch_id,
            "store_id": store_id,
            "user_name": user_name,
            "user_password": user_password,
            "user_type": user_type,
            "user_status": user_status,
            "u_id": u_id,
            "from": frm,
            "to": to,
            "page_no": pno
        }


        if (full_name == "" || branch_id == "" || store_id == "" || user_name == "" || user_password == "" || user_type == "" || user_status == "" || isValid == "") {
            $('#danger-alert').show();
            $('#danger-alert').html('Field must not be empty!');
        } else {
            axios.post("<?= API_URL ?>/add/user", formData).then(function (response) {
                if (response.data.status) {
                    ClearFields();
                    $('#userList').html(response.data.data.html)
                    $('#paginationList').html(response.data.data.pagination);
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


    /* Pagination Next Page */
    const nextPage = (frm, to, pno) => {
        $('#frm').val(frm);
        $('#to').val(to);
        $('#pno').val(pno);
        getUserList(frm, to, pno);
        return false;
    }

</script>


<!--Footer-->
<?php includes("backend.partials.footer"); ?>
