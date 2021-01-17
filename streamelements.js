let token, command, phrase, bordersProfile, bordersGame, profileBorderColor, gameBorderColor, font, nameFontStyle, gameFontStyle, nameFontColor, gameFontColor, username, id, row = []

window.addEventListener("onWidgetLoad", (obj) => {
    token = obj.detail.fieldData.token
    command = obj.detail.fieldData.command
    phrase = obj.detail.fieldData.phrase
    bordersProfile = obj.detail.fieldData.bordersProfile
    bordersGame = obj.detail.fieldData.bordersGame
    profileBorderColor = obj.detail.fieldData.profileBorderColor
    gameBorderColor = obj.detail.fieldData.gameBorderColor
    font = obj.detail.fieldData.font
    nameFontStyle = obj.detail.fieldData.nameFontStyle
    gameFontStyle = obj.detail.fieldData.gameFontStyle
    nameFontColor = obj.detail.fieldData.nameFontColor
    gameFontColor = obj.detail.fieldData.gameFontColor
    username = obj.detail.channel.username
    id = obj.detail.channel.id

    let link = document.createElement("link")
    link.type = "text/css"
    link.rel = "stylesheet"
    link.href = "https://fonts.googleapis.com/css?family=" + font.replace(" ", "+")
    document.head.appendChild(link)
    // document.head.insertAdjacentHTML("beforeend", "<link rel=\"stylesheet\" href=\"https://fonts.googleapis.com/css?family=" + font.replace(" ", "+") + "\" />")
    document.querySelector("body").style.fontFamily = font
  
    document.getElementById("image_logo").style.borderRadius = bordersProfile+"%"
    if(bordersGame > 25){
    document.getElementById("image_game").style.height = "105px"
    document.getElementById("image_game").style.objectFit = "cover";
  }
    document.getElementById("image_game").style.borderRadius = bordersGame+"%"

    document.getElementById("image_logo").style.borderColor = profileBorderColor
    document.getElementById("image_game").style.borderColor = gameBorderColor

    checkFont = nameFontStyle.split("_");
    if(typeof checkFont[1] !== "undefined"){
        document.getElementById("name").style.fontWeight = checkFont[0];
        document.getElementById("name").style.fontStyle = checkFont[1];
    }
    else{
        document.getElementById("name").style.fontWeight = nameFontStyle;
    }
        checkFont = gameFontStyle.split("_");
        if(typeof checkFont[1] !== "undefined"){
        document.getElementById("game").style.fontWeight = checkFont[0];
        document.getElementById("game").style.fontStyle = checkFont[1];
    }
    else{
        document.getElementById("game").style.fontWeight = gameFontStyle;
    }
    document.getElementById("name").style.color = nameFontColor;
    document.getElementById("game").style.color = gameFontColor;
})

window.addEventListener("onEventReceived", (obj) => {

    if (obj.detail.event && obj.detail.listener === "message") {

        let word = obj.detail.event.data.text.split(" ")
        if (word[0] === command && typeof word[1] !== "undefined") {

            let badges = obj.detail.event.data.tags.badges.replace(/\d+/g, "").replace(/,/g, "").split("/")
            if (badges.indexOf("moderator") != -1 || badges.indexOf("broadcaster") != -1) {

                fetch("https://xt.art.br/twitch/" + word[1] + "/" + username)
                .then(response => response.json())
                .then((response) => {

                    let message = phrase
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

                    const feed = (key, value) => {
                        if (document.querySelector("#" + key)) {
                            if (key.substring(0, 5) == "image") {
                                document.querySelector("#" + key).setAttribute("src", value)
                            } else {
                                document.querySelector("#" + key).innerHTML = value
                            }
                        }
                    }

                    const unmout = (response) => {
                        document.querySelector("#container").style.display = "none"
                        Object.keys(response).forEach((key) => {
                            feed(key, "")
                        })
                    }

                    unmout(response)

                    setTimeout(() => {
                        unmout(response)
                    }, 25000)

                    Object.keys(response).forEach((key) => {
                        feed(key, response[key])
                    })
                    document.querySelector("#container").style.display = "block"

                })

            }

        }

    }

})