/**
 *
 * https://github.com/brandaorodrigo/indica
 *
 */

let custom, overlay = [], empty = 1

const field = {
    'img_logo': {
        'type': 'image-input',
        'group': 'Foto',
        'label': 'Escolher Foto'
    },

    'img_logo_add': {
        'type': 'button',
        'label': 'Enviar foto',
        'group': 'Foto',
        'value': '1'
    },
    'img_logo_rmv': {
        'type': 'button',
        'label': 'Remover foto',
        'group': 'Foto',
        'value': '1'
    },
    'command': {
        'type': 'text',
        'label': 'Qual é seu comando personalizado?',
        'group': 'Comando',
        'value': '!indica'
    },
    'border_radius': {
        'type': 'dropdown',
        'label': 'Arredondamento',
        'group': 'Geral',
        'value': '0',
        'options': {
            '0': '0%',
            '5': '5%',
            '10': '10%',
            '30': '30%',
            '50': '50%'
        }
    },
    'font': {
        'type': 'googleFont',
        'label': 'Fonte',
        'group': 'Geral',
        'value': 'Valera'
    },
    'shadow_color': {
        'type': 'colorpicker',
        'label': 'Sombra',
        'group': 'Geral',
        'value': 'rgba(0,0,0,0.4)'
    },
    'border_color_line': {
        'type': 'colorpicker',
        'label': 'Cor da linha',
        'group': 'Geral',
        'value': '#f2f2f2'
    },
    'border_color_name': {
        'type': 'colorpicker',
        'label': 'Cor da borda',
        'group': 'Nome',
        'value': '#f2f2f2'
    },
    'font_color_name': {
        'type': 'colorpicker',
        'label': 'Cor da fonte',
        'group': 'Nome',
        'value': '#f2f2f2'
    },
    'font_weight_name': {
        'type': 'dropdown',
        'label': 'Estilo da fonte',
        'group': 'Nome',
        'value': '400',
        'options': {
            '400': 'Normal',
            '700': 'Negrito',
            '900': 'Black'
        }
    },
    'font_style_name': {
        'type': 'dropdown',
        'label': 'Itálico',
        'group': 'Nome',
        'value': 'normal',
        'options': {
            'normal': 'Não',
            'italic': 'Sim'
        }
    },
    'border_color_game': {
        'type': 'colorpicker',
        'label': 'Cor da borda',
        'group': 'Jogo',
        'value': '#f2f2f2'
    },
    'font_color_game': {
        'type': 'colorpicker',
        'label': 'Cor da fonte',
        'group': 'Jogo',
        'value': '#f2f2f2'
    },
    'font_weight_game': {
        'type': 'dropdown',
        'label': 'Estilo da fonte',
        'group': 'Jogo',
        'value': '400',
        'options': {
            '400': 'Normal',
            '700': 'Negrito',
            '900': 'Black'
        }
    },
    'font_style_game': {
        'type': 'dropdown',
        'label': 'Itálico',
        'group': 'Jogo',
        'value': 'normal',
        'options': {
            'normal': 'Não',
            'italic': 'Sim'
        }
    }
}

const render = () => /* custom */ {
    let html = `
    <style>
        * {
            transform-style: preserve-3d;
        }
        body {
            overflow: hidden;
            background: transparent;
            padding: 0px;
            margin: 0px;
        }
        .container {
            left: 6px;
            top: 6px;
            position: relative;
            max-width: 335px;
            min-height: 365px;
            overflow: hidden;
            display: none;
            transition: 2s ease-in-out;
        }
        .container .images-group {
            border-left: 4px solid #f2f2f2;
            position: relative;
            padding: 0px 0px 0px 10px;
            max-height: 268px;
        }
        .container .images-group #image_logo_container {
            border: 4px solid #f2f2f2;
            border-radius: 0%;
            width: 100%;
            max-width: 260px;
            height: 260px;
            overflow: hidden;
        }
        .container .images-group #image_game_container {
            height: 140px;
            border: 4px solid #f2f2f2;
            border-radius: 0%;
            object-fit: cover;
            width: 100%;
            max-width: 105px;
            position: absolute;
            bottom: 14px;
            right: 0px;
            overflow: hidden;
        }
        .container #image_logo,
        .container #image_game {
            width: 100%;
            height: 100%;
            object-fit: cover;
            vertical-align: middle;
            background: #0e0e10;
        }
        .container .texts {
            font-family: 'Varela', sans-serif;
            text-transform: uppercase;
            padding: 10px 0 0 0;
            min-height: 85px;
            height: auto;
        }
        .container .texts #name, .container .texts #game  {
            text-shadow: -2px 2px 4px rgba(0,0,0,0.5);
        }
        .container .texts #name {
            color: #f2f2f2;
            font-weight: 700;
            font-style: normal;
            opacity: 0;
            width: 100%;
            text-align: right;
            font-size: 40px;
        }
        .container .texts #game {
            color: #f2f2f2;
            font-weight: 400;
            font-style: normal;
            opacity: 0;
            font-weight: 700;
            width: 100%;
            text-align: right;
            font-size: 22px;
        }
        .container.active {
            display: block;
        }
        .container.active .images-group {
            overflow: hidden;
            top: -268px;
            animation: lineStart .5s linear 0s forwards, lineStart .5s linear 15.5s alternate-reverse backwards;
            animation-fill-mode: forwards;
        }
        /* shine */
        .container.active .shine_box {
            position: relative;
        }
        .container.active .shine_box:before {
            content: '';
            z-index: 10;
            position: absolute;
            height: 200%;
            width: 200%;
            top: -120%;
            left: -120%;
            background: linear-gradient(transparent 0%, rgba(255, 255, 255, 0.1) 45%, rgba(255, 255, 255, 0.5) 50%, rgba(255, 255, 255, 0.1) 55%, transparent 100%);
            transition: all 2s;
            transform: rotate(-45deg);
        }
        .container.active #image_logo_container:before {
            animation: shine 5s infinite forwards;
        }
        .container.active #image_game_container:before {
            animation: shine 5s infinite forwards 5.13s;
        }
        .container.active #image_logo_container {
            margin-left: -500px;
            opacity: 0;
            animation: profilePhoto .5s linear .8s forwards, profilePhoto .5s linear 15s alternate-reverse backwards;
            animation-fill-mode: forwards;
        }
        .container.active #image_game_container {
            width: 0px;
            max-height: 140px;
            opacity: 0;
            animation: gamePhoto .4s linear 1s forwards, gamePhoto .4s linear 15s alternate-reverse backwards;
            animation-fill-mode: forwards;
        }
        .container.active .texts #name {
            margin-left: -335px;
            animation: streamerName .9s ease-in-out 1s forwards, streamerName .9s ease-in-out 15s alternate-reverse backwards;
            animation-fill-mode: forwards;
        }
        .container.active .texts #game {
            margin-left: 335px;
            animation: gameName .9s ease-in-out 1s forwards, gameName .9s ease-in-out 15s alternate-reverse backwards;
            animation-fill-mode: forwards;
        }
        /* animate */
        @keyframes lineStart {
            0% {
                top: -268px;
            }
            100% {
                top: 0px;
            }
        }
        @keyframes profilePhoto {
            0% {
                margin-left: -500px;
                opacity: 0;
            }
            100% {
                margin-left: 0px;
                opacity: 1;
            }
        }
        @keyframes gamePhoto {
            0% {
                width: 0%;
                max-width: 0px;
                height: 0;
                opacity: 0;
            }
            100% {
                width: 100%;
                max-width: 105px;
                opacity: 1;
            }
        }
        @keyframes streamerName {
            0% {
                margin-left: -335px;
                opacity: 0;
            }
            100% {
                margin-left: 0;
                opacity: 1;
            }
        }
        @keyframes gameName {
            0% {
                margin-left: 335px;
                opacity: 0;
            }
            100% {
                margin-left: 0;
                opacity: 1;
            }
        }
        @keyframes shine {
            0% {
                top: -120%;
                left: -120%;
            }
            20% {
                left: 100%;
                top: 100%;
            }
            40% {
                left: 100%;
                top: 100%;
            }
            100% {
                left: 100%;
                top: 100%;
            }
        }
    </style>
    <style>
        .container .images-group {
            border-color: ` + custom.border_color_line + `;
        }
        .container .images-group #image_logo_container {
            border-color: ` + custom.border_color_name + `;
            border-radius: ` + custom.border_radius + `%;
        }
        .container .images-group #image_game_container {
            height: ` + (custom.border_radius > 25 ? '105px' : '140px') + `;
            border-color: ` + custom.border_color_game + `;
            border-radius: ` + custom.border_radius + `%;
        }
        .container .texts {
            font-family: '` + custom.font + `';
        }
        .container .texts #name, .container .texts #game  {
            text-shadow: -2px 2px 4px ` + custom.shadow_color + `;
        }
        .container .texts #name {
            color: ` + custom.font_color_name + `;
            font-weight: ` + custom.font_weight_name + `;
            font-style: ` + custom.font_style_name + `;
        }
        .container .texts #game {
            color: ` + custom.font_color_game + `;
            font-weight: ` + custom.font_weight_game + `;
            font-style: ` + custom.font_style_game + `;
        }
    </style>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=` + custom.font.replace(' ', '+') + `"/>
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
    </div>`
    document.body.insertAdjacentHTML('beforeend', html)
}

/* helpers */

const render_fix = () => {
    let name = document.querySelector('#name'),
        name_font_size
    if (name.textContent.length < 8) {
        name_font_size = '40px'
    } else if (name.textContent.length < 12) {
        name_font_size = '28px'
    } else if (name.textContent.length < 16) {
        name_font_size = '20px'
    } else if (name.textContent.length < 21) {
        name_font_size = '15px'
    } else if (name.textContent.length < 27) {
        name_font_size = '12px'
    } else if (name.textContent.length < 36) {
        name_font_size = '9px'
    } else if (name.textContent.length > 35) {
        name_font_size = '8px'
    }
    name.style.fontSize = name_font_size
    let game = document.getElementById('game'),
        game_font_size
    if (game.textContent.length < 21) {
        game_font_size = '22px'
    } else if (game.textContent.length < 25) {
        game_font_size = '17px'
    } else if (game.textContent.length < 31) {
        game_font_size = '15px'
    } else if (game.textContent.length > 30) {
        game_font_size = '12px'
    }
    game.style.fontSize = game_font_size
}

const css_add = (element, classname) => {
    if (element.classList) {
        element.classList.add(classname)
    } else {
        element.className += ' ' + classname
    }
}

const css_remove = (element, classname) => {
    if (element.classList) {
        element.classList.remove(classname)
    } else {
        classname = classname.split(' ').join('|')
        let reg = new RegExp('(^|\\b)' + classname + '(\\b|$)', 'gi')
        element.className = element.className.replace(reg, ' ')
    }
}

/* indica */

const indica_call = (indication) => /* custom */ {
    fetch('https://xt.art.br/indica/api/' + indication + '/' + custom.channel)
        .then(response => response.json())
        .then((response) => {
            overlay.push(response)
            indica_row()
        })
}

const indica_flow = (current) => {
    Object.keys(current).forEach((key) => {
        if (document.querySelector('#' + key)) {
            if (key.substring(0, 5) == 'image') {
                document.querySelector('#' + key).setAttribute('src', current[key])
            } else {
                document.querySelector('#' + key).innerHTML = current[key]
            }
        }
    })
    render_fix()
    document.querySelector('#image_logo').onload = () => {
        let container = document.querySelector('#container')
        css_add(container, 'active')
        setTimeout(() => {
            css_remove(container, 'active')
        }, ((15 * 1000) + 1000))
    }
}

const indica_row = () => /* overlay, empty */ {
    if (empty && overlay.length) {
        empty = 0
        let current = overlay.shift()
        indica_flow(current)
        setTimeout(() => {
            empty = 1
            indica_row()
        }, ((15 * 1000) + 2000))
    }
}

window.addEventListener('onWidgetLoad', (obj) => /* custom */ {
    custom = obj.detail.fieldData
    custom.id = obj.detail.channel.providerId
    custom.channel = obj.detail.channel.username
    Object.keys(field).forEach((key) => {
        custom[key] = custom[key] ? custom[key] : field[key].value
    })
    render()
})

window.addEventListener('onEventReceived', (obj) => /* custom */ {
    if (obj.detail.event.field == 'test') {
        indica_call(custom.channel)
    }
    if (obj.detail.event.field == 'img_logo_add') {
        custom.img_logo = custom.img_logo.replace('https://cdn.streamelements.com/uploads/', '')
        fetch('https://xt.art.br/indica/api/' + custom.id + '/gif/' + custom.img_logo)
            .then(response => indica_call(custom.channel))
    }
    if (obj.detail.event.field == 'img_logo_rmv') {
        fetch('https://xt.art.br/indica/api/' + custom.id + '/gif/unlink')
            .then(response => indica_call(custom.channel))
    }
    if (obj.detail.event && obj.detail.listener === 'message') {
        let word = obj.detail.event.data.text.split(' ')
        if (word[0].toLowerCase() == custom.command.toLowerCase() && typeof word[1] !== 'undefined') {
            let badges = obj.detail.event.data.tags.badges.replace(/\d+/g, '').replace(/,/g, '').split('/')
            if (badges.indexOf('moderator') != -1 || badges.indexOf('broadcaster') != -1) {
                indica_call(word[1])
            }
        }
    }
})