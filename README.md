# !indica

!indica é uma ferramenta totalmente customizável e de
código aberto para você poder indicar seus amigos streamers.

## site oficial

https://xt.art.br/indica

## desenvolvido por

- rodrigo brandão
- lucas linhares
- sony linhares

# comando

### streamelements

    /me Conheça ${user ${1}} que estava jogando ${game ${1}}. Acesse http://twitch.tv/${user.name ${1}}

### streamlabs | cloudbot

    /me Conheça {touser.name} que estava jogando {touser.game}. Acesse http://twitch.tv/{touser.name}


### streamlabs | chatbot

    /me Conheça $touser que estava jogando $game. Acesse https://twitch.tv/$touser

### nightbot

    /me Conheça o canal de $(twitch $(touser) "{{displayName}}") que estava jogando $(twitch $(touser) "{{game}}"). Acesse http://twitch.tv/$(twitch $(touser) "{{name}}")

### mixitup

    /me Conheça $arg1username que estava jogando $arg1userstreamgame. Acesse https://twitch.tv/$arg1username

### firebot

    /me Conheça $target que estava jogando $game[$target]. Acesse https://twitch.tv/$target

# overlay para streamelements > custom widget

### html

    <script src="https://xt.art.br/indica/overlay/"></script>

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

### data

    (não precisa alterar)