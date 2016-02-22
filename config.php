<?php
/*
 *  Copyright (C) 2012 Platoniq y Fundaci�n Fuentes Abiertas (see README for details)
 *	This file is part of Goteo.
 *
 *  Goteo is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU Affero General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  Goteo is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU Affero General Public License for more details.
 *
 *  You should have received a copy of the GNU Affero General Public License
 *  along with Goteo.  If not, see <http://www.gnu.org/licenses/agpl.txt>.
 *
 */

define('GOTEO_PATH', __DIR__ . DIRECTORY_SEPARATOR);
if (function_exists('ini_set')) {
    ini_set('include_path', GOTEO_PATH . PATH_SEPARATOR . '.');
} else {
    throw new Exception("No puedo a�adir la API GOTEO al include_path.");
}

// Nodo actual
define('GOTEO_NODE', 'goteo');

define('PEAR', GOTEO_PATH . 'library' . '/' . 'pear' . '/');
if (function_exists('ini_set')) {
    ini_set('include_path', ini_get('include_path') . PATH_SEPARATOR . PEAR);
} else {
    throw new Exception("No puedo a�adir las librer�as PEAR al include_path.");
}

/******************************************************
PhpMailer constants
*******************************************************/
if (!defined('PHPMAILER_CLASS')) {
    define ('PHPMAILER_CLASS', GOTEO_PATH . 'library' . DIRECTORY_SEPARATOR . 'phpmailer' . DIRECTORY_SEPARATOR . 'class.phpmailer.php');
}
if (!defined('PHPMAILER_LANGS')) {
    define ('PHPMAILER_LANGS', GOTEO_PATH . 'library' . DIRECTORY_SEPARATOR . 'phpmailer' . DIRECTORY_SEPARATOR . 'language' . DIRECTORY_SEPARATOR);
}
if (!defined('PHPMAILER_SMTP')) {
    define ('PHPMAILER_SMTP', GOTEO_PATH . 'library' . DIRECTORY_SEPARATOR . 'phpmailer' . DIRECTORY_SEPARATOR . 'class.smtp.php');
}
if (!defined('PHPMAILER_POP3')) {
    define ('PHPMAILER_POP3', GOTEO_PATH . 'library' . DIRECTORY_SEPARATOR . 'phpmailer' . DIRECTORY_SEPARATOR . 'class.pop3.php');
}

/******************************************************
OAUTH APP's Secrets
*******************************************************/
if (!defined('OAUTH_LIBS')) {
    define ('OAUTH_LIBS', GOTEO_PATH . 'library' . DIRECTORY_SEPARATOR . 'oauth' . DIRECTORY_SEPARATOR . 'SocialAuth.php');
}

//Uploads static files
$static_dir = preg_replace('/\/[A-Za-z0-9.]+\.localgood/','/static.localgood',dirname(__FILE__));
define('GOTEO_DATA_PATH', $static_dir . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR);

/**
 * Carga de configuraci�n local si existe
 * Si no se carga el real (si existe)
**/
if (file_exists('local-settings.php')) //en .gitignore
    require 'local-settings.php';
elseif (file_exists('live-settings.php')) //se considera en git
    require 'live-settings.php';
else
    die(<<<EOF
No se encuentra el archivo de configuraci&oacute;n <strong>local-settings.php</strong>, debes crear este archivo en la raiz.<br />
Puedes usar el siguiente c&oacute;digo modificado con los credenciales adecuados.<br />
<pre>
&lt;?php

mb_language("Japanese");
mb_internal_encoding("UTF-8");

// Metadata
define('GOTEO_META_TITLE', '--meta-title--');
define('GOTEO_META_DESCRIPTION', '--meta-description--');
define('GOTEO_META_KEYWORDS', '--keywords--');
define('GOTEO_META_AUTHOR', '--author--');
define('GOTEO_META_COPYRIGHT', '--copyright--');

//Mail management: ses (amazon), phpmailer (php library)
define("MAIL_HANDLER", "phpmailer");

// Database
define('GOTEO_DB_DRIVER', 'mysql');
define('GOTEO_DB_HOST', 'localhost');
define('GOTEO_DB_PORT', 3306);
define('GOTEO_DB_CHARSET', 'UTF-8');
define('GOTEO_DB_SCHEMA', 'db-schema');
define('GOTEO_DB_USERNAME', 'db-username');
define('GOTEO_DB_PASSWORD', 'db-password');

// LocalGood Common Authentication Database
define('COMMON_AUTH_DB_SCHEMA', 'db_auth');

// Mail
define('GOTEO_MAIL_FROM', 'localgood@yokohamalab.jp');
define('GOTEO_MAIL_NAME', 'LOCAL GOOD YOKOHAMA');
define('GOTEO_MAIL_TYPE', 'smtp'); // mail, sendmail or smtp
define('GOTEO_MAIL_SMTP_AUTH', true);
define('GOTEO_MAIL_SMTP_SECURE', 'ssl');
define('GOTEO_MAIL_SMTP_HOST', 'smtp--host');
define('GOTEO_MAIL_SMTP_PORT', --portnumber--);
define('GOTEO_MAIL_SMTP_USERNAME', 'smtp-usermail');
define('GOTEO_MAIL_SMTP_PASSWORD', 'smtp-password');

define('GOTEO_MAIL', 'localgood@yokohamalab.jp');
define('GOTEO_CONTACT_MAIL', 'localgood@yokohamalab.jp');
define('GOTEO_FAIL_MAIL', 'localgood@yokohamalab.jp');
define('GOTEO_LOG_MAIL', 'localgood@yokohamalab.jp');

//Quota de envio m�ximo para goteo en 24 horas
define('GOTEO_MAIL_QUOTA', 50000);
//Quota de envio m�ximo para newsletters para goteo en 24 horas
define('GOTEO_MAIL_SENDER_QUOTA', round(GOTEO_MAIL_QUOTA * 0.8));
//clave de Amazon SNS para recopilar bounces automaticamente: 'arn:aws:sns:us-east-1:XXXXXXXXX:amazon-ses-bounces'
//la URL de informacion debe ser: goteo_url.tld/aws-sns.php
define('AWS_SNS_CLIENT_ID', 'XXXXXXXXX');
define('AWS_SNS_REGION', 'us-east-1');
define('AWS_SNS_BOUNCES_TOPIC', 'amazon-ses-bounces');
define('AWS_SNS_COMPLAINTS_TOPIC', 'amazon-ses-complaints');

// Language
define('GOTEO_DEFAULT_LANG', 'en');
// name of the gettext .po file (used for admin only texts at the moment)
define('GOTEO_GETTEXT_DOMAIN', 'messages');
// gettext files are cached, to reload a new one requires to restart Apache which is stupid (and annoying while 
//	developing) this setting tells the langueage code to bypass caching by using a clever file-renaming 
// mechanism described in http://blog.ghost3k.net/articles/php/11/gettext-caching-in-php
define('GOTEO_GETTEXT_BYPASS_CACHING', true);

// url
define('SITE_URL', 'http://yokohama.localgood.jp/'); // endpoint url
define('SRC_URL', 'http://yokohama.localgood.jp/');  // host for statics
define('SEC_URL', 'http://yokohama.localgood.jp/');  // with SSL certified
define('LOCALGOOD_WP_BASE_URL', '----wp site address----');
define('LOG_PATH', '/var/www/html/localgood/cf.fukuoka.localgood.jp.il3c.com/htdocs/logs/');
define('LG_INTEGRATION_URL', '----integration site url----');
define('LG_NAME', 'LOCAL GOOD FUKUOKA');


//Sessions
//session handler: php, dynamodb
define("SESSION_HANDLER", "php");

//Files management: s3, file
define("FILE_HANDLER", "file");

//Log file management: s3, file
define("LOG_HANDLER", "file");

// environment: local, beta, real
define("GOTEO_ENV", "local");

//S3 bucket (if you set FILE_HANDLER to s3)
define("AWS_S3_BUCKET", "static.example.com");
define("AWS_S3_PREFIX", "");

//bucket para logs (if you set LOG_HANDLER to s3)
define("AWS_S3_LOG_BUCKET", "bucket");
define("AWS_S3_LOG_PREFIX", "applogs/");

// Cron params (for cron processes using wget)
define('CRON_PARAM', '--------------');
define('CRON_VALUE', '--------------');


/****************************************************
Paypal constants (sandbox)
* Must set cretentials on library/paypal/paypal_config.php as well
****************************************************/
define('PAYPAL_REDIRECT_URL', '---Sandbox/Production-url-----https://www.sandbox.paypal.com/webscr&cmd=');
define('PAYPAL_DEVELOPER_PORTAL', '--developper-domain--');
define('PAYPAL_DEVICE_ID', '--domain--');
define('PAYPAL_APPLICATION_ID', '--PayPal-app-Id---');
define('PAYPAL_BUSINESS_ACCOUNT', '--mail-like-paypal-account--');
define('PAYPAL_IP_ADDRESS', '127.0.0.1');

/****************************************************
TPV [Bank Name] (depends on your bank)
****************************************************/
define('TPV_MERCHANT_CODE', 'xxxxxxxxx');
define('TPV_REDIRECT_URL', '--bank-rest-api-url--');
define('TPV_ENCRYPT_KEY', 'xxxxxxxxx');

/*
Any other payment system configuration should be setted here
*/

/****************************************************
Social Services constants  (needed to login-with on the controller/user and library/oauth)
****************************************************/
// Credentials Facebook app
define('OAUTH_FACEBOOK_ID', '-----------------------------------'); //
define('OAUTH_FACEBOOK_SECRET', '-----------------------------------'); //

// Credentials Twitter app
define('OAUTH_TWITTER_ID', '-----------------------------------'); //
define('OAUTH_TWITTER_SECRET', '-----------------------------------'); //

// Credentials Linkedin app
define('OAUTH_LINKEDIN_ID', '-----------------------------------'); //
define('OAUTH_LINKEDIN_SECRET', '-----------------------------------'); //

// Un secreto inventado cualquiera para encriptar los emails que sirven de secreto en openid
define('OAUTH_OPENID_SECRET','-----------------------------------');

//SNS link
define('LG_FACEBOOK_PAGE', '----facebook url----');
define('LG_TWITTER', '----twitter url----');
define('LG_GOOGLE_PLUS', '----google plus url----');

// recaptcha ( to be used in /contact form )
define('RECAPTCHA_PUBLIC_KEY','-----------------------------------');
define('RECAPTCHA_PRIVATE_KEY','-----------------------------------');

/****************************************************
Google Analytics
****************************************************/
define('GOTEO_ANALYTICS_TRACKER', "<script type=\"text/javascript\">
__your_tracking_js_code_goes_here___
</script>
");

/****************************************************
AWS
****************************************************/
//Amazon Web Services Credentials
define("AWS_KEY", "--------------");
define("AWS_SECRET", "----------------------------------");
define("AWS_REGION", "-----------");

// Credentials SES
define('AWS_SES_SOURCE', '--------------');
define('AWS_SES_ACCESS', '--------------');
define('AWS_SES_SECERET', '--------------');
define('AWS_SES_CHARSET', 'UTF-8');

/****************************************************
AXES
 ****************************************************/
define('AXES_CLIENTIP', '----------');

/****************************************************
CESIUM
 ****************************************************/
define('LG_EARTHVIEW', 'http://map.yokohama.localgood.jp.il3c.com/');

/****************************************************
Change view type
 ****************************************************/
\$ua = \$_SERVER['HTTP_USER_AGENT'];
if(strpos(\$ua, 'LocalGood/iOS (Yokohama)') === 0 || strpos(\$ua, 'LocalGood/Android (Yokohama)') === 0 ) {
    define('PC_VIEW', false);
    define('VIEW_PATH', 'view/m');
} else {
    define('PC_VIEW', true);
    define('VIEW_PATH', 'view');
}
?&gt;
</pre>
EOF
);

if (file_exists('tmp-settings.php'))
    require 'tmp-settings.php';
else {
    // Temporary behaviours
    define('DEVGOTEO_LOCAL', false); // backwards compatibility
    define('GOTEO_MAINTENANCE', null); // to show the maintenance page
    define('GOTEO_EASY', null); // to take user overload easy
	define('GOTEO_FREE', true); // used somewhere...
}

$ua = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : "";
