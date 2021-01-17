let token, command, phrase, font, username, id, row = []

window.addEventListener("onWidgetLoad", (obj) => {
    token = obj.detail.fieldData.token
    command = obj.detail.fieldData.command
    phrase = obj.detail.fieldData.phrase
    font = obj.detail.fieldData.font
    username = obj.detail.channel.username
    id = obj.detail.channel.id

    let link = document.createElement("link")
    link.type = "text/css"
    link.rel = "stylesheet"
    link.href = "https://fonts.googleapis.com/css?family=" + font.replace(" ", "+")
    document.head.appendChild(link)
    // document.head.insertAdjacentHTML("beforeend", "<link rel=\"stylesheet\" href=\"https://fonts.googleapis.com/css?family=" + font.replace(" ", "+") + "\" />")
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