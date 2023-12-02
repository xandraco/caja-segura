let TokensArray = {};

const TokenContainer = document.getElementById('TokenTable'); // Contenedor donde mostrar los usuarios
const TokenTemplate = document.getElementById('DataToken').content; // Plantilla HTML
const fragment = document.createDocumentFragment()

updateBtn = document.getElementById('btnUpdate')

document.addEventListener('DOMContentLoaded', () => {
    loadUsers();

    $(function () {
        $('#dateInit').datepicker({ uiLibrary: 'bootstrap5' });
    });
    $(function () {
        $('#dateEnd').datepicker({ uiLibrary: 'bootstrap5' });
    });
});

const loadUsers = () => {
    fetch('./Backend/Files/getTokens.php')
        .then(async response => {
            const res = await response.json();
            if (res.STATUS === 'SUCCESS') {
                TokensArray = res.TOKENS;
                TokensArray.forEach((token) => {
                    TokenTemplate.querySelector('th').textContent = token.id;
                    TokenTemplate.querySelectorAll('td')[0].textContent = token.userName;
                    TokenTemplate.querySelectorAll('td')[1].textContent = token.token;
                    TokenTemplate.querySelectorAll('td')[2].textContent = token.useDate;

                    const clone = TokenTemplate.cloneNode(true); // Clonar la plantilla para cada usuario
                    // Agregar fila clonada al contenedor de usuarios
                    fragment.appendChild(clone);
                });
                TokenContainer.appendChild(fragment)
            } else {
                console.error('Error:', res.MESSAGE);
            }
        })
        .catch(error => {
            console.error('Error al obtener usuarios:', error);
        });
};

updateBtn.addEventListener('click', () => {
    const userSearch = document.getElementById('search')
    const dateInit = document.getElementById('dateInit')
    const dateEnd = document.getElementById('dateEnd')
    let state = 0

    if (userSearch.value && dateInit.value && dateEnd.value) {
        console.log(state)
        const sendData = {
            state: state,
            user: userSearch.value,
            dateInit: dateInit.value,
            dateEnd: dateEnd.value
        };
        fullSearch(sendData)
    } else if (userSearch.value) {
        state = 1
        console.log(state)
        const sendData = {
            state: state,
            user: userSearch.value,
        };
        fullSearch(sendData)
    } else if (dateInit.value && dateInit.value) {
        state = 2
        console.log(state)
        const sendData = {
            state: state,
            dateInit: dateInit.value,
            dateEnd: dateEnd.value
        };
        fullSearch(sendData)
    } else if (dateEnd || dateInit) {
        console.log('Ingresa ambas fechas')
    } else {
        loadUsers()
    }
})

const fullSearch = (sendData) => {
    fetch('./Backend/Files/searchTokenLog.php', {
        method: 'POST',
        body: JSON.stringify(sendData),
        headers: {
            'Content-Type': 'application/json',
        },
    })
        .then(async response => {
            const res = await response.json();
            if (res.STATUS === 'SUCCESS') {
                TokensArray = res.TOKENS;
                TokensArray.forEach((token) => {
                    TokenTemplate.querySelector('th').textContent = token.id;
                    TokenTemplate.querySelectorAll('td')[0].textContent = token.userName;
                    TokenTemplate.querySelectorAll('td')[1].textContent = token.token;
                    TokenTemplate.querySelectorAll('td')[2].textContent = token.useDate;

                    const clone = TokenTemplate.cloneNode(true); // Clonar la plantilla para cada usuario
                    // Agregar fila clonada al contenedor de usuarios
                    fragment.appendChild(clone);
                });
                TokenContainer.appendChild(fragment)
            } else {
                console.error('Error:', res.MESSAGE);
            }
        })
        .catch(error => {
            console.error('Error al obtener usuarios:', error);
        });
};