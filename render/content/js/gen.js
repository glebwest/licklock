class LinkGen {
    self = document.querySelector('.linkGen')
    longer = this.self.querySelector('.longer')
    setLink = this.self.querySelector('.setLink')
    spin = this.self.querySelector('.spin')
    result = this.self.querySelector('.resultLink')
    saveLinkBlock = this.self.querySelector('.saveLinkBlock')
    link = this.result.querySelector('.thisIsLink')
    saveLink = this.saveLinkBlock.querySelector('.saveLink')
    mail = this.saveLinkBlock.querySelector('.mailLink')
    linkID;
    tax = 301;
    taxList = this.saveLinkBlock.querySelector('.tax-list')
    helper = this.self.querySelector('.linkHelper')
    knowThis = this.self.querySelector('.knowThis')
    errMess = this.self.querySelector('.errMess')
    longerInput (e) {
        e.preventDefault()
        this.errMess.innerHTML = ''
        this.longer.classList.remove('error')
        this.setLink.setAttribute('value','Создать')
        if (this.longer.value.length > 4) {
            this.setLink.classList.add('active')
            this.setLink.removeAttribute('disabled')
        } else {
            this.setLink.setAttribute('disabled',true)
            this.longer.classList.add('error')
        }
    }
    setterLink(e) {
        e.preventDefault()
        if (!this.setLink.getAttribute('disabled')) {
            this.longer.setAttribute('disabled',true)
            this.spin.classList.add('active')
            this.setLink.classList.remove('active')
            App.getData('setLink',{
                'longer' : this.longer.value
            },(object)=>{
                this.spin.classList.remove('active')
                console.log(object)
                if (object.id) {
                    // nice
                    this.linkID = object.id
                    this.link.innerHTML = App.prefix + object.name
                    this.link.setAttribute('href', 'http://' + App.prefix + object.name)
                    this.result.classList.add('active')
                    if (!App.isUser) {
                        this.saveLinkBlock.classList.add('active')
                    }
                } else {
                    // error
                    this.longer.removeAttribute('disabled')
                    this.longer.classList.add('error')
                    this.setLink.classList.add('active')
                    this.setLink.setAttribute('value','Исправить и повторить')
                }
            })
        }
    }
    copyLink(e) {
        e.preventDefault()
        let rng,sel
        rng = document.createRange()
        rng.selectNode(this.link)
        sel = window.getSelection()
        sel.removeAllRanges()
        sel.addRange(rng)
        document.execCommand('copy')
        sel.removeAllRanges()
        let target = e.target
        target.classList.add('copy')
        target.value = 'Скопированно'
        setTimeout(() => {
            target.value = 'Копировать'
            target.classList.remove('copy')
        }, 3000);
    }
    mailChange(e) {
        e.preventDefault()
        this.helper.classList.remove('active')
        this.knowThis.classList.add('active')
        this.mail.classList.remove('error')
        this.saveLink.setAttribute('value','Продолжить')
        if (this.mail.value.length > 6) {
            this.result.classList.remove('active')
            this.longer.classList.remove('active')
            this.saveLink.classList.add('active')
            this.taxList.classList.add('active')
            this.saveLink.removeAttribute('disabled')
        } else {
            this.saveLink.setAttribute('disabled',true)
            this.mail.classList.add('error')
        }    
    }
    setUserAndLink(e) {
        e.preventDefault()
        if (!this.saveLink.getAttribute('disabled')) {
            this.mail.setAttribute('disabled',true)
            this.spin.classList.add('active')
            this.saveLinkBlock.classList.remove('active')
            let data = {
                'link' : this.linkID,
                'email': this.mail.value,
                'tax': this.tax
            }
            console.log(data)
            App.getData('firstRegistration',data,(object)=>{
                this.spin.classList.remove('active')
                console.log(object)
                switch (object.status) {
                    case 2:
                        // редирект сразу на страницу "спасибо"
                        window.location = '/thanks'
                        break;
                    case 1:
                        // всё хорошо, редирект по транзакции
                        window.location = '/pay/' + object.pay
                        break;
                    case 0:
                        // ошибка, проверяем её код
                        this.mail.removeAttribute('disabled')
                        this.mail.classList.add('error')
                        this.saveLinkBlock.classList.add('active')
                        this.saveLink.setAttribute('value','Исправить и продолжить')
                        switch (object.error) {
                            case 1:
                                // некорректные данные
                                this.errMess.innerHTML = 'Введены некорректные данные'
                                break;
                            case 2:
                                // пользователь уже есть
                                this.errMess.innerHTML = 'Пользователь с таким email уже зарегистрирован'
                                break;
                            case 3:
                                // неопознанная ошибка
                                window.location = '/error'
                                break;
                            default:
                                break;
                        }
                        break;
                    default:
                        break;
                }
            })
        }
    }
}

linkGen = new LinkGen()
// 1. Ввод длинной ссылки

linkGen.longer.addEventListener('input',(e)=>{
    linkGen.longerInput(e)
})

// 2. Генерация короткой ссылки

linkGen.setLink.addEventListener('click',(e)=>{
    linkGen.setterLink(e)
})

// 3. Копирование короткой ссылки

linkGen.result.querySelector('.copyLink').addEventListener('click',(e)=>{
    linkGen.copyLink(e)
})

// 4. Ввод email для создания аккаунта

linkGen.mail.addEventListener('change',(e)=>{
    linkGen.mailChange(e)
})

linkGen.mail.addEventListener('input',(e)=>{
    linkGen.errMess.innerHTML = ''
})


// 5. Прослушивание инпутов с вариантами продления

linkGen.taxList.querySelectorAll('input[type=radio]').forEach(el => {
    el.addEventListener('click',(e)=>{
        linkGen.tax = el.value
    })
});

// 6. Отправка email и ссылки для сохранения

linkGen.saveLink.addEventListener('click',(e)=>{
    linkGen.setUserAndLink(e)
})

// 7. !!! Не сделанно: начало генерации с нуля (класс reloadLink)