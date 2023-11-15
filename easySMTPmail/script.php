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
            die("reCAPTCHA error");
        }
    } else {
        die("reCAPTCHA error");
    }

    // Get form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $message = $_POST['message'];

    // Create a PHPMailer object
    $mail = new PHPMailer\PHPMailer\PHPMailer(true);
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = $fileJS['host']; // Change this to your SMTP server
        $mail->SMTPAuth = (bool)$fileJS['SMTPAuth'];
        $mail->Username = $fileJS['Username']; // Change this to your SMTP username
        $mail->Password = $fileJS['Password']; // Change this to your SMTP password
        $mail->SMTPSecure = $fileJS['SMTPSecure'];
        $mail->Port = intval($fileJS['Port']);

        // Recipients
        $mail->setFrom($fileJS['setFrom']); // Change this to your email and name
        $mail->addAddress($fileJS['addAddress']); // Change this to the recipient's email and name

        // Content
        $mail->isHTML(false);
        $mail->Subject = $fileJS['subject'];
        $mail->Body = "Name: $name\nEmail: $email\nPhone: $phone\n\n$message";

        // Send the email
        $mail->send();
        echo $fileJS['success'];
    } catch (Exception $e) {
        echo $fileJS['error'];
    };
};
