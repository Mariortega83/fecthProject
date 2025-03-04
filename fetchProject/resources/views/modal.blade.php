<!-- Modal  para crear -->

<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="createModalLabel">Registra una cancion</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createForm">
                    <div class="mb-3">
                        <label for="createTitle" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="createNombre" name="nombre">
                    </div>
                    <div class="mb-3">
                        <label for="createAuthor" class="form-label">Artista</label>
                        <input type="text" class="form-control" id="createArtista" name="artista">
                    </div>
                    <div class="mb-3">
                        <label for="createDescription" class="form-label">Duracion</label>
                        <input type="text" class="form-control" id="createDuracion" name="duracion"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="createDescription" class="form-label">Genero</label>
                        <input type="text" class="form-control" id="createGenero" name="genero"></textarea>
                    </div>
                
                </form>
            </div>
            <div class="alert alert-warning" role="alert" id="modalCreateWarning">An error ocurred. The song has not been created.</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="modalCreateButton">Create</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal  para crear fin -->

<!-- Modal  para editar -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editModalLabel">Edit Song</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editForm">
                    <div class="mb-3">
                        <label for="editNombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="editNombre" name="nombre">
                    </div>
                    <div class="mb-3">
                        <label for="editArtista" class="form-label">Artista</label>
                        <input type="text" class="form-control" id="editArtista" name="artista">
                    </div>
                    <div class="mb-3">
                        <label for="editDuracion" class="form-label">Duracion</label>
                        <input type="text" class="form-control" id="editDuracion" name="duracion">
                    </div>
                    <div class="mb-3">
                        <label for="editGenero" class="form-label">Genero</label>
                        <input type="text" class="form-control" id="editGenero" name="genero">
                    </div>
                </form>
            </div>
            <div class="alert alert-warning" role="alert" id="modalEditWarning">An error occurred. The song has not been edited.</div>
            <div class="modal-footer">
                
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="modalEditButton" >Edit</button>
                
            </div>
        </div>
    </div>
</div>
<!-- Modal  para editar fin -->

<!-- View Modal -->
<div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="viewModalLabel"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="viewModalBody">
                <form id="viewForm">
                    <div class="mb-3">
                        <ul class="list-group" id="viewSongs"></ul>
                    </div>
                </form>
            </div>
            <div class="alert alert-warning" role="alert" id="modalViewWarning">An error ocurred. Product not found.</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
