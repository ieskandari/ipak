var image = document.querySelector('#image-crop');
var data = document.querySelector('#data-crop');

var result = document.getElementById('result-crop');
var minCroppedWidth = 320;
var minCroppedHeight = 160;
var maxCroppedWidth = 640;
var maxCroppedHeight = 320;
var button = document.getElementById('button-crop');
window.addEventListener('DOMContentLoaded', function () {

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

button.onclick = function () {     
  result.innerHTML = '';
  result.appendChild(cropper.getCroppedCanvas());
};
});