<?php 
$base_url = base_url().'admin/Product/';
$pro_code = random_string('alnum', 5).($id_max['MAX(id)']+1);
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
        <li class="active">Thêm sản phẩm</li>
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
        <form id="frm_action" action="<?php echo $base_url ?>do_add" enctype="multipart/form-data" method="post" accept-charset="utf-8">
            <div class="tab-content">
                <!-- Tab infomation -->
                <div class="tab-pane fade active in" id="info">
                    <div class="row">
                        <div class="col-md-6 col-left">
                            <div class='form-group'>
                                <label>Tên</label><font color="red">*</font>
                                <input name="txt_name" type="text" id="txt_name" class='form-control required' placeholder='Tên sản phẩm' required/>
                            </div>
                            <div class='form-group'>
                                <label>Mã code</label><font color="red">*</font><span id="checkCode" class="red"></span>
                                <input name="txt_pro_code" id="txt_pro_code" type="text" class='form-control required' placeholder='Mã code nhóm sản phẩm' value="<?= $pro_code ?>" required/>
                                <input type="hidden" id="inputCheckCode" name="checkCode" value="1">
                            </div>
                            <div class='form-group'>
                                <label>Nhóm sản phẩm</label>
                                <select name="cbo_par" id="cbo_par" class="form-control" required="required">
                                    <option value="">Chọn một nhóm</option>
                                    <?php
                                    foreach ($parent as $item) {
                                        echo '<option value="'.$item['id'].'">'.$item['name'].'</option>';
                                    }
                                    ?>
                                </select>
                                <font id='err-gmember' color="red"></font>
                                <div class="clearfix"></div>
                            </div>
                            <div class="row">
                                <div class='form-group col-sm-6'>
                                    <label>Giá</label><font color="red">*</font>
                                    <input name="txt_price" type="number" id="txt_price" min="0" class='form-control required' placeholder='Giá sản phẩm' required />
                                </div>
                                <div class='form-group col-sm-6'>
                                    <label>Số lượng</label>
                                    <input name="txt_quantity" type="number" min="0" id="txt_quantity" class='form-control' placeholder='Số lượng sản phẩm'/>
                                </div>
                            </div>
                            <div class='form-group'>
                                <label>Trạng thái</label>
                                <label class="radio-inline"><input name="optactive" type="radio" value="1" checked="checked">Hiển thị</label>
                                <label class="radio-inline"><input name="optactive" type="radio" value="0">Ẩn</label>
                                <div class="clearfix"></div>
                            </div>

                            <div class='form-group'>
                                <label class="control-label">Image <small>(Ảnh chính của sản phẩm)</small></label><font color="red">*</font>
                                <input name="fileImg" type="file" id="file-thumb" class='form-control' required="" />
                                <div id="show-img">
                                    <img class="img-display" src="<?php echo base_url()?>assets/images/no_image.jpg">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-right">
                            <div class='form-group'>
                                <label>Mô tả tiêu đề</label>
                                <input name="txt_metatitle" type="text" id="txt_metatitle" class='form-control' value="" placeholder='Meta title' rows="1"/>
                            </div>
                            <div class='form-group'>
                                <label>Từ khóa</label>
                                <textarea class="form-control" name="txt_metakey" id="txt_metakey" placeholder="Meta keyword" rows="2"></textarea>
                            </div>
                            <div class='form-group'>
                                <label>Description</label>
                                <textarea class="form-control" name="txt_metadesc" id="txt_metadesc" rows="3" placeholder="Meta description"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div></br>
                    <div class='form-group'>
                        <label>Tags</label><font color="red">*</font>
                        <select name="cbo_tag[]" id="cbo_tag" class="js-example-basic-multiple js-states form-control" multiple="multiple" style="width: 100%" required="required">
                            <?php
                            foreach ($tags as $item) {
                                echo '<option value="'.$item['id'].'">'.$item['name'].'</option>';
                            }
                            ?>
                        </select>
                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div></br>

                    <div class='form-group'>
                        <label class="control-label">Mô tả ngắn <small>(Không nên quá 50 từ)</small></label>
                        <textarea name="txt_intro" id="txt_intro" rows="3" class='form-control' placeholder='Mô tả ngắn'/></textarea>
                    </div>
                    <script type="text/javascript">CKEDITOR.replace("txt_intro", {height : '100px'}); </script>

                    <div class='form-group'>
                        <label class="control-label">Nội dung</label>
                        <textarea name="txt_fulltext" id="txt_fulltext" rows="3" class='form-control' placeholder='Mô tả ngắn'/></textarea>
                    </div>
                    <script type="text/javascript">CKEDITOR.replace("txt_fulltext", {height : '200px'}); </script>
                </div>

                <!-- Tab images -->
                <div class="tab-pane fade" id="tab_images">
                    <p class="red">(Chú ý: Tải hình ảnh lên có dung lượng < 10M, kích thước chiều cao <= 1000px, chiều rộng <= 1600px)</p>
                    <div class="col-sm-4 col-xs-6 form-group">
                        <input type="file" name="files1" data-number="1" class="files">
                        <div id="show-img1" class="show-img"></div>
                    </div>
                    <div class="col-sm-4 col-xs-6 form-group">
                        <input type="file" name="files2" data-number="2" class="files">
                        <div id="show-img2" class="show-img"></div>
                    </div>
                    <div class="col-sm-4 col-xs-6 form-group">
                        <input type="file" name="files3" data-number="3" class="files">
                        <div id="show-img3" class="show-img"></div>
                    </div>
                    <div class="col-sm-4 col-xs-6 form-group">
                        <input type="file" name="files4" data-number="4" class="files">
                        <div id="show-img4" class="show-img"></div>
                    </div>
                    <div class="col-sm-4 col-xs-6 form-group">
                        <input type="file" name="files5" data-number="5" class="files">
                        <div id="show-img5" class="show-img"></div>
                    </div>
                    <div class="col-sm-4 col-xs-6 form-group">
                        <input type="file" name="files6" data-number="6" class="files">
                        <div id="show-img6" class="show-img"></div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="clearfix"></div>
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

        $("#txt_pro_code").change(function() {
            var code = $('#txt_pro_code').val();
            $.ajax({
                type: 'POST',
                data: {proCode : code},
                url: '<?php echo $base_url ?>checkCode',
                success: function(result){
                    if(result=='1'){
                        $('#checkCode').html('<i class="fa fa-times" aria-hidden="true"></i>Mã đã tồn tại. Vui lòng nhập mã khác');  
                        $('#inputCheckCode').val('0');
                    }else{
                        $('#inputCheckCode').val('1');
                    }
                }
            });
        })

        $('#cmdsave').click(function(){
            $('#frm_action').submit();
        })

        $('#frm_action').submit(function(){
            return checkinput();
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
                // file_name = file_name.substr(0, file_name.length - 2);
                // alert(file_name);
                $.ajax({
                    url : "<?= base_url() ?>admin/Upload_multiple/upload1/"+file_name,
                    method : "POST",
                    data : form_data,
                    contentType : false,
                    cache : false,
                    processData : false,
                    beforeSend : function(){
                        $("#show-img"+number).html("<label class='text-success'>Uploading...</label>");
                    },
                    success : function(data){
                        $("#show-img"+number).html(data);
                        $(this).val('');
                    }
                })
            }else{
                alert(error);
            }
        })
    });

    function checkinput()
    {
        $("#frm_action .required").filter(function () {
            return $.trim($(this).val()).length == 0
        }).length == 0;

        var a=document.forms["#frm_action"]["#txt_name"].value;
        var b=document.forms["#frm_action"]["#txt_pro_code"].value;
        var c=document.forms["#frm_action"]["#cbo_par"].value;
        var d=document.forms["#frm_action"]["#txt_price"].value;
        var e=document.forms["#frm_action"]["#file-thumb"].value;
        if (a=="" || a=="",b=="" || b=="",c=="" || c=="",d=="" || d=="" || e=="")
        {
            alert("Please fill in all the required fields (indicated by *)");
            return false;
        }
    }
</script>