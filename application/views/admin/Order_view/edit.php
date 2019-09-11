<?php
$base_url = base_url().'admin/Order/';
$status = -1;
?>
<div id="path">
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url()?>admin">Admin</a></li>
        <li><a href="<?php echo $base_url ?>">Đơn hàng</a></li>
        <li class="active">Thông tin đơn hàng</li>
    </ol>
</div>
<div id="action">
    <small>Các mục đánh dấu <font color="red">*</font> là thông tin bắt buộc</small>
    <div style="color: red">
        <?php
        if(isset($error)){
            echo $error;
        }
        ?>
    </div>
    <h3>Thông tin khách hàng</h3>
    <table class="table table-bordered">
        <tr>
            <td>Họ</td>
            <td><?= $result['lastname'] ?></td>
        </tr>
        <tr>
            <td>Tên</td>
            <td><?= $result['firstname'] ?></td>
        </tr>
        <tr>
            <td>Số điện thoại</td>
            <td><?= $result['phone'] ?></td>
        </tr>
        <tr>
            <td>Email</td>
            <td><?= $result['email'] ?></td>
        </tr>
        <tr>
            <td>Địa chỉ</td>
            <td><?= $result['address'] ?></td>
        </tr>
        <tr>
            <td>Tổng tiền</td>
            <td><?= number_format($result['totalmoney']).' đ' ?></td>
        </tr>
        <tr>
            <td>Trạng thái</td>
            <td>
                <?php
                if($result['status']==1){
                    $status = 1;
                    echo '<b class="red">Đơn hàng mới</b>';
                }else if($result['status'] == 0){
                    $status = 0;
                    echo '<b class="green">Đơn hàng đã hoàn thành</b>';
                }else if($result['status'] == -1){
                    $status = -1;
                    echo '<b>Đơn hàng đã hủy</b>';
                }else if($result['status']==2){
                    $status = 2;
                    echo '<b class="info">Đơn hàng đang xử lý</b>';
                }
                ?>
            </td>
        </tr>
        <tr>
            <td>Comment khách hàng</td>
            <td><?= $result['note'] ?></td>
        </tr>
    </table>
    <h4>Thông tin sản phẩm</h4>
    <table class="table table-bordered">
        <tr>
            <th>STT</th>
            <th>Tên SP</th>
            <th>Mã SP</th>
            <th>Giá</th>
            <th>Số lượng</th>
        </tr>
        <?php
        foreach ($product as $key => $item) {
            echo '<tr>';
            echo '<td>'.($key+1).'</td>';
            echo '<td>'.$item['product']['name'].'</td>';
            echo '<td>'.$item['pro_code'].'</td>';
            echo '<td>'.number_format($item['price']).' đ</td>';
            echo '<td>'.$item['quantity'].'</td>';
            echo '</tr>';
        }
        ?>
    </table>
    <hr>
    <form class="control" method="post" action="<?= $base_url ?>do_update">
        <div class="form-group">
            <?php
            switch ($status) {
                case '1':
                echo '<label class="radio-inline">
                <input name="opt_status" type="radio" value="1" checked>Đơn hàng mới
                </label>
                <label class="radio-inline">
                <input name="opt_status" type="radio" value="2">Đang xử lý
                </label>
                <label class="radio-inline">
                <input name="opt_status" type="radio" value="0">Hoàn thành
                </label>
                <label class="radio-inline">
                <input name="opt_status" type="radio" value="-1">Đã bị hủy
                </label>';
                break;

                case '2':
                echo '
                <label class="radio-inline">
                <input name="opt_status" type="radio" value="2" checked>Đang xử lý
                </label>
                <label class="radio-inline">
                <input name="opt_status" type="radio" value="0">Hoàn thành
                </label>
                <label class="radio-inline">
                <input name="opt_status" type="radio" value="-1">Đã bị hủy
                </label>';
                break;

                case '0':
                echo '
                <label class="radio-inline">
                <input name="opt_status" type="radio" value="0" checked>Hoàn thành
                </label>
                <label class="radio-inline">
                <input name="opt_status" type="radio" value="-1">Đã bị hủy
                </label>';
                break;

                case '-1':
                echo '
                <label class="radio-inline">
                <input name="opt_status" type="radio" value="-1" checked>Đã bị hủy
                </label>';
                break;
                
                default:
                echo '
                <label class="radio-inline">
                <input name="opt_status" type="radio" value="-1" checked>Đã bị hủy
                </label>';
                break;
            }
            ?>
        </div>
        <?php
        if($result['status'] != -1 && $result['status'] != 0){
            echo '<input type="submit" class="btn btn-primary" value="Cập nhật đơn hàng">';
        }
        ?>
    </form>
</div>
