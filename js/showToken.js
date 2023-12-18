let loggedToken = {}
// Contador y token:

let tokenValue = ''; // Variable para almacenar el valor del token
const tokenDisplay = document.getElementById('tokenDisplay');
const CounterDisplay = document.getElementById('counter');
const TimeBar = document.getElementById('timeBar');
let timer = 60;
let remainingSeconds;
let countDown; // Declarar la variable globalmente

const eventSource = new EventSource('./Backend/Files/server.php');//new

document.addEventListener('DOMContentLoaded', () => {
    clearInterval(countDown);
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
    timer = 60;
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
    TimeBar.style.width = (timer*100/60) + "%"
    if (timer <= 0) {
        genToken();
        timer = 60;
    }
}


window.addEventListener('beforeunload', function(event) {
    deleteToken()
});

// Este evento se activa cuando la página se está ocultando (cambio de página o cierre de la aplicación)
window.addEventListener('pagehide', function(event) {
    deleteToken(); // Llama a la función para enviar los datos al servidor
});

// Este evento se activa cuando la página se muestra de nuevo
window.addEventListener('pageshow', function(event) {
    // Llama a la función para cargar los tokens nuevamente
    loadToken();
    clearInterval(countDown);
});

// Este evento se activa cuando la visibilidad de la página cambia (como cambiar a otra pestaña)
document.addEventListener('visibilitychange', function(event) {
    if (document.visibilityState === 'hidden') {
        deleteToken(); // Llama a la función para enviar los datos al servidor
    }
    else if (document.visibilityState === 'visible') {
        // Llama a la función para cargar los tokens nuevamente
        loadToken();
        clearInterval(countDown);
    }
});

const deleteToken = () => {
    fetch('./Backend/Files/DeleteToken.php', {
        method: 'POST' // Envía una solicitud POST al servidor PHP
    })
    .then(response => response.json())
    .then(data => {
        if (data.STATUS === 'SUCCESS') {
            console.log('Token eliminada correctamente');
        } else {
            console.error('Error al eliminar token:', data.MESSAGE);
        }
    })
    .catch(error => console.error('Error en la petición:', error));
}



//new


eventSource.addEventListener('reloadToken', function(event) {
    // Cuando se recibe el evento 'reloadToken', recarga la página o realiza las acciones necesarias
    location.reload(); // Recarga la página
});

eventSource.addEventListener('error', function(event) {
    // Manejo de errores si ocurre algún problema con la conexión
    console.error('Error en la conexión del EventSource:', event);
});