<?php
// Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// send mail for activation
// Load Composer's autoloader
require '../../plugins/PHPMailer-6.0.7/src/Exception.php';
require '../../plugins/PHPMailer-6.0.7/src/PHPMailer.php';
require '../../plugins/PHPMailer-6.0.7/src/SMTP.php';

// Instantiation and passing `true` enables exceptions
$mailinstance = new PHPMailer(true);
//                        echo "data uploaded";

try {
    //Server settings
//    $mailinstance->SMTPDebug = 2;                                       // Enable verbose debug output
    $mailinstance->isSMTP();                                            // Set mailer to use SMTP
    // Set mailer to use SMTP

    $mailinstance->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );
    $mailinstance->Host = 'cug.edu.gh';  // Specify main and backup SMTP servers
    $mailinstance->SMTPAuth = true;                                   // Enable SMTP authentication
    $mailinstance->Username = 'icst.faculty@cug.edu.gh';                     // SMTP username
    $mailinstance->Password = 'icst.facultY';                               // SMTP password
    $mailinstance->SMTPSecure = 'ssl';                                  // Enable TLS encryption, `ssl` also accepted
    $mailinstance->Port = 465;                                    // TCP port to connect to
    $mailinstance->SMTPKeepAlive = true;
    //Recipients
    $mailinstance->setFrom('icst.faculty@cug.edu.gh', 'Faculty of Icst Mailer');
//                            $mailinstance->addAddress('joe@example.net', 'Joe User');     // Add a recipient
    $mailinstance->addAddress($EmailAddress);               // Name is optional
//                            $mailinstance->addReplyTo('info@example.com', 'Information');
//                            $mailinstance->addCC('cc@example.com');
//                            $mailinstance->addBCC('bcc@example.com');
    // Attachments
//                            $mailinstance->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    $mailinstance->addEmbeddedImage('../../assets/img/email/cucgportalemaillogo.png', 'cucgportallogo');    // Optional name
    $mailinstance->addEmbeddedImage('../../assets/img/email/mobilephone.png', 'mobilephone');    // Optional name
    $mailinstance->addEmbeddedImage('../../assets/img/email/padlockicon.png', 'padlockicon');    // Optional name
    $mailinstance->addEmbeddedImage('../../assets/img/email/profileicon.png', 'profileicon');    // Optional name
    $mailinstance->addEmbeddedImage('../../assets/img/email/usericon.png', 'usericon');    // Optional name
//    $mailinstance->addAttachment('../../assets/img/favicon.png', 'New Cucg Logo.png');    // Optional name
    // Content
    $mailinstance->isHTML(true);                                  // Set email format to HTML
    $mailinstance->Subject = 'Student Portal Email Verification and Account Activation';
    $mailinstance->Body = '   
<html>
  <head>   
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Cucg Student Portal Activation Email</title> 
    <style type="text/css">
      
      /* Default CSS */
      body,#body_style {margin: 0; padding: 0; background: #f1f1f1; color: #5b656e;}
      a {color: #09c;}
      a img {border: none; text-decoration: none;}
      table, table td {border-collapse: collapse;}
      td, h1, h2, h3, p {font-family: arial, helvetica, sans-serif; color: #313a42;}
      h1, h2, h3, h4 {color: #313a42 !important; font-weight: normal; line-height: 1.2;}
      h1 {font-size: 24px;}
      h2 {font-size: 18px;}
      h3 {font-size: 16px;}
      p {margin: 0 0 1.6em 0;}
      
      /* Force Outlook to provide a "view in browser" menu link. */
      #outlook a {padding:0;}
      
      /* Preheader and webversion */
      .preheader {background-color: #f6f6f6;}
      .preheaderContent, .webversion, .webversion a {color: #999999; font-size: 10px;}
      .preheaderContent{width: 440px;}
      .preheaderContent, .webversion {padding: 5px 10px;}
      .webversion {width: 200px; text-align: right;}
      .webversion a {text-decoration: underline; color: #999999; font-size: 10px;}
      
      /* Logo (branding) */
      .logoContainer {padding: 20px 0 10px 0px; width: 320px;}
      .logoContainer a {color: #ffffff;}
      
      /* Whitespace (imageless spacer) */
      .whitespace {font-family: 0px; line-height: 0px;}
      
      /* Button */
      .buttonContainer {padding: 10px 20px 10px 20px;}
      .button {padding: 10px 5px 10px 5px; text-align: center; background-color: #ff6b6b; border-radius: 4px;}
      .button a {color: #ffffff; text-decoration: none; display: block; text-transform: uppercase;}
      
      /* Featured content */
      .featuredHeader {background: #556270;}
      #featuredImage img {display: block; margin: 0 auto;}
      .featuredTitle {color: #ffffff; font-size: 26px; padding: 0px 0px 10px 0px; font-weight: bold;}
      .featuredContent {color: #ffffff;}
      
      /* One horizontal section of content: e.g. */
      .section {padding: 20px 0px 0px 0px;}
      .sectionOdd {background-color: #f1f1f1;}
      .sectionEven {background-color: #ffffff;}
      .sectionOdd, .sectionEven {padding: 30px 0px 30px 0px;}
      
      /* An article */
      .sectionArticleTitle, .sectionArticleContent {text-align: center;}
      .sectionArticleTitle {font-size: 18px; padding: 10px 0px 5px 0px;}
      .sectionArticleContent {font-size: 13px; line-height: 18px;}
      .sectionArticleImage {text-align: center;}
      .sectionArticleImage img {padding: 0px 0px 0px 0px; -ms-interpolation-mode: bicubic;}
      
      
      .sectionTitle, .sectionSubTitle{text-align: center;}
      .sectionTitle {font-size: 26px; padding: 0px 10px 10px 10px}
      .sectionSubTitle {padding: 0px 10px 20px 10px;}
      
      /* Footer and social media */
      .footNotes {padding: 0px 20px 0px 20px;}
      .footNotes a {color: #556270; font-size: 13px;}
      .socialMedia {background: #556270;}
      
      
      /* CSS for specific screen width(s) */
      @media only screen and (max-width: 480px) {
        body,table,td,p,a,li,blockquote {-webkit-text-size-adjust:none !important;}
          body[yahoofix] table {width: 100% !important;}
          body[yahoofix] .webversion {display: none; font-size: 0; max-height: 0; line-height: 0; mso-hide: all;}
          body[yahoofix] .logoContainer, body[yahoofix] .featuredTitle , body[yahoofix] .featuredContent {text-align: center;}
          body[yahoofix] .sectionArticleImage img {height: auto !important; max-width: 100% !important;}
          body[yahoofix] .preheaderContent{text-align: center;}
          body[yahoofix] .buttonContainer {padding: 0px 20px 0px 20px;}
          body[yahoofix] .column {float: left; width: 100%;}
          body[yahoofix] #featuredImage {text-align: center;}
          body[yahoofix] .featuredTitle {line-height: 24px; font-weight: normal !important; padding: 0px 10px 25px 10px;}
          body[yahoofix] .featuredContent {padding: 0px 10px 20px 10px;}
          body[yahoofix] .sectionArticleTitle {padding: 0px 10px 0px 10px !important;}
          body[yahoofix] .sectionArticleContent {padding: 0px 10px 30px 10px !important;}
        }
    </style>
  </head>
  <body yahoofix=>
    <span id="body_style" style="display:block">    
      <!-- topHeader -->
      <table border="0" cellspacing="0" cellpadding="0" width="100%" summary="" class="topHeader">
        <tr>
          <td>
            <!-- Logo (branding) -->
            <table border="0" cellspacing="0" cellpadding="0" width="640" align="center" summary="">
              <tr>
                <td class="logoContainer" align="center">
                  <a href="" title="Cucg  Student Portal Logo">
                    <img class="logo" src="cid:cucgportallogo" alt="Cucg Student Portal Logo" style="width: 100%; height: 25%" />
                  </a>
                </td>
              </tr>
            </table>
            <!-- End Logo (branding) -->
          </td>
        </tr>
      </table>
      <!-- End topHeader -->
      
      <!-- featuredHeader -->
      <table border="0" cellspacing="0" cellpadding="0" width="100%" summary="" class="featuredHeader">
        <tr>
          <td class="section">
            <table border="0" cellspacing="0" cellpadding="0" width="640" align="center" summary="">
              <tr>
                <td class="column">
                  <table border="0" cellspacing="0" cellpadding="0" width="395" summary="">
                    <tr>
                      <td class="featuredTitle">
                        Dear Student,
                      </td>
                    </tr>
                    <tr>
                      <td class="featuredTitle">
                        Thanks for Signing up to Catholic University\'s Student Portal
                      </td>
                    </tr>
                    <tr>
                      <td class="featuredContent">
                        Your Account have been created with the Credentials below. You can Login after the Activation.
                      </td>
                    </tr>
                  </table>
                </td>
                <td id="featuredImage" class="column"><img src="cid:mobilephone" width="234" alt="" /></td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
      <!-- End featuredHeader -->
      
      <!-- Section -->
      <table border="0" cellpadding="0" cellspacing="0" width="100%" summary="">
        <tr>
          <td class="sectionOdd">
            <table border="0" cellpadding="0" cellspacing="0" width="640" align="center" summary="">
              <tr>
                <td class="column" valign="top">
                  <table border="0" cellpadding="0" cellspacing="0" width="200" align="left" summary="">
                    <tr>
                      <td class="sectionArticleImage">
                       <img src="cid:profileicon" width="150" alt="" />
                      </td>
                    </tr>
                    <tr><td class="sectionArticleTitle">Your ID Number</td></tr>
                    <tr><td class="sectionArticleContent"> ' . $IdNumber . ' </td></tr>
                  </table>
                </td>
                <td class="column" valign="top">
                  <table border="0" cellpadding="0" cellspacing="0" width="200" align="center" summary="">
                    <tr>
                      <td class="sectionArticleImage">
                      <img src="cid:usericon" width="150" alt="User Name" />
                      </td>
                    </tr>
                    <tr><td class="sectionArticleTitle">Your Full Name </td></tr>
                    <tr><td class="sectionArticleContent"> ' . $FullName . ' </td></tr>
                  </table>
                </td>
                <td class="column" valign="top">
                  <table border="0" cellpadding="0" cellspacing="0" width="200" align="center" summary="">
                    <tr>
                      <td class="sectionArticleImage">
                        <img src="cid:padlockicon" width="150" alt="" />
                      </td>
                    </tr>
                    <tr><td class="sectionArticleTitle"> Your Password</td></tr>
                    <tr><td class="sectionArticleContent"> ' . $B4EncPassword . '</td></tr>
                  </table>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
      <table border="0" cellpadding="0" cellspacing="0" width="100%" summary="">
        <tr>
          <td class="sectionEven">
            <table border="0" cellpadding="0" cellspacing="0" width="640" align="center" summary="">
              <tr><td class="sectionTitle">Activation !!! </td></tr>
              <tr><td class="sectionSubTitle">Click the button below to activate your Account and Login </td></tr>
              <tr>
                <td class="buttonContainer">
                  <table border="0" cellpadding="0" cellspacing="0" summary="" width="30%" align="center">
                    <tr><td class="button"><a href="' . $webadress . '/scripts/php/verification?id=' . $EncIdNumber . '&verificationcode=' . $verificationcode . '" title="Click to activate">Activate</a></td></tr>
                  </table>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>

      <!-- End Section -->
      <!-- Footer -->
      <table border="0" cellspacing="0" cellpadding="0" width="100%" summary="" class="footer">
        <tr><td class="whitespace" height="10">&nbsp;</td></tr>
        <tr>
          <td>
            <table border="0" cellspacing="0" cellpadding="0" width="80%" align="center" summary="">
              <tr>
                <td class="footNotes" align="center">
                  CUCG ICT &copy; 2019,
                </td>
                <td class="footNotes" align="center">
                  All Rights Reserved.
                </td>
                <td class="footNotes" align="center">
                  Designed by <a target="_blank" href="../facultyoficst/devteam">CIS Department Development Team</a>
                </td>
              </tr>
            </table>
          </td>
        </tr>
        <tr><td class="whitespace" height="10">&nbsp;</td></tr>
      </table>
      <!-- End Footer -->
    </span>
  </body>
</html> ';
//                            $mailinstance->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mailinstance->send();

//    Updating the user table to show email sent successfully
    $query = "update usercredentials set verificationemailsent='1' where idnumber='" . $IdNumber . "' ;";
//    echo $query;
    $result = $dbhandler->Update($query);

    $sesmanager->Set("msg", "Successfull: Email Sent to your Mail Address for Account Activation :success");
    // PHP permanent URL redirection
    header("Location: ../../signup", true, 301);
    exit();
} catch (Exception $e) {
    $sesmanager->Set("msg", "Error Generated: Email Could not be Sent, Check you Email Address. :error");
    // PHP permanent URL redirection
    header("Location: ../../signup", true, 301);
    exit();
//    echo "Message could not be sent. Mailer Error: {$mailinstance->ErrorInfo}";
}
?>