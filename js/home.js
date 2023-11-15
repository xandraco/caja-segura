let loggedUser = {}
const titulo = document.getElementById('userBlog')

document.addEventListener('DOMContentLoaded', () => {
    loadUser()
})

const loadUser = () => {
    const url = window.location.search
    const params = new URLSearchParams(url)
    const email = params.get('email')

    if (email) {
        const sendData = {
            email
        }
        fetch ('./Backend/Files/home.php', {
            method: 'POST',
            body: JSON.stringify(sendData),
            headers: { 'Content-Type': 'application/json '}
        })
        .then( async (response) => {
            const user = await response.json()
            loggedUser = user.MESSAGE
            const inputIdUser = document.getElementById('idUsuario')
            inputIdUser.value = loggedUser.email
            titulo.innerHTML = loggedUser.nombre
            console.log('response => ', loggedUser)
        })
    }
}
