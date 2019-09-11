<?php 
$base_url = base_url().'admin/users/';
?>
<div id="path">
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url()?>admin">Admin</a></li>
        <li><a href="<?php echo $base_url ?>">User</a></li>
        <li class="active">Edit user</li>
    </ol>
</div>

<div id="action">
    <small>Các mục đánh dấu <font color="red">*</font> là thông tin bắt buộc</small><hr/>
    <form id="frm_action" name="frm_action" method="post" action="<?php echo $base_url ?>do_edit">
        <input type="hidden" name="txtid" value="<?php echo $user_data['id']?>">
        <div class="row">
            <div class='form-group col-md-4'>
                <label>Tên đăng nhập</label><font color="red">*</font>
                <input type="text" name="txtusername" class="form-control" id="txtusername" value="<?php echo $user_data['username']?>" readonly>
            </div>
        </div>
        <h4>Thông tin người dùng</h4>
        <div class="row">
            <div class='form-group col-sm-6 col-md-4'>
                <label>Họ & đệm</label><font color="red">*</font>
                <input type="text" name="txtfirstname" class="form-control" id="txtfirstname" value="<?php echo $user_data['firstname']?>">
                <font id='err-firstname' color="red"></font>
                <div class="clearfix"></div>
            </div>
            <div class='form-group col-sm-6 col-md-4'>
                <label>Tên</label><font color="red">*</font>
                <input type="text" name="txtlastname" class="form-control" id="txtlastname" value="<?php echo $user_data['lastname']?>">
                <font id='err-lastname' color="red"></font>
                <div class="clearfix"></div>
            </div>
            <div class='form-group col-md-6 col-md-4'>
                <label>Ngày sinh</label><font color="red">*</font>
                <input type="date" name="txtbirthday" class="form-control" id="txtbirthday" value="<?php echo date('Y-m-d', strtotime($user_data['birthday']))?>">
                <font id='err-birthday' color="red"></font>
                <div class="clearfix"></div>
            </div>
            <div class='form-group col-md-6 col-md-4'>
                <label>Địa chỉ</label>
                <input type="text" name="txtaddress" class="form-control" id="txtaddress" value="<?php echo $user_data['address']?>">
                <div class="clearfix"></div>
            </div>
            <div class='form-group col-md-6 col-md-4'>
                <label>Điện thoại</label><font color="red">*</font>
                <input type="text" name="txtphone" class="form-control" id="txtphone" value="<?php echo $user_data['phone']?>">
                <font id='err-phone' color="red"></font>
                <div class="clearfix"></div>
            </div>
            <div class='form-group col-md-6 col-md-4'>
                <label>Email</label><font color="red">*</font>
                <input type="text" name="txtemail" class="form-control" id="txtemail" value="<?php echo $user_data['email']?>">
                <font id='err-email' color="red"></font>
                <div class="clearfix"></div>
            </div>
            <!-- <div class='form-group col-md-6'>
                <label>Nhóm quyền</label>
                <select name="cbo_gmember" id="cbo_gmember" class="form-control">
                    <option value="">Chọn nhóm quyền</option>
                    <?php
                    foreach ($list_guser as $item) {
                        if($item['id'] == $user_data['guser_id']){
                            echo '<option value="'.$item['id'].'" selected="selected">'.$item['name'].'</option>';
                        }else{
                            echo '<option value="'.$item['id'].'">'.$item['name'].'</option>';
                        }
                    }
                    ?>
                </select>
                <font id='err-gmember' color="red"></font>
                <div class="clearfix"></div>
            </div> -->
            <div class='col-md-6  col-md-4'>
                <label>Giới tính</label><font color="red">*</font>
                <div class="form-group">
                    <?php
                    if($user_data['gender']==0){
                        echo '<label class="radio-inline"><input type="radio" name="optgender" value="0" checked>Nam</label>
                        <label class="radio-inline"><input type="radio" name="optgender" value="1">Nữ</label>';
                    }else{
                        echo '<label class="radio-inline"><input type="radio" name="optgender" value="0">Nam</label>
                        <label class="radio-inline"><input type="radio" name="optgender" value="1" checked>Nữ</label>';
                    }
                    ?>
                    <font id='err-gender' color="red"></font>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class='col-md-6 col-md-4'>
                <label>Tình trạng</label>
                <div class="form-group">
                    <?php
                    if($user_data['isactive']==1){
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
        <section class="hidden">
            <fieldset class="fieldset_roles">
                <legend>Chọn quyền:</legend>
                <?php
                $ar_role = json_decode($user_data['roles_id']);
                echo '<div class="col-md-12 m-bt-1"><label class="title"><input type="checkbox" onclick="toggle_all(this)">Check All</label></div>';
                foreach ($roles as $item) {
                    echo '<div class="col-xs-6 col-sm-3 col-md-3 box-child">';
                    echo '<label class="title"><input type="checkbox" onclick="toggle(this,'.$item['id'].')" name="_roles[]" value="'.$item['id'].'">'.$item['name'].'</label>';
                    $count = count($item['child']);
                    if($count>0){
                        echo '<ul class="list-child">';
                        foreach ($item['child'] as $item_child) {
                            if(in_array($item_child['id'], $ar_role)){
                                $checked = 'checked';
                            }else{
                                $checked = '';
                            }
                            echo '<li class="checkbox">
                            <label><input type="checkbox" name="_roles[]" data-parent="'.$item['id'].'" value="'.$item_child['id'].'"'.$checked.'>'.$item_child['name'].'</label>
                            </li>';
                        }
                        echo '</ul>';
                    }
                    echo '</div>';
                }
                ?>
            </fieldset>
        </section>
        <div class="text-center">
            <br/>
            <a href="<?php echo $base_url ?>" class="btn btn-default">Quay lại</a>
            <input type="submit" name="cmdsave" id="cmdsave"  class="btn btn-primary" value="Lưu thông tin">
        </div>
    </form>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('#frm_action').submit(function(){
            return checkinput();
        })
    })

    function checkinput(){
        var cur_date    = new Date();
        var cur_time    = cur_date.getTime();
        var birthday    = $('#txtbirthday').val();
        var int_birthday = Math.round(new Date(birthday).getTime());
        var valuePhone  =$("#txtphone").val();
        var phoneno     =/^[\d\.\-]+$/;
        var valueEmail  =$("#txtemail").val();
        var re_email    = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;

        if($("#txtfirstname").val()==''){
            $('#err-firstname').text('Vui lòng điền vào trường này !');
            return false;
        }else{
            $('#err-firstname').text('');
        }

        if($("#txtlastname").val()==''){
            $('#err-lastname').text('Vui lòng điền vào trường này !');
            return false;
        }else{
            $('#err-lastname').text('');
        }

        if(int_birthday>=cur_time){
            $('#err-birthday').text('Lỗi !');
            return false;
        }else{
            $('#err-birthday').text('');
        }

        if(!valuePhone.match(phoneno)){
            $("#err-phone").text("Không đúng định dạng");
            return false;
        }else{
            $("#err-phone").text('');
        }

        if(!valueEmail.match(re_email)){
            $('#err-email').text('Không đúng định dạng');
            return false;
        }
        return true;
    }

    function toggle_all(source) {
        checkboxes = document.getElementsByName('_roles[]');
        var n = checkboxes.length;
        for(var i=0; i<n; i++) {
            checkboxes[i].checked = source.checked;
        }
    }

    function toggle(source, name) {
        checkboxes = document.querySelectorAll('[data-parent="'+name+'"]');
        var n = checkboxes.length;
        for(var i=0; i<n; i++) {
            checkboxes[i].checked = source.checked;
        }
    }
</script>