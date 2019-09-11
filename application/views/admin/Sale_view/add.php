<?php 
$base_url = base_url().'admin/Sale/';
?>

<div id="path">
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url()?>admin">Admin</a></li>
        <li><a href="<?php echo $base_url ?>">Sản phẩm sale</a></li>
        <li class="active">Thêm sản phẩm sale</li>
    </ol>
</div>
<div id="action">
    <small>Các mục đánh dấu <font color="red">*</font> là thông tin bắt buộc</small><hr/>
    <div style="color: red">
        <?php
        if (isset($err_empty)) {
            echo $err_empty;
        }
        ?>
    </div>
    <div class="box-tabs">
        <ul class="nav nav-tabs" role="tablist">
            <li class="active">
                <a href="#info" role="tab" data-toggle="tab">
                    Thông tin
                </a>
            </li>
        </ul>
        <form action="<?php echo $base_url ?>do_add" enctype="multipart/form-data" method="post" accept-charset="utf-8">
            <div class="tab-content">
                <!-- Tab infomation -->
                <div class="tab-pane fade active in" id="info">
                    <div class="row">
                        <div class='form-group col-md-6'>
                            <label>Mã code sản phẩm</label><font color="red">*</font>
                            <input type="text" name="txt_pro_code" class="form-control" value="<?= $q ?>" placeholder="Mã code sản phẩm">
                        </div>
                        <div class='form-group col-sm-6 col-md-6'>
                            <label>Nhóm Sale</label><font color="red">*</font>
                            <select name="cbo_par" id="cbo_par" class="form-control">
                                <option value="">Chọn một nhóm</option>
                                <?php
                                foreach ($parent as $item) {
                                    echo '<option value="'.$item['id'].'">'.$item['name'].'</option>';
                                }
                                ?>
                            </select>
                            <div class="clearfix"></div>
                        </div>
                        <div class='form-group col-md-6'>
                            <label>Sale từ ngày:</label>
                            <input type="date" name="txt_start_sale" class="form-control" placeholder="Thời gian bắt đầu sale">
                        </div>
                        <div class='form-group col-md-6'>
                            <label>Sale đến ngày:</label>
                            <input type="date" name="txt_end_sale" class="form-control" placeholder="Thời gian kết thúc sale">
                        </div>
                        <div class='col-sm-6'>
                            <label>Trạng thái</label>
                            <div class="form-group">
                                <label class="radio-inline"><input name="optactive" type="radio" value="1" checked>Active</label>
                                <label class="radio-inline"><input name="optactive" type="radio" value="0">Deactive</label>
                                <div class="clearfix"></div>
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