class Login {
    self = document.querySelector('.logIn')
    userName = this.self.querySelector('.userName')
    userPass = this.self.querySelector('.userPass')
    letLogin = this.self.querySelector('.letLogin')
    letRecover = this.self.querySelector('.letRecover')
    letReg = this.self.querySelector('.letReg')
    letNext = this.self.querySelector('.letNext')
    errMess = this.self.querySelector('.errMess')
    knowThis = this.self.querySelector('.knowThis')
    spin = this.self.querySelector('.spin')
    dataInput(input) {
        this.errMess.innerHTML = ''
        input.classList.remove('error')
    }
    goNext(e) {
        e.preventDefault()
        if (this.userName.value.length < 6) {
            this.userName.classList.add('error')
        } else {
            this.spin.classList.add('active')
            this.letNext.classList.remove('active')
            this.letReg.classList.remove('active')
            this.knowThis.classList.remove('active')
            App.getData('checkUserByEmail',{'email':this.userName.value},(object)=>{
                this.spin.classList.remove('active')
                if (object.status === 1) {
                    if (object.user === 1) {
                        // пользователь есть
                        this.self.querySelector('.block1').classList.remove('active')
                        this.self.querySelector('.block2').classList.add('active')
                    } else {
                        // пользователя нет
                        this.errMess.innerHTML = 'Пользователя с таким email не существует'
                    }
                } else {
                    this.userName.classList.add('error')
                    // некорректный ввод
                    this.errMess.innerHTML = 'Проверьте правильность ввода'
                }
                this.letNext.classList.add('active')
                this.letReg.classList.add('active')
                this.knowThis.classList.add('active')
            })
        }
    }
    setReg(e) {
        e.preventDefault()
        if (this.userName.value.length < 6) {
            this.userName.classList.add('error')
        } else {
            this.spin.classList.add('active')
            this.letNext.classList.remove('active')
            this.letReg.classList.remove('active')
            this.knowThis.classList.remove('active')
            App.getData('registration',{'email':this.userName.value},(object)=>{
                this.spin.classList.remove('active')
                if (object.status === 1) {
                    // успешная регистрация
                    window.location = '/thanks'
                } else {
                    // ошибка
                    console.log(object)
                    this.userName.classList.add('error')
                    switch (object.error) {
                        case 1:
                            // некорректный ввод
                            this.errMess.innerHTML = 'Проверьте правильность ввода'
                            break;
                        case 2:
                            // пользователь есть
                            this.errMess.innerHTML = 'Пользователь с таким email уже зарегистрирован'
                            break;
                        default:
                            // некорректный ввод
                            this.errMess.innerHTML = 'Проверьте правильность ввода'
                            break;
                    }
                    this.letNext.classList.add('active')
                    this.letReg.classList.add('active')
                    this.knowThis.classList.add('active')
                }
            })
        }
    }
    setRecover(e) {
        e.preventDefault()
        this.spin.classList.add('active')
        this.letRecover.classList.remove('active')
        this.letLogin.classList.remove('active')
        this.knowThis.classList.remove('active')
        App.getData('recover',{'email':this.userName.value},(object)=>{
            console.log(object)
            this.spin.classList.remove('active')
            this.letRecover.classList.add('active')
            this.letLogin.classList.add('active')
            this.knowThis.classList.add('active')
            if (object.status === 1) {
                window.location = '/thanks'
            } else {
                window.location = '/error'
            }
        })
    }
    setLogin(e) {
        e.preventDefault()
        if (this.userPass.value.length < 6) {
            this.userPass.classList.add('error')
        } else {
            this.spin.classList.add('active')
            this.letRecover.classList.remove('active')
            this.letLogin.classList.remove('active')
            this.knowThis.classList.remove('active')
            App.getData('login',{
                'email':this.userName.value,
                'pass':this.userPass.value
            }, (object) => {
                console.log(object)
                if (object.status === 1) {
                    localStorage.setItem('token',object.token)
                    window.location = '/lk'
                } else {
                    switch (object.error) {
                        case 1:
                            this.errMess.innerHTML = 'Ошибка в пароле'
                            break;
                        case 2:
                            this.errMess.innerHTML = 'Ошибка в пароле'
                            break;
                        case 3:
                            this.errMess.innerHTML = 'Ошибка в пароле'
                            break;
                        default:
                            this.errMess.innerHTML = 'Неизвестная ошибка'
                            break;
                    }
                }
                this.spin.classList.remove('active')
                this.letRecover.classList.add('active')
                this.letLogin.classList.add('active')
                this.knowThis.classList.add('active')
            })   
        }
    }
}

let LOL = new Login()

App.timing = 500

// 1. Набор email

LOL.userName.addEventListener('input',(e)=>{
    LOL.dataInput(e.target)
})

// 2. Нажатие на продолжить

LOL.letNext.addEventListener('click',(e)=>{
    LOL.goNext(e)
})


// 3. Нажатие на создать аккаунт

LOL.letReg.addEventListener('click',(e)=>{
    LOL.setReg(e)
})

// 4. Набор password

LOL.userPass.addEventListener('input',(e)=>{
    LOL.dataInput(e.target)
})

// 5. Нажатие на восстановление

LOL.letRecover.addEventListener('click',(e)=>{
    LOL.setRecover(e)
})

// 6. Нажатие на вход

LOL.letLogin.addEventListener('click',(e)=>{
    LOL.setLogin(e)
})