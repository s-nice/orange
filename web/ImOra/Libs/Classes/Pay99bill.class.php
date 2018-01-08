<?php
namespace Classes;
/**
 * 快钱支付类
 * @author jiyl
 * @date   2016-12-07
 * use \Classes\Pay99bill as PayBill;
 * $payObj = PayBill::init(C('CONFIG_99BILL_AcctId'),C('PEM_99BILL'));
 */
class Pay99bill
{
	protected $merchantAcctId = ''; 
	protected $pem_99bill = '';

	/**
	 * 实例化块钱支付
	 * @param string $merchantAcctId 接收款项的人民币账号 必填
	 * @param string $pem99bill 证书文件绝对路径 必填
	 * @return NULL|\Classes\Pay99bill
	 */
	static function init($merchantAcctId='',$pem99bill='')
	{
		if($merchantAcctId == '' || $pem99bill == '' || !is_file($pem99bill)){
			return NULL;
		}else{
			$obj = new Pay99bill();
			$obj->merchantAcctId = $merchantAcctId;
			$obj->pem_99bill = $pem99bill;
			return $obj;
		}
	}
	/**
	 * 获得支付相关参数
	 * @param array $newParams 支付相关参数默认值
	 * @return array $params 返回支付支付参数数组
	 */
	public function getParams($newParams= array())
	{
		$params = array(
    			//人民币网关账号，该账号为11位人民币网关商户编号+01,该参数必填。
    			'merchantAcctId'=>$this->merchantAcctId,
    			//编码方式，1代表 UTF-8; 2 代表 GBK; 3代表 GB2312 默认为1,该参数必填。
    			'inputCharset'=>"1",
    			//接收支付结果的页面地址，该参数一般置为空即可。
    			'pageUrl' => "",
    			//服务器接收支付结果的后台地址，该参数务必填写，不能为空。
    			'bgUrl' => "",
    			//网关版本，固定值：v2.0,该参数必填。
    			'version' =>  "v2.0",
    			//语言种类，1代表中文显示，2代表英文显示。默认为1,该参数必填。
    			'language' =>  "1",
    			//签名类型,该值为4，代表PKI加密方式,该参数必填。
    			'signType' =>  "4",
    			//支付人姓名,可以为空。
    			'payerName'=> "",
    			//支付人联系类型，1 代表电子邮件方式；2 代表手机联系方式。可以为空。
    			'payerContactType' =>  "1",
    			//支付人联系方式，与payerContactType设置对应，payerContactType为1，则填写邮箱地址；payerContactType为2，则填写手机号码。可以为空。
    			'payerContact' =>  "",
    			//商户订单号，以下采用时间来定义订单号，商户可以根据自己订单号的定义规则来定义该值，不能为空。
    			'orderId' => '',
    			//订单金额，金额以“分”为单位，商户测试以1分测试即可，切勿以大金额测试。该参数必填。
    			'orderAmount' => "0",
    			//订单提交时间，格式：yyyyMMddHHmmss，如：20071117020101，不能为空。
    			'orderTime' => date("YmdHis"),
    			//商品名称，可以为空。
    			'productName'=> "",
    			//商品数量，可以为空。
    			'productNum'=> "",
    			//商品代码，可以为空。
    			'productId' => "",
    			//商品描述，可以为空。
    			'productDesc' => "",
    			//扩展字段1，商户可以传递自己需要的参数，支付完快钱会原值返回，可以为空。
    			'ext1' => "",
    			//扩展自段2，商户可以传递自己需要的参数，支付完快钱会原值返回，可以为空。
    			'ext2' => "",
    			//支付方式，一般为00，代表所有的支付方式。如果是银行直连商户，该值为10，必填。
    			'payType' => "00",
    			//银行代码，如果payType为00，该值可以为空；如果payType为10，该值必须填写，具体请参考银行列表。
    			'bankId' => "",
    			//同一订单禁止重复提交标志，实物购物车填1，虚拟产品用0。1代表只能提交一次，0代表在支付不成功情况下可以再提交。可为空。
    			'redoFlag' => "",
    			//快钱合作伙伴的帐户号，即商户编号，可为空。
    			'pid' => "");
		$params = array_merge($params,$newParams);
		return $params;
    }
    /**
     * 获取签名
     * @param array $params
     * @return string $payKey
     */
    public function createPayKey($params){
    	$param = $this->getParams();
    	$param = array_merge($param,$params);
    	// signMsg 签名字符串 不可空，生成加密签名串
    	$kq_all_para = $this->kq_ck_null($param['inputCharset'],'inputCharset');
    	$kq_all_para .= $this->kq_ck_null($param['pageUrl'],"pageUrl");
    	$kq_all_para .= $this->kq_ck_null($param['bgUrl'],'bgUrl');
    	$kq_all_para .= $this->kq_ck_null($param['version'],'version');
    	$kq_all_para .= $this->kq_ck_null($param['language'],'language');
    	$kq_all_para .= $this->kq_ck_null($param['signType'],'signType');
    	$kq_all_para .= $this->kq_ck_null($param['merchantAcctId'],'merchantAcctId');
    	$kq_all_para .= $this->kq_ck_null($param['payerName'],'payerName');
    	$kq_all_para .= $this->kq_ck_null($param['payerContactType'],'payerContactType');
    	$kq_all_para .= $this->kq_ck_null($param['payerContact'],'payerContact');
    	$kq_all_para .= $this->kq_ck_null($param['orderId'],'orderId');
    	$kq_all_para .= $this->kq_ck_null($param['orderAmount'],'orderAmount');
    	$kq_all_para .= $this->kq_ck_null($param['orderTime'],'orderTime');
    	$kq_all_para .= $this->kq_ck_null($param['productName'],'productName');
    	$kq_all_para .= $this->kq_ck_null($param['productNum'],'productNum');
    	$kq_all_para .= $this->kq_ck_null($param['productId'],'productId');
    	$kq_all_para .= $this->kq_ck_null($param['productDesc'],'productDesc');
    	$kq_all_para .= $this->kq_ck_null($param['ext1'],'ext1');
    	$kq_all_para .= $this->kq_ck_null($param['ext2'],'ext2');
    	$kq_all_para .= $this->kq_ck_null($param['payType'],'payType');
    	$kq_all_para .= $this->kq_ck_null($param['bankId'],'bankId');
    	$kq_all_para .= $this->kq_ck_null($param['redoFlag'],'redoFlag');
    	$kq_all_para .= $this->kq_ck_null($param['pid'],'pid');
    	 
    	/*// 顺序问题 不可打乱顺序
    	 $kq_all_para = '';
    	foreach($param as $k=>$v){
    	$kq_all_para.=kq_ck_null($v,$k);
    	}*/
    
    	$kq_all_para=substr($kq_all_para,0,strlen($kq_all_para)-1);
    
    	/////////////  RSA 签名计算 ///////// 开始 //
    	$fp = fopen($this->pem_99bill, "r");
    	$priv_key = fread($fp, 123456);
    	fclose($fp);
    	$pkeyid = openssl_get_privatekey($priv_key);
    
    	// compute signature
    	openssl_sign($kq_all_para, $signMsg, $pkeyid,OPENSSL_ALGO_SHA1);
    
    	// free the key from memory
    	openssl_free_key($pkeyid);
    
    	$signMsg = base64_encode($signMsg);
    	/////////////  RSA 签名计算 ///////// 结束 //
    	return $signMsg;
    }
    /**
     * 生成支付签名方法
     */
    protected function kq_ck_null($kq_va,$kq_na)
    {
    	if($kq_va == ""){
    		$kq_va="";
    	}else{
    		return $kq_va=$kq_na.'='.$kq_va.'&';
    	}
    
    }
}