<div class="row file-fix">
    <div class="file-map">
        <?php
        $i = 0;
        foreach ($data['map'] as $dir) {
        ?>
            <label onclick="load_files('<?php echo $dir['path']; ?>');">
                <?php if ($i == 0) { ?>
                    <i class="fa fa-home">/</i>
                <?php } else { ?>
                <?php echo $dir['name'] . '/';
                } ?></label>
        <?php
            $i++;
        }
        ?>
    </div>
    <div class="file-tools row">
        <i title="<?php echo T('file-refresh'); ?>" onclick="load_files('<?php echo $data['current1']; ?>');" class="fa fa-refresh float-right"></i>
        <i title="<?php echo T('prev-folder'); ?>" onclick="load_files('<?php echo $data['prev']; ?>');" class="fa fa-reply float-right"></i>
        <i title="<?php echo T('new-folder'); ?>" onclick="showRegisterFolder();" class="fa fa-plus float-right"></i>
        <div class="input-group  float-right col-md-3">
            <input type="text" class="form-control" placeholder="<?php echo T('new-folder'); ?>" id="register-folder" name="register-folder">
            <div class="input-group-append ">
                <input placeholder="نام پوشه" type="hidden" id="file-current" name="file-current" value="<?php echo $data['current']; ?>" />
                <button onclick="ajaxRegisterFolder();" class="btn btn-light">ذخیره</button>
            </div>
        </div>
        <script>
            showRegisterFolder(0);
        </script>
        <i title="<?php echo T('delete-files'); ?>" onclick="deleteFileTick();" class="fa fa-trash float-right"></i>
        <i title="<?php echo T('upload-files'); ?>" onclick="$('#file-upload').click();" class="fa fa-upload float-right"></i>
        <input data="<?php echo str_replace(BasePath,'',$data['current']); ?>" onchange="upl_image($(this));" id="file-upload" name="file-upload" type="file" style="display:none;" accept="image/*" />
        <div id="file-alert" class="float-right"> </div>
        <div class="progress myprogress-bar">
            <div class="progress-bar progress-bar-striped active float-right" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:0%">
                0%
            </div>
        </div>
    </div>
</div>
<div id="files-content" class="row file-content">
    <div onclick="load_files('<?php echo $data['prev']; ?>');" title="<?php echo T('prev-folder'); ?>" class="ic-file ic-file-folder">
        <i class="fa fa-folder"></i>
        <label>..</label>
    </div>
    <?php
    foreach ($data['dirs'] as $dir) {
    ?>
        <div onmouseover="showFileTick($(this));" onmouseout="showFileTick($(this));" id="<?php if ($data['created'] == $dir['filename']) {
                                                                                                echo 'into-content';
                                                                                            } ?>" title="<?php echo $dir['filename']; ?>" class="ic-file ic-file-folder <?php if ($data['created'] == $dir['filename']) {
                                                                                                                                                                                                                                            echo 'ic-file-created';
                                                                                                                                                                                                                                        } ?>">
            <input path="<?php echo str_replace(BaseUrl,'',$dir['path']); ?>" class="file-tick" type="checkbox" />
            <i onclick="load_files('<?php echo str_replace(BaseUrl,'',$dir['path']); ?>');" class="fa fa-folder"></i>
            <label><?php echo $dir['filename']; ?></label>
        </div>
    <?php
    }
    foreach ($data['files'] as $dir) {
    ?>
        <div onmouseover="showFileTick($(this));" onmouseout="showFileTick($(this));" id="<?php if ($data['created'] == $dir['filename']) {
                                                                                                echo 'into-content';
                                                                                            } ?>" title="<?php echo $dir['filename']; ?>" class="ic-file ic-file-img <?php if ($data['created'] == $dir['filename']) {
                                                                                                                                                                                                                                            echo 'ic-file-created';
                                                                                                                                                                                                                                        } ?>">
            <input path="<?php echo str_replace(BaseUrl,'',$dir['path']); ?>" class="file-tick" type="checkbox" />
           <a href="<?php echo $dir['path-max']; ?>" title="مشاهده تصویر" target="_blank" class="link-img"><i class="fa fa-eye"></i></a>
            <img <?php if (strlen($data['select']) > 0) {
                        echo 'onclick="SelectedImage($(this));"';
                    } ?> <?php echo $data['select']; ?> src="<?php echo $dir['path']; ?>" />
            <label><?php echo $dir['filename']; ?></label>
        </div>
    <?php
    }
    ?>
</div>