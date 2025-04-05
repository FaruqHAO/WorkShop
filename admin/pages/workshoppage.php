<div id="manageuserspage">
    <div class="card">
        <div class="card-header">
            <h2 class="h6 text-uppercase mb-0 font-weight-bold text-center"> WorkShop/Conference List </h2>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-4">
                    <div class="form-group ">
                    </div>
                </div>  
                <div class="col-4"></div>
                <div class="col-4">
                    <button class="btn btn-primary" id="Addnewworkshop">Add New</button>
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
                                <th>Event type</th>
                                <th>Speaker</th>
                                <th>Location</th>
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
                                <input type="text" id="title" class="form-control" name="title" placeholder="Enter title of confrence" required="">
                            </div>
                        </div> 
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="">Description</label>
                                <input type="text" class="form-control" id="description" name='description' required="">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Workshop-Image</label>
                                <input type="file" class="form-control" id="uploadproject" name="image" required="">
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
                                <label for="">Edition</label>
                                <input type="text" class="form-control" id="edition" name="editor" required="">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="">Event </label>
                                <input type="text" class="form-control" id="event" name="event" required="">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="">Fee's</label>
                                <input type="number" class="form-control" id="fee" name='fee'  required="">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label for="">Organizer</label>
                                <input type="text" class="form-control" id="organisers" name="organizer" required="">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="">Speaker </label>
                                <input type="text" class="form-control" id="speaker" name="speaker" required="">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="">Location</label>
                                <input type="text" class="form-control" id="location" name="location" required="">
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
        pagename("Workshop&Conference");
        $("#Addnewworkshop").on("click", function () {
            pagenav("addworkshop");
        });
        var workshoplistdatatable;
        var formdata = new FormData();
        formdata.append('action', "fetchallworkshop");
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
                        data: feedback.workshoplist,
                        columns: [
                            {data: 'id'},
                            {data: 'title'},
                            {data: 'event'},
                            {data: 'speaker'},
                            {data: 'location'},
                            {data: feedback.workshoplist,
                                render: function (data, type, row) {
                                    return "<span class=''>\n\
                                            <a class='text-info viewconference' id='" + row.id + "' data-toggle='modal' data-target='#edit_leave'><span class='mdi  mdi-eye-outline mdi-20px'></span></a>\n\
                                            <a class='text-info editconference' id='" + row.id + "' data-toggle='modal' data-target='#edit_leave'><span class='mdi mdi-square-edit-outline mdi-20px'></span></a>\n\
                                            \n\
                                            <a class='text-danger deletenews' id='" + row.id + "' data-toggle='modal' data-target='#delete_approve'><span class='mdi mdi-delete-forever-outline mdi-20px'></span></a>\n\
                                      </span>";
                                }
                            }
                        ]
                    });

                    $('.viewconference').on('click', function () {
                        var projectid = $(this).attr('id');
                        $.post("process/server.php", {
                            action: "fetchworkshopdetail",
                            projectid: projectid
                        }, function (feedback) {
                            feedback = JSON.parse(feedback);
                            if (feedback.response === true) {
                                bootbox.alert({
                                    message: profile2(),
                                    size: 'large',
                                    closeButton: false,
                                    callback: function () {
                                    }
                                });
                                $.each(feedback.workshoplistdetail, function (key, value) {
                                    $("#profile").attr('src', value.image);
                                    $("#title").text(value.title);
                                    $("#edition").text(value.editor);
                                    $("#event").text(value.event);
                                    $("#fee").text(value.fee);
                                    $("#organizer").text(value.organizer);
                                    $("#speaker").text(value.speaker);
                                    $("#location").text(value.location);
                                    $("#description").text(value.description);
                                });
                            } else if (feedback.response === false) {
                                swal({
                                    title: "Error Generated",
                                    text: "Unable to Fetch Workshop Details",
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


//                    //Edit conference info   
                    $(".editconference").on("click", function () {
                        $(".close").on('click', function () {
                            $("#editprojectmodal").modal('hide');
                        });
                        var projectid = $(this).attr('id');
                        $.post("process/server.php", {
                            action: "fetchworkshopdetail",
                            projectid: projectid
                        }, function (feedback) {
                            feedback = JSON.parse(feedback);
                            if (feedback.response === true) {
                                $("#editprojectmodal").modal('show');
                                $.each(feedback.workshoplistdetail, function (key, value) {
                                    $("#bgimg").attr('src', value.image);
                                    $("#title").val(value.title);
                                    $("#edition").val(value.editor);
                                    $("#event").val(value.event);
                                    $("#fee").val(value.fee);
                                    $("#organisers").val(value.organizer);
                                    $("#speaker").val(value.speaker);
                                    $("#location").val(value.location);
                                    $("#description").val(value.description);
                                });
                                $('#title,#edition,#event,#fee,#organizer,#speaker,#location,#description').on('change', function () {
                                    if ($(this).val() === '') {
                                        $(this).notify('This field needs data', 'info');
                                    } else {
                                        var columnname = $(this).attr('name');
                                        var dbvalue = $(this).val();
                                        $.post("process/server.php", {
                                            action: "updateworkshopdetails",
                                            projectid: projectid,
                                            columnname: columnname,
                                            result: dbvalue
                                        }, function (feedback) {
                                            feedback = JSON.parse(feedback);
                                            if (feedback.response === true) {
                                                $.notify("Update Successful!", 'success');
                                                $("#editprojectmodal").modal('hide');
                                                pagenav("workshoppage");
                                            } else if (feedback.response === false) {
                                                swal({
                                                    title: "Error Generated",
                                                    text: "Unable to Update Workshop Details",
                                                    icon: "error",
                                                    button: false,
                                                    timer: 5000
                                                });
                                            } else if ((feedback.response === false) && (feedback.error.length > 0)) {
                                                swal({
                                                    title: "Error Generated",
                                                    text: "Unable to Update Workshop Details",
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
                                                            action: "updateworkshopdetails",
                                                            projectid: projectid,
                                                            columnname: 'image',
                                                            result: coverartencodedimage
                                                        }, function (feedback) {
                                                            feedback = JSON.parse(feedback);
                                                            if (feedback.response === true) {
                                                                $.notify("Update Successful!", 'success');
                                                                $("#editprojectmodal").modal('hide');
                                                                pagenav("workshoppage");
                                                            } else if (feedback.response === false) {
                                                                swal({
                                                                    title: "Error Generated",
                                                                    text: "Unable to Update Workshop Details",
                                                                    icon: "error",
                                                                    button: false,
                                                                    timer: 5000
                                                                });
                                                            } else if ((feedback.response === false) && (feedback.error.length > 0)) {
                                                                swal({
                                                                    title: "Error Generated",
                                                                    text: "Unable to Update Workshop Details",
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
                                    text: "Unable to Fetch Workshop Details",
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
                            title: "You are about to delete this Workshop/Conference?",
                            icon: "warning",
                            buttons: true,
                            dangerMode: true
                        }).then((willDelete) => {
                            if (willDelete) {
                                $.post("process/server.php", {
                                    action: "deleteworkshop",
                                    projectid: newsid
                                }, function (feedback) {
                                    feedback = JSON.parse(feedback);
                                    if (feedback.response === true) {
                                        swal({
                                            title: "Successful",
                                            text: "Workshop/Conference deleted",
                                            icon: "success",
                                            button: true
                                        }).then((result) => {
                                            if (result === true) {
                                                pagenav("workshoppage");
                                            }
                                        });
                                    } else if (feedback.response === false) {
                                        swal({
                                            title: "Error Generated",
                                            text: "Unable to delete Workshop",
                                            icon: "error",
                                            button: false,
                                            timer: 5000
                                        });
                                    } else if ((feedback.response === false) && (feedback.error.length > 0)) {
                                        swal({
                                            title: "Error Generated",
                                            text: "Unable to delete Workshop",
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
                        text: "Unable to Fetch Workshop & Conference List",
                        icon: "error",
                        button: false,
                        timer: 5000
                    });
                    //                    swal("Error Generated", "User Not Signed In", "error");

                } else if ((feedback.response === false) && (feedback.error.length > 0)) {
                    swal({
                        title: "Error Generated",
                        text: "Unable to Fetch Workshop & Conference List",
                        icon: "error",
                        button: false,
                        timer: 5000
                    });
                }
            }
        });
    });

    function profile2() {
        return '<div class="card"><div class="card-header">Confrence/Workshop</div><div class="card-body">\n\
<div class="row"><div class="col-lg-6">\n\
<span><img class="img-thumbnail" alt="profile" id="profile"></span></div><div class="col-lg-6">\n\
<b>Title:</b><p id="title"></p><b class="">Edition:</b><p id="edition"></p> <b class="">Event:</b><p class="" id="event"></p><b class="">Fee:</b><p class="" id="fee"></p>\n\
<b class="">Organizer:</b><p class="" id="organizer"></p><b class="">Speaker:</b><p class="" id="speaker"></p><b class="">Location:</b><p class="" id="location"></p>\n\
<b class="">Description:</b><p class="" id="description"></p></div></div></div></div>';
    }
</script>
