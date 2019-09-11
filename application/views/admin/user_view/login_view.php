<div class="page-container">
    <?php
    $err='';
    if(isset($_POST['submit'])){
        $user=addslashes($_POST['txtuser']);
        $pass=addslashes($_POST['txtpass']);
        $serc=addslashes($_POST['txt_sercurity']);
        if($_SESSION['SERCURITY_CODE']!=$serc)
            $err='<font color="red">Mã bảo mật không chính xác</font>';
        else{
            global $UserLogin;
            if($UserLogin->LOGIN($user,$pass)==true)
                echo '<script language="javascript">window.location.href="index.php"</script>';
            else
                $err='<font color="red">Đăng nhập không thành công.</font>';
        }
    }
    ?>
    <form id="frm_login" name="frm_login" method="post" action="" AUTOCOMPLETE="off" >
        <div class="header-login">
            <h3>Đăng nhập hệ thống</h3>
            <p>Nếu chưa có tài khoản bạn vui lòng liên hệ Admin</p>
        </div>
        <div class="content">
            <p style="color: red"><?php echo $err;?></p>
            <div class="form-group">
                <label for="txtuser">Tên đăng nhập</label>
                <input type="text" class="form-control" name="txtuser" id="txtuser"  placeholder="Tên đăng nhập">
            </div>
            <div class="form-group">
                <label for="txtpass">Password</label>
                <input type="password" class="form-control" name="txtpass" id="txtpass" placeholder="Nhập mật khẩu">
            </div>
            <div class="form-group">
                <label for="">Mã bảo mật</label>
                <div class="row">
                    <div class="col-md-4">
                        <input  type="text" size="7" name="txt_sercurity" id="txt_sercurity" class="form-control"/>
                    </div>
                    <div class="col-md-6">
                        <img src="extensions/captcha/CaptchaSecurityImages.php?width=90&height=32" align="left" alt="" />
                    </div>
                </div>
            </div>
            <input type="submit" name="submit" id="submit" value="Đăng nhập" class="btn btn-default btn-block">
        </div>
    </form>
</div>