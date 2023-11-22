let loggedUser = {}

const titulo = document.getElementById('userBlog')
const mainContent = document.getElementById('mainContent');

document.addEventListener('DOMContentLoaded', () => {
    DataUser()
    fetchComponent('showToken');
})

const DataUser = () => {
    fetch('./Backend/Files/session.php', {method: 'GET'})
        .then(async (response) => {
            const res = await response.json();
            if (res.STATUS === 'SUCCESS') {
                // Acceder a los datos de sesión desde la respuesta JSON
                loggedUser = res.USER;
                loadUser()
            } else {
                console.error('Error:', res.MESSAGE);
            }
        }).catch(error => console.error('Error de Fetch:', error));
}

const loadUser = () => {
    titulo.innerHTML = loggedUser.user;
}

function changeContent(component) {
    fetchComponent(component);
}

function fetchComponent(component) {
    fetch(`./components/${component}.php`)
        .then(response => response.text())
        .then(data => {
            mainContent.innerHTML = data;
        })
        .catch(error => console.error('Error al cargar el componente:', error));
}