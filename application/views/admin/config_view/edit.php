<?php 
$base_url = base_url().'admin/Config/';
?>
<div id="path">
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url()?>admin">Admin</a></li>
        <li><a href="<?php echo $base_url ?>">Cấu hình website</a></li>
    </ol>
</div>
<div id="action">
    <?php
    if (isset($success_message)) {
        echo $success_message;
    }
    if (isset($error_message)) {
        echo $error_message;
    }
    ?>
    <small>Các mục đánh dấu <font color="red">*</font> là thông tin bắt buộc</small><hr/>
    <form method="post" action="<?php echo $base_url ?>update" enctype="multipart/form-data">
        <input type="hidden" name="_id" value="<?php echo $result['id'];?>">
        <div class="row">
            <div class='form-group col-md-6'>
                <label>Tên website</label><font color="red">*</font>
                <input name="_name" type="text" id="_name" class='form-control' value="<?php echo $result['name']?>" placeholder='Tên slide'/>
            </div>
            <div class='form-group col-md-6'>
                <label>Tên công ty</label><font color="red">*</font>
                <input name="_title" type="text" id="_title" class='form-control' value="<?php echo $result['title']?>" placeholder='Tên công ty'/>
            </div>
            <div class='form-group col-sm-6'>
                <label class="control-label">Email</label>
                <input name="_email" type="text" id="_email" class='form-control' value="<?php echo $result['email']?>" placeholder='Email...'/>
            </div>
            <div class='form-group col-sm-6'>
                <label class="control-label">Số điện thoại</label>
                <input name="_phone" type="number" id="_phone" class='form-control' value="<?php echo $result['phone']?>" placeholder='Phone...'/>
            </div>
            <div class='form-group col-sm-6'>
                <label class="control-label">Fax</label>
                <input name="_fax" type="text" id="_fax" class='form-control' value="<?php echo $result['fax']?>" placeholder='Fax...'/>
            </div>
            <div class='form-group col-sm-6'>
                <label class="control-label">Facebook</label>
                <input name="_facebook" type="text" id="_facebook" class='form-control' value="<?php echo $result['facebook']?>" placeholder='Facebook...'/>
            </div>
            <div class='form-group col-sm-6'>
                <label class="control-label">Youtube</label>
                <input name="_youtube" type="text" id="_youtube" class='form-control' value="<?php echo $result['youtube']?>" placeholder='Youtube...'/>
            </div>
            <div class='form-group col-sm-6'>
                <label class="control-label">G+</label>
                <input name="_gplus" type="text" id="_gplus" class='form-control' value="<?php echo $result['gplus']?>" placeholder='G+...'/>
            </div>
            <div class='form-group col-sm-6'>
                <label class="control-label">Địa chỉ</label>
                <textarea name="_address" id="_address" rows="3" class='form-control' placeholder='Địa chỉ'/><?php echo $result['address']?></textarea>
            </div>
            <div class='form-group col-sm-6'>
                <label class="control-label">Mô tả</label>
                <textarea name="_intro" id="_intro" rows="3" class='form-control' placeholder='Mô tả ngắn dưới 20 từ'/><?php echo $result['intro']?></textarea>
            </div>
            <div class='form-group col-sm-6'>
                <label class="control-label">Meta keywork <small>(Không quá 70 ký tự)</small></label>
                <textarea name="_meta_keyword" id="_meta_keyword" rows="3" minlength="0" maxlength="70" class='form-control' placeholder='Từ khóa mô tả về website...'/><?php echo $result['meta_keyword']?></textarea>
            </div>
            <div class='form-group col-sm-6'>
                <label class="control-label">Meta description <small>(Không quá 150 ký tự)</small></label>
                <textarea name="_meta_descript" id="_meta_descript" rows="3" minlength="0" maxlength="150" class='form-control' placeholder='Mô tả về website...'/><?php echo $result['meta_descript']?></textarea>
            </div>
        </div>
        <div class="text-center">
            <br/>
            <a href="<?php echo $base_url ?>" class="btn btn-default">Quay lại</a>
            <input type="submit" name="btn_save" id="btn_save"  class="btn btn-primary" value="Lưu thông tin">
        </div>
    </form>
</div>