<div id="manageuserspage">
    <div class="card">
        <div class="card-header">
            <h2 class="h6 text-uppercase mb-0 font-weight-bold text-center">Add Commanderie</h2>
        </div>
        <div class="card-body">
            <form action="#" method="POST" id="projectform" >
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="">Name</label>
                            <input type="text" id="title" class="form-control" name="name" placeholder="Enter Name of Commanderies" required="">
                        </div>
                    </div> 
                </div>
                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label for="">ID</label>
                            <input type="text" id="index" class="form-control" name="indexnumber" placeholder="Enter ID of Commanderies" required="">
                        </div>
                    </div> 
                    <div class="col-4">
                        <div class="form-group">
                            <label for="">Location</label>
                            <input type="text" id="location" class="form-control" name="location" placeholder="Enter Location of Commanderies" required="">
                        </div>
                    </div> 
                    <div class="col-4">
                        <div class="form-group">
                            <label for="">District</label>
                            <select class="form-control" id="districtlist">

                            </select>
                            <!--<input type="text" id="location" class="form-control" name="location" placeholder="Enter Location of Commanderies" required="">-->
                        </div>
                    </div> 
                </div>
                <div class="form-footer pt-2  mt-2 border-top text-center">
                    <button type="submit" class="btn btn-outline-success" data-style="expand-right" ><i class="mdi mdi-account-plus-outline"></i>  Add Commanderie</button>&nbsp;&nbsp;&nbsp;&nbsp;
                    <button type="reset" class="btn btn-outline-secondary" data-style="expand-right" ><i class="mdi mdi-account-convert"></i> Reset Form</button>
                </div>
            </form>
        </div>


    </div>
</div>




<script>
    $(function () {
        pagename("Commanderie");

        $("#title,#location").on("focusout", function () {
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
        $("#index,#districtlist").on("focusout", function () {
            //get the value of current input
            var inputvalue = $(this).val();
            if (inputvalue === ' ') {
                //remove the filled class to show that the field is not valid yet
                $('button[type=submit]').attr('disabled', 'disabled');
                $(this).notify('input field cannot be empty : ', 'error');
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
            formdata.append('action', "addcommanderie");
            formdata.append('title', $("#title").val());
            formdata.append('location', $("#location").val());
            formdata.append('index', $("#index").val());
            formdata.append('districtlist', $("#districtlist").val());
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
                            text: "Commanderie added",
                            icon: "success",
                            button: true
                        }).then((result) => {
                            pagenav("commanderie");
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
                            text: "Unable to Add Commanderie",
                            icon: "error",
                            button: false,
                            timer: 5000
                        });
                    }


                }
            });

        });

        //fetching all district
        $.post("process/server.php", {
            action: "fetchalldistrict"
        }, function (feedback) {
            feedback = JSON.parse(feedback);
            if (feedback.response === true) {
                $("#districtlist").append("<option value=' '>Select a District</option>");
                $.each(feedback.districtlist, function (key, value) {
                    $("#districtlist").append("<option value='" + value.id + "'>" + value.title + "</option>");
                });
            }
        });
    });
</script>
