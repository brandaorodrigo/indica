<?php

// config

include "config.php";

// twitch

$url = "https://api.twitch.tv/kraken/";

// header

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, HEAD, OPTIONS, POST, PUT");

// uri

$uri = substr($_SERVER["REQUEST_URI"], $uri);
if (strstr($uri, "?")) {
    $pos = strpos($uri, "?");
    $uri = substr($uri, 0, $pos);
}
$uri = urldecode($uri);
$uri = mb_strtolower($uri);
$uri = preg_replace("/[^a-z0-9_\/]/i", "", $uri);
$uri = trim($uri, "/");
$uri = explode("/", $uri);
$indication = @$uri[1];
$caller = @$uri[2];

// javascript

if (!$indication) {
    header("Content-type:text/javascript; charset=utf8");
    include "streamelements.js";
    // http_response_code(400);
    exit();
}

// id

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

// info

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

// json

$json = [
    "id" => $result->_id,
    "name" => $result->display_name,
    "url" => "https://twitch.tv/" . $result->name,
    "game" => $result->game,
    "views" => $result->views,
    "followers" => $result->followers,
    "image_logo" => $result->logo,
    "image_game" => "https://static-cdn.jtvnw.net/ttv-boxart/" . rawurlencode($result->game) . "-144x192.jpg",
    "caller" => $caller
];

// log

/*
CREATE TABLE IF NOT EXISTS `log_indicador` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `channel` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
    `game` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
    `caller` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
    `date` datetime NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
*/

$pdo = new PDO('mysql:host=' . $db_host .';dbname=' . $db_base, $db_user, $db_pass);
$sql =
"INSERT INTO `log_indicador` (
    `channel`,
    `game`,
    `caller`,
    `date`
) VALUE (
    '" . $result->display_name . "',
    '" . $result->game .  "',
    '" . $caller . "',
    '" . date('Y-m-d H:i:s') . "'
)";
$statement = $pdo->prepare($sql);
$statement->execute();

// echo

header("Content-type:application/json; charset=utf8");
echo json_encode($json);
