<style>
    .easySMTPmail :is(input, select) {
        width: 100%;
        padding: 10px;
        box-sizing: border-box;
        background: #fff;
        border: solid 1px #ddd;
        margin: 10px 0;
    }

    .easySMTPmail button {
        background: #000;
        bordfer-radius: 0;
        border: none;
        padding: 10px;
        color: #fff;
    }
</style>

<?php if (file_exists(GSDATAOTHERPATH . 'easySMTPmail/settings.json')) {

    $fileJS = json_decode(file_get_contents(GSDATAOTHERPATH . 'easySMTPmail/settings.json'), true);
}; ?>


<form action="" class="easySMTPmail" method="post">
    <h3>SMTP - settings</h3>

    <p style="width:100%;padding:10px;border:solid 1px #ddd;"> just put <b> easySMTPform() </b> function to yours template or paste shortcode in ckeditor <b> [% easySMTPmail %] </b> where you want use.</p>

    <label for="">choose sending method: (save after each change to see new fields)</label>
    <select name="smtpormail" class="smtpormail">
        <option value="smtp">SMTP</option>
        <option value="mailto">MailTo</option>
    </select>


    <?php if (isset($fileJS)) {
        echo '<script>document.querySelector(".smtpormail").value ="' . $fileJS['smtpormail'] . '"</script>';
    }; ?>

    <?php if ($fileJS['smtpormail'] == 'smtp') : ?>



        <label for="">SMTP server</label>
        <input type="text" name="host" <?php if (isset($fileJS)) {
                                            echo 'value="' . $fileJS['host'] . '"';
                                        }; ?>>

        <label for="">SMTPAuth</label>
        <select name="SMTPAuth" class="SMTPAUTH" id="">
            <option value="true">True</option>
            <option value="false">False</option>
        </select>

        <?php if (isset($fileJS) && $fileJS['SMTPAuth'] !== '') {

            echo '<script>document.querySelector(".SMTPAUTH").value ="' . $fileJS['SMTPAuth'] . '"</script>';
        }; ?>

        <label for="">Username</label>
        <input type="text" name="Username" <?php if (isset($fileJS)) {
                                                echo 'value="' . $fileJS['Username'] . '"';
                                            }; ?>>

        <label for="">Password</label>
        <input type="password" name="Password" <?php if (isset($fileJS)) {
                                                    echo 'value="' . $fileJS['Password'] . '"';
                                                }; ?>>

        <label for="">SMTPSecure</label>
        <input type="text" name="SMTPSecure" placeholder="tls" <?php if (isset($fileJS)) {
                                                                    echo 'value="' . $fileJS['SMTPSecure'] . '"';
                                                                }; ?>>


        <label for="">Port</label>
        <input type="text" name="Port" placeholder="465" <?php if (isset($fileJS)) {
                                                                echo 'value="' . $fileJS['Port'] . '"';
                                                            }; ?>>


    <?php endif; ?>


    <label for="">subject</label>
    <input type="text" name="subject" <?php if (isset($fileJS)) {
                                            echo 'value="' . $fileJS['subject'] . '"';
                                        }; ?> required>

    <label for="">set from</label>
    <input type="text" name="setFrom" <?php if (isset($fileJS)) {
                                            echo 'value="' . $fileJS['setFrom'] . '"';
                                        }; ?> required>

    <label for="">set recipient</label>
    <input type="text" name="addAddress" <?php if (isset($fileJS)) {
                                                echo 'value="' . $fileJS['addAddress'] . '"';
                                            }; ?> required>

    <label for="">Secret Key from <a href="https://www.google.com/recaptcha/admin/create" target="_blank">Google Recaptcha</a></label>
    <input type="text" name="secretKey" <?php if (isset($fileJS)) {
                                            echo 'value="' . $fileJS['secretKey'] . '"';
                                        }; ?> required>

    <label for="">Site Key from <a href="https://www.google.com/recaptcha/admin/create" target="_blank">Google Recaptcha</a></label>
    <input type="text" name="siteKey" <?php if (isset($fileJS)) {
                                            echo 'value="' . $fileJS['siteKey'] . '"';
                                        }; ?> required>



    <label for="">Success email info</label>
    <input type="text" name="success" <?php if (isset($fileJS)) {
                                            echo 'value="' . $fileJS['success'] . '"';
                                        }; ?> required>

    <label for="">Error email info</label>
    <input type="text" name="error" <?php if (isset($fileJS)) {
                                        echo 'value="' . $fileJS['error'] . '"';
                                    }; ?> required>
    <hr>
    <br>

    <h3>Translate option</h3>

    <input type="text" name="lang-name" <?php if (isset($fileJS)) {
                                            echo 'value="' . $fileJS['lang-name'] . '"';
                                        }; ?> placeholder="Name" required>
    <input type="text" name="lang-email" <?php if (isset($fileJS)) {
                                                echo 'value="' . $fileJS['lang-email'] . '"';
                                            }; ?> placeholder="Email" required>
    <input type="text" name="lang-phone" <?php if (isset($fileJS)) {
                                                echo 'value="' . $fileJS['lang-phone'] . '"';
                                            }; ?> placeholder="Phone" required>
    <input type="text" name="lang-message" <?php if (isset($fileJS)) {
                                                echo 'value="' . $fileJS['lang-message'] . '"';
                                            }; ?> placeholder="Message" required>
    <input type="text" name="lang-privacy" <?php if (isset($fileJS)) {
                                                echo 'value="' . $fileJS['lang-privacy'] . '"';
                                            }; ?> placeholder="privacy policy text checkbox" required>
    <input type="text" name="lang-submit" <?php if (isset($fileJS)) {
                                                echo 'value="' . $fileJS['lang-submit'] . '"';
                                            }; ?> placeholder="send button text" required>

    <hr>
    <button type="submit" name="saveESMTPM">Save settings</button>

</form>

<?php

if (isset($_POST['saveESMTPM'])) {


    $settings = [];

    $settings['host'] = $_POST['host'];
    $settings['SMTPAuth'] = $_POST['SMTPAuth'];
    $settings['Username'] = $_POST['Username'];
    $settings['Password'] = $_POST['Password'];
    $settings['SMTPSecure'] = $_POST['SMTPSecure'];
    $settings['subject'] = $_POST['subject'];
    $settings['setFrom'] = $_POST['setFrom'];
    $settings['addAddress'] = $_POST['addAddress'];
    $settings['secretKey'] = $_POST['secretKey'];
    $settings['siteKey'] = $_POST['siteKey'];
    $settings['success'] = $_POST['success'];
    $settings['error'] = $_POST['error'];
    $settings['Port'] = $_POST['Port'];
    $settings['smtpormail'] = $_POST['smtpormail'];
    $settings['lang-name'] = $_POST['lang-name'];
    $settings['lang-email'] = $_POST['lang-email'];
    $settings['lang-phone'] = $_POST['lang-phone'];
    $settings['lang-message'] = $_POST['lang-message'];
    $settings['lang-privacy'] = $_POST['lang-privacy'];
    $settings['lang-submit'] = $_POST['lang-submit'];


    $file = GSDATAOTHERPATH . 'easySMTPmail/settings.json';

    if (!file_exists($file)) {
        mkdir(GSDATAOTHERPATH . 'easySMTPmail/', 0755);
        file_put_contents(GSDATAOTHERPATH . 'easySMTPmail/.htaccess', 'Deny from all');
    };

    file_put_contents($file, json_encode($settings));
    echo ("<meta http-equiv='refresh' content='0'>");
}; ?>