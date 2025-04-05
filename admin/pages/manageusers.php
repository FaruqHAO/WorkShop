<div id="manageuserspage">
    <div class="card">
        <div class="card-header">
            <h2 class="h6 text-uppercase mb-0 font-weight-bold text-center"> Users List </h2>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-4">
                    <div class="form-group ">
                    </div>
                </div>  
                <div class="col-4"></div>
                <div class="col-4">
                    <button class=" btn btn-primary" id="Addnewimpact">Add New User</button>
                </div>
            </div>
        </div>
        <br><br>
        <div class="row">
            <div class="col-11 m-auto ">
                <div class="form-group border border-light" >
                    <table class=" table table-striped table-hover table-wrapper"style="width: 100%" id="abouttable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Full Name</th>
                                <th>Contact</th>
                                <th>Email</th>
                                <th>Registration Type</th>
                            </tr>
                        </thead>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {
        pagename("Members");
        $("#Addnewimpact").on("click", function () {
            pagenav("addmembers");
        });
        var workshoplistdatatable;
        var formdata = new FormData();
        formdata.append('action', "fetchallmember");
        $.ajax({
            url: '../process/server.php',
            type: 'post',
            data: formdata,
            contentType: false,
            processData: false,
            success: function (feedback) {
                feedback = JSON.parse(feedback);
                console.log(feedback);
                if (feedback.response === true) {
                    workshoplistdatatable = $("#abouttable").DataTable({
                        retrieve: true,
                        responsive: true,
                        paging: true,
                        data: feedback.governancelist,
                        dom: 'Bfrtip',
                        buttons: [
                            'copy', 'excel', 'pdf','print'
                        ],
                        columns: [
                            {data: 'regid'},
                            {data: feedback.governancelist,
                                render: function (data, type, row) {
                                    return row.firstname + row.middlename + row.lastname;
                                }
                            },
                            {data: 'contact'},
                            {data: 'email'},
                            {data: feedback.governancelist,
                                render: function (data, type, row) {
                                    if (row.certificate === '0') {
                                        return "Certificate";
                                    } else {
                                        return"No Certificate";
                                    }

                                }
                            }
                        ]
                    });
                } else if (feedback.response === false) {
                    swal({
                        title: "Error Generated",
                        text: "Unable to Fetch Members List",
                        icon: "error",
                        button: false,
                        timer: 5000
                    });
                } else if ((feedback.response === false) && (feedback.error.length > 0)) {
                    swal({
                        title: "Error Generated",
                        text: "Unable to Fetch Members List",
                        icon: "error",
                        button: false,
                        timer: 5000
                    });
                }


            }
        });
    });

</script>
