# !indica

https://xt.art.br/indica

**!indica** is a fully customizable tool for streamers who recommend other streamers in their livestreams.

## developed by

- rodrigo brandão / https://twitch.tv/brandaozzz
- sony linhares / https://twitch.tv/xtart
- lucas linhares / https://twitch.tv/tchepper

# commands

### streamelements

```
Conheça ${urlfetch https://xt.art.br/indica/api/${1}/bot/name} que estava jogando ${urlfetch https://xt.art.br/indica/api/${1}/bot/game}. Acesse https://twitch.tv/${urlfetch https://xt.art.br/indica/api/${1}/bot/user}
```

### streamelements | default

```
Conheça ${channel ${touser}} que estava jogando ${game ${touser}}. Acesse https://twitch.tv/${channel ${touser}}
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

# streamelements overlay > custom widget

### html

```html
<script src="https://xt.art.br/indica/overlay.js"></script>
```
### css

```css
/* empty */
```

### js

```javascript
/* empty */
```

### fields

```json
    "command": {
        "type": "text",
        "label": "QUAL O SEU COMANDO?",
        "group": "PERSONALIZE SEU COMANDO",
        "value": "!indica"
    },
    "img_channel": {
        "type": "image-input",
        "group": "GIF PARA SEU PERFIL",
        "label": "Faça upload de seu gif personalizado"
    },
    "img_channel_link": {
        "type": "button",
        "label": "ENVIAR SEU GIF PARA O INDICA",
        "group": "GIF PARA SEU PERFIL",
        "value": "1"
    },
    "img_channel_unlink": {
        "type": "button",
        "label": "REMOVER O SEU GIF DO INDICA",
        "group": "GIF PARA SEU PERFIL",
        "value": "1"
    },
    "btn_test_color": {
        "type": "button",
        "label": "TESTAR A SUA OVERLAY",
        "group": "FORMAS E CORES",
        "value": "1"
    },
    "border_radius": {
        "type": "dropdown",
        "label": "ARREDONDAMENTO DOS CANTOS",
        "group": "FORMAS E CORES",
        "value": "0",
        "options": {
            "0": "0%",
            "5": "5%",
            "10": "10%",
            "30": "30%",
            "50": "50%"
        }
    },
    "border_color_line": {
        "type": "colorpicker",
        "label": "COR DA LINHA DE ABERTURA",
        "group": "FORMAS E CORES",
        "value": "#f2f2f2"
    },
    "border_color_channel": {
        "type": "colorpicker",
        "label": "COR DA BORDA | FOTO DO CANAL",
        "group": "FORMAS E CORES",
        "value": "#f2f2f2"
    },
    "border_color_game": {
        "type": "colorpicker",
        "label": "COR DA BORDA | FOTO DO JOGO",
        "group": "FORMAS E CORES",
        "value": "#f2f2f2"
    },
    "font_color_channel": {
        "type": "colorpicker",
        "label": "COR DA FONTE | NOME DO CANAL",
        "group": "FORMAS E CORES",
        "value": "#f2f2f2"
    },
    "font_color_game": {
        "type": "colorpicker",
        "label": "COR DA FONTE | NOME DO JOGO",
        "group": "FORMAS E CORES",
        "value": "#f2f2f2"
    },
    "shadow_color": {
        "type": "colorpicker",
        "label": "COR DA SOMBRA",
        "group": "FORMAS E CORES",
        "value": "rgba(0,0,0,0.4)"
    },
    "btn_test_font": {
        "type": "button",
        "label": "TESTAR A SUA OVERLAY",
        "group": "ESTILOS DE TEXTO",
        "value": "1"
    },
    "font": {
        "type": "googleFont",
        "label": "FONTE DOS TEXTOS",
        "group": "ESTILOS DE TEXTO",
        "value": "Varela Round"
    },
    "font_weight_channel": {
        "type": "dropdown",
        "label": "ESTILO DA FONTE | NOME DO CANAL",
        "group": "ESTILOS DE TEXTO",
        "value": "400",
        "options": {
            "400": "Normal",
            "400|italic": "Itálico",
            "700": "Negrito",
            "700|italic": "Negrito e Itálico",
            "900": "Black",
            "900|italic": "Black e Itálico"
        }
    },
    "font_weight_game": {
        "type": "dropdown",
        "label": "ESTILO DA FONTE | NOME DO JOGO",
        "group": "ESTILOS DE TEXTO",
        "value": "400",
        "options": {
            "400": "Normal",
            "400|italic": "Itálico",
            "700": "Negrito",
            "700|italic": "Negrito e Itálico",
            "900": "Black",
            "900|italic": "Black e Itálico"
        }
    }
}
```
### data

```json
/* empty */
```

# mysql

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