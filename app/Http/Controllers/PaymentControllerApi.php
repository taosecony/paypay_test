<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentControllerApi extends Controller
{
    public function index()
    {
        return view('Payment.api');
    }

    public function sendRequest(Request $request)
    {
        $response = [
            'merchant_id'         => '30132',
            'service_id'          => '002',
            'cust_code'           => 'Merchant_TestUser_999999',
            'order_id'            => rand(),
            'item_id'             => 'ITEMID00000000000000000000000001',
            'item_name'           => 'テスト商品',
            'tax'                 => '1',
            'amount'              => '1',
            'free1'               => '',
            'free2'               => '',
            'free3'               => '',
            'order_rowno'         => '',
            'sps_cust_info_return_flg'         => '1',
            'cc_number'           => '5250729026209007',
            'cc_expiration'       => '201103',
            'security_code'       => '798',
            'cust_manage_flg'     => '0',
            'encrypted_flg'       => '0',
            'request_date'        => date('YmdHis'),
            'limit_second'        => '',
            'hashkey'             => '8435dbd48f2249807ec216c3d5ecab714264cc4a',
        ];
        $encryptValue = '';
        foreach ($response as $value)
        {
            $encryptValue .= mb_convert_encoding($value, 'Shift_JIS', 'UTF-8');
        }
        $response['sps_hashcode'] = sha1($encryptValue);
        $postData = "<?xml version=\"1.0\" encoding=\"Shift_JIS\"?>" .
                    "<sps-api-request id=\"ST01-00101-101\">" .
                    "<merchant_id>"                 . $response['merchant_id']              . "</merchant_id>" .
                    "<service_id>"                  . $response['service_id']               . "</service_id>" .
                    "<cust_code>"                   . $response['cust_code']                . "</cust_code>" .
                    "<order_id>"                    . $response['order_id']                 . "</order_id>" .
                    "<item_id>"                     . $response['item_id']                  . "</item_id>" .
                    "<item_name>"                   . base64_encode($response['item_name']) . "</item_name>" .
                    "<tax>"                         . $response['tax']                      . "</tax>" .
                    "<amount>"                      . $response['amount']                   . "</amount>" .
                    "<free1>"                       . base64_encode($response['free1'])     . "</free1>" .
                    "<free2>"                       . base64_encode($response['free2'])     . "</free2>" .
                    "<free3>"                       . base64_encode($response['free3'])     . "</free3>" .
                    "<order_rowno>"                 . $response['order_rowno']              . "</order_rowno>" .
                    "<sps_cust_info_return_flg>"    . $response['sps_cust_info_return_flg'] . "</sps_cust_info_return_flg>" .
                    "<dtls>" .
                    "</dtls>" .
                    "<pay_method_info>" .
                        "<cc_number>"                 . $response['cc_number']                . "</cc_number>" .
                        "<cc_expiration>"             . $response['cc_expiration']            . "</cc_expiration>" .
                        "<security_code>"             . $response['security_code']            . "</security_code>" .
                        "<cust_manage_flg>"           . $response['cust_manage_flg']          . "</cust_manage_flg>" .
                    "</pay_method_info>" .
                    "<pay_option_manage>" .
                    "</pay_option_manage>" .
                    "<encrypted_flg>"               . $response['encrypted_flg']            . "</encrypted_flg>" .
                    "<request_date>"                . $response['request_date']             . "</request_date>" .
                    "<limit_second>"                . $response['limit_second']             . "</limit_second>" .
                    "<sps_hashcode>"                . $response['sps_hashcode']             . "</sps_hashcode>" .
            "</sps-api-request>";
//        53111130191393


        $url = "https://stbfep.sps-system.com/api/xmlapi.do";

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $url,
            CURLOPT_USERAGENT => 'Exmaple POST',
            CURLOPT_POST => 1,
            CURLOPT_SSL_VERIFYPEER => true, //Bỏ kiểm SSL
            CURLOPT_POSTFIELDS => http_build_query($response)
        ));
        $resp = curl_exec($curl);

        var_dump($resp);

        curl_close($curl);

//        $req =new HTTP_Request($url);
//        $req->setBasicAuth($response['merchant_id'] . $response['service_id'] , $response['hashkey'] );
//        $req->setMethod(HTTP_REQUEST_METHOD_POST);
//        $req->addHeader("Content-Type", "text/xml");
//        $req->addRawPostData($postData);
//        $res = $req->sendRequest();
//
//// 戻りデータ設定
//        if( !PEAR::isError($res) ) {
//
//            if( $req->getResponseCode() == "200" ) {
//                // SUCCESS
//                echo $req->getResponseBody();
//            }
//            else {
//                return 'error1';
//            }
//        }
//        else {
//            return 'error2';
//        }

    }

    public function carrier_success(Request $request)
    {

    }

    public function carrier_error(Request $request)
    {

    }

    public function carrier_request(Request $request)
    {

    }
}
