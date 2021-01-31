<?php

include "../api/config.php";

function select($sql) {
    global $pdo;
    $return = [];
    $statement = $pdo->prepare($sql);
    $statement->execute();
    if ($statement->columnCount() > 0) {
        while ($row = @$statement->fetch(PDO::FETCH_OBJ)) {
            $return[] = $row;
        }
    }
    return $return;
}

$pdo = new PDO('mysql:host=' . $db_host .';dbname=' . $db_base, $db_user, $db_pass);

$qtd_indica = select("SELECT count(*) AS qtd FROM `indica`");
$streamer_usando = select("SELECT * FROM (SELECT `caller` AS canal, count(*) AS qtd FROM `indica` GROUP BY `caller`) sub WHERE sub.canal != '' ORDER BY sub.qtd DESC");
$streamer_indicado = select("SELECT * FROM (SELECT channel AS canal, count(*) AS qtd FROM `indica` GROUP BY channel) sub WHERE sub.canal != '' ORDER BY sub.qtd DESC");
$jogo_jogado = select("SELECT * FROM (SELECT game, count(*) AS qtd FROM `indica` GROUP BY game) sub  WHERE sub.game != '' ORDER BY sub.qtd DESC");

?><!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>
        <title>!indica | log</title>
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link rel="icon" href="favicon.png" sizes="16x16" type="image/x-icon"/>
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@100;300;400;700&family=Ubuntu:wght@300;400;700&display=swap" rel="stylesheet">
        <link href="style.css" rel="stylesheet">
    </head>
    <body>
    <h2>STREAMERS USANDO !INDICA</h2>
    <table>
    <tr><th>#</th><th>CANAL</th><th>QTD</th></tr>
    <?php foreach ($streamer_usando as $i => $s) : ?>
        <tr><td><?php echo $i + 1?></td><td><a target="_blank" href="https://twitch.tv/<?php echo $s->canal ?>"><?php echo $s->canal ?></a></td><td><?php echo $s->qtd ?></td></tr>
    <?php endforeach ?>
    </table>
    <h2>STREAMERS !INDICADOS</h2>
    <table>
    <tr><th>#</th><th>CANAL</th><th>QTD</th></tr>
    <?php foreach ($streamer_indicado as $i => $s) : ?>
        <tr><td><?php echo $i + 1 ?></td><td><a target="_blank" href="https://twitch.tv/<?php echo $s->canal ?>"><?php echo $s->canal ?></a></td><td><?php echo $s->qtd ?></td></tr>
    <?php endforeach ?>
    </table>
    <h2>JOGO MAIS !INDICADO</h2>
    <table>
    <tr><th>#</th><th>JOGO</th><th>QTD</th></tr>
    <?php foreach ($jogo_jogado as $i => $s) : ?>
        <tr><td><?php echo $i + 1 ?></td><td><?php echo $s->game ?></td><td><?php echo $s->qtd ?></td></tr>
    <?php endforeach ?>
    </table>
</body>
</html>
