function uplImg(file,obj,input_id,img_id) {
    var qu=0.8;
    if(file.size>200000)
    {
     qu=0.6;
    }
    if(file.size>400000)
    {
     qu=0.5;
    }
    if(file.size>500000)
    {
     qu=0.4;
    }
    if(file.size>1000000)
    {
     qu=0.1;
    }
     var get_file='';
     new ImageCompressor(file, {
         quality: qu,
         success(result) {
      
             const fileData = new FormData();
 
             fileData.append('fileInput', result, result.name);
             $.ajax({
                 type: "POST",
                 url:'?file_upload=img'+get_file,
                 dataType: 'json',
                 contentType: false, // Not to set any content header
                 processData: false, // Not to process data
                 data: fileData,
                 xhr: function() { // custom xhr
                     myXhr = $.ajaxSettings.xhr();
                     if (myXhr.upload) { // check if upload property exists
                         myXhr.upload.addEventListener('progress', function(e) {
 
                             var percent_complete = (e.loaded / e.total) * 100;
                             // Percentage of upload completed
                             var pers = Math.round(percent_complete);
                             $('.progress-bar').html(pers + '%');
                             $('.progress-bar').css('width', pers + '%');
                             // console.log(percent_complete);
                         }, false); // for handling the progress of the upload
                     }
 
                     return myXhr;
                 },
                 success: function(result, status, xhr) {
                     console.log(result);
                     if (result.ok == 1) {
                             $('#'+input_id).val(result.file);
                             $('#'+img_id).attr('src',BaseUrl+'upload/'+result.file);
                             $('#'+img_id).css('display','block');
                     } else {
                        alert('خطای آپلود فایل');
                     }
                     $('.myprogress-bar').css('display','none');
             
                 },
                 error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                     $('.myprogress-bar').css('display','none');
                 }
             });
         },
         error(e) {
             alert('خطای 3');
             console.log(e.message);
         },
     });
 }
     function fileUpload(file,obj,input_id,img_id) {
         var reader = new FileReader();
         var get_file='';
         get_file='&is_file=1';
         reader.onloadend = function() {
 
 
             var fileData = new FormData();
             fileData.append("fileInput", file);
             $.ajax({
                 type: "POST",
                 url: '?file_upload=img'+get_file,
                 dataType: 'json',
                 contentType: false, // Not to set any content header
                 processData: false, // Not to process data
                 data: fileData,
                 xhr: function() { // custom xhr
                     myXhr = $.ajaxSettings.xhr();
                     if (myXhr.upload) { // check if upload property exists
                         myXhr.upload.addEventListener('progress', function(e) {
                             var percent_complete = (e.loaded / e.total) * 100;
                             // Percentage of upload completed
                             var pers = Math.round(percent_complete);
                             $('.progress-bar').html(pers + '%');
                             $('.progress-bar').css('width', pers + '%');
                             // console.log(percent_complete);
                         }, false); // for handling the progress of the upload
                     }
 
                     return myXhr;
                 },
                 success: function(result, status, xhr) {
                      console.log(result);
                             $('#'+input_id).val(result.file);
                             $('#'+img_id).html(result.file);
                             $('#'+img_id).css('display','block');
 
 
                     $('.myprogress-bar').css('display','none');
             
                 },
                 error: function(xhr, status, error) {
                     alert(error);
                     $('.myprogress-bar').css('display','none');
                 }
             });
 
         }
         reader.readAsDataURL(file);
     }
 function upl_image(obj,input_id,img_id) {
     $('.myprogress-bar').css('display','block');
     var files = obj.get(0).files;
     for (var i = 0; i < files.length; i++) {
         uplImg(files[i], obj,input_id,img_id);
         //resizeAndUploadImage(files[i], obj);
     }
 }
 function upl_file(obj,input_id,img_id) {
  
     $('.myprogress-bar').css('display','block');
     var files = obj.get(0).files;
     for (var i = 0; i < files.length; i++) {
         fileUpload(files[i], obj,input_id,img_id);
         //resizeAndUploadImage(files[i], obj);
     }
 }
 function delete_file(file)
 {
    $.ajax({
        type: "POST",
        url:'?file_upload=img&del_file='+file,
        dataType: 'json',
        contentType: false, // Not to set any content header
        processData: false, // Not to process data
        data: fileData,
        xhr: function() { // custom xhr
          
        },
        success: function(result, status, xhr) {
            console.log(result);
        },
        error: function(xhr, status, error) {
        }
    });
 }