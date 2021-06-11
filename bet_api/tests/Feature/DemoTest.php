<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DemoTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        // 傳遞表頭
        $headerData = [
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Accept' => 'application/json',
            'Accept-Language' => 'zh-TW',
            'X-Timezone' => 'Asia/Taipei',
        ];
        // 傳遞資料
        $formData = [
            'client_id' => 'ebb3c65c371144d0840149d5776f914d',
            'client_secret' => '5f0f4f5202125160f02dcec44e7cfab6',
        ];
        // 訪問專案API
        $response = $this->withHeaders($headerData)->post('/api/v1/auth/token', $formData);
        // // 檢查返回的代碼是不是200，檢查回傳結構值
        $response->assertStatus(200)->assertJson([
            'success' => true,
        ]);
        // $this->session(['foo' => 'bar']);
    }
}
