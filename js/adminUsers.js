let usersArray = {};

const usersContainer = document.getElementById('TablaUsuarios'); // Contenedor donde mostrar los usuarios
const userTemplate = document.getElementById('DataUsers').content; // Plantilla HTML
const fragment = document.createDocumentFragment()

updateBtn = document.getElementById('btnUpdate')
addBtn = document.getElementById('btnAddUser')

document.addEventListener('DOMContentLoaded', () => {
    loadUsers();

    document.addEventListener('click', function (event) {
        if (event.target.classList.contains('AddUsuarioBtn')) {
            $('editarUsuarioModal').modal('show');
        }

        if (event.target.classList.contains('editarUsuarioBtn')) {
            const idUsuario = event.target.getAttribute('data-user-id');
            const modal = document.getElementById('editarUsuarioModal');
            const idUsuarioInput = modal.querySelector('#idUsuarioUpdate'); // Campo oculto en el formulario modal
            // Actualizar el valor del campo oculto con el ID del usuario seleccionado
            idUsuarioInput.value = idUsuario;
            $('editarUsuarioModal').modal('show');
            console.log("usuario >>> ", idUsuarioInput)
        }
    });

    $('#AddUsuarioModal').on('hidden.bs.modal', function () {
        document.getElementById('AddUsuarioForm').reset();
    });

    $('#editarUsuarioModal').on('hidden.bs.modal', function () {
        document.getElementById('editarUsuarioForm').reset();
    });
});

const loadUsers = () => {
    fetch('./Backend/Files/getUsers.php')
        .then(async response => {
            const res = await response.json();
            if (res.STATUS === 'SUCCESS') {
                usersArray = res.USERS;
                console.log(usersArray)
                usersArray.forEach((user) => {
                    userTemplate.querySelector('th').textContent = user.id;
                    userTemplate.querySelectorAll('td')[0].textContent = user.user;
                    userTemplate.querySelectorAll('td')[1].textContent = user.email;
                    if (user.admin === 1) {
                        userTemplate.querySelectorAll('td')[2].textContent = "Admin";
                    } else {
                        userTemplate.querySelectorAll('td')[2].textContent = "Ninguno";
                    }
                    userTemplate.querySelectorAll('a')[0].setAttribute('data-user-id', user.id);
                    userTemplate.querySelectorAll('a')[1].href = `Backend/Files/deleteUser.php?id=${user.id}`


                    const clone = userTemplate.cloneNode(true); // Clonar la plantilla para cada usuario
                    // Agregar fila clonada al contenedor de usuarios
                    fragment.appendChild(clone);
                });
                usersContainer.appendChild(fragment)
            } else {
                console.error('Error:', res.MESSAGE);
            }
        })
        .catch(error => {
            console.error('Error al obtener usuarios:', error);
        });
};

addBtn.addEventListener('click', () => {
    const email = document.getElementById('EmailAdd')
    const user = document.getElementById('userAdd');
    const password = document.getElementById('passwordAdd');
    const adminFalse = document.getElementById('adminAddFalse').checked;
    let admin = 0

    if (!adminFalse) {
        admin = 1
    }

    const sendData = {
        email: email.value,
        user: user.value,
        password: password.value,
        admin: admin
    };

    console.log(sendData)

    fetch('./Backend/Files/AddUser.php', {
        method: 'POST',
        body: JSON.stringify(sendData),
        headers: {
            'Content-Type': 'application/json',
        },
    })
        .then(async (response) => {
            const respuesta = await response.json();
            if (respuesta.MESSAGE === '1') {
                activaAlertaOk('Usuario Agregado');
            } else {
                activaAlertaError('Algo ha salido mal');
            }
            loadUsers();
        })
        .catch((error) => {
            console.log('Error en la solicitud: ', error);
            activaAlertaError('Algo ha salido mal');
        });
});


updateBtn.addEventListener('click', () => {
    const idUsuario = document.getElementById('idUsuarioUpdate')
    const user = document.getElementById('userUpdate');
    const password = document.getElementById('passwordUpdate');
    const adminFalse = document.getElementById('adminUpdateFalse').checked;
    let admin = 0

    if (!adminFalse) {
        admin = 1
    }
    const sendData = {
        idUsuario: idUsuario.value,
        user: user.value,
        password: password.value,
        admin: admin
    };

    fetch('./Backend/Files/updateUser.php', {
        method: 'POST',
        body: JSON.stringify(sendData),
        headers: {
            'Content-Type': 'application/json',
        },
    })
        .then(async (response) => {
            const respuesta = await response.json();
            if (respuesta.MESSAGE === '1') {
                activaAlertaOk('Todo actualizado');
            } else if (respuesta.MESSAGE === '2') {
                activaAlertaOk('Usuario actualizado');
            } else if (respuesta.MESSAGE === '3') {
                activaAlertaOk('Privilegios Actualizados')
            } else {
                activaAlertaError('Algo ha salido mal');
            }
            loadUsers();

        })
        .catch((error) => {
            console.log('Error en la solicitud: ', error);
            activaAlertaError('Algo ha salido mal');
        });
})