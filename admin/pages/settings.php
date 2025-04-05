<div class="card">
    <div class="card-header">
        <h2 class="h6 text-uppercase mb-0 font-weight-bold text-center">Manage Home Page</h2>
    </div>
    <div class="card-body">
        <div class="text-uppercase font-weight-bold text-light bg-dark">Pay stack Information</div>
        <div class="row border-top">
            <div class="col-6">
                <div class="form-group">
                    <label for="">Amount</label>
                    <input type="number" class="form-control" name="workshopprice" id="price">
                </div>
            </div>
        </div>
        <div class="text-uppercase font-weight-bold text-light bg-dark">Workshop/Seminar Details</div>
        <div class="row border-top">
            <div class="col-6">
                <div class="form-group">
                    <label for="">Title</label>
                    <textarea type="text" class="form-control" id="title" name='workshoptitle' maxlength ="50"></textarea>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="">Attachment File</label>
                    <input type="file" class="form-control" id="attachmentfile" name='workshopattactment'"> 
                </div>
            </div>
        </div>
    </div>
</div>

<script >
    $(function () {
        pagename("Homepage");
        $.post("../process/server.php", {
            action: "fetchallbg"
        }, function (feedback) {
            feedback = JSON.parse(feedback);
            if (feedback.response === true) {
                $.each(feedback.bginfo, function (key, value) {
                    $("#title").val(value.workshoptitle);
                    $("#price").val(value.workshopprice);


                });
                $("#title").on("change focusout", function () {
                    var inputvalue = $(this).val().toUpperCase();
                    //Regex makes sure every input value starts with a capital letter 
                    var textregex = /[A-Z][A-Za-z' -]+/;
                    //test if the regex validates the input value
                    if (!(textregex.test(inputvalue))) {
                        $(this).notify('Wrong input format : Start Each Name with a Capital Letter', 'error');
                        if ($(this).val().length < 3) {
                            $(this).notify('Length too short, Enter more than 3 Letters', 'error');
                        }
                    } else {
                        var attribute = $(this).attr('name');
                        $.post("../process/server.php", {
                            action: "updatebgnames",
                            inputvalue: inputvalue, attribute: attribute
                        }, function (feedback) {
                            feedback = JSON.parse(feedback);
                            if (feedback.response === true) {
                                $.notify('Update Successfully', "success");
                            } else if (feedback.response === false) {
                                swal({
                                    title: "Error Generated",
                                    text: "Unable to to Update details",
                                    icon: "error",
                                    button: false,
                                    timer: 5000
                                });
                            } else if ((feedback.response === false) && (feedback.error.length > 0)) {
                                swal({
                                    title: "Error Generated",
                                    text: "Unable to Update details",
                                    icon: "error",
                                    button: false,
                                    timer: 5000
                                });
                            }
                        });
                    }
                });
                $("#price").on("change focusout", function () {
                    var inputvalue = $(this).val();
                    //Regex makes sure every input value starts with a capital letter 
                    var textregex = "([0-9]{1, 3}(\, [0-9]{3})*|([0-9]+))(\.[0-9]{2})";
                    //test if the regex validates the input value
                    if (inputvalue ==='') {
                        $(this).notify('Wrong Ampunt format :', 'error');
                    } else {
                        var attribute = $(this).attr('name');
                        $.post("../process/server.php", {
                            action: "updatebgnames",
                            inputvalue: inputvalue, attribute: attribute
                        }, function (feedback) {
                            feedback = JSON.parse(feedback);
                            if (feedback.response === true) {
                                $.notify('Update Successfully', "success");
                            } else if (feedback.response === false) {
                                swal({
                                    title: "Error Generated",
                                    text: "Unable to to Update details",
                                    icon: "error",
                                    button: false,
                                    timer: 5000
                                });
                            } else if ((feedback.response === false) && (feedback.error.length > 0)) {
                                swal({
                                    title: "Error Generated",
                                    text: "Unable to Update details",
                                    icon: "error",
                                    button: false,
                                    timer: 5000
                                });
                            }
                        });
                    }
                });

                //file
                $("#attachmentfile").on('change', function () {
                    //post news information to the database.
                    var formdata = new FormData();
                    var files = $('#attachmentfile')[0].files;
                    formdata.append('file', files[0]);
                    formdata.append('action', "addproject");
                    $.ajax({
                        url: '../process/server.php',
                        type: 'post',
                        data: formdata,
                        contentType: false,
                        processData: false,
                        success: function (feedback) {
                            feedback = JSON.parse(feedback);
                            if (feedback.response === true) {
                                pagenav("projectpage");
                                swal({
                                    title: "Successful",
                                    text: "Attachment added",
                                    icon: "success",
                                    button: true
                                }).then((result) => {
                                    pagenav("settings");
                                });
                            } else if (feedback.response === false) {
                                swal({
                                    title: "Error Generated",
                                    text: feedback.message,
                                    icon: "error",
                                    button: false,
                                    timer: 5000
                                });
                            } else if ((feedback.response === false) && (feedback.error.length > 0)) {
                                swal({
                                    title: "Error Generated",
                                    text: "Unable to Upload Attachment",
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
                    text: "Unable to Fetch Background Details",
                    icon: "error",
                    button: false,
                    timer: 5000
                });
                //                    swal("Error Generated", "User Not Signed In", "error");

            } else if ((feedback.response === false) && (feedback.error.length > 0)) {
                swal({
                    title: "Error Generated",
                    text: "Unable to Fetch Background Details",
                    icon: "error",
                    button: false,
                    timer: 5000
                });
                console.log("Error Generated " + userdata.error);
            }
        });

    });
</script>


