<?php if (file_exists(GSDATAOTHERPATH . 'easySMTPmail/settings.json')) {

    $fileJS = json_decode(file_get_contents(GSDATAOTHERPATH . 'easySMTPmail/settings.json'), true);
}; ?>


<form method="post" class="easySMTPform">
    <label for="name">
        <?php if (isset($fileJS)) {
            echo $fileJS['lang-name'];
        } else {
            echo 'Name:';
        }; ?>
    </label>
    <input type="text" name="name" required>

    <label for="email"> <?php if (isset($fileJS)) {
                            echo $fileJS['lang-email'];
                        } else {
                            echo 'E-mail:';
                        }; ?></label>
    <input type="email" name="email" required>

    <label for="phone"> <?php if (isset($fileJS)) {
                            echo $fileJS['lang-phone'];
                        } else {
                            echo 'Phone:';
                        }; ?></label>
    <input type="tel" name="phone">

    <label for="message">
        <?php if (isset($fileJS)) {
            echo $fileJS['lang-message'];
        } else {
            echo ' Message:';
        }; ?>
    </label>
    <textarea name="message" rows="4" required></textarea>

    <label for=""><input type="checkbox" required>
        <?php if (isset($fileJS)) {
            echo $fileJS['lang-privacy'];
        } else {
            echo 'I accept the privacy policy';
        }; ?>
    </label>

    <!-- reCAPTCHA -->
    <div class="g-recaptcha" data-sitekey=" <?php if (isset($fileJS)) {
                                                echo $fileJS['siteKey'];
                                            } ?> "></div>

    <input type="submit" name="send-easySMTPmail" value="<?php if (isset($fileJS)) {
                                                                echo $fileJS['lang-submit'];
                                                            } else {
                                                                echo 'Send Message';
                                                            }; ?> ">
</form>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>