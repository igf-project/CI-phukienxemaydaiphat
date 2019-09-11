<?php
$base_url = base_url().'admin/Sale/';
?>
<div id="path">
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url()?>admin">Admin</a></li>
        <li><a href="<?php echo $base_url ?>">Sản phẩm sale</a></li>
        <li class="active">Sửa sản phẩm sale</li>
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
        <form action="<?php echo $base_url ?>do_edit" enctype="multipart/form-data" method="post" accept-charset="utf-8">
            <input type="hidden" name="txtid" value="<?php echo $result['id'] ?>">
            <div class="tab-content">
                <!-- Tab infomation -->
                <div class="tab-pane fade active in" id="info">
                    <div class="row">
                        <div class='form-group col-md-6'>
                            <label>Mã code sản phẩm</label><font color="red">*</font>
                            <input type="text" name="txt_pro_code" class="form-control" value="<?= $result['product_code'] ?>" placeholder="Mã code sản phẩm">
                        </div>
                        <div class='form-group col-sm-6 col-md-6'>
                            <label>Nhóm cha</label>
                            <select name="cbo_par" id="cbo_par" class="form-control">
                                <option value="">Chọn một nhóm</option>
                                <?php
                                foreach ($parent as $item) {
                                    if($item['id'] == $result['sale_group_id']){
                                        echo '<option value="'.$item['id'].'" selected>'.$item['name'].'</option>';
                                    }else{
                                        echo '<option value="'.$item['id'].'">'.$item['name'].'</option>';
                                    }
                                }
                                ?>
                            </select>
                            <font id='err-gmember' color="red"></font>
                            <div class="clearfix"></div>
                        </div>

                        <div class='form-group col-md-6'>
                            <label>Sale từ ngày:</label>
                            <input type="date" name="txt_start_sale" class="form-control"
                            value="<?= date('Y-m-d', $result['start_time']) ?>" placeholder="Thời gian bắt đầu sale">
                        </div>

                        <div class='form-group col-md-6'>
                            <label>Sale đến ngày:</label>
                            <input type="date" name="txt_end_sale" class="form-control" value="<?= date('Y-m-d', $result['end_time']) ?>" placeholder="Thời gian kết thúc sale">
                        </div>

                        <div class='col-sm-6'>
                            <label>Trạng thái</label>
                            <div class="form-group">
                                <label class="radio-inline"><input name="optactive" type="radio" value="1" <?php echo $result['isactive']==1 ? 'checked':'';?>>Active</label>
                                <label class="radio-inline"><input name="optactive" type="radio" value="0" <?php echo $result['isactive']==0 ? 'checked':'';?>>Deactive</label>
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