<?php

# get correct id for plugin
$thisfile = basename(__FILE__, ".php");

# register plugin
register_plugin(
    $thisfile, //Plugin id
    'easySMTPmail',     //Plugin name
    '3.0',         //Plugin version
    'multicolor',  //Plugin author
    'http://bit.ly/donate-multicolor-plugins', //author website
    'easy to use contact form with Captcha Google and smtp', //Plugin description
    'pages', //page type - on which admin tab to display
    'easySMTPsettings'  //main function (administration)
);

# activate filter 
add_action('theme-header', 'easySMTPscript');

# add a link in the admin tab 'theme'
add_action('pages-sidebar', 'createSideMenu', array($thisfile, 'easySMTPmail'));

add_action('theme-header', 'shortcodeEasySMTPmail');





# functions
function easySMTPsettings()
{
    include(GSPLUGINPATH . 'easySMTPmail/settings.php');

    echo "
    <style>
    .kofi-button{text-decoration:none !important;}
    </style>
    <div style='text-decoration:none !important;margin:20px 0;'><script type='text/javascript' src='https://storage.ko-fi.com/cdn/widget/Widget_2.js'></script><script type='text/javascript'>kofiwidget2.init('Buy me coffe on Ko-fi', '#29abe0', 'I3I2RHQZS');kofiwidget2.draw();</script>
    </div>";
}

function showFormEasyMail()
{
    if (file_exists(GSDATAOTHERPATH . 'easySMTPmail/settings.json')) {
        $fileJS = json_decode(file_get_contents(GSDATAOTHERPATH . 'easySMTPmail/settings.json'), true);
    };

    global $SITEURL;

    $form = '';

    $form .= '<link rel="stylesheet" href="' . $SITEURL . 'plugins/easySMTPmail/css/style.css">';

    $form .= '<form method="post" class="easySMTPform"><label for="name">';


    if (isset($fileJS)) {
        $form .= $fileJS['lang-name'];
    } else {
        $form .= 'Name:';
    };

    $form .= '</label>
    <input type="text" name="name" required>
    <label for="email">';

    if (isset($fileJS)) {
        $form .= $fileJS['lang-email'];
    } else {
        $form .= 'E-mail:';
    };

    $form .= '</label>
    <input type="email" name="email" required>
    <label for="phone">';

    if (isset($fileJS)) {
        $form .= $fileJS['lang-phone'];
    } else {
        $form .= 'Phone:';
    };


    $form .= '</label>
    <input type="tel" name="phone">
    <label for="message">';

    if (isset($fileJS)) {
        $form .= $fileJS['lang-message'];
    } else {
        $form .= ' Message:';
    };

    $form .= '</label>
    <textarea name="message" rows="4" required></textarea>
    <label for=""><input type="checkbox" required>';

    if (isset($fileJS)) {
        $form .= $fileJS['lang-privacy'];
    } else {
        $form .= 'I accept the privacy policy';
    };

    $form .= '
        </label>
        <!-- reCAPTCHA -->
        <div class="g-recaptcha" data-sitekey="';

    if (isset($fileJS)) {
        $form .= $fileJS['siteKey'];
        $form .= '"></div>
        <input type="submit" name="send-easySMTPmail" value="';

        if (isset($fileJS)) {
            $form .= $fileJS['lang-submit'];
        } else {
            $form .= 'Send Message';
        };

        $form .= '">';

        if (isset($_POST['info'])) {
            $form .= $_POST['info'];
        };


        $form .= '</form>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>';



        return $form;
    }
}


function easySMTPform()
{
    echo showFormEasyMail();
}



function easySMTPscript()
{
    include(GSPLUGINPATH . 'easySMTPmail/script.php');
}

function shortcodeEasySMTPmail($e = '')
{

    ///shortbox create
    global $content;
    $newcontent = preg_replace_callback(
        '/\\[% easySMTPmail %\\]/i',
        "showFormEasyMail",
        $content
    );
    $content = $newcontent;
}
