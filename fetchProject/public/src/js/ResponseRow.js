export default class ResponseRow {
    constructor(parent, currentPage) {
        this.parent = parent;
        this.currentPage = currentPage;
    }

    add({ id, nombre, artista, duracion, genero, user }) {
        const div = document.createElement('div');
        div.classList.add('card', 'mb-3', 'p-3');

        div.appendChild(this.#createLabeledElement('Title', nombre));
        div.appendChild(this.#createLabeledElement('Artist', artista));
        div.appendChild(this.#createLabeledElement('Duration', duracion));
        div.appendChild(this.#createLabeledElement('Genre', genero));

        // Verificar si 'user' existe antes de acceder a sus propiedades
        const userName = user && user.name ? user.name : 'Unknown User';
        const userId = user && user.id ? user.id : 'Unknown ID';

        div.appendChild(this.#createLabeledElement('Created by', userName));
        div.appendChild(this.#createLabeledElement('User ID', userId));

        const buttonSection = document.createElement('div');
        buttonSection.classList.add('d-flex', 'justify-content-between', 'mt-2');

        // Botón de ver canción
        const buttonView = document.createElement('a');
        buttonView.textContent = 'View Song';
        buttonView.setAttribute('data-bs-toggle', 'modal');
        buttonView.setAttribute('data-bs-target', '#viewModal');
        buttonView.classList.add('btn', 'btn-success', 'col-auto', 'mb-2');
        buttonView.dataset.id = id;
        buttonView.dataset.nombre = nombre;
        buttonView.dataset.artista = artista;
        buttonView.dataset.duracion = duracion;
        buttonView.dataset.genero = genero;
        buttonView.dataset.url = "/song/" + id;
        buttonView.dataset.method = "get";

        buttonSection.appendChild(buttonView);

        // Solo mostramos los botones de editar y borrar si el usuario está autenticado
        if (window.isAuthenticated) {
            const buttonEdit = document.createElement('a');
            buttonEdit.textContent = 'Edit Song';
            buttonEdit.setAttribute('data-bs-toggle', 'modal');
            buttonEdit.setAttribute('data-bs-target', '#editModal');
            buttonEdit.classList.add('btn', 'btn-primary', 'col-auto', 'mb-2');
            buttonEdit.dataset.id = id;
            buttonEdit.dataset.nombre = nombre;
            buttonEdit.dataset.artista = artista;
            buttonEdit.dataset.duracion = duracion;
            buttonEdit.dataset.genero = genero;
            buttonEdit.dataset.url = "/song/" + id;
            buttonEdit.dataset.method = "put";

            const buttonDelete = document.createElement('button');
            buttonDelete.textContent = 'Delete Song';
            buttonDelete.classList.add('btn', 'btn-danger', 'col-auto', 'mb-2');
            buttonDelete.dataset.id = id;
            buttonDelete.dataset.url = "/song/" + id;
            buttonDelete.dataset.method = "delete";

            buttonSection.append(buttonEdit, buttonDelete);
        }

        div.appendChild(buttonSection);
        this.parent.appendChild(div);
    }

    #createLabeledElement(label, textContent, additionalClasses = '', id = '') {
        const container = document.createElement('div');
        container.classList.add('mb-2');

        const labelElement = document.createElement('strong');
        labelElement.textContent = label + ': ';
        
        const valueElement = document.createElement('span');
        valueElement.textContent = textContent;
        if (id) valueElement.id = id;
        if (additionalClasses) valueElement.classList.add(...additionalClasses.split(' '));

        container.appendChild(labelElement);
        container.appendChild(valueElement);

        return container;
    }
}
