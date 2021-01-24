<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>
        <!--
        <meta property='og:title' content='!indica'/>
        <meta property='og:image' content='http://spotmetrics.com/retrospectiva/share.jpg'/>
        <meta property='og:description' content='Olha só o tamanho da nossa Promoção de Natal 2020'/>
        -->
        <title>!indica | recomende seus amigos streamers</title>
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Ubuntu" rel="stylesheet">
        <link rel="icon" href="favicon.png" sizes="16x16" type="image/x-icon">
        <style>
            ::-moz-selection { /* Code for Firefox */
                color: #fff;
                background: #111111;
            }
            ::selection {
                color: #fff;
                background: #111111;
            }
            select {
                -webkit-appearance: none;
                -moz-appearance: none;
                appearance: none;
                padding-top: -5px !important;
                margin: 0 !important;
                float: left;
            }
            * {
                font-family: "Ubuntu" !important;
                font-weight: 300;
            }
            body {
                background: #fff;
                margin: 0;
                color: #333;
                font-size:18px;
                padding: 0;
                font-weight: 300;
            }
            .video {
                position: fixed;
                height: 100vh;
                width: 160px;
                left: 0;
                top: 0;
                background: #222;
            }
            .video .logo {
                background:#444;
                color:#fff;
                display:block;
                font-family: "Ubuntu" !important;
                font-weight: 700 !important;
                width:100px;
                border-radius:10%;
                text-align:center;
                height:100px;
                line-height:100px;
                font-size:90px;
                margin:30px;
            }
            .tutorial {
                width: calc(100vw - 160px);
                right: 0;
                min-height: 100vh;
                position: absolute;
                top: 0;
            }
            .tutorial .padding {
                padding: 40px 40px 60px 60px;
            }
            input {
                padding: 22px 24px;
                width: calc(100% - 50px);
                font-size: 16px;
                background: #eee;
                font-family: "Roboto Mono";
                font-weight:100 !important;
                color: #222;
                border: 1px solid #ddd;
                line-height: 18px !important;
                border-radius: 4px;
                margin:0;
            }
            label {
                margin: 30px 0 10px 0;
                display: block;
                font-size: #222;
            }

            section {
                background: #222;
                font-size: 17px;
                border: 1px solid #444;
                padding: 25px;
                display:block;
                font-family: "Roboto Mono";
                color: #ccc;
                font-weight: 100;
                line-height: 32px;
                border-radius: 4px;
                margin:0;
            }
            section span {
                color: #777;
                font-style: italic
            }
            h2 {
                margin:40px 0 20px 0;
                display:block;
            }
            h1 {
                font-weight:700;
            }





            .logo {
	-webkit-animation: color_change 12s infinite alternate;
	-moz-animation: color_change 12s infinite alternate;
	-ms-animation: color_change 12s infinite alternate;
	-o-animation: color_change 12s infinite alternate;
	animation: color_change 12s infinite alternate;
}

@-webkit-keyframes color_change {
	from { background-color: #f32323; }
	to { background-color: #31e2aa; }
}
@-moz-keyframes color_change {
	from { background-color: #f32323; }
	to { background-color: #31e2aa; }
}
@-ms-keyframes color_change {
	from { background-color: #f32323; }
	to { background-color: #31e2aa; }
}
@-o-keyframes color_change {
	from { background-color: #f32323; }
	to { background-color: #31e2aa; }
}
@keyframes color_change {
	from { background-color: #f32323; }
	to { background-color: #31e2aa; }
}



        </style>
    </head>
    <body>

        <div class="video">
            <div class="logo">!i</div>
        </div>

        <div class="tutorial">
            <div class="padding">

                <h1 style="margin-top:0">!indica</h1>

                <h2>CONFIGURAÇÕES</h2>

                <label>Escreva aqui a sua frase (variáveis: &lt;name&gt;, &lt;game&gt;, &lt;url&gt;)</label>
                <input type="text" name="phrase" id="phrase" value="/me Conheça <name> que estava jogando <game>. Acesse <url>">

                <h2>COMANDO</h2>

                <label>STREAMELEMENTS</label>
                <section id="streamelements">
                /me Conheça ${user ${1}} que estava jogando ${game ${1}}. Acesse https://twitch.tv/${user.name ${1}}
                </section>

                <label>STREAMLABS</label>
                <section id="streamlabs">
                /me Conheça {touser.name} que estava jogando {touser.game}. Acesse https://twitch.tv/{touser.name}
                </section>


                <label>NIGHTBOT</label>
                <section id="nightbot">
                /me Conheça $(twitch $(touser) "{{displayName}}") que estava jogando $(twitch $(touser) "{{game}}"). Acesse https://twitch.tv/$(twitch $(touser) "{{name}}")
                </section>

                <label>MIX IT UP</label>
                <section id="mixitup">
                /me Conheça $arg1username que estava jogando $arg1userstreamgame. Acesse https://twitch.tv/$arg1username
                </section>

                <label>FIREBOT</label>
                <section id="firebot">
                /me Conheça $target que estava jogando $game[$target]. Acesse https://twitch.tv/$target
                </section>

                <h2>OVERLAY PARA STREAMELEMENTS (CRIE UM CUSTOM WIDGET E CLIQUE EM OPEN EDITOR)</h2>

                <label>HTML</label>
                <section>
                    &lt;link href="https://xt.art.br/indica/overlay.css" rel="stylesheet"/&gt;
                    &lt;script src="https://xt.art.br/indica/overlay.js"&gt;&lt;/script&gt;
                </section>

                <label>CSS</label>
                <section>
                    <span>(APAGAR TUDO E DEIXAR VAZIO)</span>
                </section>

                <label>JS</label>
                <section>
                    <span>(APAGAR TUDO E DEIXAR VAZIO)</span>
                </section>

                <label>FIELDS</label>
                <section>
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
                </section>

                <label>DATA</label>
                <section><span>(NÃO PRECISA MEXER)</span></section>

            </div>
        </div>
        <script>

            /*
            function player_aspect() {
                let height = document.querySelector(".video").offsetHeight
                let width = height * 0.5625
                document.querySelector(".video").style.width = width + "px"
                document.querySelector(".tutorial").style.width = "calc(100vw - " + width + "px)"
            }

            window.addEventListener("resize", function(event) {
                player_aspect()
            })

            player_aspect()
            */

            let bot = {
                "streamelements": {
                    "name": "${user ${1}}",
                    "game": "${game ${1}}",
                    "url": "https://twitch.tv/${user.name ${1}}"
                },
                "streamlabs": {
                    "name": "{touser.name}",
                    "game": "{touser.game}",
                    "url": "https://twitch.tv/{touser.name}"
                },
                "nightbot": {
                    "name": '$(twitch $(touser) "{{displayName}}")',
                    "game": '$(twitch $(touser) "{{game}}")',
                    "url": 'https://twitch.tv/$(twitch $(touser) "{{name}}")'
                },
                "firebot": {
                    "name": '$target',
                    "game": '$game[$target]',
                    "url": 'https://twitch.tv/$target'
                },
                "mixitup" : {
                    "name": '$arg1username',
                    "game": '$arg1userstreamgame',
                    "url": 'https://twitch.tv/$arg1username'
                }
            }

            function update() {
                let message = document.querySelector("#phrase").value
                Object.keys(bot).forEach(function(b) {
                    let current = message
                    Object.keys(bot[b]).forEach(function(key) {
                        current = current.replaceAll("<" + key + ">", bot[b][key])
                    })
                    if (document.querySelector("#" + b)) {
                        document.querySelector("#" + b).innerHTML = current
                    }
                })
            }

            document.querySelector("#phrase").addEventListener("keyup", function () {
                if (!document.querySelector("#phrase").value) {
                    document.querySelector("#phrase").value = "/me Conheça <name> que estava jogando <game>. Acesse <url>"
                }
                update()
            })

        </script>
    </body>
</html>