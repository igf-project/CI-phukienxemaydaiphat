<?php
$base_url = base_url().'admin/Menu/';
?>
<div id="path">
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url()?>admin">Admin</a></li>
        <li><a href="<?php echo $base_url ?>">Menu</a></li>
        <li class="active">Edit menu</li>
    </ol>
</div>
<div id="action">
    <small>Các mục đánh dấu <font color="red">*</font> là thông tin bắt buộc. Chọn một kiểu link trước</small><hr/>
    <form method="post" action="<?php echo $base_url ?>do_edit" enctype="multipart/form-data">
        <input type="hidden" name="txtid" value="<?= $result['id'] ?>">
        <div class="row">
            <div class="col-sm-6 form-group">
                <label>Chọn một kiểu link</label><font color="red">*</font>
                <select name="cbo_viewtype" id="cbo_viewtype" class="form-control">
                    <option value="link">Links</option>
                    <!-- <option value="catalog">Nhóm sản phẩm</option> -->
                    <option value="category">Nhóm bài viết</option>
                    <option value="post">Bài viết</option>
                    <!-- <option value="page">Page</option> -->
                </select>
                <script type="text/javascript">
                    cbo_Selected('cbo_viewtype','<?php echo $result['view_type'];?>');
                </script>
            </div>
            <div class="col-sm-6 form-group">
                <div id="selectBox">
                    <?php
                    if($result['link']!= ''){
                        echo '<label>Url</label><font color="red">*</font>
                        <input type="text" name="txt_url" class="form-control" value="'.$result['link'].'" placeholder="Url" required>';
                    }

                    if($result['cata_id']!= 0){
                        echo '<label>Nhóm sản phẩm</label><font color="red">*</font>';
                        echo '<select name="cbo_catalog" id="cbo_catalog" class="form-control">';
                        echo '<option value="0" title="Top">Chọn một nhóm sản phẩm</option>';
                        foreach ($catalog as $item) {
                            if($item['id'] == $result['cata_id']){
                                echo '<option value="'.$item['id'].'" selected>'.$item['name'].'</option>';
                            }else{
                                echo '<option value="'.$item['id'].'">'.$item['name'].'</option>';
                            }
                        }
                        echo '</select>';
                        echo '<script>$("#cbo_catalog").select2();</script>';
                    }

                    if($result['post_group_id']!= 0){
                        echo '<label>Nhóm bài viết</label><font color="red">*</font>';
                        echo '<select name="cbo_category" id="cbo_category" class="form-control">';
                        echo '<option value="0" title="Top">Chọn một nhóm bài viết</option>';
                        foreach ($category as $item) {
                            if($item['id'] == $result['post_group_id']){
                                echo '<option value="'.$item['id'].'" selected>'.$item['name'].'</option>';
                            }else{
                                echo '<option value="'.$item['id'].'">'.$item['name'].'</option>';
                            }
                        }
                        echo '</select>';
                        echo '<script>$("#cbo_category").select2();</script>';
                    }

                    if($result['post_id']!= 0){
                        echo '<label>Bài viết</label><font color="red">*</font>';
                        echo '<select name="cbo_post" id="cbo_post" class="form-control">';
                        echo '<option value="0" title="Top">Chọn một bài viết</option>';
                        foreach ($post as $item) {
                            if($item['id'] == $result['post_id']){
                                echo '<option value="'.$item['id'].'" selected>'.$item['title'].'</option>';
                            }else{
                                echo '<option value="'.$item['id'].'">'.$item['title'].'</option>';
                            }
                        }
                        echo '</select>';
                        echo '<script>$("#cbo_post").select2();</script>';
                    }
                    ?>
                    
                </div>
            </div>
            <div class="clearfix"></div><hr/>
            <div class="col-sm-6 form-group">
                <label>Tên</label><font color="red">*</font>
                <input type="text" name="txt_name" class="form-control" value="<?= $result['title'] ?>" placeholder="Tên" required>
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
                <script type="text/javascript">
                    cbo_Selected('cbo_par','<?php echo $result['par_id'];?>');
                </script>
            </div>
            <div class="col-sm-6 form-group">
                <label>Class</label>
                <input type="text" name="txt_class" class="form-control" value="<?= $result['class'] ?>" placeholder="class">
            </div>
            <div class="col-sm-6 form-group">
                <label>Icon</label>
                <input type="text" name="txt_icon" class="form-control" value="<?= $result['icon'] ?>" placeholder="Icon">
            </div>
            <div class='col-sm-6 form-group'>
                <label>Trạng thái</label>
                <div class="form-group">
                    <label class="radio-inline"><input name="optactive" type="radio" value="1" <?php if($result['isactive']==1) echo 'checked' ?>>Active</label>
                    <label class="radio-inline"><input name="optactive" type="radio" value="0" <?php if($result['isactive']==0) echo 'checked' ?>>Deactive</label>
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