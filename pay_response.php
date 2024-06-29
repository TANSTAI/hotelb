<?php 

    require('admin/inc/db_config.php');
    require('admin/inc/essentials.php');

    require('inc/paytm/config_paytm.php');
    require('inc/paytm/encdec_paytm.php');
    date_default_timezone_set("Asia/Ho_Chi_Minh");

    session_start();
    unset($_SERVER['room']);


    // if(isset($_GET['partnerCode'])){

    //     $code_order = 'ORD_'.$_SESSION['uId'].random_int(11111,9999999);
    //     $partnerCode= $_GET['partnerCode'];
    //     $orderId= $_GET['orderId'];
    //     $amount= $_GET['amount'];
    //     $orderInfo= $_GET['orderInfo'];
    //     $orderType= $_GET['orderType'];
    //     $transId= $_GET['transId'];
    //     $payType= $_GET['payType'];

    //     //insert datamomo
    //     $insert_momo = "INSERT INTO momo(partner_code,order_id,amount,order_info,order_type,trans_id,pay_type,code_cart)
    //     VALUE('".$partnerCode."','".$orderId."','".$amount."','".$orderInfo."','".$orderType."','".$transId."','".$payType."','".$code_order."') ";
    //     $cart_query = mysqli_query($mysqli,$insert_momo);
    //     if($cart_query){
    //         echo ' <p class="fw-bold alert alert-success">
    //         <i class="bi bi-check-circle-fill"></i>
    //         Thanh Toán Thành Công! Đặt phòng Thành công.
    //         <br></br>
    //         <a href="bookings.php">Đi Tới Hồ Sơ Đặt Phòng</a>
    //       </p>';
    //     }
    //     else{
    //         echo '<p class="fw-bold alert alert-danger">
    //         <i class="bi bi-check-circle-fill"></i>
    //         Thanh toán thất bại ! đặt phòng không thành công.
    //         <br></br>
    //         <a href="bookings.php">Đi Tới Hồ Sơ Đặt Phòng</a>
    //       </p>';
    //     }
    //     redirect('pay_status.php?order='.$_POST['orderId']);

    //   }
    function regenerate_session($uid)
    {
        $user_q = select("SELECT * FROM `user_cred` WHERE `id`=? LIMIT 1",[$uid],'i');
        $user_fetch = mysqli_fetch_assoc($user_q);

        $_SESSION['login'] = true;
        $_SESSION['uId'] = $user_fetch['id'];
        $_SESSION['uName'] = $user_fetch['name'];
        $_SESSION['uPic'] = $user_fetch['profile'];
        $_SESSION['uPhone'] = $user_fetch['phonenum'];
       
    }



    header("Pragma: no-cache");
    header("Cache-Control: no-cache");
    header("Expires: 0");

    
    $paytmChecksum = "";
    $paramList = array();
    $isValidChecksum = "FALSE";

    $paramList = $_POST;
    $paytmChecksum = isset($_POST["CHECKSUMHASH"]) ? $_POST["CHECKSUMHASH"] : ""; //Sent by Paytm pg

    //Verify all parameters received from Paytm pg to your application. Like MID received from paytm pg is same as your application�s MID, TXN_AMOUNT and ORDER_ID are same as what was sent by you to Paytm PG for initiating transaction etc.
    $isValidChecksum = verifychecksum_e($paramList, PAYTM_MERCHANT_KEY, $paytmChecksum); //will return TRUE or FALSE string.


    if($isValidChecksum == "TRUE") 
    {
        $slct_query = "SELECT `booking_id`, `user_id` FROM `booking_order` WHERE `order_id`='$_POST[ORDERID]'";

        $slct_res = mysqli_query($con,$slct_query);
        if(mysqli_num_rows($slct_res)==0){
            redirect('index.php');
        }

        $slct_fetch = mysqli_fetch_assoc($slct_res);

        if(!(isset($_SESSION['login']) && $_SESSION['login'] == true)){
            //regenerate session
            regenerate_session($slct_fetch['user_id']);
        }

        if ($_POST["STATUS"] == "TXN_SUCCESS") 
        {
            $upd_query = "UPDATE `booking_order` SET `booking_status`='booked',
            `trans_id`='$_POST[TXNID]',`trans_amt`='$_POST[TXNAMOUNT]',`trans_status`='$_POST[STATUS]',`trans_resp_msg`='RESPMSG' 
            WHERE `booking_id`='$slct_fetch[booking_id]";

            mysqli_query($con,$upd_query);          
        }
        else {
            $upd_query = "UPDATE `booking_order` SET `booking_status`='payment failed',
            `trans_id`='$_POST[TXNID]',`trans_amt`='$_POST[TXNAMOUNT]',`trans_status`='$_POST[STATUS]',`trans_resp_msg`='RESPMSG' 
            WHERE `booking_id`='$slct_fetch[booking_id]";

            mysqli_query($con,$upd_query);
        }
        redirect('pay_status.php?order='.$_POST['ORDERID']);
    }
    else {
       redirect('index.php');
    }


    

?>


    