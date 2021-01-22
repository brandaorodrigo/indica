let id, token, command, phrase, raid, overlay = [], empty = 1

window.addEventListener("onWidgetLoad", function (obj) {
    let data = obj.detail.fieldData
    // chat
    id = obj.detail.channel.id
    token = data.token ? data.token : null
    command = data.command ? data.command : SE_API.setField("command", "!cu")
    phrase = data.phrase ? data.phrase : SE_API.setField("phrase", "/me Conheça <name> que estava jogando <game>. Acesse <url>")
    raid = data.raid ? data.raid : 0
    // overlay
    document.body.insertAdjacentHTML("beforeend", `<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=` + data.font.replace(" ", "+") + `"/>`)
    document.body.insertAdjacentHTML("beforeend", `<link rel="stylesheet" href="https://xt.art.br/twitch/streamelements.css"/>`)
    if (!token) {
        document.body.insertAdjacentHTML("beforeend", `
        <div style="position:absolute;left:0;top:0;width:100vw;height:100vh;z-index:9999;background:#ff0;">
            CADASTRE O JWT TOKEN
        </div>`)
    } else {
        data.border_radius = data.border_radius ? data.border_radius : 0
        data.border_color_user = data.border_color_user ? data.border_color_user : "#f2f2f2"
        data.border_color_game = data.border_color_game ? data.border_color_game : "#f2f2f2"
        data.font = data.font ? data.font : "Roboto"
        data.font_style_user = data.font_style_user ? data.font_style_user : "700"
        data.font_color_user = data.font_color_user ? data.font_color_user : "#f2f2f2"
        data.font_style_game = data.font_style_game ? data.font_style_game : "400"
        data.font_color_game = data.font_color_game ? data.font_color_game : "#f2f2f2"
        // html + css
        document.body.insertAdjacentHTML("beforeend", `
        <div id="container" class="container">
            <div class="images-group">
                <img id="image_logo"/>
                <img id="image_game"/>
            </div>
            <div class="texts">
                <div id="name"></div>
                <div id="game"></div>
            </div>
        </div>`)
        document.querySelector("body").style.fontFamily = data.font
        if (document.querySelector("#image_logo")) {
            document.querySelector("#image_logo").style.borderRadius = data.border_radius + "%"
            document.querySelector("#image_logo").style.borderColor = data.border_color_user
        }
        if (document.querySelector("#image_game")) {
            if (data.border_radius > 25) {
                document.querySelector("#image_game").style.height = "105px"
                document.querySelector("#image_game").style.objectFit = "cover"
            }
            document.querySelector("#image_game").style.borderRadius = data.border_radius + "%"
            document.querySelector("#image_game").style.borderColor = data.border_color_game
        }
        if (document.querySelector("#name")) {
            document.querySelector("body").style.fontFamily = data.font
            document.querySelector("#name").style.color = data.font_color_user
            let check_font_user = data.font_style_user.split("_")
            if (typeof check_font_user[1] !== "undefined") {
                document.querySelector("#name").style.fontWeight = data.check_font_user[0]
                document.querySelector("#name").style.fontStyle = data.check_font_user[1]
            } else {
                document.querySelector("#name").style.fontWeight = data.font_style_user
            }
        }
        if (document.querySelector("#game")) {
            document.querySelector("body").style.fontFamily = data.font
            document.querySelector("#game").style.color = data.font_color_game
            let check_font_game = data.font_style_game.split("_")
            if (typeof check_font_game[1] !== "undefined") {
                document.querySelector("#game").style.fontWeight = data.check_font_game[0]
                document.querySelector("#game").style.fontStyle = data.check_font_game[1]
            } else {
                document.querySelector("#game").style.fontWeight = data.font_style_game
            }
        }
    }
})

window.addEventListener("onEventReceived", function (obj) {
    if (obj.detail.event) {
        let caller = obj.detail.event.data.channel
        if (obj.detail.listener === "message") {
            let word = obj.detail.event.data.text.split(" ")
            if (word[0] === command && typeof word[1] !== "undefined") {
                let badges = obj.detail.event.data.tags.badges.replace(/\d+/g, "").replace(/,/g, "").split("/")
                if (badges.indexOf("moderator") != -1 || badges.indexOf("broadcaster") != -1) {
                    run(word[1], caller)
                }
            }
        }
        if (obj.detail.listener === "raid-latest" && raid) {
            run(obj.detail.event.data.name, caller)
        }
    }
})

function run(channel, caller) {
    fetch("https://xt.art.br/twitch/" + channel + "/" + caller + "?v=" + Date.now())
    .then(function(response) {
        if (response.status != 200) {
            throw new Error()
        }
        return response.json()
    })
    .then(function(response) {
        overlay.push(response)
        flow()
        let message = phrase
        Object.keys(response).forEach(function(key) {
            message = message.replace("<" + key + ">", response[key])
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
    })
}

function resizeFont(){
	var nameElement = document.getElementById("name"),
        gameElement = document.getElementById("game"),
        namefontSize = "",
        gamefontSize = "";
    /*Channel Name*/
    if(nameElement.textContent.length < 8){namefontSize = "40px";}
    else if(nameElement.textContent.length < 12){namefontSize = "28px";}
    else if(nameElement.textContent.length < 16){namefontSize = "20px";}
    else if(nameElement.textContent.length < 21){namefontSize = "15px";}
    else if(nameElement.textContent.length < 27){namefontSize = "12px";}
    else if(nameElement.textContent.length < 36){namefontSize = "9px";}
    else if(nameElement.textContent.length > 35){namefontSize = "8px";}
    nameElement.style.fontSize = namefontSize;
    /*Game Name*/
    if(gameElement.textContent.length < 21){gamefontSize = "22px";}
    else if(gameElement.textContent.length < 25){gamefontSize = "17px";}
    else if(gameElement.textContent.length < 31){gamefontSize = "15px";}
    else if(gameElement.textContent.length > 30){gamefontSize = "12px";}
    gameElement.style.fontSize = gamefontSize;
}

function flow() /* overlay, empty */ {
    if (empty && overlay.length) {
        empty = 0
        let current = overlay.shift()
        show(current)
        resizeFont()
        setTimeout(() => {
            empty = 1
            flow()
        }, 20000)
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
    let container = document.querySelector("#container")
    setTimeout(() => {
        addCssClass(container, "active")
        setTimeout(() => {
            removeCssClass(container, "active")
        }, 15000)
    }, 1000)
}

function addCssClass(element, classname) {
    if (element.classList) {
        element.classList.add(classname)
    } else {
        element.className += " " + classname
    }
}

function removeCssClass(element, classname) {
    if (element.classList) {
        element.classList.remove(classname)
    } else {
        classname = classname.split(" ").join("|")
        let reg = new RegExp("(^|\\b)" + classname + "(\\b|$)", "gi")
        element.className = element.className.replace(reg, " ")
    }
}
