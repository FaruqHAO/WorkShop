<div class="card">
    <div class="card-header">
        <h2 class="h6 text-uppercase mb-0 font-weight-bold text-center">Manage About Page</h2>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <div class="form-group">
                        <label for="">Background Picture</label>
                        <input type="file" id="passport" class="form-control" required="">
                    </div>
                </div>
            </div>
            <div class="col-6">
                <img  src="" id="bgimg" class="float-right" alt="background image" style="height: 100px; width: 69%">
            </div>
        </div>
        <br>
        <div class="text-uppercase font-weight-bold text-light bg-dark">Main information</div>
        <div class="row border-top">
            <div class="col-12">
                <div class="form-group">
                    <label for="">Text</label>
                    <div id="fullnews" name="fullnews"></div>
                </div>
            </div>
        </div>

    </div>
</div>

<script >
    $(function () {
        pagename("About us");

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


        $.post("process/server.php", {
            action: "fetchaboutmain"
        }, function (feedback) {
            feedback = JSON.parse(feedback);
            if (feedback.response === true) {
                var aboutid = '';
                $.each(feedback.bginfo, function (key, value) {
                    aboutid = value.id;
                    $('#bgimg').attr('src', value.image);
                    var Title = $('<textarea />').html(value.text).text();
                    quill.root.innerHTML = Title;
                });
                $("#passport").on('change', function () {
                    //Get count of selected files
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
                                    $("#bgimg").attr("src", e.target.result);
                                    var attribute = "image";
                                    $.post("process/server.php", {
                                        action: "updateaboutmins",
                                        inputvalue: e.target.result, attribute: attribute
                                    }, function (feedback) {
                                        feedback = JSON.parse(feedback);
                                        if (feedback.response === true) {
                                            $.notify('Update Successfully', "success");
                                        } else if (feedback.response === false) {
                                            swal({
                                                title: "Error Generated",
                                                text: "Unable to to Update image",
                                                icon: "error",
                                                button: false,
                                                timer: 5000
                                            });
                                        } else if ((feedback.response === false) && (feedback.error.length > 0)) {
                                            swal({
                                                title: "Error Generated",
                                                text: "Unable to Update image",
                                                icon: "error",
                                                button: false,
                                                timer: 5000
                                            });
                                        }
                                    });
                                }
                                reader.readAsDataURL($(this)[0].files[i]);
                            }
                        } else {
                            alert("This browser does not support FileReader.");
                        }
                    } else {
                        swal({
                            title: "Error Generated",
                            text: "This file type is not an image",
                            icon: "error",
                            button: true

                        });
                    }
                });
                quill.on('text-change', function (delta, oldDelta, source) {
                    if (source == 'api') {
//                        console.log("An API call triggered this change.");
                    } else if (source == 'user') {
                        var myEditor = document.querySelector('#fullnews');
                        var html = myEditor.children[0].innerHTML;
                        var attribute = 'text';
                        $.post("process/server.php", {
                            action: "updateaboutmins",
                            inputvalue: html, attribute: attribute
                        }, function (feedback) {
                            feedback = JSON.parse(feedback);
                            if (feedback.response === true) {
                                $.notify('Update Successfully', "success");
                            } else if (feedback.response === false) {
                                swal({
                                    title: "Error Generated",
                                    text: "Unable to to Update about text",
                                    icon: "error",
                                    button: false,
                                    timer: 5000
                                });
                            } else if ((feedback.response === false) && (feedback.error.length > 0)) {
                                swal({
                                    title: "Error Generated",
                                    text: "Unable to Update about text",
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
                    text: "Unable to Fetch about Details",
                    icon: "error",
                    button: false,
                    timer: 5000
                });
                //                    swal("Error Generated", "User Not Signed In", "error");

            } else if ((feedback.response === false) && (feedback.error.length > 0)) {
                swal({
                    title: "Error Generated",
                    text: "Unable to Fetch about Details",
                    icon: "error",
                    button: false,
                    timer: 5000
                });
                console.log("Error Generated " + userdata.error);
            }
        });

    });
</script>


