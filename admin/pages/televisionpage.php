<div id="manageuserspage">
    <div class="card">
        <div class="card-header">
            <h2 class="h6 text-uppercase mb-0 font-weight-bold text-center"> Television List </h2>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-4">
                    <div class="form-group ">
                    </div>
                </div>  
                <div class="col-4"></div>
                <div class="col-4">
                    <button class=" btn btn-primary" id="Addnewimpact">Add New TV</button>
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
                <h5 class="modal-title">Edit Workshop/Conference</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="#" method="POST" id="projectform" >
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="">Title</label>
                                <input type="text" id="title" class="form-control" name="title" placeholder="Enter title of Impact" required="">
                            </div>
                        </div> 
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Image</label>
                                <input type="file" class="form-control" id="uploadproject" required="">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Preview</label>
                                <img  src="" id="bgimg" class="float-right" alt="background image" style="height: 100px; width: 69%">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label for="">Video URL</label>
                                <input type="text" class="form-control" id="video" required="">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="">Description</label>
                                <input type="text" class="form-control" id="description" required="">
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
        pagename("Television");
        $("#Addnewimpact").on("click", function () {
            pagenav("addtelevision");
        });
        var workshoplistdatatable;
        var formdata = new FormData();
        formdata.append('action', "fetchalltv");
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
                        data: feedback.impactlist,
                        columns: [
                            {data: 'id'},
                            {data: 'title'},
                            {data: feedback.impactlist,
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
                            action: "fetchtvdetail",
                            projectid: projectid
                        }, function (feedback) {
                            feedback = JSON.parse(feedback);
                            if (feedback.response === true) {
                                $("#editprojectmodal").modal('show');
                                $.each(feedback.impactdetail, function (key, value) {
                                    $("#bgimg").attr('src', value.image);
                                    $("#title").val(value.title);
                                    $("#video").val(value.videourl);
                                });
                                $('#title,#description,#video').on('change', function () {
                                    if ($(this).val() === '') {
                                        $(this).notify('This field needs data', 'info');
                                    } else {
                                        var columnname = $(this).attr('name');
                                        var dbvalue = $(this).val();
                                        $.post("process/server.php", {
                                            action: "updatetvdetails",
                                            projectid: projectid,
                                            columnname: columnname,
                                            result: dbvalue
                                        }, function (feedback) {
                                            feedback = JSON.parse(feedback);
                                            if (feedback.response === true) {
                                                $.notify("Update Successful!", 'success');
                                                $("#editprojectmodal").modal('hide');
                                                pagenav("televisionpage");
                                            } else if (feedback.response === false) {
                                                swal({
                                                    title: "Error Generated",
                                                    text: "Unable to Update TV Details",
                                                    icon: "error",
                                                    button: false,
                                                    timer: 5000
                                                });
                                            } else if ((feedback.response === false) && (feedback.error.length > 0)) {
                                                swal({
                                                    title: "Error Generated",
                                                    text: "Unable to Update TV Details",
                                                    icon: "error",
                                                    button: false,
                                                    timer: 5000
                                                });
                                            }
                                        });
                                    }
                                });
                                var coverartencodedimage;
                                $("#uploadproject").on('change', function () {
                                    //Get count of selected files
                                    var countFiles = $(this)[0].files.length;
                                    var filesize = this.files[0].size;
                                    var imgPath = $(this)[0].value;
                                    var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
                                    if (extn === "gif" || extn === "png" || extn === "jpg" || extn === "jpeg") {
                                        if (filesize <= 521600) {
                                            $('button[type=submit]').removeAttr('disabled');
                                            $(this).removeClass('border-danger').addClass('border-success');
                                            if (typeof (FileReader) !== "undefined") {
                                                $('button[type=submit]').removeAttr('disabled');
                                                $(this).removeClass('border-danger').addClass('border-success');
                                                //loop for each file selected for uploaded.
                                                for (var i = 0; i < countFiles; i++)
                                                {
                                                    var reader = new FileReader();
                                                    reader.onload = function (e) {
                                                        coverartencodedimage = e.target.result;
                                                        $("#bgimg").attr("src", e.target.result);
                                                        var columnname = $(this).attr('name');
                                                        var dbvalue = $(this).val();
                                                        $.post("process/server.php", {
                                                            action: "updatetvdetails",
                                                            projectid: projectid,
                                                            columnname: 'image',
                                                            result: coverartencodedimage
                                                        }, function (feedback) {
                                                            feedback = JSON.parse(feedback);
                                                            if (feedback.response === true) {
                                                                $.notify("Update Successful!", 'success');
                                                                $("#editprojectmodal").modal('hide');
                                                                pagenav("televisionpage");
                                                            } else if (feedback.response === false) {
                                                                swal({
                                                                    title: "Error Generated",
                                                                    text: "Unable to Update TV Details",
                                                                    icon: "error",
                                                                    button: false,
                                                                    timer: 5000
                                                                });
                                                            } else if ((feedback.response === false) && (feedback.error.length > 0)) {
                                                                swal({
                                                                    title: "Error Generated",
                                                                    text: "Unable to Update TV Details",
                                                                    icon: "error",
                                                                    button: false,
                                                                    timer: 5000
                                                                });
                                                            }
                                                        });

                                                    };
                                                    reader.readAsDataURL($(this)[0].files[i]);
                                                }
                                            } else {
                                                alert("This browser does not support FileReader.");
                                            }
                                        } else {
                                            swal({
                                                title: "Error Generated",
                                                text: "This Passport size is too large",
                                                icon: "error",
                                                button: true
                                            });
                                            $('button[type=submit]').attr('disabled', 'disabled');
                                            $(this).addClass('border-danger');
                                        }
                                    } else {
                                        swal({
                                            title: "Error Generated",
                                            text: "This file type is not an image",
                                            icon: "error",
                                            button: true
                                        });
                                        $('button[type=submit]').attr('disabled', 'disabled');
                                        $(this).addClass('border-danger');
                                    }
                                });
                            } else if (feedback.response === false) {
                                swal({
                                    title: "Error Generated",
                                    text: "Unable to Fetch TV Details",
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
                            title: "You are about to delete this TV?",
                            icon: "warning",
                            buttons: true,
                            dangerMode: true
                        }).then((willDelete) => {
                            if (willDelete) {
                                $.post("process/server.php", {
                                    action: "deleteimpact",
                                    projectid: newsid
                                }, function (feedback) {
                                    feedback = JSON.parse(feedback);
                                    if (feedback.response === true) {
                                        swal({
                                            title: "Successful",
                                            text: "Impact of service deleted",
                                            icon: "success",
                                            button: true
                                        }).then((result) => {
                                            if (result === true) {
                                                pagenav("impactpage");
                                            }
                                        });
                                    } else if (feedback.response === false) {
                                        swal({
                                            title: "Error Generated",
                                            text: "Unable to delete Impact of Service",
                                            icon: "error",
                                            button: false,
                                            timer: 5000
                                        });
                                    } else if ((feedback.response === false) && (feedback.error.length > 0)) {
                                        swal({
                                            title: "Error Generated",
                                            text: "Unable to delete Impact of Service",
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
                        text: "Unable to Fetch TV List",
                        icon: "error",
                        button: false,
                        timer: 5000
                    });
                    //                    swal("Error Generated", "User Not Signed In", "error");

                } else if ((feedback.response === false) && (feedback.error.length > 0)) {
                    swal({
                        title: "Error Generated",
                        text: "Unable to Fetch TV List",
                        icon: "error",
                        button: false,
                        timer: 5000
                    });
                }

            }
        });
    });


</script>
