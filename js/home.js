let loggedUser = {}
const titulo = document.getElementById('userBlog')

// Contador y token:
let tokenInterval = null; // Variable para almacenar el intervalo del contador
let tokenValue = ''; // Variable para almacenar el valor del token
const tokenDisplay = document.getElementById('tokenDisplay');
const contadorDisplay = document.getElementById('counter');

document.addEventListener('DOMContentLoaded', () => {
    loadUser()

    // Iniciar contador para regenerar token cada 5 minutos
    tokenInterval = setInterval(genToken, 300000); // 300000 ms = 5 minutos
})

const loadUser = () => {
    const url = window.location.search
    const params = new URLSearchParams(url)
    const email = params.get('email')

    if (email) {
        const sendData = {
            email
        }
        fetch('./Backend/Files/home.php', {
            method: 'POST',
            body: JSON.stringify(sendData),
            headers: { 'Content-Type': 'application/json' }
        })
            .then(async (response) => {
                const user = await response.json()
                loggedUser = user.MESSAGE
                console.log('response => ', loggedUser)
                genToken(); // Generar token al inicio
            })
    }
}

const genToken = () => {
    // Genera un token aleatorio de 6 dígitos
    const token = Math.floor(Math.random() * (999999 - 100000 + 1)) + 100000;
    tokenValue = token.toString(); // Almacena el token generado en la variable

    // Muestra el token en el HTML
    tokenDisplay.textContent = tokenValue;

    // Inserta el token en la base de datos (usando fetch o tu método de envío de datos)
    SendToken(tokenValue);
}

const SendToken = (token) => {
    const idUsuario = loggedUser.id;

    const sendData = {
        token,
        idUsuario
    };
    console.log(sendData)
    fetch('./Backend/Files/newToken.php', {
        method: 'POST',
        body: JSON.stringify(sendData),
        headers: { 'Content-Type': 'application/json' }
    })
        .then(async(response) => await response.json())
        .catch(error => {
            console.error('Error al enviar el token al PHP:', error);
        });
}