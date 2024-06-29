<?php

    require('../inc/db_config.php');
    require('../inc/essentials.php');
    adminLogin();

    if(isset($_POST['get_bookings']))
    {
        $frm_data = filteration($_POST);
        $query = "SELECT bo.*, bd.* FROM `booking_order` bo
        INNER JOIN `booking_detail` bd ON bo.booking_id = bd.booking_id
        WHERE (bo.order_id LIKE ? OR bd.phonenum LIKE ? OR bd.user_name LIKE ?)
        AND (bo.booking_status = ? AND bo.arrival = ?) ORDER BY bo.booking_id ASC";

        $res = select($query,["%$frm_data[search]%","%$frm_data[search]%","%$frm_data[search]%","booked",0],'sssss');
        $i = 1;
        $table_data="";

        if(mysqli_num_rows($res)==0){
            echo"<b>Không tìm thấy dữ liệu!</b>";
            exit;
        }

        while($data = mysqli_fetch_assoc($res))
        {
            $date = date("d-m-Y",strtotime($data['datetime']));
            $checkin = date("d-m-Y",strtotime($data['check_in']));
            $checkout = date("d-m-Y",strtotime($data['check_out']));

            $table_data .="
                <tr>
                    <td>$i</td>
                    <td>
                        <span class='badge bg-primary'>
                            Order ID: $data[order_id]
                        </span>
                        <br>
                        <b>Tên :</b>$data[user_name]
                        <br>
                        <b>Điện thoại :</b>$data[phonenum]
                    </td>
                    <td> 
                        <b>Phòng :</b> $data[room_name]
                        <br>
                        <b>Giá :</b> $data[price]₫
                    </td>
                    <td>
                        <b>Check in:</b> $checkin
                        <br>
                        <b>Check out:</b> $checkout
                        <br>
                        <b>Thành Tiền:</b> $data[trans_amt]₫
                        <br>
                        <b>Ngày:</b> $date
                    </td>
                    <td>
                        <button type='button' onclick='assigh_room($data[booking_id])' class='btn text-white btn-sm fw-bold custom-bg shadow-none' data-bs-toggle='modal' data-bs-target='#assigh-room'>
                        <i class='bi bi-check2-square'></i> Xác Nhận
                        </button>
                        <br>
                        <button type='button' onclick='cancel_booking($data[booking_id])' class='mt-2 btn btn-outline-danger btn-sm fw-bold shadow-none'>
                        <i class='bi bi-trash'></i> Hủy Booking
                        </button>

                    </td>
                </tr>
            ";
            $i++;
        }
        echo $table_data;

    }

    if(isset($_POST['assigh_room']))
    {
        $frm_data = filteration($_POST);

        $query = "UPDATE `booking_order` bo INNER JOIN `booking_detail` bd
        ON bo.booking_id = bd.booking_id
        SET bo.arrival = ?, bo.rate_review = ? ,bd.room_no = ?
        WHERE bo.booking_id=?";

        $values = [1,0,$frm_data['room_no'],$frm_data['booking_id']];

        $res = update($query,$values,'iisi');// it will update 2 rows so it return 2

        echo ($res==2) ? 1 : 0;
    }

    if(isset($_POST['cancel_booking']))
    {
        $frm_data = filteration($_POST);

        $query = "UPDATE `booking_order` SET `booking_status`=?, `refund` = ? WHERE `booking_id`=?";
        $values = ['cancelled',0,$frm_data['booking_id']];
        $res = update($query,$values,'sii');

        echo $res;
    }

?>