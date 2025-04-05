<div id="manageuserspage">
    <div class="card">
        <div class="card-header">
            <h2 class="h6 text-uppercase mb-0 font-weight-bold text-center">Manage New Page</h2>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-4"></div>
                <div class="col-4"></div>
                <div class="col-4"><button class="btn btn-primary float-right" id="addnews"> Add news</button></div>
            </div>  
        </div>
        <br><br>
        <div class="row">
            <div class="col-11 m-auto ">
                <div class="form-group border border-light" >
                    <table class=" table table-striped table-hover table-wrapper"style="width: 100%" id="newstable">
                        <thead>
                            <tr>
                                <th>S.N</th>
                                <th>Title</th>
                                <th>Author</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<div id="addnewsmodal" class="modal fade modal-xl" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center">Add News</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="#" method="POST" id="addnewsform" >
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label for="">Title</label>
                                <input type="text" id="Enewstitle" class="form-control" name="title" placeholder="the title of the news item" required="">
                            </div>
                        </div> 
                        <div class="col-4">
                            <div class="form-group">
                                <label for="">Date</label>
                                <input type="date" class="form-control" id="Enewsdate" name="date"required="">
                            </div> 
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="">Author</label>
                                <input type="text" class="form-control" id="Enewsauthor"name="author" required="">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="">Short news</label>
                                <textarea class="form-control" id="Ebeliefnews" name="beliefnews" required="" placeholder="Enter News Belief"></textarea>
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
                    <div class="row">
                        <div class="col-6">
                            <label for="">Upload News image </label>
                            <input type="file" id="Enewsimage" class="form-control">
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <div class="col-6 image-holder">
                                    <img src="" class="" id="newsimg"style="height: 100px;">
                                </div> 
                            </div>
                        </div>
                    </div>
                    <div class="form-footer pt-2  mt-2 border-top text-center">
                        <button type="submit" class="btn btn-outline-success" data-style="expand-right" ><i class="mdi mdi-account-plus-outline"></i>  Add News</button>&nbsp;&nbsp;&nbsp;&nbsp;
                        <button type="reset" class="btn btn-outline-secondary" data-style="expand-right" ><i class="mdi mdi-account-convert"></i> Reset Form</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div id="editnewsmodal" class="modal fade modal-xl" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center">Edit news</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="#" method="POST" id="editnewsform" >
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label for="">Title</label>
                                <input type="text" id="Enewstitle" class="form-control" name="title" placeholder="the title of the news item" required="">
                            </div>
                        </div> 
                        <div class="col-4">
                            <div class="form-group">
                                <label for="">Date</label>
                                <input type="date" class="form-control" id="Enewsdate" name="date"required="">
                            </div> 
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="">Author</label>
                                <input type="text" class="form-control" id="Enewsauthor"name="author" required="">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="">Short news</label>
                                <textarea class="form-control" id="Ebeliefnews" name="beliefnews" required="" placeholder="Enter News Belief"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="">Full news</label>
                                <div id="fullnews" name="fullnews"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label for="">Upload News image </label>
                            <input type="file" id="Enewsimage" class="form-control">
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <div class="col-6 image-holder">
                                    <img src="" class="" id="newsimg"style="height: 100px;">
                                </div> 
                            </div>
                        </div>
                    </div>
                    <div class="form-footer pt-2  mt-2 border-top text-center">
                        <button type="submit" class="btn btn-outline-success" data-style="expand-right" ><i class="mdi mdi-account-plus-outline"></i>  Edit News</button>&nbsp;&nbsp;&nbsp;&nbsp;
                        <button type="reset" class="btn btn-outline-secondary" data-style="expand-right" ><i class="mdi mdi-account-convert"></i> Reset Form</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {
        pagename("News");
        var newslistdatatable;
        var formdata = new FormData();
        formdata.append('action', "fetchallnews");
        $.ajax({
            url: 'process/server.php',
            type: 'post',
            data: formdata,
            contentType: false,
            processData: false,
            success: function (feedback) {
                feedback = JSON.parse(feedback);
                if (feedback.response === true) {
                    newslistdatatable = $("#newstable").DataTable({
                        retrieve: true,
                        responsive: true,
                        paging: true,
                        data: feedback.newslist,
                        columns: [
                            {data: 'id'},
                            {data: 'title'},
                            {data: 'author'},
                            {data: 'date'},
                            {data: feedback.newslist,
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
                    var coverartencodedimage;
                    $(".editnews").on("click", function () {
                        $(".close").on("click", function () {
                            $("#editnewsmodal").modal('hide');
                            pagenav("newspage");
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
                        let quill = new Quill('#fullnews', {
                            modules: {
                                toolbar: toolbar
                            }, theme: 'snow'
                        });

                        var newsid = $(this).attr('id');
                        $.post("process/server.php", {
                            action: "fetchnewsdetail",
                            newsid: newsid
                        }, function (feedback) {
                            feedback = JSON.parse(feedback);
                            if (feedback.response === true) {
                                $("#editnewsmodal").modal('show');
                                $.each(feedback.newslistdetail, function (key, value) {
                                    $('#Enewstitle').val(value.title);
                                    $('#Enewsdate').val(value.date);
                                    $('#Enewsauthor').val(value.author);
                                    $('#Ebeliefnews').val(value.content);
                                    var Title = $('<textarea />').html(value.fullstory).text();
                                    quill.root.innerHTML = Title;
                                    $('#Ecategory').val(value.cat);
                                    $('#newsimg').attr('src', value.image);
                                });
                                $("#Enewsimage").on("change", function () {
                                    var countFiles = $(this)[0].files.length;
                                    var imgPath = $(this)[0].value;
                                    var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
                                    if (extn === "gif" || extn === "png" || extn === "jpg" || extn === "jpeg") {
                                        if (typeof (FileReader) !== "undefined") {
                                            //loop for each file selected for uploaded.
                                            for (var i = 0; i < countFiles; i++)
                                            {
                                                var reader = new FileReader();
                                                reader.onload = function (e) {
                                                    coverartencodedimage = e.target.result;
                                                    $("#newsimg").attr("src", e.target.result);
                                                }
                                                reader.readAsDataURL($(this)[0].files[i]);
                                            }
                                        } else {
                                            alert("This browser does not support FileReader.");
                                        }
                                    }
                                })
                                $("#editnewsform").on('submit', function (event) {
                                    event.preventDefault();
                                    event.stopPropagation();
                                    //post news information to the database.
                                    var formdata = new FormData();
                                    formdata.append('action', "updatenews");
                                    var myEditor = document.querySelector('#fullnews');
                                    var html = myEditor.children[0].innerHTML;

                                    formdata.append('newsid', newsid);
                                    formdata.append('image', coverartencodedimage);
                                    formdata.append('fullnews', html);
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
                                            feedback = JSON.parse(feedback);
                                            if (feedback.response === true) {
                                                $("#editnewsmodal").modal('hide');
                                                $.notify('Update Successful', 'success');
                                                pagenav("newspage");
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
                                                pagenav("newspage");
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
                        text: "Unable to Fetch News List",
                        icon: "error",
                        button: false,
                        timer: 5000
                    });
                    //                    swal("Error Generated", "User Not Signed In", "error");

                } else if ((feedback.response === false) && (feedback.error.length > 0)) {
                    swal({
                        title: "Error Generated",
                        text: "Unable to Fetch Album List",
                        icon: "error",
                        button: false,
                        timer: 5000
                    });
                }

            }
        });


        $("#addnews").on('click', function () {
            $(".close").on("click", function () {
                $("#addnewsmodal").modal('hide');
                pagenav("newspage");
            });
            $("#addnewsmodal").modal('show');
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
            var coverartencodedimage;
            $("#Enewsimage").on("change", function () {
                var countFiles = $(this)[0].files.length;
                var imgPath = $(this)[0].value;
                var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
                if (extn === "gif" || extn === "png" || extn === "jpg" || extn === "jpeg") {
                    if (typeof (FileReader) !== "undefined") {
                        //loop for each file selected for uploaded.
                        for (var i = 0; i < countFiles; i++)
                        {
                            var reader = new FileReader();
                            reader.onload = function (e) {
                                coverartencodedimage = e.target.result;
                                $("#newsimg").attr("src", e.target.result);
                            }
                            reader.readAsDataURL($(this)[0].files[i]);
                        }
                    } else {
                        alert("This browser does not support FileReader.");
                    }
                }
            })

            $("#addnewsform").on('submit', function (event) {
                event.preventDefault();
                event.stopPropagation();
                //post news information to the database.
                var formdata = new FormData();
                formdata.append('action', "addnews");
                var myEditor = document.querySelector('#fullnew');
                var html = myEditor.children[0].innerHTML;
                formdata.append('image', coverartencodedimage);
                formdata.append('fullnews', html);
                var other_data = $('#addnewsform').serializeArray();
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
                        feedback = JSON.parse(feedback);
                        console.log(feedback);
                        if (feedback.response === true) {
                            $("#addnewsmodal").modal('hide');
                            swal({
                                title: "Successful",
                                text: "News added",
                                icon: "success",
                                button: true
                            }).then((result) => {
                                if (result === true) {
                                    pagenav("newspage");
                                }
                            });
                        } else if (feedback.response === false) {
                            swal({
                                title: "Error Generated",
                                text: "Unable to Add News",
                                icon: "error",
                                button: false,
                                timer: 5000
                            });
                        } else if ((feedback.response === false) && (feedback.error.length > 0)) {
                            swal({
                                title: "Error Generated",
                                text: "Unable to Add News",
                                icon: "error",
                                button: false,
                                timer: 5000
                            });
                        }


                    }
                });

            });
        });

    });
</script>
