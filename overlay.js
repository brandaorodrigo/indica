let custom,
    overlay = [],
    empty = 1

function css_pre() /* custom */ {
    document.body.insertAdjacentHTML("beforeend", `
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=` + custom.font.replace(" ", "+") + `"/>
    <div id="container" class="container">
        <div class="images-group">
            <div id="image_logo_container" class="shine_box">
                <img id="image_logo"/>
            </div>
            <div id="image_game_container" class="shine_box">
                <img id="image_game"/>
            </div>
        </div>
        <div class="texts">
            <div id="name"></div>
            <div id="game"></div>
        </div>
    </div>`)
    document.querySelector("body").style.fontFamily = custom.font
    if (document.querySelector(".images-group")) {
        document.querySelector(".images-group").style.borderColor = custom.border_color_line
    }
    if (document.querySelector("#image_logo_container")) {
        document.querySelector("#image_logo_container").style.borderRadius = custom.border_radius + "%"
        document.querySelector("#image_logo_container").style.borderColor = custom.border_color_user
    }
    if (document.querySelector("#image_game_container")) {
        if (custom.border_radius > 25) {
            document.querySelector("#image_game_container").style.height = "105px"
            document.querySelector("#image_game_container").style.objectFit = "cover"
        }
        document.querySelector("#image_game_container").style.borderRadius = custom.border_radius + "%"
        document.querySelector("#image_game_container").style.borderColor = custom.border_color_game
    }
    if (document.querySelector("#name")) {
        document.querySelector("body").style.fontFamily = custom.font
        document.querySelector("#name").style.color = custom.font_color_user
        document.querySelector("#name").style.textShadow = "-2px 2px 4px " + custom.shadow_color
        let check_font_user = custom.font_style_user.split("_")
        if (typeof check_font_user[1] !== "undefined") {
            document.querySelector("#name").style.fontWeight = custom.check_font_user[0]
            document.querySelector("#name").style.fontStyle = custom.check_font_user[1]
        } else {
            document.querySelector("#name").style.fontWeight = custom.font_style_user
        }
    }
    if (document.querySelector("#game")) {
        document.querySelector("body").style.fontFamily = custom.font
        document.querySelector("#game").style.color = custom.font_color_game
        document.querySelector("#game").style.textShadow = "-2px 2px 4px " + custom.shadow_color
        let check_font_game = custom.font_style_game.split("_")
        if (typeof check_font_game[1] !== "undefined") {
            document.querySelector("#game").style.fontWeight = custom.check_font_game[0]
            document.querySelector("#game").style.fontStyle = custom.check_font_game[1]
        } else {
            document.querySelector("#game").style.fontWeight = custom.font_style_game
        }
    }
}

function css_pos() {
    let name = document.querySelector("#name"),
        name_font_size
    if (name.textContent.length < 8) {
        name_font_size = "40px"
    } else if (name.textContent.length < 12) {
        name_font_size = "28px"
    } else if (name.textContent.length < 16) {
        name_font_size = "20px"
    } else if (name.textContent.length < 21) {
        name_font_size = "15px"
    } else if (name.textContent.length < 27) {
        name_font_size = "12px"
    } else if (name.textContent.length < 36) {
        name_font_size = "9px"
    } else if (name.textContent.length > 35) {
        name_font_size = "8px"
    }
    name.style.fontSize = name_font_size
    let game = document.getElementById("game"),
        game_font_size
    if (game.textContent.length < 21) {
        game_font_size = "22px"
    } else if (game.textContent.length < 25) {
        game_font_size = "17px"
    } else if (game.textContent.length < 31) {
        game_font_size = "15px"
    } else if (game.textContent.length > 30) {
        game_font_size = "12px"
    }
    game.style.fontSize = game_font_size
}

function flow() /* overlay, empty */ {
    if (empty && overlay.length) {
        empty = 0
        let current = overlay.shift()
        show(current)
        setTimeout(() => {
            empty = 1
            flow()
        }, 17000)
    }
}

function show(current) {
    Object.keys(current).forEach((key) => {
        if (document.querySelector("#" + key)) {
            if (key.substring(0, 5) == "image") {
                document.querySelector("#" + key).setAttribute("src", current[key])
            } else {
                document.querySelector("#" + key).innerHTML = current[key]
            }
        }
    })
    css_pos()
    let container = document.querySelector("#container")
    setTimeout(() => {
        add_css_class(container, "active")
        setTimeout(() => {
            remove_css_class(container, "active")
        }, 15000)
    }, 666)
}

function add_css_class(element, classname) {
    if (element.classList) {
        element.classList.add(classname)
    } else {
        element.className += " " + classname
    }
}

function remove_css_class(element, classname) {
    if (element.classList) {
        element.classList.remove(classname)
    } else {
        classname = classname.split(" ").join("|")
        let reg = new RegExp("(^|\\b)" + classname + "(\\b|$)", "gi")
        element.className = element.className.replace(reg, " ")
    }
}

/* listeners */

window.addEventListener("onWidgetLoad", function(obj) {
    custom = obj.detail.fieldData
    custom.command = custom.command ? custom.command : SE_API.setField("command", "!indica")
    custom.font = custom.font ? custom.font : SE_API.setField("font", "Roboto")
    custom.font_style_user = custom.font_style_user ? custom.font_style_user : SE_API.setField("font_style_user", "700")
    custom.font_color_user = custom.font_color_user ? custom.font_color_user : SE_API.setField("font_color_user", "#ffffff")
    custom.font_style_game = custom.font_style_game ? custom.font_style_game : SE_API.setField("font_style_game", "400")
    custom.font_color_game = custom.font_color_game ? custom.font_color_game : SE_API.setField("font_color_game", "#ffffff")
    custom.shadow_color = custom.shadow_color ? custom.shadow_color : SE_API.setField("shadow_color", "#888888")
    custom.border_radius = custom.border_radius ? custom.border_radius : SE_API.setField("border_radius", "0")
    custom.border_color_user = custom.border_color_user ? custom.border_color_user : SE_API.setField("border_color_user", "#ffffff")
    custom.border_color_game = custom.border_color_game ? custom.border_color_game : SE_API.setField("border_color_game", "#ffffff")
    custom.border_color_line = custom.border_color_line ? custom.border_color_line : SE_API.setField("border_color_line", "#ffffff")
    css_pre()
})

window.addEventListener("onEventReceived", function(obj) /* custom */ {
    if (obj.detail.event && obj.detail.listener === "message") {
        let caller = obj.detail.event.data.channel
        let word = obj.detail.event.data.text.split(" ")
        if (word[0] === custom.command && typeof word[1] !== "undefined") {
            let badges = obj.detail.event.data.tags.badges.replace(/\d+/g, "").replace(/,/g, "").split("/")
            if (badges.indexOf("moderator") != -1 || badges.indexOf("broadcaster") != -1) {
                fetch("https://xt.art.br/indica/api/" + word[1] + "/" + caller + "?" + Date.now())
                    .then(function(response) {
                        if (response.status != 200) {
                            throw new Error()
                        }
                        return response.json()
                    })
                    .then(function(response) {
                        overlay.push(response)
                        flow()
                    })
            }
        }
    }
})

/*

custom fields

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

*/