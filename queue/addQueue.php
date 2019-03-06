<?php
?>
<div id="addQueueModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form name="create_event" id="create_event">
                <div class="modal-header">
                    <h4 class="modal-title">Adicionar musica na fila:</h4>
                    <button type="button" class="btn-white" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="form-group">
                            <label>Convidado:</label>
                            <input type="text" name="convidado" id="convidado" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Categoria:</label>
                            <select id="categoria">
                                <option value="NAC">Nacional</option>
                                <option value="INTER">Internacional</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Codigo da Musica:</label>
                            <input type="text" name="musica" id="musica" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="background-color: #fff">
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancelar"
                           id="cancelOrder">
                    <input type="button" class="btn btn-white" value="Adicionar" id="insertQueue">
                </div>
            </form>
        </div>
    </div>
</div>
