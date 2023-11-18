let user;
const btnLogin = document.getElementById('btnLogin');

btnLogin.addEventListener('click', () => {
  const email = document.getElementById('email');
  const password = document.getElementById('password');

  if (email.value.trim() === '' || password.value.trim() === '') {
    activaAlerta('Los campos no pueden estar vacíos');
  } else {
    const sendData = {
      email: email.value,
      password: password.value,
    };

    fetch('./Backend/Files/login.php', {
      method: 'POST',
      body: JSON.stringify(sendData),
      headers: {
        'Content-Type': 'application/json',
      },
    })
      .then(async (response) => {
        const respuesta = await response.json();
        if (respuesta.MESSAGE === 'No se encontro el usuario') {
          activaAlerta('El usuario no existe');
        } else if (respuesta.MESSAGE === 'Contraseña incorrecta') {
          activaAlerta('Contraseña incorrecta');
        } else if (respuesta.MESSAGE === 'success') {
          // Almacena información del usuario en la sesión del servidor
          fetch('./Backend/Files/session.php', {
            method: 'POST',
            body: JSON.stringify({ usuario: respuesta.USUARIO }),
            headers: {
              'Content-Type': 'application/json',
            },
          })
            .then(() => {
              // Indica al usuario que el inicio de sesión fue exitoso
              activaAlerta('Inicio de sesión exitoso');

              // Redirige al usuario después de mostrar el mensaje
              setTimeout(() => {
                window.location.replace('/CheckToken/home.php');
              }, 2000);
            })
            .catch((error) => {
              console.log('Error al almacenar la sesión: ', error);
              activaAlerta('Algo ha salido mal');
            });
        } else {
          activaAlerta('Algo ha salido mal');
        }
      })
      .catch((error) => {
        console.log('Error en la solicitud: ', error);
        activaAlerta('Algo ha salido mal');
      });
  }
});

const activaAlerta = mensaje => {
    const alerta =document.getElementsByClassName('alert')
    console.log('alerta', alerta)
    alerta[0].innerHTML = mensaje
    alerta[0].classList.remove('hide')
    alerta[0].classList.add('show')
    setTimeout(() => {
        alerta[0].classList.remove('show')
        alerta[0].classList.add('hide')
    }, 30000)
}
