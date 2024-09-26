<?php

namespace App\Helpers;

use Exception;

class SMSHelper
{

    private static $_lastResponse;

    /**
     * @var array<SMSTemplate, string>
     */
    private static $_templates = [
        'SUBSIDY_APPROVED' => ['1107171084744469771', 'Hi %s , your subsidy has been approved against a loan from MMSY. Department of Industries'],
        'FORWARDED_TO_BANK' => ['1107171084749622081', 'Hi %s, your application has been forwarded to the nodal bank for disbursement of the loan. Department of Industries'],
        'LOAN_DISBURSED' => ['1107171084754705604', 'Hi %s, your loan has been disbursed from the nodal bank. Department of Industries'],
        'OTP_SMS' => ['1107171084765226481', 'Hi, %s is OTP for MMSY login or %s can used as one click login. Department of Industries'],
        'SAVE_DATA' => ['1107171084769827252', 'Your MMSY application (No: MMSY-%s) has been submitted successfully. Please log in with your email or mobile number to complete it. Department of Industries'],
        'FINAL_SUBMIT' => ['1107171084776072009', 'Your MMSY Application (No: MMSY-%s) has been successfully submitted and is pending at the DLC. Please keep checking for further updates. Thank you. Department of Industries'],
        'DLC_TO_BANK' => ['1107171084782281483', 'We are pleased to inform you that your MMSY Application (No: MMSY-%s) has been approved by the DLC and has now been forwarded to the bank for further processing. Please stay tuned for updates from the bank regarding the status of your application. Department of Industries'],
        'RELEASE_60' => ['1107171084788617931', 'We are excited to inform you that 60 Percent of your subsidy amount has been released by the nodal bank to your chosen financial bank. Please continue to stay in touch with your financial bank for further details regarding the disbursement of your subsidy. Department of Industries'],
        'RELEASE_40' => ['1107171084793800935', 'We are pleased to inform you that the remaining 40 Percent of your subsidy amount has been released by the nodal bank to your chosen financial bank. This marks the completion of the subsidy disbursement process for your MMSY application. Department of Industries'],
        'NEW_OTP_MSG' => ['1107171084799061412', 'Dear Applicant, please use the One-Time Password %s to log in to your application. The OTP will be valid for 5 minutes. Department of Industries'],
        'OTP_MSG' => ['1107171084805289189', 'Your One-Time Password (OTP) for verification is: %s. This OTP is valid for the next 10 minutes. Department of Industries'],
        'OTP_MSG_GM' => ['1107171084810446699', 'Your One-Time Password (OTP) for approval is: %s. This OTP is valid for the next 10 minutes. Department of Industries'],
    ];

    public static function sendSMS(string $mobile, string $templateId, array $params): bool
    {
        if (!isset(self::$_templates[$templateId])) {
            throw new Exception("Template '$templateId' was not found!");
        }
        array_unshift($params, self::$_templates[$templateId][1]);
        $message = call_user_func_array('sprintf', $params);
        self::send($mobile, $message, self::$_templates[$templateId][0]);
        return substr(self::$_lastResponse, 0, 3) == '402';
    }

    private static function send(string $mobile, string $message, string $templateId)
    {
        $key = hash('sha512', trim(env('SMS_GATEWAY_USERNAME')) . trim(env('SMS_GATEWAY_SENDER_ID')) . trim($message) . trim(env('SMS_GATEWAY_KEY')));

        $data = array(
            "username" => trim(env('SMS_GATEWAY_USERNAME')),
            "password" => trim(env('SMS_GATEWAY_PASSWORD')),
            "senderid" => trim(env('SMS_GATEWAY_SENDER_ID')),
            "content" => trim($message),
            "smsservicetype" => "singlemsg",
            "mobileno" => trim($mobile),
            "key" => trim($key),
            "templateid" => trim($templateId),
        );
        return self::postToUrl("https://msdgweb.mgov.gov.in/esms/sendsmsrequestDLT", $data);
    }

    //function to send unicode sms by making http connection
    private static function postToUrl($url, $data)
    {
        $fields = '';
        foreach ($data as $key => $value) {
            $fields .= $key . '=' . urlencode($value) . '&';
        }
        $fields = rtrim($fields, '&');

        $post = curl_init();
        //curl_setopt($post, CURLOPT_SSLVERSION, 5); // uncomment for systems supporting TLSv1.1 only
        curl_setopt($post, CURLOPT_SSLVERSION, 6); // use for systems supporting TLSv1.2 or comment the line
        // curl_setopt($post, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($post, CURLOPT_URL, $url);
        curl_setopt($post, CURLOPT_POST, count($data));
        curl_setopt($post, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($post, CURLOPT_HTTPHEADER, array("Content-Type:application/x-www-form-urlencoded"));
        curl_setopt($post, CURLOPT_HTTPHEADER, array("Content-length:"
            . strlen($fields)));
        curl_setopt($post, CURLOPT_HTTPHEADER, array("User-Agent:Mozilla/4.0 (compatible; MSIE 5.0; Windows 98; DigExt)"));
        curl_setopt($post, CURLOPT_RETURNTRANSFER, 1);
        self::$_lastResponse = curl_exec($post); //result from mobile seva server
        curl_close($post);
        return self::$_lastResponse;
    }

    public static function getResponse()
    {
        return self::$_lastResponse;
    }

    public static function getResponseMeaning()
    {
        $responses = [
            "401" => "Credentials Error, may be invalid username or password",
            "402" => "Message submitted successfully",
            "403" => "Credits not available",
            "404" => "Internal Database Error",
            "405" => "Internal Networking Error",
            "406" => "Invalid or Duplicate numbers",
            "407" => "Network Error on SMSC",
            "408" => "Network Error on SMSC",
            "409" => "SMSC response timed out, message will be submitted",
            "410" => "Internal Limit Exceeded, Contact support",
            "411" => "Sender ID not approved.",
            "412" => "Sender ID not approved.",
            "413" => "Suspect Spam, we do not accept these messages.",
            "414" => "Rejected by various reasons by the operator such as DND, SPAM etc",
            "415" => "Secure Key not available",
            "416" => "Hash doesn't match",
            "418" => "Daily Limit Exceeded",
        ];
        return isset($responses[substr(self::getResponse(), 0, 3)]) ? $responses[substr(self::getResponse(), 0, 3)] : 'UNKNOWN';
    }
}
