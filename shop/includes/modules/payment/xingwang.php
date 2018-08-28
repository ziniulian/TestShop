<?php
/**
 * ECSHOP 通联插件
 * ============================================================================
 * * 版权所有 2005-2012 上海商派网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.ecshop.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: liubo $
 * $Id: xingwang.php 17217 2011-01-19 06:29:08Z liubo $
 */

if (!defined('IN_ECS'))
{
    die('Hacking attempt');
}

$payment_lang = ROOT_PATH . 'languages/' . $GLOBALS['_CFG']['lang'] . '/payment/xingwang.php';

if (file_exists($payment_lang))
{
    global $_LANG;

    include_once($payment_lang);
}

/**
 * 模块信息
 */
if (isset($set_modules) && $set_modules == true)
{
    $i = isset($modules) ? count($modules) : 0;

    /* 代码 */
    $modules[$i]['code'] = basename(__FILE__, '.php');

    /* 描述对应的语言项 */
    $modules[$i]['desc'] = 'xingwang_desc';

    /* 是否支持货到付款 */
    $modules[$i]['is_cod'] = '0';

    /* 是否支持在线支付 */
    $modules[$i]['is_online'] = '1';

    /* 作者 */
    $modules[$i]['author']  = '西安昊海网络';

    /* 网址 */
    $modules[$i]['website'] = 'http://www.xaphp.cn/';

    /* 版本号 */
    $modules[$i]['version'] = 'v1.0';

    /* 配置信息 */
    $modules[$i]['config'] = array(
        array('name' => 'xingwang_account', 'type' => 'text', 'value' => ''),
        array('name' => 'xingwang_key', 'type' => 'text', 'value' => ''),
    );

    return;

}

class xingwang
{
    /**
     * 构造函数
     *
     * @access  public
     * @param
     *
     * @return void
     */

    function xingwang()
    {
    }

    function __construct()
    {
        $this->xingwang();
    }

   /**
     * 生成支付代码
     * @param   array   $order  订单信息
     * @param   array   $payment    支付方式信息
     */
   function get_code($order, $payment)
   {
       $merchantId         = trim($payment['xingwang_account']);                 //商户号
       $order_id           = $order['order_sn'];                                    //商户订单号 不可空
	  // $order_amount =explode("." 
       $order_amount       = intval($order['order_amount']*100);                       //商户订单金额 不可空
       $order_time         = local_date('YmdHis', $order['add_time']);            //商户订单提交时间 不可空 14位
       $payType           = '1';                                                //支付方式 不可空
       $receiveUrl         = return_url(basename(__FILE__, '.php'));
       $receiveUrl         = return_url(basename(__FILE__, '.php'));
       $product_desc       = '';
       $key                = trim($payment['xingwang_key']);
	   

        /* 生成加密签名串 请务必按照如下顺序和规则组成加密串！*/
	

	$serverUrl='https://ceshi.allinpay.com/gateway/index.do';	// 测试环境
	// $serverUrl='https://service.allinpay.com/gateway/index.do';	// 生产环境
	$inputCharset='';
	$pickupUrl=$receiveUrl;
	$receiveUrl=$receiveUrl;
	$version='v1.0';
	$language='';
	$signType=1;
	$merchantId=$merchantId;
	$payerName='';
	$payerEmail='';	
	$payerTelephone='';
	$payerIDCard='';
	$pid='';
	$orderNo=$order_id;
	$orderAmount=$order_amount;
	$orderDatetime=$order_time;
	$orderCurrency='';
	$orderExpireDatetime='';
	$productName='';
	$productId='';
	$productPrice='';
	$productNum='';
	$productDesc='';
	$ext1='';
	$ext2='';
	$extTL='';
	$payType=0; //payType   不能为空，必须放在表单中提交。
	$issuerId=''; //issueId 直联时不为空，必须放在表单中提交。
	$pan='';	
	$tradeNature='';
	$key=$key; 

	// 生成签名字符串。
	$bufSignSrc=""; 
	if($inputCharset != "")
	$bufSignSrc=$bufSignSrc."inputCharset=".$inputCharset."&";		
	if($pickupUrl != "")
	$bufSignSrc=$bufSignSrc."pickupUrl=".$pickupUrl."&";		
	if($receiveUrl != "")
	$bufSignSrc=$bufSignSrc."receiveUrl=".$receiveUrl."&";		
	if($version != "")
	$bufSignSrc=$bufSignSrc."version=".$version."&";		
	if($language != "")
	$bufSignSrc=$bufSignSrc."language=".$language."&";		
	if($signType != "")
	$bufSignSrc=$bufSignSrc."signType=".$signType."&";		
	if($merchantId != "")
	$bufSignSrc=$bufSignSrc."merchantId=".$merchantId."&";		
	if($payerName != "")
	$bufSignSrc=$bufSignSrc."payerName=".$payerName."&";		
	if($payerEmail != "")
	$bufSignSrc=$bufSignSrc."payerEmail=".$payerEmail."&";		
	if($payerTelephone != "")
	$bufSignSrc=$bufSignSrc."payerTelephone=".$payerTelephone."&";			
	if($payerIDCard != "")
	$bufSignSrc=$bufSignSrc."payerIDCard=".$payerIDCard."&";			
	if($pid != "")
	$bufSignSrc=$bufSignSrc."pid=".$pid."&";		
	if($orderNo != "")
	$bufSignSrc=$bufSignSrc."orderNo=".$orderNo."&";
	if($orderAmount != "")
	$bufSignSrc=$bufSignSrc."orderAmount=".$orderAmount."&";
	if($orderCurrency != "")
	$bufSignSrc=$bufSignSrc."orderCurrency=".$orderCurrency."&";
	if($orderDatetime != "")
	$bufSignSrc=$bufSignSrc."orderDatetime=".$orderDatetime."&";
	if($orderExpireDatetime != "")
	$bufSignSrc=$bufSignSrc."orderExpireDatetime=".$orderExpireDatetime."&";
	if($productName != "")
	$bufSignSrc=$bufSignSrc."productName=".$productName."&";
	if($productPrice != "")
	$bufSignSrc=$bufSignSrc."productPrice=".$productPrice."&";
	if($productNum != "")
	$bufSignSrc=$bufSignSrc."productNum=".$productNum."&";
	if($productId != "")
	$bufSignSrc=$bufSignSrc."productId=".$productId."&";
	if($productDesc != "")
	$bufSignSrc=$bufSignSrc."productDesc=".$productDesc."&";
	if($ext1 != "")
	$bufSignSrc=$bufSignSrc."ext1=".$ext1."&";
	if($ext2 != "")
	$bufSignSrc=$bufSignSrc."ext2=".$ext2."&";
	if($extTL != "")
	$bufSignSrc=$bufSignSrc."extTL".$extTL."&";
	if($payType != "5")
	$bufSignSrc=$bufSignSrc."payType=".$payType."&";		
	if($issuerId != "")
	$bufSignSrc=$bufSignSrc."issuerId=".$issuerId."&";
	if($pan != "")
	$bufSignSrc=$bufSignSrc."pan=".$pan."&";	
	if($tradeNature != "")
	$bufSignSrc=$bufSignSrc."tradeNature=".$tradeNature."&";	
	$bufSignSrc=$bufSignSrc."key=".$key; //key为MD5密钥，密钥是在通联支付网关商户服务网站上设置。
	//签名，设为signMsg字段值。
	$signMsg = strtoupper(md5($bufSignSrc));
	//echo $bufSignSrc;
	 
	// echo $signMsg;exit;
	 
	 $html ='';
	 $html .='<form name="form2" action="http://ceshi.allinpay.com/gateway/index.do" method="post">';	// 测试环境
	 // $html .='<form name="form2" action="http://service.allinpay.com/gateway/index.do" method="post">';	// 生产环境
	 $html .='<input type="hidden" name="inputCharset" id="inputCharset" value="'.$inputCharset.'" />';
	 $html .='<input type="hidden" name="pickupUrl" id="pickupUrl" value="'.$pickupUrl.'"/>';
	 $html .='<input type="hidden" name="receiveUrl" id="receiveUrl" value="'.$receiveUrl.'"/>';
	 $html .='<input type="hidden" name="version" id="version" value="'.$version.'"/>';
	 $html .='<input type="hidden" name="language" id="language" value="'.$language.'" />';
	 $html .='<input type="hidden" name="signType" id="signType" value="'.$signType.'"/>';
	 $html .='<input type="hidden" name="merchantId" id="merchantId" value="'.$merchantId.'" />';
	 $html .='<input type="hidden" name="payerName" id="payerName" value="'.$payerName.'"/>';
	 $html .='<input type="hidden" name="payerEmail" id="payerEmail" value="'.$payerEmail.'" />';
	 $html .='<input type="hidden" name="payerTelephone" id="payerTelephone" value="'.$payerTelephone.'" />';
	 $html .='<input type="hidden" name="payerIDCard" id="payerIDCard" value="'.$payerIDCard.'" />';
	 $html .='<input type="hidden" name="pid" id="pid" value="'.$pid.'"/>';
	 $html .='<input type="hidden" name="orderNo" id="orderNo" value="'.$orderNo.'" />';
	 $html .='<input type="hidden" name="orderAmount" id="orderAmount" value="'.$orderAmount.'"/>';
	 $html .='<input type="hidden" name="orderCurrency" id="orderCurrency" value="'.$orderCurrency.'" />';
	 $html .='<input type="hidden" name="orderDatetime" id="orderDatetime" value="'.$orderDatetime.'" />';
	 $html .='<input type="hidden" name="orderExpireDatetime" id="orderExpireDatetime" value="'.$orderExpireDatetime.'"/>';
	 $html .='<input type="hidden" name="productName" id="productName" value="'.$productName.'" />';
	 $html .='<input type="hidden" name="productPrice" id="productPrice" value="'.$productPrice.'" />';
	 $html .='<input type="hidden" name="productNum" id="productNum" value="'.$productNum.'"/>';	
	 $html .='<input type="hidden" name="productId" id="productId" value="'.$productId.'" />';
	 $html .='<input type="hidden" name="productDesc" id="productDesc" value="'.$productDesc.'" />';
	 $html .='<input type="hidden" name="ext1" id="ext1" value="'.$ext1.'" />';
	 $html .='<input type="hidden" name="ext2" id="ext2" value="'.$ext2.'" />';
	 $html .='<input type="hidden" name="extTL" id="extTL" value="'.$extTL.'" />';
	 $html .='<input type="hidden" name="payType" value="'.$payType.'" />';
	 $html .='<input type="hidden" name="issuerId" value="'.$issuerId.'" />';
	 $html .='<input type="hidden" name="pan" value="'.$pan.'" />';
	 $html .='<input type="hidden" name="tradeNature" value="'.$tradeNature.'" />';
	 $html .='<input type="hidden" name="signMsg" id="signMsg" value="'.$signMsg.'" />';
	 $html .='<div align="center"><input type="submit" value="确认付款，到通联支付去啦" align=center/>';
	 $html .='</div>';
	 $html .='</form>';
        return $html;
    }
/**
     * 响应操作
     */
    function respond()
    {
		  require_once("php_rsa.php"); 
	
		
		  $merchantId=$_POST["merchantId"];
		  $version=$_POST['version'];
		  $language=$_POST['language'];
		  $signType=$_POST['signType'];
		  $payType=$_POST['payType'];
		  $issuerId=$_POST['issuerId'];
		  $paymentOrderId=$_POST['paymentOrderId'];
		  $orderNo=$_POST['orderNo'];
		  $orderDatetime=$_POST['orderDatetime'];
		  $orderAmount=$_POST['orderAmount'];
		  $payDatetime=$_POST['payDatetime'];
		  $payAmount=$_POST['payAmount'];
		  $ext1=$_POST['ext1'];
		  $ext2=$_POST['ext2'];
		  $payResult=$_POST['payResult'];
		  $errorCode=$_POST['errorCode'];
		  $returnDatetime=$_POST['returnDatetime'];
		  $signMsg=$_POST["signMsg"];
		  $bufSignSrc="";
		  if($merchantId != "")
		  $bufSignSrc=$bufSignSrc."merchantId=".$merchantId."&";		
		  if($version != "")
		  $bufSignSrc=$bufSignSrc."version=".$version."&";		
		  if($language != "")
		  $bufSignSrc=$bufSignSrc."language=".$language."&";		
		  if($signType != "")
		  $bufSignSrc=$bufSignSrc."signType=".$signType."&";		
		  if($payType != "")
		  $bufSignSrc=$bufSignSrc."payType=".$payType."&";
		  if($issuerId != "")
		  $bufSignSrc=$bufSignSrc."issuerId=".$issuerId."&";
		  if($paymentOrderId != "")
		  $bufSignSrc=$bufSignSrc."paymentOrderId=".$paymentOrderId."&";
		  if($orderNo != "")
		  $bufSignSrc=$bufSignSrc."orderNo=".$orderNo."&";
		  if($orderDatetime != "")
		  $bufSignSrc=$bufSignSrc."orderDatetime=".$orderDatetime."&";
		  if($orderAmount != "")
		  $bufSignSrc=$bufSignSrc."orderAmount=".$orderAmount."&";
		  if($payDatetime != "")
		  $bufSignSrc=$bufSignSrc."payDatetime=".$payDatetime."&";
		  if($payAmount != "")
		  $bufSignSrc=$bufSignSrc."payAmount=".$payAmount."&";
		  if($ext1 != "")
		  $bufSignSrc=$bufSignSrc."ext1=".$ext1."&";
		  if($ext2 != "")
		  $bufSignSrc=$bufSignSrc."ext2=".$ext2."&";
		  if($payResult != "")
		  $bufSignSrc=$bufSignSrc."payResult=".$payResult."&";
		  if($errorCode != "")
		  $bufSignSrc=$bufSignSrc."errorCode=".$errorCode."&";
		  if($returnDatetime != "")
		  $bufSignSrc=$bufSignSrc."returnDatetime=".$returnDatetime;
		  
		
		  //验签
		  //解析publickey.txt文本获取公钥信息
		  $publickeyfile = ROOT_PATH.'/includes/modules/payment/publickey.txt';
		
		  $publickeycontent = file_get_contents($publickeyfile);
			// echo "<br>".$publickeycontent."dddddddddddd";exit;
			 //  echo "sdfsdf";exit;
		  $publickeyarray = explode(PHP_EOL, $publickeycontent);
		  
		//  print_r($publickeyarray);exit;
		  
		 // $publickey = explode('=',$publickeyarray[0]);
		  //$modulus = explode('=',$publickeyarray[1]);
		  $publickey = explode('=','exponent=65537');
		  $modulus = explode('=','modulus=138160948945050723511254051873625661786815263514865951691880964086020498952475353694719429065578331848498697383672390998308040150215924720100066025651233307499589395728978328151790447094401222788922912726800979265458221369074659412137338344430928154114331278308595487275121241457999008683550649484117133755109');
			// echo "<br>publickey=".$publickey[1];
			//  echo "<br>modulus=".$modulus[1];
		  $keylength = 1024;
		  //验签结果
		  $verify_result = rsa_verify($bufSignSrc,$signMsg, $publickey[1], $modulus[1], $keylength,"sha1");
		  $value = null;
		  //echo $verify_result."dddddddddddd";
		  if($verify_result){
			  $value = "报文验签成功！";
			 // echo "1";
		  }
		  else{
			  $value = "报文验签失败！";
			 // echo "2";
		  }
		  //验签成功，还需要判断订单状态，为"1"表示支付成功。
		  $payvalue = null;
		  $pay_result = false;
		  // if($verify_result and $payResult == 1){
		  if($payResult == 1){
			  $pay_result = true;
			  $pay_log_id = get_order_id_by_sn($orderNo);
          	 order_paid($pay_log_id);
//                order_paid($ext1);
             return true;			
		  }else{
			 return false;
		  }		
  }
    /**
    * 将变量值不为空的参数组成字符串
    * @param   string   $strs  参数字符串
    * @param   string   $key   参数键名
    * @param   string   $val   参数键对应值
    */
    function append_param($strs,$key,$val)
    {
//        if($strs != "")
//        {
//            if($key != '' && $val != '')
//            {
//                $strs .= '&' . $key . '=' . $val;
//            }
//        }
//        else
//        {
//            if($val != '')
//            {
//                $strs = $key . '=' . $val;
//            }
//        }
		$strs .= $val;
            return $strs;
    }
}
?>