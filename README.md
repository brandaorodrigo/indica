# !indica

!indica é uma ferramenta totalmente customizável e de código aberto para streamers indicarem outros streamers em suas lives.

## site oficial

https://xt.art.br/indica

## desenvolvido por

- rodrigo brandão / https://twitch.tv/brandaozzz
- sony linhares  / https://twitch.tv/xtart
- lucas linhares  / https://twitch.tv/tchepper

# comando

### streamelements

```
Conheça ${urlfetch https://xt.art.br/indica/api/${1}/bot/name} que estava jogando ${urlfetch https://xt.art.br/indica/api/${1}/bot/game}. Acesse https://twitch.tv/${urlfetch https://xt.art.br/indica/api/${1}/bot/user}
```

### streamlabs | cloudbot

```
Conheça {touser.name} que estava jogando {touser.game}. Acesse http://twitch.tv/{touser.name}
```

### streamlabs | chatbot

```
Conheça $touser que estava jogando $game. Acesse https://twitch.tv/$touser
```

### nightbot

```
Conheça o canal de $(twitch $(touser) "{{displayName}}") que estava jogando $(twitch $(touser) "{{game}}"). Acesse http://twitch.tv/$(twitch $(touser) "{{name}}")
```
### mixitup

```
Conheça $arg1username que estava jogando $arg1userstreamgame. Acesse https://twitch.tv/$arg1username
```
### firebot

```
Conheça $target que estava jogando $game[$target]. Acesse https://twitch.tv/$target
```

# overlay para streamelements > custom widget

### html

```html
<script src="https://xt.art.br/indica/overlay.js"></script>
```
### css

```html
(apagar tudo e deixar vazio)
```

### js

```html
(apagar tudo e deixar vazio)
```

### fields

```javascript
{
    "command": {
        "type": "text",
        "label": "Qual é seu comando personalizado?",
        "group": "Comando",
        "value": "!indica"
    },
    "border_radius": {
        "type": "dropdown",
        "label": "Arredondamento",
        "group": "Geral",
        "value": "0",
        "options": {
            "0": "0%",
            "5": "5%",
            "10": "10%",
            "30": "30%",
            "50": "50%"
        }
    },
    "animation_time": {
        "type": "dropdown",
        "label": "Tempo da exibição",
        "group": "Geral",
        "value": "14",
        "options": {
            "10": "10 segundos",
            "15": "15 segundos",
            "20": "20 segundos"
        }
    },
    "font": {
        "type": "googleFont",
        "label": "Fonte",
        "group": "Geral",
        "value": "Roboto"
    },
    "shadow_color": {
        "type": "colorpicker",
        "label": "Sombra",
        "group": "Geral",
        "value": "#888888"
    },
    "border_color_line": {
        "type": "colorpicker",
        "label": "Cor da linha",
        "group": "Geral",
        "value": "#f4f4f4"
    },
    "border_color_name": {
        "type": "colorpicker",
        "label": "Cor da borda",
        "group": "Nome",
        "value": "#f4f4f4"
    },
    "font_color_name": {
        "type": "colorpicker",
        "label": "Cor da fonte",
        "group": "Nome",
        "value": "#f4f4f4"
    },
    "font_weight_name": {
        "type": "dropdown",
        "label": "Estilo da fonte",
        "group": "Nome",
        "value": "400",
        "options": {
            "400": "Normal",
            "700": "Negrito",
            "900": "Black"
        }
    },
    "font_style_name": {
        "type": "dropdown",
        "label": "Itálico",
        "group": "Nome",
        "value": "normal",
        "options": {
            "normal": "Não",
            "italic": "Sim"
        }
    },
    "border_color_game": {
        "type": "colorpicker",
        "label": "Cor da borda",
        "group": "Jogo",
        "value": "#f4f4f4"
    },
    "font_color_game": {
        "type": "colorpicker",
        "label": "Cor da fonte",
        "group": "Jogo",
        "value": "#f4f4f4"
    },
    "font_weight_game": {
        "type": "dropdown",
        "label": "Estilo da fonte",
        "group": "Jogo",
        "value": "400",
        "options": {
            "400": "Normal",
            "700": "Negrito",
            "900": "Black"
        }
    },
    "font_style_game": {
        "type": "dropdown",
        "label": "Itálico",
        "group": "Jogo",
        "value": "normal",
        "options": {
            "normal": "Não",
            "italic": "Sim"
        }
    }
}
```
### data

```html
(não precisa alterar)
```

# informações para desenvolvedores
## mysql

```sql
CREATE TABLE IF NOT EXISTS `channels` (
    `id` int(11) NOT NULL,
    `user` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
    `name` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
    `url` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
    `game` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
    `views` int(11) NOT NULL,
    `followers` int(11) NOT NULL,
    `image_logo` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
    `image_game` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
    `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `channels` ADD PRIMARY KEY (`id`), ADD KEY `id` (`id`);

CREATE TABLE IF NOT EXISTS `images` (
    `id` int(11) NOT NULL,
    `image_custom` varchar(200) COLLATE utf8_unicode_ci NULL,
    `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `images` ADD PRIMARY KEY (`id`), ADD KEY `id` (`id`);

CREATE TABLE IF NOT EXISTS `logs` (
  `id` int(11) NOT NULL,
  `channel` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `game` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `caller` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ip` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `datetime` datetime NOT NULL,
  `date` date DEFAULT NULL,
  `time` time DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
```