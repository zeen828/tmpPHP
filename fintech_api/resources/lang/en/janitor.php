<?php
return [

    /*
    |--------------------------------------------------------------------------
    | Guest Type Name
    |--------------------------------------------------------------------------
    |
    | Set the guest type relative name list.
    |
    | Example :
    | 'names' => [
    |    Guest type code => Type name
    | ]
    */

    'names' => [
        'business_bet' => 'Racing Lottery',
        'business_binary' => 'Binary Option',
        'exchange_pay_day' => 'Payday',
    ],

    /*
    |--------------------------------------------------------------------------
    | Guest Data
    |--------------------------------------------------------------------------
    |
    | Set the relative data content of the guest type.
    |
    | Example :
    | 'data' => [
    |    You can customize the content
    | ]
    */

    'data' => [
        'payday' => [
            'error' => [
                '0' => 'Success.',
                //成功
                '2' => 'Other errors.',
                //其他錯誤
                '5' => 'Field format does not match.',
                //欄位格式不符合
                '6' => 'Fill in the item field.',
                //項目欄位填空
                '7' => 'Signature verification erro.',
                //簽名驗證錯誤
                '9' => 'Incorrect or incomplete data fields.',
                //資料欄位錯誤或不齊全
                '11' => 'Store number does not exist.',
                //店家編號不存在
                '201' => 'Insufficient amount available.',
                //可撥金額不足
                '302' => 'Order number already exists.',
                //訂單編號已經存在
                '1102' => 'Store is not bound.',
            ]
        ]
    ],
];