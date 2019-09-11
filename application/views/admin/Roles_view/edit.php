<?php 
$base_url = base_url().'admin/Roles/';
?>
<div id="path">
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url()?>">Admin</a></li>
        <li><a href="<?php echo $base_url ?>">Phân quyền</a></li>
        <li class="active">Sửa quyền</li>
    </ol>
</div>
<div id="action">
    <small>Các mục đánh dấu <font color="red">*</font> là thông tin bắt buộc</small><hr/>
    <form id="frm_action" name="frm_action" method="post" action="<?php echo $base_url ?>do_edit">
        <input type="hidden" name="txtid" value="<?= $result['id'] ?>">
        <div class="row">
            <span id="msgbox" style="display:none"></span>
            <div class='form-group col-sm-6'>
                <label>Tên Quyền</label><font color="red">*</font>
                <input type="text" name="_name" value="<?= $result['name'] ?>" class="form-control">
            </div>
            <div class='form-group col-sm-6'>
                <label>Nhóm quyền</label>
                <select name="cbo_group" id="cbo_group" class="form-control">
                    <option value="">Chọn nhóm quyền</option>
                    <?php
                    foreach ($parent as $item) {
                        if($result['par_id'] == $item['id']){
                            echo '<option value="'.$item['id'].'" selected>'.$item['name'].'</option>';
                        }else{
                            echo '<option value="'.$item['id'].'">'.$item['name'].'</option>';
                        }
                    }
                    ?>
                </select>
            </div>
            <div class='form-group col-sm-12'>
                <label>Mô tả</label>
                <textarea class="form-control" name="_intro" rows="3"><?= $result['intro'] ?></textarea>
            </div>
        </div>
        <div class="text-center">
            <br/>
            <a href="<?php echo $base_url ?>" class="btn btn-default">Quay lại</a>
            <input type="submit" name="cmdsave" id="cmdsave"  class="btn btn-primary" value="Lưu thông tin">
        </div>
    </form>
</div>
