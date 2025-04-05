<div id="manageuserspage">
    <div class="card">
        <div class="card-header">
            <h2 class="h6 text-uppercase mb-0 font-weight-bold text-center">Add About us</h2>
        </div>
        <div class="card-body">
            <form action="#" method="POST" id="editnewsform" >
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
                            <label for="">Full news</label>
                            <div id="fullnew" name="fullnews"></div>
                        </div>
                    </div>
                </div>
                <div class="form-footer pt-2  mt-2 border-top text-center">
                    <button type="submit" class="btn btn-outline-success" data-style="expand-right" ><i class="mdi mdi-account-plus-outline"></i>  Add About</button>&nbsp;&nbsp;&nbsp;&nbsp;
                    <button type="reset" class="btn btn-outline-secondary" data-style="expand-right" ><i class="mdi mdi-account-convert"></i> Reset Form</button>
                </div>
            </form>
        </div>


    </div>
</div>




<script>
    $(function () {
      pagename("About us");
        let toolbar = [
            ["bold", "italic", "underline", "strick"],
            [{header: [1, 2, 3, 4, 5, 6, false]}],
            [{size: ["small", "large", "huge", false]}],
            [{list: "ordered"}, {list: "bullet"}],
            ["links", "image", "video", "formula"],
            [{script: "sub"}, {script: "super"}],
            [{indent: "+1"}, {indent: "-1"}],
            [{color: []}, {background: []}],
            [{font: []}],
            [{align: []}],
            ["code-block"]
        ];
        let quill = new Quill('#fullnew', {
            modules: {
                toolbar: toolbar
            }, theme: 'snow'
        });
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
        $("#editnewsform").on('submit', function (event) {
            quill.on('selection-change ', function (range, oldRange, source) {
                if (range) {
                    if (range.length == 0) {
                        $('button[type=submit]').attr('disabled', 'disabled');
                        $(this).notify('Wrong input format', 'error');
                        $(this).addClass('border-danger');
                    } else {
                        $(this).removeClass('border-danger');
                        $(this).addClass('border-success');
                        $('button[type=submit]').removeAttr('disabled');
                    }
                } else {
                    console.log('Cursor not in the editor');
                }
            });
            event.preventDefault();
            event.stopPropagation();
            //post news information to the database.
            var formdata = new FormData();
            var myEditor = document.querySelector('#fullnew');
            var html = myEditor.children[0].innerHTML;
            formdata.append('action', "addabout");
            formdata.append('content', html);
            formdata.append('title', $("#Title").val());

            $.ajax({
                url: 'process/server.php',
                type: 'post',
                data: formdata,
                contentType: false,
                processData: false,
                success: function (feedback) {
                    console.log(feedback);
                    feedback = JSON.parse(feedback);
                    if (feedback.response === true) {
                        swal({
                            title: "Successful",
                            text: "About added",
                            icon: "success",
                            button: true
                        }).then((result) => {
                            $.get("Pages/manageaboutus.php", function (data) {
                                $("#pagecontent").html(data);
                            });
                        });
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


                }
            });

        });

        quill.on('selection-change ', function (range, oldRange, source) {
            if (range) {
                if (range.length == 0) {
                    $('button[type=submit]').attr('disabled', 'disabled');
                    $(this).notify('Wrong input format', 'error');
                    $(this).addClass('border-danger');
                } else {
                    $(this).removeClass('border-danger');
                    $(this).addClass('border-success');
                    $('button[type=submit]').removeAttr('disabled');
                }
            } else {
                console.log('Cursor not in the editor');
            }
        });
    });
</script>
