<?php

function twitch_users($client_id, $channel_name) {
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => "https://api.twitch.tv/kraken/users/?login=" . $channel_name . "&client_id=" . $client_id . "&api_version=5",
        CURLOPT_RETURNTRANSFER => 1
    ]);
    $result = @curl_exec($curl);
    $result = @json_decode($result, true);
    $user_id = @$result["users"][0]["_id"];
    if (!$user_id) {
        return false;
    }
    return $user_id;
}

function twitch_channels($client_id, $user_id) {
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => "https://api.twitch.tv/kraken/channels/" . $user_id . "?client_id=" . $client_id . "&api_version=5",
        CURLOPT_RETURNTRANSFER => 1
    ]);
    $result = @curl_exec($curl);
    $result = @json_decode($result);
    if (!$result) {
        return false;
    }
    $return = [
        "id" => $result->_id,
        "user" => $result->name,
        "name" => $result->display_name,
        "url" => "https://twitch.tv/" . $result->name,
        "game" => $result->game ?: "(nenhum jogo, ainda)",
        "views" => $result->views,
        "followers" => $result->followers,
        "image_logo" => !strstr($result->logo, 'default') ? $result->logo : "https://xt.art.br/indica/api/no_profile.png",
        "image_game" => $result->game ? "https://static-cdn.jtvnw.net/ttv-boxart/" . rawurlencode($result->game) . "-144x192.jpg" : "https://xt.art.br/indica/api/no_game.png",
        "date" => date('Y-m-d H:i:s')
    ];
    $return = (object)$return;
    return $return;
}

function db_select($pdo, $sql, $first = false) {
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

function db_query($pdo, $sql) {
    $statement = $pdo->prepare($sql);
    $statement->execute();
}

function base64($img, $type = false) {
    if (!$type) {
        $type = pathinfo($img, PATHINFO_EXTENSION);
    }
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $img);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $img = curl_exec($ch);
    curl_close($ch);
    if (!$img) {
        return null;
    }
    $base64 = base64_encode($img);
    return 'data:image/' . $type . ';charset=utf-8;base64, ' . $base64;
}

// ----------------------------------------------------------------------------

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, HEAD, OPTIONS, POST, PUT");
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Origin, Accept, X-Requested-With, Content-Type, Access-Control-Request-Method, Access-Control-Request-Headers");

// ----------------------------------------------------------------------------

$uri = $_SERVER["REQUEST_URI"];
if (strstr($uri, "?")) {
    $pos = strpos($uri, "?");
    $uri = substr($uri, 0, $pos);
}
$uri = urldecode($uri);
$uri = mb_strtolower($uri);
$uri = preg_replace("/[^a-z0-9_\/]/i", "", $uri);
$uri = trim($uri, "/");
$uri = explode("/", $uri);
$indication = @$uri[2];
$caller = @$uri[3];
$plain = @$uri[4];
if (!$indication) {
    http_response_code(400);
    exit();
}

// ----------------------------------------------------------------------------

include "config.php";
$pdo = new PDO('mysql:host=' . $db_host .';dbname=' . $db_base, $db_user, $db_pass);

// -------------------------------------------------------------------

if ($caller == 'add' || $caller == 'rmv') {
    // TODO TENTAR LIMITAR O CALLER PARA O STREAMELEMENTS SOMENTE
    if (@$_GET['img_logo'] && stristr(@$_GET['img_logo'], 'https://cdn.streamelements.com')) {
        $user_id = twitch_users($client_id, $indication);
        if (!$user_id) {
            http_response_code(400);
            exit();
        }
        $date = date("Y-m-d H:i:s");
        $sql ="DELETE FROM `images` WHERE `id` = {$user_id}";
        db_query($pdo, $sql);
        if ($caller == 'add') {
            $sql =
            "INSERT INTO `images` (
                `id`,
                `image_custom`,
                `date`
            ) VALUES (
                {$user_id},
                '{$_GET['img_logo']}',
                '{$date}'
            )";
            db_query($pdo, $sql);
        }
    }
    http_response_code(200);
    exit();
}

// -------------------------------------------------------------------

$sql = "SELECT * FROM `channels` WHERE `user` = '{$indication}'";
$twitch = db_select($pdo, $sql, true);
if (!@$twitch->date || time() > strtotime(@$twitch->date) + ($hours * 3600)) {
    $user_id = twitch_users($client_id, $indication);
    if (!$user_id) {
        http_response_code(400);
        exit();
    }
    $twitch = twitch_channels($client_id, $user_id);
    if (!$twitch) {
        http_response_code(400);
        exit();
    }
    $sql = "DELETE FROM `channels` WHERE `user` = '{$indication}'";
    db_query($pdo, $sql);
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
    db_query($pdo, $sql);
}

$sql = "SELECT `image_custom` FROM `images` WHERE `id` = {$twitch->id}";
$images = db_select($pdo, $sql, true);
$image_custom = @$images->image_custom ?: null;
if (!@getimagesize($image_custom)) {
    $image_custom = null;
}
if ($image_custom) {
    $twitch->image_logo = $image_custom;
}

// ----------------------------------------------------------------------------

if ($caller == "bot") {
    if (!$plain) {
        http_response_code(400);
        exit();
    }
    header("Content-type:text/plain; charset=utf8");
    echo $twitch->{$plain};
    exit();
}

// ----------------------------------------------------------------------------

$log = [
    "channel" => $twitch->user,
    "game" => $twitch->game,
    "caller" => $caller,
    "ip" => $_SERVER['REMOTE_ADDR'],
    "datetime" => date("Y-m-d H:i:s"),
    "date" => date("Y-m-d"),
    "hour" => date("H:i:s")
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
db_query($pdo, $sql);

// json -----------------------------------------------------------------------

$twitch->image_logo = base64($twitch->image_logo);
$twitch->image_game = base64($twitch->image_game);

header("Content-type:application/json; charset=utf8");
echo json_encode($twitch);