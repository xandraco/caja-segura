document.addEventListener('DOMContentLoaded', () => {
    const tokenForm = document.getElementById('tokenForm');

    tokenForm.addEventListener('submit', (event) => {
        event.preventDefault();

        const token = document.getElementById('tokenInput').value;
        sendTokenToVerification(token);
        document.getElementById('tokenForm').reset();
    });
});

function sendTokenToVerification(token) {
    fetch('./Backend/Files/tokenVerification.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ token: token })
    })
    .then(response => response.json())
    .then(data => {
        // Manejar la respuesta recibida desde tokenVerification.php
        console.log(data); // Puedes mostrar la respuesta en la consola o realizar otras acciones según tu lógica
    })
    .catch(error => {
        console.error('Error:', error);
    });
}
