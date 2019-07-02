<?php
/**
 * Created by yang
 * User: bonzaphp@gmail.com
 * Date: 2019-06-27
 * Time: 11:43
 */

namespace bonza\fdd;

use bonza\fdd\interfaces\FddInterface;

class Fdd
{

    private $fdd = null;

    public function __construct(FddInterface $fdd)
    {
        $this->fdd = $fdd;
    }

    /**
     * 用户或企业账号 获取客户编码
     * @param string $open_id 用户在接入方唯一id
     * @param int $account_type 账户类型，1个人，2企业
     * @return array
     */
    public function accountRegister(string $open_id, int $account_type = 1): array
    {
        return $this->fdd->accountRegister($open_id, $account_type);
    }

    /**
     *
     *  获取企业实名认证地址
     * @param string $customer_id
     * @param string $notify_url
     * @param string $legal_info
     * @param int $page_modify
     * @param int $company_principal_type
     * @return void
     */
    public function getCompanyVerifyUrl($customer_id, $notify_url, $legal_info, $page_modify = 1, $company_principal_type = 1)
    {
        $this->getCompanyVerifyUrl($customer_id, $notify_url, $legal_info, $page_modify, $company_principal_type);
    }


    /**
     *  获取个人实名认证地址
     * @param string $customer_id
     * @param string $notify_url
     * @param int $verified_way
     * @param int $page_modify
     * @param int $cert_flag
     * @return array
     */
    public function getPersonVerifyUrl($customer_id, $notify_url, $verified_way = 2, $page_modify = 1, $cert_flag = 0)
    {
        return $this->fdd->getPersonVerifyUrl($customer_id, $notify_url, $verified_way, $page_modify, $cert_flag);
    }
    /**
     * 实名信息哈希存证
     * @param string $customer_id
     * @param string $transaction_id
     * @param string $preservation_name
     * @param string $file_name
     * @param string $noper_time
     * @param string $file_size
     * @param string $original_sha25
     * @param int $cert_flag 自动申请实名证书 参 数 值 为 “0”：不申 请， 参 数 值 为 “1”：自动 申请
     * @return array
     */
    public function hashDeposit(string $customer_id, string $transaction_id, string $preservation_name, string $file_name, string $noper_time, string $file_size, string $original_sha25, int $cert_flag = 0): array
    {
        return $this->hashDeposit($customer_id, $transaction_id, $preservation_name, $file_name, $noper_time, $file_size, $original_sha25, $cert_flag);
    }

    /**
     * 个人实名信息存证
     * @param string $customer_id
     * @param string $name
     * @param string $idcard
     * @param string $mobile
     * @param string $preservation_name
     * @param string $preservation_data_provider
     * @param string $mobile_essential_factor
     * @param int $document_type
     * @param int $cert_flag
     * @param int $verified_type
     * @return array
     */
    public function personDeposit($customer_id, $name, $idcard, $mobile, $preservation_name, $preservation_data_provider, $mobile_essential_factor, $document_type = 0, $cert_flag = 1, $verified_type = 2): array
    {
        return $this->fdd->personDeposit($customer_id, $name, $idcard, $mobile, $preservation_name, $preservation_data_provider, $mobile_essential_factor, $document_type, $cert_flag, $verified_type);
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
        return $this->fdd->threeElementVerifyMobile($name, $idcard, $mobile);
    }
    /**
     *
     * 查询个人实名认证信息
     * @param inter $verified_serialno
     * @return array
     */
    public function findPersonCertInfo($verified_serialno)
    {
        return $this->findPersonCertInfo($verified_serialno);
    }

    /**
     *
     * 对企业信息实名存证
     * @param string $transaction_id
     * @param string $company_customer_id
     * @param string $company_preservation_name
     * @param string $company_preservation_data_provider
     * @param string $company_name
     * @param string $credit_code
     * @param string $credit_code_file
     * @param string $company_principal_verifie_msg 企业负责人信息
     * @param string $applyNum
     * @param string $document_type
     * @param string $verified_mode
     * @param string $company_principal_type
     * @return array
     */
    public function companyDeposit($transaction_id, $company_customer_id, $company_preservation_name, $company_preservation_data_provider, $company_name, $credit_code, $credit_code_file, $company_principal_verifie_msg, $applyNum, $power_attorney_file, $document_type = 1, $verified_mode = 1, $company_principal_type = 1)
    {
        return $this->companyDeposit($transaction_id, $company_customer_id, $company_preservation_name, $company_preservation_data_provider, $company_name, $credit_code, $credit_code_file, $company_principal_verifie_msg, $applyNum, $power_attorney_file, $document_type = 1, $verified_mode = 1, $company_principal_type = 1);
    }

    /**
     *
     *
     * 查询企业实名认证信息
     * @param int $verified_serialno
     * @return array
     */
    public function findCompanyCertInfo($verified_serialno)
    {
        return $this->fdd->findCompanyCertInfo($verified_serialno);
    }


    /**
     *
     * 编号证书申请
     * @param string $customer_id
     * @param string $evidence_no
     * @return array
     */
    public function applyClientNumCert($customer_id, $evidence_no)
    {
        return $this->fdd->applyClientNumCert($customer_id,$evidence_no);
    }

    /**
     *
     * 印章上传
     * 新增用户签章图片
     * @param string $customer_id
     * @param string $signature_img_base64
     * @return array
     */
    public function addSignature($customer_id, $signature_img_base64)
    {
        return $this->fdd->addSignature($customer_id,$signature_img_base64);
    }


    /**
     *
     * 新增用户签章图片
     * @param string $customer_id
     * @param string $signature_img_base64
     * @return array
     */
    public function customSignature($customer_id, $content)
    {
        return $this->fdd->customSignature($customer_id,$content);
    }


    /**
     *
     * 合同上传
     * @param string $contract_id
     * @param string $doc_title
     * @param string $file
     * @param string $doc_url
     * @param string $doc_type
     * @return array
     */
    public function uploadDocs($contract_id, $doc_title, $file, $doc_url, $doc_type = '.pdf')
    {
        return $this->fdd->uploadDocs($contract_id,$doc_title,$file,$doc_url,$doc_type);
    }


    /**
     *
     *  模板上传
     * @param $template_id
     * @param string $file
     * @param string $doc_url
     * @param string $doc_type
     * @return array
     */
    public function uploadTemplate($template_id, $file, $doc_url, $doc_type = '.pdf')
    {
        return $this->fdd->uploadTemplate($template_id, $file, $doc_url, $doc_type);
    }


    /**
     *
     *  模板填充
     * @param string $doc_title
     * @param string $template_id
     * @param string $contract_id
     * @param string $font_size
     * @param string $parameter_map
     * @param string $font_type
     * @return array
     */
    public function generateContract($doc_title, $template_id, $contract_id, $font_size, $parameter_map, $font_type)
    {

    }


    /**
     *
     *  自动签署
     * @param string $transaction_id
     * @param string $contract_id
     * @param string $customer_id
     * @param string $client_role
     * @param string $pagenum
     * @param string $x
     * @param string $y
     * @return array
     */
    public function extsignAuto($transaction_id, $contract_id, $customer_id, $client_role, $pagenum, $x, $y)
    {
        $msg_digest = base64_encode(
            strtoupper(
                sha1($this->appId . strtoupper(md5($this->timestamp)) . strtoupper(sha1($this->appSecret . $customer_id))
                )
            )
        );
        return $this->curl->sendRequest($this->baseUrl . "extsign_auto" . '.api', 'post', [
            //公共参数
            "app_id"         => $this->appId,
            "timestamp"      => $this->timestamp,
            "v"              => $this->version,
            "msg_digest"     => $msg_digest,
            //业务参数
            "transaction_id" => $transaction_id,//交易号
            "contract_id"    => $contract_id,//合同编号
            "customer_id"    => $customer_id,//客户编号
            "client_role"    => $client_role,//客户角色  1-接入平台；2-仅适用互金行业担保公司或担保人；3-接入平台客户（互金行业指投资人）；4-仅适用互金行业借款企业或者借款人如果需要开通自动签权限请联系法
            "pagenum"        => $pagenum,//页码 签章页码，从 0 开始。即在第一页签章，传值 0。
            "x"              => $x,//盖章点 x 坐标
            "y"              => $y,//盖章点 y 坐标
        ]);
    }


    /**
     *  手动签署接口
     * @param string $transaction_id
     * @param string $contract_id
     * @param string $customer_id
     * @param string $doc_title
     * @param string $return_url
     * @param string $customer_mobile
     * @return array
     */
    public function extsign($transaction_id, $contract_id, $customer_id, $doc_title, $return_url, $customer_mobile)
    {

        $msg_digest = base64_encode(
            strtoupper(
                sha1($this->appId . strtoupper(md5($this->timestamp)) . strtoupper(sha1($this->appSecret . $customer_id))
                )
            )
        );
        return $this->curl->sendRequest($this->baseUrl . "extsign" . '.api', 'get', [
            //公共参数
            "app_id"          => $this->appId,
            "timestamp"       => $this->timestamp,
            "v"               => $this->version,
            "msg_digest"      => $msg_digest,
            //业务参数
            "transaction_id"  => $transaction_id,//交易号
            "contract_id"     => $contract_id,//合同编号
            "customer_id"     => $customer_id,//客户编号
            "doc_title"       => $doc_title,//客户角色  1-接入平台；2-仅适用互金行业担保公司或担保人；3-接入平台客户（互金行业指投资人）；4-仅适用互金行业借款企业或者借款人如果需要开通自动签权限请联系法
            "return_url"      => $return_url,//页面跳转URL（签署结果同步通知）
            "customer_mobile" => $customer_mobile,//手机号
        ]);
    }


    /**
     *此接口将打开页面
     *  合同查看
     * @param string $contract_id
     * @return array
     */
    public function viewContract($contract_id)
    {
        $msg_digest = base64_encode(
            strtoupper(
                sha1($this->appId . strtoupper(md5($this->timestamp)) . strtoupper(sha1($this->appSecret . $contract_id))
                )
            )
        );
        return $this->curl->sendRequest($this->baseUrl . "view_contract" . '.api', 'get', [
            //公共参数
            "app_id"      => $this->appId,
            "timestamp"   => $this->timestamp,
            "v"           => $this->version,
            "msg_digest"  => $msg_digest,
            //业务参数
            "contract_id" => $contract_id,//合同编号
        ]);
    }


    /**
     *
     *  合同下载
     * @param string $contract_id
     * @return array
     */
    public function downLoadContract($contract_id)
    {
        $msg_digest = base64_encode(
            strtoupper(
                sha1($this->appId . strtoupper(md5($this->timestamp)) . strtoupper(sha1($this->appSecret . $contract_id))
                )
            )
        );
        return $this->curl->sendRequest($this->baseUrl . "downLoadContract" . '.api', 'get', [
            //公共参数
            "app_id"      => $this->appId,
            "timestamp"   => $this->timestamp,
            "v"           => $this->version,
            "msg_digest"  => $msg_digest,
            //业务参数
            "contract_id" => $contract_id,//合同编号
        ]);
    }


    /**
     *
     *  合同归档
     * @param string $contract_id
     * @return array
     */
    public function contractFiling($contract_id)
    {
        $msg_digest = base64_encode(
            strtoupper(
                sha1($this->appId . strtoupper(md5($this->timestamp)) . strtoupper(sha1($this->appSecret . $this->ascllSort([$contract_id])))
                )
            )
        );
        return $this->curl->sendRequest($this->baseUrl . "contractFiling" . '.api', 'post', [
            //公共参数
            "app_id"      => $this->appId,
            "timestamp"   => $this->timestamp,
            "v"           => $this->version,
            "msg_digest"  => $msg_digest,
            //业务参数
            "contract_id" => $contract_id,//合同编号
        ]);
    }


    /**
     *
     *  实名证书申请
     * @method Post
     * @param string $customer_id
     * @param string $verified_serialno
     * @return array
     */
    public function applyCert($customer_id, $verified_serialno)
    {
        $msg_digest = base64_encode(
            strtoupper(
                sha1($this->appId . strtoupper(md5($this->timestamp)) . strtoupper(sha1($this->appSecret . $this->ascllSort([$customer_id, $verified_serialno])))
                )
            )
        );
        return $this->curl->sendRequest($this->baseUrl . "apply_cert" . '.api', 'post', [
            //公共参数
            "app_id"            => $this->appId,
            "timestamp"         => $this->timestamp,
            "v"                 => $this->version,
            "msg_digest"        => $msg_digest,
            //业务参数
            "customer_id"       => $customer_id,//客户编号
            "verified_serialno" => $verified_serialno,//实名认证序列号
        ]);
    }


    /**
     *
     *  编号证书申请
     * @param string $customer_id
     * @param string $verified_serialno
     * @return array
     */
    public function applyNumcert($customer_id, $verified_serialno)
    {

        $msg_digest = base64_encode(
            strtoupper(
                sha1($this->appId . strtoupper(md5($this->timestamp)) . strtoupper(sha1($this->appSecret . $this->ascllSort([$customer_id, $verified_serialno])))
                )
            )
        );
        return $this->curl->sendRequest($this->baseUrl . "apply_numcert" . '.api', 'post', [
            //公共参数
            "app_id"            => $this->appId,
            "timestamp"         => $this->timestamp,
            "v"                 => $this->version,
            "msg_digest"        => $msg_digest,
            //业务参数
            "customer_id"       => $customer_id,//客户编号
            "verified_serialno" => $verified_serialno,//实名认证序列号
        ]);
    }

    /**
     *
     *  通过 uuid 下载文件
     * @param string $uuid
     * @return array
     */
    public function getFile($uuid)
    {
        $timestamp = date("YmdHis");
        $msg_digest = base64_encode(
            strtoupper(
                sha1($this->appId . strtoupper(md5($this->timestamp)) . strtoupper(sha1($this->appSecret . $this->ascllSort([$uuid])))
                )
            )
        );
        return $this->curl->sendRequest($this->baseUrl . "get_file" . '.api', 'post', [
            //公共参数
            "app_id"     => $this->appId,
            "timestamp"  => $this->timestamp,
            "v"          => $this->version,
            "msg_digest" => $msg_digest,
            //业务参数
            "uuid"       => $uuid,//图片 uuid 查询认证结果时返回
        ]);
    }


    /**
     * ascll码排序
     * @param array $arr
     * @return array
     */
    private function ascllSort($arr, $sf = 0)
    {
        sort($arr, $sf);
        $tmp = implode('', $arr);
        return $tmp;
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
                throw new \Exception('未知加密方法');
            }
            $ivLen = openssl_cipher_iv_length('des-ede3');
            $iv = openssl_random_pseudo_bytes($ivLen);
            $result = bin2hex(openssl_encrypt($data, 'des-ede3', $key, OPENSSL_RAW_DATA, $iv));
            if (!$result) {
                throw new \Exception('加密失败');
            }
            return [TRUE, $result];
        } catch (\Exception $e) {
            return [FALSE, $e->getMessage()];
        }
    }


}