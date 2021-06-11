---
title: API Reference

language_tabs:
- bash
- javascript
- php
- python

includes:

search: true

toc_footers:
- <a href='#'>Top</a>
---
<!-- START_INFO -->
# Info

Welcome to the API reference documentation.

API documentation is for developers to use.


<!-- END_INFO -->
## Authorization

You must register your service with provider, and provider will provide you with the information client_id and client_secrect required for login.

## Verification

Service authorization verification uses a JWT authentication token.

### Note :

<aside class="warning" style="color:#FFFFFF" >
When the access token expires, if you continue to call the service API, the request will automatically refresh the access token contained in the header authorization and return a new access token to you.
</aside>

## Error

When the request APIs fails, respond to related error messages.

### Response Body

success : false

error :

Parameter | Type | Description
--------- | ------- | ------- | -----------
status | INT | Http status code
code | INT | Error code
message | STR | Error message
description | OBJ | Other error descriptions

#Activity Log


<!-- START_de44251051971e0a9942942f1741060a -->
## Activity Log Types

Get a list of log types for system activity.

### Response Body

success : true

data :

Parameter | Type | Description
--------- | ------- | ------- | -----------
type | STR | Log type code
name | STR | Log type name

> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/v1/system/log/type" \
    -H "Accept: application/json" \
    -H "Accept-Language: zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2" \
    -H "X-Timezone: Asia/Taipei" \
    -H "Authorization: Bearer {access_token}"
```

```javascript
const url = new URL(
    "http://localhost/api/v1/system/log/type"
);

let headers = {
    "Accept": "application/json",
    "Accept-Language": "zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2",
    "X-Timezone": "Asia/Taipei",
    "Authorization": "Bearer {access_token}",
    "Content-Type": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'http://localhost/api/v1/system/log/type',
    [
        'headers' => [
            'Accept' => 'application/json',
            'Accept-Language' => 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
            'X-Timezone' => 'Asia/Taipei',
            'Authorization' => 'Bearer {access_token}',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://localhost/api/v1/system/log/type'
headers = {
  'Accept': 'application/json',
  'Accept-Language': 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
  'X-Timezone': 'Asia/Taipei',
  'Authorization': 'Bearer {access_token}'
}
response = requests.request('GET', url, headers=headers)
response.json()
```


> Example response (200):

```json
{
    "success": true,
    "data": [
        {
            "type": "default",
            "name": "Default"
        },
        {
            "type": "model",
            "name": "Model"
        },
        {
            "type": "access",
            "name": "Access"
        },
        {
            "type": "auth",
            "name": "Auth"
        },
        {
            "type": "login",
            "name": "Login"
        },
        {
            "type": "logout",
            "name": "Logout"
        },
        {
            "type": "revoke",
            "name": "Revoke"
        }
    ]
}
```

### HTTP Request
`GET api/v1/system/log/type`


<!-- END_de44251051971e0a9942942f1741060a -->

<!-- START_a1640eb011c86c73d626bc1d89d50014 -->
## Activity Log Index

Get the system activity log index.

### Response Body

success : true

data :

Parameter | Type | Description
--------- | ------- | ------- | -----------
type | STR | Log type code
name | STR | Log type name
description | STR | Log operation description
target_id | STR | Target indicator id
target_name | STR | Target type name of model
trigger_id | STR | Trigger indicator id
trigger_name | STR | Trigger type name of model
properties | OBJ | Property content
created_at | STR | Datetime when the log was created

meta.pagination :

Parameter | Type | Description
--------- | ------- | ------- | -----------
total | INT | Total number of data
count | INT | Number of data displayed
per_page | INT | Number of displayed data per page
current_page | INT | Current page number
total_pages | INT | Total pages

> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/v1/system/logs/default?start=2018-10-01&end=2020-10-30&page=1&rows=15" \
    -H "Accept: application/json" \
    -H "Accept-Language: zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2" \
    -H "X-Timezone: Asia/Taipei" \
    -H "Authorization: Bearer {access_token}"
```

```javascript
const url = new URL(
    "http://localhost/api/v1/system/logs/default"
);

let params = {
    "start": "2018-10-01",
    "end": "2020-10-30",
    "page": "1",
    "rows": "15",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Accept": "application/json",
    "Accept-Language": "zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2",
    "X-Timezone": "Asia/Taipei",
    "Authorization": "Bearer {access_token}",
    "Content-Type": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'http://localhost/api/v1/system/logs/default',
    [
        'headers' => [
            'Accept' => 'application/json',
            'Accept-Language' => 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
            'X-Timezone' => 'Asia/Taipei',
            'Authorization' => 'Bearer {access_token}',
        ],
        'query' => [
            'start'=> '2018-10-01',
            'end'=> '2020-10-30',
            'page'=> '1',
            'rows'=> '15',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://localhost/api/v1/system/logs/default'
params = {
  'start': '2018-10-01',
  'end': '2020-10-30',
  'page': '1',
  'rows': '15',
}
headers = {
  'Accept': 'application/json',
  'Accept-Language': 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
  'X-Timezone': 'Asia/Taipei',
  'Authorization': 'Bearer {access_token}'
}
response = requests.request('GET', url, headers=headers, params=params)
response.json()
```


> Example response (200):

```json
{
    "success": true,
    "data": [
        {
            "type": "model",
            "name": "Model",
            "description": "Updated",
            "target_id": "1",
            "target_name": "System Parameter",
            "trigger_id": "1294583",
            "trigger_name": "Client",
            "properties": {
                "old": {
                    "value": "20",
                    "updated_at": "2020-01-10 09:45:15"
                },
                "attributes": {
                    "value": "2",
                    "updated_at": "2020-01-10 09:45:19"
                }
            },
            "created_at": "2020-01-10 09:45:19"
        }
    ],
    "meta": {
        "pagination": {
            "total": 1,
            "count": 1,
            "per_page": 15,
            "current_page": 1,
            "total_pages": 1
        }
    }
}
```

### HTTP Request
`GET api/v1/system/logs/{type?}`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `type` |  optional  | Log type code
#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `start` |  optional  | Start range of query creation date
    `end` |  optional  | End range of query creation date
    `page` |  required  | Page number
    `rows` |  optional  | Per page rows defaults to 15

<!-- END_a1640eb011c86c73d626bc1d89d50014 -->

#Auth Token


<!-- START_f20788e5bb009bef0443c783c5049af6 -->
## Get Access Token

Login with client service to get the access token.

### Response Body

success : true

data :

Parameter | Type | Description
--------- | ------- | ------- | -----------
access_token | STR | API access token
token_type | STR | API access token type
expires_in | INT | API access token valid seconds

> Example request:

```bash
curl -X POST \
    "http://localhost/api/v1/auth/token" \
    -H "Content-Type: application/x-www-form-urlencoded" \
    -H "Accept: application/json" \
    -H "Accept-Language: zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2" \
    -H "X-Timezone: Asia/Taipei" \
    -d '{"client_id":"{client_id}","client_secret":"{client_secret}"}'

```

```javascript
const url = new URL(
    "http://localhost/api/v1/auth/token"
);

let headers = {
    "Content-Type": "application/x-www-form-urlencoded",
    "Accept": "application/json",
    "Accept-Language": "zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2",
    "X-Timezone": "Asia/Taipei",
};

let body = {
    "client_id": "{client_id}",
    "client_secret": "{client_secret}"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'http://localhost/api/v1/auth/token',
    [
        'headers' => [
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Accept' => 'application/json',
            'Accept-Language' => 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
            'X-Timezone' => 'Asia/Taipei',
        ],
        'form_params' => [
            'client_id' => '{client_id}',
            'client_secret' => '{client_secret}',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://localhost/api/v1/auth/token'
payload = {
    "client_id": "{client_id}",
    "client_secret": "{client_secret}"
}
headers = {
  'Content-Type': 'application/x-www-form-urlencoded',
  'Accept': 'application/json',
  'Accept-Language': 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
  'X-Timezone': 'Asia/Taipei'
}
response = requests.request('POST', url, headers=headers, json=payload)
response.json()
```


> Example response (200):

```json
{
    "success": true,
    "data": {
        "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9sb2NhbGhvc3RcL2FwaVwvdjFcL2F1dGhcL3Rva2VuIiwiaWF0IjoxNTQzMjI2NzgzLCJleHAiOjE1NDMyMjY4NDMsIm5iZiI6MTU0MzIyNjc4MywianRpIjoiWnZYVk9Ib2JRRzhKSnZqUCIsInN1YiI6MX0.9ZwtS9G2FyEPypmYczvZWuqUykEtEX2foDpYEXuTurc",
        "token_type": "bearer",
        "expires_in": 3660
    }
}
```

### HTTP Request
`POST api/v1/auth/token`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `client_id` | STR |  required  | Client id
        `client_secret` | STR |  required  | Client secret
    
<!-- END_f20788e5bb009bef0443c783c5049af6 -->

<!-- START_68e63b8a0b5cc80072f757c903bae06f -->
## Refresh Access Token

Refresh the current access token.

### Response Body

success : true

data :

Parameter | Type | Description
--------- | ------- | ------- | -----------
access_token | STR | API access token
token_type | STR | API access token type
expires_in | INT | API access token valid seconds

> Example request:

```bash
curl -X PATCH \
    "http://localhost/api/v1/auth/token/refresh" \
    -H "Content-Type: application/x-www-form-urlencoded" \
    -H "Accept: application/json" \
    -H "Accept-Language: zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2" \
    -H "X-Timezone: Asia/Taipei" \
    -H "Authorization: Bearer {access_token}"
```

```javascript
const url = new URL(
    "http://localhost/api/v1/auth/token/refresh"
);

let headers = {
    "Content-Type": "application/x-www-form-urlencoded",
    "Accept": "application/json",
    "Accept-Language": "zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2",
    "X-Timezone": "Asia/Taipei",
    "Authorization": "Bearer {access_token}",
};

fetch(url, {
    method: "PATCH",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->patch(
    'http://localhost/api/v1/auth/token/refresh',
    [
        'headers' => [
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Accept' => 'application/json',
            'Accept-Language' => 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
            'X-Timezone' => 'Asia/Taipei',
            'Authorization' => 'Bearer {access_token}',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://localhost/api/v1/auth/token/refresh'
headers = {
  'Content-Type': 'application/x-www-form-urlencoded',
  'Accept': 'application/json',
  'Accept-Language': 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
  'X-Timezone': 'Asia/Taipei',
  'Authorization': 'Bearer {access_token}'
}
response = requests.request('PATCH', url, headers=headers)
response.json()
```


> Example response (200):

```json
{
    "success": true,
    "data": {
        "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9sb2NhbGhvc3RcL2FwaVwvdjFcL2F1dGhcL3Rva2VuXC9yZWZyZXNoIiwiaWF0IjoxNTQzMjI2NzgzLCJleHAiOjE1NDMyMjY4NDMsIm5iZiI6MTU0MzIyNjc4MywianRpIjoiMzRMbUZ5a3hQUDR3eWg0SSIsInN1YiI6MX0.GcZ8vExcbjWRTPQ_kOlBUg3h32ph-4viXIugApqjsTA",
        "token_type": "bearer",
        "expires_in": 3660
    }
}
```

### HTTP Request
`PATCH api/v1/auth/token/refresh`


<!-- END_68e63b8a0b5cc80072f757c903bae06f -->

<!-- START_bb25dd8e6f847f92794b7887a2cfdc1d -->
## Revoke Access Token

Revoke the current access token.

### Response Body

success : true

> Example request:

```bash
curl -X DELETE \
    "http://localhost/api/v1/auth/token" \
    -H "Content-Type: application/x-www-form-urlencoded" \
    -H "Accept: application/json" \
    -H "Accept-Language: zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2" \
    -H "X-Timezone: Asia/Taipei" \
    -H "Authorization: Bearer {access_token}"
```

```javascript
const url = new URL(
    "http://localhost/api/v1/auth/token"
);

let headers = {
    "Content-Type": "application/x-www-form-urlencoded",
    "Accept": "application/json",
    "Accept-Language": "zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2",
    "X-Timezone": "Asia/Taipei",
    "Authorization": "Bearer {access_token}",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->delete(
    'http://localhost/api/v1/auth/token',
    [
        'headers' => [
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Accept' => 'application/json',
            'Accept-Language' => 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
            'X-Timezone' => 'Asia/Taipei',
            'Authorization' => 'Bearer {access_token}',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://localhost/api/v1/auth/token'
headers = {
  'Content-Type': 'application/x-www-form-urlencoded',
  'Accept': 'application/json',
  'Accept-Language': 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
  'X-Timezone': 'Asia/Taipei',
  'Authorization': 'Bearer {access_token}'
}
response = requests.request('DELETE', url, headers=headers)
response.json()
```


> Example response (200):

```json
{
    "success": true
}
```

### HTTP Request
`DELETE api/v1/auth/token`


<!-- END_bb25dd8e6f847f92794b7887a2cfdc1d -->

<!-- START_998817f1756c5ceba7368d2f0d1e977f -->
## Login Identity

Login with user credentials and return the user's identity access token.

### Response Body

success : true

data :

Parameter | Type | Description
--------- | ------- | ------- | -----------
access_token | STR | API access token
token_type | STR | API access token type
expires_in | INT | API access token valid seconds

> Example request:

```bash
curl -X POST \
    "http://localhost/api/v1/auth/user/login/admin" \
    -H "Content-Type: application/x-www-form-urlencoded" \
    -H "Accept: application/json" \
    -H "Accept-Language: zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2" \
    -H "X-Timezone: Asia/Taipei" \
    -H "Authorization: Bearer {access_token}" \
    -d '{"account":"{account}","password":"{password}"}'

```

```javascript
const url = new URL(
    "http://localhost/api/v1/auth/user/login/admin"
);

let headers = {
    "Content-Type": "application/x-www-form-urlencoded",
    "Accept": "application/json",
    "Accept-Language": "zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2",
    "X-Timezone": "Asia/Taipei",
    "Authorization": "Bearer {access_token}",
};

let body = {
    "account": "{account}",
    "password": "{password}"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'http://localhost/api/v1/auth/user/login/admin',
    [
        'headers' => [
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Accept' => 'application/json',
            'Accept-Language' => 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
            'X-Timezone' => 'Asia/Taipei',
            'Authorization' => 'Bearer {access_token}',
        ],
        'form_params' => [
            'account' => '{account}',
            'password' => '{password}',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://localhost/api/v1/auth/user/login/admin'
payload = {
    "account": "{account}",
    "password": "{password}"
}
headers = {
  'Content-Type': 'application/x-www-form-urlencoded',
  'Accept': 'application/json',
  'Accept-Language': 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
  'X-Timezone': 'Asia/Taipei',
  'Authorization': 'Bearer {access_token}'
}
response = requests.request('POST', url, headers=headers, json=payload)
response.json()
```


> Example response (200):

```json
{
    "success": true,
    "data": {
        "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ8.eyJpc6MiOiJodHRwOlwvXC8sb2NhbGhvc3RcL2FwaVwvdjFcL2F1dGhcL3Rva2VuXC9yZWZyZXNoIiwiaWF0IjoxNTQzMjI2NzgzLCJleHAiOjE1NDMyMjY4NDMsIm5iZiI6MTU0MzIyNjc4MywianRpIjoiMzRMbUZ5a3hQUDR3eWg0SSIsInN1YiI6MX0.GcZ8vExcbjWRTPQ_kOlBUg3h32ph-4viXIugApqjsTA",
        "token_type": "bearer",
        "expires_in": 3660
    }
}
```

### HTTP Request
`POST api/v1/auth/user/login/{type}`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `type` |  required  | User type code
#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `account` | STR |  required  | User account
        `password` | STR |  required  | User password
    
<!-- END_998817f1756c5ceba7368d2f0d1e977f -->

<!-- START_3f94ccb69d3e756917f3a7c16856ab8c -->
## Login Signature

Login with user authorized signature code and return the user's identity access token.

### Response Body

success : true

data :

Parameter | Type | Description
--------- | ------- | ------- | -----------
access_token | STR | API access token
token_type | STR | API access token type
expires_in | INT | API access token valid seconds

> Example request:

```bash
curl -X POST \
    "http://localhost/api/v1/auth/user/signature/login" \
    -H "Content-Type: application/x-www-form-urlencoded" \
    -H "Accept: application/json" \
    -H "Accept-Language: zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2" \
    -H "X-Timezone: Asia/Taipei" \
    -H "Authorization: Bearer {access_token}" \
    -d '{"signature":"{signature}"}'

```

```javascript
const url = new URL(
    "http://localhost/api/v1/auth/user/signature/login"
);

let headers = {
    "Content-Type": "application/x-www-form-urlencoded",
    "Accept": "application/json",
    "Accept-Language": "zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2",
    "X-Timezone": "Asia/Taipei",
    "Authorization": "Bearer {access_token}",
};

let body = {
    "signature": "{signature}"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'http://localhost/api/v1/auth/user/signature/login',
    [
        'headers' => [
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Accept' => 'application/json',
            'Accept-Language' => 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
            'X-Timezone' => 'Asia/Taipei',
            'Authorization' => 'Bearer {access_token}',
        ],
        'form_params' => [
            'signature' => '{signature}',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://localhost/api/v1/auth/user/signature/login'
payload = {
    "signature": "{signature}"
}
headers = {
  'Content-Type': 'application/x-www-form-urlencoded',
  'Accept': 'application/json',
  'Accept-Language': 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
  'X-Timezone': 'Asia/Taipei',
  'Authorization': 'Bearer {access_token}'
}
response = requests.request('POST', url, headers=headers, json=payload)
response.json()
```


> Example response (200):

```json
{
    "success": true,
    "data": {
        "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ8.eyJpc6MiOiJodHRwOlwvXC8sb2NhbGhvc3RcL2FwaVwvdjFcL2F1dGhcL3Rva2VuXC9yZWZyZXNoIiwiaWF0IjoxNTQzMjI2NzgzLCJleHAiOjE1NDMyMjY4NDMsIm5iZiI6MTU0MzIyNjc4MywianRpIjoiMzRMbUZ5a3hQUDR3eWg0SSIsInN1YiI6MX0.GcZ8vExcbjWRTPQ_kOlBUg3h32ph-4viXIugApqjsTA",
        "token_type": "bearer",
        "expires_in": 3660
    }
}
```

### HTTP Request
`POST api/v1/auth/user/signature/login`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `signature` | STR |  required  | User authorized signature code
    
<!-- END_3f94ccb69d3e756917f3a7c16856ab8c -->

<!-- START_b215a331b41c5b89eb535674f45d6d3b -->
## Logout Identity

Revoke the current user's identity access token and return client access token.

### Response Body

success : true

data :

Parameter | Type | Description
--------- | ------- | ------- | -----------
access_token | STR | API access token
token_type | STR | API access token type
expires_in | INT | API access token valid seconds

> Example request:

```bash
curl -X DELETE \
    "http://localhost/api/v1/auth/user/logout" \
    -H "Content-Type: application/x-www-form-urlencoded" \
    -H "Accept: application/json" \
    -H "Accept-Language: zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2" \
    -H "X-Timezone: Asia/Taipei" \
    -H "Authorization: Bearer {access_token}"
```

```javascript
const url = new URL(
    "http://localhost/api/v1/auth/user/logout"
);

let headers = {
    "Content-Type": "application/x-www-form-urlencoded",
    "Accept": "application/json",
    "Accept-Language": "zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2",
    "X-Timezone": "Asia/Taipei",
    "Authorization": "Bearer {access_token}",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->delete(
    'http://localhost/api/v1/auth/user/logout',
    [
        'headers' => [
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Accept' => 'application/json',
            'Accept-Language' => 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
            'X-Timezone' => 'Asia/Taipei',
            'Authorization' => 'Bearer {access_token}',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://localhost/api/v1/auth/user/logout'
headers = {
  'Content-Type': 'application/x-www-form-urlencoded',
  'Accept': 'application/json',
  'Accept-Language': 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
  'X-Timezone': 'Asia/Taipei',
  'Authorization': 'Bearer {access_token}'
}
response = requests.request('DELETE', url, headers=headers)
response.json()
```


> Example response (200):

```json
{
    "success": true,
    "data": {
        "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ8.eyJpc3MiOiJodHRwOlwvXC8sb2NhbGhvc3RcL2FwaVwvdjFcL2F1dGhcL3Rva2VuXC9yZWZyZXNoIiwiaWF0IjoxNTQzMjI2NzgzLCJleHAiOjE1NDMyMjY4NDMsIm5iZiI6MTU0MzIyNjc4MywianRpIjoiMzRMbUZ5a3hQUDR3eWg0SSIsInN1YiI6MX0.GcZ8vExcbjWRTPQ_kOlBUg3h32ph-4viXIugApqjsTA",
        "token_type": "bearer",
        "expires_in": 3660
    }
}
```

### HTTP Request
`DELETE api/v1/auth/user/logout`


<!-- END_b215a331b41c5b89eb535674f45d6d3b -->

<!-- START_4785e33720e3e17f3a15fbfccb507b8c -->
## Authorization Signature

Get the user code used for signature authorization login.

### Response Body

success : true

data :

Parameter | Type | Description
--------- | ------- | ------- | -----------
signature | STR | Authorized signature code
expires_in | INT | Authorized signature code valid seconds

> Example request:

```bash
curl -X POST \
    "http://localhost/api/v1/auth/user/signature" \
    -H "Content-Type: application/x-www-form-urlencoded" \
    -H "Accept: application/json" \
    -H "Accept-Language: zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2" \
    -H "X-Timezone: Asia/Taipei" \
    -H "Authorization: Bearer {access_token}"
```

```javascript
const url = new URL(
    "http://localhost/api/v1/auth/user/signature"
);

let headers = {
    "Content-Type": "application/x-www-form-urlencoded",
    "Accept": "application/json",
    "Accept-Language": "zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2",
    "X-Timezone": "Asia/Taipei",
    "Authorization": "Bearer {access_token}",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'http://localhost/api/v1/auth/user/signature',
    [
        'headers' => [
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Accept' => 'application/json',
            'Accept-Language' => 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
            'X-Timezone' => 'Asia/Taipei',
            'Authorization' => 'Bearer {access_token}',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://localhost/api/v1/auth/user/signature'
headers = {
  'Content-Type': 'application/x-www-form-urlencoded',
  'Accept': 'application/json',
  'Accept-Language': 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
  'X-Timezone': 'Asia/Taipei',
  'Authorization': 'Bearer {access_token}'
}
response = requests.request('POST', url, headers=headers)
response.json()
```


> Example response (200):

```json
{
    "success": true,
    "data": {
        "signature": "8466b336802941ac8df1bd3173bdeb8de1fabcec5fbb036f0c08c550a738b182abab2d07",
        "expires_in": 180
    }
}
```

### HTTP Request
`POST api/v1/auth/user/signature`


<!-- END_4785e33720e3e17f3a15fbfccb507b8c -->

<!-- START_78f9296d6b3db0d9eef1c43efc8b0e58 -->
## Show Service Profile

Show the client service profile for the current access token.

### Response Body

success : true

data :

Parameter | Type | Description
--------- | ------- | ------- | -----------
app_id | STR | Client serial id
name | STR | Client name
ban | INT | Client ban number
description | STR | Client ban description
created_at | STR | Datetime when the client was created
updated_at | STR | Client last updated datetime

> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/v1/auth/service" \
    -H "Accept: application/json" \
    -H "Accept-Language: zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2" \
    -H "X-Timezone: Asia/Taipei" \
    -H "Authorization: Bearer {access_token}"
```

```javascript
const url = new URL(
    "http://localhost/api/v1/auth/service"
);

let headers = {
    "Accept": "application/json",
    "Accept-Language": "zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2",
    "X-Timezone": "Asia/Taipei",
    "Authorization": "Bearer {access_token}",
    "Content-Type": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'http://localhost/api/v1/auth/service',
    [
        'headers' => [
            'Accept' => 'application/json',
            'Accept-Language' => 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
            'X-Timezone' => 'Asia/Taipei',
            'Authorization' => 'Bearer {access_token}',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://localhost/api/v1/auth/service'
headers = {
  'Accept': 'application/json',
  'Accept-Language': 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
  'X-Timezone': 'Asia/Taipei',
  'Authorization': 'Bearer {access_token}'
}
response = requests.request('GET', url, headers=headers)
response.json()
```


> Example response (200):

```json
{
    "success": true,
    "data": {
        "app_id": "6398211294583",
        "name": "admin",
        "ban": 0,
        "description": "Global Service",
        "created_at": "2018-11-26 11:41:32",
        "updated_at": "2018-11-26 11:41:32"
    }
}
```

### HTTP Request
`GET api/v1/auth/service`


<!-- END_78f9296d6b3db0d9eef1c43efc8b0e58 -->

<!-- START_99bf69cde1e88c66c8ab6a145412c67f -->
## Login Types

Get a list of user types for login.

### Response Body

success : true

data :

Parameter | Type | Description
--------- | ------- | ------- | -----------
type | STR | Type code
description | STR | Type about description

> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/v1/auth/user/type" \
    -H "Accept: application/json" \
    -H "Accept-Language: zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2" \
    -H "X-Timezone: Asia/Taipei" \
    -H "Authorization: Bearer {access_token}"
```

```javascript
const url = new URL(
    "http://localhost/api/v1/auth/user/type"
);

let headers = {
    "Accept": "application/json",
    "Accept-Language": "zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2",
    "X-Timezone": "Asia/Taipei",
    "Authorization": "Bearer {access_token}",
    "Content-Type": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'http://localhost/api/v1/auth/user/type',
    [
        'headers' => [
            'Accept' => 'application/json',
            'Accept-Language' => 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
            'X-Timezone' => 'Asia/Taipei',
            'Authorization' => 'Bearer {access_token}',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://localhost/api/v1/auth/user/type'
headers = {
  'Accept': 'application/json',
  'Accept-Language': 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
  'X-Timezone': 'Asia/Taipei',
  'Authorization': 'Bearer {access_token}'
}
response = requests.request('GET', url, headers=headers)
response.json()
```


> Example response (200):

```json
{
    "success": true,
    "data": [
        {
            "type": "member",
            "description": "Member User"
        },
        {
            "type": "admin",
            "description": "Admin User"
        }
    ]
}
```

### HTTP Request
`GET api/v1/auth/user/type`


<!-- END_99bf69cde1e88c66c8ab6a145412c67f -->

#Authority Operation


<!-- START_071cca960826af06018aca214c6a1335 -->
## Global Authority

Grant the global permissions to type object.

### Response Body

success : true

> Example request:

```bash
curl -X PUT \
    "http://localhost/api/v1/system/authority/global/admin/1294583" \
    -H "Content-Type: application/x-www-form-urlencoded" \
    -H "Accept: application/json" \
    -H "Accept-Language: zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2" \
    -H "X-Timezone: Asia/Taipei" \
    -H "Authorization: Bearer {access_token}"
```

```javascript
const url = new URL(
    "http://localhost/api/v1/system/authority/global/admin/1294583"
);

let headers = {
    "Content-Type": "application/x-www-form-urlencoded",
    "Accept": "application/json",
    "Accept-Language": "zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2",
    "X-Timezone": "Asia/Taipei",
    "Authorization": "Bearer {access_token}",
};

fetch(url, {
    method: "PUT",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->put(
    'http://localhost/api/v1/system/authority/global/admin/1294583',
    [
        'headers' => [
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Accept' => 'application/json',
            'Accept-Language' => 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
            'X-Timezone' => 'Asia/Taipei',
            'Authorization' => 'Bearer {access_token}',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://localhost/api/v1/system/authority/global/admin/1294583'
headers = {
  'Content-Type': 'application/x-www-form-urlencoded',
  'Accept': 'application/json',
  'Accept-Language': 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
  'X-Timezone': 'Asia/Taipei',
  'Authorization': 'Bearer {access_token}'
}
response = requests.request('PUT', url, headers=headers)
response.json()
```


> Example response (200):

```json
{
    "success": true
}
```

### HTTP Request
`PUT api/v1/system/authority/global/{type}/{uid}`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `type` |  required  | License object type code
    `uid` |  required  | Identify the object serial id

<!-- END_071cca960826af06018aca214c6a1335 -->

<!-- START_434dd7b9b7125ac2c26611a3f18c6fc9 -->
## Grant Authority

Grant the permissions to type object.

### Response Body

success : true

> Example request:

```bash
curl -X PATCH \
    "http://localhost/api/v1/system/authority/grant/admin/1294583" \
    -H "Content-Type: application/x-www-form-urlencoded" \
    -H "Accept: application/json" \
    -H "Accept-Language: zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2" \
    -H "X-Timezone: Asia/Taipei" \
    -H "Authorization: Bearer {access_token}" \
    -d '{"interface":"{interface}","snapshot":"{snapshot}"}'

```

```javascript
const url = new URL(
    "http://localhost/api/v1/system/authority/grant/admin/1294583"
);

let headers = {
    "Content-Type": "application/x-www-form-urlencoded",
    "Accept": "application/json",
    "Accept-Language": "zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2",
    "X-Timezone": "Asia/Taipei",
    "Authorization": "Bearer {access_token}",
};

let body = {
    "interface": "{interface}",
    "snapshot": "{snapshot}"
}

fetch(url, {
    method: "PATCH",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->patch(
    'http://localhost/api/v1/system/authority/grant/admin/1294583',
    [
        'headers' => [
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Accept' => 'application/json',
            'Accept-Language' => 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
            'X-Timezone' => 'Asia/Taipei',
            'Authorization' => 'Bearer {access_token}',
        ],
        'form_params' => [
            'interface' => '{interface}',
            'snapshot' => '{snapshot}',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://localhost/api/v1/system/authority/grant/admin/1294583'
payload = {
    "interface": "{interface}",
    "snapshot": "{snapshot}"
}
headers = {
  'Content-Type': 'application/x-www-form-urlencoded',
  'Accept': 'application/json',
  'Accept-Language': 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
  'X-Timezone': 'Asia/Taipei',
  'Authorization': 'Bearer {access_token}'
}
response = requests.request('PATCH', url, headers=headers, json=payload)
response.json()
```


> Example response (200):

```json
{
    "success": true
}
```

### HTTP Request
`PATCH api/v1/system/authority/grant/{type}/{uid}`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `type` |  required  | License object type code
    `uid` |  required  | Identify the object serial id
#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `interface` | ARR |  optional  | Managed APIs interface code
        `snapshot` | ARR |  optional  | Authority snapshot id
    
<!-- END_434dd7b9b7125ac2c26611a3f18c6fc9 -->

<!-- START_1d84986cb7536728cea607803158087c -->
## Remove Authority

Remove the permissions to type object.

### Response Body

success : true

> Example request:

```bash
curl -X PATCH \
    "http://localhost/api/v1/system/authority/remove/admin/1294583" \
    -H "Content-Type: application/x-www-form-urlencoded" \
    -H "Accept: application/json" \
    -H "Accept-Language: zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2" \
    -H "X-Timezone: Asia/Taipei" \
    -H "Authorization: Bearer {access_token}" \
    -d '{"interface":"{interface}","snapshot":"{snapshot}"}'

```

```javascript
const url = new URL(
    "http://localhost/api/v1/system/authority/remove/admin/1294583"
);

let headers = {
    "Content-Type": "application/x-www-form-urlencoded",
    "Accept": "application/json",
    "Accept-Language": "zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2",
    "X-Timezone": "Asia/Taipei",
    "Authorization": "Bearer {access_token}",
};

let body = {
    "interface": "{interface}",
    "snapshot": "{snapshot}"
}

fetch(url, {
    method: "PATCH",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->patch(
    'http://localhost/api/v1/system/authority/remove/admin/1294583',
    [
        'headers' => [
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Accept' => 'application/json',
            'Accept-Language' => 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
            'X-Timezone' => 'Asia/Taipei',
            'Authorization' => 'Bearer {access_token}',
        ],
        'form_params' => [
            'interface' => '{interface}',
            'snapshot' => '{snapshot}',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://localhost/api/v1/system/authority/remove/admin/1294583'
payload = {
    "interface": "{interface}",
    "snapshot": "{snapshot}"
}
headers = {
  'Content-Type': 'application/x-www-form-urlencoded',
  'Accept': 'application/json',
  'Accept-Language': 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
  'X-Timezone': 'Asia/Taipei',
  'Authorization': 'Bearer {access_token}'
}
response = requests.request('PATCH', url, headers=headers, json=payload)
response.json()
```


> Example response (200):

```json
{
    "success": true
}
```

### HTTP Request
`PATCH api/v1/system/authority/remove/{type}/{uid}`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `type` |  required  | License object type code
    `uid` |  required  | Identify the object serial id
#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `interface` | ARR |  optional  | Managed APIs interface code
        `snapshot` | ARR |  optional  | Authority snapshot id
    
<!-- END_1d84986cb7536728cea607803158087c -->

<!-- START_358058f78909f17714a89f302f319291 -->
## Authority License Types

Get a list of authority object types.

### Response Body

success : true

data :

Parameter | Type | Description
--------- | ------- | ------- | -----------
type | STR | Type code
description | STR | Type about description

> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/v1/system/authority/type" \
    -H "Accept: application/json" \
    -H "Accept-Language: zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2" \
    -H "X-Timezone: Asia/Taipei" \
    -H "Authorization: Bearer {access_token}"
```

```javascript
const url = new URL(
    "http://localhost/api/v1/system/authority/type"
);

let headers = {
    "Accept": "application/json",
    "Accept-Language": "zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2",
    "X-Timezone": "Asia/Taipei",
    "Authorization": "Bearer {access_token}",
    "Content-Type": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'http://localhost/api/v1/system/authority/type',
    [
        'headers' => [
            'Accept' => 'application/json',
            'Accept-Language' => 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
            'X-Timezone' => 'Asia/Taipei',
            'Authorization' => 'Bearer {access_token}',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://localhost/api/v1/system/authority/type'
headers = {
  'Accept': 'application/json',
  'Accept-Language': 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
  'X-Timezone': 'Asia/Taipei',
  'Authorization': 'Bearer {access_token}'
}
response = requests.request('GET', url, headers=headers)
response.json()
```


> Example response (200):

```json
{
    "success": true,
    "data": [
        {
            "type": "member",
            "description": "Member User"
        },
        {
            "type": "admin",
            "description": "Admin User"
        }
    ]
}
```

### HTTP Request
`GET api/v1/system/authority/type`


<!-- END_358058f78909f17714a89f302f319291 -->

#Authority Snapshot


<!-- START_4663a02d82579882c4fec18f5c283144 -->
## Build Authority Snapshot

Build a authority snapshot.

### Response Body

success : true

data :

Parameter | Type | Description
--------- | ------- | ------- | -----------
id | STR | Snapshot id
name | STR | Snapshot name

> Example request:

```bash
curl -X POST \
    "http://localhost/api/v1/system/authority/snapshot" \
    -H "Content-Type: application/x-www-form-urlencoded" \
    -H "Accept: application/json" \
    -H "Accept-Language: zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2" \
    -H "X-Timezone: Asia/Taipei" \
    -H "Authorization: Bearer {access_token}" \
    -d '{"name":"{name}","interface":"{interface}"}'

```

```javascript
const url = new URL(
    "http://localhost/api/v1/system/authority/snapshot"
);

let headers = {
    "Content-Type": "application/x-www-form-urlencoded",
    "Accept": "application/json",
    "Accept-Language": "zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2",
    "X-Timezone": "Asia/Taipei",
    "Authorization": "Bearer {access_token}",
};

let body = {
    "name": "{name}",
    "interface": "{interface}"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'http://localhost/api/v1/system/authority/snapshot',
    [
        'headers' => [
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Accept' => 'application/json',
            'Accept-Language' => 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
            'X-Timezone' => 'Asia/Taipei',
            'Authorization' => 'Bearer {access_token}',
        ],
        'form_params' => [
            'name' => '{name}',
            'interface' => '{interface}',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://localhost/api/v1/system/authority/snapshot'
payload = {
    "name": "{name}",
    "interface": "{interface}"
}
headers = {
  'Content-Type': 'application/x-www-form-urlencoded',
  'Accept': 'application/json',
  'Accept-Language': 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
  'X-Timezone': 'Asia/Taipei',
  'Authorization': 'Bearer {access_token}'
}
response = requests.request('POST', url, headers=headers, json=payload)
response.json()
```


> Example response (200):

```json
{
    "success": true,
    "data": {
        "id": "4f9f99e6d29046439a438b05f9607da1",
        "name": "View Client"
    }
}
```

### HTTP Request
`POST api/v1/system/authority/snapshot`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `name` | STR |  required  | Authority snapshot name
        `interface` | ARR |  required  | Managed APIs interface code
    
<!-- END_4663a02d82579882c4fec18f5c283144 -->

<!-- START_5c6e08aa0996c3c4840b887bbcd14c8d -->
## Rename Authority Snapshot

Rename the snapshot name of the authority snapshot.

### Response Body

success : true

> Example request:

```bash
curl -X PATCH \
    "http://localhost/api/v1/system/authority/snapshot/4f9f99e6d29046439a438b05f9607da1/name" \
    -H "Content-Type: application/x-www-form-urlencoded" \
    -H "Accept: application/json" \
    -H "Accept-Language: zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2" \
    -H "X-Timezone: Asia/Taipei" \
    -H "Authorization: Bearer {access_token}" \
    -d '{"name":"{name}"}'

```

```javascript
const url = new URL(
    "http://localhost/api/v1/system/authority/snapshot/4f9f99e6d29046439a438b05f9607da1/name"
);

let headers = {
    "Content-Type": "application/x-www-form-urlencoded",
    "Accept": "application/json",
    "Accept-Language": "zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2",
    "X-Timezone": "Asia/Taipei",
    "Authorization": "Bearer {access_token}",
};

let body = {
    "name": "{name}"
}

fetch(url, {
    method: "PATCH",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->patch(
    'http://localhost/api/v1/system/authority/snapshot/4f9f99e6d29046439a438b05f9607da1/name',
    [
        'headers' => [
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Accept' => 'application/json',
            'Accept-Language' => 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
            'X-Timezone' => 'Asia/Taipei',
            'Authorization' => 'Bearer {access_token}',
        ],
        'form_params' => [
            'name' => '{name}',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://localhost/api/v1/system/authority/snapshot/4f9f99e6d29046439a438b05f9607da1/name'
payload = {
    "name": "{name}"
}
headers = {
  'Content-Type': 'application/x-www-form-urlencoded',
  'Accept': 'application/json',
  'Accept-Language': 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
  'X-Timezone': 'Asia/Taipei',
  'Authorization': 'Bearer {access_token}'
}
response = requests.request('PATCH', url, headers=headers, json=payload)
response.json()
```


> Example response (200):

```json
{
    "success": true
}
```

### HTTP Request
`PATCH api/v1/system/authority/snapshot/{id}/name`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `id` |  required  | Authority snapshot id
#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `name` | STR |  required  | Authority snapshot name
    
<!-- END_5c6e08aa0996c3c4840b887bbcd14c8d -->

<!-- START_43cf7284570837d48455a56949920e2f -->
## Authority Snapshot Index

Get the authority snapshot index.

### Response Body

success : true

data :

Parameter | Type | Description
--------- | ------- | ------- | -----------
id | STR | Snapshot id
name | STR | Snapshot name
created_at | STR | Datetime when the snapshot was created
updated_at | STR | Snapshot last updated datetime

meta.pagination :

Parameter | Type | Description
--------- | ------- | ------- | -----------
total | INT | Total number of data
count | INT | Number of data displayed
per_page | INT | Number of displayed data per page
current_page | INT | Current page number
total_pages | INT | Total pages

> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/v1/system/authority/snapshot?start=2018-10-01&end=2020-10-30&page=1&rows=15" \
    -H "Accept: application/json" \
    -H "Accept-Language: zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2" \
    -H "X-Timezone: Asia/Taipei" \
    -H "Authorization: Bearer {access_token}"
```

```javascript
const url = new URL(
    "http://localhost/api/v1/system/authority/snapshot"
);

let params = {
    "start": "2018-10-01",
    "end": "2020-10-30",
    "page": "1",
    "rows": "15",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Accept": "application/json",
    "Accept-Language": "zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2",
    "X-Timezone": "Asia/Taipei",
    "Authorization": "Bearer {access_token}",
    "Content-Type": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'http://localhost/api/v1/system/authority/snapshot',
    [
        'headers' => [
            'Accept' => 'application/json',
            'Accept-Language' => 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
            'X-Timezone' => 'Asia/Taipei',
            'Authorization' => 'Bearer {access_token}',
        ],
        'query' => [
            'start'=> '2018-10-01',
            'end'=> '2020-10-30',
            'page'=> '1',
            'rows'=> '15',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://localhost/api/v1/system/authority/snapshot'
params = {
  'start': '2018-10-01',
  'end': '2020-10-30',
  'page': '1',
  'rows': '15',
}
headers = {
  'Accept': 'application/json',
  'Accept-Language': 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
  'X-Timezone': 'Asia/Taipei',
  'Authorization': 'Bearer {access_token}'
}
response = requests.request('GET', url, headers=headers, params=params)
response.json()
```


> Example response (200):

```json
{
    "success": true,
    "data": [
        {
            "id": "4f9f99e6d29046439a438b05f9607da1",
            "name": "View Client",
            "created_at": "2020-01-10 09:45:19",
            "updated_at": "2020-01-10 09:45:19"
        }
    ],
    "meta": {
        "pagination": {
            "total": 1,
            "count": 1,
            "per_page": 15,
            "current_page": 1,
            "total_pages": 1
        }
    }
}
```

### HTTP Request
`GET api/v1/system/authority/snapshot`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `start` |  optional  | Start range of query creation date
    `end` |  optional  | End range of query creation date
    `page` |  required  | Page number
    `rows` |  optional  | Per page rows defaults to 15

<!-- END_43cf7284570837d48455a56949920e2f -->

<!-- START_510bcb6fbb5e447630ad02d3faea18ed -->
## Authority Snapshot Info

Get the specified snapshot info from authority.

### Response Body

success : true

data :

Parameter | Type | Description
--------- | ------- | ------- | -----------
id | STR | Snapshot id
name | STR | Snapshot name
authority | ARR | Snapshot APIs authority
created_at | STR | Datetime when the snapshot was created
updated_at | STR | Snapshot last updated datetime

> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/v1/system/authority/snapshot/4f9f99e6d29046439a438b05f9607da1" \
    -H "Accept: application/json" \
    -H "Accept-Language: zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2" \
    -H "X-Timezone: Asia/Taipei" \
    -H "Authorization: Bearer {access_token}"
```

```javascript
const url = new URL(
    "http://localhost/api/v1/system/authority/snapshot/4f9f99e6d29046439a438b05f9607da1"
);

let headers = {
    "Accept": "application/json",
    "Accept-Language": "zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2",
    "X-Timezone": "Asia/Taipei",
    "Authorization": "Bearer {access_token}",
    "Content-Type": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'http://localhost/api/v1/system/authority/snapshot/4f9f99e6d29046439a438b05f9607da1',
    [
        'headers' => [
            'Accept' => 'application/json',
            'Accept-Language' => 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
            'X-Timezone' => 'Asia/Taipei',
            'Authorization' => 'Bearer {access_token}',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://localhost/api/v1/system/authority/snapshot/4f9f99e6d29046439a438b05f9607da1'
headers = {
  'Accept': 'application/json',
  'Accept-Language': 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
  'X-Timezone': 'Asia/Taipei',
  'Authorization': 'Bearer {access_token}'
}
response = requests.request('GET', url, headers=headers)
response.json()
```


> Example response (200):

```json
{
    "success": true,
    "data": {
        "id": "4f9f99e6d29046439a438b05f9607da1",
        "name": "View Client",
        "authority": [
            "auth.client.index",
            "auth.token.create"
        ],
        "created_at": "2020-01-10 09:45:19",
        "updated_at": "2020-01-10 09:45:19"
    }
}
```

### HTTP Request
`GET api/v1/system/authority/snapshot/{id}`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `id` |  required  | Authority snapshot id

<!-- END_510bcb6fbb5e447630ad02d3faea18ed -->

<!-- START_6a06f6f58051d0669ee54bd499e5c6d0 -->
## Delete Authority Snapshot

Delete the specified snapshot from authority.

### Response Body

success : true

> Example request:

```bash
curl -X DELETE \
    "http://localhost/api/v1/system/authority/snapshot/4f9f99e6d29046439a438b05f9607da1" \
    -H "Accept: application/json" \
    -H "Accept-Language: zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2" \
    -H "X-Timezone: Asia/Taipei" \
    -H "Authorization: Bearer {access_token}"
```

```javascript
const url = new URL(
    "http://localhost/api/v1/system/authority/snapshot/4f9f99e6d29046439a438b05f9607da1"
);

let headers = {
    "Accept": "application/json",
    "Accept-Language": "zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2",
    "X-Timezone": "Asia/Taipei",
    "Authorization": "Bearer {access_token}",
    "Content-Type": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->delete(
    'http://localhost/api/v1/system/authority/snapshot/4f9f99e6d29046439a438b05f9607da1',
    [
        'headers' => [
            'Accept' => 'application/json',
            'Accept-Language' => 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
            'X-Timezone' => 'Asia/Taipei',
            'Authorization' => 'Bearer {access_token}',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://localhost/api/v1/system/authority/snapshot/4f9f99e6d29046439a438b05f9607da1'
headers = {
  'Accept': 'application/json',
  'Accept-Language': 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
  'X-Timezone': 'Asia/Taipei',
  'Authorization': 'Bearer {access_token}'
}
response = requests.request('DELETE', url, headers=headers)
response.json()
```


> Example response (200):

```json
{
    "success": true
}
```

### HTTP Request
`DELETE api/v1/system/authority/snapshot/{id}`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `id` |  required  | Authority snapshot id

<!-- END_6a06f6f58051d0669ee54bd499e5c6d0 -->

#Client Service


<!-- START_6d34569a6f41a28ced38518748ef8d63 -->
## Build Client

Build a client user for the service.

### Response Body

success : true

data :

Parameter | Type | Description
--------- | ------- | ------- | -----------
app_id | STR | Client serial id
name | STR | Client name
client_id | STR | Client id account
client_secret | STR | Client secret password
ban | INT | Client ban number
description | STR | Client ban description
status | BOOL | Client status false: Disable true: Enable
created_at | STR | Datetime when the client was created
updated_at | STR | Client last updated datetime

> Example request:

```bash
curl -X POST \
    "http://localhost/api/v1/auth/client" \
    -H "Content-Type: application/x-www-form-urlencoded" \
    -H "Accept: application/json" \
    -H "Accept-Language: zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2" \
    -H "X-Timezone: Asia/Taipei" \
    -H "Authorization: Bearer {access_token}" \
    -d '{"name":"{name}","ban":"{ban}"}'

```

```javascript
const url = new URL(
    "http://localhost/api/v1/auth/client"
);

let headers = {
    "Content-Type": "application/x-www-form-urlencoded",
    "Accept": "application/json",
    "Accept-Language": "zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2",
    "X-Timezone": "Asia/Taipei",
    "Authorization": "Bearer {access_token}",
};

let body = {
    "name": "{name}",
    "ban": "{ban}"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'http://localhost/api/v1/auth/client',
    [
        'headers' => [
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Accept' => 'application/json',
            'Accept-Language' => 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
            'X-Timezone' => 'Asia/Taipei',
            'Authorization' => 'Bearer {access_token}',
        ],
        'form_params' => [
            'name' => '{name}',
            'ban' => '{ban}',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://localhost/api/v1/auth/client'
payload = {
    "name": "{name}",
    "ban": "{ban}"
}
headers = {
  'Content-Type': 'application/x-www-form-urlencoded',
  'Accept': 'application/json',
  'Accept-Language': 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
  'X-Timezone': 'Asia/Taipei',
  'Authorization': 'Bearer {access_token}'
}
response = requests.request('POST', url, headers=headers, json=payload)
response.json()
```


> Example response (200):

```json
{
    "success": true,
    "data": {
        "app_id": "6398214000002",
        "name": "mmo game",
        "client_id": "c81e8e3225624250829a2139eb8a4d4c",
        "client_secret": "d4b25b9f79aa9f489557efeb78671197",
        "ban": 1,
        "description": "User Service",
        "status": true,
        "created_at": "2018-11-26 18:06:24",
        "updated_at": "2018-11-26 18:06:24"
    }
}
```

### HTTP Request
`POST api/v1/auth/client`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `name` | STR |  required  | Client service name
        `ban` | INT |  required  | Ban number
    
<!-- END_6d34569a6f41a28ced38518748ef8d63 -->

<!-- START_fe3e999aa43d7782c9e13d5bb8eb7acb -->
## Reset Client Secret

Reset the client's service secret.

### Response Body

success : true

data :

Parameter | Type | Description
--------- | ------- | ------- | -----------
client_secret | STR | Client secret password

> Example request:

```bash
curl -X PATCH \
    "http://localhost/api/v1/auth/client/1294583/reset_secret" \
    -H "Content-Type: application/x-www-form-urlencoded" \
    -H "Accept: application/json" \
    -H "Accept-Language: zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2" \
    -H "X-Timezone: Asia/Taipei" \
    -H "Authorization: Bearer {access_token}"
```

```javascript
const url = new URL(
    "http://localhost/api/v1/auth/client/1294583/reset_secret"
);

let headers = {
    "Content-Type": "application/x-www-form-urlencoded",
    "Accept": "application/json",
    "Accept-Language": "zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2",
    "X-Timezone": "Asia/Taipei",
    "Authorization": "Bearer {access_token}",
};

fetch(url, {
    method: "PATCH",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->patch(
    'http://localhost/api/v1/auth/client/1294583/reset_secret',
    [
        'headers' => [
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Accept' => 'application/json',
            'Accept-Language' => 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
            'X-Timezone' => 'Asia/Taipei',
            'Authorization' => 'Bearer {access_token}',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://localhost/api/v1/auth/client/1294583/reset_secret'
headers = {
  'Content-Type': 'application/x-www-form-urlencoded',
  'Accept': 'application/json',
  'Accept-Language': 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
  'X-Timezone': 'Asia/Taipei',
  'Authorization': 'Bearer {access_token}'
}
response = requests.request('PATCH', url, headers=headers)
response.json()
```


> Example response (200):

```json
{
    "success": true,
    "data": {
        "client_secret": "5a38f514ffe7704f8c0094d41fb75bf7"
    }
}
```

### HTTP Request
`PATCH api/v1/auth/client/{app_id}/reset_secret`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `app_id` |  required  | Client serial id

<!-- END_fe3e999aa43d7782c9e13d5bb8eb7acb -->

<!-- START_179c59ff52d2e057dba49a43ea819856 -->
## Rename Client

Rename the client name of the service.

### Response Body

success : true

> Example request:

```bash
curl -X PATCH \
    "http://localhost/api/v1/auth/client/2215437/name" \
    -H "Content-Type: application/x-www-form-urlencoded" \
    -H "Accept: application/json" \
    -H "Accept-Language: zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2" \
    -H "X-Timezone: Asia/Taipei" \
    -H "Authorization: Bearer {access_token}" \
    -d '{"name":"{name}"}'

```

```javascript
const url = new URL(
    "http://localhost/api/v1/auth/client/2215437/name"
);

let headers = {
    "Content-Type": "application/x-www-form-urlencoded",
    "Accept": "application/json",
    "Accept-Language": "zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2",
    "X-Timezone": "Asia/Taipei",
    "Authorization": "Bearer {access_token}",
};

let body = {
    "name": "{name}"
}

fetch(url, {
    method: "PATCH",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->patch(
    'http://localhost/api/v1/auth/client/2215437/name',
    [
        'headers' => [
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Accept' => 'application/json',
            'Accept-Language' => 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
            'X-Timezone' => 'Asia/Taipei',
            'Authorization' => 'Bearer {access_token}',
        ],
        'form_params' => [
            'name' => '{name}',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://localhost/api/v1/auth/client/2215437/name'
payload = {
    "name": "{name}"
}
headers = {
  'Content-Type': 'application/x-www-form-urlencoded',
  'Accept': 'application/json',
  'Accept-Language': 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
  'X-Timezone': 'Asia/Taipei',
  'Authorization': 'Bearer {access_token}'
}
response = requests.request('PATCH', url, headers=headers, json=payload)
response.json()
```


> Example response (200):

```json
{
    "success": true
}
```

### HTTP Request
`PATCH api/v1/auth/client/{app_id}/name`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `app_id` |  required  | Client serial id
#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `name` | STR |  required  | Client service name
    
<!-- END_179c59ff52d2e057dba49a43ea819856 -->

<!-- START_43c613f4ba24e7a610fe7e9bbb6ca0d2 -->
## Rewrite Client Ban

Rewrite the client ban number of the service.

### Response Body

success : true

> Example request:

```bash
curl -X PATCH \
    "http://localhost/api/v1/auth/client/2215437/ban" \
    -H "Content-Type: application/x-www-form-urlencoded" \
    -H "Accept: application/json" \
    -H "Accept-Language: zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2" \
    -H "X-Timezone: Asia/Taipei" \
    -H "Authorization: Bearer {access_token}" \
    -d '{"ban":"{ban}"}'

```

```javascript
const url = new URL(
    "http://localhost/api/v1/auth/client/2215437/ban"
);

let headers = {
    "Content-Type": "application/x-www-form-urlencoded",
    "Accept": "application/json",
    "Accept-Language": "zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2",
    "X-Timezone": "Asia/Taipei",
    "Authorization": "Bearer {access_token}",
};

let body = {
    "ban": "{ban}"
}

fetch(url, {
    method: "PATCH",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->patch(
    'http://localhost/api/v1/auth/client/2215437/ban',
    [
        'headers' => [
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Accept' => 'application/json',
            'Accept-Language' => 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
            'X-Timezone' => 'Asia/Taipei',
            'Authorization' => 'Bearer {access_token}',
        ],
        'form_params' => [
            'ban' => '{ban}',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://localhost/api/v1/auth/client/2215437/ban'
payload = {
    "ban": "{ban}"
}
headers = {
  'Content-Type': 'application/x-www-form-urlencoded',
  'Accept': 'application/json',
  'Accept-Language': 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
  'X-Timezone': 'Asia/Taipei',
  'Authorization': 'Bearer {access_token}'
}
response = requests.request('PATCH', url, headers=headers, json=payload)
response.json()
```


> Example response (200):

```json
{
    "success": true
}
```

### HTTP Request
`PATCH api/v1/auth/client/{app_id}/ban`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `app_id` |  required  | Client serial id
#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `ban` | INT |  required  | Ban number
    
<!-- END_43c613f4ba24e7a610fe7e9bbb6ca0d2 -->

<!-- START_d9b2c15892e3a3af5d67eb19ee5f993d -->
## Disable Client

Disable the client user for the service.

### Response Body

success : true

> Example request:

```bash
curl -X PATCH \
    "http://localhost/api/v1/auth/client/2215437/disable" \
    -H "Content-Type: application/x-www-form-urlencoded" \
    -H "Accept: application/json" \
    -H "Accept-Language: zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2" \
    -H "X-Timezone: Asia/Taipei" \
    -H "Authorization: Bearer {access_token}"
```

```javascript
const url = new URL(
    "http://localhost/api/v1/auth/client/2215437/disable"
);

let headers = {
    "Content-Type": "application/x-www-form-urlencoded",
    "Accept": "application/json",
    "Accept-Language": "zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2",
    "X-Timezone": "Asia/Taipei",
    "Authorization": "Bearer {access_token}",
};

fetch(url, {
    method: "PATCH",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->patch(
    'http://localhost/api/v1/auth/client/2215437/disable',
    [
        'headers' => [
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Accept' => 'application/json',
            'Accept-Language' => 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
            'X-Timezone' => 'Asia/Taipei',
            'Authorization' => 'Bearer {access_token}',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://localhost/api/v1/auth/client/2215437/disable'
headers = {
  'Content-Type': 'application/x-www-form-urlencoded',
  'Accept': 'application/json',
  'Accept-Language': 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
  'X-Timezone': 'Asia/Taipei',
  'Authorization': 'Bearer {access_token}'
}
response = requests.request('PATCH', url, headers=headers)
response.json()
```


> Example response (200):

```json
{
    "success": true
}
```

### HTTP Request
`PATCH api/v1/auth/client/{app_id}/disable`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `app_id` |  required  | Client serial id

<!-- END_d9b2c15892e3a3af5d67eb19ee5f993d -->

<!-- START_e896ce251295c2b8d2d38ee35246fbca -->
## Enable Client

Enable the client user for the service.

### Response Body

success : true

> Example request:

```bash
curl -X PATCH \
    "http://localhost/api/v1/auth/client/2215437/enable" \
    -H "Content-Type: application/x-www-form-urlencoded" \
    -H "Accept: application/json" \
    -H "Accept-Language: zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2" \
    -H "X-Timezone: Asia/Taipei" \
    -H "Authorization: Bearer {access_token}"
```

```javascript
const url = new URL(
    "http://localhost/api/v1/auth/client/2215437/enable"
);

let headers = {
    "Content-Type": "application/x-www-form-urlencoded",
    "Accept": "application/json",
    "Accept-Language": "zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2",
    "X-Timezone": "Asia/Taipei",
    "Authorization": "Bearer {access_token}",
};

fetch(url, {
    method: "PATCH",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->patch(
    'http://localhost/api/v1/auth/client/2215437/enable',
    [
        'headers' => [
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Accept' => 'application/json',
            'Accept-Language' => 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
            'X-Timezone' => 'Asia/Taipei',
            'Authorization' => 'Bearer {access_token}',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://localhost/api/v1/auth/client/2215437/enable'
headers = {
  'Content-Type': 'application/x-www-form-urlencoded',
  'Accept': 'application/json',
  'Accept-Language': 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
  'X-Timezone': 'Asia/Taipei',
  'Authorization': 'Bearer {access_token}'
}
response = requests.request('PATCH', url, headers=headers)
response.json()
```


> Example response (200):

```json
{
    "success": true
}
```

### HTTP Request
`PATCH api/v1/auth/client/{app_id}/enable`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `app_id` |  required  | Client serial id

<!-- END_e896ce251295c2b8d2d38ee35246fbca -->

<!-- START_7d5b3045644027fa3c82032eb23c6269 -->
## Ban Index

Get the ban index for the service.

### Response Body

success : true

data :

Parameter | Type | Description
--------- | ------- | ------- | -----------
number | INT | Ban number
description | STR | Ban description
status | BOOL | Available option status false: Disable true: Enable

> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/v1/auth/client/ban" \
    -H "Accept: application/json" \
    -H "Accept-Language: zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2" \
    -H "X-Timezone: Asia/Taipei" \
    -H "Authorization: Bearer {access_token}"
```

```javascript
const url = new URL(
    "http://localhost/api/v1/auth/client/ban"
);

let headers = {
    "Accept": "application/json",
    "Accept-Language": "zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2",
    "X-Timezone": "Asia/Taipei",
    "Authorization": "Bearer {access_token}",
    "Content-Type": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'http://localhost/api/v1/auth/client/ban',
    [
        'headers' => [
            'Accept' => 'application/json',
            'Accept-Language' => 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
            'X-Timezone' => 'Asia/Taipei',
            'Authorization' => 'Bearer {access_token}',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://localhost/api/v1/auth/client/ban'
headers = {
  'Accept': 'application/json',
  'Accept-Language': 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
  'X-Timezone': 'Asia/Taipei',
  'Authorization': 'Bearer {access_token}'
}
response = requests.request('GET', url, headers=headers)
response.json()
```


> Example response (200):

```json
{
    "success": true,
    "data": [
        {
            "number": 0,
            "description": "Global Service",
            "status": true
        },
        {
            "number": 1,
            "description": "User Service",
            "status": true
        },
        {
            "number": 2,
            "description": "Admin Service",
            "status": true
        }
    ]
}
```

### HTTP Request
`GET api/v1/auth/client/ban`


<!-- END_7d5b3045644027fa3c82032eb23c6269 -->

<!-- START_73f2b75334014a01aecf0774396bd8c4 -->
## Ban Info

Get the ban description info for the service.

### Response Body

success : true

data :

Parameter | Type | Description
--------- | ------- | ------- | -----------
number | INT | Ban number
description | STR | Ban description
status | BOOL | Available option status false: Disable true: Enable

> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/v1/auth/client/ban/1" \
    -H "Accept: application/json" \
    -H "Accept-Language: zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2" \
    -H "X-Timezone: Asia/Taipei" \
    -H "Authorization: Bearer {access_token}"
```

```javascript
const url = new URL(
    "http://localhost/api/v1/auth/client/ban/1"
);

let headers = {
    "Accept": "application/json",
    "Accept-Language": "zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2",
    "X-Timezone": "Asia/Taipei",
    "Authorization": "Bearer {access_token}",
    "Content-Type": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'http://localhost/api/v1/auth/client/ban/1',
    [
        'headers' => [
            'Accept' => 'application/json',
            'Accept-Language' => 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
            'X-Timezone' => 'Asia/Taipei',
            'Authorization' => 'Bearer {access_token}',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://localhost/api/v1/auth/client/ban/1'
headers = {
  'Accept': 'application/json',
  'Accept-Language': 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
  'X-Timezone': 'Asia/Taipei',
  'Authorization': 'Bearer {access_token}'
}
response = requests.request('GET', url, headers=headers)
response.json()
```


> Example response (200):

```json
{
    "success": true,
    "data": {
        "number": 1,
        "description": "User Service",
        "status": true
    }
}
```

### HTTP Request
`GET api/v1/auth/client/ban/{number}`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `number` |  required  | Ban number

<!-- END_73f2b75334014a01aecf0774396bd8c4 -->

<!-- START_bf8c881099ec02c8c07cbe94f0b5100b -->
## Client Index

Get the client user index for the service.

### Response Body

success : true

data :

Parameter | Type | Description
--------- | ------- | ------- | -----------
app_id | STR | Client serial id
name | STR | Client name
ban | INT | Client ban number
description | STR | Client ban description
status | BOOL | Client status false: Disable true: Enable
created_at | STR | Datetime when the client was created
updated_at | STR | Client last updated datetime

meta.pagination :

Parameter | Type | Description
--------- | ------- | ------- | -----------
total | INT | Total number of data
count | INT | Number of data displayed
per_page | INT | Number of displayed data per page
current_page | INT | Current page number
total_pages | INT | Total pages

> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/v1/auth/client?start=2018-10-01&end=2020-10-30&page=1&rows=15" \
    -H "Accept: application/json" \
    -H "Accept-Language: zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2" \
    -H "X-Timezone: Asia/Taipei" \
    -H "Authorization: Bearer {access_token}"
```

```javascript
const url = new URL(
    "http://localhost/api/v1/auth/client"
);

let params = {
    "start": "2018-10-01",
    "end": "2020-10-30",
    "page": "1",
    "rows": "15",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Accept": "application/json",
    "Accept-Language": "zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2",
    "X-Timezone": "Asia/Taipei",
    "Authorization": "Bearer {access_token}",
    "Content-Type": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'http://localhost/api/v1/auth/client',
    [
        'headers' => [
            'Accept' => 'application/json',
            'Accept-Language' => 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
            'X-Timezone' => 'Asia/Taipei',
            'Authorization' => 'Bearer {access_token}',
        ],
        'query' => [
            'start'=> '2018-10-01',
            'end'=> '2020-10-30',
            'page'=> '1',
            'rows'=> '15',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://localhost/api/v1/auth/client'
params = {
  'start': '2018-10-01',
  'end': '2020-10-30',
  'page': '1',
  'rows': '15',
}
headers = {
  'Accept': 'application/json',
  'Accept-Language': 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
  'X-Timezone': 'Asia/Taipei',
  'Authorization': 'Bearer {access_token}'
}
response = requests.request('GET', url, headers=headers, params=params)
response.json()
```


> Example response (200):

```json
{
    "success": true,
    "data": [
        {
            "app_id": "6398211294583",
            "name": "admin",
            "ban": 0,
            "description": "Global Service",
            "status": true,
            "created_at": "2018-11-26 11:41:32",
            "updated_at": "2018-11-26 11:41:32"
        },
        {
            "app_id": "6398212215437",
            "name": "sns gmae",
            "ban": 1,
            "description": "User Service",
            "status": true,
            "created_at": "2018-11-26 11:41:32",
            "updated_at": "2018-11-26 11:41:32"
        },
        {
            "app_id": "6398213515611",
            "name": "arpg gmae",
            "ban": 1,
            "description": "User Service",
            "status": true,
            "created_at": "2018-11-26 11:41:32",
            "updated_at": "2018-11-26 11:41:32"
        }
    ],
    "meta": {
        "pagination": {
            "total": 3,
            "count": 3,
            "per_page": 15,
            "current_page": 1,
            "total_pages": 1
        }
    }
}
```

### HTTP Request
`GET api/v1/auth/client`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `start` |  optional  | Start range of query creation date
    `end` |  optional  | End range of query creation date
    `page` |  required  | Page number
    `rows` |  optional  | Per page rows defaults to 15

<!-- END_bf8c881099ec02c8c07cbe94f0b5100b -->

<!-- START_76b36b901af46b9b1d00fb5cfcf956e8 -->
## Client Info

Get the client user info for the service.

### Response Body

success : true

data :

Parameter | Type | Description
--------- | ------- | ------- | -----------
app_id | STR | Client serial id
name | STR | Client name
client_id | STR | Client id account
client_secret | STR | Client secret password
ban | INT | Client ban number
description | STR | Client ban description
status | BOOL | Client status false: Disable true: Enable
created_at | STR | Datetime when the client was created
updated_at | STR | Client last updated datetime

> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/v1/auth/client/1294583" \
    -H "Accept: application/json" \
    -H "Accept-Language: zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2" \
    -H "X-Timezone: Asia/Taipei" \
    -H "Authorization: Bearer {access_token}"
```

```javascript
const url = new URL(
    "http://localhost/api/v1/auth/client/1294583"
);

let headers = {
    "Accept": "application/json",
    "Accept-Language": "zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2",
    "X-Timezone": "Asia/Taipei",
    "Authorization": "Bearer {access_token}",
    "Content-Type": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'http://localhost/api/v1/auth/client/1294583',
    [
        'headers' => [
            'Accept' => 'application/json',
            'Accept-Language' => 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
            'X-Timezone' => 'Asia/Taipei',
            'Authorization' => 'Bearer {access_token}',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://localhost/api/v1/auth/client/1294583'
headers = {
  'Accept': 'application/json',
  'Accept-Language': 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
  'X-Timezone': 'Asia/Taipei',
  'Authorization': 'Bearer {access_token}'
}
response = requests.request('GET', url, headers=headers)
response.json()
```


> Example response (200):

```json
{
    "success": true,
    "data": {
        "app_id": "6398211294583",
        "name": "admin",
        "client_id": "2301cb9578e2de254401ccc473928439",
        "client_secret": "504b8f12b812b4b8ddeb210f826de044",
        "ban": 0,
        "description": "Global Service",
        "status": true,
        "created_at": "2018-11-26 11:41:32",
        "updated_at": "2018-11-26 11:41:32"
    }
}
```

### HTTP Request
`GET api/v1/auth/client/{app_id}`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `app_id` |  required  | Client serial id

<!-- END_76b36b901af46b9b1d00fb5cfcf956e8 -->

#Feature Provider


<!-- START_3222428f9020909edab32c7ea58a933e -->
## Feature Index

Get the feature index for the provider.

### Response Body

success : true

data :

Parameter | Type | Description
--------- | ------- | ------- | -----------
code | STR | Feature code
description | STR | Feature description
arguments.deploy.{*}.type | STR | Feature deployment arguments type
arguments.deploy.{*}.status | STR | Feature deployment arguments request status 'required' or 'optional'
arguments.deploy.{*}.description | STR | Feature deployment arguments description
arguments.handle.{*}.type | STR | Feature handle arguments type
arguments.handle.{*}.status | STR | Feature handle arguments request status 'required' or 'optional'
arguments.handle.{*}.description | STR | Feature handle arguments description
responses.deploy.{*}.type | STR | Feature deployment responses type
responses.deploy.{*}.description | STR | Feature deployment responses description
responses.handle.{*}.type | STR | Feature handle responses type
responses.handle.{*}.description | STR | Feature handle responses description

> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/v1/feature" \
    -H "Accept: application/json" \
    -H "Accept-Language: zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2" \
    -H "X-Timezone: Asia/Taipei" \
    -H "Authorization: Bearer {access_token}"
```

```javascript
const url = new URL(
    "http://localhost/api/v1/feature"
);

let headers = {
    "Accept": "application/json",
    "Accept-Language": "zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2",
    "X-Timezone": "Asia/Taipei",
    "Authorization": "Bearer {access_token}",
    "Content-Type": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'http://localhost/api/v1/feature',
    [
        'headers' => [
            'Accept' => 'application/json',
            'Accept-Language' => 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
            'X-Timezone' => 'Asia/Taipei',
            'Authorization' => 'Bearer {access_token}',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://localhost/api/v1/feature'
headers = {
  'Accept': 'application/json',
  'Accept-Language': 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
  'X-Timezone': 'Asia/Taipei',
  'Authorization': 'Bearer {access_token}'
}
response = requests.request('GET', url, headers=headers)
response.json()
```


> Example response (200):

```json
{
    "success": true,
    "data": [
        {
            "code": "add_gold",
            "description": "Increase Gold Coins",
            "arguments": {
                "deploy": {
                    "quantity": {
                        "type": "integer",
                        "status": "required",
                        "description": "Quantity increase ( 1 ~ 2147483647 )"
                    }
                },
                "handle": []
            },
            "responses": {
                "deploy": {
                    "quantity": {
                        "type": "integer",
                        "description": "Increase quantity"
                    }
                },
                "handle": {
                    "name": {
                        "type": "string",
                        "description": "Currency name"
                    },
                    "quantity": {
                        "type": "integer",
                        "description": "Increase quantity"
                    }
                }
            }
        },
        {
            "code": "item_bale",
            "description": "Package Item",
            "arguments": {
                "deploy": {
                    "id": {
                        "type": "integer",
                        "status": "required",
                        "description": "Item serial id"
                    },
                    "quantity": {
                        "type": "integer",
                        "status": "required",
                        "description": "Quantity increase ( 1 ~ 2147483647 )"
                    }
                },
                "handle": []
            },
            "responses": {
                "deploy": {
                    "id": {
                        "type": "integer",
                        "description": "Item serial id"
                    },
                    "quantity": {
                        "type": "integer",
                        "description": "Increase quantity"
                    }
                },
                "handle": {
                    "id": {
                        "type": "integer",
                        "description": "Item serial id"
                    },
                    "type": {
                        "type": "integer",
                        "description": "Item type number"
                    },
                    "name": {
                        "type": "string",
                        "description": "Item name"
                    },
                    "quantity": {
                        "type": "integer",
                        "description": "Increase quantity"
                    }
                }
            }
        }
    ]
}
```

### HTTP Request
`GET api/v1/feature`


<!-- END_3222428f9020909edab32c7ea58a933e -->

<!-- START_4612506758e5c99dcc229d43a3e3277a -->
## Feature Code Info

Get the feature code information for the provider.

### Response Body

success : true

data :

Parameter | Type | Description
--------- | ------- | ------- | -----------
code | STR | Feature code
description | STR | Feature description
arguments.deploy.{*}.type | STR | Feature deployment arguments type
arguments.deploy.{*}.status | STR | Feature deployment arguments request status 'required' or 'optional'
arguments.deploy.{*}.description | STR | Feature deployment arguments description
arguments.handle.{*}.type | STR | Feature handle arguments type
arguments.handle.{*}.status | STR | Feature handle arguments request status 'required' or 'optional'
arguments.handle.{*}.description | STR | Feature handle arguments description
responses.deploy.{*}.type | STR | Feature deployment responses type
responses.deploy.{*}.description | STR | Feature deployment responses description
responses.handle.{*}.type | STR | Feature handle responses type
responses.handle.{*}.description | STR | Feature handle responses description

> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/v1/feature/add_gold" \
    -H "Accept: application/json" \
    -H "Accept-Language: zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2" \
    -H "X-Timezone: Asia/Taipei" \
    -H "Authorization: Bearer {access_token}"
```

```javascript
const url = new URL(
    "http://localhost/api/v1/feature/add_gold"
);

let headers = {
    "Accept": "application/json",
    "Accept-Language": "zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2",
    "X-Timezone": "Asia/Taipei",
    "Authorization": "Bearer {access_token}",
    "Content-Type": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'http://localhost/api/v1/feature/add_gold',
    [
        'headers' => [
            'Accept' => 'application/json',
            'Accept-Language' => 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
            'X-Timezone' => 'Asia/Taipei',
            'Authorization' => 'Bearer {access_token}',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://localhost/api/v1/feature/add_gold'
headers = {
  'Accept': 'application/json',
  'Accept-Language': 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
  'X-Timezone': 'Asia/Taipei',
  'Authorization': 'Bearer {access_token}'
}
response = requests.request('GET', url, headers=headers)
response.json()
```


> Example response (200):

```json
{
    "success": true,
    "data": {
        "code": "add_gold",
        "description": "Increase Gold Coins",
        "arguments": {
            "deploy": {
                "quantity": {
                    "type": "integer",
                    "status": "required",
                    "description": "Quantity increase ( 1 ~ 2147483647 )"
                }
            },
            "handle": []
        },
        "responses": {
            "deploy": {
                "quantity": {
                    "type": "integer",
                    "description": "Increase quantity"
                }
            },
            "handle": {
                "name": {
                    "type": "string",
                    "description": "Currency name"
                },
                "quantity": {
                    "type": "integer",
                    "description": "Increase quantity"
                }
            }
        }
    }
}
```

### HTTP Request
`GET api/v1/feature/{code}`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `code` |  required  | Feature code

<!-- END_4612506758e5c99dcc229d43a3e3277a -->

#Notify Bulletin


<!-- START_44b268d0b645f408084847d51dc3cb54 -->
## Bulletin Index

Get the bulletin notification index.

### Response Body

success : true

data :

Parameter | Type | Description
--------- | ------- | ------- | -----------
id | STR | Bulletin serial id
subject | STR | Subject name
content | OBJ | Notify content
type | STR | User type code
type_name | STR | User type name
released_at | STR | Schedule the bulletin release datetime
expired_at | STR | Schedule the bulletin end datetime
status | BOOL | Bulletin status false: Disable true: Enable
created_at | STR | Datetime when the bulletin was created
updated_at | STR | Bulletin last updated datetime

meta.pagination :

Parameter | Type | Description
--------- | ------- | ------- | -----------
total | INT | Total number of data
count | INT | Number of data displayed
per_page | INT | Number of displayed data per page
current_page | INT | Current page number
total_pages | INT | Total pages

> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/v1/notice/bulletin?start=2020-10-07&end=2020-10-10&page=1&rows=15" \
    -H "Accept: application/json" \
    -H "Accept-Language: zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2" \
    -H "X-Timezone: Asia/Taipei" \
    -H "Authorization: Bearer {access_token}"
```

```javascript
const url = new URL(
    "http://localhost/api/v1/notice/bulletin"
);

let params = {
    "start": "2020-10-07",
    "end": "2020-10-10",
    "page": "1",
    "rows": "15",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Accept": "application/json",
    "Accept-Language": "zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2",
    "X-Timezone": "Asia/Taipei",
    "Authorization": "Bearer {access_token}",
    "Content-Type": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'http://localhost/api/v1/notice/bulletin',
    [
        'headers' => [
            'Accept' => 'application/json',
            'Accept-Language' => 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
            'X-Timezone' => 'Asia/Taipei',
            'Authorization' => 'Bearer {access_token}',
        ],
        'query' => [
            'start'=> '2020-10-07',
            'end'=> '2020-10-10',
            'page'=> '1',
            'rows'=> '15',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://localhost/api/v1/notice/bulletin'
params = {
  'start': '2020-10-07',
  'end': '2020-10-10',
  'page': '1',
  'rows': '15',
}
headers = {
  'Accept': 'application/json',
  'Accept-Language': 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
  'X-Timezone': 'Asia/Taipei',
  'Authorization': 'Bearer {access_token}'
}
response = requests.request('GET', url, headers=headers, params=params)
response.json()
```


> Example response (200):

```json
{
    "success": true,
    "data": [
        {
            "id": "ddc09c60-8385-4e64-8516-6ba3f6fd6a84",
            "subject": "Maintenance notice",
            "content": {
                "message": "Maintenance notice : 2020-10-10 10:00:00 ~ 2020-10-10 12:00:00."
            },
            "type": "member",
            "type_name": "Member User",
            "released_at": "2020-10-10 00:00:00",
            "expired_at": "2020-10-10 11:00:00",
            "status": true,
            "created_at": "2020-10-08 10:00:00",
            "updated_at": "2020-10-09 10:00:00"
        },
        {
            "id": "ddc09c60-8385-4e64-8516-6ba3f6fd6a82",
            "subject": "Activity notice",
            "content": {
                "message": "Activity notice.",
                "url": "https:\/\/www.example.com\/activity\/1001"
            },
            "type": "member",
            "type_name": "Member User",
            "released_at": "2020-10-10 12:00:00",
            "expired_at": "2020-10-12 10:00:00",
            "status": true,
            "created_at": "2020-10-08 11:00:00",
            "updated_at": "2020-10-08 12:00:00"
        },
        {
            "id": "ddc09c60-8385-4e64-8516-6ba3f6fd6a83",
            "subject": "Maintenance notice",
            "content": {
                "message": "Maintenance notice : 2020-10-12 10:00:00 ~ 2020-10-12 12:00:00."
            },
            "type": "member",
            "type_name": "Member User",
            "released_at": "2020-10-12 00:00:00",
            "expired_at": "2020-10-12 11:00:00",
            "status": false,
            "created_at": "2020-10-09 10:00:00",
            "updated_at": "2020-10-09 11:00:00"
        }
    ],
    "meta": {
        "pagination": {
            "total": 3,
            "count": 3,
            "per_page": 15,
            "current_page": 1,
            "total_pages": 1
        }
    }
}
```

### HTTP Request
`GET api/v1/notice/bulletin`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `start` |  optional  | Start range of query creation date
    `end` |  optional  | End range of query creation date
    `page` |  required  | Page number
    `rows` |  optional  | Per page rows defaults to 15

<!-- END_44b268d0b645f408084847d51dc3cb54 -->

<!-- START_b42ab2dc8b009a7f8e5d7912fdb6b18a -->
## Bulletin Info

Get the bulletin notification info.

### Response Body

success : true

data :

Parameter | Type | Description
--------- | ------- | ------- | -----------
id | STR | Bulletin serial id
subject | STR | Subject name
content | OBJ | Notify content
type | STR | User type code
type_name | STR | User type name
released_at | STR | Schedule the bulletin release datetime
expired_at | STR | Schedule the bulletin end datetime
status | BOOL | Bulletin status false: Disable true: Enable
created_at | STR | Datetime when the bulletin was created
updated_at | STR | Bulletin last updated datetime

> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/v1/notice/bulletin/ddc09c60-8385-4e64-8516-6ba3f6fd6a84" \
    -H "Accept: application/json" \
    -H "Accept-Language: zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2" \
    -H "X-Timezone: Asia/Taipei" \
    -H "Authorization: Bearer {access_token}"
```

```javascript
const url = new URL(
    "http://localhost/api/v1/notice/bulletin/ddc09c60-8385-4e64-8516-6ba3f6fd6a84"
);

let headers = {
    "Accept": "application/json",
    "Accept-Language": "zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2",
    "X-Timezone": "Asia/Taipei",
    "Authorization": "Bearer {access_token}",
    "Content-Type": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'http://localhost/api/v1/notice/bulletin/ddc09c60-8385-4e64-8516-6ba3f6fd6a84',
    [
        'headers' => [
            'Accept' => 'application/json',
            'Accept-Language' => 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
            'X-Timezone' => 'Asia/Taipei',
            'Authorization' => 'Bearer {access_token}',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://localhost/api/v1/notice/bulletin/ddc09c60-8385-4e64-8516-6ba3f6fd6a84'
headers = {
  'Accept': 'application/json',
  'Accept-Language': 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
  'X-Timezone': 'Asia/Taipei',
  'Authorization': 'Bearer {access_token}'
}
response = requests.request('GET', url, headers=headers)
response.json()
```


> Example response (200):

```json
{
    "success": true,
    "data": {
        "id": "ddc09c60-8385-4e64-8516-6ba3f6fd6a84",
        "subject": "Maintenance notice",
        "content": {
            "message": "Maintenance notice : 2020-10-10 10:00:00 ~ 2020-10-10 12:00:00."
        },
        "type": "member",
        "type_name": "Member User",
        "released_at": "2020-10-10 00:00:00",
        "expired_at": "2020-10-10 11:00:00",
        "status": true,
        "created_at": "2020-10-08 10:00:00",
        "updated_at": "2020-10-09 10:00:00"
    }
}
```

### HTTP Request
`GET api/v1/notice/bulletin/{id}`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `id` |  required  | Bulletin serial id

<!-- END_b42ab2dc8b009a7f8e5d7912fdb6b18a -->

<!-- START_61262d541a3fcb5b3a0bc5028bb4fea1 -->
## Notifiable User Types

Get a list of user types for notification.

### Response Body

success : true

data :

Parameter | Type | Description
--------- | ------- | ------- | -----------
type | STR | User type code
description | STR | User type about description

> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/v1/notice/bulletin/user/type" \
    -H "Accept: application/json" \
    -H "Accept-Language: zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2" \
    -H "X-Timezone: Asia/Taipei" \
    -H "Authorization: Bearer {access_token}"
```

```javascript
const url = new URL(
    "http://localhost/api/v1/notice/bulletin/user/type"
);

let headers = {
    "Accept": "application/json",
    "Accept-Language": "zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2",
    "X-Timezone": "Asia/Taipei",
    "Authorization": "Bearer {access_token}",
    "Content-Type": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'http://localhost/api/v1/notice/bulletin/user/type',
    [
        'headers' => [
            'Accept' => 'application/json',
            'Accept-Language' => 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
            'X-Timezone' => 'Asia/Taipei',
            'Authorization' => 'Bearer {access_token}',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://localhost/api/v1/notice/bulletin/user/type'
headers = {
  'Accept': 'application/json',
  'Accept-Language': 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
  'X-Timezone': 'Asia/Taipei',
  'Authorization': 'Bearer {access_token}'
}
response = requests.request('GET', url, headers=headers)
response.json()
```


> Example response (200):

```json
{
    "success": true,
    "data": [
        {
            "type": "member",
            "description": "Member User"
        },
        {
            "type": "admin",
            "description": "Admin User"
        }
    ]
}
```

### HTTP Request
`GET api/v1/notice/bulletin/user/type`


<!-- END_61262d541a3fcb5b3a0bc5028bb4fea1 -->

<!-- START_5b7eaa4b6f7f8c5260d7b149cd9f8045 -->
## Build Bulletin

Build a bulletin notification message.

### Response Body

success : true

> Example request:

```bash
curl -X POST \
    "http://localhost/api/v1/notice/bulletin/build/member" \
    -H "Accept: application/json" \
    -H "Accept-Language: zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2" \
    -H "X-Timezone: Asia/Taipei" \
    -H "Authorization: Bearer {access_token}" \
    -H "Content-Type: application/json" \
    -d '{"subject":"{subject}","message":"{message}","start":"{start}","end":"{end}"}'

```

```javascript
const url = new URL(
    "http://localhost/api/v1/notice/bulletin/build/member"
);

let headers = {
    "Accept": "application/json",
    "Accept-Language": "zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2",
    "X-Timezone": "Asia/Taipei",
    "Authorization": "Bearer {access_token}",
    "Content-Type": "application/json",
};

let body = {
    "subject": "{subject}",
    "message": "{message}",
    "start": "{start}",
    "end": "{end}"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'http://localhost/api/v1/notice/bulletin/build/member',
    [
        'headers' => [
            'Accept' => 'application/json',
            'Accept-Language' => 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
            'X-Timezone' => 'Asia/Taipei',
            'Authorization' => 'Bearer {access_token}',
            'Content-Type' => 'application/json',
        ],
        'form_params' => [
            'subject' => '{subject}',
            'message' => '{message}',
            'start' => '{start}',
            'end' => '{end}',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://localhost/api/v1/notice/bulletin/build/member'
payload = {
    "subject": "{subject}",
    "message": "{message}",
    "start": "{start}",
    "end": "{end}"
}
headers = {
  'Accept': 'application/json',
  'Accept-Language': 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
  'X-Timezone': 'Asia/Taipei',
  'Authorization': 'Bearer {access_token}',
  'Content-Type': 'application/json'
}
response = requests.request('POST', url, headers=headers, json=payload)
response.json()
```


> Example response (200):

```json
{
    "success": true
}
```

### HTTP Request
`POST api/v1/notice/bulletin/build/{type}`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `type` |  required  | User type code
#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `subject` | STR |  required  | Subject name
        `message` | STR |  required  | Push message
        `start` | STR |  required  | Bulletin start range time yyyy-mm-dd hh:ii:ss
        `end` | STR |  required  | Bulletin end range time yyyy-mm-dd hh:ii:ss
    
<!-- END_5b7eaa4b6f7f8c5260d7b149cd9f8045 -->

<!-- START_418935f2e497e100c36ca4d7ebd96d6b -->
## Disable Bulletin

Disable the bulletin notification.

### Response Body

success : true

> Example request:

```bash
curl -X PATCH \
    "http://localhost/api/v1/notice/bulletin/ddc09c60-8385-4e64-8516-6ba3f6fd6a84/disable" \
    -H "Accept: application/json" \
    -H "Accept-Language: zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2" \
    -H "X-Timezone: Asia/Taipei" \
    -H "Authorization: Bearer {access_token}"
```

```javascript
const url = new URL(
    "http://localhost/api/v1/notice/bulletin/ddc09c60-8385-4e64-8516-6ba3f6fd6a84/disable"
);

let headers = {
    "Accept": "application/json",
    "Accept-Language": "zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2",
    "X-Timezone": "Asia/Taipei",
    "Authorization": "Bearer {access_token}",
    "Content-Type": "application/json",
};

fetch(url, {
    method: "PATCH",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->patch(
    'http://localhost/api/v1/notice/bulletin/ddc09c60-8385-4e64-8516-6ba3f6fd6a84/disable',
    [
        'headers' => [
            'Accept' => 'application/json',
            'Accept-Language' => 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
            'X-Timezone' => 'Asia/Taipei',
            'Authorization' => 'Bearer {access_token}',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://localhost/api/v1/notice/bulletin/ddc09c60-8385-4e64-8516-6ba3f6fd6a84/disable'
headers = {
  'Accept': 'application/json',
  'Accept-Language': 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
  'X-Timezone': 'Asia/Taipei',
  'Authorization': 'Bearer {access_token}'
}
response = requests.request('PATCH', url, headers=headers)
response.json()
```


> Example response (200):

```json
{
    "success": true
}
```

### HTTP Request
`PATCH api/v1/notice/bulletin/{id}/disable`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `id` |  required  | Bulletin serial id

<!-- END_418935f2e497e100c36ca4d7ebd96d6b -->

<!-- START_0d9f2111af691361c4d52e70cb3eab3f -->
## Enable Bulletin

Enable the bulletin notification.

### Response Body

success : true

> Example request:

```bash
curl -X PATCH \
    "http://localhost/api/v1/notice/bulletin/ddc09c60-8385-4e64-8516-6ba3f6fd6a84/enable" \
    -H "Accept: application/json" \
    -H "Accept-Language: zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2" \
    -H "X-Timezone: Asia/Taipei" \
    -H "Authorization: Bearer {access_token}"
```

```javascript
const url = new URL(
    "http://localhost/api/v1/notice/bulletin/ddc09c60-8385-4e64-8516-6ba3f6fd6a84/enable"
);

let headers = {
    "Accept": "application/json",
    "Accept-Language": "zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2",
    "X-Timezone": "Asia/Taipei",
    "Authorization": "Bearer {access_token}",
    "Content-Type": "application/json",
};

fetch(url, {
    method: "PATCH",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->patch(
    'http://localhost/api/v1/notice/bulletin/ddc09c60-8385-4e64-8516-6ba3f6fd6a84/enable',
    [
        'headers' => [
            'Accept' => 'application/json',
            'Accept-Language' => 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
            'X-Timezone' => 'Asia/Taipei',
            'Authorization' => 'Bearer {access_token}',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://localhost/api/v1/notice/bulletin/ddc09c60-8385-4e64-8516-6ba3f6fd6a84/enable'
headers = {
  'Accept': 'application/json',
  'Accept-Language': 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
  'X-Timezone': 'Asia/Taipei',
  'Authorization': 'Bearer {access_token}'
}
response = requests.request('PATCH', url, headers=headers)
response.json()
```


> Example response (200):

```json
{
    "success": true
}
```

### HTTP Request
`PATCH api/v1/notice/bulletin/{id}/enable`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `id` |  required  | Bulletin serial id

<!-- END_0d9f2111af691361c4d52e70cb3eab3f -->

#SMS Log


<!-- START_732439d5d924dc672dc350b0cd2c6531 -->
## SMS Record Index

Get the SMS sending index.

### Response Body

success : true

data :

Parameter | Type | Description
--------- | ------- | ------- | -----------
serial | STR | SMS record serial id
source_id | STR | SMS operate source id
source | STR | SMS operate source type code
source_name | STR | SMS operate source type name
telecomer | STR | SMS telecomer type code
telecomer_name | STR | SMS telecomer type name
phone | STR | SMS to phone number
message.message | STR | SMS message
message.subject | STR | SMS subject
result | OBJ | SMS response result message
operate | STR | SMS operate type ( success, failure )
created_at | STR | Datetime when the SMS was sent
updated_at | STR | Datetime when the log was updated

meta.pagination :

Parameter | Type | Description
--------- | ------- | ------- | -----------
total | INT | Total number of data
count | INT | Number of data displayed
per_page | INT | Number of displayed data per page
current_page | INT | Current page number
total_pages | INT | Total pages

> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/v1/sms/log?start=2018-10-01&end=2020-10-30&page=1&rows=15" \
    -H "Accept: application/json" \
    -H "Accept-Language: zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2" \
    -H "X-Timezone: Asia/Taipei" \
    -H "Authorization: Bearer {access_token}"
```

```javascript
const url = new URL(
    "http://localhost/api/v1/sms/log"
);

let params = {
    "start": "2018-10-01",
    "end": "2020-10-30",
    "page": "1",
    "rows": "15",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Accept": "application/json",
    "Accept-Language": "zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2",
    "X-Timezone": "Asia/Taipei",
    "Authorization": "Bearer {access_token}",
    "Content-Type": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'http://localhost/api/v1/sms/log',
    [
        'headers' => [
            'Accept' => 'application/json',
            'Accept-Language' => 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
            'X-Timezone' => 'Asia/Taipei',
            'Authorization' => 'Bearer {access_token}',
        ],
        'query' => [
            'start'=> '2018-10-01',
            'end'=> '2020-10-30',
            'page'=> '1',
            'rows'=> '15',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://localhost/api/v1/sms/log'
params = {
  'start': '2018-10-01',
  'end': '2020-10-30',
  'page': '1',
  'rows': '15',
}
headers = {
  'Accept': 'application/json',
  'Accept-Language': 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
  'X-Timezone': 'Asia/Taipei',
  'Authorization': 'Bearer {access_token}'
}
response = requests.request('GET', url, headers=headers, params=params)
response.json()
```


> Example response (200):

```json
{
    "success": true,
    "data": [
        {
            "serial": "120201118",
            "source_id": "1294583",
            "source": "system",
            "source_name": "System",
            "telecomer": "mexmo",
            "telecomer_name": "Mexmo Telecomer",
            "phone": "+886930684635",
            "message": {
                "message": "Authcode: 58496",
                "subject": "Auth Code"
            },
            "result": {
                "message-id": "0C000000217B7F02",
                "remaining-balance": "15.53590000",
                "message-price": "0.03330000",
                "status": "0"
            },
            "operate": "success",
            "created_at": "2020-11-18 10:57:20",
            "updated_at": "2020-11-18 10:57:20"
        },
        {
            "serial": "220201118",
            "source_id": "1294583",
            "source": "system",
            "source_name": "System",
            "telecomer": "mexmo",
            "telecomer_name": "Mexmo Telecomer",
            "phone": "+886930877633",
            "message": {
                "message": "Authcode: 35745",
                "subject": "Auth Code"
            },
            "result": {
                "message-id": "0C000000217B7F10",
                "remaining-balance": "15.50260000",
                "message-price": "0.03330000",
                "status": "0"
            },
            "operate": "success",
            "created_at": "2020-11-18 10:57:30",
            "updated_at": "2020-11-18 10:57:30"
        }
    ],
    "meta": {
        "pagination": {
            "total": 2,
            "count": 2,
            "per_page": 15,
            "current_page": 1,
            "total_pages": 1
        }
    }
}
```

### HTTP Request
`GET api/v1/sms/log`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `start` |  optional  | Start range of query creation date
    `end` |  optional  | End range of query creation date
    `page` |  required  | Page number
    `rows` |  optional  | Per page rows defaults to 15

<!-- END_732439d5d924dc672dc350b0cd2c6531 -->

<!-- START_5a966e0a01ae4d1abfb64b6df679ba31 -->
## SMS Record Serial Info

Get the SMS sending serial info.

### Response Body

success : true

data :

Parameter | Type | Description
--------- | ------- | ------- | -----------
serial | STR | SMS record serial id
source_id | STR | SMS operate source id
source | STR | SMS operate source type code
source_name | STR | SMS operate source type name
telecomer | STR | SMS telecomer type code
telecomer_name | STR | SMS telecomer type name
phone | STR | SMS to phone number
message.message | STR | SMS message
message.subject | STR | SMS subject
result | OBJ | SMS response result message
operate | STR | SMS operate type ( success, failure )
created_at | STR | Datetime when the SMS was sent
updated_at | STR | Datetime when the log was updated

> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/v1/sms/log/120201118" \
    -H "Accept: application/json" \
    -H "Accept-Language: zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2" \
    -H "X-Timezone: Asia/Taipei" \
    -H "Authorization: Bearer {access_token}"
```

```javascript
const url = new URL(
    "http://localhost/api/v1/sms/log/120201118"
);

let headers = {
    "Accept": "application/json",
    "Accept-Language": "zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2",
    "X-Timezone": "Asia/Taipei",
    "Authorization": "Bearer {access_token}",
    "Content-Type": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'http://localhost/api/v1/sms/log/120201118',
    [
        'headers' => [
            'Accept' => 'application/json',
            'Accept-Language' => 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
            'X-Timezone' => 'Asia/Taipei',
            'Authorization' => 'Bearer {access_token}',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://localhost/api/v1/sms/log/120201118'
headers = {
  'Accept': 'application/json',
  'Accept-Language': 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
  'X-Timezone': 'Asia/Taipei',
  'Authorization': 'Bearer {access_token}'
}
response = requests.request('GET', url, headers=headers)
response.json()
```


> Example response (200):

```json
{
    "success": true,
    "data": {
        "serial": "120201118",
        "source_id": "1294583",
        "source": "system",
        "source_name": "System",
        "telecomer": "mexmo",
        "telecomer_name": "Mexmo Telecomer",
        "phone": "+886930684635",
        "message": {
            "message": "Authcode: 58496",
            "subject": "Auth Code"
        },
        "result": {
            "message-id": "0C000000217B7F02",
            "remaining-balance": "15.53590000",
            "message-price": "0.03330000",
            "status": "0"
        },
        "operate": "success",
        "created_at": "2020-11-18 10:57:20",
        "updated_at": "2020-11-18 10:57:20"
    }
}
```

### HTTP Request
`GET api/v1/sms/log/{serial}`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `serial` |  required  | SMS record serial id

<!-- END_5a966e0a01ae4d1abfb64b6df679ba31 -->

#Support API Interface


<!-- START_2f8186a709e64de985791fb2a8d22755 -->
## APIs

Get a list of all API interfaces.

### Response Body

success : true

data :

Parameter | Type | Description
--------- | ------- | ------- | -----------
code | STR | Interface code
interface | STR | Interface uri
description | STR | Interface about description

> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/v1/system/interface" \
    -H "Accept: application/json" \
    -H "Accept-Language: zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2" \
    -H "X-Timezone: Asia/Taipei" \
    -H "Authorization: Bearer {access_token}"
```

```javascript
const url = new URL(
    "http://localhost/api/v1/system/interface"
);

let headers = {
    "Accept": "application/json",
    "Accept-Language": "zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2",
    "X-Timezone": "Asia/Taipei",
    "Authorization": "Bearer {access_token}",
    "Content-Type": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'http://localhost/api/v1/system/interface',
    [
        'headers' => [
            'Accept' => 'application/json',
            'Accept-Language' => 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
            'X-Timezone' => 'Asia/Taipei',
            'Authorization' => 'Bearer {access_token}',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://localhost/api/v1/system/interface'
headers = {
  'Accept': 'application/json',
  'Accept-Language': 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
  'X-Timezone': 'Asia/Taipei',
  'Authorization': 'Bearer {access_token}'
}
response = requests.request('GET', url, headers=headers)
response.json()
```


> Example response (200):

```json
{
    "success": true,
    "data": [
        {
            "code": "auth.token.create",
            "interface": "api\/v1\/auth\/token",
            "description": "Login Client Service"
        },
        {
            "code": "auth.token.refresh",
            "interface": "api\/v1\/auth\/token\/refresh",
            "description": "Refresh Access Token"
        },
        {
            "code": "auth.token.revoke",
            "interface": "api\/v1\/auth\/token\/revoke",
            "description": "Revoke Access Token"
        },
        {
            "code": "auth.user.logout",
            "interface": "api\/v1\/auth\/logout",
            "description": "User Logout"
        },
        {
            "code": "auth.read.service",
            "interface": "api\/v1\/auth\/service",
            "description": "Read Own Service Info"
        },
        {
            "code": "auth.client.index",
            "interface": "api\/v1\/auth\/client",
            "description": "Client Service Index"
        },
        {
            "code": "auth.client.read",
            "interface": "api\/v1\/auth\/client\/{app_id}",
            "description": "Search Client Service Info"
        }
    ]
}
```

### HTTP Request
`GET api/v1/system/interface`


<!-- END_2f8186a709e64de985791fb2a8d22755 -->

<!-- START_9590974ae3375ddcc7dd4436df7f2f81 -->
## Managed APIs

Get a list of managed API interfaces.

### Response Body

success : true

data :

Parameter | Type | Description
--------- | ------- | ------- | -----------
code | STR | Interface code
interface | STR | Interface uri
description | STR | Interface about description

> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/v1/system/interface/managed" \
    -H "Accept: application/json" \
    -H "Accept-Language: zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2" \
    -H "X-Timezone: Asia/Taipei" \
    -H "Authorization: Bearer {access_token}"
```

```javascript
const url = new URL(
    "http://localhost/api/v1/system/interface/managed"
);

let headers = {
    "Accept": "application/json",
    "Accept-Language": "zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2",
    "X-Timezone": "Asia/Taipei",
    "Authorization": "Bearer {access_token}",
    "Content-Type": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'http://localhost/api/v1/system/interface/managed',
    [
        'headers' => [
            'Accept' => 'application/json',
            'Accept-Language' => 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
            'X-Timezone' => 'Asia/Taipei',
            'Authorization' => 'Bearer {access_token}',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://localhost/api/v1/system/interface/managed'
headers = {
  'Accept': 'application/json',
  'Accept-Language': 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
  'X-Timezone': 'Asia/Taipei',
  'Authorization': 'Bearer {access_token}'
}
response = requests.request('GET', url, headers=headers)
response.json()
```


> Example response (200):

```json
{
    "success": true,
    "data": [
        {
            "code": "auth.client.index",
            "interface": "api\/v1\/auth\/client",
            "description": "Client Service Index"
        },
        {
            "code": "auth.client.read",
            "interface": "api\/v1\/auth\/client\/{app_id}",
            "description": "Search Client Service Info"
        }
    ]
}
```

### HTTP Request
`GET api/v1/system/interface/managed`


<!-- END_9590974ae3375ddcc7dd4436df7f2f81 -->

<!-- START_fa21e5e4c0aba28e390b21e2faff1556 -->
## Managed APIs By Ban

Get a list of managed API interfaces by ban number.

### Response Body

success : true

data :

Parameter | Type | Description
--------- | ------- | ------- | -----------
code | STR | Interface code
interface | STR | Interface uri
description | STR | Interface about description

> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/v1/system/interface/managed/ban/1" \
    -H "Accept: application/json" \
    -H "Accept-Language: zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2" \
    -H "X-Timezone: Asia/Taipei" \
    -H "Authorization: Bearer {access_token}"
```

```javascript
const url = new URL(
    "http://localhost/api/v1/system/interface/managed/ban/1"
);

let headers = {
    "Accept": "application/json",
    "Accept-Language": "zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2",
    "X-Timezone": "Asia/Taipei",
    "Authorization": "Bearer {access_token}",
    "Content-Type": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'http://localhost/api/v1/system/interface/managed/ban/1',
    [
        'headers' => [
            'Accept' => 'application/json',
            'Accept-Language' => 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
            'X-Timezone' => 'Asia/Taipei',
            'Authorization' => 'Bearer {access_token}',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://localhost/api/v1/system/interface/managed/ban/1'
headers = {
  'Accept': 'application/json',
  'Accept-Language': 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
  'X-Timezone': 'Asia/Taipei',
  'Authorization': 'Bearer {access_token}'
}
response = requests.request('GET', url, headers=headers)
response.json()
```


> Example response (200):

```json
{
    "success": true,
    "data": [
        {
            "code": "auth.client.index",
            "interface": "api\/v1\/auth\/client",
            "description": "Client Service Index"
        }
    ]
}
```

### HTTP Request
`GET api/v1/system/interface/managed/ban/{number}`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `number` |  required  | Ban number

<!-- END_fa21e5e4c0aba28e390b21e2faff1556 -->

#Support Language


<!-- START_3b33f12749213e1b3333db4f1fd9170d -->
## Language Index

Get the language index.

### Response Body

success : true

data :

Parameter | Type | Description
--------- | ------- | ------- | -----------
language | STR | Language code
description | STR | Language about description

> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/v1/system/language" \
    -H "Accept: application/json" \
    -H "Accept-Language: zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2" \
    -H "X-Timezone: Asia/Taipei" \
    -H "Authorization: Bearer {access_token}"
```

```javascript
const url = new URL(
    "http://localhost/api/v1/system/language"
);

let headers = {
    "Accept": "application/json",
    "Accept-Language": "zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2",
    "X-Timezone": "Asia/Taipei",
    "Authorization": "Bearer {access_token}",
    "Content-Type": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'http://localhost/api/v1/system/language',
    [
        'headers' => [
            'Accept' => 'application/json',
            'Accept-Language' => 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
            'X-Timezone' => 'Asia/Taipei',
            'Authorization' => 'Bearer {access_token}',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://localhost/api/v1/system/language'
headers = {
  'Accept': 'application/json',
  'Accept-Language': 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
  'X-Timezone': 'Asia/Taipei',
  'Authorization': 'Bearer {access_token}'
}
response = requests.request('GET', url, headers=headers)
response.json()
```


> Example response (200):

```json
{
    "success": true,
    "data": [
        {
            "language": "en",
            "description": "English"
        },
        {
            "language": "zh-TW",
            "description": "繁體中文"
        }
    ]
}
```

### HTTP Request
`GET api/v1/system/language`


<!-- END_3b33f12749213e1b3333db4f1fd9170d -->

<!-- START_bebcb8f4fbeb05baaa755a4ed520a0c7 -->
## Default Language

Get the default language.

### Response Body

success : true

data :

Parameter | Type | Description
--------- | ------- | ------- | -----------
language | STR | Language code
description | STR | Language about description

> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/v1/system/language/default" \
    -H "Accept: application/json" \
    -H "Accept-Language: zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2" \
    -H "X-Timezone: Asia/Taipei" \
    -H "Authorization: Bearer {access_token}"
```

```javascript
const url = new URL(
    "http://localhost/api/v1/system/language/default"
);

let headers = {
    "Accept": "application/json",
    "Accept-Language": "zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2",
    "X-Timezone": "Asia/Taipei",
    "Authorization": "Bearer {access_token}",
    "Content-Type": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'http://localhost/api/v1/system/language/default',
    [
        'headers' => [
            'Accept' => 'application/json',
            'Accept-Language' => 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
            'X-Timezone' => 'Asia/Taipei',
            'Authorization' => 'Bearer {access_token}',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://localhost/api/v1/system/language/default'
headers = {
  'Accept': 'application/json',
  'Accept-Language': 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
  'X-Timezone': 'Asia/Taipei',
  'Authorization': 'Bearer {access_token}'
}
response = requests.request('GET', url, headers=headers)
response.json()
```


> Example response (200):

```json
{
    "success": true,
    "data": {
        "language": "en",
        "description": "English"
    }
}
```

### HTTP Request
`GET api/v1/system/language/default`


<!-- END_bebcb8f4fbeb05baaa755a4ed520a0c7 -->

#System Parameters


<!-- START_23171f241d6d390e3410bfe6a0981615 -->
## Rewrite Parameter Value

Rewrite the parameter value.

### Response Body

success : true

> Example request:

```bash
curl -X PATCH \
    "http://localhost/api/v1/system/parameter/status" \
    -H "Content-Type: application/x-www-form-urlencoded" \
    -H "Accept: application/json" \
    -H "Accept-Language: zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2" \
    -H "X-Timezone: Asia/Taipei" \
    -H "Authorization: Bearer {access_token}"
```

```javascript
const url = new URL(
    "http://localhost/api/v1/system/parameter/status"
);

let headers = {
    "Content-Type": "application/x-www-form-urlencoded",
    "Accept": "application/json",
    "Accept-Language": "zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2",
    "X-Timezone": "Asia/Taipei",
    "Authorization": "Bearer {access_token}",
};

fetch(url, {
    method: "PATCH",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->patch(
    'http://localhost/api/v1/system/parameter/status',
    [
        'headers' => [
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Accept' => 'application/json',
            'Accept-Language' => 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
            'X-Timezone' => 'Asia/Taipei',
            'Authorization' => 'Bearer {access_token}',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://localhost/api/v1/system/parameter/status'
headers = {
  'Content-Type': 'application/x-www-form-urlencoded',
  'Accept': 'application/json',
  'Accept-Language': 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
  'X-Timezone': 'Asia/Taipei',
  'Authorization': 'Bearer {access_token}'
}
response = requests.request('PATCH', url, headers=headers)
response.json()
```


> Example response (200):

```json
{
    "success": true
}
```

### HTTP Request
`PATCH api/v1/system/parameter/{slug}`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `slug` |  required  | Parameter key name

<!-- END_23171f241d6d390e3410bfe6a0981615 -->

<!-- START_539935877c78f1175fb1a70c68af3b40 -->
## Parameter Index

Get the parameter index.

### Response Body

success : true

data :

Parameter | Type | Description
--------- | ------- | ------- | -----------
slug | STR | Parameter key name
value | STR | Parameter value
rule.description | STR | Parameter value description
rule.type | STR | Parameter value type
description | STR | Parameter about description
created_at | STR | Datetime when the parameter was created
updated_at | STR | Parameter last updated datetime

meta.pagination :

Parameter | Type | Description
--------- | ------- | ------- | -----------
total | INT | Total number of data
count | INT | Number of data displayed
per_page | INT | Number of displayed data per page
current_page | INT | Current page number
total_pages | INT | Total pages

> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/v1/system/parameter?page=1&rows=15" \
    -H "Accept: application/json" \
    -H "Accept-Language: zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2" \
    -H "X-Timezone: Asia/Taipei" \
    -H "Authorization: Bearer {access_token}"
```

```javascript
const url = new URL(
    "http://localhost/api/v1/system/parameter"
);

let params = {
    "page": "1",
    "rows": "15",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Accept": "application/json",
    "Accept-Language": "zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2",
    "X-Timezone": "Asia/Taipei",
    "Authorization": "Bearer {access_token}",
    "Content-Type": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'http://localhost/api/v1/system/parameter',
    [
        'headers' => [
            'Accept' => 'application/json',
            'Accept-Language' => 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
            'X-Timezone' => 'Asia/Taipei',
            'Authorization' => 'Bearer {access_token}',
        ],
        'query' => [
            'page'=> '1',
            'rows'=> '15',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://localhost/api/v1/system/parameter'
params = {
  'page': '1',
  'rows': '15',
}
headers = {
  'Accept': 'application/json',
  'Accept-Language': 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
  'X-Timezone': 'Asia/Taipei',
  'Authorization': 'Bearer {access_token}'
}
response = requests.request('GET', url, headers=headers, params=params)
response.json()
```


> Example response (200):

```json
{
    "success": true,
    "data": [
        {
            "slug": "status",
            "value": "1",
            "rule": {
                "description": "Define values 0 ~ 1",
                "type": "integer"
            },
            "description": "System Status",
            "created_at": "2018-10-28 17:53:06",
            "updated_at": "2018-11-28 17:53:06"
        }
    ],
    "meta": {
        "pagination": {
            "total": 1,
            "count": 1,
            "per_page": 15,
            "current_page": 1,
            "total_pages": 1
        }
    }
}
```

### HTTP Request
`GET api/v1/system/parameter`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `page` |  required  | Page number
    `rows` |  optional  | Per page rows defaults to 15

<!-- END_539935877c78f1175fb1a70c68af3b40 -->

<!-- START_9e89de3e705345bd9134a8c625532693 -->
## Parameter Info

Get the parameter info.

### Response Body

success : true

data :

Parameter | Type | Description
--------- | ------- | ------- | -----------
slug | STR | Parameter key name
value | STR | Parameter value
rule.description | STR | Parameter value description
rule.type | STR | Parameter value type
description | STR | Parameter about description
created_at | STR | Datetime when the parameter was created
updated_at | STR | Parameter last updated datetime

> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/v1/system/parameter/status" \
    -H "Accept: application/json" \
    -H "Accept-Language: zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2" \
    -H "X-Timezone: Asia/Taipei" \
    -H "Authorization: Bearer {access_token}"
```

```javascript
const url = new URL(
    "http://localhost/api/v1/system/parameter/status"
);

let headers = {
    "Accept": "application/json",
    "Accept-Language": "zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2",
    "X-Timezone": "Asia/Taipei",
    "Authorization": "Bearer {access_token}",
    "Content-Type": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'http://localhost/api/v1/system/parameter/status',
    [
        'headers' => [
            'Accept' => 'application/json',
            'Accept-Language' => 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
            'X-Timezone' => 'Asia/Taipei',
            'Authorization' => 'Bearer {access_token}',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://localhost/api/v1/system/parameter/status'
headers = {
  'Accept': 'application/json',
  'Accept-Language': 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
  'X-Timezone': 'Asia/Taipei',
  'Authorization': 'Bearer {access_token}'
}
response = requests.request('GET', url, headers=headers)
response.json()
```


> Example response (200):

```json
{
    "success": true,
    "data": {
        "slug": "status",
        "value": "1",
        "rule": {
            "description": "Define values 0 ~ 1",
            "type": "integer"
        },
        "description": "System Status",
        "created_at": "2018-10-28 17:53:06",
        "updated_at": "2018-11-28 17:53:06"
    }
}
```

### HTTP Request
`GET api/v1/system/parameter/{slug}`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `slug` |  required  | Parameter key name

<!-- END_9e89de3e705345bd9134a8c625532693 -->

#User Notify


<!-- START_649347262cba35069045e3a1a0d3ae4c -->
## My Notify Messages

Get the messages of the user notification.

### Response Body

success : true

data :

Parameter | Type | Description
--------- | ------- | ------- | -----------
id | STR | Notice serial id
notice.subject | OBJ | Notice message subject
notice.content | OBJ | Notice message content object
notice.type | STR | Notice message type code
notice.type_name | STR | Notice message type name
read_at | STR | Datetime when the notice was read
created_at | STR | Datetime when the notice was created

> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/v1/notice" \
    -H "Accept: application/json" \
    -H "Accept-Language: zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2" \
    -H "X-Timezone: Asia/Taipei" \
    -H "Authorization: Bearer {access_token}"
```

```javascript
const url = new URL(
    "http://localhost/api/v1/notice"
);

let headers = {
    "Accept": "application/json",
    "Accept-Language": "zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2",
    "X-Timezone": "Asia/Taipei",
    "Authorization": "Bearer {access_token}",
    "Content-Type": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'http://localhost/api/v1/notice',
    [
        'headers' => [
            'Accept' => 'application/json',
            'Accept-Language' => 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
            'X-Timezone' => 'Asia/Taipei',
            'Authorization' => 'Bearer {access_token}',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://localhost/api/v1/notice'
headers = {
  'Accept': 'application/json',
  'Accept-Language': 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
  'X-Timezone': 'Asia/Taipei',
  'Authorization': 'Bearer {access_token}'
}
response = requests.request('GET', url, headers=headers)
response.json()
```


> Example response (200):

```json
{
    "success": true,
    "data": [
        {
            "id": "ddc09c60-8385-4e64-8516-6ba3f6fd6a64",
            "notice": {
                "subject": "Test",
                "content": {
                    "message": "Test message"
                },
                "type": "none",
                "type_name": "Notice"
            },
            "read_at": "2020-04-16 11:04:19",
            "created_at": "2020-04-15 14:02:47"
        }
    ]
}
```

### HTTP Request
`GET api/v1/notice`


<!-- END_649347262cba35069045e3a1a0d3ae4c -->

<!-- START_fde37eddda385e6ee7a582ef3cea7af1 -->
## My Unread Notify Messages

Get the messages of the user unread notification.

### Response Body

success : true

data :

Parameter | Type | Description
--------- | ------- | ------- | -----------
id | STR | Notice serial id
notice.subject | OBJ | Notice message subject
notice.content | OBJ | Notice message content object
notice.type | STR | Notice message type code
notice.type_name | STR | Notice message type name
read_at | STR | Datetime when the notice was read
created_at | STR | Datetime when the notice was created

> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/v1/notice/unread" \
    -H "Accept: application/json" \
    -H "Accept-Language: zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2" \
    -H "X-Timezone: Asia/Taipei" \
    -H "Authorization: Bearer {access_token}"
```

```javascript
const url = new URL(
    "http://localhost/api/v1/notice/unread"
);

let headers = {
    "Accept": "application/json",
    "Accept-Language": "zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2",
    "X-Timezone": "Asia/Taipei",
    "Authorization": "Bearer {access_token}",
    "Content-Type": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'http://localhost/api/v1/notice/unread',
    [
        'headers' => [
            'Accept' => 'application/json',
            'Accept-Language' => 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
            'X-Timezone' => 'Asia/Taipei',
            'Authorization' => 'Bearer {access_token}',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://localhost/api/v1/notice/unread'
headers = {
  'Accept': 'application/json',
  'Accept-Language': 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
  'X-Timezone': 'Asia/Taipei',
  'Authorization': 'Bearer {access_token}'
}
response = requests.request('GET', url, headers=headers)
response.json()
```


> Example response (200):

```json
{
    "success": true,
    "data": [
        {
            "id": "ddc09c60-8385-4e64-8516-6ba3f6fd6a64",
            "notice": {
                "subject": "Test",
                "content": {
                    "message": "Test message"
                },
                "type": "none",
                "type_name": "Notice"
            },
            "read_at": "2020-04-16 11:04:19",
            "created_at": "2020-04-15 14:02:47"
        }
    ]
}
```

### HTTP Request
`GET api/v1/notice/unread`


<!-- END_fde37eddda385e6ee7a582ef3cea7af1 -->

<!-- START_16dd607a882f3cd47fd63438e19600ae -->
## My Unread Notify Counts

Get the counts of the user unread notification.

### Response Body

success : true

data :

Parameter | Type | Description
--------- | ------- | ------- | -----------
count | INT | Unread count

> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/v1/notice/count" \
    -H "Accept: application/json" \
    -H "Accept-Language: zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2" \
    -H "X-Timezone: Asia/Taipei" \
    -H "Authorization: Bearer {access_token}"
```

```javascript
const url = new URL(
    "http://localhost/api/v1/notice/count"
);

let headers = {
    "Accept": "application/json",
    "Accept-Language": "zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2",
    "X-Timezone": "Asia/Taipei",
    "Authorization": "Bearer {access_token}",
    "Content-Type": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'http://localhost/api/v1/notice/count',
    [
        'headers' => [
            'Accept' => 'application/json',
            'Accept-Language' => 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
            'X-Timezone' => 'Asia/Taipei',
            'Authorization' => 'Bearer {access_token}',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://localhost/api/v1/notice/count'
headers = {
  'Accept': 'application/json',
  'Accept-Language': 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
  'X-Timezone': 'Asia/Taipei',
  'Authorization': 'Bearer {access_token}'
}
response = requests.request('GET', url, headers=headers)
response.json()
```


> Example response (200):

```json
{
    "success": true,
    "data": {
        "count": 1
    }
}
```

### HTTP Request
`GET api/v1/notice/count`


<!-- END_16dd607a882f3cd47fd63438e19600ae -->

<!-- START_66d36a88f2c09a3365595484b0c4d053 -->
## Remove My Read

Remove read notification messages of the user.

### Response Body

success : true

> Example request:

```bash
curl -X DELETE \
    "http://localhost/api/v1/notice/ddc09c60-8385-4e64-8516-6ba3f6fd6a84" \
    -H "Accept: application/json" \
    -H "Accept-Language: zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2" \
    -H "X-Timezone: Asia/Taipei" \
    -H "Authorization: Bearer {access_token}"
```

```javascript
const url = new URL(
    "http://localhost/api/v1/notice/ddc09c60-8385-4e64-8516-6ba3f6fd6a84"
);

let headers = {
    "Accept": "application/json",
    "Accept-Language": "zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2",
    "X-Timezone": "Asia/Taipei",
    "Authorization": "Bearer {access_token}",
    "Content-Type": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->delete(
    'http://localhost/api/v1/notice/ddc09c60-8385-4e64-8516-6ba3f6fd6a84',
    [
        'headers' => [
            'Accept' => 'application/json',
            'Accept-Language' => 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
            'X-Timezone' => 'Asia/Taipei',
            'Authorization' => 'Bearer {access_token}',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://localhost/api/v1/notice/ddc09c60-8385-4e64-8516-6ba3f6fd6a84'
headers = {
  'Accept': 'application/json',
  'Accept-Language': 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
  'X-Timezone': 'Asia/Taipei',
  'Authorization': 'Bearer {access_token}'
}
response = requests.request('DELETE', url, headers=headers)
response.json()
```


> Example response (200):

```json
{
    "success": true
}
```

### HTTP Request
`DELETE api/v1/notice/{id}`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `id` |  required  | Notice serial id

<!-- END_66d36a88f2c09a3365595484b0c4d053 -->

<!-- START_72bef1ddf848d05e292950ad1dc5c9a1 -->
## Remove All My Read

Remove all read notification messages of the user.

### Response Body

success : true

> Example request:

```bash
curl -X DELETE \
    "http://localhost/api/v1/notice/all" \
    -H "Accept: application/json" \
    -H "Accept-Language: zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2" \
    -H "X-Timezone: Asia/Taipei" \
    -H "Authorization: Bearer {access_token}"
```

```javascript
const url = new URL(
    "http://localhost/api/v1/notice/all"
);

let headers = {
    "Accept": "application/json",
    "Accept-Language": "zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2",
    "X-Timezone": "Asia/Taipei",
    "Authorization": "Bearer {access_token}",
    "Content-Type": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->delete(
    'http://localhost/api/v1/notice/all',
    [
        'headers' => [
            'Accept' => 'application/json',
            'Accept-Language' => 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
            'X-Timezone' => 'Asia/Taipei',
            'Authorization' => 'Bearer {access_token}',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://localhost/api/v1/notice/all'
headers = {
  'Accept': 'application/json',
  'Accept-Language': 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
  'X-Timezone': 'Asia/Taipei',
  'Authorization': 'Bearer {access_token}'
}
response = requests.request('DELETE', url, headers=headers)
response.json()
```


> Example response (200):

```json
{
    "success": true
}
```

### HTTP Request
`DELETE api/v1/notice/all`


<!-- END_72bef1ddf848d05e292950ad1dc5c9a1 -->


# Declaration

This document is written by the development team. 

If you have any questions, please ask the relevant person.

<aside style="color:#FFFFFF">
© PROVIDER. ALL RIGHTS RESERVED.
</aside>
