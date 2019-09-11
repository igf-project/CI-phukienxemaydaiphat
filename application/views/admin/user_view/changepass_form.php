<?php 
$base_url = base_url().'admin/users/';
?>
<div id="path">
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url()?>admin">Admin</a></li>
        <li><a href="<?php echo $base_url?>">User</a></li>
        <li class="active">Changepass</li>
    </ol>
</div>
<div id="action">
    <?php
    if (isset($success_message)) {
        echo $success_message;
    }
    if (isset($error_message)) {
        echo $error_message;
    }
    ?>
    <small>Các mục đánh dấu <font color="red">*</font> là thông tin bắt buộc</small><hr/>
    <form id="frm_action" name="frm_action" method="post" action="<?php echo $base_url ?>do_changepass">
        <input type="hidden" name="txtid" value="<?php echo $row_user['id']?>">
        <div class="row">
            <span id="msgbox" style="display:none"></span>
            <div class='form-group col-md-4'>
                <label>Tên đăng nhập</label><font color="red">*</font>
                <input type="text" name="txtusername" class="form-control" id="txtusername" value="<?php echo $row_user['username']?>" readonly>
                <font id='err-username' color="red"></font>
            </div>
            <div class='form-group col-md-4'>
                <label>Mật khẩu mới</label><font color="red">*</font><small> ( 6-12 ký tự )</small>
                <input type="password" name="txtpassword" class="form-control" id="txtpassword">
                <font id='err-password' color="red"></font>
                <div class="clearfix"></div>
            </div>
            <div class='form-group col-md-4'>
                <label>Nhập lại mật khẩu mới</label><font color="red">*</font>
                <input type="password" name="txtrepass" class="form-control" id="txtrepass">
                <font id='err-repassword' color="red"></font>
                <div class="clearfix"></div>
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
    $(document).ready(function() {
        // Check validate variable
        $('#frm_action').submit(function(){
            return checkinput();
        })
    })

    function checkinput(){
        var lenght_pass = $("#txtpassword").val().length;
        
        if($("#txtpassword").val()=="" || lenght_pass<6 || lenght_pass>12){
            $('#err-password').text('Mật khẩu có độ dài lớn hơn 6 ký tự và nhỏ hơn 12 ký tự!');
            return false;
        }else{
            $('#err-password').text('');
        }

        if($("#txtrepass").val()!=$("#txtpassword").val()){
            $('#err-repassword').text('Nhập lại mật khẩu không trùng khớp !');
            return false;
        }else{
            $('#err-repassword').text('');
        }
        return true;
    }
</script>