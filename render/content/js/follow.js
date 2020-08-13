let App = new Main()

App.timing = 1

// 1. Сбор информации о пользователе

let dataObject = {
    'tech' : navigator.platform,
    'town' : null, // ++ на будущее
    'country' : null // ++ на будущее
}

// 2. Запрос на получение адреса перехода и редирект

App.getData('getLink',{'name' : way, 'follow' : dataObject},(object)=>{
    console.log(object)
    if (object.status === 0) {
        window.location = '/error'
    } else if (object.status === 1) {
        window.location = object.link
    } else {
        window.location = '/error'
    }
})

