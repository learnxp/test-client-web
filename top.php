<?php
use \Tsugi\Core\LTIX;

if ( ! defined('COOKIE_SESSION') ) define('COOKIE_SESSION', true);

require_once "tsugi/config.php";

// Do this early to allow sanity-db.php to check in more detail after
// Headers has been sent
$PDOX = false;
try {
    define('PDO_WILL_CATCH', true);
    $PDOX = LTIX::getConnection();
    $LAUNCH = LTIX::session_start();
} catch(PDOException $ex){
    $PDOX = false;  // sanity-db-will re-check this below
}

$scriptName = basename($_SERVER['SCRIPT_FILENAME'] ?? $_SERVER['SCRIPT_NAME'] ?? '');
$homePath = $CFG->getExtension('home_path', false);
if ( $scriptName === 'index.php' && is_string($homePath) && trim($homePath) !== '' ) {
    $home = $CFG->getHomeUrl();
    $here = $CFG->getCurrentUrl();
    $norm = function ($url) {
        $url = rtrim((string) $url, '/');
        if ( strlen($url) >= 10 && substr($url, -10) === '/index.php' ) {
            $url = rtrim(substr($url, 0, -10), '/');
        }
        return $url;
    };
    if ( is_string($home) && $home !== '' && ( ! is_string($here) || $norm($here) !== $norm($home) ) ) {
        header('Location: '.$home, true, 302);
        exit;
    }
}

$R = $CFG->apphome . '/';
$T = $CFG->wwwroot . '/';
if ( isset($CFG->top_menu_callback) && is_callable($CFG->top_menu_callback) ) {
    $set = call_user_func($CFG->top_menu_callback);
} else {
    $set = new \Tsugi\UI\MenuSet();
    $set->setHome($CFG->servicename, $CFG->getHomeUrl());
}
$OUTPUT->topNavSession($set);

$OUTPUT->header();
?>
<style>
a[target="_blank"]:after {
    font-family: "FontAwesome";
    content: " \f08e";
}
.goog-te-banner-frame.skiptranslate {
    display: none !important;
    } 
body {
    top: 0px !important; 
    }
</style>
