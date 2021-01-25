<?php

include "api/config.php";

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

$qtd_indica = select("SELECT count(*) AS qtd FROM `log_indicador`");
$streamer_usando = select("SELECT * FROM (SELECT `caller` AS canal, count(*) AS qtd FROM `log_indicador` GROUP BY `caller`) sub ORDER BY sub.qtd DESC");
$streamer_indicado = select("SELECT * FROM (SELECT channel AS canal, count(*) AS qtd FROM `log_indicador` GROUP BY channel) sub ORDER BY sub.qtd DESC");

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
        <style>
            * {
                font-family: 'Ubuntu', sans-serif !important;
                font-weight: 400;
            }
            body {
                background: #fff;
                margin: 0;
                color: #666;
                font-size: 14px;
                padding: 0;
                font-weight: 300;
            }
            table, th, td {
                border-collapse: collapse;
            }
            th, td {
                border:1px solid #ccc;
                padding:5px;
                text-align:left;
            }
            table {
                width:400px;
                margin:10px auto;
            }

            .left {
                width:50vw;position:absolute;left:0;top:0;
                padding:40px;
                text-align:center;
            }
            .right {
                width:50vw;position:absolute;right:0;top:0;
                padding:40px;
                text-align:center;
            }
        </style>
    </head>
    <body>
    <div class="left">
    <h1>STREAMERS USANDO !INDICA</h1>
    <table>
    <tr><th>#</th><th>CANAL</th><th>QTD</th></tr>
    <?php foreach ($streamer_usando as $i => $s) : ?>
        <tr><td><?php echo $i + 1?></td><td><a href="https://twitch.tv/<?php echo $s->canal ?>"><?php echo $s->canal ?></a></td><td><?php echo $s->qtd ?></td></tr>
    <?php endforeach ?>
    </table>
    </div>
    <div class="right">
    <h1>STREAMERS !INDICADOS</h1>
    <table>
    <tr><th>#</th><th>CANAL</th><th>QTD</th></tr>
    <?php foreach ($streamer_indicado as $i => $s) : ?>
        <tr><td><?php echo $i + 1 ?></td><td><a href="https://twitch.tv/<?php echo $s->canal ?>"><?php echo $s->canal ?></a></td><td><?php echo $s->qtd ?></td></tr>
    <?php endforeach ?>
    </table>
    </div>
</body>
</html>
