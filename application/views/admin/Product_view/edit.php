<?php
$base_url = base_url().'admin/Product/';

if($result['thumb']==''){
    $thumb = $this->config->item('THUMB_DEFAULT');
}else{
    $thumb = base_url().$result['thumb'];
}

// Convert Array of arrays in to single array
$new_array_tagid = array();
foreach($array_tagId as $k=>$v) {
    $new_array_tagid[$k] = $v['tag_id'];
}
?>
<style type="text/css">
#uploaded_images .item{
    position: relative;
    display: block;
    height: 120px;
    margin-bottom: 15px;
    overflow: hidden;
}
#uploaded_images .item>img{
    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
}
</style>
<div id="path">
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url()?>admin">Admin</a></li>
        <li><a href="<?php echo $base_url ?>">Sản phẩm</a></li>
        <li class="active">Sửa sản phẩm</li>
    </ol>
</div>
<div id="action">
    <small>Các mục đánh dấu <font color="red">*</font> là thông tin bắt buộc</small><hr/>
    <div style="color: red">
        <?php
        if(isset($error_message)){
            echo $error_message;
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
            <li>
                <a href="#tab_images" role="tab" data-toggle="tab">
                    Hình ảnh
                </a>
            </li>
        </ul>
        <form id="frm_action" action="<?php echo $base_url ?>do_edit" enctype="multipart/form-data" method="post" accept-charset="utf-8">
            <input type="hidden" name="txtid" value="<?php echo $result['id'] ?>">
            <div class="tab-content">
                <!-- Tab infomation -->
                <div class="tab-pane fade active in" id="info">
                    <div class="row">
                        <div class="col-md-6 col-left">
                            <div class='form-group'>
                                <label>Tên</label><font color="red">*</font>
                                <input name="txt_name" id="txt_name" type="text" class='form-control required' value="<?= $result['name'] ?>" placeholder='Tên sản phẩm' required />
                            </div>

                            <div class='form-group'>
                                <label>Mã code</label><font color="red">*</font>
                                <input name="txt_pro_code" id="txt_pro_code" type="text" class='form-control required' placeholder='Mã code nhóm sản phẩm' value="<?= $result['pro_code'] ?>" required readonly />
                            </div>
                            <div class='form-group'>
                                <label>Nhóm sản phẩm</label>
                                <select name="cbo_par" id="cbo_par" class="form-control" required="required">
                                    <option value="">Chọn một nhóm</option>
                                    <?php
                                    foreach ($parent as $item) {
                                        if($item['id'] == $result['cata_id']){
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
                            <div class="row">
                                <div class='form-group col-md-6'>
                                    <label>Giá</label><font color="red">*</font>
                                    <input name="txt_price" type="number" id="txt_price" min="0" class='form-control required' value="<?= $result['start_price'] ?>" placeholder='Giá sản phẩm' required />
                                </div>
                                <div class='form-group col-md-6'>
                                    <label>Số lượng</label>
                                    <input name="txt_quantity" type="number" min="0" id="txt_quantity" class='form-control' value="<?= $result['quantity'] ?>" placeholder='Số lượng sản phẩm'/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Trạng thái</label>
                                <label class="radio-inline"><input name="optactive" type="radio" value="1" <?php echo $result['isactive']==1 ? 'checked':'';?>>Active</label>
                                <label class="radio-inline"><input name="optactive" type="radio" value="0" <?php echo $result['isactive']==0 ? 'checked':'';?>>Deactive</label>
                                <div class="clearfix"></div>
                            </div>

                            <div class='form-group'>
                                <label class="control-label">Image</label>
                                <input name="url_image" type="hidden"  value="<?php echo $result['thumb'];?>">
                                <input name="fileImg" type="file" id="file-thumb" class='form-control' />
                                <div id="show-img">
                                    <img class="img-display" src="<?php echo $thumb ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-right">
                            <div class='form-group'>
                                <label>Mô tả tiêu đề</label>
                                <input name="txt_metatitle" type="text" id="txt_metatitle" class='form-control' value="<?php echo $result['meta_title'] ?>" placeholder='' rows="1"/>
                            </div>

                            <div class='form-group'>
                                <label>Từ khóa</label>
                                <textarea class="form-control" name="txt_metakey" id="txt_metakey" rows="2"><?php echo $result['meta_key'] ?></textarea>
                            </div>

                            <div class='form-group'>
                                <label>Description</label>
                                <textarea class="form-control" name="txt_metadesc" id="txt_metadesc" rows="3"><?php echo $result['meta_desc'] ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div></br>
                    <div class='form-group'>
                        <label>Tags</label><font color="red">*</font>
                        <select  name="cbo_tag[]" id="cbo_tag" class="form-control" multiple="multiple" style="width: 100%" required="required">
                            <?php
                            foreach ($tags as $item) {
                                if(in_array($item['id'], $new_array_tagid)){
                                    echo '<option value="'.$item['id'].'" selected>'.$item['name'].'</option>';
                                }else{
                                    echo '<option value="'.$item['id'].'">'.$item['name'].'</option>';
                                }
                            }
                            ?>
                        </select>
                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div></br>
                    <div class='form-group'>
                        <label class="control-label">Mô tả ngắn <small>(Không nên quá 50 từ)</small></label>
                        <textarea name="txt_intro" id="txt_intro" rows="3" class='form-control' placeholder='Mô tả ngắn'/><?= $result['intro'] ?></textarea>
                    </div>
                    <script type="text/javascript">CKEDITOR.replace("txt_intro", {height : '100px'}); </script>

                    <div class='form-group'>
                        <label class="control-label">Nội dung</label>
                        <textarea name="txt_fulltext" id="txt_fulltext" rows="3" class='form-control' placeholder='Mô tả ngắn'/><?= $result['fulltext'] ?></textarea>
                    </div>
                    <script type="text/javascript">CKEDITOR.replace("txt_fulltext", {height : '200px'}); </script>
                </div>

                <!-- Tab images -->

                <div class="tab-pane fade" id="tab_images">
                    <div class="row">
                        <div class="hidden">
                            <input type="file" name="files1" data-number="1" class="files" id="files1">
                            <input type="file" name="files2" data-number="2" class="files" id="files2">
                            <input type="file" name="files3" data-number="3" class="files" id="files3">
                            <input type="file" name="files4" data-number="4" class="files" id="files4">
                            <input type="file" name="files5" data-number="5" class="files" id="files5">
                            <input type="file" name="files6" data-number="6" class="files" id="files6">
                        </div>
                        <?php
                        $images = json_decode($result['images']);
                        $n = count($images);
                        $m = 6 - $n;
                        for ($i=0; $i < $n; $i++) { 
                            $j = $i+1;
                            echo '<div class="col-md-4 col-sm-6 form-group">
                            <div class="row">
                            <div class="col-md-9 col-sm-9 col-xs-8">
                            <input id="file_image'.$j.'" type="text" class="form-control" name="file_image[]" value="'.$images[$i].'" placeholder="Url image">
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-4">
                            <button type="button" data-number="'.$j.'" class="button_select_image btn btn-primary">Chọn</button>
                            </div>
                            </div>
                            </div>';
                        }

                        for ($i=$n; $i < 6; $i++) { 
                            $j = $i+1;
                            echo '<div class="col-md-4 col-sm-6 form-group">
                            <div class="row">
                            <div class="col-md-9 col-sm-9 col-xs-8">
                            <input id="file_image'.$j.'" type="text" class="form-control" name="file_image[]" value="" placeholder="Url image">
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-4">
                            <button type="button" data-number="'.$j.'" class="button_select_image btn btn-primary">Chọn</button>
                            </div>
                            </div>
                            </div>';
                        }
                        ?>
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
        $("#cbo_tag").select2();

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

    $('#cmdsave').click(function(){
        $('#frm_action').submit();
    })

    $('#frm_action').submit(function(){
        return checkinput();
    })

    $('.button_select_image').click(function(){
        var num = $(this).attr("data-number");
        $('#files'+num).click();
        // console.log($('#files'+num).attr("data-number"));
    })

    // Upload multiple
    $('.files').change(function(){
        var file_name = $(this).attr('name');
        var number = $(this).attr('data-number');
        var files = $(this)[0].files;
        var error = '';
        var form_data = new FormData();

        var name = files[0].name;
        var extension = name.split('.').pop().toLowerCase();
        if(jQuery.inArray(extension, ['jpg', 'png', 'gif', 'jpeg']) == -1){
            error += "Invalid Image file";
        }else{
            form_data.append(file_name, files[0]);
        }

        if(error == ''){
            $.ajax({
                url : "<?= base_url() ?>admin/Upload_multiple/upload_edit/"+file_name,
                method : "POST",
                data : form_data,
                contentType : false,
                cache : false,
                processData : false,
                success : function(data){
                    $("#file_image"+number).val(data);
                    $(this).val('');
                }
            })
        }else{
            alert(error);
        }
    })

    function checkinput()
    {
        $("#frm_action .required").filter(function () {
            return $.trim($(this).val()).length == 0
        }).length == 0;

        var a=document.forms["#frm_action"]["#txt_name"].value;
        var b=document.forms["#frm_action"]["#txt_pro_code"].value;
        var c=document.forms["#frm_action"]["#cbo_par"].value;
        var d=document.forms["#frm_action"]["#txt_price"].value;
        if (a=="" || a=="",b=="" || b=="",c=="" || c=="",d=="" || d=="")
        {
            alert("Please fill in all the required fields (indicated by *)");
            return false;
        }
    }
</script>