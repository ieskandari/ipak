function CloseModal(obj) {
    $('#' + obj).modal('hide');
}


function displayNone(x) {
    x.getElementsByTagName("div")[0].style.opacity = "1";
}

function displayBlock(x) {
    x.getElementsByTagName("div")[0].style.opacity = "0";
}

function tick($obj) {
    var table = document.getElementsByTagName("table")[0];
    var row = table.getElementsByTagName("tbody")[0].getElementsByTagName("tr");
    for ($x = 0; $x < row.length; $x++) {
        row[$x].getElementsByTagName("td")[0].getElementsByTagName("input")[0].checked = $obj.checked;
    }
}
autosize(document.querySelectorAll('textarea'));
//
function ajaxResizeImage(file, newfile, input) {
    if ($('#towidth').val() <= 0) {
        return;
    }
    $.ajax({
        type: "POST",
        url:BasePath+ "file/postcrop",
        data: { 'towidth': $('#towidth').val(), 'filename': file, 'newfilename': newfile },
        cache: false,
        success: function(data) {
            load_files(input);
        }
    });
}
//
//
function load_files(obj) {
    url =BaseUrlModel+"?file_upload=1&gallery=1&action=index&input=" + obj.trim();
 //   url = url.replace(/\S/g, '__________');
    loadAction(url);
}
var objSelectImage;
var objSelectImageIsEditor;

function load_files_select(obj, editor) {
    objSelectImageIsEditor = editor;
    objSelectImage = obj;
    url =BaseUrlModel+"?file_upload=1&gallery=1&action=index&input=";
    console.log(url);
  //  url = url.replace(/\S/g, '__________');
    loadAction(url);
} 


function SelectedImage(obj) {

    objSelectImage.attr('src', obj.attr('src'));
    var parent = objSelectImage.parent().parent();
    var parent1 = objSelectImage.parent();
    var inputs = $('#' + parent.attr('id') + ' input');
    var data_name = '';
    if (inputs.length > 0) {
        var nameLast = inputs.last().attr('id');
        nameLast = nameLast.replace(objSelectImage.attr('data-name') + '_', '');
        var int = parseInt(nameLast) + 1;
        data_name = objSelectImage.attr('data-name') + '_' + int;
    } else {
        data_name = objSelectImage.attr('data-name') + '_0';
    }
    parent1.append('<input type="hidden" id="' + data_name + '" name="' + data_name + '" value="' + obj.attr('src').replace(BaseUrl+'np-content/uploads/','') + '" />');

    if ($('#created').length > 0) {
        if (objSelectImageIsEditor == 1) {
            $('#created').attr('id', '');
        }
    }
    if ($('#created-p').length > 0) {
        $('#created-p').attr('id', '');
    }

}

function loadAction(input) {
    url = input;
    $('#filemanager .loader').css('display', 'block');
    $('#filemanager .modal-body-cont').load(url);
    $('#filemanager .loader').css('display', 'none');
}

function deleteFileTick() {
    //  alert($('#file-body input:checked').length);
    $('#file-body input:checked').each(function(index) {
        ajaxDeleteFolder($(this).attr('path'))
    });
}

function showFileTick(obj) {
    if (obj.children('input:checked').length == 0) {
        obj.children('.file-tick').toggle();
    }
    obj.children('.file-btn-edit').toggle();
}

function showRegisterFolder(obj = 500) {
    $('.file-tools .input-group').toggle(obj);
}

function showIconBlock(obj, show) {
    return;
    if (show == 1) {
        obj.children('.article').show();
    } else {
        obj.children('.article').hide();
    }

}

function getSelectedText() {
    if (window.getSelection) {
        return window.getSelection().toString();
    } else if (document.getSelection) {
        return document.getSelection();
    } else if (document.selection) {
        return document.selection.createRange().text;
    }
}
var selectedText;
var selectedBlock = '0';

function replaceAll(str, find, replace) {
    return str.replace(new RegExp(find, 'g'), replace);
}

function pasteHtmlAtCaret(html) {
    var sel, range;
    if (window.getSelection) {
        // IE9 and non-IE
        sel = window.getSelection();
        if (sel.getRangeAt && sel.rangeCount) {
            range = sel.getRangeAt(0);
            range.deleteContents();

            // Range.createContextualFragment() would be useful here but is
            // non-standard and not supported in all browsers (IE9, for one)
            var el = document.createElement("div");
            el.innerHTML = html;
            var frag = document.createDocumentFragment(),
                node, lastNode;
            while ((node = el.firstChild)) {
                lastNode = frag.appendChild(node);
            }
            range.insertNode(frag);

            // Preserve the selection
            if (lastNode) {
                range = range.cloneRange();
                range.setStartAfter(lastNode);
                range.collapse(true);
                sel.removeAllRanges();
                sel.addRange(range);
            }
        }
    } else if (document.selection && document.selection.type != "Control") {
        // IE < 9
        document.selection.createRange().pasteHTML(html);
    }
}

function showBlockArticle(obj, pre) {
    hideBlockArticle(pre, 'block', 'none');
    $('#' + pre + '-article-block #' + pre + '-' + obj).css('display', 'block');
}

function hideBlockArticle(pre, BlockORhide, BlockORhide1) {
    $('#' + pre + '-article-block').css('display', BlockORhide);
    $('#' + pre + '-article-block .option-item').css('display', BlockORhide1);
}

function addBlockHeader(hh, pre) {
    document.getElementById(pre + '-div').focus();

    pasteHtmlAtCaret('<' + hh + ' onclick="selectedBlockEvent($(this))">' + 'Title' + '</' + hh + '>');
    hideBlockArticle(pre, 'none', 'none');
}

function addBlockLink(pre) {
    $('#created').remove();
    document.getElementById(pre + '-div').focus();
    pasteHtmlAtCaret('<a id="created" href="' + $('#' + pre + '-link-link').val() + '">' + $('#' + pre + '-link-title').val() + '</a>');
    showBlockArticle('option-link', pre)
}

function addBlockLinkInter(pre) {
    document.getElementById(pre + '-div').focus();
    $('#created').html($('#' + pre + '-link-title').val());
    $('#created').attr('href', $('#' + pre + '-link-link').val());
    $('#created').attr('id', '');
    hideBlockArticle(pre, 'none', 'none');
}

function addBlockParagraph(pre) {
    document.getElementById(pre + '-div').focus();
    pasteHtmlAtCaret('<p>paragraph</p>');
    $('#created').remove();
    hideBlockArticle(pre, 'none', 'none');
}

function addBlockList(pre) {
    document.getElementById(pre + '-div').focus();
    pasteHtmlAtCaret('<ul><li></li></ul>');
    $('#created').remove();
    hideBlockArticle(pre, 'none', 'none');
}

function addBlockImage(pre) {
    document.getElementById(pre + '-div').focus();
    $('#created').remove();
    var str_src = $('#' + pre + '-image-name').attr('src');
    str_src = str_src.replace('uploads', 'uploads-max');
    pasteHtmlAtCaret('<img id="created" style="width:' + $('#' + pre + '-image-width').val() + 'px;height:' + $('#' + pre + '-image-height').val() + 'px;" src="' + str_src + '" />');
    showBlockArticle('option-image', pre)
}

function addBlockImageInter(pre) {
    document.getElementById(pre + '-div').focus();
    var str_src = $('#' + pre + '-image-name').attr('src');
    str_src = str_src.replace('uploads/', 'uploads-max/');
    $('#created').attr('src', str_src);
    $('#created').css('width', $('#' + pre + '-image-width').val());
    $('#created').css('height', $('#' + pre + '-image-height').val());
    $('#created').attr('id', '');
    hideBlockArticle(pre, 'none', 'none');
}

function selectedBlockEvent(obj) {
    selectedBlock = obj;
}

function addBlockToDiv(obj) {
    var prarentDiv = obj.parent();
    //  prarentDiv.append(getSelection1());
    var par = prarentDiv.children('.textarea-div').html();
    selectedText = selectedText.trim();
    selectedText = '' + selectedText + '';
    // par=par.replace(selectedText,'<a href="#">'+selectedText+'</a>'); 
    par = replaceAll(par, selectedText, '<a href="#">' + selectedText + '</a>');
    prarentDiv.children('.textarea-div').html(par);


}

function AddImageToPost(obj, src, name, ismore) {
    $('#created-p').remove();
    var strImg = '<div onmouseover="ShowRemoveButtonImagePost($(this),1);" onmouseout="ShowRemoveButtonImagePost($(this),0);" id="created-p" class="img gallery-img-item">' +
        '<i onclick="RemoveImagePost($(this));" class="fa fa-remove img-remove"></i>' +
        '<img src="' + src + '" data-name="' + name + '" id="created"  />' +
        '</div>';
    if (ismore === '0') {
        obj.html(strImg);
    } else {
        obj.append(strImg);
    }

    load_files_select($('#created'), 1);
}

function ShowRemoveButtonImagePost(obj, show) {
    if (show === 1) {
        obj.children('i').css('display', 'block');
    } else {
        obj.children('i').css('display', 'none');
    }

}

function RemoveImagePost(obj) {
    var parent = obj.parent();
    parent.remove();
}

function highlightSelected() {

    var selection = getSelectedText();
    if (selection.length >= 3) {
        selectedText = selection;
    }
}

function ajaxDeleteFolder(path) {
    var folder = path;
  
    $.ajax({
        type: "GET",
        url: BaseUrlModel+"?file_upload=1&gallery=1&action=deletefolder",
        data: { 'folder': folder, 'path': $('#file-current').val() },
        cache: false,
        success: function(item) {
            if (item != 'error') {
                load_files(item);
            } else {
                alert('Error');
            }
        }
    });
}

function ajaxRegisterFolder() {
    var folder = $("#register-folder").val();
    $.ajax({
        type: "GET",
        url: BaseUrlModel+"?file_upload=1&gallery=1&action=registerfolder",
        data: { 'folder': folder, 'path': $('#file-current').val() },
        cache: false,
        success: function(item) {
            if (item != 'error') {
                var t=''+item;
             
                load_files(t);
            } else {
                alert('خطا در آپلود فایل');
            }
        }
    });
}

function scrollTo(element, to, duration) {
    var start = element.scrollTop,
        change = to - start,
        currentTime = 0,
        increment = 20;

    var animateScroll = function() {
        currentTime += increment;
        var val = Math.easeInOutQuad(currentTime, start, change, duration);
        element.scrollTop = val;
        if (currentTime < duration) {
            setTimeout(animateScroll, increment);
        }
    };
    animateScroll();
}
Math.easeInOutQuad = function(t, b, c, d) {
    t /= d / 2;
    if (t < 1) return c / 2 * t * t + b;
    t--;
    return -c / 2 * (t * (t - 2) - 1) + b;
};

function dataURLtoFile(dataurl, filename) {
    var arr = dataurl.split(','),
        mime = arr[0].match(/:(.*?);/)[1],
        bstr = atob(arr[1]),
        n = bstr.length,
        u8arr = new Uint8Array(n);
    while (n--) {
        u8arr[n] = bstr.charCodeAt(n);
    }
    return new File([u8arr], filename, { type: mime });
}

function resizeAndUploadImage(file, obj) {
    var filename = file.name;
    var reader = new FileReader();
    reader.onloadend = function() {

        var tempImg = new Image();
        tempImg.src = reader.result;
        tempImg.onload = function() {

            var MAX_WIDTH = 1200;
            var tempW = tempImg.width;
            var tempH = tempImg.height;
            var MAX_HEIGHT = (tempH * MAX_WIDTH) / tempW;
            if (tempW > tempH) {
                if (tempW > MAX_WIDTH) {
                    tempH *= MAX_WIDTH / tempW;
                    tempW = MAX_WIDTH;
                }
            } else {
                if (tempH > MAX_HEIGHT) {
                    tempW *= MAX_HEIGHT / tempH;
                    tempH = MAX_HEIGHT;
                }
            }

            var canvas = document.createElement('canvas');
            canvas.width = tempW;
            canvas.height = tempH;
            var ctx = canvas.getContext("2d");
            ctx.drawImage(this, 0, 0, tempW, tempH);
            var dataURL = canvas.toDataURL("image/jpg");

            var fileData = new FormData();
            var file = dataURLtoFile(dataURL, filename);
            fileData.append("fileInput", file);
            //alert(BasePath+ 'file/uplimage?url=' + obj.attr('data'));
            $.ajax({
                type: "POST",
                url:BasePath+ 'file/uplimage?url=' + obj.attr('data'),
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
                   
                    if (result.ok == 1) {
                        $('#files-content').append(result.data);
                        $('#file-alert').html(result.message);
                    } else {
                        $('#file-alert').html(result.message);
                    }
                    $('.myprogress-bar').toggle();
                    $('#file-alert').fadeIn(1000);
                },
                error: function(xhr, status, error) {

                }
            });
        }

    }
    reader.readAsDataURL(file);
}
function uplNew(file,obj) {
    new ImageCompressor(file, {
        quality: 0.9,
        success(result) {
     
            const fileData = new FormData();

            fileData.append('fileInput', result, result.name);
            $.ajax({
                type: "POST",
                url:BaseUrlModel+"?file_upload=1&gallery=1&action=uplimage&url="+ obj.attr('data') ,
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
                   
                    if (result.ok == 1) {
                        $('#files-content').append(result.data);
                        $('#file-alert').html(result.message);
                    } else {
                        $('#file-alert').html(result.message);
                    }
                    $('.myprogress-bar').toggle();
                    $('#file-alert').fadeIn(1000);
                },
                error: function(xhr, status, error) {

                }
            });
        },
        error(e) {
            console.log(e.message);
        },
    });
}
function upl_image(obj) {
    $('.myprogress-bar').toggle(1000);
    $('#file-alert').fadeOut(100);
    var files = obj.get(0).files;
    for (var i = 0; i < files.length; i++) {
       uplNew(files[i], obj);
        //resizeAndUploadImage(files[i], obj);
    }
}

function uplcrop(objcanvas, filename, objpath) {
//     console.log(filename);
//   console.log(objpath);
    var dataURL = objcanvas.toDataURL("image/jpg");

    var fileData = new FormData();
    var file = dataURLtoFile(dataURL, filename);
    fileData.append("fileInput", file);

    $.ajax({
        type: "POST",
        url:BasePath+ 'file/uplimage?url=' + objpath,
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
                    // $('.progress-bar').html(pers + '%');
                    //  $('.progress-bar').css('width', pers + '%');
                    // console.log(percent_complete);
                }, false); // for handling the progress of the upload
            }

            return myXhr;
        },
        success: function(result, status, xhr) {
            if (result.ok == 1) {
                load_files('' + objpath);
            } else {
                alert('error');
            }
            //  $('.myprogress-bar').toggle();
            //    $('#file-alert').fadeIn(1000);
        },
        error: function(xhr, status, error) {

        }
    });
}

function DivToTextarea() {
    $('#form-input .textarea-div').each(function(index) {
        var hvalue = $(this).html();
        localStorage.setItem($(this).attr('data-name'),hvalue);
        $('#form-input').append('<textarea style="display:none;" id="' + $(this).attr('data-name') + '" name="' + $(this).attr('data-name') + '">' + hvalue + '</textarea>');
    });
}
function CopyFromClip(obj)
{
    var h_val=localStorage.getItem(obj.attr('data-name'));
    $('#'+obj.attr('data-name')+'-div').html(h_val);
}
var toggler = document.getElementsByClassName("caret");
var i;

for (i = 0; i < toggler.length; i++) {
    toggler[i].addEventListener("click", function() {
        this.parentElement.querySelector(".nested").classList.toggle("active");
        this.classList.toggle("caret-down");
    });
}

function SearchTags(obj) {
    $('#box-tags').children('.checkbox').each(function() {
        if ($(this).children('label').text().indexOf(obj.val()) === -1) {
            $(this).css('display', 'none');
        } else {
            $(this).css('display', 'block');
        }
    });
}

function SearchCats(obj) {
    $('#box-cats .checkbox').each(function() {
        if ($(this).children('label').text().indexOf(obj.val()) === -1) {
            $(this).css('display', 'none');
        } else {
            $(this).css('display', 'block');
            $(this).parentsUntil("div").css('display', 'block');
        }
    });
}