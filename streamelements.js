let command, phrase, token, username, id, font, row = []

window.addEventListener("onWidgetLoad", (obj) => {
    command = obj.detail.fieldData.command
    phrase = obj.detail.fieldData.phrase
    token = obj.detail.fieldData.token
    username = obj.detail.channel.username
    id = obj.detail.channel.id
    font = obj.detail.fieldData.font

    let link = document.createElement("link")
    link.title = "https://fonts.googleapis.com/css?family=" + font
    document.body.appendChild(link)
    document.querySelector("body").style.fontFamily = font
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

                    unmout()

                    setTimeout(() => {
                        unmout()
                    }, 10000)

                    Object.keys(response).forEach((key) => {
                        feed(key, response[key])
                    })
                    document.querySelector("#container").style.display = "block"

                })

            }

        }

    }

})