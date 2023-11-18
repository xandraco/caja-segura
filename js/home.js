let loggedUser = {}

const titulo = document.getElementById('userBlog')

// Contador y token:
let tokenInterval = null; // Variable para almacenar el intervalo del contador
let tokenValue = ''; // Variable para almacenar el valor del token
const tokenDisplay = document.getElementById('tokenDisplay');
const CounterDisplay = document.getElementById('counter');
let timer = 60;

document.addEventListener('DOMContentLoaded', () => {
    $.ajax({
        type: 'GET',
        url: './Backend/Files/session.php',
        dataType: 'json',
        success: function (response) {
            // Manejar la respuesta del servidor
            if (response.STATUS === 'SUCCESS') {
                // Acceder a los datos de sesión desde la respuesta JSON
                loggedUser = response.USER;
            } else {
                console.error('Error:', response.MESSAGE);
            }
        },
        error: function (xhr, status, error) {
            console.error('Error de AJAX:', status, error);
        }
    });
    loadUser()
    CounterDisplay.textContent = timer.toString()
})

const loadUser = () => {    
    titulo.innerHTML = loggedUser['email'];
    console.log(loggedUser.id, loggedUser.user)
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
    const idUsuario = loggedUser['id'];
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
        .then(async (response) => await response.json())
        .catch(error => {
            console.error('Error al enviar el token al PHP:', error);
        });
}

const updateCountDown = () => {
    timer--;
    CounterDisplay.textContent = timer.toString()
    if (timer <= 1) {
        genToken();
        timer = 60;
    }
}