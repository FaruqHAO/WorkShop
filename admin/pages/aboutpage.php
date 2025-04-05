<div id="manageuserspage">
    <div class="card">
        <div class="card-header">
            <h2 class="h6 text-uppercase mb-0 font-weight-bold text-center"> About us List </h2>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-4">
                    <div class="form-group ">
                    </div>
                </div>  
                <div class="col-4"></div>
                <div class="col-4">
                    <button class="btn btn-primary" id="Addnewaboutus">Add New About us</button>
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

<div id="editnewsmodal" class="modal fade modal-xl" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit About us</h5>
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
                                <label for="">Full news</label>
                                <div id="fullnew" name="fullnews"></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-footer pt-2  mt-2 border-top text-center">
                        <button type="submit" class="btn btn-outline-success" data-style="expand-right" ><i class="mdi mdi-account-plus-outline"></i>  Edit About</button>&nbsp;&nbsp;&nbsp;&nbsp;
                        <button type="reset" class="btn btn-outline-secondary" data-style="expand-right" ><i class="mdi mdi-account-convert"></i> Reset Form</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<script>
    $(function () {
        pagename("About us");
        $("#Addnewaboutus").on("click", function () {
            pagenav("addaboutus");
        });
        var newslistdatatable;
        var formdata = new FormData();
        formdata.append('action', "fetchallabout");
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
                        data: feedback.aboutlist,
                        columns: [
                            {data: 'id'},
                            {data: 'title'},
                            {data: feedback.aboutlist,
                                render: function (data, type, row) {
                                    return "<span class=''>\n\
                                            <a class='text-info editnews' id='" + row.id + "' data-toggle='modal' data-target='#edit_leave'><span class='mdi mdi-square-edit-outline mdi-24px'></span></a>\n\
                                            \n\
                                            <a class='text-danger deletenews'  id='" + row.id + "' data-toggle='modal' data-target='#delete_approve'><span class='mdi mdi-delete-forever-outline mdi-24px'></span></a>\n\
                                      </span>";
                                }
                            }
                        ]
                    });
//                    //Edit user info   
                    $(".editnews").on("click", function () {
                        $(".close").on('click', function () {
                            $("#editnewsmodal").modal('hide');
                        });
                        let toolbar = [
                            ["bold", "italic", "underline", "strick"],
                            [{header: [1, 2, 3, 4, 5, 6, false]}],
                            [{size: ["small", "large", "huge", false]}],
                            [{list: "ordered"}, {list: "bullet"}],
                            ["links", "image", "video", "formula"],
                            [{script: "sub"}, {script: "super"}],
                            [{indent: "+1"}, {indent: "-1"}],
                            [{color: []}, {background: []}],
                            [{font: []}],
                            [{align: []}],
                            ["code-block"]
                        ];
                        let quill = new Quill('#fullnew', {
                            modules: {
                                toolbar: toolbar
                            }, theme: 'snow'
                        });

                        var aboutid = $(this).attr('id');
                        $.post("process/server.php", {
                            action: "fetchaboutdetail",
                            aboutid: aboutid
                        }, function (feedback) {
                            feedback = JSON.parse(feedback);
                            if (feedback.response === true) {
                                $("#editnewsmodal").modal('show');
                                $.each(feedback.aboutlistdetail, function (key, value) {
                                    $('#Title').val(value.title);
                                    var Title = $('<textarea />').html(value.content).text();
                                    quill.root.innerHTML = Title;
                                });
                                $("#editnewsform").on('submit', function (event) {
                                    event.preventDefault();
                                    event.stopPropagation();
                                    //post news information to the database.
                                    var formdata = new FormData();
                                    var myEditor = document.querySelector('#fullnew');
                                    var html = myEditor.children[0].innerHTML;
                                    formdata.append('action', "updateaboutus");
                                    formdata.append('aboutid', aboutid);
                                    formdata.append('content', html);
                                    var other_data = $('#editnewsform').serializeArray();
                                    $.each(other_data, function (key, input) {
                                        formdata.append(input.name, input.value);
                                    });
                                    $.ajax({
                                        url: 'process/server.php',
                                        type: 'post',
                                        data: formdata,
                                        contentType: false,
                                        processData: false,
                                        success: function (feedback) {
                                            console.log(feedback);
                                            feedback = JSON.parse(feedback);
                                            if (feedback.response === true) {
                                                $("#editnewsmodal").modal('hide');
                                                $.notify('Update Successful', 'success');
                                                pagenav("aboutpage");
                                            } else if (feedback.response === false) {
                                                swal({
                                                    title: "Error Generated",
                                                    text: "Unable to to Update Detail",
                                                    icon: "error",
                                                    button: false,
                                                    timer: 5000
                                                });
                                            } else if ((feedback.response === false) && (feedback.error.length > 0)) {
                                                swal({
                                                    title: "Error Generated",
                                                    text: "Unable to Update Detail",
                                                    icon: "error",
                                                    button: false,
                                                    timer: 5000
                                                });
                                            }


                                        }
                                    });

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
                        swal({
                            title: "You are about to delete this News?",
                            icon: "warning",
                            buttons: true,
                            dangerMode: true
                        }).then((willDelete) => {
                            if (willDelete) {
                                $.post("process/server.php", {
                                    action: "deletenews",
                                    newsid: newsid
                                }, function (feedback) {
                                    feedback = JSON.parse(feedback);
                                    if (feedback.response === true) {
                                        swal({
                                            title: "Successful",
                                            text: "News deleted",
                                            icon: "success",
                                            button: true
                                        }).then((result) => {
                                            if (result === true) {
                                                pagenav("aboutpage");
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
                        text: "Unable to Fetch About us List",
                        icon: "error",
                        button: false,
                        timer: 5000
                    });
                    //                    swal("Error Generated", "User Not Signed In", "error");

                } else if ((feedback.response === false) && (feedback.error.length > 0)) {
                    swal({
                        title: "Error Generated",
                        text: "Unable to Fetch About us List",
                        icon: "error",
                        button: false,
                        timer: 5000
                    });
                    console.log("Error Generated " + userdata.error);
                }

            }
        });


    });
</script>
