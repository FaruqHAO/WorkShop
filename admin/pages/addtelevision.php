<div id="manageuserspage">
    <div class="card">
        <div class="card-header">
            <h2 class="h6 text-uppercase mb-0 font-weight-bold text-center">Add Impact of our Service</h2>
        </div>
        <div class="card-body">
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
             
                <div class="form-footer pt-2  mt-2 border-top text-center">
                    <button type="submit" class="btn btn-outline-success" data-style="expand-right" ><i class="mdi mdi-account-plus-outline"></i>  Add TV</button>&nbsp;&nbsp;&nbsp;&nbsp;
                    <button type="reset" class="btn btn-outline-secondary" data-style="expand-right" ><i class="mdi mdi-account-convert"></i> Reset Form</button>
                </div>
            </form>
        </div>


    </div>
</div>




<script>
    $(function () {
        pagename("Television");

        $("#title").on("focusout", function () {
            //get the value of current input
            var inputvalue = $(this).val();
            //Regex makes sure every input value starts with a capital letter 
            var textregex = /[A-Z][A-Za-z' -]+/;
            //test if the regex validates the input value
            if (!(textregex.test(inputvalue))) {
                //remove the filled class to show that the field is not valid yet
                $('button[type=submit]').attr('disabled', 'disabled');
                $(this).notify('Wrong input format : Start Each Name with a Capital Letter', 'error');
                if ($(this).val().length < 3) {
                    $(this).notify('Length too short, Enter more than 3 Letters', 'error');
                }
                $(this).addClass('border-danger');
            } else {
                $(this).removeClass('border-danger');
                $(this).addClass('border-success');
                $('button[type=submit]').removeAttr('disabled');
            }
        });
        $("#video").on("focusout", function () {
            //get the value of current input
            var inputvalue = $(this).val();
            if (inputvalue === '') {
                //remove the filled class to show that the field is not valid yet
                $('button[type=submit]').attr('disabled', 'disabled');
                $(this).notify('Input cannot be left open', 'error');
                $(this).addClass('border-danger');
            } else {
                var matches = inputvalue.match(/watch\?v=([a-zA-Z0-9\-_]+)/);
                if (matches)
                {
                    $(this).removeClass('border-danger');
                    $(this).addClass('border-success');
                    $('button[type=submit]').removeAttr('disabled');
                } else {
                    $('button[type=submit]').attr('disabled', 'disabled');
                    $(this).notify('Invalid URL', 'error');
                    $(this).addClass('border-danger');
                }

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


        $("#projectform").on('submit', function (event) {
            event.preventDefault();
            event.stopPropagation();
            //post news information to the database.
            var formdata = new FormData();
            formdata.append('action', "addtv");
            formdata.append('title', $("#title").val());
            formdata.append('video', $("#video").val());
            formdata.append('coverartencodedimage', coverartencodedimage);
            $.ajax({
                url: 'process/server.php',
                type: 'post',
                data: formdata,
                contentType: false,
                processData: false,
                success: function (feedback) {
                    feedback = JSON.parse(feedback);
                    if (feedback.response === true) {
                        swal({
                            title: "Successful",
                            text: "Television added",
                            icon: "success",
                            button: true
                        }).then((result) => {
                            pagenav("televisionpage");
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
                            text: "Unable to Add Television",
                            icon: "error",
                            button: false,
                            timer: 5000
                        });
                    }


                }
            });

        });
    });
</script>
