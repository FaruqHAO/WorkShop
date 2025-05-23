<div id="manageuserspage">
    <div class="card">
        <div class="card-header">
            <h2 class="h6 text-uppercase mb-0 font-weight-bold text-center">Add About us</h2>
        </div>
        <div class="card-body">
            <form action="#" method="POST" id="projectform" >
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="">Title</label>
                            <input type="text" id="Title" class="form-control" name="title" placeholder="Enter title of confrence" required="">
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
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="">Workshop-Image</label>
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
                            <label for="">Edition</label>
                            <input type="text" class="form-control" id="edition" required="">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="">Event </label>
                            <input type="text" class="form-control" id="event" required="">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="">Fee's</label>
                            <input type="number" class="form-control" id="fee" required="">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label for="">Organizer</label>
                            <input type="text" class="form-control" id="organisers" required="">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="">Speaker </label>
                            <input type="text" class="form-control" id="speaker" required="">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="">Location</label>
                            <input type="text" class="form-control" id="location" required="">
                        </div>
                    </div>
                </div>
                <div class="form-footer pt-2  mt-2 border-top text-center">
                    <button type="submit" class="btn btn-outline-success" data-style="expand-right" ><i class="mdi mdi-account-plus-outline"></i>  Add New</button>&nbsp;&nbsp;&nbsp;&nbsp;
                    <button type="reset" class="btn btn-outline-secondary" data-style="expand-right" ><i class="mdi mdi-account-convert"></i> Reset Form</button>
                </div>
            </form>
        </div>


    </div>
</div>




<script>
    $(function () {
        pagename("Workshop&Conference");

        $("#Title,#description,#edition,#event,#organisers,#speaker,#location").on("focusout", function () {
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
        $("#fee").on("focusout", function () {
            //get the value of current input
            var inputvalue = $(this).val();
            if (inputvalue === '') {
                //remove the filled class to show that the field is not valid yet
                $('button[type=submit]').attr('disabled', 'disabled');
                $(this).notify('Input cannot be left open', 'error');
                $(this).addClass('border-danger');
            } else {
                $(this).removeClass('border-danger');
                $(this).addClass('border-success');
                $('button[type=submit]').removeAttr('disabled');
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
            formdata.append('action', "addworkshop");
            formdata.append('title', $("#Title").val());
            formdata.append('description', $("#description").val());
            formdata.append('edition', $("#edition").val());
            formdata.append('event', $("#event").val());
            formdata.append('organisers', $("#organisers").val());
            formdata.append('speaker', $("#speaker").val());
            formdata.append('location', $("#location").val());
            formdata.append('fee', $("#fee").val());
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
                            text: "Workshop/Confrences added",
                            icon: "success",
                            button: true
                        }).then((result) => {
                            pagenav("workshoppage");
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
                            text: "Unable to Add Workshop/Confrences",
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
