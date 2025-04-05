<?php

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Loading Components of mail
//D:\www\drootdocs\midnytupdates\admin\process\phpmailer6.5.1\src
require '../vendor/phpmailer6.5.1/src/Exception.php';
require '../vendor/phpmailer6.5.1/src/PHPMailer.php';
require '../vendor/phpmailer6.5.1/src/SMTP.php';

function mailer($recEmail, $recName, $subject, $emaildata,$attachmentname,$workshoptitle) {

//Create an instance; passing `true` enables exceptions Arrange this nar
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_OFF;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host = 'mail.scholarindexing.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth = true;                                   //Enable SMTP authentication
        $mail->Username = 'hello@scholarindexing.com';                     //SMTP username
        $mail->Password = '<Twozik/>';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        //Recipients
        $mail->setFrom('hello@scholarindexing.com', 'Scholar Indexing Society Event Management');
        $mail->addAddress($recEmail, $recName);     //Add a recipient
//        $mail->addAddress('ellen@example.com');               //Name is optional
        $mail->addReplyTo('hello@scholarindexing.com', 'Information');
//        $mail->addCC('cc@example.com');
//        $mail->addBCC('bcc@example.com');
//        
        //Attachments
//        $mail->addEmbeddedImage('mailtemplates/images/logo2.jpg', 'Scholarindexingblog');    // Optional name
//        $mail->addEmbeddedImage('mailtemplates/images/facebook_icon.png', 'facebook_icon');    // Optional name
//        $mail->addEmbeddedImage('mailtemplates/images/instagram_icon.png', 'instagram_icon');    // Optional name
//        $mail->addEmbeddedImage('mailtemplates/images/twitter_icon.png', 'twitter_icon');    // Optional name
//        $mail->addEmbeddedImage('mailtemplates/images/youtube_icon.png', 'youtube_icon');    // Optional name
//        $mail->addEmbeddedImage('../mailtemplates/images/youtube_icon.png', 'youtube_icon');    // Optional name
        //Content
        $mail->isHTML(true);                //Set email format to HTML
        $mail->Subject = $workshoptitle;

        try {
//            $etemplatedir = projectroot . '/' . 'admin' . '/' . 'process' . '/' . 'mailtemplates';
            $etemplatedir = projectroot . '/' . '/' . 'process' . '/' . 'mailtemplates';
            $etemplatedirfile = $etemplatedir . '/' . 'template.php';
            $econtentfile = $etemplatedir . '/' . $emaildata['content'];

            if (file_exists($etemplatedirfile)) {
                $etemplatefilecontent = file_get_contents($etemplatedirfile);
                $econtent = file_get_contents($econtentfile);

//                $econtentneedle = array('Work shop registration successful', 'The zoom link will be sent to you shortly');
//                $econtentreplacevalues = array($emaildata['username'], $emaildata['password']);
//
//                $econtentfinal = str_replace($econtentneedle, $econtentreplacevalues, $econtent);
//
//                $needle = array('<$recName>', '<$emailcontent>');
//                $replacevalue = array($recName, $econtentfinal);
//                $body = str_replace($needle, $replacevalue, $etemplatefilecontent);
                $body = "<p><b>Dear " . $recName . "</b><br><br>"
                        . "Thank you for registering for this Event. Your commitment to being a part of this program is truly appreciated, and we are thrilled to have you on board.<br><br>
Your registration serves as a testament to your interest and dedication, and we are confident that your presence will contribute to the success and meaningful impact of this program. Your participation will undoubtedly enrich the discussions, interactions, and experiences of all involved.<br><br>
As we prepare for the program, we are diligently working to ensure that every aspect is tailored to provide a valuable and enjoyable experience for you. <b>We will be sharing further details, schedules, and any necessary information as an attachment below</b>, Do well to download them<br><br>
Please feel free to reach out to our team at Scholarindexing@gmail.com if you have any questions or need assistance in the meantime.<br><br>
Once again, thank you for registering for this Program. Your support and enthusiasm are crucial to our endeavor, and we are eagerly looking forward to having you with us. Together, we will make this event a memorable and rewarding experience for all participants.<br><br><br>
Warm regards</p>";
            } else {
                $body = "Template and content does not Exist on server";
            }
        } catch (Exception $e) {
            $body = "Error in Getting Email body and Template";
        }



        $mail->Body = $body;
        $mail->AltBody = $body;
        $mail->addAttachment("mailtemplates/images/".$attachmentname);
        $mail->send();
        return true;
    } catch (Exception $e) {
        return "Message could not be sent. Mailer Error: {$mail->ErrorInfo} " . $e;
    }
}
