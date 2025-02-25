import HttpClient from './HttpClient.js';
import ResponseContent from './ResponseContent.js';
import ResponseRow from './ResponseRow.js';

export default class ModalEvents {
  constructor(url, csrf) {
    this.url = url;
    this.csrf = csrf;

    // Elementos principales de la página
    this.content = document.getElementById('content');
    this.userContent = document.getElementById('userContent');
    this.paginationContent = document.getElementById('paginationContent');
    this.responseContent = new ResponseContent(this.content, this.paginationContent, this.userContent);

    this.fetchUrl = '';
    this.httpClient = new HttpClient(this.url, this.csrf);
    this.ResponseRow = new ResponseRow(this.content, this.url);

    // Modal para ver canciones (en este caso se muestran en una lista)
    this.modalView = document.getElementById('viewModal');

    // Modal para Crear Canción
    this.modalCreate = document.getElementById('createModal');
    this.modalCreateButton = document.getElementById('modalCreateButton');
    this.createNombre = document.getElementById('createNombre');
    this.createArtista = document.getElementById('createArtista');
    this.createDuracion = document.getElementById('createDuracion');
    this.createGenero = document.getElementById('createGenero');

    // Modal para Editar Canción
    this.modalEdit = document.getElementById('editModal');
    this.modalEditButton = document.getElementById('modalEditButton');
    this.editNombre = document.getElementById('editNombre');
    this.editArtista = document.getElementById('editArtista');
    this.editDuracion = document.getElementById('editDuracion');
    this.editGenero = document.getElementById('editGenero');

    // Elemento para mostrar mensajes
    this.messageElement = document.getElementById('message');

    this.assignEvents();
  }

  assignEvents() {
    // --- Modal de Ver Canciones ---
    this.modalView.addEventListener('show.bs.modal', event => {
      this.fetchUrl = event.relatedTarget.dataset.url;
      const title = event.relatedTarget.dataset.title;
      this.httpClient.get(this.fetchUrl, {}, data => this.responseReview(data, title));
    });

    // --- Modal de Crear Canción ---
    this.modalCreate.addEventListener('show.bs.modal', event => {
      this.fetchUrl = event.relatedTarget.dataset.url;
      // Limpiar campos
      this.createNombre.value = '';
      this.createArtista.value = '';
      this.createDuracion.value = '';
      this.createGenero.value = '';
    });

    this.modalCreateButton.addEventListener('click', event => {
      // Ocultar alerta de error (si está visible)
      const warning = document.getElementById('modalCreateWarning');
      if (warning) warning.style.display = 'none';

      this.httpClient.post(
        this.fetchUrl,
        {
          nombre: this.createNombre.value,
          artista: this.createArtista.value,
          duracion: this.createDuracion.value,
          genero: this.createGenero.value,
        },
        data => this.responseCreate(data)
      );
    });

    // --- Modal de Editar Canción ---
    this.modalEdit.addEventListener('show.bs.modal', event => {
      const button = event.relatedTarget;
      this.fetchUrl = button.dataset.url;
      this.editNombre.value = button.dataset.nombre;
      this.editArtista.value = button.dataset.artista;
      this.editDuracion.value = button.dataset.duracion;
      this.editGenero.value = button.dataset.genero;
    });

    this.modalEditButton.addEventListener('click', event => {
      const warning = document.getElementById('modalEditWarning');
      if (warning) warning.style.display = 'none';

      this.httpClient.put(
        this.fetchUrl,
        {
          nombre: this.editNombre.value,
          artista: this.editArtista.value,
          duracion: this.editDuracion.value,
          genero: this.editGenero.value,
        },
        data => this.responseEdit(data)
      );
    });

    // --- Botón de Borrar Canción ---
    this.content.addEventListener('click', event => {
      if (event.target.dataset.method === 'delete') {
        const url = event.target.dataset.url;
        this.httpClient.delete(url, {}, data => this.responseDelete(data));
      }
    });

    const logoutLink = document.getElementById('logoutLink');
    if (logoutLink) {
      logoutLink.addEventListener('click', event => {
        event.preventDefault();
        document.getElementById('logout-form').submit();
      });
    }
  }

  responseReview(song) {
    console.log(song);
    const modalTitle = this.modalView.querySelector('.modal-title');
    const modalBody = this.modalView.querySelector('.modal-body');

    modalTitle.textContent = song.song.nombre;
    modalBody.innerHTML = `
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">${song.song.nombre}</h5>
          <p class="card-text"><strong>Artist:</strong> ${song.song.artista}</p>
          <p class="card-text"><strong>Duration:</strong> ${song.song.duracion}</p>
          <p class="card-text"><strong>Genre:</strong> ${song.song.genero}</p>
        </div>
      </div>
    `;
  }

  formattedDate(date) {
    date = new Date(date);
    return `${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, '0')}-${String(
      date.getDate()
    ).padStart(2, '0')}`;
  }

  responseCommonContent(data) {
    this.responseContent.setContent(data);
  }

  responseCreate(data) {
    if (data.result) {
      // Canción creada correctamente
      bootstrap.Modal.getInstance(this.modalCreate).hide();
      this.responseCommonContent(data);
    } else {
      const warning = document.getElementById('modalCreateWarning');
      if (warning) {
        warning.style.display = 'block';
        setTimeout(() => {
          warning.style.display = 'none';
        }, 4000);
      }
    }
  }

  responseEdit(data) {
    if (data.result) {
      bootstrap.Modal.getInstance(this.modalEdit).hide();
      this.responseCommonContent(data);
    } else {
      const warning = document.getElementById('modalEditWarning');
      if (warning) {
        warning.style.display = 'block';
        setTimeout(() => {
          warning.style.display = 'none';
        }, 4000);
      }
    }
  }

  responseDelete(data) {
    if (data.result) {
      this.responseCommonContent(data);
      this.showMessage(data.message, 'success');
    } else {
      this.showMessage(data.message, 'danger');
    }
  }

  responseReload(data) {
    if (data.result) {
      location.reload();
    } else {
      // Para errores en Login o Registro se usa la alerta compartida en el modal (modalViewWarning)
      const warning = document.getElementById('modalViewWarning');
      if (warning) {
        warning.style.display = 'block';
        setTimeout(() => {
          warning.style.display = 'none';
        }, 4000);
      }
    }
  }

  fillViewModal(song) {
    const modalTitle = this.modalView.querySelector('.modal-title');
    const modalBody = this.modalView.querySelector('.modal-body');

    modalTitle.textContent = song.nombre;
    modalBody.innerHTML = `
      <p><strong>Artist:</strong> ${song.artista}</p>
      <p><strong>Duration:</strong> ${song.duracion}</p>
      <p><strong>Genre:</strong> ${song.genero}</p>
    `;
  }

  showMessage(message, type) {
    this.messageElement.innerHTML = `<div class="alert alert-${type}" role="alert">${message}</div>`;
    setTimeout(() => {
      this.messageElement.innerHTML = '';
    }, 4000);
  }

  init() {
    // Cambia el endpoint a '/song' o al que corresponda en tu backend
    this.httpClient.get('/song', {}, data => {
      this.responseCommonContent(data);
    });
  }
}