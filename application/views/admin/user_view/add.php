<?php 
$base_url = base_url().'admin/Users/';
?>
<div id="path">
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url()?>">Admin</a></li>
        <li><a href="<?php echo $base_url ?>">User</a></li>
        <li class="active">Add user</li>
    </ol>
</div>
<div id="action">
    <small>Các mục đánh dấu <font color="red">*</font> là thông tin bắt buộc</small><hr/>
    <form id="frm_action" name="frm_action" method="post" action="<?php echo $base_url ?>do_add">
        <div class="row">
            <span id="msgbox" style="display:none"></span>
            <input type="hidden" name="checkuser" id="checkuser" value="" />
            <input name="txttask" type="hidden" id="txttask" value="1" />
            <div class='form-group col-md-4'>
                <label>Tên đăng nhập</label><font color="red">*</font>
                <input type="text" name="txtusername" class="form-control" id="txtusername">
                <input type="hidden" name="chk_user" id="chk_user" value=""/>
                <span id="username_result"></span>
                <font id='err-username' color="red"></font>
            </div>
            <div class='form-group col-md-4'>
                <label>Mật khẩu</label><font color="red">*</font><small> ( 6-12 ký tự )</small>
                <input type="password" name="txtpassword" class="form-control" id="txtpassword">
                <font id='err-password' color="red"></font>
                <div class="clearfix"></div>
            </div>
            <div class='form-group col-md-4'>
                <label>Nhập lại mật khẩu</label><font color="red">*</font>
                <input type="password" name="txtrepass" class="form-control" id="txtrepass">
                <font id='err-repassword' color="red"></font>
                <div class="clearfix"></div>
            </div>
        </div>
        <h4>Thông tin người dùng</h4>
        <div class="row">
            <div class='form-group col-sm-6 col-md-4'>
                <label>Họ & đệm</label><font color="red">*</font>
                <input type="text" name="txtfirstname" class="form-control" id="txtfirstname">
                <font id='err-firstname' color="red"></font>
                <div class="clearfix"></div>
            </div>
            <div class='form-group col-sm-6 col-md-4'>
                <label>Tên</label><font color="red">*</font>
                <input type="text" name="txtlastname" class="form-control" id="txtlastname">
                <font id='err-lastname' color="red"></font>
                <div class="clearfix"></div>
            </div>
            <div class='form-group col-sm-6 col-md-4'>
                <label>Ngày sinh</label><font color="red">*</font>
                <input type="date" name="txtbirthday" class="form-control" id="txtbirthday">
                <font id='err-birthday' color="red"></font>
                <div class="clearfix"></div>
            </div>
            <div class='form-group col-sm-6 col-md-4'>
                <label>Địa chỉ</label>
                <input type="text" name="txtaddress" class="form-control" id="txtaddress">
                <div class="clearfix"></div>
            </div>
            <div class='form-group col-sm-6 col-md-4'>
                <label>Điện thoại</label><font color="red">*</font>
                <input type="text" name="txtphone" class="form-control" id="txtphone">
                <font id='err-phone' color="red"></font>
                <div class="clearfix"></div>
            </div>
            <div class='form-group col-sm-6 col-md-4'>
                <label>Email</label><font color="red">*</font>
                <input type="text" name="txtemail" class="form-control" id="txtemail">
                <font id='err-email' color="red"></font>
                <div class="clearfix"></div>
            </div>
            <div class='col-sm-6 col-md-4'>
                <label>Giới tính</label><font color="red">*</font>
                <div class="form-group">
                    <label class="radio-inline"><input type="radio" name="optgender" value="0" checked>Nam</label>
                    <label class="radio-inline"><input type="radio" name="optgender" value="1">Nữ</label>
                    <font id='err-gender' color="red"></font>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class='col-sm-6 col-md-4'>
                <label>Tình trạng</label>
                <div class="form-group">
                    <label class="radio-inline"><input name="optactive" type="radio" value="1" checked>Active</label>
                    <label class="radio-inline"><input name="optactive" type="radio" value="0">Deactive</label>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <!-- <div class='form-group col-sm-6 col-md-4'>
            <label>Nhóm quyền</label>
            <select name="cbo_gmember" id="cbo_gmember" class="form-control">
                <option value="">Chọn nhóm quyền</option>
                <?php
                foreach ($list_guser as $item) {
                    echo '<option value="'.$item['id'].'">'.$item['name'].'</option>';
                }
                ?>
            </select>
            <font id='err-gmember' color="red"></font>
            <div class="clearfix"></div>
        </div> -->
        <section class="hidden">
            <fieldset class="fieldset_roles">
                <legend>Chọn quyền:</legend>
                <?php
                echo '<div class="col-md-12 m-bt-1"><label class="title"><input type="checkbox" onclick="toggle_all(this)">Check All</label></div>';

                foreach ($roles as $item) {
                    echo '<div class="col-xs-6 col-sm-3 col-md-3 box-child">';
                    echo '<label class="title"><input type="checkbox" onclick="toggle(this,'.$item['id'].')" name="_roles[]" value="'.$item['id'].'">'.$item['name'].'</label>';
                    $count = count($item['child']);
                    if($count>0){
                        echo '<ul class="list-child">';
                        foreach ($item['child'] as $item_child) {
                            echo '<li class="checkbox">
                            <label><input type="checkbox" name="_roles[]" data-parent="'.$item['id'].'" value="'.$item_child['id'].'">'.$item_child['name'].'</label>
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

        // Check exist username ajaxs
        $("#txtusername").change(function() {
            var username = $('#txtusername').val();
            $.ajax({
                type: 'POST',
                data: {username : username},
                url: '<?php echo $base_url ?>check_user',
                success: function(result){
                    if(result=='0'){
                        $('#username_result').html('<span class="green"><i class="fa fa-check-square" aria-hidden="true"></i> Tên có thể sử dụng</span>');  
                        $('#chk_user').val('1');
                        $('#err-username').text('');
                    }else{
                        $('#username_result').html('<span class="red"><i class="fa fa-times" aria-hidden="true"></i> Tên đã tồn tại. Vui lòng nhập tên khác</span>');  
                        $('#chk_user').val('0');
                        $('#err-username').text('');
                    }
                }
            });
        })

        // Check validate variable
        $('#frm_action').submit(function(){
            return checkinput();
        })
    })
    
    function checkinput(){
        var lenght_pass = $("#txtpassword").val().length;
        var cur_date    = new Date();
        var cur_time    = cur_date.getTime();
        var birthday    = $('#txtbirthday').val();
        var int_birthday = Math.round(new Date(birthday).getTime());
        var valuePhone  =$("#txtphone").val();
        var phoneno     =/^[\d\.\-]+$/;
        var valueEmail  =$("#txtemail").val();
        var re_email    = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;

        if($('#chk_user').val()=="0") {
            $('#err-username').text('Tên đăng nhập đã có trong hệ thống. Vui lòng nhập tên khác');
            return false;
        }else if($('#chk_user').val()==""){
            $('#err-username').text('Vui lòng điền vào trường này');
            return false;
        }else{
            $('#err-username').text('');
        }

        if($("#txtpassword").val()=="" || lenght_pass<6 || lenght_pass>12){
            $('#err-password').text('Lỗi !');
            return false;
        }else{
            $('#err-password').text('');
        }

        if($("#txtrepass").val()!=$("#txtpassword").val()){
            $('#err-repassword').text('Lỗi !');
            return false;
        }else{
            $('#err-repassword').text('');
        }

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