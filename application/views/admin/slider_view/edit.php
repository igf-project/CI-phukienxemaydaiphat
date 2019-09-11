<?php
    $base_url = base_url().'admin/Slider/';

    if($slider_data['image']==''){
        $thumb = $this->config->item('THUMB_DEFAULT');
    }else{
        $thumb = base_url().$slider_data['image'];
    }
?>
<div id="path">
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url()?>admin">Admin</a></li>
        <li><a href="<?php echo $base_url ?>">Slider</a></li>
        <li class="active">Sửa slider</li>
    </ol>
</div>
<div id="action">
    <small>Các mục đánh dấu <font color="red">*</font> là thông tin bắt buộc</small><hr/>
    <form method="post" action="<?php echo $base_url ?>do_edit" enctype="multipart/form-data">
        <input type="hidden" name="txtid" value="<?php echo $id;?>">
        <div class="row">
            <div class='form-group col-md-6'>
                <label>Hình ảnh</label><font color="red">*</font>
                <input name="txt_name" type="text" id="txt_name" size="45" class='form-control' value="<?php echo $slider_data['name']?>" placeholder='Tên slide'/>
            </div>
            <div class='form-group col-sm-6'>
                <label class="control-label">Link</label>
                <input name="txt_link" type="text" id="txt_link" size="45" class='form-control' <?php echo $slider_data['link']?> placeholder='Link'/>
            </div>
            <div class='form-group col-sm-6'>
                <label class="control-label">Mô tả</label>
                <textarea name="txt_intro" id="txt_intro" rows="3" class='form-control' placeholder='Mô tả ngắn dưới 20 từ'/><?php echo $slider_data['intro']?></textarea>
            </div>
            <div class='form-group col-sm-6'>
                <label class="control-label">Image<font color="red">*</font></label>
                <input name="fileImg" type="file" id="file-thumb" size="45" class='form-control'/>
                <input name="url_image" type="hidden" value="<?php echo $slider_data['image'] ?>""/>
                <div id="show-img">
                    <img class="img-display" src="<?php echo $thumb?>">
                </div>
            </div>
        </div>
        <div class="text-center">
            <br/>
            <a href="<?php echo $base_url ?>" class="btn btn-default">Quay lại</a>
            <input type="submit" name="cmdsave" id="cmdsave"  class="btn btn-primary" value="Lưu thông tin">
        </div>
    </form>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $("input#file-thumb").change(function(e) {
            for (var i = 0; i < e.originalEvent.srcElement.files.length; i++) {
                var file = e.originalEvent.srcElement.files[i];
                var img = document.createElement("img");
                var reader = new FileReader();
                reader.onloadend = function() {
                    img.src = reader.result;
                }
                reader.readAsDataURL(file);
                $('#show-img').addClass('show-img');
                $('#show-img').html(img);
            }
        });
    });
</script>