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
                            <label for="">Project file</label>
                            <input type="file" class="form-control" id="uploadproject" required="">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="">Project Status</label>
                            <select class="form-control" id="projectstatus" required="">
                                <option value=" "> Select Project status</option>
                                <option value="CurrentProject"> Current Project</option>
                                <option value="PastProject"> Past Project</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-footer pt-2  mt-2 border-top text-center">
                    <button type="submit" class="btn btn-outline-success" data-style="expand-right" ><i class="mdi mdi-account-plus-outline"></i>  Add Project</button>&nbsp;&nbsp;&nbsp;&nbsp;
                    <button type="reset" class="btn btn-outline-secondary" data-style="expand-right" ><i class="mdi mdi-account-convert"></i> Reset Form</button>
                </div>
            </form>
        </div>


    </div>
</div>




<script>
    $(function () {
        pagename("About us");

        $("#Title").on("focusout", function () {
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
        $("#year,#projectstatus").on("focusout", function () {
            //get the value of current input
            var inputvalue = $(this).val();
            if (inputvalue === '') {
                //remove the filled class to show that the field is not valid yet
                $('button[type=submit]').attr('disabled', 'disabled');
                $(this).notify('Wrong input format : Start Each Name with a Capital Letter', 'error');
                $(this).addClass('border-danger');
            } else {
                $(this).removeClass('border-danger');
                $(this).addClass('border-success');
                $('button[type=submit]').removeAttr('disabled');
            }
        });



        $("#projectform").on('submit', function (event) {
            event.preventDefault();
            event.stopPropagation();
            //post news information to the database.
            var formdata = new FormData();
            var files = $('#uploadproject')[0].files;
            formdata.append('file', files[0]);
            formdata.append('action', "addproject");
            formdata.append('title', $("#Title").val());
            formdata.append('year', $("#year").val());
            formdata.append('status', $("#projectstatus").val());
            $.ajax({
                url: 'process/server.php',
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
                            text: "Project added",
                            icon: "success",
                            button: true
                        }).then((result) => {
                            pagenav("projectpage");
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
                            text: "Unable to Add Project",
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
