<?php

// config ---------------------------------------------------------------------

date_default_timezone_set('America/Fortaleza');

include "config.php";

// header ---------------------------------------------------------------------

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, HEAD, OPTIONS, POST, PUT");
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Origin, Accept, X-Requested-With, Content-Type, Access-Control-Request-Method, Access-Control-Request-Headers");

// uri ------------------------------------------------------------------------

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

// pdo ------------------------------------------------------------------------

$pdo = new PDO('mysql:host=' . $db_host .';dbname=' . $db_base, $db_user, $db_pass);

function select($sql, $first = false)
{
    global $pdo;
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

// channels -------------------------------------------------------------------

$sql = "SELECT * FROM `channels` WHERE `user` = '{$indication}'";
$twitch = select($sql, true);

if (!@$twitch->date || time() > strtotime(@$twitch->date) + ($hours * 3600)) {

    // kraken -----------------------------------------------------------------

    $url = "https://api.twitch.tv/kraken/";

    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => $url . "users/?login=" . $indication . "&client_id=" . $client_id . "&api_version=5",
        CURLOPT_RETURNTRANSFER => 1
    ]);
    $result = @curl_exec($curl);
    $result = @json_decode($result, true);
    $user_id = @$result["users"][0]["_id"];
    if (!$user_id) {
        http_response_code(400);
        exit();
    }

    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => $url . "channels/" . $user_id . "?client_id=" . $client_id . "&api_version=5",
        CURLOPT_RETURNTRANSFER => 1
    ]);
    $result = @curl_exec($curl);
    $result = @json_decode($result);
    if (!$result) {
        http_response_code(400);
        exit();
    }

    $sql = "DELETE FROM `channels` WHERE `user` = '{$indication}'";
    $statement = $pdo->prepare($sql);
    $statement->execute();

    $twitch = [
        "id" => $result->_id,
        "user" => $result->name,
        "name" => $result->display_name,
        "url" => "https://twitch.tv/" . $result->name,
        "game" => $result->game ?: "(nenhum jogo, ainda)",
        "views" => $result->views,
        "followers" => $result->followers,
        "image_logo" => $result->logo,
        "image_game" => "https://static-cdn.jtvnw.net/ttv-boxart/" . rawurlencode($result->game) . "-144x192.jpg",
        "date" => date('Y-m-d H:i:s')
    ];
    $twitch = (object)$twitch;

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
        '{$twitch->views}',
        '{$twitch->followers}',
        '{$twitch->image_logo}',
        '{$twitch->image_game}',
        '{$twitch->date}'
    )";
    $statement = $pdo->prepare($sql);
    $statement->execute();

}

$sql = "SELECT `image_custom` FROM `images` WHERE `id` = {$twitch->id}";
$image_custom = select($sql, true);
$image_custom = @$image_custom->image_custom ?: null;
if (!@getimagesize($image_custom)) {
    $image_custom = null;
}
if ($image_custom) {
    $twitch->image_logo = $image_custom;
}

// plain ----------------------------------------------------------------------

if ($caller == "bot") {
    if (!$plain) {
        http_response_code(400);
        exit();
    }
    header("Content-type:text/plain; charset=utf8");
    echo $twitch->{$plain};
    exit();
}

// log ------------------------------------------------------------------------

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
$statement = $pdo->prepare($sql);
$statement->execute();

// json -----------------------------------------------------------------------

header("Content-type:application/json; charset=utf8");
echo json_encode($twitch);