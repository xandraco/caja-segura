let usuario
const btnLogin = document.getElementById('btnLogin')

btnLogin.addEventListener('click', () => {
    const email = document.getElementById('email')
    const password = document.getElementById('password')

    if (email.value.trim() === '' || password.value.trim() === '') {
        // Enviamos una alerta
        activaAlerta('Los campos no pueden estar vacios')
    } else {
        // intentamos loggearnosa
        const sendData = {
            email: email.value,
            password: password.value
        }

        fetch('./Backend/Files/login.php', {
            method: 'POST',
            body: JSON.stringify(sendData),
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then(async (response) => {
            // console.log(await response.json())
            const respuesta = await response.json()
            if (respuesta.MESSAGE === 'No se encontro el usuario') {
                activaAlerta('El usuario no existe en la DB')
            } else if (respuesta.MESSAGE === 'Invalid password') {
                activaAlerta('Contraseña incorrecta')
            } else if (respuesta.MESSAGE === 'success') {
                usuario = respuesta.USUARIO['email']
                window.location.replace(`/home.html?email=${usuario}`)
            } else {
                activaAlerta('Algo ha salido mal')
            }
        })
        .catch((error) => {
            console.log('error: ', error)
        })
    }
})

const activaAlerta = mensaje => {
    const alerta =document.getElementsByClassName('alert')
    console.log('alerta', alerta)
    alerta[0].innerHTML = mensaje
    alerta[0].classList.remove('hide')
    alerta[0].classList.add('show')
    setTimeout(() => {
        alerta[0].classList.remove('show')
        alerta[0].classList.add('hide')
    }, 3000)
}
