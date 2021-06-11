## Laravel PHP Framework

[![Build Status](https://travis-ci.org/laravel/framework.svg)](https://travis-ci.org/laravel/framework)
[![Total Downloads](https://poser.pugx.org/laravel/framework/d/total.svg)](https://packagist.org/packages/laravel/framework)
[![Latest Stable Version](https://poser.pugx.org/laravel/framework/v/stable.svg)](https://packagist.org/packages/laravel/framework)
[![Latest Unstable Version](https://poser.pugx.org/laravel/framework/v/unstable.svg)](https://packagist.org/packages/laravel/framework)
[![License](https://poser.pugx.org/laravel/framework/license.svg)](https://packagist.org/packages/laravel/framework)

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable, creative experience to be truly fulfilling. Laravel attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as authentication, routing, sessions, queueing, and caching.

Laravel is accessible, yet powerful, providing powerful tools needed for large, robust applications. A superb inversion of control container, expressive migration system, and tightly integrated unit testing support give you the tools you need to build any application with which you are tasked.

## Official Documentation

Documentation for the framework can be found on the [Laravel website](http://laravel.com/docs).

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](http://laravel.com/docs/contributions).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell at taylor@laravel.com. All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)

## Attach Kits

The third-party kit included below.

[l5-repository](http://andersonandra.de/l5-repository/)

[league/fractal](https://fractal.thephpleague.com/installation/)

[jwt-auth](https://jwt-auth.readthedocs.io/en/develop/)

[apidoc](https://github.com/mpociot/laravel-apidoc-generator)

[activitylog](https://github.com/spatie/laravel-activitylog)

[laravel-phone](https://github.com/Propaganistas/Laravel-Phone)

[guzzlehttp](https://github.com/guzzle/guzzle)

## Development Learning

### 主要建構 Artisan Commands :
```
$ [更新:APP Secret Key] $php artisan key:generate 
$ [更新:JWT Secret Key] $php artisan jwt:secret
$ [更新:Signature Secret Key] $php artisan signature:secret
$ [建構:Migration 索引表] $php artisan migrate:install
$ [建構:Migration 數據表] $php artisan migrate --seed
$ [建構:全實體部件] $php artisan make:entity
$ [建構:Controller 實體] $php artisan make:rest-controller
$ [建構:Exception Code 部件] $php artisan make:ex-code
$ [建構:Exception Code Language] $php artisan make:ex-converter
$ [建構:Request 部件] $php artisan make:request
$ [建構:Response 部件] $php artisan make:response
$ [建構:User Auth Model 部件] $php artisan make:user-auth
$ [建構:Feature 部件] $php artisan make:feature
$ [建構:SMS Notification 部件] $php artisan make:notification-sms
$ [建構:Verifier 部件] $php artisan make:verifier
$ [建構:Cell 部件] $php artisan make:cell
$ [建構:API 文件] $php artisan apidoc:generate --force
$ [建構:Currency Model 部件] $php artisan make:currency
```

### 主要生產 Artisan Commands :
```
$ [生產:系統參數] $php artisan data:sp-add
$ [生產:authority 欄位] $php artisan mg-column:append-authority
$ [生產:feature 欄位] $php artisan mg-column:append-feature
$ [生產:setting 欄位] $php artisan mg-column:append-setting
$ [生產:unique_auth 欄位] $php artisan mg-column:append-unique-auth
$ [建立:ban 服務禁令配置]] $php artisan config:add-ban-service
$ [暫停:trade 服務接口] $php artisan trade:pause
$ [建立:trade 授權源類配置] $php artisan config:add-trade-source
$ [建立:receipt 表單種類配置] $php artisan config:add-receipt-form
$ [建立:receipt 授權源類配置] $php artisan config:add-receipt-source
```

### 數據操作 Artisan Commands :
```
$ [建立:Client Service] $php artisan data:client-add
$ [讀取:Client Service] $php artisan data:client-read
$ [編輯:Client Service] $php artisan data:client-edit
$ [讀取:系統參數] $php artisan data:sp-read
$ [編輯:系統參數] $php artisan data:sp-edit
$ [清除:資料庫過期緩存] $php artisan cache:db-expired-clear
```

### 驗證規則 Validator :
```
@ [行動電話-全球地區 範例: +886933852661] phone:AUTO,mobile
@ [任意電話-全球地區 範例: +8860229998110] phone:AUTO
@ [行動電話-台灣地區 範例: +886933852661] phone:TW,mobile
@ [行動電話-台灣地區 & 中國地區 範例: +886933852661] phone:TW,CN,mobile
@ [臺灣身分證字號 範例: A113515664] taiwan_id_verifier
@ [額度範圍支持浮點長度 範例: 100.00] amount_verifier:0.00,100.00 >> amount_verifier:min,max
@ [實例物件類型驗證 範例: new Foo()] instanceof_verifier
@ [實例物件名驗證 範例: new Foo()] instanceof_verifier:Foo
@ [實例複數物件名驗證 範例: new Foo()] instanceof_verifier:Foo,...
```

### 代碼擴展 Function :
```
+ [身份授權驗證類] TokenAuth
+ [語系文字提取] Lang::dict
+ [API 格式響應] Response::success
+ [電話解析] Phone::parse
```

### 開發檔案目錄 :
```
> Responses 處理響應數據返回樣式，產檔目錄。
	app \ Http \ Controllers \ Responses (相關指令 : $php artisan make:response)
> Exception 訊息碼對應檔，產檔目錄。
	app \ Exceptions  (相關指令 : $php artisan make:ex-code)
> 程式函式庫目錄。
	app \ Libraries
> Exception 訊息轉換對應檔，產檔目錄。
	resources \ lang \ 語系 \ exception (相關指令 : $php artisan make:ex-converter)
```

### 配置檔案 :
```
> API Service 授權配置檔。
	config \ auth.php
> API Service 權限限制配置檔。
	config \ ban.php
> API Exception 對應轉換錯誤碼配置檔。
	config \ exception.php
> API Feature 特徵元件索引配置檔。
	config \ feature.php
> API Parameter 系統參數驗證器配置檔。
	config \ sp.php
> API SMS 頻道基礎配置檔。
	config \ sms.php
> API Signature 簽章存儲配置檔。
	config \ signature.php
> API Map 基礎存儲配置檔。
	config \ map.php
> API Notice 基礎存儲配置檔。
	config \ notice.php
> API Janitor 基礎類配置檔。
	config \ janitor.php	
> API Admin 管理員配置檔。
	config \ admin.php
> API Trade 交易貨幣配置檔。
	config \ trade.php
> API Rreceipt 單據操作配置檔。
	config \ receipt.php
```

### 開發注意事項 :
```
* 基本 make: 指令遵循 PSR-1 命名規則，避免路徑產生不如預期的錯誤。
* 特殊指令 make:ex-converter 需使用 Exception namespace class name 全名建檔，才能正確捕抓 Exception Class。
* 屏蔽 Exception 儲存日誌，請於 app \ Exceptions \ Handler.php 中修訂 $dontReport 數組，可父類群組屏蔽。
* 使用 l5-repository 物件 Repository 操作 Create 或 Update 相關，若指定 Validator Class 會驗證寫入數據庫數據。
```

### l5-repository 開發定位  : 
```
* Entities : 僅當成 Eloquent Model。
* Repositories : 輔助 Entities，處理資料商業邏輯，注入到 Controllers 。
* Requests : 接收 Request 處理數據驗證，注入到 Controllers。
* Controllers : 接收 Request，返回 Response。
* Presenters : 處理數據顯示邏輯，注入到 Repositories。
* Transformers : 輔助 Presenters  提供資料庫數據返回樣式。
* Validators : 輔助 Repositories 處理資料數據驗證。
```
