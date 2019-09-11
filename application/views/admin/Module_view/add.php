<?php 
$base_url = base_url().'admin/Module/';
?>

<div id="path">
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url()?>admin">Admin</a></li>
        <li><a href="<?php echo $base_url ?>">Module</a></li>
        <li class="active">Add field</li>
    </ol>
</div>
<div id="action">
    <small>Các mục đánh dấu <font color="red">*</font> là thông tin bắt buộc</small><hr/>
    <div style="color: red">
        <?php
        if(isset($error)){
            echo $error;
        }
        ?>
    </div>
    <form action="<?php echo $base_url ?>do_add" enctype="multipart/form-data" method="post" accept-charset="utf-8">
        <div class="row">
            <div class='form-group col-sm-6'>
                <label class="control-label">Kiểu hiển thị <small>(Chọn kiểu hiển thị trước)</small></label><font color="red">*</font>
                <select name="cbo_viewtype" class="form-control" id="cbo_viewtype" required>
                    <option value="0">-- Chọn một dạng hiển thị --</option>
                    <option value="html">Html</option>
                    <!-- <option value="catalog">Nhóm sản phẩm</option> -->
                    <option value="category">Nhóm bài viết</option>
                    <option value="post">Bài viết</option>
                </select>
            </div>
            <div class='form-group col-md-6'>
                <label>Tiêu đề</label><font color="red">*</font>
                <input name="txt_name" type="text" id="txt_name" class='form-control' placeholder='Tiêu đề Module' required/>
            </div>
            <div class='form-group col-md-6'>
                <label>Vị trí</label><font color="red">*</font>
                <select name="cbo_position" class="form-control" id="cbo_position">
                    <option value="">-- Chọn một vị trí --</option>
                    <option value="footer">footer</option>
                    <option value="bottom">bottom</option>
                    <option value="banner">banner</option>
                    <option value="left">left</option>
                    <option value="right">right</option>
                    <option value="box1">box1</option>
                    <option value="box2">box2</option>
                    <option value="box3">box3</option>
                    <option value="box4">box4</option>
                    <option value="box5">box5</option>
                </select>
            </div>
            <div class='form-group col-md-6'>
                <label>Class</label>
                <input name="txt_class" type="text" class='form-control'/>
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
        <div class="clearfix"></div>
        <h3>Parameter</h3><hr>
        <div class="row">
            <div id="selectBox"></div>
        </div>
        <div class="text-center">
            <br/>
            <a href="<?php echo $base_url ?>" class="btn btn-default">Quay lại</a>
            <input type="submit" name="cmdsave" id="cmdsave"  class="btn btn-primary" value="Lưu thông tin">
        </div>
    </form>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('#cbo_viewtype').change(function(){
            var view_type = $(this).val();
            var str = '';
            $.ajax({
                type: 'POST',
                data: {view_type : view_type},
                url: '<?php echo $base_url ?>check_view_type/'+view_type,
                success: function(result){
                    $('#selectBox').html(result);
                }
            });
        })
    })
</script>