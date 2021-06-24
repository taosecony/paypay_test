<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentModel extends Model
{
    private $connection_url;		// 接続先URL アドレス
    private $connection_timeout;	// 通信タイムアウト


    public function __construct()
    {
        // プロパティ初期化
        $this->connection_url = '';
        $this->connection_timeout = 600;
    }





    /**
     *
     *	接続先URL アドレスの設定
     */
    public function set_connection_url($connection_url ='')
    {
        $this->connection_url = $connection_url;
    }





    /**
     *
     *	接続先URL アドレスの取得
     */
    public function get_connection_url()
    {
        return $this->connection_url;
    }





    /**
     *
     *	通信タイムアウト時間（s）の設定
     */
    public function set_connection_timeout($connection_timeout =0)
    {
        $this->connection_timeout = $connection_timeout;
    }





    /**
     *
     *	通信タイムアウト時間（s）の取得
     */
    public function get_connection_timeout()
    {
        return $this->connection_timeout;
    }
    public function sendRequest($param_list)
    {
        $html = '';
        $html .= '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"><html><head><title></title></head>';
        $html .= '<body onload="javascript:document.forms['."'form1'".'].submit();">';
        $html .= '<form action=" '.$this->connection_url.'" method="post" id="form1">';
        foreach ($param_list as $key => $val)
        {
            $html .= '<input type="hidden" name="'.$key.'" value="'.$val.'" />';
        }
        $html .= '</form></body></html>';
        return $html;
//        $rValue = array();
//
//
//
//        if (empty($param_list)) {
//            dd('empty param_list');
//            return array();
//        }
//
//
//
//        // 送信データ作成
//        $url = parse_url($this->connection_url);
//        $http_data = '';
//        reset($param_list);
//        foreach ($param_list as $key => $value) {
//            $http_data .= (($http_data!=='') ? '&' : '') . $key . '=' . urlencode($value);
//        }
//        $http_header = "POST " . $url['path'] . " HTTP/1.0" . "\r\n" .
//            "User-Agent:SLN_PAYMENT_CLIENT_PG_PHP_VERSION_1_0" . "\r\n" .
//            "Content-Type:application/x-www-form-urlencoded" . "\r\n" .
//            "Content-Length:" . strlen($http_data);
//        $http_post = $http_header . "\r\n\r\n" . $http_data;
//
//
//
//        // 送信処理
//        $errno = 0;
//        $errstr = '';
//        $hm = array();
//        // ソケット通信接続
//        $fp = fsockopen('ssl://' . $url['host'], 443, $errno, $errstr, $this->connection_timeout);
//        if ($fp == false) {
//            dd('fp = false');
//            return array();
//        }
//
//
//
//        // 接続後タイムアウト設定
//        $result = socket_set_timeout($fp, $this->connection_timeout);
//        if ($result == false) {
//            dd('timeout');
//            return array();
//        }
//
//
//
//        // データ送信受信
//        fwrite($fp, $http_post);
//        $response_data = '';
//        while (!feof($fp)) {
//            $response_data .= fgets($fp, 4096);
//        }
//        // ソケット通信情報を取得
//        $hm = stream_get_meta_data($fp);
//        // ソケット通信切断
//        $result = fclose($fp);
//
//
//
//        if ($result !== true) {
//            dd('SLN との切断に失敗しました');
//            return array();
//        }
//        if ($hm['timed_out'] !== true) {
//            // レスポンスデータ生成
//            $rValue = $response_data ;
//        }
//        else {
//            // エラー： タイムアウト発生
//            dd('通信中にタイムアウトが発生しました');
//            return array();
//        }
//
//
//        return $rValue;
    }
}
