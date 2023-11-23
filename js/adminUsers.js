let usersArray = {};

const usersContainer = document.getElementById('TablaUsuarios'); // Contenedor donde mostrar los usuarios
const userTemplate = document.getElementById('DataUsers').content; // Plantilla HTML
const fragment = document.createDocumentFragment()

document.addEventListener('DOMContentLoaded', () => {
    loadUsers();
});

const loadUsers = () => {
    fetch('./Backend/Files/getUsers.php')
        .then(async response => {
            const res = await response.json();
            if (res.STATUS === 'SUCCESS') {
                usersArray = res.USERS;
                usersArray.forEach((user) => {
                    userTemplate.querySelector('th').textContent = user.id;
                    userTemplate.querySelectorAll('td')[0].textContent = user.user;
                    userTemplate.querySelectorAll('td')[1].textContent = user.email;
                    userTemplate.querySelectorAll('td')[2].textContent = user.admin;
                    userTemplate.querySelectorAll('a')[0].href = `Backend/files/updateUser.php?id${user.id}`
                    userTemplate.querySelectorAll('a')[1].href = `Backend/files/deleteUser.php?id${user.id}`

                    
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

