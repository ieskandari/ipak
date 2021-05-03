
<?php
function delete_modal()
{
?>
<!-- Modal -->
<div class="modal fade modal-danger" id="delete-modal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><?php echo _T("delete-title"); ?></h4>
        </div>
        <div class="modal-body">
          <p></p>
        </div>
        <div class="modal-footer">
           <a  class="btn btn-success ok-btn"><?php echo _T("ok"); ?></a>
          <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo _T("cancel"); ?></button>
        </div>
      </div>
      
    </div>
  </div>
  <?php }
  add_action("footer_scripts", "delete_modal");
  ?>