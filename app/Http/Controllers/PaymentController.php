<?php

namespace App\Http\Controllers;


use App\PaymentModel;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        return view('Payment.index');
    }

    public function sendRequest(Request $request)
    {
        $response = [
          'pay_method'          => 'paypay',
          'merchant_id'         => '30132',
          'service_id'          => '001',
          'cust_code'           => 'Merchant_TestUser_999999',
          'sps_cust_no'         => '',
          'sps_payment_no'      => '',
          'order_id'            => random_bytes(30),
          'item_id'             => 'T_0003',
          'pay_item_id'         => '',
          'item_name'           => '',
          'tax'                 => '',
          'amount'              => '1',
          'pay_type'            => '0',
          'auto_charge_type'    => '',
          'service_type'        => '0',
          'div_settele'         => '',
          'last_charge_month'   => '',
          'camp_type'           => '',
          'tracking_id'         => '',
          'terminal_type'       => '0',
            'success_url'           => route('carrier_success'),
            'cancel_url'            => route('carrier_cancel'),
            'error_url'             => route('carrier_error'),
            'pagecon_url'           => route('carrier_request'),
//          'success_url'         => route('carrier_success'),
//          'cancel_url'          => route('carrier_error'),
//          'error_url'           => route('carrier_error'),
//          'pagecon_url'         => route('carrier_error'),
          'free1'               => '',
          'free2'               => '',
          'free3'               => '',
          'free_csv'            => '',
          'request_date'        => date('YmdHis'),
          'limit_second'        => '',
          'hashkey'             => 'c48e0e2c7d04f0954594f14c7801bd430ca6263e',
        ];
        $utf8 = '';
        foreach ($response as $value)
        {
            $utf8 .=$value;
        }
        $response['sps_hashcode'] = sha1($utf8);
        $url = "https://stbfep.sps-system.com/Extra/BuyRequestAction.do";

//        $encryptValue = [
//            'MerchantPass'    => 'u8YyNvFz',
//            'TransactionDate' => date('Ymd'),
//            'MerchantFree1'   => '123123123123',
//            'MerchantFree2'   => 0,
//            'MerchantFree3'   => '',
//            'TenantId'        => '0001',
//            'CarrierKbn'      => sprintf('%02d', 3),
//            'CarrierPass'     => '91e5529089da2485117d4951ef80c5b62485b6a1',
//            'ProcNo'          => sprintf('%020d', date("YmdHis")),
//            'Amount'          => '1',
//            'DisplayItem1'    => '',
//            'SuccesURL'       => 'https://stbfep.sps-system.com/MerchantPaySuccess1.jsp',
//            'CancelURL'       => 'https://stbfep.sps-system.com/MerchantPaySuccess2.jsp',
//            'ErrorURL'        => 'https://stbfep.sps-system.com/MerchantPaySuccess3.jsp',
//            'EndNoticeURL'    => 'https://stbfep.sps-system.com/MerchantPaySuccess4.jsp',
//            'CustomerId'      => '1',
//            'ProductId'       => '1',
//        ];
//        $url = "https://www.test.e-scott.jp/online/cac/OCAC010.do";
//        $request_params = [
//            'MerchantId'   => '00000752',
//            'OperateId'    => '7Gathering',
//            'EncryptValue' => base64_encode(openssl_encrypt(
//                http_build_query($encryptValue), 'aes-128-cbc', 'T7qmXmuRhJ3rFTe8', 1, 'vsermgtwv38257fe'
//            )),
//        ];
        $payment = new PaymentModel();
        $payment->set_connection_url($url);
        $payment->set_connection_timeout(90);
        $return = $payment->sendRequest($response);
        $redirect = true;
        if ($redirect) {
//            // 擬似的にHTTPResponseをparseする。
//            $_res_array = explode("\r\n", mb_convert_encoding($return, 'Shift_JIS', 'UTF-8'));
//            $_is_body = false;
//            $_header = array();
//            $_body = array();
//            foreach ($_res_array as $idx => $_res) {
//                // 空行が見付かるまではヘッダ、空行から先はボディと言う潔いパース。
//                if (empty($_res)) {
//                    $_is_body = true;
//                    continue;
//                }
//                if ($_is_body) {
//                    $_body[] = $_res;
//                } else {
//                    $_header[] = $_res;
//                }
//            }
//            // ヘッダ設定。
////            foreach ($_header as $header) {
////                header($header);
////            }
//            // ボディを流す。
            echo $return;
            exit();


        }

//        $body = '';
//        $return_code = '';
//        if (!$this->pickBody($return, $body, $return_code)) {
//            return array(false, $return_code);
//        }
//
//        $response = array();
//        $tmp = explode('&', $body);
//        foreach ($tmp as $tmp2) {
//            $tmp3 = explode('=', $tmp2);
//            if (count($tmp3) ==0) {
//                continue;
//            }
//            $column = $tmp3[0];
//            $value	= isset($tmp3[1])?$tmp3[1]:'';
//            $response[$column] = $value;
//        }
//        unset($tmp, $tmp2, $tmp3);
////        $response['Token'] = $token;
//
//        // ログに記録
//
//        dd($return_code);

    }
    private function pickBody($response, &$body, &$return_code)
    {
        $message = preg_split('/\\n/', $response, -1, PREG_SPLIT_NO_EMPTY);
        if (count($message) <2) {
            $body = '';
            $return_code = '';
            return false;
        }

        $head = current($message);
        $body = end($message);

        $head_params = preg_split('/ /', $head, -1, PREG_SPLIT_NO_EMPTY);
        if (count($head_params) <2) {
            $body = '';
            $return_code = '';
            return false;
        }

        $return_code = $head_params[1];
        return true;
    }
    public function carrier_success(Request $request)
    {
        $fp = fopen('../storage/success.txt', 'w');//mở file ở chế độ write-only
        fwrite($fp, $request);
        fwrite($fp,date('YmdHis'));
        fclose($fp);
    }
    public function carrier_error(Request $request)
    {
        $fp = fopen('../storage/error.txt', 'w');//mở file ở chế độ write-only
        fwrite($fp, $request);
        fwrite($fp,date('YmdHis'));
        fclose($fp);
    }
    public function carrier_cancel(Request $request)
    {
        $fp = fopen('../storage/cancel.txt', 'w');//mở file ở chế độ write-only
        fwrite($fp, $request);
        fwrite($fp,date('YmdHis'));
        fclose($fp);
    }
    public function carrier_request(Request $request)
    {
        $fp = fopen('../storage/request.txt', 'w');//mở file ở chế độ write-only
        fwrite($fp, $request);
        fwrite($fp,date('YmdHis'));
        fclose($fp);
        return 'OK,';
    }
}
