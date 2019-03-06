<?php
?>
<div id="addEventModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form name="create_event" id="create_event">
                <div class="modal-header">
                    <h4 class="modal-title">Adicionar evento:</h4>
                    <button type="button" class="btn-white" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="form-group">
                            <label>Data:</label>
                            <input type="text" name="data" id="datepicker" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Hora:</label>
                            <input type="text" name="hora" id="timepicker" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Local:</label>
                            <textarea name="local" id="local" class="form-control" required></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Upload Flyer:</label>
                        <input type="button" name="btnFlyer" id="btnFlyer" class="btn btn-default" value="Upload"></input>
                    </div>
                </div>
                <div class="modal-footer" style="background-color: #fff">
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancelar"
                           id="cancelOrder">
                    <input type="button" class="btn btn-white" value="Adicionar" id="insertEvent">
                </div>
            </form>
        </div>
    </div>
</div>