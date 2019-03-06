<?php
?>
<div id="addUploadListModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="./admin/upload.php" method="post" enctype="multipart/form-data" id="listForm">
                <div class="modal-header">
                    <h4 class="modal-title">Adicionar Lista CSV:</h4>
                    <button type="button" class="btn-white" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <div style="text-align: left">
                        <label>Nacional:</label><br/>
                        <input type="file" name="fileToUpload1" id="fileToUpload1" class="btn btn-default">
                        <label>Internacional:</label><br/>
                        <input type="file" name="fileToUpload2" id="fileToUpload2" class="btn btn-default">
                    </div>
                    <br/>
                    <input type="button" class="btn btn-white" value="Upload" id="uploadList">
                </div>
            </form>
        </div>
    </div>
</div>