$(function () {
    Ladda.bind('button[type=submit]');

    $('#signinform').on('submit', function (event) {

        event.preventDefault();
        event.stopPropagation();

        email = $('#email');
        password = $('#password');


        if (email.val() === "") {
            email.notify("Username Empty", "error").focus().addClass('border-danger');
//            Ladda.stopAll();

        } else if (password.val() === "") {
            password.notify("Password Empty", "error").focus().addClass('border-danger');
//            Ladda.stopAll();

        } else if ((email !== "") && (password.val() !== "")) {
            password.removeClass('border-danger').addClass('border-success');
            email.removeClass('border-danger').addClass('border-success');


            console.log("Page submited");
            $.post("process/server.php",
                    {email: email.val(), password: password.val(), action: 'signin'}, function (feedback) {
//                    console.log(feedback)
                feedback = JSON.parse(feedback);
                    console.log("Response after processing : " + feedback.response);

                if (feedback.response === true) {
//                        Ladda.stopAll();
                    window.location.href = "dashboard";

                } else if (feedback.response === false) {
                    Ladda.stopAll();
                    $('#password').focus().removeClass('border-success').addClass('border-danger');
                    $.notify(" Invalid Login Credentials ", "error");
                    
//                        swal("Error Generated", "Invalid Login Credentials!", "error");

                } else {
                    Ladda.stopAll();
                    $('#email').focus().removeClass('border-success').addClass('border-danger');
                    $.notify(feedback.response, "error");
                    
//                        swal("Error Generated", feedback.response, "error");
                }
            });

        } else {
            console.log("Invalid");
        }


    });


});
