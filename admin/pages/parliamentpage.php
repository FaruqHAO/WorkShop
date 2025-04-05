<div id="manageuserspage">
    <div class="card">
        <div class="card-header">
            <h2 class="h6 text-uppercase mb-0 font-weight-bold text-center"> Parliament List </h2>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-4">
                    <div class="form-group ">
                    </div>
                </div>  
                <div class="col-4"></div>
                <div class="col-4">
                    <!--<button class=" btn btn-primary" id="Addnewimpact">Add New Parliament</button>-->
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
                                <th>description</th>
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
                <h5 class="modal-title">Edit Parliament</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="#" method="POST" id="adduserform" >
                    <div class="text-uppercase font-weight-bold text-light bg-dark">Personal Information</div>
                    <div class="row border-top">
                        <div class="col-6">
                            <!-- Upload image input-->
                            <div class="input-group mb-3 px-2 py-2 rounded-pill bg-white shadow-sm">
                                <input id="upload" type="file" onchange="readURL(this);" class="form-control border-0">
                                <label id="upload-label" for="upload" class="font-weight-light text-muted">Choose Profile</label>
                                <div class="input-group-append">
                                    <label for="upload" class="btn btn-light m-0 rounded-pill px-4"> <i class="fa fa-cloud-upload mr-2 text-muted"></i><small class="text-uppercase font-weight-bold text-muted">Choose file</small></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="image-area mt-4">
                                <img id="imageResult" src="assets/img/user/defaultuser.png" alt="" class="img-thumbnail rounded shadow-sm mx-auto d-block">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Full Name</label>
                                <input type="text" id="fullname" name="fullname" class="form-control" placeholder="Kelly">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="">Description</label>
                                <input type="text" id="description" name="description" class="form-control" placeholder="Kelly">
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
        pagename("Parliament");
        $("#Addnewimpact").on("click", function () {
            pagenav("addParliament");
        });
        var workshoplistdatatable;
        var formdata = new FormData();
        formdata.append('action', "fetchallparliament");
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
                        data: feedback.governancelist,
                        columns: [
                            {data: 'id'},
                            {data: 'fullname'},
                            {data: 'description'},
                            {data: feedback.governancelist,
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
                    //edit govenance
                    //                    //Edit conference info   
                    $(".editconference").on("click", function () {

                        $(".close").on('click', function () {
                            $("#editprojectmodal").modal('hide');
                        });
                        var projectid = $(this).attr('id');
                        $.post("process/server.php", {
                            action: "fetchparliamentdetail",
                            projectid: projectid
                        }, function (feedback) {
                            feedback = JSON.parse(feedback);
                            if (feedback.response === true) {
                                $("#editprojectmodal").modal('show');
                                $.each(feedback.governacedetail, function (key, value) {
                                    $("#fullname").val(value.fullname);
                                    $("#description").val(value.description);
                                    $("#imageResult").attr('src', value.image);
                                });
                                $('#fullname,#description').on('change', function () {
                                    if ($(this).val() === '') {
                                        $(this).notify('This field needs data', 'info');
                                    } else {
                                        var columnname = $(this).attr('name');
                                        var dbvalue = $(this).val();
                                        $.post("process/server.php", {
                                            action: "updateparliamentdetails",
                                            projectid: projectid,
                                            columnname: columnname,
                                            result: dbvalue
                                        }, function (feedback) {
                                            feedback = JSON.parse(feedback);
                                            if (feedback.response === true) {
                                                $.notify("Update Successful!", 'success');
                                                $("#editprojectmodal").modal('hide');
                                                pagenav("parliamentpage");
                                            } else if (feedback.response === false) {
                                                swal({
                                                    title: "Error Generated",
                                                    text: "Unable to Update Parliament Details",
                                                    icon: "error",
                                                    button: false,
                                                    timer: 5000
                                                });
                                            } else if ((feedback.response === false) && (feedback.error.length > 0)) {
                                                swal({
                                                    title: "Error Generated",
                                                    text: "Unable to Update Parliament Details",
                                                    icon: "error",
                                                    button: false,
                                                    timer: 5000
                                                });
                                            }
                                        });
                                    }
                                });

                                var coverartencodedimage;
                                $("#upload").on('change', function () {
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
                                                        $("#imageResult").attr("src", e.target.result);
                                                        $.post("process/server.php", {
                                                            action: "updateparliamentdetails",
                                                            projectid: projectid,
                                                            columnname: 'image',
                                                            result: coverartencodedimage
                                                        }, function (feedback) {
                                                            feedback = JSON.parse(feedback);
                                                            if (feedback.response === true) {
                                                                $.notify("Update Successful!", 'success');
                                                                $("#editprojectmodal").modal('hide');
                                                                pagenav("parliamentpage");
                                                            } else if (feedback.response === false) {
                                                                swal({
                                                                    title: "Error Generated",
                                                                    text: "Unable to Update Parliament",
                                                                    icon: "error",
                                                                    button: false,
                                                                    timer: 5000
                                                                });
                                                            } else if ((feedback.response === false) && (feedback.error.length > 0)) {
                                                                swal({
                                                                    title: "Error Generated",
                                                                    text: "Unable to Update Parliament",
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
                                    text: "Unable to Fetch Governances Details",
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
                        })

                    });
//                    delecting user details
                    $(".deletenews").on("click", function () {
                        var newsid = $(this).attr('id');
                        swal({
                            title: "You are about to delete this Governances?",
                            icon: "warning",
                            buttons: true,
                            dangerMode: true
                        }).then((willDelete) => {
                            if (willDelete) {
                                $.post("process/server.php", {
                                    action: "deletegovernance",
                                    projectid: newsid
                                }, function (feedback) {
                                    feedback = JSON.parse(feedback);
                                    if (feedback.response === true) {
                                        swal({
                                            title: "Successful",
                                            text: "Governances deleted",
                                            icon: "success",
                                            button: true
                                        }).then((result) => {
                                            if (result === true) {
                                                pagenav("commanderie");
                                            }
                                        });
                                    } else if (feedback.response === false) {
                                        swal({
                                            title: "Error Generated",
                                            text: "Unable to delete Governances",
                                            icon: "error",
                                            button: false,
                                            timer: 5000
                                        });
                                    } else if ((feedback.response === false) && (feedback.error.length > 0)) {
                                        swal({
                                            title: "Error Generated",
                                            text: "Unable to delete Governances",
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
                } else if (feedback.response === false) {
                    swal({
                        title: "Error Generated",
                        text: "Unable to Fetch Parliament List",
                        icon: "error",
                        button: false,
                        timer: 5000
                    });
                } else if ((feedback.response === false) && (feedback.error.length > 0)) {
                    swal({
                        title: "Error Generated",
                        text: "Unable to Fetch Parliament List",
                        icon: "error",
                        button: false,
                        timer: 5000
                    });
                }


            }
        });

    });

</script>

