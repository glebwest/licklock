// создание главного объекта, проверка токена, генерация управляющих конструкций

let App = new Main()

let login = document.querySelector('.login')

App.timing = 1

App.getData('checkToken','hello',(object)=>{
    // console.log(object)
    if (object === true) {
        App.isUser = object
        // генерация кнопок лк и выход
        login.querySelector('p').innerHTML = 'Выход';
    } else {
        App.isUser = false
        // генерация кнопки вход
        login.querySelector('p').innerHTML = 'Вход';
    }
    App.goOut()
    login.classList.add('active')
})

login.addEventListener('click',(e)=>{
    if (login.classList.contains('active')) {
        if (App.isUser) {
            App.getData('logout','byby',(object)=>{
                if (object === 'byby') {
                    App.revomeToken()
                    window.location = '/login';
                }
            })
        } else {
            window.location = '/login'
        }
    }
})

let burger = document.querySelector('.burger')
let menu = document.querySelector('.menu')

burger.addEventListener('click',(e)=>{
    burger.classList.toggle('open')
    menu.classList.toggle('open')
})