<?php
/*
 *  Made by Supercrafter100
 *  https://github.com/NamelessMC/Nameless/
 *  NamelessMC version 2.0.3
 *
 *  License: MIT
 *
 *  Panel user sessions page
 */
if (!$user->handlePanelPageLoad('admincp.users.sessions')) {
    require_once(ROOT_PATH . '/403.php');
    die();
}

const PAGE = 'panel';
const PARENT_PAGE = 'users';
const PANEL_PAGE = 'sessions';
$page_title = $language->get('admin', 'sessions');
require_once(ROOT_PATH . '/core/templates/backend_init.php');

// Load modules + template
Module::loadPage($user, $pages, $cache, $smarty, [$navigation, $cc_nav, $staffcp_nav], $widgets, $template);

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    Redirect::to(URL::build('/panel/users'));
}

$view_user = new User($_GET['id']);
if (!$view_user->exists()) {
    Redirect::to(URL::build('/panel/users'));
}

if (isset($_GET['action'])) {
    if ($_GET['action'] == 'logout' && isset($_GET['hash'])) {
        $hash = $_GET['hash'];
        DB::getInstance()->update('users_session', [
            'hash',
            '=',
            $hash
        ], [
            'active' => 0
        ]);
        $success = $language->get('admin', 'logout_session_successfully');
    }
}

$sessions = DB::getInstance()->query('SELECT * FROM nl2_users_session WHERE user_id = ?', [$view_user->data()->id])->results();
$user_sessions_list = [];
foreach ($sessions as $session) {
    $user_sessions_list[] = [
        'hash' => $session->hash,
        'active' => $session->active,
        'device' => $session->device_name,
        'method' => $session->login_method,
        'logout_link' => URL::build('/panel/users/sessions/','id=' . $view_user->data()->id . '&action=logout&hash=' . $session->hash)
    ];
}

$smarty->assign([
    'VIEWING_USER_SESSIONS' => $language->get('admin', 'viewing_sessions_for_x', [
        'user' =>  Output::getClean($view_user->data()->username),
    ]),
    'SESSIONS' => $user_sessions_list,
    'SESSION' => $language->get('admin', 'session'),
    'DEVICE' => $language->get('admin', 'device'),
    'ACTIVE' => $language->get('admin', 'active'),
    'LOGIN_METHOD' => $language->get('admin', 'login_method'),
    'BACK_LINK' => URL::build('/panel/user/' . Output::getClean($view_user->data()->id . '-' . $view_user->data()->username)),
    'LOGOUT' => $language->get('general', 'log_out')
]);

$smarty->assign([
    'PARENT_PAGE' => PARENT_PAGE,
    'DASHBOARD' => $language->get('admin', 'dashboard'),
    'USER_MANAGEMENT' => $language->get('admin', 'user_management'),
    'USERS' => $language->get('admin', 'users'),
    'PAGE' => PANEL_PAGE,
    'TOKEN' => Token::get(),
    'SUBMIT' => $language->get('general', 'submit'),
    'USER_ID' => $view_user->data()->id,
    'BACK' => $language->get('general', 'back')
]);

if (isset($success)) {
    $smarty->assign([
        'SUCCESS' => $success,
        'SUCCESS_TITLE' => $language->get('general', 'success')
    ]);
}

if (isset($errors) && count($errors)) {
    $smarty->assign([
        'ERRORS' => $errors,
        'ERRORS_TITLE' => $language->get('general', 'error')
    ]);
}

$template->onPageLoad();
require(ROOT_PATH . '/core/templates/panel_navbar.php');
$template->displayTemplate('core/users_sessions.tpl', $smarty);
