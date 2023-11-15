document.addEventListener("DOMContentLoaded", () => {
    const url = window.location.search
    const params = new URLSearchParams(url)
    const existe = params.get('existe')
    if (existe) {
        const alerta =document.getElementsByClassName('alert')
        alerta[0].classList.remove('hide')
        alerta[0].classList.add('show')
        setTimeout(() => {
            alerta[0].classList.remove('show')
            alerta[0].classList.add('hide')
        }, 3000)
    }
    console.log('params => ', params, existe)
})