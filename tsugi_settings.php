<?php
if ( ! isset($CFG) ) {
    http_response_code(404);
    exit;
}
/**
 * These are some configuration variables that are not secure / sensitive
 *
 * This file is included at the end of tsugi/config.php
 */

$CFG->tool_folders = array("admin", "../tools", "../mod", "tool");

$CFG->google_login_redirect = $CFG->apphome . "/login";

$CFG->sessionlifetime = 18*60*60;  // 18 hours

$CFG->service_worker = true;

$CFG->top_menu_callback = function() {
    global $CFG;
    $R = rtrim((string) $CFG->apphome, '/') . '/';
    $T = rtrim((string) $CFG->wwwroot, '/') . '/';
    $set = new \Tsugi\UI\MenuSet();
    $set->setHome($CFG->servicename, $CFG->apphome);
    if ( $CFG->google_client_id && ! \Tsugi\Util\U::isLoggedIn() ) {
        $set->addRight('Login', $R.'login');
    }
    if ( $CFG->google_client_id && \Tsugi\Util\U::isLoggedIn() ) {
        $submenu = new \Tsugi\UI\Menu();
        $submenu->addLink('Profile', $R.'profile');
        $submenu->addLink('Map', $R.'map');
        if ( isset($_COOKIE['adminmenu']) && $_COOKIE['adminmenu'] == 'true' ) {
            $submenu->addLink('Admin', $T.'admin/');
        }
        $submenu->addLink('Logout', $R.'logout');
        $set->addRight(\Tsugi\UI\Output::avatarMenuTrigger(), $submenu);
    }
    if ( \Tsugi\Util\U::isLoggedIn() && \Tsugi\Controllers\Courses::showCoursesWidget() ) {
        $set->addRight(
            '<tsugi-courses api-url="'. htmlspecialchars($T . 'courses/json') . '" all-url="'. htmlspecialchars($T . 'courses') . '" enter-url="'. htmlspecialchars($T . 'courses') . '"></tsugi-courses>',
            false,
            true,
            'hidden-xs tsugi-wc-nav-item'
        );
    }
    if ( $CFG->hasSiteLessons() ) {
        $set->addLeft('Lessons', $R.'lessons');
    }
    return $set;
};
