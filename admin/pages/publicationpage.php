<div id="manageuserspage">
    <div class="card">
        <div class="card-header">
            <h2 class="h6 text-uppercase mb-0 font-weight-bold text-center"> Publication List </h2>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-4">
                    <div class="form-group ">
                    </div>
                </div>  
                <div class="col-4"></div>
                <div class="col-4">
                    <button class=" btn btn-primary" id="Addnewproject">Add Publication</button>
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
                                <th>File</th>
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
                <h5 class="modal-title">Edit Publication</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="#" method="POST" id="editnewsform" >
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="">Title</label>
                                <input type="text" id="Title" class="form-control" name="title" placeholder="the title of the news item" required="">
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
        pagename("Publication");
        $("#Addnewproject").on("click", function () {
            pagenav("addnewpublication");
        });
        var newslistdatatable;
        var formdata = new FormData();
        formdata.append('action', "fetchallpublication");
        $.ajax({
            url: 'process/server.php',
            type: 'post',
            data: formdata,
            contentType: false,
            processData: false,
            success: function (feedback) {
                feedback = JSON.parse(feedback);
                if (feedback.response === true) {
                    newslistdatatable = $("#abouttable").DataTable({
                        retrieve: true,
                        responsive: true,
                        paging: true,
                        data: feedback.publicationlist,
                        columns: [
                            {data: 'id'},
                            {data: 'title'},
                            {data: feedback.publicationlist,
                                render: function (data, type, row) {
                                    return "<span class=''>\n\
                                            <a class='text-info downloadcertificate' href='process/publication/" + row.file + "' id='" + row.file + "' data-toggle='modal' data-target='#edit_leave'><span class='mdi mdi-download-outline mdi-24px'></span></a>\n\
                                      </span>";
                                }
                            },
                            {data: feedback.publicationlist,
                                render: function (data, type, row) {
                                    return "<span class=''>\n\
                                            <a class='text-info editproject' id='" + row.id + "' data-toggle='modal' data-target='#edit_leave'><span class='mdi mdi-square-edit-outline mdi-24px'></span></a>\n\
                                            \n\
                                            <a class='text-danger deletenews' name='" + row.file + "' id='" + row.id + "' data-toggle='modal' data-target='#delete_approve'><span class='mdi mdi-delete-forever-outline mdi-24px'></span></a>\n\
                                      </span>";
                                }
                            }
                        ]
                    });
                    $(".downloadcertificate").on('click', function () {
                        var fileid = $(this).attr('id');
                        downloadFile("process/publication/" + fileid);
                    });
//                    //Edit user info   
                    $(".editproject").on("click", function () {
                        var projectid = $(this).attr('id');
                        $.post("process/server.php", {
                            action: "fetchprojectdetail",
                            projectid: projectid
                        }, function (feedback) {
                            feedback = JSON.parse(feedback);
                            if (feedback.response === true) {
                                $("#editprojectmodal").modal('show');
                                $.each(feedback.projectlistdetail, function (key, value) {
                                    $('#Title').val(value.title);
                                   
//                                    $('#uploadproject').val(value.upload);
                                });
                                $('#Title').on('change', function () {
                                    if ($(this).val() === '') {
                                        $(this).notify('This field needs data', 'info');
                                    } else {
                                        var columnname = $(this).attr('name');
                                        var dbvalue = $(this).val();
                                        $.post("process/server.php", {
                                            action: "updatepublicationdetails",
                                            projectid: projectid,
                                            columnname: columnname,
                                            result: dbvalue
                                        }, function (feedback) {
                                            feedback = JSON.parse(feedback);
                                            if (feedback.response === true) {
                                                $.notify("Update Successful!", 'success');
                                                $("#editprojectmodal").modal('hide');
                                                pagenav("projectpage");
                                            } else if (feedback.response === false) {
                                                swal({
                                                    title: "Error Generated",
                                                    text: "Unable to Update Project Details",
                                                    icon: "error",
                                                    button: false,
                                                    timer: 5000
                                                });
                                            } else if ((feedback.response === false) && (feedback.error.length > 0)) {
                                                swal({
                                                    title: "Error Generated",
                                                    text: "Unable to Update Project Details",
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
                                    text: "Unable to Fetch News Details",
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
                        var filename = $(this).attr('name');
                        swal({
                            title: "You are about to delete this Publication?",
                            icon: "warning",
                            buttons: true,
                            dangerMode: true
                        }).then((willDelete) => {
                            if (willDelete) {
                                $.post("process/server.php", {
                                    action: "deletepublication",
                                    projectid: newsid,
                                    filename:filename
                                }, function (feedback) {
                                    feedback = JSON.parse(feedback);
                                    if (feedback.response === true) {
                                        swal({
                                            title: "Successful",
                                            text: "Project deleted",
                                            icon: "success",
                                            button: true
                                        }).then((result) => {
                                            if (result === true) {
                                                pagenav("projectpage");
                                            }
                                        });
                                    } else if (feedback.response === false) {
                                        swal({
                                            title: "Error Generated",
                                            text: "Unable to delete News",
                                            icon: "error",
                                            button: false,
                                            timer: 5000
                                        });
                                    } else if ((feedback.response === false) && (feedback.error.length > 0)) {
                                        swal({
                                            title: "Error Generated",
                                            text: "Unable to delete News",
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
                        text: "Unable to Fetch Project List",
                        icon: "error",
                        button: false,
                        timer: 5000
                    });
                    //                    swal("Error Generated", "User Not Signed In", "error");

                } else if ((feedback.response === false) && (feedback.error.length > 0)) {
                    swal({
                        title: "Error Generated",
                        text: "Unable to Fetch Project List",
                        icon: "error",
                        button: false,
                        timer: 5000
                    });
                    console.log("Error Generated " + userdata.error);
                }

            }
        });
    });
    function downloadFile(filepath) {
        window.location.href = filepath;
    }

</script>
