<?php
$base_url = base_url().'admin/Menu/';
?>
<div id="path">
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url()?>admin">Admin</a></li>
        <li><a href="<?php echo $base_url ?>">Menu</a></li>
        <li class="active">Add menu</li>
    </ol>
</div>
<div id="action">
    <small>Các mục đánh dấu <font color="red">*</font> là thông tin bắt buộc. Chọn một kiểu link trước</small><hr/>
    <form method="post" action="<?php echo $base_url ?>do_add" enctype="multipart/form-data">
        <div class="row">
            <div class="col-sm-6 form-group">
                <label>Chọn một kiểu link</label><font color="red">*</font>
                <select name="cbo_viewtype" id="cbo_viewtype" class="form-control">
                    <option value="link" selected="selected">Links</option>
                    <!-- <option value="catalog">Nhóm sản phẩm</option> -->
                    <option value="category">Nhóm bài viết</option>
                    <option value="post">Bài viết</option>
                    <!-- <option value="page">Page</option> -->
                </select>
            </div>
            <div class="col-sm-6 form-group">
                <div id="selectBox">
                    <label>Url</label><font color="red">*</font>
                    <input type="text" name="txt_url" class="form-control" placeholder="Url" required>
                </div>
            </div>
            <div class="clearfix"></div><hr/>
            <div class="col-sm-6 form-group">
                <label>Tên</label><font color="red">*</font>
                <input type="text" name="txt_name" class="form-control" placeholder="Tên" required>
            </div>
            <div class="col-sm-6 form-group">
                <label>Menu cha</label><font color="red">*</font>
                <select name="cbo_par" id="cbo_par" class="form-control">
                    <option value="0" title="Top">Chọn nhóm cha</option>
                    <?php
                    foreach ($parent as $item) {
                        echo '<option value="'.$item['id'].'">'.$item['title'].'</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="col-sm-6 form-group">
                <label>Class</label>
                <input type="text" name="txt_class" class="form-control" placeholder="class">
            </div>
            <div class="col-sm-6 form-group">
                <label>Icon</label>
                <input type="text" name="txt_icon" class="form-control" placeholder="Icon">
            </div>
            <div class='col-sm-6 form-group'>
                <label>Trạng thái</label>
                <div class="form-group">
                    <label class="radio-inline"><input name="optactive" type="radio" value="1" checked>Active</label>
                    <label class="radio-inline"><input name="optactive" type="radio" value="0">Deactive</label>
                    <div class="clearfix"></div>
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
    $(document).ready(function(){
        $('#cbo_par').select2();
        $('#cbo_viewtype').change(function(){
            var view_type = $(this).val();
            var str = '';
            $.ajax({
                type: 'POST',
                data: {view_type : view_type},
                url: '<?php echo $base_url ?>check_view_type',
                success: function(result){
                    $('#selectBox').html(result);
                }
            });
        })
    })
</script>