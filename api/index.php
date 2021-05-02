<?php

function twitch_users($client_id, $channel_name) {
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => 'https://api.twitch.tv/kraken/users/?login=' . $channel_name . '&client_id=' . $client_id . '&api_version=5',
        CURLOPT_RETURNTRANSFER => 1
    ]);
    $result = @curl_exec($curl);
    $result = @json_decode($result, true);
    $user_id = @$result['users'][0]['_id'];
    if (!$user_id) {
        return false;
    }
    return $user_id;
}

function twitch_channels($client_id, $user_id) {
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => 'https://api.twitch.tv/kraken/channels/' . $user_id . '?client_id=' . $client_id . '&api_version=5',
        CURLOPT_RETURNTRANSFER => 1
    ]);
    $result = @curl_exec($curl);
    $result = @json_decode($result);
    if (!$result) {
        return false;
    }
    $return = [
        'id' => $result->_id,
        'user' => $result->name,
        'name' => $result->display_name,
        'url' => 'https://twitch.tv/' . $result->name,
        'game' => $result->game ?: '(nenhum jogo, ainda)',
        'views' => $result->views,
        'followers' => $result->followers,
        'image_logo' => !strstr($result->logo, 'default') ? $result->logo : 'https://xt.art.br/indica/api/no_profile.jpg',
        'image_game' => $result->game ? 'https://static-cdn.jtvnw.net/ttv-boxart/' . rawurlencode($result->game) . '-144x192.jpg' : 'https://xt.art.br/indica/api/no_game.jpg',
        'date' => date('Y-m-d H:i:s')
    ];
    $return = (object)$return;
    return $return;
}

function select($pdo, $sql, $first = false) {
    $return = [];
    $statement = $pdo->prepare($sql);
    $statement->execute();
    if ($statement->columnCount() > 0) {
        while ($row = @$statement->fetch(PDO::FETCH_OBJ)) {
            if ($first) {
                return $row;
            }
            $return[] = $row;
        }
    }
    return $return;
}

function query($pdo, $sql) {
    $statement = $pdo->prepare($sql);
    $statement->execute();
}

// ----------------------------------------------------------------------------

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, HEAD, OPTIONS, POST, PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Origin, Accept, X-Requested-With, Content-Type, Access-Control-Request-Method, Access-Control-Request-Headers');

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
// ----------------------------------------------------------------------------

$user_id = $channel_name = $action = $plain = null;
if (is_numeric($uri[2])) {
    $user_id = $uri[2];
} else {
    $channel_name = $uri[2];
}
$action = @$uri[3];
$plain = @$uri[4];

// ----------------------------------------------------------------------------

include 'config.php';
$pdo = new PDO('mysql:host=' . $db_host .';dbname=' . $db_base, $db_user, $db_pass);

// ----------------------------------------------------------------------------

if ($action == 'gif') {
    if (!$user_id || !$plain) {
        http_response_code(400);
        exit();
    }
    $sql = "DELETE FROM `images` WHERE `id` = {$user_id}";
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
        {$user_id},
        '{$image_custom}',
        NOW()
    )";
    query($pdo, $sql);
    http_response_code(200);
    exit();
}

// ----------------------------------------------------------------------------

$sql = "SELECT * FROM `channels` WHERE " . ($user_id ? "`id` = " . $user_id : "`user` = '" . $channel_name . "'");
$twitch = select($pdo, $sql, true);
if (!@$twitch->date || time() > strtotime(@$twitch->date) + ($hours * 3600)) {
    $user_id = $user_id ?: twitch_users($client_id, $channel_name);
    if (!$user_id) {
        http_response_code(404);
        exit();
    }
    $twitch = twitch_channels($client_id, $user_id);
    if (!$twitch) {
        http_response_code(404);
        exit();
    }
    $sql = "DELETE FROM `channels` WHERE `id` = {$user_id}";
    query($pdo, $sql);
    $sql =
    "INSERT INTO `channels` (
        `id`,
        `user`,
        `name`,
        `url`,
        `game`,
        `views`,
        `followers`,
        `image_logo`,
        `image_game`,
        `date`
    ) VALUES (
        {$twitch->id},
        '{$twitch->user}',
        '{$twitch->name}',
        '{$twitch->url}',
        '{$twitch->game}',
        {$twitch->views},
        {$twitch->followers},
        '{$twitch->image_logo}',
        '{$twitch->image_game}',
        '{$twitch->date}'
    )";
    query($pdo, $sql);
}
$sql = "SELECT `image_custom` FROM `images` WHERE `id` = {$twitch->id}";
$images = select($pdo, $sql, true);
$image_custom = @$images->image_custom ?: null;
if (!@getimagesize($image_custom)) {
    $image_custom = null;
}
if ($image_custom) {
    $twitch->image_logo = $image_custom;
}

// ----------------------------------------------------------------------------

if ($action == 'bot') {
    if (!$plain) {
        http_response_code(400);
        exit();
    }
    header('Content-type:text/plain; charset=utf8');
    echo $twitch->{$plain};
    exit();
}

// ----------------------------------------------------------------------------

$log = [
    'channel' => $twitch->user,
    'game' => $twitch->game,
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

// ----------------------------------------------------------------------------

header('Content-type:application/json; charset=utf8');
echo json_encode($twitch);