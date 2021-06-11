<?php

namespace App\Libraries\Cells\Service\Every8d;

use App\Libraries\Abstracts\Base\Cell as CellBase;
use Carbon;

/**
 * Final Class SendCell.
 *
 * @package App\Libraries\Cells\Service\Every8d
 */
final class SendCell extends CellBase
{

    /**
     * Get the validation rules that apply to the arguments input.
     *
     * @return array
     */
    protected function rules(): array
    {
        return [
            'subject' => 'between:1,64',
            'content' => 'required||between:1,256',
            'phone' => 'required|phone:AUTO,mobile',
            'sendtime' => 'date_format:Y-m-d H:i:s',
            // Custom validation rules
        ];
    }

    /**
     * Execute the cell handle.
     *
     * @return array
     * @throws \Exception
     */
    protected function handle(): array
    {
        // You can use getInput function to get the value returned by validation rules
        // $this->getInput( Rules name )

        try {
            $url = 'http://' . config('services.every8d.host') . '/API21/HTTP/sendSMS.ashx';
            // <param name="subject">簡訊主旨，主旨不會隨著簡訊內容發送出去。用以註記本次發送之用途。可傳入空字串。</param>
            // <param name="content">簡訊發送內容</param>
            // <param name="mobile">接收人之手機號碼。格式為: +886912345678或09123456789。多筆接收人時，請以半形逗點隔開( , )，如0912345678,0922333444。</param>
            // <param name="sendTime">簡訊預定發送台北時間。-立即發送：請傳入空字串。-預約發送：請傳入預計發送時間，若傳送時間小於系統接單時間，將不予傳送。格式為YYYYMMDDhhmnss；例如:預約2009/01/31 15:30:00發送，則傳入20090131153000。若傳遞時間已逾現在之時間，將立即發送。</param>
            $subject = $this->getInput('subject');
            $content = $this->getInput('content');
            $mobile = $this->getInput('phone');
            $sendTime = $this->getInput('sendtime');
            $sendTime = (isset($sendTime[0]) ? Carbon::parse($sendTime)->format('YmdHis') : '');
            
            $userID = config('services.every8d.id');
            $password = config('services.every8d.password');
            $success = false;
            $postDataString = "UID=" . $userID;
            $postDataString .= "&PWD=" . $password;
            $postDataString .= "&SB=" . $subject;
            $postDataString .= "&MSG=" . $content;
            $postDataString .= "&DEST=" . $mobile;
            $postDataString .= "&ST=" . $sendTime;
            $resultString = $this->httpPost($url, $postDataString);
            if(substr($resultString,0,1) == "-") {
                return $this->failure([
                    'message' => $resultString
                ]);
            }
            $strArray = explode(",", $resultString);
            // 傳送成功 回傳字串內容格式為：credit,sended,cost,unsend,batch_id，各值中間以逗號分隔。
            // credit：發送後剩餘點數。負值代表發送失敗，系統無法處理該命令
            // sended：發送通數。
            // cost：本次發送扣除點數
            // unsend：無額度時發送的通數，當該值大於0而剩餘點數等於0時表示有部份的簡訊因無額度而無法被發送。
            // batch_id：批次識別代碼。為一唯一識別碼，可藉由本識別碼查詢發送狀態。格式範例：220478cc-8506-49b2-93b7-2505f651c12e
   
            /* Return success message */
            return $this->success([
                'credit' => $strArray[0],
                'sended' => $strArray[1],
                'cost' => $strArray[2],
                'unsend' => $strArray[3],
                'batch_id' => $strArray[4]
            ]);
        } catch (\Throwable $e) {
            /* Return failure message */
            return $this->failure([
                'message' => $e->getMessage()
            ]);
            /* Throw error */
            // throw $e;
        }
    }

    /**
     * Http post.
     * 
     * @param string $url
     * @param string $postData
     * 
     * @return string
     */
    private function httpPost($url, $postData): string
    {
        $res = "";
		$length = strlen($postData);
		$fp = fsockopen(config('services.every8d.host'), 80, $errno, $errstr);
		$header = "POST " . $url . " HTTP/1.0\r\n";
		$header .= "Content-Type: application/x-www-form-urlencoded; charset=utf-8\r\n"; 
		$header .= "Content-Length: " . $length . "\r\n\r\n";
		$header .= $postData . "\r\n";
		
		fputs($fp, $header, strlen($header));
		while (!feof($fp)) {
			$res .= fgets($fp, 1024);
		}
		fclose($fp);
		$strArray = explode("\r\n\r\n", $res);
		return $strArray[1];
	}
}