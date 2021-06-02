<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, HEAD, OPTIONS, POST, PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Origin, Accept, X-Requested-With, Content-Type, Access-Control-Request-Method, Access-Control-Request-Headers');

// ====================================================================================================================

$uri = $_SERVER['REQUEST_URI'];
if (strstr($uri, '?')) {
    $pos = strpos($uri, '?');
    $uri = substr($uri, 0, $pos);
}
$uri = urldecode($uri);
$uri = mb_strtolower($uri);
$uri = preg_replace('/[^a-z0-9_\-\.\/]/i', '', $uri);
$uri = trim($uri, '/');
$uri = explode('/', $uri);
if (!@$uri[2]) {
    http_response_code(400);
    exit();
}

$channel = $uri[2];
$action = @$uri[3] ?: null;
$plain = @$uri[4] ?: null;

// ====================================================================================================================

include 'utils.php';
include 'config.php';

// ====================================================================================================================

$pdo = new PDO('mysql:host=' . $db_host .';dbname=' . $db_base, $db_user, $db_pass);

// ====================================================================================================================

$user = get_twitch_user($pdo, $client_id, $client_secret, $channel, $hours);
if (!$user) {
    http_response_code(404);
    exit();
}

// ====================================================================================================================

if ($action == 'gif') {
    if (!$plain) {
        http_response_code(400);
        exit();
    }
    $sql = "DELETE FROM `images` WHERE `id` = {$user->id}";
    query($pdo, $sql);
    $image_custom = 'https://cdn.streamelements.com/uploads/' . $plain;
    if (!@getimagesize($image_custom)) {
        http_response_code(404);
        exit();
    }
    $sql =
    "INSERT INTO `images` (
        `id`,
        `image_custom`,
        `date`
    ) VALUES (
        {$user->id},
        '{$image_custom}',
        NOW()
    )";
    query($pdo, $sql);
    http_response_code(200);
    exit();
}

// ====================================================================================================================

$user = (object)[
    'id' => $user->id,
    'user' => $user->user,
    'name' => $user->name,
    'url' => 'https://twitch.tv/' . $user->user,
    'game' => $user->game ?: '(nenhum jogo, ainda)',
    'image_logo' => !strstr($user->image_logo, 'default') ? $user->image_logo : 'https://xt.art.br/indica/api/no_profile.jpg',
    'image_game' => $user->game ? 'https://static-cdn.jtvnw.net/ttv-boxart/' . rawurlencode($user->game) . '-144x192.jpg' : 'https://xt.art.br/indica/api/no_game.jpg',
];

// ====================================================================================================================

$sql = "SELECT `image_custom` FROM `images` WHERE `id` = {$user->id}";
$images = select($pdo, $sql, true);
$image_custom = @$images->image_custom ?: null;
if (!@getimagesize($image_custom)) {
    $image_custom = null;
}
if ($image_custom) {
    $user->image_logo = $image_custom;
}

// ====================================================================================================================

if ($action == 'bot') {
    if (!$plain) {
        http_response_code(400);
        exit();
    }
    header('Content-type:text/plain; charset=utf8');
    echo $user->{$plain};
    exit();
}

// ====================================================================================================================

$log = [
    'id' => $user->id,
    'channel' => $user->user,
    'game' => $user->game,
    'caller' => $action,
    'ip' => $_SERVER['REMOTE_ADDR'],
    'datetime' => date('Y-m-d H:i:s'),
    'date' => date('Y-m-d'),
    'hour' => date('H:i:s')
];
$log = (object)$log;
$sql =
"INSERT INTO `logs` (
    `channel`,
    `game`,
    `caller`,
    `ip`,
    `datetime`,
    `date`,
    `time`
) VALUES (
    '{$log->channel}',
    '{$log->game}',
    '{$log->caller}',
    '{$log->ip}',
    '{$log->datetime}',
    '{$log->date}',
    '{$log->hour}'
)";
query($pdo, $sql);

// ====================================================================================================================

header('Content-type:application/json; charset=utf8');
echo json_encode($user);