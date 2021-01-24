
# !indica

!indica é uma ferramenta totalmente customizável e de
código aberto para você poder indicar seus amigos streamers.

# comando para chatbots

### streamelements

    /me Conheça o canal de @${user ${1}} que estava jogando ${game ${1}}. Acesse: http://twitch.tv/${user.name ${1}}

### streamlabs

    /me Conheça o canal de @{touser.name} que estava jogando {touser.game}. Acesse http://twitch.tv/{touser.name}

### nightbot

    /me Conheça o canal de @$(twitch $(touser) "{{displayName}}") que estava jogando $(twitch $(touser) "{{game}}"). Acesse http://twitch.tv/$(twitch $(touser) "{{name}}")


### mixitup

    /me Conheça $arg1username que estava jogando $arg1userstreamgame. Acesse https://twitch.tv/$arg1username

### firebot

    /me Conheça $target que estava jogando $game[$target]. Acesse https://twitch.tv/$target

# overlay para streamelements > custom widget

### html

    <script  src="https://xt.art.br/overlay"></script>

### css

    (apagar tudo e deixar vazio)

### js

    (apagar tudo e deixar vazio)

### fields

    {
        "command": {
            "type": "text",
            "label": "Qual é seu comando personalizado?",
            "group": "Comando",
            "value": "!indica"
        },
        "font": {
            "type": "googleFont",
            "label": "Fonte",
            "group": "Fontes",
            "value": "Roboto"
        },
        "font_style_user": {
            "type": "dropdown",
            "label": "Estilo da fonte do nome do streamer",
            "group": "Fontes",
            "value": "700",
            "options": {
                "400": "Normal",
                "700": "Negrito",
                "900": "Black",
                "400_italic": "Normal Itálico",
                "700_italic": "Negrito Itálico",
                "900_italic": "Black Itálico"
            }
        },
        "font_color_user": {
            "type": "colorpicker",
            "label": "Cor da fonte do nome do streamer",
            "group": "Fontes",
            "value": "#ffffff"
        },
        "font_style_game": {
            "type": "dropdown",
            "label": "Estilo da fonte do nome do jogo",
            "group": "Fontes",
            "value": "400",
            "options": {
                "400": "Normal",
                "700": "Negrito",
                "900": "Black",
                "400_italic": "Normal Itálico",
                "700_italic": "Negrito Itálico",
                "900_italic": "Black Itálico"
            }
        },
        "font_color_game": {
            "type": "colorpicker",
            "label": "Cor da fonte do nome do jogo",
            "group": "Fontes",
            "value": "#ffffff"
        },
        "shadow_color": {
            "type": "colorpicker",
            "label": "Cor da sombra do texto",
            "group": "Fontes",
            "value": "#888888"
        },
        "border_radius": {
            "type": "dropdown",
            "label": "Arredondar bordas",
            "group": "Bordas",
            "value": "0",
            "options": {
                "0": "0%",
                "5": "5%",
                "10": "10%",
                "30": "30%",
                "50": "50%"
            }
        },
        "border_color_user": {
            "type": "colorpicker",
            "label": "Cor da borda da foto do streamer",
            "group": "Bordas",
            "value": "#ffffff"
        },
        "border_color_game": {
            "type": "colorpicker",
            "label": "Cor da borda da capa do jogo",
            "group": "Bordas",
            "value": "#ffffff"
        },
        "border_color_line": {
            "type": "colorpicker",
            "label": "Cor da linha lateral",
            "group": "Bordas",
            "value": "#ffffff"
        }
    }

### data

    (não precisa alterar)