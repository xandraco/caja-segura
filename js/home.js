let loggedUser = {}
const titulo = document.getElementById('userBlog')

// Contador y token:
let tokenInterval = null; // Variable para almacenar el intervalo del contador
let tokenValue = ''; // Variable para almacenar el valor del token
const tokenDisplay = document.getElementById('tokenDisplay');
const CounterDisplay = document.getElementById('counter');
let restartTimer = 0;

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
        fetch('./Backend/Files/home.php', {
            method: 'POST',
            body: JSON.stringify(sendData),
            headers: { 'Content-Type': 'application/json' }
        })
            .then(async (response) => {
                const user = await response.json()
                loggedUser = user.MESSAGE
                titulo.innerHTML = loggedUser.user
                console.log('response => ', loggedUser)
                genToken(); // Generar token al inicio
                tokenInterval = setInterval(genToken, 60000); // 300000 ms = 5 minutos
                updateCountDown()
                CountDown = setInterval(updateCountDown, 1000);
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
        .then( async(response) => await response.json())
        .catch(error => {
            console.error('Error al enviar el token al PHP:', error);
        });
}

const updateCountDown = () => {
    const now = new Date();
    if(restartTimer == 0){
        const nextUpdate = new Date(now.getTime() + 60 * 1000); // Calcular el tiempo para la próxima actualización (1 minuto)
        restartTimer = 1
    }
    console.log('jolines, esto no funciona', nextUpdate)
    const difference = nextUpdate - now;
    const minutes = Math.floor((difference % (1000 * 60 * 60)) / (1000 * 60));
    const seconds = Math.floor((difference % (1000 * 60)) / 1000);

    const display = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
    CounterDisplay.textContent = display;

    if (difference < 0) {
        clearInterval(intervalTimer); // Detener el contador si ha pasado el tiempo límite
        genToken(); // Generar un nuevo token
        intervalTimer = setInterval(updateCountDown, 1000); // Reiniciar el contador
        restartTimer = 0
    }
}