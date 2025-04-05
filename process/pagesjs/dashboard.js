//console.log("first L Page Loaded ");

$(function () {


//    console.log("Second L Page Loaded");
    $(document).trigger('load');

//    Load User Data
//    $(window).on('load', function () {
//    document.addEventListener("DOMContentLoaded", function () {
//        retrieve for Login User
//        console.log("Third L Page Loaded");
    $.post("../process/server.php",
            {action: 'retrivesessiondata'}, function (userdata) {
//                            console.log(userdata);
        userdata = JSON.parse(userdata);
        console.log("Response after processing : " + userdata.response);

        if (userdata.response === true) {
            $('#topuserfullname').html(userdata.othernames);
            $('#downuserfullname').html(userdata.othernames)
                    .append("<small class='pt-1'>" + userdata.username + "</small>");

        } else if (userdata.response === false) {
            $('#signout').trigger('click');
            console.log("Error Generated", "User Not Signed In", "error");

        } else if ((userdata.response === false) && (userdata.error.length > 0)) {
            console.log("Error Generated", userdata.error, "error");
        }
    });
    $(".page").on('click', function () {
        var pagename = $(this).attr('id');
        pagenav(pagename);
    });

    //  Menu Items on Click Load content
//    });


//    Check session on hover
    $(window).on('mouseover click', function (e) {
//        console.log("I am hovering");
//        /      Login User Check session
        $.post("../process/server.php",
                {action: 'checksession'}, function (feedback) {
//            console.log(feedback);
            feedback = JSON.parse(feedback);
//            console.log(feedback);
//            console.log("Session Expired : " + feedback.response);

            if (feedback.response === true) {
//                swal("Warning Generated", "Inactive for Long; User Logged out", "warning");
                swal({
                    title: "Warning Generated",
                    text: "Inactive for Long; User Logged out.",
                    icon: "warning",
                    button: false,
                    timer: 3000
                });
                setTimeout(function () {
                    $('#signout').trigger('click');
                }, 2700);

            } else if (feedback.response === false) {

            } else if ((feedback.response === false) && (feedback.error.length > 0)) {
                swal("Error Generated", feedback.error, "error");
            }
        });
    });
//news
    $("#viewall").on("click", function () {

    });

//});


//$(function () {

    //    Signing a User out
    $('#signout').on('click', function () {
        console.log("On click sign out");
        $.post("../process/server.php",
                {action: 'signout'}, function (feedback) {
            feedback = JSON.parse(feedback);
            if (feedback.response === true) {
                window.location.href = "login";
            } else if (feedback.response === false) {
                swal("Error Generated", "Unable to Sign Out Properly", "error");
            } else if ((feedback.response === false) && (feedback.error.length > 0)) {
                swal("Error Generated", feedback.error, "error");
            }
        }

        );
    });
    $.post("../process/server.php",
            {action: 'userprofile'
            }, function (feedback) {
        feedback = JSON.parse(feedback);
        if (feedback.response === true) {
            $.each(feedback.usersinfo, function (key, value) {
                $("#passportprofile").attr('src', value.passport);
                $("#passportprofile").attr('src', value.passport);
            });
        } else if (feedback.response === false) {
//                swal({
//                    title: "Error Generated",
//                    text: "Unable to Fetch Users Details",
//                    icon: "error",
//                    button: false,
//                    timer: 5000
//                });
        } else if ((feedback.response === false) && (feedback.error.length > 0)) {
//                swal({
//                    title: "Error Generated",
//                    text: "Unable to Fetch Details",
//                    icon: "error",
//                    button: false,
//                    timer: 5000
//                });
        }

    });
    //profile modal
    $("#profilemodal").on('click', function () {

        $("#editprofilemodal").modal('show');
        $.post("../process/server.php",
                {action: 'userprofile'
                }, function (feedback) {
            feedback = JSON.parse(feedback);
            if (feedback.response === true) {
                $.each(feedback.usersinfo, function (key, value) {
                    $("#Pfirstname").val(value.firstname);
                    $("#Pmiddlename").val(value.middlename);
                    $("#Plastname").val(value.lastname);
                    $("#Eemail").val(value.email);
                    $("#Pphonenumber").val(value.phonenumber);
                    $("#passportprofile").attr('src', value.passport);
                    console.log(value.passport);
                    $("#profileheader").text(value.firstname + " " + value.lastname + " " + "Profile");
                });
                $("#Pfirstname,#Pmiddlename,#Plastname").on('change', function () {
                    var attribute = $(this).attr('name');
                    //get the value of current input
                    var inputvalue = $(this).val();
                    //Regex makes sure every input value starts with a capital letter 
                    var textregex = /[A-Z][A-Za-z' -]+/;

                    //test if the regex validates the input value
                    if (!(textregex.test(inputvalue))) {
                        //remove the filled class to show that the field is not valid yet
                        $(this).notify('Wrong input format : Start Each Name with a Capital Letter', 'error');

                        if ($(this).val().length < 3) {
                            $(this).notify('Length too short, Enter more than 3 Letters', 'error');
                        }
                        $(this).addClass('border-danger');

                    } else {
                        $(this).removeClass('border-danger');
                        $(this).addClass('border-success');
                        $.post("../process/server.php", {
                            action: "updateuserprofile",
                            inputvalue: inputvalue, attribute: attribute
                        }, function (feedback) {
                            feedback = JSON.parse(feedback);
                            if (feedback.response === true) {
                                $.notify('Update Successful', 'success');
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
                        });
                    }
                });
                $("#Pphonenumber").on('change', function () {
                    var inputvalue = $(this).val();

                    //email regex 
                    var phoneregex = /^\+[0-9]{10,12}/;

                    //tests if the regex validates email
                    if (!(phoneregex.test(inputvalue))) {
                        $(this).notify('Empty or Wrong Phone Format', 'error');
                        $(this).addClass('border-danger');

                    } else {
                        $.post("process/formserver.php", {
                            action: "checkphonenumberexist", phonenumber: $(this).val()
                        }, function (feedback) {
                            feedback = JSON.parse(feedback);
//                    console.log(feedback);

                            if (feedback.response === true) {
                                $('#Pphonenumber').notify("Phone Exist in System Already", "error").addClass('border-danger');
                            } else if (feedback.response === false) {
                                $('#Pphonenumber').notify("Phone Accepted", "success").removeClass('border-danger').addClass('border-success');
                                var attribute = $(this).attr('name')
                                $.post("../process/server.php", {
                                    action: "updateuserprofile",
                                    inputvalue: inputvalue, attribute: attribute
                                }, function (feedback) {
                                    feedback = JSON.parse(feedback);
                                    if (feedback.response === true) {
                                        $.notify('Update Successful', 'success');
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
                                });

                            } else if ((feedback.response === false) && (feedback.error.length > 0)) {
                                $.notify(feedback.error, "error");
                                $('button[type=submit]').attr('disabled', 'disabled');
                            }

                        });

                    }
                })
            } else if (feedback.response === false) {
//                swal({
//                    title: "Error Generated",
//                    text: "Unable to Fetch Users Details",
//                    icon: "error",
//                    button: false,
//                    timer: 5000
//                });
            } else if ((feedback.response === false) && (feedback.error.length > 0)) {
//                swal({
//                    title: "Error Generated",
//                    text: "Unable to Fetch Details",
//                    icon: "error",
//                    button: false,
//                    timer: 5000
//                });
            }

        });
    });
    $("#con-password").on('focusout', function () {
        var conpassword = $(this).val();
        var password = $("#new-password").val();
        if (conpassword === password) {
            $("#new-password").removeClass('border-danger');
            $("#con-password").removeClass('border-danger');
            $('button[type=submit]').removeAttr('disabled');
        } else {
            $("#con-password").notify("Password do not match", 'error').addClass('border-danger');
            $("#con-password").focus();
            $("#new-password").addClass('border-danger').focus();
            $('button[type=submit]').attr('disabled', 'disabled');
        }
    })
    $("#passwordmodal").on('click', function () {
        $("#editpassmodal").modal('show');
        $('#changepassword').on('submit', function (event) {
            event.preventDefault();
            event.stopPropagation();
            //        Add User to Database
            $.post("../process/server.php", {
                action: "changepassword", oldpass: $('#oldpass').val(),
                newpass: $('#new-password').val()
            }, function (feedback) {
                console.log(feedback);
//                                feedback = JSON.parse(feedback);
//                                Ladda.stopAll();
//                                if (feedback.response === true) {
//                                    swal({
//                                        title: "Successful",
//                                        text: "Genre added",
//                                        icon: "success",
//                                        button: true,
//                                    }).then((result) => {
//                                        if (result === true) {
//                                            $.get("pages/managegenre.php", function (data) {
//                                                $("#pagecontent").html(data);
//                                            });
//                                        }
//                                    });
//
//                                    $("#addgenremodal").modal('hide');
//
//                                } else if (feedback.response === false) {
//                                    if (feedback.error.length > 0) {
//                                        swal({
//                                            title: "Error Generated",
//                                            text: feedback.error,
//                                            icon: "error",
//                                            button: false,
//                                            timer: 4000
//                                        });
//                                    } else if (feedback.warning.length > 0) {
//                                        swal({
//                                            title: "Warning Generated",
//                                            text: feedback.warning,
//                                            icon: "warning",
//                                            button: false,
//                                            timer: 5000
//                                        });
//                                    } else {
//                                        swal({
//                                            title: "Error Generated",
//                                            text: "Genre Could not be added",
//                                            icon: "error",
//                                            button: false,
//                                            timer: 4000
//                                        });
//                                    }
//                                }

            });

            console.log("FormSubmitted");
        });
    })
});
function pagename(data) {
    $("#pagenamedash").text(data);
}
function pagenav(newpage) {
    var path = 'pages/' + newpage + '.php';
    $("#pagecontent").empty();
//     $("#pagecontent").html(pagedata.filecontent);
    $.get(path, function (data) {
        if (data === '') {
            swal({
                title: "Error Generated:",
                text: "Page does not exit",
                icon: "error",
                button: false,
                timer: 4000
            });
             window.location.href = "dashboard";
        } else {
            $("#pagecontent").html(data);
        }
    });


}
