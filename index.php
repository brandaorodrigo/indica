<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>
        <meta property='og:title' content='!indica'/>
        <meta property='og:image' content='https://xt.art.br/indica/favicon.png'/>
        <meta property='og:description' content='!indica é uma ferramenta totalmente customizável e de código aberto para você poder indicar seus amigos streamers.'/>
        <title>!indica | seu canal, sua indentidade</title>
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link rel="icon" href="favicon.png" sizes="16x16" type="image/x-icon"/>
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@100;300;400;700&family=Ubuntu:wght@300;400;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="style.css"/>
    </head>
    <body>

        <div class="video">
            <div class="logo">!i</div>
        </div>

        <div class="tutorial">
            <div class="padding">

                <a href="https://github.com/brandaorodrigo/indica">github</a>

                <h1><div>!i</div>ndica</h1>
                <h2>AGORA QUE VOCÊ JÁ NOS CONHECE UM <br>POUCO MAIS, QUE TAL EXPERIMENTARMOS?</h2>
                Vamos lá!<br>
                Para começar, escolha a frase que será exibida no seu chat quando você divulgar um streamer.<br><br>
                No campo abaixo, descreva a sua frase personalizada respeitando as variáveis <strong>&lt;name&gt;</strong>,
                <strong>&lt;game&gt;</strong>, <strong>&lt;url&gt;</strong>. Ou se preferir, pode utilizar o exemplo já aplicado.
                <input type="text" name="phrase" id="phrase" value="/me Conheça <name> que estava jogando <game>. Acesse <url>">

                Depois de personalizar a sua frase no campo acima, o comando para o seu bot será gerado logo abaixo.<br>
                Escolha e copie o comando de acordo com o bot que você utiliza em seu canal.

                <h3>STREAMELEMENTS</h3>
                <section id="streamelements" class="copy">
                    /me Conheça ${user ${1}} que estava jogando ${game ${1}}. Acesse https://twitch.tv/${user.name ${1}}
                </section>

                <h3>STREAMLABS | CLOUDBOT</h3>
                <section id="streamlabs_cloudbot" class="copy">
                /me Conheça {touser.name} que estava jogando {touser.game}. Acesse https://twitch.tv/{touser.name}
                </section>

                <h3>STREAMLABS | CHATBOT</h3>
                <section id="streamlabs_chatbot" class="copy">
                /me Conheça $touser que estava jogando $game. Acesse https://twitch.tv/$touser
                </section>


                <h3>NIGHTBOT</h3>
                <section id="nightbot" class="copy">
                /me Conheça $(twitch $(touser) "{{displayName}}") que estava jogando $(twitch $(touser) "{{game}}"). Acesse https://twitch.tv/$(twitch $(touser) "{{name}}")
                </section>

                <!--
                <label>MIX IT UP</label>
                <section id="mixitup" class="copy">
                /me Conheça $arg1username que estava jogando $arg1userstreamgame. Acesse https://twitch.tv/$arg1username
                </section>

                <label>FIREBOT</label>
                <section id="firebot" class="copy">
                /me Conheça $target que estava jogando $game[$target]. Acesse https://twitch.tv/$target
                </section>
                -->

                <h2>OVERLAY PARA STREAMELEMENTS (CRIE UM CUSTOM WIDGET E CLIQUE EM OPEN EDITOR)</h2>

                <h3>HTML</h3>
                <section id="html" class="copy">
                    &lt;link href="https://xt.art.br/indica/overlay.css" rel="stylesheet"/&gt;<br>
                    &lt;script src="https://xt.art.br/indica/overlay.js"&gt;&lt;/script&gt;
                </section>

                <h3>CSS</h3>
                <section>
                    <span>(apagar tudo e deixar vazio)</span>
                </section>

                <h3>JS</h3>
                <section>
                    <span>(apagar tudo e deixar vazio)</span>
                </section>

                <h3>FIELDS</h3>
                <section id="fields" class="copy">
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

                <h3>DATA</h3>
                <section><span>(não precisa alterar)</span></section>

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
                "streamlabs_cloudbot": {
                    "name": "{touser.name}",
                    "game": "{touser.game}",
                    "url": "https://twitch.tv/{touser.name}"
                },
                "streamlabs_chatbot": {
                    "name": "$touser",
                    "game": "$game",
                    "url": "https://twitch.tv/$touser"
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

            /*Copy Command and Alert*/
            document.addEventListener('click', function(e) {
                e = e || window.event;
                var target = e.target;
                if(target.className == "copy"){
                    copyToClipboard(target.id);
                    document.getElementById("alert-copy").style.display = "block";
                    setTimeout(function(){
                        document.getElementById("alert-copy").style.display = "none";
                    }, 1500);
                }
            }, false);

            function copyToClipboard(e) {
                var range = document.createRange();
                range.selectNode(document.getElementById(e));
                window.getSelection().removeAllRanges();
                window.getSelection().addRange(range);
                document.execCommand("copy");
                window.getSelection().removeAllRanges();
            }

        </script>
    </body>
</html>