<style>
    #upload {
        opacity: 0;
    }

    #upload-label {
        position: absolute;
        top: 50%;
        left: 1rem;
        transform: translateY(-50%);
    }

    .image-area {
        border: 2px dashed rgba(255, 255, 255, 0.7);
        padding: 1rem;
        /*position: relative;*/
    }

    .image-area::before {
        content: 'Uploaded image result';
        color: #fff;
        font-weight: bold;
        text-transform: uppercase;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 0.8rem;
        z-index: 1;
    }

    .image-area img {
        z-index: 2;
        position: relative;
    }
    #imageResult{
        height: 199px;
        width: 65%;
        margin-top: -39px;
    }
</style>
<div class="card">
    <div class="card-header  bg-dark">
        <h2 class="h6 text-capitalize mb-0 text-center text-light ">Governance Registration</h2>
    </div>
    <div class="card-body ">
        <form action="#" method="POST" id="adduserform" >
            <div class="text-uppercase font-weight-bold text-light bg-dark">Personal Information</div>
            <div class="row border-top">
                <div class="col-6">
                    <!-- Upload image input-->
                    <div class="input-group mb-3 px-2 py-2 rounded-pill bg-white shadow-sm">
                        <input id="upload" type="file" onchange="readURL(this);" class="form-control border-0">
                        <label id="upload-label" for="upload" class="font-weight-light text-muted">Choose Profile</label>
                        <div class="input-group-append">
                            <label for="upload" class="btn btn-light m-0 rounded-pill px-4"> <i class="fa fa-cloud-upload mr-2 text-muted"></i><small class="text-uppercase font-weight-bold text-muted">Choose file</small></label>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="image-area mt-4">
                        <img id="imageResult" src="assets/img/user/defaultuser.png" alt="" class="img-thumbnail rounded shadow-sm mx-auto d-block">
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="">Title</label>
                        <input type="text" id="title" class="form-control" placeholder="DR.MR.SR" required="">
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="">Full Name</label>
                        <input type="text" id="fullname" class="form-control" placeholder="Kelly">
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="">Nationality</label>
<!--                        <input type="text" class="form-control" id="nation" required="" placeholder="ghana">-->
                        <select class="form-select form-control" id="nation" name="country" required="">
                            <option value="null">Select Country</option>
                            <option value="Afghanistan">Afghanistan</option>
                            <option value="Aland Islands">Aland Islands</option>
                            <option value="Albania">Albania</option>
                            <option value="Algeria">Algeria</option>
                            <option value="American Samoa">American Samoa</option>
                            <option value="Andorra">Andorra</option>
                            <option value="Angola">Angola</option>
                            <option value="Anguilla">Anguilla</option>
                            <option value="Antarctica">Antarctica</option>
                            <option value="Antigua and Barbuda">Antigua and Barbuda</option>
                            <option value="Argentina">Argentina</option>
                            <option value="Armenia">Armenia</option>
                            <option value="Aruba">Aruba</option>
                            <option value="Australia">Australia</option>
                            <option value="Austria">Austria</option>
                            <option value="Azerbaijan">Azerbaijan</option>
                            <option value="Bahamas">Bahamas</option>
                            <option value="Bahrain">Bahrain</option>
                            <option value="Bangladesh">Bangladesh</option>
                            <option value="Barbados">Barbados</option>
                            <option value="Belarus">Belarus</option>
                            <option value="Belgium">Belgium</option>
                            <option value="Belize">Belize</option>
                            <option value="Benin">Benin</option>
                            <option value="Bermuda">Bermuda</option>
                            <option value="Bhutan">Bhutan</option>
                            <option value="Bolivia">Bolivia</option>
                            <option value="Bonaire, Sint Eustatius and Saba">Bonaire, Sint Eustatius and Saba</option>
                            <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
                            <option value="Botswana">Botswana</option>
                            <option value="Bouvet Island">Bouvet Island</option>
                            <option value="Brazil">Brazil</option>
                            <option value="British Indian Ocean Territory">British Indian Ocean Territory</option>
                            <option value="Brunei Darussalam">Brunei Darussalam</option>
                            <option value="Bulgaria">Bulgaria</option>
                            <option value="Burkina Faso">Burkina Faso</option>
                            <option value="Burundi">Burundi</option>
                            <option value="Cambodia">Cambodia</option>
                            <option value="Cameroon">Cameroon</option>
                            <option value="Canada">Canada</option>
                            <option value="Cape Verde">Cape Verde</option>
                            <option value="Cayman Islands">Cayman Islands</option>
                            <option value="Central African Republic">Central African Republic</option>
                            <option value="Chad">Chad</option>
                            <option value="Chile">Chile</option>
                            <option value="China">China</option>
                            <option value="Christmas Island">Christmas Island</option>
                            <option value="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option>
                            <option value="Colombia">Colombia</option>
                            <option value="Comoros">Comoros</option>
                            <option value="Congo">Congo</option>
                            <option value="Congo, Democratic Republic of the Congo">Congo, Democratic Republic of the Congo</option>
                            <option value="Cook Islands">Cook Islands</option>
                            <option value="Costa Rica">Costa Rica</option>
                            <option value="Cote D'Ivoire">Cote D'Ivoire</option>
                            <option value="Croatia">Croatia</option>
                            <option value="Cuba">Cuba</option>
                            <option value="Curacao">Curacao</option>
                            <option value="Cyprus">Cyprus</option>
                            <option value="Czech Republic">Czech Republic</option>
                            <option value="Denmark">Denmark</option>
                            <option value="Djibouti">Djibouti</option>
                            <option value="Dominica">Dominica</option>
                            <option value="Dominican Republic">Dominican Republic</option>
                            <option value="Ecuador">Ecuador</option>
                            <option value="Egypt">Egypt</option>
                            <option value="El Salvador">El Salvador</option>
                            <option value="Equatorial Guinea">Equatorial Guinea</option>
                            <option value="Eritrea">Eritrea</option>
                            <option value="Estonia">Estonia</option>
                            <option value="Ethiopia">Ethiopia</option>
                            <option value="Falkland Islands (Malvinas)">Falkland Islands (Malvinas)</option>
                            <option value="Faroe Islands">Faroe Islands</option>
                            <option value="Fiji">Fiji</option>
                            <option value="Finland">Finland</option>
                            <option value="France">France</option>
                            <option value="French Guiana">French Guiana</option>
                            <option value="French Polynesia">French Polynesia</option>
                            <option value="French Southern Territories">French Southern Territories</option>
                            <option value="Gabon">Gabon</option>
                            <option value="Gambia">Gambia</option>
                            <option value="Georgia">Georgia</option>
                            <option value="Germany">Germany</option>
                            <option value="Ghana">Ghana</option>
                            <option value="Gibraltar">Gibraltar</option>
                            <option value="Greece">Greece</option>
                            <option value="Greenland">Greenland</option>
                            <option value="Grenada">Grenada</option>
                            <option value="Guadeloupe">Guadeloupe</option>
                            <option value="Guam">Guam</option>
                            <option value="Guatemala">Guatemala</option>
                            <option value="Guernsey">Guernsey</option>
                            <option value="Guinea">Guinea</option>
                            <option value="Guinea-Bissau">Guinea-Bissau</option>
                            <option value="Guyana">Guyana</option>
                            <option value="Haiti">Haiti</option>
                            <option value="Heard Island and Mcdonald Islands">Heard Island and Mcdonald Islands</option>
                            <option value="Holy See (Vatican City State)">Holy See (Vatican City State)</option>
                            <option value="Honduras">Honduras</option>
                            <option value="Hong Kong">Hong Kong</option>
                            <option value="Hungary">Hungary</option>
                            <option value="Iceland">Iceland</option>
                            <option value="India">India</option>
                            <option value="Indonesia">Indonesia</option>
                            <option value="Iran, Islamic Republic of">Iran, Islamic Republic of</option>
                            <option value="Iraq">Iraq</option>
                            <option value="Ireland">Ireland</option>
                            <option value="Isle of Man">Isle of Man</option>
                            <option value="Israel">Israel</option>
                            <option value="Italy">Italy</option>
                            <option value="Jamaica">Jamaica</option>
                            <option value="Japan">Japan</option>
                            <option value="Jersey">Jersey</option>
                            <option value="Jordan">Jordan</option>
                            <option value="Kazakhstan">Kazakhstan</option>
                            <option value="Kenya">Kenya</option>
                            <option value="Kiribati">Kiribati</option>
                            <option value="Korea, Democratic People's Republic of">Korea, Democratic People's Republic of</option>
                            <option value="Korea, Republic of">Korea, Republic of</option>
                            <option value="Kosovo">Kosovo</option>
                            <option value="Kuwait">Kuwait</option>
                            <option value="Kyrgyzstan">Kyrgyzstan</option>
                            <option value="Lao People's Democratic Republic">Lao People's Democratic Republic</option>
                            <option value="Latvia">Latvia</option>
                            <option value="Lebanon">Lebanon</option>
                            <option value="Lesotho">Lesotho</option>
                            <option value="Liberia">Liberia</option>
                            <option value="Libyan Arab Jamahiriya">Libyan Arab Jamahiriya</option>
                            <option value="Liechtenstein">Liechtenstein</option>
                            <option value="Lithuania">Lithuania</option>
                            <option value="Luxembourg">Luxembourg</option>
                            <option value="Macao">Macao</option>
                            <option value="Macedonia, the Former Yugoslav Republic of">Macedonia, the Former Yugoslav Republic of</option>
                            <option value="Madagascar">Madagascar</option>
                            <option value="Malawi">Malawi</option>
                            <option value="Malaysia">Malaysia</option>
                            <option value="Maldives">Maldives</option>
                            <option value="Mali">Mali</option>
                            <option value="Malta">Malta</option>
                            <option value="Marshall Islands">Marshall Islands</option>
                            <option value="Martinique">Martinique</option>
                            <option value="Mauritania">Mauritania</option>
                            <option value="Mauritius">Mauritius</option>
                            <option value="Mayotte">Mayotte</option>
                            <option value="Mexico">Mexico</option>
                            <option value="Micronesia, Federated States of">Micronesia, Federated States of</option>
                            <option value="Moldova, Republic of">Moldova, Republic of</option>
                            <option value="Monaco">Monaco</option>
                            <option value="Mongolia">Mongolia</option>
                            <option value="Montenegro">Montenegro</option>
                            <option value="Montserrat">Montserrat</option>
                            <option value="Morocco">Morocco</option>
                            <option value="Mozambique">Mozambique</option>
                            <option value="Myanmar">Myanmar</option>
                            <option value="Namibia">Namibia</option>
                            <option value="Nauru">Nauru</option>
                            <option value="Nepal">Nepal</option>
                            <option value="Netherlands">Netherlands</option>
                            <option value="Netherlands Antilles">Netherlands Antilles</option>
                            <option value="New Caledonia">New Caledonia</option>
                            <option value="New Zealand">New Zealand</option>
                            <option value="Nicaragua">Nicaragua</option>
                            <option value="Niger">Niger</option>
                            <option value="Nigeria">Nigeria</option>
                            <option value="Niue">Niue</option>
                            <option value="Norfolk Island">Norfolk Island</option>
                            <option value="Northern Mariana Islands">Northern Mariana Islands</option>
                            <option value="Norway">Norway</option>
                            <option value="Oman">Oman</option>
                            <option value="Pakistan">Pakistan</option>
                            <option value="Palau">Palau</option>
                            <option value="Palestinian Territory, Occupied">Palestinian Territory, Occupied</option>
                            <option value="Panama">Panama</option>
                            <option value="Papua New Guinea">Papua New Guinea</option>
                            <option value="Paraguay">Paraguay</option>
                            <option value="Peru">Peru</option>
                            <option value="Philippines">Philippines</option>
                            <option value="Pitcairn">Pitcairn</option>
                            <option value="Poland">Poland</option>
                            <option value="Portugal">Portugal</option>
                            <option value="Puerto Rico">Puerto Rico</option>
                            <option value="Qatar">Qatar</option>
                            <option value="Reunion">Reunion</option>
                            <option value="Romania">Romania</option>
                            <option value="Russian Federation">Russian Federation</option>
                            <option value="Rwanda">Rwanda</option>
                            <option value="Saint Barthelemy">Saint Barthelemy</option>
                            <option value="Saint Helena">Saint Helena</option>
                            <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
                            <option value="Saint Lucia">Saint Lucia</option>
                            <option value="Saint Martin">Saint Martin</option>
                            <option value="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option>
                            <option value="Saint Vincent and the Grenadines">Saint Vincent and the Grenadines</option>
                            <option value="Samoa">Samoa</option>
                            <option value="San Marino">San Marino</option>
                            <option value="Sao Tome and Principe">Sao Tome and Principe</option>
                            <option value="Saudi Arabia">Saudi Arabia</option>
                            <option value="Senegal">Senegal</option>
                            <option value="Serbia">Serbia</option>
                            <option value="Serbia and Montenegro">Serbia and Montenegro</option>
                            <option value="Seychelles">Seychelles</option>
                            <option value="Sierra Leone">Sierra Leone</option>
                            <option value="Singapore">Singapore</option>
                            <option value="Sint Maarten">Sint Maarten</option>
                            <option value="Slovakia">Slovakia</option>
                            <option value="Slovenia">Slovenia</option>
                            <option value="Solomon Islands">Solomon Islands</option>
                            <option value="Somalia">Somalia</option>
                            <option value="South Africa">South Africa</option>
                            <option value="South Georgia and the South Sandwich Islands">South Georgia and the South Sandwich Islands</option>
                            <option value="South Sudan">South Sudan</option>
                            <option value="Spain">Spain</option>
                            <option value="Sri Lanka">Sri Lanka</option>
                            <option value="Sudan">Sudan</option>
                            <option value="Suriname">Suriname</option>
                            <option value="Svalbard and Jan Mayen">Svalbard and Jan Mayen</option>
                            <option value="Swaziland">Swaziland</option>
                            <option value="Sweden">Sweden</option>
                            <option value="Switzerland">Switzerland</option>
                            <option value="Syrian Arab Republic">Syrian Arab Republic</option>
                            <option value="Taiwan, Province of China">Taiwan, Province of China</option>
                            <option value="Tajikistan">Tajikistan</option>
                            <option value="Tanzania, United Republic of">Tanzania, United Republic of</option>
                            <option value="Thailand">Thailand</option>
                            <option value="Timor-Leste">Timor-Leste</option>
                            <option value="Togo">Togo</option>
                            <option value="Tokelau">Tokelau</option>
                            <option value="Tonga">Tonga</option>
                            <option value="Trinidad and Tobago">Trinidad and Tobago</option>
                            <option value="Tunisia">Tunisia</option>
                            <option value="Turkey">Turkey</option>
                            <option value="Turkmenistan">Turkmenistan</option>
                            <option value="Turks and Caicos Islands">Turks and Caicos Islands</option>
                            <option value="Tuvalu">Tuvalu</option>
                            <option value="Uganda">Uganda</option>
                            <option value="Ukraine">Ukraine</option>
                            <option value="United Arab Emirates">United Arab Emirates</option>
                            <option value="United Kingdom">United Kingdom</option>
                            <option value="United States">United States</option>
                            <option value="United States Minor Outlying Islands">United States Minor Outlying Islands</option>
                            <option value="Uruguay">Uruguay</option>
                            <option value="Uzbekistan">Uzbekistan</option>
                            <option value="Vanuatu">Vanuatu</option>
                            <option value="Venezuela">Venezuela</option>
                            <option value="Viet Nam">Viet Nam</option>
                            <option value="Virgin Islands, British">Virgin Islands, British</option>
                            <option value="Virgin Islands, U.s.">Virgin Islands, U.s.</option>
                            <option value="Wallis and Futuna">Wallis and Futuna</option>
                            <option value="Western Sahara">Western Sahara</option>
                            <option value="Yemen">Yemen</option>
                            <option value="Zambia">Zambia</option>
                            <option value="Zimbabwe">Zimbabwe</option>
                        </select>
                    </div>
                </div>  
            </div>
            <div class="text-uppercase mt-5 font-weight-bold text-light bg-dark">Contact Information</div>
            <div class="row border-top">
                <div class="col-6">
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" class="form-control" placeholder="janedoe@gmail.com" required="">
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="phonenumber">Phone Number</label>
                        <input type="text" id="phonenumber" class="form-control" placeholder="+233 44 345 34567" required="">
                    </div>
                </div>
            </div>
            <div class="text-uppercase mt-5 font-weight-bold text-light bg-dark">Offical Information</div>
            <div class="row border-top">
                <div class="col-6">
                    <div class="form-group">
                        <label for="">Commandery</label>
                        <select class="form-control" id="commanderylist">

                        </select>
                    </div>
                </div> 
            </div>
            <div class="form-footer pt-2  mt-2 border-top text-center">
                <button type="submit" class="btn btn-outline-success" data-style="expand-right" ><i class="mdi mdi-account-plus-outline"></i>  Add Members</button>&nbsp;&nbsp;&nbsp;&nbsp;
                <button type="reset" class="btn btn-outline-secondary" data-style="expand-right" ><i class="mdi mdi-account-convert"></i> Reset Form</button>
            </div>
        </form>

    </div>

</div>

<script >
    pagename("Members");
//    $('select').select2({placeholder: 'Select an option'});
    $(function () {
        var coverartencodedimage;
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#imageResult').attr('src', e.target.result);
                    coverartencodedimage = e.target.result;
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
        $(function () {
            $('#upload').on('change', function () {
                var countFiles = $(this)[0].files.length;
                var imgPath = $(this)[0].value;
                var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
                if (extn === "gif" || extn === "png" || extn === "jpg" || extn === "jpeg") {

                    readURL(input);
                } else {
                    swal({
                        title: "Error Generated",
                        text: "This file type is not an image",
                        icon: "error",
                        button: true

                    });
                }
            });
        });
        var input = document.getElementById('upload');
        var infoArea = document.getElementById('upload-label');
        input.addEventListener('change', showFileName);
        function showFileName(event) {
            var input = event.srcElement;
            var fileName = input.files[0].name;
            infoArea.textContent = 'File name: ' + fileName;
        }
        //get all fetchallcommanderie
        $.post("process/server.php", {
            action: "fetchallcommanderie"
        }, function (feedback) {
            feedback = JSON.parse(feedback);
            if (feedback.response === true) {
                $("#commanderylist").append("<option value='NULL'>Select Governances</option>");
                $.each(feedback.commanderielist, function (key, value) {
                    $("#commanderylist").append("<option value='" + value.id + "'>" + value.name + "</option>");
                });
            }
        });
        //        Validate fields
        $('#fullname, #title').on('focusout', function () {
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
        $('#phonenumber').on('focusout', function () {
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
//                    console.log(feedback);

                    if (feedback.response === true) {
                        $('#phonenumber').notify("Phone Exist in System Already", "error").addClass('border-danger');
                        $('button[type=submit]').attr('disabled', 'disabled');

                    } else if (feedback.response === false) {
                        $('#phonenumber').notify("Phone Accepted", "success").removeClass('border-danger').addClass('border-success');
                        $('button[type=submit]').removeAttr('disabled');

                    } else if ((feedback.response === false) && (feedback.error.length > 0)) {
                        $.notify(feedback.error, "error");
                        $('button[type=submit]').attr('disabled', 'disabled');
                    }

                });

            }

        });

        $('#adduserform').on('submit', function (event) {
            event.preventDefault();
            event.stopPropagation();
//                Add User to Database
            $.post("process/server.php", {
                action: "addmember", email: $('#email').val(), title: $('#title').val(),
                fullname: $('#fullname').val(), phonenumber: $('#phonenumber').val(),
                nation: $('#nation').val(), coverartencodedimage: coverartencodedimage,
                commanderylist: $("#commanderylist").val(),status:'1'
            }, function (feedback) {
                feedback = JSON.parse(feedback);
                console.log(feedback);
                if (feedback.response === true) {
                    swal({
                        title: "Successful",
                        text: "Members added",
                        icon: "success",
                        button: true
                    }).then((result) => {
                        pagenav("members");
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
                            text: "Members Could not be added",
                            icon: "error",
                            button: false,
                            timer: 4000
                        });
                    }
                }

            });


        });
    });

</script>
