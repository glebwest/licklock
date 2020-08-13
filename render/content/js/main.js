
// Класс для получения токена и запроса на сервер

class Main {
    prefix = 'lick.loc/'
    token = localStorage.getItem('token')
    url = '/api.php'
    isUser;
    goFlag;
    goValue;
    timing = 750
    delay = ms => {
        return new Promise(r => setTimeout( ()=> r(), ms))
    }
    async getData(method,object,toDo = function(object){}) {
        let quest = {'method' : method, 'token' : this.token, 'data' : object, 'sys' : navigator.platform}
        try {
            await this.delay(this.timing)
            const response = await fetch (this.url,{
                method: 'POST',
                headers: {
                    'Content-Type':'application/json; charset=utf-8'
                },
                body: JSON.stringify(quest)
            })
    
            const data = await response.json()
    
            let answer = data.ans
            toDo(answer)
        } catch (e) {
            console.error(e) || toDo('SERVER ERROR. TRY LATER')
        }
    }
    include(url) {
        let script = document.createElement('script')
        script.src = '/render/content/js/' + url + '.js'
        document.getElementsByTagName('script')[0].before(script)
    }
    revomeToken() {
        this.token = null
        this.isUser = null
        localStorage.removeItem('token')
    }
    goOut() {
        if (this.goFlag === this.isUser) {
            window.location = '/' + this.goValue
        }
    }
}