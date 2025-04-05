<div id="manageuserspage">
    <div class="card">
        <div class="card-header">
            <h2 class="h6 text-uppercase mb-0 font-weight-bold text-center"> Gallery List </h2>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-4">
                    <div class="form-group ">
                    </div>
                </div>  
                <div class="col-4"></div>
                <div class="col-4">
                    <button class=" btn btn-primary" id="Addnewproject">Add Gallery</button>
                </div>
            </div>
        </div>
        <br><br>
        <div class="row">
            <div class="col-11 m-auto ">
                <div class="form-group border border-light" >
                    <table class=" table table-hover table-wrapper"style="width: 100%" id="gallerytable">
                        <thead>
                            <tr>
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
                <h5 class="modal-title">Edit Project</h5>
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
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="">Year</label>
                                <input type="year" class="form-control" id="year" required="">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="">Project Status</label>
                                <select class="form-control" id="projectstatus" required="">
                                    <option value="null"> Select Project status</option>
                                    <option value="CurrentProject"> Current Project</option>
                                    <option value="PastProject"> Past Project</option>
                                </select>
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
        pagename("Gallery");
        $("#Addnewproject").on("click", function () {
            pagenav("addnewimage");
        });
        var newslistdatatable;
        var formdata = new FormData();
        formdata.append('action', "fetchallgallery");
        $.ajax({
            url: 'process/server.php',
            type: 'post',
            data: formdata,
            contentType: false,
            processData: false,
            success: function (feedback) {
                feedback = JSON.parse(feedback);
                if (feedback.response === true) {
                    newslistdatatable = $("#gallerytable").DataTable({
                        retrieve: true,
                        responsive: true,
                        paging: true,
                        data: feedback.gallerylist,
                        columns: [
                            {data: feedback.gallerylist,
                                render: function (data, type, row) {
                                    return '<div class="row"><div class="col-lg-6 video-box"><img src="' + row.image + '" class="img-fluid" alt="">\n\
          </div>\n\
<div class="col-lg-6 d-flex flex-column justify-content-center p-5"><b>Title:</b><p id="title">' + row.title + '</p></div></div>';
                                }
                            },
                            {data: feedback.gallerylist,
                                render: function (data, type, row) {
                                    return "<span class=''>\n\
                                            <a class='text-danger deletenews' id='" + row.id + "' data-toggle='modal' data-target='#delete_approve'><span class='mdi mdi-delete-forever-outline mdi-24px'></span></a>\n\
                                      </span>";
                                }
                            }
                        ]
                    });
                    $(".deletenews").on("click", function () {
                        var newsid = $(this).attr('id');
                        swal({
                            title: "You are about to delete this Image?",
                            icon: "warning",
                            buttons: true,
                            dangerMode: true
                        }).then((willDelete) => {
                            if (willDelete) {
                                $.post("process/server.php", {
                                    action: "deleteimage",
                                    projectid: newsid
                                }, function (feedback) {
                                    feedback = JSON.parse(feedback);
                                    if (feedback.response === true) {
                                        swal({
                                            title: "Successful",
                                            text: "Image deleted",
                                            icon: "success",
                                            button: true
                                        }).then((result) => {
                                            if (result === true) {
                                                pagenav("photogallarypage");
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
                        text: "Unable to Fetch Image List",
                        icon: "error",
                        button: false,
                        timer: 5000
                    });
                    //                    swal("Error Generated", "User Not Signed In", "error");

                } else if ((feedback.response === false) && (feedback.error.length > 0)) {
                    swal({
                        title: "Error Generated",
                        text: "Unable to Fetch Image List",
                        icon: "error",
                        button: false,
                        timer: 5000
                    });
                }

            }
        });
    });
</script>
