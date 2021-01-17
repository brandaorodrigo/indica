let id,
    username,
    token,
    command,
    phrase,
    font,
    bordersProfile,
    bordersGame,
    profileBorderColor,
    gameBorderColor,
    nameFontStyle,
    gameFontStyle,
    nameFontColor,
    gameFontColor,
    empty = 1,
    overlay = []

window.addEventListener("onWidgetLoad", (obj) => {
    id = obj.detail.channel.id
    username = obj.detail.channel.username

    token = obj.detail.fieldData.token
    command = obj.detail.fieldData.command
    phrase = obj.detail.fieldData.phrase

    font = obj.detail.fieldData.font
    bordersProfile = obj.detail.fieldData.bordersProfile
    bordersGame = obj.detail.fieldData.bordersGame
    profileBorderColor = obj.detail.fieldData.profileBorderColor
    gameBorderColor = obj.detail.fieldData.gameBorderColor
    nameFontStyle = obj.detail.fieldData.nameFontStyle
    gameFontStyle = obj.detail.fieldData.gameFontStyle
    nameFontColor = obj.detail.fieldData.nameFontColor
    gameFontColor = obj.detail.fieldData.gameFontColor

    //let link = document.createElement("link")
    //link.type = "text/css"
    //link.rel = "stylesheet"
    //link.href = "https://fonts.googleapis.com/css?family=" + font.replace(" ", "+")
    //document.head.appendChild(link)
    document.head.insertAdjacentHTML("beforeend", "<link rel=\"stylesheet\" href=\"https://fonts.googleapis.com/css?family=" + font.replace(" ", "+") + "\" />")
    document.querySelector("body").style.fontFamily = font

    if (document.getElementById("image_logo")) {
        document.getElementById("image_logo").style.borderRadius = bordersProfile + "%"
        document.getElementById("image_logo").style.borderColor = profileBorderColor
    }
    if (document.getElementById("image_game")) {
        if (bordersGame > 25) {
            document.getElementById("image_game").style.height = "105px"
            document.getElementById("image_game").style.objectFit = "cover"
        }
        document.getElementById("image_game").style.borderRadius = bordersGame + "%"
        document.getElementById("image_game").style.borderColor = gameBorderColor
    }
    if (document.getElementById("name")) {
        checkFont = nameFontStyle.split("_")
        if (typeof checkFont[1] !== "undefined") {
            document.getElementById("name").style.fontWeight = checkFont[0]
            document.getElementById("name").style.fontStyle = checkFont[1]
        } else {
            document.getElementById("name").style.fontWeight = nameFontStyle
            document.getElementById("name").style.color = nameFontColor
        }
    }
    if (document.getElementById("game")) {
        checkFont = gameFontStyle.split("_")
        if (typeof checkFont[1] !== "undefined") {
            document.getElementById("game").style.fontWeight = checkFont[0]
            document.getElementById("game").style.fontStyle = checkFont[1]
        } else {
            document.getElementById("game").style.fontWeight = gameFontStyle
        }
        document.getElementById("game").style.color = gameFontColor;
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
                    if (response.game) {
                        message = '/me Conheça <name> que não estava jogando. Acesse <url>'
                    }
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
                    overlay.push(response)
                    flow()
                })
            }
        }
    }
})

const flow = () => {
    if (empty && overlay.length) {
        empty = 0
        let current = overlay.shift()
        show(current)
        setTimeout(() => {
            empty = 1
            flow()
        }, 24000)
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
    // TODO: AQUI IREMOS SETAR A CLASSE DE ANIMACAO E DEPOIS REMOVE-LA
    setTimeout(() => {
        document.querySelector("#container").style.display = "block"
        setTimeout(() => {
            document.querySelector("#container").style.display = "none"
        }, 20000)
    }, 2000)
}