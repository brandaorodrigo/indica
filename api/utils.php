<?php

function query($pdo, $sql)
{
    $statement = $pdo->prepare($sql);
    $statement->execute();
}

function select($pdo, $sql, $first = false)
{
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

function set_token($pdo, $client_id, $client_secret)
{
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => 'https://id.twitch.tv/oauth2/token',
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => http_build_query([
            'client_id' => $client_id,
            'client_secret' => $client_secret,
            'grant_type' => 'client_credentials',
        ])
    ]);
    $response = @curl_exec($curl);
    $response = @json_decode($response);
    if (!$response) {
        curl_close($curl);
        return null;
    }
    $response->expires_in = date('Y-m-d H:i:s', time() + 86400);
    $sql = "DELETE FROM token";
    query($pdo, $sql);
    $sql =
        "INSERT INTO token (
        access_token,
        expires_in
    ) VALUES (
        '{$response->access_token}',
        '{$response->expires_in}'
    )";
    query($pdo, $sql);
    return @$response->access_token ?? null;
}

function get_token($pdo, $client_id, $client_secret)
{
    $sql = "SELECT access_token FROM token WHERE expires_in > now()";
    $row = select($pdo, $sql, true);
    $access_token = @$row->access_token;
    if (!$access_token) {
        $access_token = set_token($pdo, $client_id, $client_secret);
    }
    return $access_token;
}

function set_twitch_user($pdo, $client_id, $client_secret, $channel)
{
    $access_token = get_token($pdo, $client_id, $client_secret);
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => 'https://api.twitch.tv/helix/users?login=' . $channel,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => [
            'Authorization: Bearer ' . $access_token,
            'Client-Id: ' .  $client_id
        ],
    ]);
    $user = curl_exec($curl);
    $user = @json_decode($user);
    $user = @$user->data[0];
    if (!$user) {
        curl_close($curl);
        return null;
    }
    curl_setopt_array($curl, [
        CURLOPT_URL => 'https://api.twitch.tv/helix/channels?broadcaster_id=' . $user->id,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => [
            'Authorization: Bearer ' . $access_token,
            'Client-Id: ' .  $client_id
        ],
    ]);
    $broadcaster = @curl_exec($curl);
    $broadcaster = @json_decode($broadcaster);
    $broadcaster = @$broadcaster->data[0];
    if (!$broadcaster) {
        curl_close($curl);
        return null;
    }
    $user->game_name = $broadcaster->game_name;
    $user->game_id = $broadcaster->game_id;
    $sql = "DELETE FROM `users` WHERE `id` = {$user->id}";
    query($pdo, $sql);
    $date = date('Y-m-d H:i:s');
    $sql =
        "INSERT INTO `users` (
            `id`,
            `user`,
            `name`,
            `image_logo`,
            `game`,
            `game_id`,
            `date`
        ) VALUES (
            {$user->id},
            '{$user->login}',
            '{$user->display_name}',
            '{$user->profile_image_url}',
            '{$user->game_name}',
            '{$user->game_id}',
            '{$date}'
        )";
    query($pdo, $sql);
    return (object)[
        'id' => $user->id,
        'user' => $user->login,
        'name' => $user->display_name,
        'image_logo' => $user->profile_image_url,
        'game' => $user->game_name,
        'game_id' => $user->game_id,
    ];
}

function get_twitch_user($pdo, $client_id, $client_secret, $channel, $hours)
{
    $expires_id = date('Y-m-d H:i:s', time() - ($hours * 3600));
    $sql =
        "SELECT
            users.id,
            users.user,
            users.name,
            users.image_logo,
            users.game,
            users.game_id,
            users.date
        FROM
            users
        WHERE
            users.user = '{$channel}'
        AND
            users.date > '{$expires_id}'
        ";
    $user = select($pdo, $sql, true);
    if (!$user) {
        $user = set_twitch_user($pdo, $client_id, $client_secret, $channel);
    }
    return $user;
}
