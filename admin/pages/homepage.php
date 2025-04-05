<div class="card">
    <div class="card-header">
        <h2 class="h6 text-uppercase mb-0 font-weight-bold text-center">Manage Home Page</h2>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <div class="form-group">
                        <label for="">Background Picture</label>
                        <input type="file" id="passport" name='backgroundimage' class="form-control" required="">
                    </div>
                </div>
            </div>
            <div class="col-6">
                <img  src="" id="" name='' class="float-right bgimage" alt="background image" style="height: 100px; width: 69%">
            </div>
        </div>
        <br>
        <div class="text-uppercase font-weight-bold text-light bg-dark">Carousel Information</div>
        <div class="row border-top">
            <div class="col-6">
                <div class="form-group">
                    <label for="">First Background Text</label>
                    <textarea type="text" class="form-control" id="maintext" name='backgroundtext' maxlength ="60"></textarea>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="">First Sub Text</label>
                    <textarea type="text" class="form-control" id="subtext" name='backgroundsubtext' maxlength ="40"> </textarea>
                </div>
            </div>
        </div>

        <div class="row border-top">
            <div class="col-6">
                <div class="form-group">
                    <label for="">Second Background Text</label>
                    <textarea type="text" class="form-control" id="twomaintext" name='secondbackgroundtext' maxlength ="60"></textarea>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="">Second Sub Text</label>
                    <textarea type="text" class="form-control" id="twosubtext" name='secondbackgroundsun' maxlength ="40"> </textarea>
                </div>
            </div>
        </div>
        <div class="row border-top">
            <div class="col-6">
                <div class="form-group">
                    <label for="">Third Background Text</label>
                    <textarea type="text" class="form-control" id="threemaintext" name='thirdbackgroundtext' maxlength ="60"></textarea>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="">Third Sub Text</label>
                    <textarea type="text" class="form-control" id="threesubtext" name='thirdbackgroundsun' maxlength ="40"> </textarea>
                </div>
            </div>
        </div>


        <div class="text-uppercase font-weight-bold text-light bg-dark">Knights of St.John International about</div>
        <div class="row border-top">
            <div class="col-6">
                <div class="form-group">
                    <label for="">Title</label>
                    <textarea type="text" class="form-control" id="firsttitle" name='firsttitle' maxlength ="15"></textarea>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="">Information</label>
                    <textarea type="text" class="form-control" id="firstinformation" name='firstinformation' maxlength ="80"> </textarea>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="">Title</label>
                    <textarea type="text" class="form-control" id="secondtitle" name='secondtitle' maxlength ="15"></textarea>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="">Information</label>
                    <textarea type="text" class="form-control" id="secondinformation" name='secondinformation' maxlength ="80"> </textarea>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="">Title</label>
                    <textarea type="text" class="form-control" id="thirdtitle" name='thirdtitle' maxlength ="15"></textarea>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="">Information</label>
                    <textarea type="text" class="form-control" id="thirdinfoormation" name='thirdinfoormation' maxlength ="80"> </textarea>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="">Title</label>
                    <textarea type="text" class="form-control" id="forthtitle" name='forthtitle' maxlength ="15"></textarea>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="">Information</label>
                    <textarea type="text" class="form-control" id="forthinformation" name='forthinformation' maxlength ="80"> </textarea>
                </div>
            </div>

        </div>
        <div class="text-uppercase font-weight-bold text-light bg-dark">Recent Workshop</div>
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="">Title</label>
                    <input type="text" id="workshoptitle" class="form-control" name="workshoptitle"required="">
                </div>
            </div> 
            <div class="col-6">
                <div class="form-group">
                    <label for="">Description</label>
                    <input type="text" class="form-control" id="workshopdescription" name="workshopdescription" required="">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="">Workshop-Image</label>
                    <input type="file" class="form-control" id="workshopimage" name="workshopimage" required="">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="">Preview</label>
                    <img  src="" id="workshopima" name='' class="float-right" alt="background image" style="height: 100px; width: 69%">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="">Work shop URL</label>
                    <input class="form-control" id="workshopurl" name="workshopurl" required="">
                </div>
            </div>

        </div>
    </div>
</div>

<script >
    $(function () {
        pagename("Homepage");
        $.post("process/server.php", {
            action: "fetchallbg"
        }, function (feedback) {
            feedback = JSON.parse(feedback);
            if (feedback.response === true) {
                $.each(feedback.bginfo, function (key, value) {
                    $('.bgimage').attr('src', value.backgroundimage);
                    $("#maintext").val(value.backgroundtext);
                    $("#subtext").val(value.backgroundsubtext);
                    $("#twomaintext").val(value.secondbackgroundtext);
                    $("#twosubtext").val(value.secondbackgroundsun);
                    $("#threemaintext").val(value.thirdbackgroundtext);
                    $("#threesubtext").val(value.thirdbackgroundsun);
                    $("#testimonial").val(value.Testimonials);
                    $("#announcement").text(value.Announcement);
                    $("#announcement2").attr('href', value.links);
                    $("#firsttitle").text(value.firsttitle);
                    $("#firstinformation").text(value.firstinformation);
                    $("#secondtitle").text(value.secondtitle);
                    $("#secondinformation").text(value.secondinformation);
                    $("#thirdtitle").text(value.thirdtitle);
                    $("#thirdinfoormation").text(value.thirdinfoormation);
                    $("#forthtitle").text(value.forthtitle);
                    $("#forthinformation").text(value.forthinformation);
                    $("#workshoptitle").val(value.workshoptitle);
                    $("#workshopdescription").val(value.workshopdescription);
                    $("#workshopurl").val(value.workshopurl);
                    $('#workshopima').attr('src', value.workshopimage);

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
                                    $(".bgimage").attr("src", e.target.result);
                                    $.post("process/server.php", {
                                        action: "updatebgnames",
                                        inputvalue: e.target.result, attribute: "backgroundimage"
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
                $("#workshopimage").on('change', function () {
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
//                                    var preview = $(this).attr('id');
                                    $("#workshopima").attr("src", e.target.result);
                                    var attribute = $(this).attr('name');
                                    $.post("process/server.php", {
                                        action: "updatebgnames",
                                        inputvalue: e.target.result, attribute: 'workshopimage'
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




                $("#maintext,#subtext,#twomaintext,#twosubtext,#threemaintext,#threesubtext,#testimonial,#announcement,#announcement2,\n\
        #firsttitle,#firstinformation,#secondtitle,#secondinformation,#thirdtitle,#thirdinfoormation,#forthtitle,#forthinformation,#workshoptitle,#workshopdescription,#workshopurl").on("change focusout", function () {
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
                        $.post("process/server.php", {
                            action: "updatebgnames",
                            inputvalue: inputvalue, attribute: attribute
                        }, function (feedback) {
                            feedback = JSON.parse(feedback);
                            if (feedback.response === true) {
                                $.notify('Update Successfully', "success");
                            } else if (feedback.response === false) {
                                swal({
                                    title: "Error Generated",
                                    text: "Unable to to Update background",
                                    icon: "error",
                                    button: false,
                                    timer: 5000
                                });
                            } else if ((feedback.response === false) && (feedback.error.length > 0)) {
                                swal({
                                    title: "Error Generated",
                                    text: "Unable to Update background",
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


