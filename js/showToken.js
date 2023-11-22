let loggedToken = {}
// Contador y token:

let tokenValue = ''; // Variable para almacenar el valor del token
const tokenDisplay = document.getElementById('tokenDisplay');
const CounterDisplay = document.getElementById('counter');
let timer = 60;

document.addEventListener('DOMContentLoaded', () => {
    DataUserToken()
    CounterDisplay.textContent = timer.toString()
})

const DataUserToken = () => {
    fetch('./Backend/Files/session.php', { method: 'GET' })
        .then(async (response) => {
            const res = await response.json();
            if (res.STATUS === 'SUCCESS') {
                // Acceder a los datos de sesión desde la respuesta JSON
                loggedUser = res.USER;
                loadToken()
            } else {
                console.error('Error:', res.MESSAGE);
            }
        }).catch(error => console.error('Error de Fetch:', error));
}

const loadToken = () => {
    genToken(); // Generar token al inicio
    countDown = setInterval(updateCountDown, 1000);
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
    fetch('./Backend/Files/newToken.php', {
        method: 'POST',
        body: JSON.stringify(sendData),
        headers: { 'Content-Type': 'application/json' }
    })
        .then(async (response) => await response.json())
        .catch(error => {
            console.error('Error al enviar el token al PHP:', error);
        });
}

const updateCountDown = () => {
    timer--;
    CounterDisplay.textContent = timer.toString()
    if (timer <= 0) {
        genToken();
        timer = 60;
    }
}