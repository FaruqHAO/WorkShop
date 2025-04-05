<div id="manageuserspage">
    <div class="card">
        <div class="card-header">
            <h2 class="h6 text-uppercase mb-0 font-weight-bold text-center"> Impact of Service List </h2>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-4">
                    <div class="form-group ">
                    </div>
                </div>  
                <div class="col-4"></div>
                <div class="col-4">
                    <button class=" btn btn-primary" id="Addnewimpact">Add New District</button>
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
                                <th>S.N</th>
                                <th>Title</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="editprojectmodal" class="modal fade modal-xl" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit District</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="#" method="POST" id="projectform" >
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="">Title</label>
                                <input type="text" id="title" class="form-control" name="title" placeholder="Enter title of District" required="">
                            </div>
                        </div> 
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<script>
    $(function () {
        pagename("District");
        $("#Addnewimpact").on("click", function () {
            pagenav("adddistrict");
        });
        var workshoplistdatatable;
        var formdata = new FormData();
        formdata.append('action', "fetchalldistrict");
        $.ajax({
            url: 'process/server.php',
            type: 'post',
            data: formdata,
            contentType: false,
            processData: false,
            success: function (feedback) {
                feedback = JSON.parse(feedback);
                if (feedback.response === true) {
                    workshoplistdatatable = $("#abouttable").DataTable({
                        retrieve: true,
                        responsive: true,
                        paging: true,
                        data: feedback.districtlist,
                        columns: [
                            {data: 'id'},
                            {data: 'title'},
                            {data: feedback.districtlist,
                                render: function (data, type, row) {
                                    return "<span class=''>\n\
                                            <a class='text-info editconference' id='" + row.id + "' data-toggle='modal' data-target='#edit_leave'><span class='mdi mdi-square-edit-outline mdi-20px'></span></a>\n\
                                            \n\
                                            <a class='text-danger deletenews' id='" + row.id + "' data-toggle='modal' data-target='#delete_approve'><span class='mdi mdi-delete-forever-outline mdi-20px'></span></a>\n\
                                      </span>";
                                }
                            }
                        ]
                    });


//                    //Edit conference info   
                    $(".editconference").on("click", function () {
                        $(".close").on('click', function () {
                            $("#editprojectmodal").modal('hide');
                        });
                        var projectid = $(this).attr('id');
                        $.post("process/server.php", {
                            action: "fetchdistrictdetail",
                            projectid: projectid
                        }, function (feedback) {
                            feedback = JSON.parse(feedback);
                            if (feedback.response === true) {
                                $("#editprojectmodal").modal('show');
                                $.each(feedback.districtdetail, function (key, value) {
                                    $("#title").val(value.title);
                                });
                                $('#title').on('change', function () {
                                    if ($(this).val() === '') {
                                        $(this).notify('This field needs data', 'info');
                                    } else {
                                        var columnname = $(this).attr('name');
                                        var dbvalue = $(this).val();
                                        $.post("process/server.php", {
                                            action: "updatedistrictdetails",
                                            projectid: projectid,
                                            columnname: columnname,
                                            result: dbvalue
                                        }, function (feedback) {
                                            feedback = JSON.parse(feedback);
                                            if (feedback.response === true) {
                                                $.notify("Update Successful!", 'success');
                                                $("#editprojectmodal").modal('hide');
                                                pagenav("district");
                                            } else if (feedback.response === false) {
                                                swal({
                                                    title: "Error Generated",
                                                    text: "Unable to Update District Details",
                                                    icon: "error",
                                                    button: false,
                                                    timer: 5000
                                                });
                                            } else if ((feedback.response === false) && (feedback.error.length > 0)) {
                                                swal({
                                                    title: "Error Generated",
                                                    text: "Unable to Update District Details",
                                                    icon: "error",
                                                    button: false,
                                                    timer: 5000
                                                });
                                            }
                                        });
                                    }
                                });
                            } else if (feedback.response === false) {
                                swal({
                                    title: "Error Generated",
                                    text: "Unable to Fetch Impact Details",
                                    icon: "error",
                                    button: false,
                                    timer: 5000
                                });
                            } else if ((feedback.response === false) && (feedback.error.length > 0)) {
                                swal({
                                    title: "Error Generated",
                                    text: "Unable to Fetch Details",
                                    icon: "error",
                                    button: false,
                                    timer: 5000
                                });
                            }

                        });
                    });
////                delecting user details
                    $(".deletenews").on("click", function () {
                        var newsid = $(this).attr('id');
                        swal({
                            title: "You are about to delete this District?",
                            icon: "warning",
                            buttons: true,
                            dangerMode: true
                        }).then((willDelete) => {
                            if (willDelete) {
                                $.post("process/server.php", {
                                    action: "deletedistrict",
                                    projectid: newsid
                                }, function (feedback) {
                                    feedback = JSON.parse(feedback);
                                    if (feedback.response === true) {
                                        swal({
                                            title: "Successful",
                                            text: "District deleted",
                                            icon: "success",
                                            button: true
                                        }).then((result) => {
                                            if (result === true) {
                                                pagenav("district");
                                            }
                                        });
                                    } else if (feedback.response === false) {
                                        swal({
                                            title: "Error Generated",
                                            text: "Unable to delete District",
                                            icon: "error",
                                            button: false,
                                            timer: 5000
                                        });
                                    } else if ((feedback.response === false) && (feedback.error.length > 0)) {
                                        swal({
                                            title: "Error Generated",
                                            text: "Unable to delete District",
                                            icon: "error",
                                            button: false,
                                            timer: 5000
                                        });
                                    }
                                });
                            } else {

                            }
                        })
                    });
                    //adding new artist.

                } else if (feedback.response === false) {
                    swal({
                        title: "Error Generated",
                        text: "Unable to Fetch District List",
                        icon: "error",
                        button: false,
                        timer: 5000
                    });
                    //                    swal("Error Generated", "User Not Signed In", "error");

                } else if ((feedback.response === false) && (feedback.error.length > 0)) {
                    swal({
                        title: "Error Generated",
                        text: "Unable to Fetch District List",
                        icon: "error",
                        button: false,
                        timer: 5000
                    });
                }

            }
        });
    });


</script>
