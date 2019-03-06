<?php
?>
<div id="addUploadFlyerModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="./admin/upload.php" method="post" enctype="multipart/form-data" id="flyerForm">
                <div class="modal-header">
                    <h4 class="modal-title">Adicionar flyer:</h4>
                    <button type="button" class="btn-white" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <input type="file" name="fileToUpload" id="fileToUpload" class="btn btn-default">
                    <input type="button" class="btn btn-white" value="Upload" id="uploadFlyer">
                </div>
            </form>
        </div>
    </div>
</div>