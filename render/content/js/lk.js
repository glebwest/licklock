class LK {
    self = document.querySelector('.lk')
    links = this.self.querySelectorAll('.lk-menu-el')
    tabs = this.self.querySelectorAll('.lk-tab')
    spin = this.self.querySelector('.spin')
    openTab(target) {
        let current;
        this.links.forEach(el => {
            if (el.dataset.tab == target.dataset.tab) {
                el.classList.add('active')
            } else {
                el.classList.remove('active')
            }
        })
        this.tabs.forEach(el => {
            if (el.dataset.tab == target.dataset.tab) {
                el.classList.add('active')
                current = el
            } else {
                el.classList.remove('active')
            }
        })
        this.spin.classList.add('active')
        App.timing = 750
        App.getData(target.dataset.method,'hello',(object)=>{
            console.log(object)
            this.spin.classList.remove('active')
            //
        })
    }
}

Lk = new LK()

Lk.openTab(Lk.self.querySelector('.lk-menu-el.active'))

Lk.links.forEach(el => {
    el.addEventListener('click',(e)=>{
        Lk.openTab(e.target)
    })
});