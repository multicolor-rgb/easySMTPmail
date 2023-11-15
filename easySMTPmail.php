<?php

# get correct id for plugin
$thisfile = basename(__FILE__, ".php");

# register plugin
register_plugin(
    $thisfile, //Plugin id
    'easySMTPmail',     //Plugin name
    '1.0',         //Plugin version
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

# functions
function easySMTPsettings()
{
    include(GSPLUGINPATH . 'easySMTPmail/settings.php');
    
  echo '
  <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank" style="box-sizing:border-box; display:grid; align-items:center;width:100%;grid-template-columns:1fr auto; padding:10px !important;background:#fafafa;border:solid 1px #ddd;margin-top:20px;">
      <p style="margin:0;padding:0;">If you want to support my work via PayPal :) Thanks! </p>
      <input type="hidden" name="cmd" value="_s-xclick" />
      <input type="hidden" name="hosted_button_id" value="KFZ9MCBUKB7GL" />
      <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_SM.gif" border="0" name="submit" title="PayPal - The safer, easier way to pay online!" alt="Donate with PayPal button" />
      <img alt="" border="0" src="https://www.paypal.com/en_PL/i/scr/pixel.gif" width="1" height="1" />
  </form>';
}

function easySMTPform()
{
    include(GSPLUGINPATH . 'easySMTPmail/form.php');
}


function easySMTPscript()
{
    include(GSPLUGINPATH . 'easySMTPmail/script.php');
}
