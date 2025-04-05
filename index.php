<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Work Shop Registration Form</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
         <link href="images/logo2.jpg" rel="icon">
         <link href="images/logo2.jpg" rel="apple-touch-icon"><!-- comment -->
        <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <script src="vendor/jquery-3.5.1/jquery-3.5.1.min.js" type="text/javascript"></script>
        <script src="vendor/bootstrap/js/popper.min.js" type="text/javascript"></script>
        <script src="vendor/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <!-- MATERIAL DESIGN ICONIC FONT -->
        <link rel="stylesheet" href="fonts/material-design-iconic-font/css/material-design-iconic-font.min.css">
        <script src="vendor/sweetalert.js" type="text/javascript"></script>
        <script src="vendor/notify.min.js" type="text/javascript"></script>
        <!-- STYLE CSS -->
        <link rel="stylesheet" href="css/style.css">
        <script src="https://js.paystack.co/v1/inline.js"></script>
    </head>

    <body>
        <!--<div class="m-4">-->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark text-white">
            <div class="container-fluid">
                <a href="index.php" class="navbar-brand">
                    <img src="images/logo2.jpg" height="28" alt="Work shop Brand">
                </a>
                <center><h2 id="titleworkshop"></h2></center>
                <!--                    <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                                        <span class="navbar-toggler-icon"></span>
                                    </button>-->
                <!--                    <div class="collapse navbar-collapse" id="navbarCollapse">
                                        <div class="navbar-nav">
                                            <a href="#" class="nav-item nav-link active">Home</a>
                                            <a href="#" class="nav-item nav-link">Profile</a>
                                            <a href="#" class="nav-item nav-link">Messages</a>
                                            <a href="#" class="nav-item nav-link disabled" tabindex="-1">Reports</a>
                                        </div>
                                        <div class="navbar-nav ms-auto">
                                            <a href="#" class="nav-item nav-link">Login</a>
                                        </div>
                                    </div>-->
                <a href="index.php" class="navbar-brand">
                    <img src="images/logo1.jpg" height="28" alt="School Logo">
                </a>
            </div>
        </nav>
        <!--</div>-->

        <div class="wrapper" style="">
            <!--<div class="wrapper" style="background-image: url('images/bg-registration-form-3.jpg');">-->
            <div class="inner">
                <form action="" id="worshopform">
                    <h3>Registration Form</h3>
                    <div class="form-group">
                        <div class="form-wrapper">
                            <label for="">Firstname:</label>
                            <div class="form-holder">
                                <i class="zmdi zmdi-account-o"></i>
                                <input type="text" class="form-control" id="firstname" required="" placeholder="kelly">
                            </div>
                        </div>
                        <div class="form-wrapper">
                            <label for="">Middlename:(Optional)</label>
                            <div class="form-holder">
                                <i class="zmdi zmdi-account-o"></i>
                                <input type="text" class="form-control" id="middlename">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-wrapper">
                            <label for="">Surname:</label>
                            <div class="form-holder">
                                <i class="zmdi zmdi-account-o"></i>
                                <input type="text" class="form-control" placeholder="" id="surname" required="" placeholder="kent">
                            </div>
                        </div>
                        <div class="form-wrapper">
                            <label for="">Email:</label>
                            <div class="form-holder">
                                <i style="font-style: normal; font-size: 15px;">@</i>
                                <input type="text" class="form-control" id="email" required="" autocomplete="off" placeholder="name@email.com">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-wrapper">
                            <label for="">Contact:</label>
                            <div class="form-holder">
                                <i class="zmdi zmdi-account-box-phone"></i>
                                <input type="text" class="form-control" id="contact" required="" autocomplete="off" placeholder="+233111111111">
                            </div>
                        </div>
                        <!--                        <div class="form-wrapper">
                                                    <label for="">Gender:</label>
                                                    <div class="form-holder select">
                                                        <select name="" id="" class="form-control">
                                                            <option value="male">Male</option>
                                                            <option value="femal">Female</option>
                                                            <option value="other">Other</option>
                                                        </select>
                                                        <i class="zmdi zmdi-face"></i>
                                                    </div>
                                                </div>-->
                    </div>
                    <div class="form-end">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" id="registrationtype">CERTIFICATE <b id="pricetag">(30GH).</b>
                                <span class="checkmark"></span>
                            </label>
                        </div>
                    </div>
                    <b><p>CERTIFICATION IS AUTHORIZED BY: Professor Daniels Obeng-Ofori and Professor Felix Adebayo Adekoya</p></b>
                    <div class="row mt-5">
                        <div class="col-4"></div>
                        <div class="col-4">
                            <center>
                                <div class="button-holder">
                                    <button type="submit" id="sub">Register Now</button>
                                </div>
                            </center>
                        </div>
                        <div class="col-4"></div>

                    </div>
                </form>
            </div>
        </div>
        <div class="footer footer-expand bg-dark">

        </div>

    </body>
    <script>

        $(function () {
            var certificateprice = '';
            var attachmentname = '';
            var workshoptitle = '';
            $.post("process/server.php", {
                action: "fetchallbg"
            }, function (feedback) {
                feedback = JSON.parse(feedback);
                if (feedback.response === true) {
                    $.each(feedback.bginfo, function (key, value) {
                        $("#titleworkshop").text(value.workshoptitle);
                        $("#price").val(value.workshopprice);
                        $("#pricetag").text("("+value.workshopprice+")");
                        
                        certificateprice = value.workshopprice;
                        attachmentname = value.workshopattactment;
                        workshoptitle = value.workshoptitle;
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


            $('#firstname, #surname').on('focusout', function () {
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
            $('#middlename').on('input', function () {
                var inputvalue = $(this).val();
                //Regex makes sure every input value starts with a capital letter 
                var textregex = /[A-Z][A-Za-z' -]+/;
                //test if the regex validates the input value
                if (!(textregex.test(inputvalue))) {
                    //remove the filled class to show that the field is not valid yet
//                    $('button[type=submit]').attr('disabled', 'disabled');
                    $(this).notify('Wrong input format : Start Each Name with a Capital Letter', 'error');
                    if ($(this).val().length < 3) {
                        $(this).notify('Length too short, Enter more than 3 Letters', 'error');
                    }
                    $(this).addClass('border-danger');
                } else {
                    $(this).removeClass('border-danger');
                    $(this).addClass('border-success');
//                    $('button[type=submit]').removeAttr('disabled');
                }
            });

//        Check if Email Exist in system Already
            $('#email').on('focusout', function () {
                //get the email entered
                var inputvalue = $(this).val();
                //email regex 
                var emailregex = /[a-zA-Z0-9_\.\+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-\.]+/;
                //tests if the regex validates email
                if (!(emailregex.test(inputvalue))) {
                    $('button[type=submit]').attr('disabled', 'disabled');
                    $(this).notify('Empty or Wrong Email Format', 'error');
                    $(this).addClass('border-danger');
                } else {
                    $.post("process/formserver.php", {
                        action: "checkemailexist", email: $(this).val()
                    }, function (feedback) {
                        feedback = JSON.parse(feedback);
//                    console.log(feedback);
                        if (feedback.response === true) {
                            $('#email').notify("Email Exist in System Already", "error").addClass('border-danger');
                            $('button[type=submit]').attr('disabled', 'disabled');
                        } else if (feedback.response === false) {
                            $('#email').notify("Email Accepted", "success").removeClass('border-danger').addClass('border-success');
                            $('button[type=submit]').removeAttr('disabled');
                        } else if ((feedback.response === false) && (feedback.error.length > 0)) {
                            $.notify(feedback.error, "error");
                            $('button[type=submit]').attr('disabled', 'disabled');
                        }
                    });

                }

            });

            //        Check if Phone Number Exist in system Already
            $('#contact').on('focusout', function () {
                //get the email entered
                var inputvalue = $(this).val();

                //email regex 
                var phoneregex = /^\+[0-9]{10,12}/;

                //tests if the regex validates email
                if (!(phoneregex.test(inputvalue))) {
                    $('button[type=submit]').attr('disabled', 'disabled');
                    $(this).notify('Empty or Wrong Phone Format', 'error');
                    $(this).addClass('border-danger');

                } else {

                    $.post("process/formserver.php", {
                        action: "checkphonenumberexist", phonenumber: $(this).val()
                    }, function (feedback) {
                        feedback = JSON.parse(feedback);
                        if (feedback.response === true) {
                            $('#contact').notify("Phone Exist in System Already", "error").addClass('border-danger');
                            $('button[type=submit]').attr('disabled', 'disabled');

                        } else if (feedback.response === false) {
                            $('#contact').notify("Phone Accepted", "success").removeClass('border-danger').addClass('border-success');
                            $('button[type=submit]').removeAttr('disabled');

                        } else if ((feedback.response === false) && (feedback.error.length > 0)) {
                            $.notify(feedback.error, "error");
                            $('button[type=submit]').attr('disabled', 'disabled');
                        }

                    });

                }

            });

            $('#registrationtype').change(function () {
                if (this.checked) {
//                    $('#sub').val('');
//                    $('button[type=submit]').val('Processing…');
//                    alert('Checkbox checked!');
//                    payWithPaystack();
                } else {
//                    $('button[type=submit]').val('Register…');
//                    alert('unCheckbox checked!');


                }
//                checkDetails(this);
//                console.log($(this).val());
            });
            $("#registrationtype").on('hover', function () {

            });

            $('#worshopform').on('submit', function (event) {
                event.preventDefault();
                event.stopPropagation();
                if ($('#registrationtype').is(':checked')) {
                    payWithPaystack($('#email').val(), certificateprice, attachmentname, workshoptitle);

                } else {
                    //                Add User to Database
                    $.post("process/server.php", {
                        action: "adduser", email: $('#email').val(), firstname: $('#firstname').val(), surname: $('#surname').val(),
                        middlename: $('#middlename').val(), phonenumber: $('#contact').val(), attachmentname: attachmentname, workshoptitle: workshoptitle,
                        signupmethod: '1'
                    }, function (feedback) {
                        console.log(feedback);
                        feedback = JSON.parse(feedback);


                        if (feedback.response === true) {
                            swal({
                                title: "Successful",
                                text: "Registration Successful, Email Sent",
                                icon: "success",
                                button: true
                            }).then((result) => {
                                location.reload(true);
                            });

                        } else if (feedback.response === false) {
                            if (feedback.error.length > 0) {
                                swal({
                                    title: "Error Generated",
                                    text: feedback.error,
                                    icon: "error",
                                    button: false,
                                    timer: 4000
                                });

                            } else if (feedback.warning.length > 0) {
                                swal({
                                    title: "Warning Generated",
                                    text: feedback.warning,
                                    icon: "warning",
                                    button: false,
                                    timer: 5000
                                });

                            } else {
                                swal({
                                    title: "Error Generated",
                                    text: "User Could not be added",
                                    icon: "error",
                                    button: false,
                                    timer: 4000
                                });
                            }
                        }

                    });

                    console.log("FormSubmitted");



                }


            });

        });


        function payWithPaystack(email, price, attachmentname, workshoptitle) {

            var handler = PaystackPop.setup({
                key: 'pk_live_df1e933cd024b8f51d110e1a0dd182a4f7af341b', //put your public key here
                email: "miracleatianashie81@gmail.com", //put your customer's email here
                amount: price * 100, //amount the customer is supposed to pay
                currency: "GHS",
                message: "You are to pay 30 GH for the certificate",
                metadata: {
                    custom_fields: [
                        {
                            display_name: "Mobile Number",
                            variable_name: "mobile_number",
                            value: "+2348012345678" //customer's mobile number
                        }
                    ]
                },
                callback: function (response) {
                    //after the transaction have been completed
                    //make post call  to the server with to verify payment 
                    //using transaction reference as post data
                    $.post("process/server.php", {action: 'verifypayment', reference: response.reference}, function (status) {
                        if (status == "success") {
                            //successful transaction
                            alert('Transaction was successful');
                            adduser(attachmentname, workshoptitle);
                        } else {
                            swal({
                                title: "Transaction Failed",
                                text: response,
                                icon: "error",
                                button: false,
                                timer: 4000
                            });
                        }
                    });
                },
                onClose: function () {
                    //when the user close the payment modal
                    swal({
                        title: "Transaction cancelled",
                        text: "Registration Successful",
                        icon: "error",
                        button: false,
                        timer: 4000
                    });
                }
            });
            handler.openIframe(); //open the paystack's payment modal
        }
        function adduser(attachmentname, workshoptitle) {
            //                Add User to Database
            $.post("process/server.php", {
                action: "adduser", email: $('#email').val(), firstname: $('#firstname').val(), surname: $('#surname').val(),
                middlename: $('#middlename').val(), phonenumber: $('#contact').val(), attachmentname: attachmentname, workshoptitle: workshoptitle,
                signupmethod: '0'
            }, function (feedback) {
                feedback = JSON.parse(feedback);
                console.log(feedback);


                if (feedback.response === true) {
                    swal({
                        title: "Successful",
                        text: "Registration Successful, Email Sent",
                        icon: "success",
                        button: true
                    }).then((result) => {
                        location.reload(true);
                    });

                } else if (feedback.response === false) {
                    if (feedback.error.length > 0) {
                        swal({
                            title: "Error Generated",
                            text: feedback.error,
                            icon: "error",
                            button: false,
                            timer: 4000
                        });

                    } else if (feedback.warning.length > 0) {
                        swal({
                            title: "Warning Generated",
                            text: feedback.warning,
                            icon: "warning",
                            button: false,
                            timer: 5000
                        });

                    } else {
                        swal({
                            title: "Error Generated",
                            text: "User Could not be added",
                            icon: "error",
                            button: false,
                            timer: 4000
                        });
                    }
                }

            });
        }

    </script>
</html>