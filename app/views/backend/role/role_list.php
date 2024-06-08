<!--Header-->
<?php includes("backend.partials.header", ["page_title" => "Role list"]) ?>

<div class="flex">
    <?php includes("backend.partials.nav"); ?>
    <div class="main-sec">
        <div class="bg-base-100 p-3 sm:p-6 rounded-xl shadow-md mt-5">
            <input type="hidden" id="frm" value=""/>
            <input type="hidden" id="to" value=""/>
            <input type="hidden" id="pno" value=""/>
            <?php
            $params = getParams();
            if (isset($params['error'])) {
                ?>
                <div style="display: block"
                     class="flex items-center p-4 mb-7 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800"
                     role="alert">
                    <?= $params['error'] ?>
                </div>
                <?php
            }
            ?>
            <div id="danger-alert" style="display: none"
                 class="flex items-center p-4 mb-7 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800"
                 role="alert">

            </div>

            <div id="alert" style="display: none"
                 class="flex items-center p-4 mb-4 text-sm text-green-800 border border-green-300 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 dark:border-green-800"
                 role="alert">

            </div>

            <div class="flex mb-2 w-full flex-end">
                <div class="join sm:mr-0 gap-3 flex items-center">
                    <h1 class="text-2xl font-bold">Role List</h1>
                    <a href="<?= route('/role/create') ?>" class="btn btn-primary">Add</a>
                </div>
                <div class="join shadow-md ml-auto mr-auto sm:mr-0">
                    <label class="input input-bordered flex items-center gap-2">
                        <input type="text" class="grow" onkeyup="getRoleList()" id="search" placeholder="Search"/>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor"
                             class="w-4 h-4 opacity-70" style="width: 25px">
                            <path fill-rule="evenodd"
                                  d="M9.965 11.026a5 5 0 1 1 1.06-1.06l2.755 2.754a.75.75 0 1 1-1.06 1.06l-2.755-2.754ZM10.5 7a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0Z"
                                  clip-rule="evenodd"/>
                        </svg>
                    </label>
                </div>
            </div>
            <div class="overflow-x-auto mt-3" id="roleList">
                <table class="table table-zebra">
                    <thead class="bg-base-200 text-base">
                    <tr>
                        <th>SL</th>
                        <th>Name</th>
                        <th>Permissions</th>
                        <th class="text-center">Options</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <th colspan="4" class="text-center">No record found</th>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="flex mb-2 w-full flex-end mt-2">
                <div class="join shadow-md ml-auto mr-auto sm:mr-0" id="paginationList">

                </div>
            </div>
        </div>
    </div>
</div>

<!--Javascript script-->
<?php includes("backend.partials.script"); ?>

<script type="text/javascript">

    // Get role list
    const getRoleList = (frm = "", to = "", pno = "") => {
        let search = $('#search').val();

        const formData = {
            "search": search,
            "from": frm,
            "to": to,
            "page_no": pno
        }

        axios.post("<?= API_URL ?>/get/role/list", formData).then(function (response) {
            if (response.data.status) {
                $('#roleList').html(response.data.data.html)
                $('#paginationList').html(response.data.data.pagination);
                $('#danger-alert').hide();
            }
        })
    }

    $(document).ready(function () {
        getRoleList();
    });


    /* Pagination Next Page */
    const nextPage = (frm, to, pno) => {
        $('#frm').val(frm);
        $('#to').val(to);
        $('#pno').val(pno);
        getPermissionList(frm, to, pno);
        return false;
    }

    /* Start Delete Data*/
    const deletePermission = (id) => {
        Swal.fire({
            title: "Are you sure?",
            text: "You want to delete this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                deleteRecord(id);
            }
        });

        return false;
    }

    const deleteRecord = (delid) => {
        if (delid != "") {
            axios.post("<?= API_URL ?>/delete/role-record", {
                "deleted_id": delid
            }).then(function (response) {
                if (response.data.status == true) {
                    $('#alert').show();
                    $('#alert').html('Record deleted successfully!!!');
                    const frm = $('#frm').val();
                    const to = $('#to').val();
                    const pno = $('#pno').val();
                    getRoleList(frm, to, pno);
                } else {
                    $('#danger-alert').show();
                    $('#danger-alert').html('Record did not deleted. Try again!');
                }
            })
            return false;
        }
    }
    /* End Delete Data*/

</script>


<!--Footer-->
<?php includes("backend.partials.footer"); ?>
