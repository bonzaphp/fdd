<?php
/**
 * Created by yang
 * User: bonzaphp@gmail.com
 * Date: 2019-06-27
 * Time: 13:37
 */

namespace bonza\fdd\api;

use bonza\fdd\exception\InvalidArgumentException;
use bonza\fdd\extend\Curl;
use bonza\fdd\interfaces\FddInterface;
use CURLFile;
use Exception;

/**
 * 法大大API version2
 * Class FddApi2
 * @author bonzaphp@gmail.com
 * @Date 2019-06-27
 * @package bonza\fdd
 */
class FddApi3 implements FddInterface
{
    /**
     * @var string
     */
    private $appId;
    /**
     * @var string
     */
    private $appSecret;
    /**
     * @var string
     */
    private $timestamp;
    /**
     * @var string api版本
     */
    private $version = '2.0';
    /**
     * @var Curl
     */
    private $curl = null;
    /**
     * @var string
     */
    private $baseUrl = '';

    /**
     * @var string
     */
    public function __construct($options)
    {
        $this->timestamp = date("YmdHis");
        if (isset($options['appId'])) {
            $this->appId = $options['appId'];
        } else {
            throw new InvalidArgumentException('参数错误');
        }
        if (isset($options['appSecret'])) {
            $this->appSecret = $options['appSecret'];
        } else {
            throw new InvalidArgumentException('参数错误');
        }
        $this->baseUrl = $options['baseUrl'] ?? $this->baseUrl;
        $this->version = $options['version'] ?? $this->version;
        $this->curl = new Curl();
    }

    /**
     * 用户或企业账号 获取客户编码
     * @param string $open_id 用户在接入方唯一id open_id一般是客户的唯一标识，ID，身份证都可以。一般user_id比较合适
     * @param int $account_type 账户类型，1个人，2企业
     * @return array
     */
    public function accountRegister(string $open_id, int $account_type = 1): array
    {
        $personalParams = compact('account_type', 'open_id');
        $msg_digest = $this->getMsgDigest($personalParams);
        $commonParams = $this->getCommonParams($msg_digest);
        $params = $commonParams + $personalParams;
        return $this->curl->sendRequest($this->baseUrl . "account_register" . '.api', 'post', $params);
    }

    /**
     *
     *  获取企业实名认证地址
     * @param string $customer_id 客户编号
     * @param string $notify_url 是否允许用户页面修改1 允许，2 不允许
     * @param string $legal_info 回调地址
     * @param int $page_modify 企业负责人身份 :1. 法人，2. 代理人
     * @param int $company_principal_type 法人信息
     * @return array
     */
    public function getCompanyVerifyUrl($customer_id, $notify_url, $legal_info, $page_modify = 1, $company_principal_type = 1): array
    {
        $personalParams = compact('company_principal_type', 'customer_id', 'legal_info', 'notify_url', 'page_modify');
        $msg_digest = $this->getMsgDigest($personalParams);
        $params = $this->getCommonParams($msg_digest) + $personalParams;
        return $this->curl->sendRequest($this->baseUrl . "get_company_verify_url" . '.api', 'post', $params);
    }


    /**
     *  获取个人实名认证地址
     * @param string $customer_id 客户编号
     * @param string $notify_url 回调地址 异步通知认证结果
     * @param string $verified_way 实名认证套餐类型
     * @param string $page_modify 是否允许用户页面修改1 允许，2 不允许
     * @param string $cert_flag 是否认证成功后自动申请实名证书参数值为 “0”：不申请，参数值为“1”：自动申请
     * @return array
     */
    public function getPersonVerifyUrl($customer_id, $notify_url, $verified_way = '2', $page_modify = '1', $cert_flag = '0'): array
    {
        /*        cert_flag
                customer_id
                customer_ident_no
                customer_ident_type
                customer_name
                ident_front_path
                notify_url
                page_modify
                result_type
                return_url
                verified_way*/
        $customer_ident_no = '220282199103072937';
        $customer_ident_type = '0';
        $customer_name = '王志闯';
        $mobile = '18129986450';
        $ident_front_path = 'http://www.ydjituan.com/images/yd1.jpg';
        $personalParams = compact('customer_id',
            'notify_url', 'verified_way', 'page_modify',
            'cert_flag', 'customer_ident_no', 'customer_ident_type', 'customer_name',
            'mobile', 'ident_front_path');
        $msg_digest = $this->getMsgDigest($personalParams);
        $params = $this->getCommonParams($msg_digest) + $personalParams;
        return $this->curl->sendRequest($this->baseUrl . "get_person_verify_url" . '.api', 'post', $params);
    }


    /**
     * 实名信息哈希存证
     * @param string $customer_id 客户编号
     * @param string $preservation_name 存证名称
     * @param string $file_name 文件名
     * @param string $noper_time 文件最后修改时间 文件最后修改时间(unix 时间，单位s):file.lastModified()/1000
     * @param string $file_size 文件大小  字符类型；值单位（byte） ;最大值:“9223372036854775807” >> 2^63-1 最小值:0sha256
     * @param string $original_sha25 文件哈希值 文件 hash 值： sha256 算法
     * @param string $transaction_id 交易号  自定义
     * @param int $cert_flag 是否认证成 功后自动申请实名证书 参 数 值 为 “0”：不申 请， 参 数 值 为 “1”：自动 申请
     * @return array
     */
    public function hashDeposit(string $customer_id, string $transaction_id, string $preservation_name, string $file_name, string $noper_time, string $file_size, string $original_sha25, int $cert_flag = 0): array
    {
        $personalParams = compact('cert_flag', 'customer_id', 'file_name', 'file_size', 'noper_time', 'original_sha25', 'preservation_name', 'transaction_id');
        $msg_digest = $this->getMsgDigest($personalParams);
        $params = $this->getCommonParams($msg_digest) + $personalParams;
        return $this->curl->sendRequest($this->baseUrl . "hash_deposit" . '.api', 'get', $params);
    }

    /**
     * 个人实名信息存证
     * @param string $customer_id 客户编号
     * @param string $preservation_name 存证名称
     * @param string $preservation_data_provider 存证提供方
     * @param string $verified_type 1:公安部二要素(姓名+身份证);2:手机三要素(姓名+身份证+手机号);3:银行卡三要素(姓名+身份证+银行卡);4:四要素(姓名+身份证+手机号+银行卡)Z：其他
     * @param string $name 姓名
     * @param string $idcard 证件号
     * @param string $mobile 手机号
     * @param string $document_type 证件类型 默认是 0：身份证， 具体查看 5.18 附录
     * @param string $mobile_essential_factor 手机三要素
     * @param string $cert_flag 是 否认 证成 功后 自动 申请 实名证书参 数值 为“0”：不申请，参 数值 为“1”：自动申请
     * @return array
     */
    public function personDeposit($customer_id, $name, $idcard, $mobile, $preservation_name, $preservation_data_provider, $mobile_essential_factor, $document_type = 0, $cert_flag = 1, $verified_type = 2): array
    {
        //verifiedType=2 公安部三要素
//        $mobile_essential_factor = json_encode([
//            'transactionId' => $transactionId,//交易号
//        ]);
        $personalParams = compact('cert_flag', 'customer_id', 'document_type', 'idcard', 'mobile', 'mobile_essential_factor', 'name', 'preservation_data_provider', 'preservation_name', 'verified_type');
        $msg_digest = $this->getMsgDigest($personalParams);
        $params = $this->getCommonParams($msg_digest) + $personalParams;
        return $this->curl->sendRequest($this->baseUrl . "person_deposit" . '.api', 'post', $params);
    }

    /**
     *
     *
     * 三要素身份验证
     * @param string $name
     * @param string $idcard
     * @param string $mobile
     * @return array
     */
    public function threeElementVerifyMobile($name, $idcard, $mobile): array
    {
        /**
         *
         * 3des(姓名|身份证号码|手机号， app_secret)
         **/
        $verify_element = $this->encrypt($name . "|" . $idcard . "|" . $mobile, $this->appSecret);
        $verify_element = strtoupper($verify_element[1]);
        $personalParams = compact('verify_element');//三要素（姓名、 身份证号码、手机号码
        $msg_digest = $this->getMsgDigest($personalParams);
        $params = $this->getCommonParams($msg_digest) + $personalParams;
        return $this->curl->sendRequest($this->baseUrl . "three_element_verify_mobile" . '.api', 'post', $params);
    }

    /**
     *
     * 查询个人实名认证信息
     * @param string $verified_serialno 交易号，获取认证地址时返回
     * @return array
     */
    public function findPersonCertInfo($verified_serialno): array
    {
        $personalParams = compact('verified_serialno');
        $msg_digest = $this->getMsgDigest($personalParams);
        $params = $this->getCommonParams($msg_digest) + $personalParams;
        return $this->curl->sendRequest($this->baseUrl . "find_personCertInfo" . '.api', 'post', $params);
    }

    /**
     *
     * 对企业信息实名存证
     * @param string $company_customer_id 企业客户编号
     * @param string $company_preservation_name 企业存证名称
     * @param string $company_preservation_data_provider 存证提供者
     * @param string $company_name 企业名称
     * @param string $document_type 证件类型 1:三证合一 2：旧版营业执照
     * @param string $credit_code 统 一社 会信用代码
     * @param string $credit_code_file 统 一社 会信 用代 码电子版
     * @param string $verified_mode 实 名认 证方式1:授权委托书 2:银行对公打款
     * @param string $power_attorney_file 授 权委 托书电子版
     * @param string $company_principal_type 企 业负 责人身份 :1.法人， 2 代理人
     * @param string $company_principal_verifie_msg json 企 业负 责人 实名 存证 信息
     * @param string $transaction_id 交易号
     * @return array
     */
    public function companyDeposit($transaction_id, $company_customer_id, $company_preservation_name, $company_preservation_data_provider, $company_name, $credit_code, $credit_code_file, $company_principal_verifie_msg, $applyNum, $power_attorney_file, $document_type = 1, $verified_mode = 1, $company_principal_type = 1): array
    {
        //企业负责人信息
//        $company_principal_verifie_msg = json_encode([
//            'customer_id' => $customer_id,//企业负责人客户编号
//            'preservation_name' => $preservation_name,//存证名称
//            'preservation_data_provider' => $preservation_data_provider,//存证数据提供方
//            'name' => $name,//企业负责人姓名
//            'idcard' => $idcard,//企业负责人idcard
//            'verified_type' => $verified_type,//企业负责人实名存证类型 1:公安部二要素(姓名+身份证);2:手机三要素(姓名+身份证+手机号);3:银行卡三要素(姓名+身份证+银行卡);4:四要素(姓名+身份证+手机号+ 银行卡)Z：其他
//            'customer_id' => $customer_id,//企业负责人客户编号
//        ]);
        //verifiedType=1 公安部二要素
        $public_security_essential_factor = json_encode([
            'applyNum' => $applyNum,//申请编号
        ]);
        $personalParams = compact('company_name', 'company_principal_type', 'company_principal_verifie_msg', 'credit_cod', 'company_customer_id', 'document_type', 'company_preservation_data_provider', 'company_preservation_name', 'transaction_id', 'verified_mod');
        $msg_digest = $this->getMsgDigest($personalParams);
        $params = $this->getCommonParams($msg_digest) + $personalParams;
        return $this->curl->sendRequest($this->baseUrl . "company_deposit" . '.api', 'post', $params);
    }

    /**
     *
     *
     * 查询企业实名认证信息
     * @param string $verified_serialno 交易号，获取认证地址时返回
     * @return array
     */
    public function findCompanyCertInfo($verified_serialno): array
    {
        $personalParams = compact('verified_serialno');
        $msg_digest = $this->getMsgDigest($personalParams);
        $params = $this->getCommonParams($msg_digest) + $personalParams;
        return $this->curl->sendRequest($this->baseUrl . "find_companyCertInfo" . '.api', 'post', $params);
    }


    /**
     *
     * 编号证书申请
     * @param string $customer_id 注册账号时返回
     * @param string $evidence_no 实名信息存证时返回
     * @return array
     */
    public function applyClientNumCert($customer_id, $evidence_no): array
    {
        $personalParams = compact('customer_id', 'evidence_no');
        $msg_digest = $this->getMsgDigest($personalParams);
        $params = $this->getCommonParams($msg_digest) + $personalParams;
        return $this->curl->sendRequest($this->baseUrl . "apply_client_numcert" . '.api', 'post', $params);
    }

    /**
     *
     * 印章上传
     * 新增用户签章图片
     * @param string $customer_id 客户编号
     * @param string $signature_img_base64 签章图片 base64
     * @return array
     */
    public function addSignature($customer_id, $signature_img_base64): array
    {
        $personalParams = compact('customer_id', 'signature_img_base64');
        $msg_digest = $this->getMsgDigest($personalParams);
        $params = $this->getCommonParams($msg_digest) + $personalParams;
        return $this->curl->sendRequest($this->baseUrl . "add_signature" . '.api', 'post', $params);
    }


    /**
     *
     * 新增用户签章图片
     * @param string $customer_id 客户编号
     * @param string $content 印章展示的内容
     * @return array
     */
    public function customSignature($customer_id, $content): array
    {
        $personalParams = compact('content', 'customer_id');
        $msg_digest = $this->getMsgDigest($personalParams);
        $params = $this->getCommonParams($msg_digest) + $personalParams;
        return $this->curl->sendRequest($this->baseUrl . "custom_signature" . '.api', 'post', $params);
    }


    /**
     *
     * 合同上传
     * @param string $contract_id 合同编号
     * @param string $doc_title 合同标题
     * @param string $file 文档地址  File 文件 doc_url和 file 两个参数必选一
     * @param string $doc_url PDF 文档  File 文件 doc_url和 file 两个参数必选一
     * @param string $doc_type 文档类型  .pdf
     * @return array
     */
    public function uploadDocs($contract_id, $doc_title, $file, $doc_url, $doc_type = '.pdf'): array
    {
        $msg_digest = $this->getMsgDigest(compact('contract_id'));
        $personalParams = [
            //业务参数
            "contract_id" => $contract_id,
            "doc_title"   => $doc_title,
            "doc_url "    => $doc_url,
            "file"        => $file,
            "doc_type"    => $doc_type,
        ];
        $params = $this->getCommonParams($msg_digest) + $personalParams;
        return $this->curl->sendRequest($this->baseUrl . "uploaddocs" . '.api', 'post', $params);
    }


    /**
     *
     *  模板上传
     * @param string $template_id 模板编号
     * @param string $file 文档地址 字段类型：字符串， 须为 URLdoc_url 和 file两个参数必选一
     * @param string $doc_url PDF 文档  File 文件 doc_url和 file 两个参数必选一
     * @param string $doc_type 文档类型  .pdf
     * @return array
     */
    public function uploadTemplate($template_id, $file, $doc_url, $doc_type = '.pdf'): array
    {
        $msg_digest = $this->getMsgDigest(compact('template_id'));
        $personalParams = [
            //业务参数
            "template_id" => $template_id,
            "doc_url"     => $doc_url,
            "file"        => new CURLFile($file),
            "doc_type"    => $doc_type,
        ];
        $params = $this->getCommonParams($msg_digest) + $personalParams;
        return $this->curl->sendRequest($this->baseUrl . "uploadtemplate" . '.api', 'post', $params);
    }

    /**
     * 查看合同模版
     *
     * @param $template_id
     * @return mixed
     * @author bonzaphp@gmail.com
     */
    public function viewTemplate($template_id)
    {
        $personalParams = compact('template_id');
        $msg_digest = $this->getMsgDigest($personalParams);
        $params = $this->getCommonParams($msg_digest) + $personalParams;
        return $this->baseUrl . "view_template" . '.api' . '?' . http_build_query($params);
    }

    /**
     * 下载合同模版
     *
     * @param $template_id
     * @return string
     * @author bonzaphp@gmail.com
     */
    public function templateDownload($template_id)
    {
        $personalParams = compact('template_id');
        $msg_digest = $this->getMsgDigest($personalParams);
        $params = $this->getCommonParams($msg_digest) + $personalParams;
        return $this->baseUrl . "download_template" . '.api' . '?' . http_build_query($params);
    }

    /**
     * 删除合同模版
     *
     * @param $template_id
     * @return array
     * @author bonzaphp@gmail.com
     */
    public function templateDelete($template_id): array
    {
        $personalParams = compact('template_id');
        $msg_digest = $this->getMsgDigest($personalParams);
        $params = $this->getCommonParams($msg_digest) + $personalParams;
        return $this->curl->sendRequest($this->baseUrl . "template_delete" . '.api', 'post', $params);
    }

    /**
     *
     *  模板填充
     * @param string $doc_title 文档标题合同标题
     * @param string $template_id 模板编号
     * @param string $contract_id 合同编号
     * @param string $font_size 字体大小
     * @param string $parameter_map 填充内容
     * @param string $font_type 字体类型
     * @return array
     */
    public function generateContract($doc_title, $template_id, $contract_id, $font_size, $parameter_map, $font_type): array
    {
        $msg_digest = $this->getMsgDigest(compact('template_id', 'contract_id'), $parameter_map);
        $personalParams = [
            //业务参数
            "doc_title"     => $doc_title,
            "template_id"   => $template_id,
            "contract_id"   => $contract_id,
            "font_size"     => $font_size,
            "parameter_map" => $parameter_map,
            "font_type"     => $font_type,
        ];
        $params = $this->getCommonParams($msg_digest) + $personalParams;
        return $this->curl->sendRequest($this->baseUrl . "generate_contract" . '.api', 'post', $params);
    }


    /**
     *
     *  自动签署
     * @param string $transaction_id 交易号
     * @param string $contract_id 合同编号
     * @param string $customer_id 客户编号
     * @param string $client_role 客户角色  1-接入平台；2-仅适用互金行业担保公司或担保人；3-接入平台客户（互金行业指投资人）；4-仅适用互金行业借款企业或者借款人如果需要开通自动签权限请联系法
     * @param string $pagenum 页码 签章页码，从 0 开始。即在第一页签章，传值 0。
     * @param string $x 盖章点 x 坐标
     * @param string $y 盖章点 y 坐标
     * @return array
     */
    public function extSignAuto($transaction_id, $contract_id, $customer_id, $client_role, $pagenum, $x, $y): array
    {
        $msg_digest = $this->getMsgDigest(compact('customer_id'));
        $personalParams = [
            //业务参数
            "transaction_id" => $transaction_id,
            "contract_id"    => $contract_id,
            "customer_id"    => $customer_id,
            "client_role"    => $client_role,
            "pagenum"        => $pagenum,
            "x"              => $x,
            "y"              => $y,
        ];
        $params = $this->getCommonParams($msg_digest) + $personalParams;
        return $this->curl->sendRequest($this->baseUrl . "extsign_auto" . '.api', 'post', $params);
    }


    /**
     *  手动签署接口
     * @param string $transaction_id 交易号
     * @param string $contract_id 合同编号
     * @param string $customer_id 客户编号
     * @param string $doc_title 客户角色  1-接入平台；2-仅适用互金行业担保公司或担保人；3-接入平台客户（互金行业指投资人）；4-仅适用互金行业借款企业或者借款人如果需要开通自动签权限请联系法
     * @param string $return_url 页面跳转URL（签署结果同步通知）
     * @param string $customer_mobile 手机号
     * @return array
     */
    public function extSign($transaction_id, $contract_id, $customer_id, $doc_title, $return_url, $customer_mobile): array
    {

        $msg_digest = $this->getMsgDigest(compact('customer_id'));
        $params = $this->getCommonParams($msg_digest) + [
                //业务参数
                "transaction_id"  => $transaction_id,
                "contract_id"     => $contract_id,
                "customer_id"     => $customer_id,
                "doc_title"       => $doc_title,
                "return_url"      => $return_url,
                "customer_mobile" => $customer_mobile,
            ];
        return $this->curl->sendRequest($this->baseUrl . "extsign" . '.api', 'get', $params);
    }


    /**
     *此接口将打开页面
     *  合同查看
     * @param string $contract_id
     * @return array
     */
    public function viewContract($contract_id): array
    {
        $msg_digest = $this->getMsgDigest(compact('contract_id'));
        $params = $this->getCommonParams($msg_digest) + [
                //业务参数
                "contract_id" => $contract_id,//合同编号
            ];
        return $this->curl->sendRequest($this->baseUrl . "view_contract" . '.api', 'get', $params);
    }


    /**
     *
     *  合同下载
     * @param string $contract_id
     * @return array
     */
    public function downLoadContract($contract_id): array
    {
        $msg_digest = $this->getMsgDigest(compact('contract_id'));
        $params = $this->getCommonParams($msg_digest) + [
                //业务参数
                "contract_id" => $contract_id,//合同编号
            ];
        return $this->curl->sendRequest($this->baseUrl . "downLoadContract" . '.api', 'get', $params);
    }


    /**
     *
     *  合同归档
     * @param string $contract_id
     * @return array
     */
    public function contractFiling($contract_id): array
    {
        $msg_digest = $this->getMsgDigest(compact('contract_id'));
        $params = $this->getCommonParams($msg_digest) + [
                //业务参数
                "contract_id" => $contract_id,//合同编号
            ];
        return $this->curl->sendRequest($this->baseUrl . "contractFiling" . '.api', 'post', $params);
    }


    /**
     *
     *  实名证书申请
     * @method Post
     * @param string $customer_id 客户编号
     * @param string $verified_serialno 实名认证序列号
     * @return array
     */
    public function applyCert($customer_id, $verified_serialno): array
    {
        $personalParams = compact('customer_id', 'verified_serialno');
        $msg_digest = $this->getMsgDigest($personalParams);
        $params = $this->getCommonParams($msg_digest) + $personalParams;
        return $this->curl->sendRequest($this->baseUrl . "apply_cert" . '.api', 'post', $params);
    }


    /**
     *
     *  编号证书申请
     * @param string $customer_id 客户编号
     * @param string $verified_serialno 实名认证序列号
     * @return array
     */
    public function applyNumCert($customer_id, $verified_serialno): array
    {

        $personalParams = compact('customer_id', 'verified_serialno');
        $msg_digest = $this->getMsgDigest($personalParams);
        $params = $this->getCommonParams($msg_digest) + $personalParams;
        return $this->curl->sendRequest($this->baseUrl . "apply_numcert" . '.api', 'post', $params);
    }

    /**
     *
     *  通过 uuid 下载文件
     * @param string $uuid 图片 uuid 查询认证结果时返回
     * @return array
     */
    public function getFile($uuid): array
    {
        $msg_digest = $this->getMsgDigest(compact('uuid'));
        $params = $this->getCommonParams($msg_digest) + [
                //业务参数
                "uuid" => $uuid,
            ];
        return $this->curl->sendRequest($this->baseUrl . "get_file" . '.api', 'post', $params);
    }


    /**
     * ascll码排序
     * @param array $arr
     * @param int $sorting_type 排序参数
     * @return array
     */
    private function ascllSort($arr, $sorting_type = 0)
    {
        ksort($arr, $sorting_type);
        return implode('', $arr);
    }

    /**
     *
     * 3des加密
     * @param string $data
     * @param string $key
     * @return array
     */
    private function encrypt($data, $key)
    {
        try {
            if (!in_array('des-ede3', openssl_get_cipher_methods())) {
                throw new Exception('未知加密方法');
            }
            $ivLen = openssl_cipher_iv_length('des-ede3');
            $iv = openssl_random_pseudo_bytes($ivLen);
            $result = bin2hex(openssl_encrypt($data, 'des-ede3', $key, OPENSSL_RAW_DATA, $iv));
            if (!$result) {
                throw new Exception('加密失败');
            }
            return [TRUE, $result];
        } catch (Exception $e) {
            return [FALSE, $e->getMessage()];
        }
    }

    /**
     * 对业务参数进行处理，生成实际(msg_digest)消息摘要
     * @param array $data 必须是键值数组
     * @param string $parameter_map
     * @return string
     * @author bonzaphp@gmail.com
     */
    private function getMsgDigest(array $data, string $parameter_map = ''): string
    {
        if (!empty($parameter_map) && isset($parameter_map)) {
            $ascllSort = $data['template_id'].$data['contract_id'];
        } else {
            $ascllSort = $this->ascllSort($data);
        }
        return base64_encode(
            strtoupper(
                sha1(
                    $this->appId
                    . strtoupper(md5($this->timestamp))
                    . strtoupper(
                        sha1(
                            $this->appSecret . $ascllSort
                        )
                    )
                    . $parameter_map
                )
            )
        );
    }

    /**
     * 获取公共参数
     * @param string $msg_digest
     * @return array
     * @author bonzaphp@gmail.com
     */
    private function getCommonParams(string $msg_digest): array
    {
        return [
            //公共参数
            "app_id"     => $this->appId,
            "timestamp"  => $this->timestamp,
            "v"          => $this->version,
            "msg_digest" => $msg_digest,
        ];
    }


}