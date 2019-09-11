<?php 
$base_url = base_url().'admin/Module/';
?>

<div id="path">
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url()?>admin">Admin</a></li>
        <li><a href="<?php echo $base_url ?>">Module</a></li>
        <li class="active">Edit field</li>
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
    <form action="<?php echo $base_url ?>do_edit" enctype="multipart/form-data" method="post" accept-charset="utf-8">
        <input type="hidden" name="txtid" value="<?php echo $id;?>">
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
                <script type="text/javascript">
                    cbo_Selected('cbo_viewtype','<?php echo $result['type'];?>');
                </script>
            </div>
            <div class='form-group col-md-6'>
                <label>Tiêu đề</label><font color="red">*</font>
                <input name="txt_name" type="text" id="txt_name" value="<?= $result['name'] ?>" class='form-control' placeholder='Tiêu đề Module' required/>
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
                <script type="text/javascript">
                    cbo_Selected('cbo_position','<?php echo $result['position'];?>');
                </script>
            </div>
            <div class='form-group col-md-6'>
                <label>Class</label>
                <input name="txt_class" type="text" class='form-control' value="<?= $result['class'] ?>" />
            </div>
            <div class='col-sm-6'>
                <label>Trạng thái</label>
                <div class="form-group">
                    <?php
                    if($result['isactive']==1){
                        echo '<label class="radio-inline"><input name="optactive" type="radio" value="1" checked>Active</label>
                        <label class="radio-inline"><input name="optactive" type="radio" value="0">Deactive</label>';
                    }else{
                        echo '<label class="radio-inline"><input name="optactive" type="radio" value="1">Active</label>
                        <label class="radio-inline"><input name="optactive" type="radio" value="0" checked>Deactive</label>';
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <h3>Parameter</h3><hr>
        <div class="row">
            <div id="selectBox">
                <?php
                    if($result['content']!= ''){
                        echo '<div class="col-sm-12 form-group">';
                        echo'<label class="control-label">Nội dung</label>
                        <textarea name="txt_fulltext" id="txt_fulltext" rows="3" class="form-control" placeholder="Nội dung"/>'.$result['content'].'</textarea>';
                        echo '<script type="text/javascript">CKEDITOR.replace("txt_fulltext", {height : "300px"}); </script>';
                        echo '</div>';
                    }

                    if($result['cata_id']!= ''){
                        echo '<div class="col-sm-6 form-group">';
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
                        echo '</div>';
                    }

                    if($result['cate_id']!= ''){
                        echo '<div class="col-sm-6 form-group">';
                        echo '<label>Nhóm bài viết</label><font color="red">*</font>';
                        echo '<select name="cbo_category" id="cbo_category" class="form-control">';
                        echo '<option value="0" title="Top">Chọn một nhóm bài viết</option>';
                        foreach ($category as $item) {
                            if($item['id'] == $result['cate_id']){
                                echo '<option value="'.$item['id'].'" selected>'.$item['name'].'</option>';
                            }else{
                                echo '<option value="'.$item['id'].'">'.$item['name'].'</option>';
                            }
                        }
                        echo '</select>';
                        echo '<script>$("#cbo_category").select2();</script>';
                        echo '</div>';
                    }

                    if($result['post_id']!= ''){
                        echo '<div class="col-sm-6 form-group">';
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
                        echo '</div>';
                    }
                    ?>
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