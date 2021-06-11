<?php

namespace App\Libraries\Cells\Service\Every8d;

use App\Libraries\Abstracts\Base\Cell as CellBase;

/**
 * Final Class CreditCell.
 *
 * @package App\Libraries\Cells\Service\Every8d
 */
final class CreditCell extends CellBase
{

    /**
     * Get the validation rules that apply to the arguments input.
     *
     * @return array
     */
    protected function rules(): array
    {
        return [
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
            $url = 'http://' . config('services.every8d.host') . '/API21/HTTP/getCredit.ashx';
            $userID = config('services.every8d.id');
            $password = config('services.every8d.password');
            $success = false;
            $postDataString = "UID=" . $userID . "&PWD=" . $password;
            $resultString = $this->httpPost($url, $postDataString);
            if (substr($resultString, 0, 1) == "-") {
                return $this->failure([
                    'message' => $resultString
                ]);
            }
            /* Return success message */
            return $this->success([
                'credit' => $resultString
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