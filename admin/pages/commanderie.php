<div id="manageuserspage">
    <div class="card">
        <div class="card-header">
            <h2 class="h6 text-uppercase mb-0 font-weight-bold text-center"> Commanderies List </h2>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-4">
                    <div class="form-group ">
                    </div>
                </div>  
                <div class="col-4"></div>
                <div class="col-4">
                    <button class=" btn btn-primary" id="Addnewimpact">Add New District</button>
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
                                <th>ID</th>
                                <th>Name</th>
                                <th>Location</th>
                                <th>District</th>
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
                <h5 class="modal-title">Edit Commanderies</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
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
            </form>
            </div>
        </div>
    </div>
</div>



<script>
    $(function () {
        pagename("Commanderie");
        $("#Addnewimpact").on("click", function () {
            pagenav("addcommanderie");
        });
        var workshoplistdatatable;
        var formdata = new FormData();
        formdata.append('action', "fetchallcommanderie");
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
                        data: feedback.commanderielist,
                        columns: [
                            {data: 'id'},
                            {data: 'indexnumber'},
                            {data: 'name'},
                            {data: 'location'},
                            {data: 'district'},
                            {data: feedback.commanderielist,
                                render: function (data, type, row) {
                                    return "<span class=''>\n\
                                            <a class='text-info editconference' id='" + row.id + "' data-toggle='modal' data-target='#edit_leave'><span class='mdi mdi-square-edit-outline mdi-20px'></span></a>\n\
                                            \n\
                                            <a class='text-danger deletenews' id='" + row.id + "' data-toggle='modal' data-target='#delete_approve'><span class='mdi mdi-delete-forever-outline mdi-20px'></span></a>\n\
                                      </span>";
                                }
                            }
                        ]
                    });


//                    //Edit conference info   
                    $(".editconference").on("click", function () {
                        $(".close").on('click', function () {
                            $("#editprojectmodal").modal('hide');
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
                        var projectid = $(this).attr('id');
                        $.post("process/server.php", {
                            action: "fetchcommanderiedetail",
                            projectid: projectid
                        }, function (feedback) {
                            feedback = JSON.parse(feedback);
                            if (feedback.response === true) {
                                $("#editprojectmodal").modal('show');
                                $.each(feedback.commanderdetail, function (key, value) {
                                    $("#title").val(value.name);
                                    $("#location").val(value.location);
                                    $("#districtlist").val(value.districtid);
                                    $("#index").val(value.indexnumber);
                                });
                                $('#title,#location,#districtlist,#index').on('change', function () {
                                    if ($(this).val() === '') {
                                        $(this).notify('This field needs data', 'info');
                                    } else {
                                        var columnname = $(this).attr('name');
                                        var dbvalue = $(this).val();
                                        $.post("process/server.php", {
                                            action: "updatecommanderiedetails",
                                            projectid: projectid,
                                            columnname: columnname,
                                            result: dbvalue
                                        }, function (feedback) {
                                            feedback = JSON.parse(feedback);
                                            if (feedback.response === true) {
                                                $.notify("Update Successful!", 'success');
                                                $("#editprojectmodal").modal('hide');
                                                pagenav("commanderie");
                                            } else if (feedback.response === false) {
                                                swal({
                                                    title: "Error Generated",
                                                    text: "Unable to Update Commanderie Details",
                                                    icon: "error",
                                                    button: false,
                                                    timer: 5000
                                                });
                                            } else if ((feedback.response === false) && (feedback.error.length > 0)) {
                                                swal({
                                                    title: "Error Generated",
                                                    text: "Unable to Update Commanderie Details",
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
                                    text: "Unable to Fetch Commanderie Details",
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
                            title: "You are about to delete this Commanderie?",
                            icon: "warning",
                            buttons: true,
                            dangerMode: true
                        }).then((willDelete) => {
                            if (willDelete) {
                                $.post("process/server.php", {
                                    action: "deletecommanderie",
                                    projectid: newsid
                                }, function (feedback) {
                                    feedback = JSON.parse(feedback);
                                    if (feedback.response === true) {
                                        swal({
                                            title: "Successful",
                                            text: "Commanderie deleted",
                                            icon: "success",
                                            button: true
                                        }).then((result) => {
                                            if (result === true) {
                                                pagenav("commanderie");
                                            }
                                        });
                                    } else if (feedback.response === false) {
                                        swal({
                                            title: "Error Generated",
                                            text: "Unable to delete Commanderie",
                                            icon: "error",
                                            button: false,
                                            timer: 5000
                                        });
                                    } else if ((feedback.response === false) && (feedback.error.length > 0)) {
                                        swal({
                                            title: "Error Generated",
                                            text: "Unable to delete Commanderie",
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
                        text: "Unable to Fetch Commanderie List",
                        icon: "error",
                        button: false,
                        timer: 5000
                    });
                    //                    swal("Error Generated", "User Not Signed In", "error");

                } else if ((feedback.response === false) && (feedback.error.length > 0)) {
                    swal({
                        title: "Error Generated",
                        text: "Unable to Fetch Commanderie List",
                        icon: "error",
                        button: false,
                        timer: 5000
                    });
                }

            }
        });
    });


</script>
