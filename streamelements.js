let id, username,
    token, command, phrase, phrase_game, phrase_raid,
    border_radius, border_color_logo, border_color_game,
    font, font_style_user, font_color_user, font_style_game, font_color_game,
    empty = 1, overlay = []

window.addEventListener("onWidgetLoad", (obj) => {

    // load html + css

    document.head.insertAdjacentHTML("beforeend", "<link rel=\"stylesheet\" href=\"https://xt.art.br/twitch/streamelements.css\" />")
    document.body.insertAdjacentHTML("beforeend", "<div id=\"container\" class=\"container\"><div class=\"images-group\"><img id=\"image_logo\"/><img id=\"image_game\"/></div><div class=\"texts\"><div id=\"name\"></div><div id=\"game\"></div></div></div>")

    // native fields

    id = obj.detail.channel.id
    username = obj.detail.channel.username

    // custom fields

    token = obj.detail.fieldData.token ? obj.detail.fieldData.token : null

    command = obj.detail.fieldData.command ? obj.detail.fieldData.command : SE_API.setField("command", "!indicar")
    phrase = obj.detail.fieldData.phrase ? obj.detail.fieldData.phrase : SE_API.setField("phrase", "/me Conheça <user> que estava jogando <game>. Acesse <twitch>")
    phrase_game = obj.detail.fieldData.phrase_game ? obj.detail.fieldData.phrase_game : SE_API.setField("phrase_game", "/me Conheça <name> que não estava jogando. Acesse <url>") // TODO = PENSAR SE ISSO É IMPORTANTE
    phrase_raid = obj.detail.fieldData.phrase_raid ? obj.detail.fieldData.phrase_raid : SE_API.setField("phrase_raid", "/me Conheça <user> que estava jogando <game>. Acesse <twitch>") // TODO = PENSAR SE ISSO É IMPORTANTE

    border_radius = obj.detail.fieldData.border_radius ? obj.detail.fieldData.border_radius : 0
    border_color_user = obj.detail.fieldData.border_color_user ? obj.detail.fieldData.border_color_user : "#ffffff"
    border_color_game = obj.detail.fieldData.border_color_game ? obj.detail.fieldData.border_color_game : "#ffffff"

    font = obj.detail.fieldData.font ? obj.detail.fieldData.font : "Roboto" // TODO = QUAL VAI SER A FONTE PADRAO ?
    font_style_user = obj.detail.fieldData.font_style_user ? obj.detail.fieldData.font_style_user : "700"
    font_color_user = obj.detail.fieldData.font_color_user ? obj.detail.fieldData.font_color_user : "#ffffff"
    font_style_game = obj.detail.fieldData.font_style_game ? obj.detail.fieldData.font_style_game : "400"
    font_color_game = obj.detail.fieldData.font_color_game ? obj.detail.fieldData.font_color_game : "#ffffff"

    // check

    if (!token) {
        document.body.insertAdjacentHTML("beforeend", "<div style=\"position:absolute;left:0;top:0;width:100vw;height:100vh;z-index:9999;background:#f00;\">CADASTRE O JWT TOKEN</div>") // TODO = CRIAR HTML QUE EXPLICA O QUE FAZER NO JWT TOKEN
    }

    document.head.insertAdjacentHTML("beforeend", "<link rel=\"stylesheet\" href=\"https://fonts.googleapis.com/css?family=" + font.replace(" ", "+") + "\" />")
    document.querySelector("body").style.fontFamily = font

    if (document.querySelector("#image_logo")) {
        document.querySelector("#image_logo").style.borderRadius = border_radius + "%"
        document.querySelector("#image_logo").style.borderColor = border_color_user
    }

    if (document.querySelector("#image_game")) {
        if (border_radius > 25) {
            document.querySelector("#image_game").style.height = "105px"
            document.querySelector("#image_game").style.objectFit = "cover"
        }
        document.querySelector("#image_game").style.borderRadius = border_radius + "%"
        document.querySelector("#image_game").style.borderColor = border_color_game
    }

    if (document.querySelector("#name")) {
        document.querySelector("#name").style.color = font_color_user
        let check_font_user = font_style_user.split("_")
        if (typeof check_font_user[1] !== "undefined") {
            document.querySelector("#name").style.fontWeight = check_font_user[0]
            document.querySelector("#name").style.fontStyle = check_font_user[1]
        } else {
            document.querySelector("#name").style.fontWeight = font_style_user
        }
    }

    if (document.querySelector("#game")) {
        document.querySelector("#game").style.color = font_color_game
        let check_font_game = font_style_game.split("_")
        if (typeof check_font_game[1] !== "undefined") {
            document.querySelector("#game").style.fontWeight = check_font_game[0]
            document.querySelector("#game").style.fontStyle = check_font_game[1]
        } else {
            document.querySelector("#game").style.fontWeight = font_style_game
        }
    }

})

window.addEventListener("onEventReceived", (obj) => {
    if (obj.detail.event && obj.detail.listener === "message") {
        let word = obj.detail.event.data.text.split(" ")
        if (word[0] === command && typeof word[1] !== "undefined") {
            let badges = obj.detail.event.data.tags.badges.replace(/\d+/g, "").replace(/,/g, "").split("/")
            if (badges.indexOf("moderator") != -1 || badges.indexOf("broadcaster") != -1) {
                fetch("https://xt.art.br/twitch/" + word[1] + "/" + username)
                .then((response) => {
                    if (response.status != 200)
                        throw new Error()
                    return response.json()
                })
                .then((response) => {
                    let message = phrase
                    if (!response.game) {
                        message = phrase_game
                    }
                    say(message, response)
                    overlay.push(response)
                    flow()
                })
            }
        }
    }
     // TODO = VERIFICAR SE É RAID E SE O PARAMETRO SE QUER ALERTAR RAID ESTA ATIVADO
})

const say = (message, response) => {
    Object.keys(response).forEach((key) => {
        message = message.replaceAll("<" + key + ">", response[key])
    })
    fetch("https://api.streamelements.com/kappa/v2/bot/" + id + "/say", {
        "method": "POST",
        "headers": {
            "Accept": "application/json",
            "Content-Type": "application/json",
            "Authorization": "Bearer " + token
        },
        "body": JSON.stringify({ "message": message })
    })
}

const flow = () => {
    if (empty && overlay.length) {
        empty = 0
        let current = overlay.shift()
        show(current)
        setTimeout(() => {
            empty = 1
            flow()
        }, 22000)
    }
}

const show = (current) => {
    Object.keys(current).forEach((key) => {
        if (document.querySelector("#" + key)) {
            if (key.substring(0, 5) == "image") {
                document.querySelector("#" + key).setAttribute("src", current[key])
            } else {
                document.querySelector("#" + key).innerHTML = current[key]
            }
        }
    })
    setTimeout(() => {
        document.querySelector("#container").classList.add("active")
        setTimeout(() => {
            document.querySelector("#container").classList.remove("active")
        }, 20000)
    }, 1000)
}