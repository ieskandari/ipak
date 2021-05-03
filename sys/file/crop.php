<?php

?>
<div class="row file-fix">
<div class="file-tools row">
    <i title="<?php  echo T('prev-folder'); ?>" onclick="load_files('<?php echo $data['prev']; ?>');" class="fa fa-reply float-right"></i> 
    </div>
    </div>

    
    <div class="container">
  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li class="nav-item">
      <a class="nav-link active" data-toggle="tab" href="#crop"><?php echo T("crop"); ?>  <i class="fa fa-crop"></i></a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="tab" href="#menu1"><?php echo T("resize"); ?>  <i class="fa fa-arrows"></i></a>
    </li>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div id="crop" class="container tab-pane active"><br>
        <div id="image-img" class="col-half float-right">
          <img id="image-crop" src="<?php echo $data['path-max']; ?>"  class="cropper-hidden">
        </div>
        <div style="padding: 1rem;" class="col-half float-right">
        <div id="result-crop"><canvas width="320" height="179"></canvas></div>
        <p>Data: <span id="data-crop">{"x":634,"y":184,"width":320,"height":180,"rotate":0,"scaleX":1,"scaleY":1}</span></p>
        <button onclick="getCrop();" class="btn btn-primary" type="button-crop" id="button"><?php echo T("crop"); ?></button>
        <button onclick="postcrop();" class="btn btn-primary" type="button-crop" id="button"><?php echo T("save"); ?></button>
        </div>
    </div>
    <div id="menu1" class="container tab-pane fade"><br>
    <div class="input-group-append ">
        <label class="label-group"><?php echo T("width").' : '; ?></label>
                        <input  id="towidth" name="towidth"  value="0" />
                        <button onclick="ajaxResizeImage('<?php echo $data['path']; ?>','<?php echo $data['prev']. $data['newfilename']; ?>','<?php echo $data['prev']; ?>');"  class="btn btn-primary"><?php  echo T('save'); ?></button>
                    </div>
    </div>
  </div>
</div>
<script>
     var image = document.querySelector('#image-crop');
        var data = document.querySelector('#data-crop');
        var result = document.getElementById('result-crop');
var minCroppedWidth = 10;
var minCroppedHeight = 10;
var maxCroppedWidth = $('#image-img').width()*2;
var maxCroppedHeight = $('#image-img').height()*2;
var button = document.getElementById('button-crop');
var cropper = new Cropper(image, {
viewMode: 3,
  data: {
    width: (minCroppedWidth + maxCroppedWidth) / 2,
    height: (minCroppedHeight + maxCroppedHeight) / 2,
  },

  crop: function (event) {
    var width = event.detail.width;
    var height = event.detail.height;

    if (
      width < minCroppedWidth
      || height < minCroppedHeight
      || width > maxCroppedWidth
      || height > maxCroppedHeight
    ) {
      cropper.setData({
        width: Math.max(minCroppedWidth, Math.min(maxCroppedWidth, width)),
        height: Math.max(minCroppedHeight, Math.min(maxCroppedHeight, height)),
      });
    }

    data.textContent = JSON.stringify(cropper.getData(true));
  },
});

 function getCrop() {     
  result.innerHTML = '';
  result.append(cropper.getCroppedCanvas());
}
function postcrop()
{
  uplcrop(cropper.getCroppedCanvas(),'<?php echo  $data['newfilename']; ?>','<?php echo $data['prev']; ?>');
 
}
</script>