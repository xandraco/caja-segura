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
            const email = await response.json()
            loggedUser = email.MESSAGE
            const inputIdUser = document.getElementById('idUsuario')
            inputIdUser.value = loggedUser.email
            titulo.innerHTML = loggedUser.email
            console.log('response => ', loggedUser)
        })
    }
}
