<?php

if (isset($_POST['send-easySMTPmail'])) {

    $fileJS = json_decode(file_get_contents(GSDATAOTHERPATH . 'easySMTPmail/settings.json'), true);

    // Autoload PHPMailer classes if not using Composer
    require GSPLUGINPATH . 'easySMTPmail/src/Exception.php';
    require GSPLUGINPATH . 'easySMTPmail/src/PHPMailer.php';
    require GSPLUGINPATH . 'easySMTPmail/src/SMTP.php';

    // Your reCAPTCHA secret key
    $recaptchaSecretKey = $fileJS['secretKey'];

    // Verify reCAPTCHA
    if (isset($_POST['g-recaptcha-response'])) {
        $recaptchaResponse = $_POST['g-recaptcha-response'];
        $recaptchaUrl = "https://www.google.com/recaptcha/api/siteverify?secret={$recaptchaSecretKey}&response={$recaptchaResponse}";
        $recaptchaData = json_decode(file_get_contents($recaptchaUrl));

        if (!$recaptchaData->success) {
            $_POST['info'] = '<div class="easySMTPerror">reCAPTCHA error</div>';
        }
    } else {
        $_POST['info'] = '<div class="easySMTPerror">reCAPTCHA error</div>';
    }


    if (!isset($_POST['info'])) {
        // Get form data
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $message = htmlspecialchars($_POST['message'], ENT_QUOTES, 'UTF-8');


        // Create a PHPMailer object
        $mail = new PHPMailer\PHPMailer\PHPMailer(true);
        try {
            // Server settings

            if ($fileJS['smtpormail'] == 'smtp') {
                $mail->isSMTP();
                $mail->CharSet = 'UTF-8';
                $mail->IsHTML(true);
                $mail->ContentType = 'text/html; charset=UTF-8';
                $mail->Host = $fileJS['host']; // Change this to your SMTP server
                $mail->SMTPAuth = (bool)$fileJS['SMTPAuth'];
                $mail->Username = $fileJS['Username']; // Change this to your SMTP username
                $mail->Password = $fileJS['Password']; // Change this to your SMTP password
                $mail->SMTPSecure = $fileJS['SMTPSecure'];
                $mail->Port = intval($fileJS['Port']);
            } else {
                $mail->IsMail();
            };

            // Recipients
            $mail->setFrom($fileJS['setFrom']); // Change this to your email and name
            $mail->addAddress($fileJS['addAddress']); // Change this to the recipient's email and name

            $mail->addReplyTo($email, $name);

            // Content
            $mail->isHTML(false);
            $mail->Subject = $fileJS['subject'];
            $mail->Body = "Name: $name\nEmail: $email\nPhone: $phone\n\n$message";

            // Send the email
            $mail->send();
            $_POST['info'] = '<div class="easySMTPsuccess">' . $fileJS['success'] . '</div>';
        } catch (Exception $e) {
            $_POST['info'] = '<div class="easySMTPerror">' . $fileJS['error'] . $mail->ErrorInfo. '</div>';
        };
    };
};
