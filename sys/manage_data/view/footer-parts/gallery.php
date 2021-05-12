<div class="modal fade" id="filemanager">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">مدیریت فایل</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div id="file-body" class="modal-body file-body">
                    <div class="modal-body-cont"></div>
                    <div class="loader"></div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">بستن</button>
                </div>

            </div>
        </div>
    </div>
    <script src="<?php echo BaseUrl; ?>content/js/cropper.js"></script>
    <script src="<?php echo BaseUrl; ?>content/js/autosize.js"></script>
    <script src="<?php echo BaseUrl; ?>content/js/image-compressor.js"></script>
    <script src="<?php echo BaseUrl; ?>content/js/file-manager.js"></script>