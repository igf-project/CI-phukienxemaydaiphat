<?php 
$base_url = base_url().'admin/tag/';
?>

<div id="path">
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url()?>admin">Admin</a></li>
        <li><a href="<?php echo $base_url ?>">Danh sách tags</a></li>
        <li class="active">Thêm tag</li>
    </ol>
</div>
<div id="action">
    <div class="box-tabs">
        <small>Các mục đánh dấu <font color="red">*</font> là thông tin bắt buộc</small><hr/>
        <div style="color: red">
            <?php
            if(isset($error)){
                echo $error;
            }
            ?>
        </div>
        <form action="<?php echo $base_url ?>do_add" enctype="multipart/form-data" method="post" accept-charset="utf-8">
            <div class="tab-content">
                <!-- Tab infomation -->
                <div class="tab-pane fade active in" id="info">
                    <div class="row">
                        <div class="col-md-6">
                            <div class='form-group'>
                                <label>Tên</label><font color="red">*</font>
                                <input name="txt_name" type="text" id="txt_name" class='form-control' placeholder='Tên tag' required />
                            </div>
                            <div class='form-group'>
                                <label>Nhóm cha</label>
                                <select name="cbo_par" id="cbo_par" class="form-control" style="width: 100%">
                                    <option value="">Chọn một nhóm</option>
                                    <?php
                                    foreach ($parent as $item) {
                                        echo '<option value="'.$item['id'].'">'.$item['name'].'</option>';
                                    }
                                    ?>
                                </select>
                                <div class="clearfix"></div>
                            </div>
                            <div class='form-group'>
                                <label>Link</label><font color="red">*</font>
                                <input name="txt_link" type="text" id="txt_link" class='form-control' placeholder='Đường link của tag' required="required" />
                            </div>
                            <div>
                                <label>Trạng thái</label>
                                <div class="form-group">
                                    <label class="radio-inline"><input name="optactive" type="radio" value="1" checked>Hiển thị</label>
                                    <label class="radio-inline"><input name="optactive" type="radio" value="0">Ẩn</label>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class='form-group'>
                                <label>Mô tả tiêu đề</label>
                                <input name="txt_metatitle" type="text" id="txt_metatitle" class='form-control' value="" placeholder='' rows="1"/>
                            </div>
                            <div class='form-group'>
                                <label>Từ khóa</label>
                                <textarea class="form-control" name="txt_metakey" id="txt_metakey" rows="2"></textarea>
                            </div>
                            <div class='form-group'>
                                <label>Description</label>
                                <textarea class="form-control" name="txt_metadesc" id="txt_metadesc" rows="3"></textarea>
                            </div>
                        </div>
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
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $("#cbo_par").select2();
    });
</script>