<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>API Reference</title>

    <link rel="stylesheet" href="docs/css/style.css" />
    <script src="docs/js/all.js"></script>


          <script>
        $(function() {
            setupLanguages(["bash","javascript","php","python"]);
        });
      </script>
      </head>

  <body class="">
    <a href="#" id="nav-button">
      <span>
        NAV
        <img src="docs/images/navbar.png" />
      </span>
    </a>
    <div class="tocify-wrapper">
        <img src="docs/images/logo.png" />
                    <div class="lang-selector">
                                  <a href="#" data-language-name="bash">bash</a>
                                  <a href="#" data-language-name="javascript">javascript</a>
                                  <a href="#" data-language-name="php">php</a>
                                  <a href="#" data-language-name="python">python</a>
                            </div>
                            <div class="search">
              <input type="text" class="search" id="input-search" placeholder="Search">
            </div>
            <ul class="search-results"></ul>
              <div id="toc">
      </div>
                    <ul class="toc-footer">
                                  <li><a href='#'>Top</a></li>
                            </ul>
            </div>
    <div class="page-wrapper">
      <div class="dark-box"></div>
      <div class="content">
          <!-- START_INFO -->
<h1>Info</h1>
<p>Welcome to the API reference documentation.</p>
<p>API documentation is for developers to use.</p>
<!-- END_INFO -->
<h2>Authorization</h2>
<p>You must register your service with provider, and provider will provide you with the information client_id and client_secrect required for login.</p>
<h2>Verification</h2>
<p>Service authorization verification uses a JWT authentication token.</p>
<h3>Note :</h3>
<aside class="warning" style="color:#FFFFFF" >
When the access token expires, if you continue to call the service API, the request will automatically refresh the access token contained in the header authorization and return a new access token to you.
</aside>
<h2>Error</h2>
<p>When the request APIs fails, respond to related error messages.</p>
<h3>Response Body</h3>
<p>success : false</p>
<p>error :</p>
<table>
<thead>
<tr>
<th>Parameter</th>
<th>Type</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td>status</td>
<td>INT</td>
<td>Http status code</td>
</tr>
<tr>
<td>code</td>
<td>INT</td>
<td>Error code</td>
</tr>
<tr>
<td>message</td>
<td>STR</td>
<td>Error message</td>
</tr>
<tr>
<td>description</td>
<td>OBJ</td>
<td>Other error descriptions</td>
</tr>
</tbody>
</table>
<h1>Activity Log</h1>
<!-- START_de44251051971e0a9942942f1741060a -->
<h2>Activity Log Types</h2>
<p>Get a list of log types for system activity.</p>
<h3>Response Body</h3>
<p>success : true</p>
<p>data :</p>
<table>
<thead>
<tr>
<th>Parameter</th>
<th>Type</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td>type</td>
<td>STR</td>
<td>Log type code</td>
</tr>
<tr>
<td>name</td>
<td>STR</td>
<td>Log type name</td>
</tr>
</tbody>
</table>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "http://localhost/api/v1/system/log/type" \
    -H "Accept: application/json" \
    -H "Accept-Language: zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2" \
    -H "X-Timezone: Asia/Taipei" \
    -H "Authorization: Bearer {access_token}"</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'http://localhost/api/v1/system/log/type',
    [
        'headers' =&gt; [
            'Accept' =&gt; 'application/json',
            'Accept-Language' =&gt; 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
            'X-Timezone' =&gt; 'Asia/Taipei',
            'Authorization' =&gt; 'Bearer {access_token}',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<pre><code class="language-python">import requests
import json

url = 'http://localhost/api/v1/system/log/type'
headers = {
  'Accept': 'application/json',
  'Accept-Language': 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
  'X-Timezone': 'Asia/Taipei',
  'Authorization': 'Bearer {access_token}'
}
response = requests.request('GET', url, headers=headers)
response.json()</code></pre>
<blockquote>
<p>Example response (200):</p>
</blockquote>
<pre><code class="language-json">{
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
}</code></pre>
<h3>HTTP Request</h3>
<p><code>GET api/v1/system/log/type</code></p>
<!-- END_de44251051971e0a9942942f1741060a -->
<!-- START_a1640eb011c86c73d626bc1d89d50014 -->
<h2>Activity Log Index</h2>
<p>Get the system activity log index.</p>
<h3>Response Body</h3>
<p>success : true</p>
<p>data :</p>
<table>
<thead>
<tr>
<th>Parameter</th>
<th>Type</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td>type</td>
<td>STR</td>
<td>Log type code</td>
</tr>
<tr>
<td>name</td>
<td>STR</td>
<td>Log type name</td>
</tr>
<tr>
<td>description</td>
<td>STR</td>
<td>Log operation description</td>
</tr>
<tr>
<td>target_id</td>
<td>STR</td>
<td>Target indicator id</td>
</tr>
<tr>
<td>target_name</td>
<td>STR</td>
<td>Target type name of model</td>
</tr>
<tr>
<td>trigger_id</td>
<td>STR</td>
<td>Trigger indicator id</td>
</tr>
<tr>
<td>trigger_name</td>
<td>STR</td>
<td>Trigger type name of model</td>
</tr>
<tr>
<td>properties</td>
<td>OBJ</td>
<td>Property content</td>
</tr>
<tr>
<td>created_at</td>
<td>STR</td>
<td>Datetime when the log was created</td>
</tr>
</tbody>
</table>
<p>meta.pagination :</p>
<table>
<thead>
<tr>
<th>Parameter</th>
<th>Type</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td>total</td>
<td>INT</td>
<td>Total number of data</td>
</tr>
<tr>
<td>count</td>
<td>INT</td>
<td>Number of data displayed</td>
</tr>
<tr>
<td>per_page</td>
<td>INT</td>
<td>Number of displayed data per page</td>
</tr>
<tr>
<td>current_page</td>
<td>INT</td>
<td>Current page number</td>
</tr>
<tr>
<td>total_pages</td>
<td>INT</td>
<td>Total pages</td>
</tr>
</tbody>
</table>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "http://localhost/api/v1/system/logs/default?start=2018-10-01&amp;end=2020-10-30&amp;page=1&amp;rows=15" \
    -H "Accept: application/json" \
    -H "Accept-Language: zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2" \
    -H "X-Timezone: Asia/Taipei" \
    -H "Authorization: Bearer {access_token}"</code></pre>
<pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/v1/system/logs/default"
);

let params = {
    "start": "2018-10-01",
    "end": "2020-10-30",
    "page": "1",
    "rows": "15",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'http://localhost/api/v1/system/logs/default',
    [
        'headers' =&gt; [
            'Accept' =&gt; 'application/json',
            'Accept-Language' =&gt; 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
            'X-Timezone' =&gt; 'Asia/Taipei',
            'Authorization' =&gt; 'Bearer {access_token}',
        ],
        'query' =&gt; [
            'start'=&gt; '2018-10-01',
            'end'=&gt; '2020-10-30',
            'page'=&gt; '1',
            'rows'=&gt; '15',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<pre><code class="language-python">import requests
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
response.json()</code></pre>
<blockquote>
<p>Example response (200):</p>
</blockquote>
<pre><code class="language-json">{
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
}</code></pre>
<h3>HTTP Request</h3>
<p><code>GET api/v1/system/logs/{type?}</code></p>
<h4>URL Parameters</h4>
<table>
<thead>
<tr>
<th>Parameter</th>
<th>Status</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td><code>type</code></td>
<td>optional</td>
<td>Log type code</td>
</tr>
</tbody>
</table>
<h4>Query Parameters</h4>
<table>
<thead>
<tr>
<th>Parameter</th>
<th>Status</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td><code>start</code></td>
<td>optional</td>
<td>Start range of query creation date</td>
</tr>
<tr>
<td><code>end</code></td>
<td>optional</td>
<td>End range of query creation date</td>
</tr>
<tr>
<td><code>page</code></td>
<td>required</td>
<td>Page number</td>
</tr>
<tr>
<td><code>rows</code></td>
<td>optional</td>
<td>Per page rows defaults to 15</td>
</tr>
</tbody>
</table>
<!-- END_a1640eb011c86c73d626bc1d89d50014 -->
<h1>Auth Token</h1>
<!-- START_f20788e5bb009bef0443c783c5049af6 -->
<h2>Get Access Token</h2>
<p>Login with client service to get the access token.</p>
<h3>Response Body</h3>
<p>success : true</p>
<p>data :</p>
<table>
<thead>
<tr>
<th>Parameter</th>
<th>Type</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td>access_token</td>
<td>STR</td>
<td>API access token</td>
</tr>
<tr>
<td>token_type</td>
<td>STR</td>
<td>API access token type</td>
</tr>
<tr>
<td>expires_in</td>
<td>INT</td>
<td>API access token valid seconds</td>
</tr>
</tbody>
</table>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X POST \
    "http://localhost/api/v1/auth/token" \
    -H "Content-Type: application/x-www-form-urlencoded" \
    -H "Accept: application/json" \
    -H "Accept-Language: zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2" \
    -H "X-Timezone: Asia/Taipei" \
    -d '{"client_id":"{client_id}","client_secret":"{client_secret}"}'
</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;post(
    'http://localhost/api/v1/auth/token',
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/x-www-form-urlencoded',
            'Accept' =&gt; 'application/json',
            'Accept-Language' =&gt; 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
            'X-Timezone' =&gt; 'Asia/Taipei',
        ],
        'form_params' =&gt; [
            'client_id' =&gt; '{client_id}',
            'client_secret' =&gt; '{client_secret}',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<pre><code class="language-python">import requests
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
response.json()</code></pre>
<blockquote>
<p>Example response (200):</p>
</blockquote>
<pre><code class="language-json">{
    "success": true,
    "data": {
        "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9sb2NhbGhvc3RcL2FwaVwvdjFcL2F1dGhcL3Rva2VuIiwiaWF0IjoxNTQzMjI2NzgzLCJleHAiOjE1NDMyMjY4NDMsIm5iZiI6MTU0MzIyNjc4MywianRpIjoiWnZYVk9Ib2JRRzhKSnZqUCIsInN1YiI6MX0.9ZwtS9G2FyEPypmYczvZWuqUykEtEX2foDpYEXuTurc",
        "token_type": "bearer",
        "expires_in": 3660
    }
}</code></pre>
<h3>HTTP Request</h3>
<p><code>POST api/v1/auth/token</code></p>
<h4>Body Parameters</h4>
<table>
<thead>
<tr>
<th>Parameter</th>
<th>Type</th>
<th>Status</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td><code>client_id</code></td>
<td>STR</td>
<td>required</td>
<td>Client id</td>
</tr>
<tr>
<td><code>client_secret</code></td>
<td>STR</td>
<td>required</td>
<td>Client secret</td>
</tr>
</tbody>
</table>
<!-- END_f20788e5bb009bef0443c783c5049af6 -->
<!-- START_68e63b8a0b5cc80072f757c903bae06f -->
<h2>Refresh Access Token</h2>
<p>Refresh the current access token.</p>
<h3>Response Body</h3>
<p>success : true</p>
<p>data :</p>
<table>
<thead>
<tr>
<th>Parameter</th>
<th>Type</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td>access_token</td>
<td>STR</td>
<td>API access token</td>
</tr>
<tr>
<td>token_type</td>
<td>STR</td>
<td>API access token type</td>
</tr>
<tr>
<td>expires_in</td>
<td>INT</td>
<td>API access token valid seconds</td>
</tr>
</tbody>
</table>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X PATCH \
    "http://localhost/api/v1/auth/token/refresh" \
    -H "Content-Type: application/x-www-form-urlencoded" \
    -H "Accept: application/json" \
    -H "Accept-Language: zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2" \
    -H "X-Timezone: Asia/Taipei" \
    -H "Authorization: Bearer {access_token}"</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;patch(
    'http://localhost/api/v1/auth/token/refresh',
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/x-www-form-urlencoded',
            'Accept' =&gt; 'application/json',
            'Accept-Language' =&gt; 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
            'X-Timezone' =&gt; 'Asia/Taipei',
            'Authorization' =&gt; 'Bearer {access_token}',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<pre><code class="language-python">import requests
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
response.json()</code></pre>
<blockquote>
<p>Example response (200):</p>
</blockquote>
<pre><code class="language-json">{
    "success": true,
    "data": {
        "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9sb2NhbGhvc3RcL2FwaVwvdjFcL2F1dGhcL3Rva2VuXC9yZWZyZXNoIiwiaWF0IjoxNTQzMjI2NzgzLCJleHAiOjE1NDMyMjY4NDMsIm5iZiI6MTU0MzIyNjc4MywianRpIjoiMzRMbUZ5a3hQUDR3eWg0SSIsInN1YiI6MX0.GcZ8vExcbjWRTPQ_kOlBUg3h32ph-4viXIugApqjsTA",
        "token_type": "bearer",
        "expires_in": 3660
    }
}</code></pre>
<h3>HTTP Request</h3>
<p><code>PATCH api/v1/auth/token/refresh</code></p>
<!-- END_68e63b8a0b5cc80072f757c903bae06f -->
<!-- START_bb25dd8e6f847f92794b7887a2cfdc1d -->
<h2>Revoke Access Token</h2>
<p>Revoke the current access token.</p>
<h3>Response Body</h3>
<p>success : true</p>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X DELETE \
    "http://localhost/api/v1/auth/token" \
    -H "Content-Type: application/x-www-form-urlencoded" \
    -H "Accept: application/json" \
    -H "Accept-Language: zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2" \
    -H "X-Timezone: Asia/Taipei" \
    -H "Authorization: Bearer {access_token}"</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;delete(
    'http://localhost/api/v1/auth/token',
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/x-www-form-urlencoded',
            'Accept' =&gt; 'application/json',
            'Accept-Language' =&gt; 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
            'X-Timezone' =&gt; 'Asia/Taipei',
            'Authorization' =&gt; 'Bearer {access_token}',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<pre><code class="language-python">import requests
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
response.json()</code></pre>
<blockquote>
<p>Example response (200):</p>
</blockquote>
<pre><code class="language-json">{
    "success": true
}</code></pre>
<h3>HTTP Request</h3>
<p><code>DELETE api/v1/auth/token</code></p>
<!-- END_bb25dd8e6f847f92794b7887a2cfdc1d -->
<!-- START_998817f1756c5ceba7368d2f0d1e977f -->
<h2>Login Identity</h2>
<p>Login with user credentials and return the user's identity access token.</p>
<h3>Response Body</h3>
<p>success : true</p>
<p>data :</p>
<table>
<thead>
<tr>
<th>Parameter</th>
<th>Type</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td>access_token</td>
<td>STR</td>
<td>API access token</td>
</tr>
<tr>
<td>token_type</td>
<td>STR</td>
<td>API access token type</td>
</tr>
<tr>
<td>expires_in</td>
<td>INT</td>
<td>API access token valid seconds</td>
</tr>
</tbody>
</table>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X POST \
    "http://localhost/api/v1/auth/user/login/admin" \
    -H "Content-Type: application/x-www-form-urlencoded" \
    -H "Accept: application/json" \
    -H "Accept-Language: zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2" \
    -H "X-Timezone: Asia/Taipei" \
    -H "Authorization: Bearer {access_token}" \
    -d '{"account":"{account}","password":"{password}"}'
</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;post(
    'http://localhost/api/v1/auth/user/login/admin',
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/x-www-form-urlencoded',
            'Accept' =&gt; 'application/json',
            'Accept-Language' =&gt; 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
            'X-Timezone' =&gt; 'Asia/Taipei',
            'Authorization' =&gt; 'Bearer {access_token}',
        ],
        'form_params' =&gt; [
            'account' =&gt; '{account}',
            'password' =&gt; '{password}',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<pre><code class="language-python">import requests
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
response.json()</code></pre>
<blockquote>
<p>Example response (200):</p>
</blockquote>
<pre><code class="language-json">{
    "success": true,
    "data": {
        "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ8.eyJpc6MiOiJodHRwOlwvXC8sb2NhbGhvc3RcL2FwaVwvdjFcL2F1dGhcL3Rva2VuXC9yZWZyZXNoIiwiaWF0IjoxNTQzMjI2NzgzLCJleHAiOjE1NDMyMjY4NDMsIm5iZiI6MTU0MzIyNjc4MywianRpIjoiMzRMbUZ5a3hQUDR3eWg0SSIsInN1YiI6MX0.GcZ8vExcbjWRTPQ_kOlBUg3h32ph-4viXIugApqjsTA",
        "token_type": "bearer",
        "expires_in": 3660
    }
}</code></pre>
<h3>HTTP Request</h3>
<p><code>POST api/v1/auth/user/login/{type}</code></p>
<h4>URL Parameters</h4>
<table>
<thead>
<tr>
<th>Parameter</th>
<th>Status</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td><code>type</code></td>
<td>required</td>
<td>User type code</td>
</tr>
</tbody>
</table>
<h4>Body Parameters</h4>
<table>
<thead>
<tr>
<th>Parameter</th>
<th>Type</th>
<th>Status</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td><code>account</code></td>
<td>STR</td>
<td>required</td>
<td>User account</td>
</tr>
<tr>
<td><code>password</code></td>
<td>STR</td>
<td>required</td>
<td>User password</td>
</tr>
</tbody>
</table>
<!-- END_998817f1756c5ceba7368d2f0d1e977f -->
<!-- START_3f94ccb69d3e756917f3a7c16856ab8c -->
<h2>Login Signature</h2>
<p>Login with user authorized signature code and return the user's identity access token.</p>
<h3>Response Body</h3>
<p>success : true</p>
<p>data :</p>
<table>
<thead>
<tr>
<th>Parameter</th>
<th>Type</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td>access_token</td>
<td>STR</td>
<td>API access token</td>
</tr>
<tr>
<td>token_type</td>
<td>STR</td>
<td>API access token type</td>
</tr>
<tr>
<td>expires_in</td>
<td>INT</td>
<td>API access token valid seconds</td>
</tr>
</tbody>
</table>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X POST \
    "http://localhost/api/v1/auth/user/signature/login" \
    -H "Content-Type: application/x-www-form-urlencoded" \
    -H "Accept: application/json" \
    -H "Accept-Language: zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2" \
    -H "X-Timezone: Asia/Taipei" \
    -H "Authorization: Bearer {access_token}" \
    -d '{"signature":"{signature}"}'
</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;post(
    'http://localhost/api/v1/auth/user/signature/login',
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/x-www-form-urlencoded',
            'Accept' =&gt; 'application/json',
            'Accept-Language' =&gt; 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
            'X-Timezone' =&gt; 'Asia/Taipei',
            'Authorization' =&gt; 'Bearer {access_token}',
        ],
        'form_params' =&gt; [
            'signature' =&gt; '{signature}',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<pre><code class="language-python">import requests
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
response.json()</code></pre>
<blockquote>
<p>Example response (200):</p>
</blockquote>
<pre><code class="language-json">{
    "success": true,
    "data": {
        "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ8.eyJpc6MiOiJodHRwOlwvXC8sb2NhbGhvc3RcL2FwaVwvdjFcL2F1dGhcL3Rva2VuXC9yZWZyZXNoIiwiaWF0IjoxNTQzMjI2NzgzLCJleHAiOjE1NDMyMjY4NDMsIm5iZiI6MTU0MzIyNjc4MywianRpIjoiMzRMbUZ5a3hQUDR3eWg0SSIsInN1YiI6MX0.GcZ8vExcbjWRTPQ_kOlBUg3h32ph-4viXIugApqjsTA",
        "token_type": "bearer",
        "expires_in": 3660
    }
}</code></pre>
<h3>HTTP Request</h3>
<p><code>POST api/v1/auth/user/signature/login</code></p>
<h4>Body Parameters</h4>
<table>
<thead>
<tr>
<th>Parameter</th>
<th>Type</th>
<th>Status</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td><code>signature</code></td>
<td>STR</td>
<td>required</td>
<td>User authorized signature code</td>
</tr>
</tbody>
</table>
<!-- END_3f94ccb69d3e756917f3a7c16856ab8c -->
<!-- START_b215a331b41c5b89eb535674f45d6d3b -->
<h2>Logout Identity</h2>
<p>Revoke the current user's identity access token and return client access token.</p>
<h3>Response Body</h3>
<p>success : true</p>
<p>data :</p>
<table>
<thead>
<tr>
<th>Parameter</th>
<th>Type</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td>access_token</td>
<td>STR</td>
<td>API access token</td>
</tr>
<tr>
<td>token_type</td>
<td>STR</td>
<td>API access token type</td>
</tr>
<tr>
<td>expires_in</td>
<td>INT</td>
<td>API access token valid seconds</td>
</tr>
</tbody>
</table>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X DELETE \
    "http://localhost/api/v1/auth/user/logout" \
    -H "Content-Type: application/x-www-form-urlencoded" \
    -H "Accept: application/json" \
    -H "Accept-Language: zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2" \
    -H "X-Timezone: Asia/Taipei" \
    -H "Authorization: Bearer {access_token}"</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;delete(
    'http://localhost/api/v1/auth/user/logout',
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/x-www-form-urlencoded',
            'Accept' =&gt; 'application/json',
            'Accept-Language' =&gt; 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
            'X-Timezone' =&gt; 'Asia/Taipei',
            'Authorization' =&gt; 'Bearer {access_token}',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<pre><code class="language-python">import requests
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
response.json()</code></pre>
<blockquote>
<p>Example response (200):</p>
</blockquote>
<pre><code class="language-json">{
    "success": true,
    "data": {
        "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ8.eyJpc3MiOiJodHRwOlwvXC8sb2NhbGhvc3RcL2FwaVwvdjFcL2F1dGhcL3Rva2VuXC9yZWZyZXNoIiwiaWF0IjoxNTQzMjI2NzgzLCJleHAiOjE1NDMyMjY4NDMsIm5iZiI6MTU0MzIyNjc4MywianRpIjoiMzRMbUZ5a3hQUDR3eWg0SSIsInN1YiI6MX0.GcZ8vExcbjWRTPQ_kOlBUg3h32ph-4viXIugApqjsTA",
        "token_type": "bearer",
        "expires_in": 3660
    }
}</code></pre>
<h3>HTTP Request</h3>
<p><code>DELETE api/v1/auth/user/logout</code></p>
<!-- END_b215a331b41c5b89eb535674f45d6d3b -->
<!-- START_4785e33720e3e17f3a15fbfccb507b8c -->
<h2>Authorization Signature</h2>
<p>Get the user code used for signature authorization login.</p>
<h3>Response Body</h3>
<p>success : true</p>
<p>data :</p>
<table>
<thead>
<tr>
<th>Parameter</th>
<th>Type</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td>signature</td>
<td>STR</td>
<td>Authorized signature code</td>
</tr>
<tr>
<td>expires_in</td>
<td>INT</td>
<td>Authorized signature code valid seconds</td>
</tr>
</tbody>
</table>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X POST \
    "http://localhost/api/v1/auth/user/signature" \
    -H "Content-Type: application/x-www-form-urlencoded" \
    -H "Accept: application/json" \
    -H "Accept-Language: zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2" \
    -H "X-Timezone: Asia/Taipei" \
    -H "Authorization: Bearer {access_token}"</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;post(
    'http://localhost/api/v1/auth/user/signature',
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/x-www-form-urlencoded',
            'Accept' =&gt; 'application/json',
            'Accept-Language' =&gt; 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
            'X-Timezone' =&gt; 'Asia/Taipei',
            'Authorization' =&gt; 'Bearer {access_token}',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<pre><code class="language-python">import requests
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
response.json()</code></pre>
<blockquote>
<p>Example response (200):</p>
</blockquote>
<pre><code class="language-json">{
    "success": true,
    "data": {
        "signature": "8466b336802941ac8df1bd3173bdeb8de1fabcec5fbb036f0c08c550a738b182abab2d07",
        "expires_in": 180
    }
}</code></pre>
<h3>HTTP Request</h3>
<p><code>POST api/v1/auth/user/signature</code></p>
<!-- END_4785e33720e3e17f3a15fbfccb507b8c -->
<!-- START_78f9296d6b3db0d9eef1c43efc8b0e58 -->
<h2>Show Service Profile</h2>
<p>Show the client service profile for the current access token.</p>
<h3>Response Body</h3>
<p>success : true</p>
<p>data :</p>
<table>
<thead>
<tr>
<th>Parameter</th>
<th>Type</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td>app_id</td>
<td>STR</td>
<td>Client serial id</td>
</tr>
<tr>
<td>name</td>
<td>STR</td>
<td>Client name</td>
</tr>
<tr>
<td>ban</td>
<td>INT</td>
<td>Client ban number</td>
</tr>
<tr>
<td>description</td>
<td>STR</td>
<td>Client ban description</td>
</tr>
<tr>
<td>created_at</td>
<td>STR</td>
<td>Datetime when the client was created</td>
</tr>
<tr>
<td>updated_at</td>
<td>STR</td>
<td>Client last updated datetime</td>
</tr>
</tbody>
</table>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "http://localhost/api/v1/auth/service" \
    -H "Accept: application/json" \
    -H "Accept-Language: zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2" \
    -H "X-Timezone: Asia/Taipei" \
    -H "Authorization: Bearer {access_token}"</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'http://localhost/api/v1/auth/service',
    [
        'headers' =&gt; [
            'Accept' =&gt; 'application/json',
            'Accept-Language' =&gt; 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
            'X-Timezone' =&gt; 'Asia/Taipei',
            'Authorization' =&gt; 'Bearer {access_token}',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<pre><code class="language-python">import requests
import json

url = 'http://localhost/api/v1/auth/service'
headers = {
  'Accept': 'application/json',
  'Accept-Language': 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
  'X-Timezone': 'Asia/Taipei',
  'Authorization': 'Bearer {access_token}'
}
response = requests.request('GET', url, headers=headers)
response.json()</code></pre>
<blockquote>
<p>Example response (200):</p>
</blockquote>
<pre><code class="language-json">{
    "success": true,
    "data": {
        "app_id": "6398211294583",
        "name": "admin",
        "ban": 0,
        "description": "Global Service",
        "created_at": "2018-11-26 11:41:32",
        "updated_at": "2018-11-26 11:41:32"
    }
}</code></pre>
<h3>HTTP Request</h3>
<p><code>GET api/v1/auth/service</code></p>
<!-- END_78f9296d6b3db0d9eef1c43efc8b0e58 -->
<!-- START_99bf69cde1e88c66c8ab6a145412c67f -->
<h2>Login Types</h2>
<p>Get a list of user types for login.</p>
<h3>Response Body</h3>
<p>success : true</p>
<p>data :</p>
<table>
<thead>
<tr>
<th>Parameter</th>
<th>Type</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td>type</td>
<td>STR</td>
<td>Type code</td>
</tr>
<tr>
<td>description</td>
<td>STR</td>
<td>Type about description</td>
</tr>
</tbody>
</table>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "http://localhost/api/v1/auth/user/type" \
    -H "Accept: application/json" \
    -H "Accept-Language: zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2" \
    -H "X-Timezone: Asia/Taipei" \
    -H "Authorization: Bearer {access_token}"</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'http://localhost/api/v1/auth/user/type',
    [
        'headers' =&gt; [
            'Accept' =&gt; 'application/json',
            'Accept-Language' =&gt; 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
            'X-Timezone' =&gt; 'Asia/Taipei',
            'Authorization' =&gt; 'Bearer {access_token}',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<pre><code class="language-python">import requests
import json

url = 'http://localhost/api/v1/auth/user/type'
headers = {
  'Accept': 'application/json',
  'Accept-Language': 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
  'X-Timezone': 'Asia/Taipei',
  'Authorization': 'Bearer {access_token}'
}
response = requests.request('GET', url, headers=headers)
response.json()</code></pre>
<blockquote>
<p>Example response (200):</p>
</blockquote>
<pre><code class="language-json">{
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
}</code></pre>
<h3>HTTP Request</h3>
<p><code>GET api/v1/auth/user/type</code></p>
<!-- END_99bf69cde1e88c66c8ab6a145412c67f -->
<h1>Authority Operation</h1>
<!-- START_071cca960826af06018aca214c6a1335 -->
<h2>Global Authority</h2>
<p>Grant the global permissions to type object.</p>
<h3>Response Body</h3>
<p>success : true</p>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X PUT \
    "http://localhost/api/v1/system/authority/global/admin/1294583" \
    -H "Content-Type: application/x-www-form-urlencoded" \
    -H "Accept: application/json" \
    -H "Accept-Language: zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2" \
    -H "X-Timezone: Asia/Taipei" \
    -H "Authorization: Bearer {access_token}"</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;put(
    'http://localhost/api/v1/system/authority/global/admin/1294583',
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/x-www-form-urlencoded',
            'Accept' =&gt; 'application/json',
            'Accept-Language' =&gt; 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
            'X-Timezone' =&gt; 'Asia/Taipei',
            'Authorization' =&gt; 'Bearer {access_token}',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<pre><code class="language-python">import requests
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
response.json()</code></pre>
<blockquote>
<p>Example response (200):</p>
</blockquote>
<pre><code class="language-json">{
    "success": true
}</code></pre>
<h3>HTTP Request</h3>
<p><code>PUT api/v1/system/authority/global/{type}/{uid}</code></p>
<h4>URL Parameters</h4>
<table>
<thead>
<tr>
<th>Parameter</th>
<th>Status</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td><code>type</code></td>
<td>required</td>
<td>License object type code</td>
</tr>
<tr>
<td><code>uid</code></td>
<td>required</td>
<td>Identify the object serial id</td>
</tr>
</tbody>
</table>
<!-- END_071cca960826af06018aca214c6a1335 -->
<!-- START_434dd7b9b7125ac2c26611a3f18c6fc9 -->
<h2>Grant Authority</h2>
<p>Grant the permissions to type object.</p>
<h3>Response Body</h3>
<p>success : true</p>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X PATCH \
    "http://localhost/api/v1/system/authority/grant/admin/1294583" \
    -H "Content-Type: application/x-www-form-urlencoded" \
    -H "Accept: application/json" \
    -H "Accept-Language: zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2" \
    -H "X-Timezone: Asia/Taipei" \
    -H "Authorization: Bearer {access_token}" \
    -d '{"interface":"{interface}","snapshot":"{snapshot}"}'
</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;patch(
    'http://localhost/api/v1/system/authority/grant/admin/1294583',
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/x-www-form-urlencoded',
            'Accept' =&gt; 'application/json',
            'Accept-Language' =&gt; 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
            'X-Timezone' =&gt; 'Asia/Taipei',
            'Authorization' =&gt; 'Bearer {access_token}',
        ],
        'form_params' =&gt; [
            'interface' =&gt; '{interface}',
            'snapshot' =&gt; '{snapshot}',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<pre><code class="language-python">import requests
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
response.json()</code></pre>
<blockquote>
<p>Example response (200):</p>
</blockquote>
<pre><code class="language-json">{
    "success": true
}</code></pre>
<h3>HTTP Request</h3>
<p><code>PATCH api/v1/system/authority/grant/{type}/{uid}</code></p>
<h4>URL Parameters</h4>
<table>
<thead>
<tr>
<th>Parameter</th>
<th>Status</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td><code>type</code></td>
<td>required</td>
<td>License object type code</td>
</tr>
<tr>
<td><code>uid</code></td>
<td>required</td>
<td>Identify the object serial id</td>
</tr>
</tbody>
</table>
<h4>Body Parameters</h4>
<table>
<thead>
<tr>
<th>Parameter</th>
<th>Type</th>
<th>Status</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td><code>interface</code></td>
<td>ARR</td>
<td>optional</td>
<td>Managed APIs interface code</td>
</tr>
<tr>
<td><code>snapshot</code></td>
<td>ARR</td>
<td>optional</td>
<td>Authority snapshot id</td>
</tr>
</tbody>
</table>
<!-- END_434dd7b9b7125ac2c26611a3f18c6fc9 -->
<!-- START_1d84986cb7536728cea607803158087c -->
<h2>Remove Authority</h2>
<p>Remove the permissions to type object.</p>
<h3>Response Body</h3>
<p>success : true</p>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X PATCH \
    "http://localhost/api/v1/system/authority/remove/admin/1294583" \
    -H "Content-Type: application/x-www-form-urlencoded" \
    -H "Accept: application/json" \
    -H "Accept-Language: zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2" \
    -H "X-Timezone: Asia/Taipei" \
    -H "Authorization: Bearer {access_token}" \
    -d '{"interface":"{interface}","snapshot":"{snapshot}"}'
</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;patch(
    'http://localhost/api/v1/system/authority/remove/admin/1294583',
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/x-www-form-urlencoded',
            'Accept' =&gt; 'application/json',
            'Accept-Language' =&gt; 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
            'X-Timezone' =&gt; 'Asia/Taipei',
            'Authorization' =&gt; 'Bearer {access_token}',
        ],
        'form_params' =&gt; [
            'interface' =&gt; '{interface}',
            'snapshot' =&gt; '{snapshot}',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<pre><code class="language-python">import requests
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
response.json()</code></pre>
<blockquote>
<p>Example response (200):</p>
</blockquote>
<pre><code class="language-json">{
    "success": true
}</code></pre>
<h3>HTTP Request</h3>
<p><code>PATCH api/v1/system/authority/remove/{type}/{uid}</code></p>
<h4>URL Parameters</h4>
<table>
<thead>
<tr>
<th>Parameter</th>
<th>Status</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td><code>type</code></td>
<td>required</td>
<td>License object type code</td>
</tr>
<tr>
<td><code>uid</code></td>
<td>required</td>
<td>Identify the object serial id</td>
</tr>
</tbody>
</table>
<h4>Body Parameters</h4>
<table>
<thead>
<tr>
<th>Parameter</th>
<th>Type</th>
<th>Status</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td><code>interface</code></td>
<td>ARR</td>
<td>optional</td>
<td>Managed APIs interface code</td>
</tr>
<tr>
<td><code>snapshot</code></td>
<td>ARR</td>
<td>optional</td>
<td>Authority snapshot id</td>
</tr>
</tbody>
</table>
<!-- END_1d84986cb7536728cea607803158087c -->
<!-- START_358058f78909f17714a89f302f319291 -->
<h2>Authority License Types</h2>
<p>Get a list of authority object types.</p>
<h3>Response Body</h3>
<p>success : true</p>
<p>data :</p>
<table>
<thead>
<tr>
<th>Parameter</th>
<th>Type</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td>type</td>
<td>STR</td>
<td>Type code</td>
</tr>
<tr>
<td>description</td>
<td>STR</td>
<td>Type about description</td>
</tr>
</tbody>
</table>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "http://localhost/api/v1/system/authority/type" \
    -H "Accept: application/json" \
    -H "Accept-Language: zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2" \
    -H "X-Timezone: Asia/Taipei" \
    -H "Authorization: Bearer {access_token}"</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'http://localhost/api/v1/system/authority/type',
    [
        'headers' =&gt; [
            'Accept' =&gt; 'application/json',
            'Accept-Language' =&gt; 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
            'X-Timezone' =&gt; 'Asia/Taipei',
            'Authorization' =&gt; 'Bearer {access_token}',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<pre><code class="language-python">import requests
import json

url = 'http://localhost/api/v1/system/authority/type'
headers = {
  'Accept': 'application/json',
  'Accept-Language': 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
  'X-Timezone': 'Asia/Taipei',
  'Authorization': 'Bearer {access_token}'
}
response = requests.request('GET', url, headers=headers)
response.json()</code></pre>
<blockquote>
<p>Example response (200):</p>
</blockquote>
<pre><code class="language-json">{
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
}</code></pre>
<h3>HTTP Request</h3>
<p><code>GET api/v1/system/authority/type</code></p>
<!-- END_358058f78909f17714a89f302f319291 -->
<h1>Authority Snapshot</h1>
<!-- START_4663a02d82579882c4fec18f5c283144 -->
<h2>Build Authority Snapshot</h2>
<p>Build a authority snapshot.</p>
<h3>Response Body</h3>
<p>success : true</p>
<p>data :</p>
<table>
<thead>
<tr>
<th>Parameter</th>
<th>Type</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td>id</td>
<td>STR</td>
<td>Snapshot id</td>
</tr>
<tr>
<td>name</td>
<td>STR</td>
<td>Snapshot name</td>
</tr>
</tbody>
</table>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X POST \
    "http://localhost/api/v1/system/authority/snapshot" \
    -H "Content-Type: application/x-www-form-urlencoded" \
    -H "Accept: application/json" \
    -H "Accept-Language: zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2" \
    -H "X-Timezone: Asia/Taipei" \
    -H "Authorization: Bearer {access_token}" \
    -d '{"name":"{name}","interface":"{interface}"}'
</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;post(
    'http://localhost/api/v1/system/authority/snapshot',
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/x-www-form-urlencoded',
            'Accept' =&gt; 'application/json',
            'Accept-Language' =&gt; 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
            'X-Timezone' =&gt; 'Asia/Taipei',
            'Authorization' =&gt; 'Bearer {access_token}',
        ],
        'form_params' =&gt; [
            'name' =&gt; '{name}',
            'interface' =&gt; '{interface}',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<pre><code class="language-python">import requests
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
response.json()</code></pre>
<blockquote>
<p>Example response (200):</p>
</blockquote>
<pre><code class="language-json">{
    "success": true,
    "data": {
        "id": "4f9f99e6d29046439a438b05f9607da1",
        "name": "View Client"
    }
}</code></pre>
<h3>HTTP Request</h3>
<p><code>POST api/v1/system/authority/snapshot</code></p>
<h4>Body Parameters</h4>
<table>
<thead>
<tr>
<th>Parameter</th>
<th>Type</th>
<th>Status</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td><code>name</code></td>
<td>STR</td>
<td>required</td>
<td>Authority snapshot name</td>
</tr>
<tr>
<td><code>interface</code></td>
<td>ARR</td>
<td>required</td>
<td>Managed APIs interface code</td>
</tr>
</tbody>
</table>
<!-- END_4663a02d82579882c4fec18f5c283144 -->
<!-- START_5c6e08aa0996c3c4840b887bbcd14c8d -->
<h2>Rename Authority Snapshot</h2>
<p>Rename the snapshot name of the authority snapshot.</p>
<h3>Response Body</h3>
<p>success : true</p>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X PATCH \
    "http://localhost/api/v1/system/authority/snapshot/4f9f99e6d29046439a438b05f9607da1/name" \
    -H "Content-Type: application/x-www-form-urlencoded" \
    -H "Accept: application/json" \
    -H "Accept-Language: zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2" \
    -H "X-Timezone: Asia/Taipei" \
    -H "Authorization: Bearer {access_token}" \
    -d '{"name":"{name}"}'
</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;patch(
    'http://localhost/api/v1/system/authority/snapshot/4f9f99e6d29046439a438b05f9607da1/name',
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/x-www-form-urlencoded',
            'Accept' =&gt; 'application/json',
            'Accept-Language' =&gt; 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
            'X-Timezone' =&gt; 'Asia/Taipei',
            'Authorization' =&gt; 'Bearer {access_token}',
        ],
        'form_params' =&gt; [
            'name' =&gt; '{name}',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<pre><code class="language-python">import requests
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
response.json()</code></pre>
<blockquote>
<p>Example response (200):</p>
</blockquote>
<pre><code class="language-json">{
    "success": true
}</code></pre>
<h3>HTTP Request</h3>
<p><code>PATCH api/v1/system/authority/snapshot/{id}/name</code></p>
<h4>URL Parameters</h4>
<table>
<thead>
<tr>
<th>Parameter</th>
<th>Status</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td><code>id</code></td>
<td>required</td>
<td>Authority snapshot id</td>
</tr>
</tbody>
</table>
<h4>Body Parameters</h4>
<table>
<thead>
<tr>
<th>Parameter</th>
<th>Type</th>
<th>Status</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td><code>name</code></td>
<td>STR</td>
<td>required</td>
<td>Authority snapshot name</td>
</tr>
</tbody>
</table>
<!-- END_5c6e08aa0996c3c4840b887bbcd14c8d -->
<!-- START_43cf7284570837d48455a56949920e2f -->
<h2>Authority Snapshot Index</h2>
<p>Get the authority snapshot index.</p>
<h3>Response Body</h3>
<p>success : true</p>
<p>data :</p>
<table>
<thead>
<tr>
<th>Parameter</th>
<th>Type</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td>id</td>
<td>STR</td>
<td>Snapshot id</td>
</tr>
<tr>
<td>name</td>
<td>STR</td>
<td>Snapshot name</td>
</tr>
<tr>
<td>created_at</td>
<td>STR</td>
<td>Datetime when the snapshot was created</td>
</tr>
<tr>
<td>updated_at</td>
<td>STR</td>
<td>Snapshot last updated datetime</td>
</tr>
</tbody>
</table>
<p>meta.pagination :</p>
<table>
<thead>
<tr>
<th>Parameter</th>
<th>Type</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td>total</td>
<td>INT</td>
<td>Total number of data</td>
</tr>
<tr>
<td>count</td>
<td>INT</td>
<td>Number of data displayed</td>
</tr>
<tr>
<td>per_page</td>
<td>INT</td>
<td>Number of displayed data per page</td>
</tr>
<tr>
<td>current_page</td>
<td>INT</td>
<td>Current page number</td>
</tr>
<tr>
<td>total_pages</td>
<td>INT</td>
<td>Total pages</td>
</tr>
</tbody>
</table>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "http://localhost/api/v1/system/authority/snapshot?start=2018-10-01&amp;end=2020-10-30&amp;page=1&amp;rows=15" \
    -H "Accept: application/json" \
    -H "Accept-Language: zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2" \
    -H "X-Timezone: Asia/Taipei" \
    -H "Authorization: Bearer {access_token}"</code></pre>
<pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/v1/system/authority/snapshot"
);

let params = {
    "start": "2018-10-01",
    "end": "2020-10-30",
    "page": "1",
    "rows": "15",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'http://localhost/api/v1/system/authority/snapshot',
    [
        'headers' =&gt; [
            'Accept' =&gt; 'application/json',
            'Accept-Language' =&gt; 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
            'X-Timezone' =&gt; 'Asia/Taipei',
            'Authorization' =&gt; 'Bearer {access_token}',
        ],
        'query' =&gt; [
            'start'=&gt; '2018-10-01',
            'end'=&gt; '2020-10-30',
            'page'=&gt; '1',
            'rows'=&gt; '15',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<pre><code class="language-python">import requests
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
response.json()</code></pre>
<blockquote>
<p>Example response (200):</p>
</blockquote>
<pre><code class="language-json">{
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
}</code></pre>
<h3>HTTP Request</h3>
<p><code>GET api/v1/system/authority/snapshot</code></p>
<h4>Query Parameters</h4>
<table>
<thead>
<tr>
<th>Parameter</th>
<th>Status</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td><code>start</code></td>
<td>optional</td>
<td>Start range of query creation date</td>
</tr>
<tr>
<td><code>end</code></td>
<td>optional</td>
<td>End range of query creation date</td>
</tr>
<tr>
<td><code>page</code></td>
<td>required</td>
<td>Page number</td>
</tr>
<tr>
<td><code>rows</code></td>
<td>optional</td>
<td>Per page rows defaults to 15</td>
</tr>
</tbody>
</table>
<!-- END_43cf7284570837d48455a56949920e2f -->
<!-- START_510bcb6fbb5e447630ad02d3faea18ed -->
<h2>Authority Snapshot Info</h2>
<p>Get the specified snapshot info from authority.</p>
<h3>Response Body</h3>
<p>success : true</p>
<p>data :</p>
<table>
<thead>
<tr>
<th>Parameter</th>
<th>Type</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td>id</td>
<td>STR</td>
<td>Snapshot id</td>
</tr>
<tr>
<td>name</td>
<td>STR</td>
<td>Snapshot name</td>
</tr>
<tr>
<td>authority</td>
<td>ARR</td>
<td>Snapshot APIs authority</td>
</tr>
<tr>
<td>created_at</td>
<td>STR</td>
<td>Datetime when the snapshot was created</td>
</tr>
<tr>
<td>updated_at</td>
<td>STR</td>
<td>Snapshot last updated datetime</td>
</tr>
</tbody>
</table>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "http://localhost/api/v1/system/authority/snapshot/4f9f99e6d29046439a438b05f9607da1" \
    -H "Accept: application/json" \
    -H "Accept-Language: zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2" \
    -H "X-Timezone: Asia/Taipei" \
    -H "Authorization: Bearer {access_token}"</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'http://localhost/api/v1/system/authority/snapshot/4f9f99e6d29046439a438b05f9607da1',
    [
        'headers' =&gt; [
            'Accept' =&gt; 'application/json',
            'Accept-Language' =&gt; 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
            'X-Timezone' =&gt; 'Asia/Taipei',
            'Authorization' =&gt; 'Bearer {access_token}',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<pre><code class="language-python">import requests
import json

url = 'http://localhost/api/v1/system/authority/snapshot/4f9f99e6d29046439a438b05f9607da1'
headers = {
  'Accept': 'application/json',
  'Accept-Language': 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
  'X-Timezone': 'Asia/Taipei',
  'Authorization': 'Bearer {access_token}'
}
response = requests.request('GET', url, headers=headers)
response.json()</code></pre>
<blockquote>
<p>Example response (200):</p>
</blockquote>
<pre><code class="language-json">{
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
}</code></pre>
<h3>HTTP Request</h3>
<p><code>GET api/v1/system/authority/snapshot/{id}</code></p>
<h4>URL Parameters</h4>
<table>
<thead>
<tr>
<th>Parameter</th>
<th>Status</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td><code>id</code></td>
<td>required</td>
<td>Authority snapshot id</td>
</tr>
</tbody>
</table>
<!-- END_510bcb6fbb5e447630ad02d3faea18ed -->
<!-- START_6a06f6f58051d0669ee54bd499e5c6d0 -->
<h2>Delete Authority Snapshot</h2>
<p>Delete the specified snapshot from authority.</p>
<h3>Response Body</h3>
<p>success : true</p>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X DELETE \
    "http://localhost/api/v1/system/authority/snapshot/4f9f99e6d29046439a438b05f9607da1" \
    -H "Accept: application/json" \
    -H "Accept-Language: zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2" \
    -H "X-Timezone: Asia/Taipei" \
    -H "Authorization: Bearer {access_token}"</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;delete(
    'http://localhost/api/v1/system/authority/snapshot/4f9f99e6d29046439a438b05f9607da1',
    [
        'headers' =&gt; [
            'Accept' =&gt; 'application/json',
            'Accept-Language' =&gt; 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
            'X-Timezone' =&gt; 'Asia/Taipei',
            'Authorization' =&gt; 'Bearer {access_token}',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<pre><code class="language-python">import requests
import json

url = 'http://localhost/api/v1/system/authority/snapshot/4f9f99e6d29046439a438b05f9607da1'
headers = {
  'Accept': 'application/json',
  'Accept-Language': 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
  'X-Timezone': 'Asia/Taipei',
  'Authorization': 'Bearer {access_token}'
}
response = requests.request('DELETE', url, headers=headers)
response.json()</code></pre>
<blockquote>
<p>Example response (200):</p>
</blockquote>
<pre><code class="language-json">{
    "success": true
}</code></pre>
<h3>HTTP Request</h3>
<p><code>DELETE api/v1/system/authority/snapshot/{id}</code></p>
<h4>URL Parameters</h4>
<table>
<thead>
<tr>
<th>Parameter</th>
<th>Status</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td><code>id</code></td>
<td>required</td>
<td>Authority snapshot id</td>
</tr>
</tbody>
</table>
<!-- END_6a06f6f58051d0669ee54bd499e5c6d0 -->
<h1>Client Service</h1>
<!-- START_6d34569a6f41a28ced38518748ef8d63 -->
<h2>Build Client</h2>
<p>Build a client user for the service.</p>
<h3>Response Body</h3>
<p>success : true</p>
<p>data :</p>
<table>
<thead>
<tr>
<th>Parameter</th>
<th>Type</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td>app_id</td>
<td>STR</td>
<td>Client serial id</td>
</tr>
<tr>
<td>name</td>
<td>STR</td>
<td>Client name</td>
</tr>
<tr>
<td>client_id</td>
<td>STR</td>
<td>Client id account</td>
</tr>
<tr>
<td>client_secret</td>
<td>STR</td>
<td>Client secret password</td>
</tr>
<tr>
<td>ban</td>
<td>INT</td>
<td>Client ban number</td>
</tr>
<tr>
<td>description</td>
<td>STR</td>
<td>Client ban description</td>
</tr>
<tr>
<td>status</td>
<td>BOOL</td>
<td>Client status false: Disable true: Enable</td>
</tr>
<tr>
<td>created_at</td>
<td>STR</td>
<td>Datetime when the client was created</td>
</tr>
<tr>
<td>updated_at</td>
<td>STR</td>
<td>Client last updated datetime</td>
</tr>
</tbody>
</table>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X POST \
    "http://localhost/api/v1/auth/client" \
    -H "Content-Type: application/x-www-form-urlencoded" \
    -H "Accept: application/json" \
    -H "Accept-Language: zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2" \
    -H "X-Timezone: Asia/Taipei" \
    -H "Authorization: Bearer {access_token}" \
    -d '{"name":"{name}","ban":"{ban}"}'
</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;post(
    'http://localhost/api/v1/auth/client',
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/x-www-form-urlencoded',
            'Accept' =&gt; 'application/json',
            'Accept-Language' =&gt; 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
            'X-Timezone' =&gt; 'Asia/Taipei',
            'Authorization' =&gt; 'Bearer {access_token}',
        ],
        'form_params' =&gt; [
            'name' =&gt; '{name}',
            'ban' =&gt; '{ban}',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<pre><code class="language-python">import requests
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
response.json()</code></pre>
<blockquote>
<p>Example response (200):</p>
</blockquote>
<pre><code class="language-json">{
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
}</code></pre>
<h3>HTTP Request</h3>
<p><code>POST api/v1/auth/client</code></p>
<h4>Body Parameters</h4>
<table>
<thead>
<tr>
<th>Parameter</th>
<th>Type</th>
<th>Status</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td><code>name</code></td>
<td>STR</td>
<td>required</td>
<td>Client service name</td>
</tr>
<tr>
<td><code>ban</code></td>
<td>INT</td>
<td>required</td>
<td>Ban number</td>
</tr>
</tbody>
</table>
<!-- END_6d34569a6f41a28ced38518748ef8d63 -->
<!-- START_fe3e999aa43d7782c9e13d5bb8eb7acb -->
<h2>Reset Client Secret</h2>
<p>Reset the client's service secret.</p>
<h3>Response Body</h3>
<p>success : true</p>
<p>data :</p>
<table>
<thead>
<tr>
<th>Parameter</th>
<th>Type</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td>client_secret</td>
<td>STR</td>
<td>Client secret password</td>
</tr>
</tbody>
</table>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X PATCH \
    "http://localhost/api/v1/auth/client/1294583/reset_secret" \
    -H "Content-Type: application/x-www-form-urlencoded" \
    -H "Accept: application/json" \
    -H "Accept-Language: zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2" \
    -H "X-Timezone: Asia/Taipei" \
    -H "Authorization: Bearer {access_token}"</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;patch(
    'http://localhost/api/v1/auth/client/1294583/reset_secret',
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/x-www-form-urlencoded',
            'Accept' =&gt; 'application/json',
            'Accept-Language' =&gt; 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
            'X-Timezone' =&gt; 'Asia/Taipei',
            'Authorization' =&gt; 'Bearer {access_token}',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<pre><code class="language-python">import requests
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
response.json()</code></pre>
<blockquote>
<p>Example response (200):</p>
</blockquote>
<pre><code class="language-json">{
    "success": true,
    "data": {
        "client_secret": "5a38f514ffe7704f8c0094d41fb75bf7"
    }
}</code></pre>
<h3>HTTP Request</h3>
<p><code>PATCH api/v1/auth/client/{app_id}/reset_secret</code></p>
<h4>URL Parameters</h4>
<table>
<thead>
<tr>
<th>Parameter</th>
<th>Status</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td><code>app_id</code></td>
<td>required</td>
<td>Client serial id</td>
</tr>
</tbody>
</table>
<!-- END_fe3e999aa43d7782c9e13d5bb8eb7acb -->
<!-- START_179c59ff52d2e057dba49a43ea819856 -->
<h2>Rename Client</h2>
<p>Rename the client name of the service.</p>
<h3>Response Body</h3>
<p>success : true</p>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X PATCH \
    "http://localhost/api/v1/auth/client/2215437/name" \
    -H "Content-Type: application/x-www-form-urlencoded" \
    -H "Accept: application/json" \
    -H "Accept-Language: zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2" \
    -H "X-Timezone: Asia/Taipei" \
    -H "Authorization: Bearer {access_token}" \
    -d '{"name":"{name}"}'
</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;patch(
    'http://localhost/api/v1/auth/client/2215437/name',
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/x-www-form-urlencoded',
            'Accept' =&gt; 'application/json',
            'Accept-Language' =&gt; 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
            'X-Timezone' =&gt; 'Asia/Taipei',
            'Authorization' =&gt; 'Bearer {access_token}',
        ],
        'form_params' =&gt; [
            'name' =&gt; '{name}',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<pre><code class="language-python">import requests
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
response.json()</code></pre>
<blockquote>
<p>Example response (200):</p>
</blockquote>
<pre><code class="language-json">{
    "success": true
}</code></pre>
<h3>HTTP Request</h3>
<p><code>PATCH api/v1/auth/client/{app_id}/name</code></p>
<h4>URL Parameters</h4>
<table>
<thead>
<tr>
<th>Parameter</th>
<th>Status</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td><code>app_id</code></td>
<td>required</td>
<td>Client serial id</td>
</tr>
</tbody>
</table>
<h4>Body Parameters</h4>
<table>
<thead>
<tr>
<th>Parameter</th>
<th>Type</th>
<th>Status</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td><code>name</code></td>
<td>STR</td>
<td>required</td>
<td>Client service name</td>
</tr>
</tbody>
</table>
<!-- END_179c59ff52d2e057dba49a43ea819856 -->
<!-- START_43c613f4ba24e7a610fe7e9bbb6ca0d2 -->
<h2>Rewrite Client Ban</h2>
<p>Rewrite the client ban number of the service.</p>
<h3>Response Body</h3>
<p>success : true</p>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X PATCH \
    "http://localhost/api/v1/auth/client/2215437/ban" \
    -H "Content-Type: application/x-www-form-urlencoded" \
    -H "Accept: application/json" \
    -H "Accept-Language: zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2" \
    -H "X-Timezone: Asia/Taipei" \
    -H "Authorization: Bearer {access_token}" \
    -d '{"ban":"{ban}"}'
</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;patch(
    'http://localhost/api/v1/auth/client/2215437/ban',
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/x-www-form-urlencoded',
            'Accept' =&gt; 'application/json',
            'Accept-Language' =&gt; 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
            'X-Timezone' =&gt; 'Asia/Taipei',
            'Authorization' =&gt; 'Bearer {access_token}',
        ],
        'form_params' =&gt; [
            'ban' =&gt; '{ban}',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<pre><code class="language-python">import requests
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
response.json()</code></pre>
<blockquote>
<p>Example response (200):</p>
</blockquote>
<pre><code class="language-json">{
    "success": true
}</code></pre>
<h3>HTTP Request</h3>
<p><code>PATCH api/v1/auth/client/{app_id}/ban</code></p>
<h4>URL Parameters</h4>
<table>
<thead>
<tr>
<th>Parameter</th>
<th>Status</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td><code>app_id</code></td>
<td>required</td>
<td>Client serial id</td>
</tr>
</tbody>
</table>
<h4>Body Parameters</h4>
<table>
<thead>
<tr>
<th>Parameter</th>
<th>Type</th>
<th>Status</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td><code>ban</code></td>
<td>INT</td>
<td>required</td>
<td>Ban number</td>
</tr>
</tbody>
</table>
<!-- END_43c613f4ba24e7a610fe7e9bbb6ca0d2 -->
<!-- START_d9b2c15892e3a3af5d67eb19ee5f993d -->
<h2>Disable Client</h2>
<p>Disable the client user for the service.</p>
<h3>Response Body</h3>
<p>success : true</p>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X PATCH \
    "http://localhost/api/v1/auth/client/2215437/disable" \
    -H "Content-Type: application/x-www-form-urlencoded" \
    -H "Accept: application/json" \
    -H "Accept-Language: zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2" \
    -H "X-Timezone: Asia/Taipei" \
    -H "Authorization: Bearer {access_token}"</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;patch(
    'http://localhost/api/v1/auth/client/2215437/disable',
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/x-www-form-urlencoded',
            'Accept' =&gt; 'application/json',
            'Accept-Language' =&gt; 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
            'X-Timezone' =&gt; 'Asia/Taipei',
            'Authorization' =&gt; 'Bearer {access_token}',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<pre><code class="language-python">import requests
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
response.json()</code></pre>
<blockquote>
<p>Example response (200):</p>
</blockquote>
<pre><code class="language-json">{
    "success": true
}</code></pre>
<h3>HTTP Request</h3>
<p><code>PATCH api/v1/auth/client/{app_id}/disable</code></p>
<h4>URL Parameters</h4>
<table>
<thead>
<tr>
<th>Parameter</th>
<th>Status</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td><code>app_id</code></td>
<td>required</td>
<td>Client serial id</td>
</tr>
</tbody>
</table>
<!-- END_d9b2c15892e3a3af5d67eb19ee5f993d -->
<!-- START_e896ce251295c2b8d2d38ee35246fbca -->
<h2>Enable Client</h2>
<p>Enable the client user for the service.</p>
<h3>Response Body</h3>
<p>success : true</p>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X PATCH \
    "http://localhost/api/v1/auth/client/2215437/enable" \
    -H "Content-Type: application/x-www-form-urlencoded" \
    -H "Accept: application/json" \
    -H "Accept-Language: zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2" \
    -H "X-Timezone: Asia/Taipei" \
    -H "Authorization: Bearer {access_token}"</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;patch(
    'http://localhost/api/v1/auth/client/2215437/enable',
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/x-www-form-urlencoded',
            'Accept' =&gt; 'application/json',
            'Accept-Language' =&gt; 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
            'X-Timezone' =&gt; 'Asia/Taipei',
            'Authorization' =&gt; 'Bearer {access_token}',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<pre><code class="language-python">import requests
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
response.json()</code></pre>
<blockquote>
<p>Example response (200):</p>
</blockquote>
<pre><code class="language-json">{
    "success": true
}</code></pre>
<h3>HTTP Request</h3>
<p><code>PATCH api/v1/auth/client/{app_id}/enable</code></p>
<h4>URL Parameters</h4>
<table>
<thead>
<tr>
<th>Parameter</th>
<th>Status</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td><code>app_id</code></td>
<td>required</td>
<td>Client serial id</td>
</tr>
</tbody>
</table>
<!-- END_e896ce251295c2b8d2d38ee35246fbca -->
<!-- START_7d5b3045644027fa3c82032eb23c6269 -->
<h2>Ban Index</h2>
<p>Get the ban index for the service.</p>
<h3>Response Body</h3>
<p>success : true</p>
<p>data :</p>
<table>
<thead>
<tr>
<th>Parameter</th>
<th>Type</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td>number</td>
<td>INT</td>
<td>Ban number</td>
</tr>
<tr>
<td>description</td>
<td>STR</td>
<td>Ban description</td>
</tr>
<tr>
<td>status</td>
<td>BOOL</td>
<td>Available option status false: Disable true: Enable</td>
</tr>
</tbody>
</table>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "http://localhost/api/v1/auth/client/ban" \
    -H "Accept: application/json" \
    -H "Accept-Language: zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2" \
    -H "X-Timezone: Asia/Taipei" \
    -H "Authorization: Bearer {access_token}"</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'http://localhost/api/v1/auth/client/ban',
    [
        'headers' =&gt; [
            'Accept' =&gt; 'application/json',
            'Accept-Language' =&gt; 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
            'X-Timezone' =&gt; 'Asia/Taipei',
            'Authorization' =&gt; 'Bearer {access_token}',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<pre><code class="language-python">import requests
import json

url = 'http://localhost/api/v1/auth/client/ban'
headers = {
  'Accept': 'application/json',
  'Accept-Language': 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
  'X-Timezone': 'Asia/Taipei',
  'Authorization': 'Bearer {access_token}'
}
response = requests.request('GET', url, headers=headers)
response.json()</code></pre>
<blockquote>
<p>Example response (200):</p>
</blockquote>
<pre><code class="language-json">{
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
}</code></pre>
<h3>HTTP Request</h3>
<p><code>GET api/v1/auth/client/ban</code></p>
<!-- END_7d5b3045644027fa3c82032eb23c6269 -->
<!-- START_73f2b75334014a01aecf0774396bd8c4 -->
<h2>Ban Info</h2>
<p>Get the ban description info for the service.</p>
<h3>Response Body</h3>
<p>success : true</p>
<p>data :</p>
<table>
<thead>
<tr>
<th>Parameter</th>
<th>Type</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td>number</td>
<td>INT</td>
<td>Ban number</td>
</tr>
<tr>
<td>description</td>
<td>STR</td>
<td>Ban description</td>
</tr>
<tr>
<td>status</td>
<td>BOOL</td>
<td>Available option status false: Disable true: Enable</td>
</tr>
</tbody>
</table>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "http://localhost/api/v1/auth/client/ban/1" \
    -H "Accept: application/json" \
    -H "Accept-Language: zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2" \
    -H "X-Timezone: Asia/Taipei" \
    -H "Authorization: Bearer {access_token}"</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'http://localhost/api/v1/auth/client/ban/1',
    [
        'headers' =&gt; [
            'Accept' =&gt; 'application/json',
            'Accept-Language' =&gt; 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
            'X-Timezone' =&gt; 'Asia/Taipei',
            'Authorization' =&gt; 'Bearer {access_token}',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<pre><code class="language-python">import requests
import json

url = 'http://localhost/api/v1/auth/client/ban/1'
headers = {
  'Accept': 'application/json',
  'Accept-Language': 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
  'X-Timezone': 'Asia/Taipei',
  'Authorization': 'Bearer {access_token}'
}
response = requests.request('GET', url, headers=headers)
response.json()</code></pre>
<blockquote>
<p>Example response (200):</p>
</blockquote>
<pre><code class="language-json">{
    "success": true,
    "data": {
        "number": 1,
        "description": "User Service",
        "status": true
    }
}</code></pre>
<h3>HTTP Request</h3>
<p><code>GET api/v1/auth/client/ban/{number}</code></p>
<h4>URL Parameters</h4>
<table>
<thead>
<tr>
<th>Parameter</th>
<th>Status</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td><code>number</code></td>
<td>required</td>
<td>Ban number</td>
</tr>
</tbody>
</table>
<!-- END_73f2b75334014a01aecf0774396bd8c4 -->
<!-- START_bf8c881099ec02c8c07cbe94f0b5100b -->
<h2>Client Index</h2>
<p>Get the client user index for the service.</p>
<h3>Response Body</h3>
<p>success : true</p>
<p>data :</p>
<table>
<thead>
<tr>
<th>Parameter</th>
<th>Type</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td>app_id</td>
<td>STR</td>
<td>Client serial id</td>
</tr>
<tr>
<td>name</td>
<td>STR</td>
<td>Client name</td>
</tr>
<tr>
<td>ban</td>
<td>INT</td>
<td>Client ban number</td>
</tr>
<tr>
<td>description</td>
<td>STR</td>
<td>Client ban description</td>
</tr>
<tr>
<td>status</td>
<td>BOOL</td>
<td>Client status false: Disable true: Enable</td>
</tr>
<tr>
<td>created_at</td>
<td>STR</td>
<td>Datetime when the client was created</td>
</tr>
<tr>
<td>updated_at</td>
<td>STR</td>
<td>Client last updated datetime</td>
</tr>
</tbody>
</table>
<p>meta.pagination :</p>
<table>
<thead>
<tr>
<th>Parameter</th>
<th>Type</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td>total</td>
<td>INT</td>
<td>Total number of data</td>
</tr>
<tr>
<td>count</td>
<td>INT</td>
<td>Number of data displayed</td>
</tr>
<tr>
<td>per_page</td>
<td>INT</td>
<td>Number of displayed data per page</td>
</tr>
<tr>
<td>current_page</td>
<td>INT</td>
<td>Current page number</td>
</tr>
<tr>
<td>total_pages</td>
<td>INT</td>
<td>Total pages</td>
</tr>
</tbody>
</table>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "http://localhost/api/v1/auth/client?start=2018-10-01&amp;end=2020-10-30&amp;page=1&amp;rows=15" \
    -H "Accept: application/json" \
    -H "Accept-Language: zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2" \
    -H "X-Timezone: Asia/Taipei" \
    -H "Authorization: Bearer {access_token}"</code></pre>
<pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/v1/auth/client"
);

let params = {
    "start": "2018-10-01",
    "end": "2020-10-30",
    "page": "1",
    "rows": "15",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'http://localhost/api/v1/auth/client',
    [
        'headers' =&gt; [
            'Accept' =&gt; 'application/json',
            'Accept-Language' =&gt; 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
            'X-Timezone' =&gt; 'Asia/Taipei',
            'Authorization' =&gt; 'Bearer {access_token}',
        ],
        'query' =&gt; [
            'start'=&gt; '2018-10-01',
            'end'=&gt; '2020-10-30',
            'page'=&gt; '1',
            'rows'=&gt; '15',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<pre><code class="language-python">import requests
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
response.json()</code></pre>
<blockquote>
<p>Example response (200):</p>
</blockquote>
<pre><code class="language-json">{
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
}</code></pre>
<h3>HTTP Request</h3>
<p><code>GET api/v1/auth/client</code></p>
<h4>Query Parameters</h4>
<table>
<thead>
<tr>
<th>Parameter</th>
<th>Status</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td><code>start</code></td>
<td>optional</td>
<td>Start range of query creation date</td>
</tr>
<tr>
<td><code>end</code></td>
<td>optional</td>
<td>End range of query creation date</td>
</tr>
<tr>
<td><code>page</code></td>
<td>required</td>
<td>Page number</td>
</tr>
<tr>
<td><code>rows</code></td>
<td>optional</td>
<td>Per page rows defaults to 15</td>
</tr>
</tbody>
</table>
<!-- END_bf8c881099ec02c8c07cbe94f0b5100b -->
<!-- START_76b36b901af46b9b1d00fb5cfcf956e8 -->
<h2>Client Info</h2>
<p>Get the client user info for the service.</p>
<h3>Response Body</h3>
<p>success : true</p>
<p>data :</p>
<table>
<thead>
<tr>
<th>Parameter</th>
<th>Type</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td>app_id</td>
<td>STR</td>
<td>Client serial id</td>
</tr>
<tr>
<td>name</td>
<td>STR</td>
<td>Client name</td>
</tr>
<tr>
<td>client_id</td>
<td>STR</td>
<td>Client id account</td>
</tr>
<tr>
<td>client_secret</td>
<td>STR</td>
<td>Client secret password</td>
</tr>
<tr>
<td>ban</td>
<td>INT</td>
<td>Client ban number</td>
</tr>
<tr>
<td>description</td>
<td>STR</td>
<td>Client ban description</td>
</tr>
<tr>
<td>status</td>
<td>BOOL</td>
<td>Client status false: Disable true: Enable</td>
</tr>
<tr>
<td>created_at</td>
<td>STR</td>
<td>Datetime when the client was created</td>
</tr>
<tr>
<td>updated_at</td>
<td>STR</td>
<td>Client last updated datetime</td>
</tr>
</tbody>
</table>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "http://localhost/api/v1/auth/client/1294583" \
    -H "Accept: application/json" \
    -H "Accept-Language: zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2" \
    -H "X-Timezone: Asia/Taipei" \
    -H "Authorization: Bearer {access_token}"</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'http://localhost/api/v1/auth/client/1294583',
    [
        'headers' =&gt; [
            'Accept' =&gt; 'application/json',
            'Accept-Language' =&gt; 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
            'X-Timezone' =&gt; 'Asia/Taipei',
            'Authorization' =&gt; 'Bearer {access_token}',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<pre><code class="language-python">import requests
import json

url = 'http://localhost/api/v1/auth/client/1294583'
headers = {
  'Accept': 'application/json',
  'Accept-Language': 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
  'X-Timezone': 'Asia/Taipei',
  'Authorization': 'Bearer {access_token}'
}
response = requests.request('GET', url, headers=headers)
response.json()</code></pre>
<blockquote>
<p>Example response (200):</p>
</blockquote>
<pre><code class="language-json">{
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
}</code></pre>
<h3>HTTP Request</h3>
<p><code>GET api/v1/auth/client/{app_id}</code></p>
<h4>URL Parameters</h4>
<table>
<thead>
<tr>
<th>Parameter</th>
<th>Status</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td><code>app_id</code></td>
<td>required</td>
<td>Client serial id</td>
</tr>
</tbody>
</table>
<!-- END_76b36b901af46b9b1d00fb5cfcf956e8 -->
<h1>Feature Provider</h1>
<!-- START_3222428f9020909edab32c7ea58a933e -->
<h2>Feature Index</h2>
<p>Get the feature index for the provider.</p>
<h3>Response Body</h3>
<p>success : true</p>
<p>data :</p>
<table>
<thead>
<tr>
<th>Parameter</th>
<th>Type</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td>code</td>
<td>STR</td>
<td>Feature code</td>
</tr>
<tr>
<td>description</td>
<td>STR</td>
<td>Feature description</td>
</tr>
<tr>
<td>arguments.deploy.{*}.type</td>
<td>STR</td>
<td>Feature deployment arguments type</td>
</tr>
<tr>
<td>arguments.deploy.{*}.status</td>
<td>STR</td>
<td>Feature deployment arguments request status 'required' or 'optional'</td>
</tr>
<tr>
<td>arguments.deploy.{*}.description</td>
<td>STR</td>
<td>Feature deployment arguments description</td>
</tr>
<tr>
<td>arguments.handle.{*}.type</td>
<td>STR</td>
<td>Feature handle arguments type</td>
</tr>
<tr>
<td>arguments.handle.{*}.status</td>
<td>STR</td>
<td>Feature handle arguments request status 'required' or 'optional'</td>
</tr>
<tr>
<td>arguments.handle.{*}.description</td>
<td>STR</td>
<td>Feature handle arguments description</td>
</tr>
<tr>
<td>responses.deploy.{*}.type</td>
<td>STR</td>
<td>Feature deployment responses type</td>
</tr>
<tr>
<td>responses.deploy.{*}.description</td>
<td>STR</td>
<td>Feature deployment responses description</td>
</tr>
<tr>
<td>responses.handle.{*}.type</td>
<td>STR</td>
<td>Feature handle responses type</td>
</tr>
<tr>
<td>responses.handle.{*}.description</td>
<td>STR</td>
<td>Feature handle responses description</td>
</tr>
</tbody>
</table>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "http://localhost/api/v1/feature" \
    -H "Accept: application/json" \
    -H "Accept-Language: zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2" \
    -H "X-Timezone: Asia/Taipei" \
    -H "Authorization: Bearer {access_token}"</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'http://localhost/api/v1/feature',
    [
        'headers' =&gt; [
            'Accept' =&gt; 'application/json',
            'Accept-Language' =&gt; 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
            'X-Timezone' =&gt; 'Asia/Taipei',
            'Authorization' =&gt; 'Bearer {access_token}',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<pre><code class="language-python">import requests
import json

url = 'http://localhost/api/v1/feature'
headers = {
  'Accept': 'application/json',
  'Accept-Language': 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
  'X-Timezone': 'Asia/Taipei',
  'Authorization': 'Bearer {access_token}'
}
response = requests.request('GET', url, headers=headers)
response.json()</code></pre>
<blockquote>
<p>Example response (200):</p>
</blockquote>
<pre><code class="language-json">{
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
}</code></pre>
<h3>HTTP Request</h3>
<p><code>GET api/v1/feature</code></p>
<!-- END_3222428f9020909edab32c7ea58a933e -->
<!-- START_4612506758e5c99dcc229d43a3e3277a -->
<h2>Feature Code Info</h2>
<p>Get the feature code information for the provider.</p>
<h3>Response Body</h3>
<p>success : true</p>
<p>data :</p>
<table>
<thead>
<tr>
<th>Parameter</th>
<th>Type</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td>code</td>
<td>STR</td>
<td>Feature code</td>
</tr>
<tr>
<td>description</td>
<td>STR</td>
<td>Feature description</td>
</tr>
<tr>
<td>arguments.deploy.{*}.type</td>
<td>STR</td>
<td>Feature deployment arguments type</td>
</tr>
<tr>
<td>arguments.deploy.{*}.status</td>
<td>STR</td>
<td>Feature deployment arguments request status 'required' or 'optional'</td>
</tr>
<tr>
<td>arguments.deploy.{*}.description</td>
<td>STR</td>
<td>Feature deployment arguments description</td>
</tr>
<tr>
<td>arguments.handle.{*}.type</td>
<td>STR</td>
<td>Feature handle arguments type</td>
</tr>
<tr>
<td>arguments.handle.{*}.status</td>
<td>STR</td>
<td>Feature handle arguments request status 'required' or 'optional'</td>
</tr>
<tr>
<td>arguments.handle.{*}.description</td>
<td>STR</td>
<td>Feature handle arguments description</td>
</tr>
<tr>
<td>responses.deploy.{*}.type</td>
<td>STR</td>
<td>Feature deployment responses type</td>
</tr>
<tr>
<td>responses.deploy.{*}.description</td>
<td>STR</td>
<td>Feature deployment responses description</td>
</tr>
<tr>
<td>responses.handle.{*}.type</td>
<td>STR</td>
<td>Feature handle responses type</td>
</tr>
<tr>
<td>responses.handle.{*}.description</td>
<td>STR</td>
<td>Feature handle responses description</td>
</tr>
</tbody>
</table>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "http://localhost/api/v1/feature/add_gold" \
    -H "Accept: application/json" \
    -H "Accept-Language: zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2" \
    -H "X-Timezone: Asia/Taipei" \
    -H "Authorization: Bearer {access_token}"</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'http://localhost/api/v1/feature/add_gold',
    [
        'headers' =&gt; [
            'Accept' =&gt; 'application/json',
            'Accept-Language' =&gt; 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
            'X-Timezone' =&gt; 'Asia/Taipei',
            'Authorization' =&gt; 'Bearer {access_token}',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<pre><code class="language-python">import requests
import json

url = 'http://localhost/api/v1/feature/add_gold'
headers = {
  'Accept': 'application/json',
  'Accept-Language': 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
  'X-Timezone': 'Asia/Taipei',
  'Authorization': 'Bearer {access_token}'
}
response = requests.request('GET', url, headers=headers)
response.json()</code></pre>
<blockquote>
<p>Example response (200):</p>
</blockquote>
<pre><code class="language-json">{
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
}</code></pre>
<h3>HTTP Request</h3>
<p><code>GET api/v1/feature/{code}</code></p>
<h4>URL Parameters</h4>
<table>
<thead>
<tr>
<th>Parameter</th>
<th>Status</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td><code>code</code></td>
<td>required</td>
<td>Feature code</td>
</tr>
</tbody>
</table>
<!-- END_4612506758e5c99dcc229d43a3e3277a -->
<h1>Notify Bulletin</h1>
<!-- START_44b268d0b645f408084847d51dc3cb54 -->
<h2>Bulletin Index</h2>
<p>Get the bulletin notification index.</p>
<h3>Response Body</h3>
<p>success : true</p>
<p>data :</p>
<table>
<thead>
<tr>
<th>Parameter</th>
<th>Type</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td>id</td>
<td>STR</td>
<td>Bulletin serial id</td>
</tr>
<tr>
<td>subject</td>
<td>STR</td>
<td>Subject name</td>
</tr>
<tr>
<td>content</td>
<td>OBJ</td>
<td>Notify content</td>
</tr>
<tr>
<td>type</td>
<td>STR</td>
<td>User type code</td>
</tr>
<tr>
<td>type_name</td>
<td>STR</td>
<td>User type name</td>
</tr>
<tr>
<td>released_at</td>
<td>STR</td>
<td>Schedule the bulletin release datetime</td>
</tr>
<tr>
<td>expired_at</td>
<td>STR</td>
<td>Schedule the bulletin end datetime</td>
</tr>
<tr>
<td>status</td>
<td>BOOL</td>
<td>Bulletin status false: Disable true: Enable</td>
</tr>
<tr>
<td>created_at</td>
<td>STR</td>
<td>Datetime when the bulletin was created</td>
</tr>
<tr>
<td>updated_at</td>
<td>STR</td>
<td>Bulletin last updated datetime</td>
</tr>
</tbody>
</table>
<p>meta.pagination :</p>
<table>
<thead>
<tr>
<th>Parameter</th>
<th>Type</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td>total</td>
<td>INT</td>
<td>Total number of data</td>
</tr>
<tr>
<td>count</td>
<td>INT</td>
<td>Number of data displayed</td>
</tr>
<tr>
<td>per_page</td>
<td>INT</td>
<td>Number of displayed data per page</td>
</tr>
<tr>
<td>current_page</td>
<td>INT</td>
<td>Current page number</td>
</tr>
<tr>
<td>total_pages</td>
<td>INT</td>
<td>Total pages</td>
</tr>
</tbody>
</table>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "http://localhost/api/v1/notice/bulletin?start=2020-10-07&amp;end=2020-10-10&amp;page=1&amp;rows=15" \
    -H "Accept: application/json" \
    -H "Accept-Language: zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2" \
    -H "X-Timezone: Asia/Taipei" \
    -H "Authorization: Bearer {access_token}"</code></pre>
<pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/v1/notice/bulletin"
);

let params = {
    "start": "2020-10-07",
    "end": "2020-10-10",
    "page": "1",
    "rows": "15",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'http://localhost/api/v1/notice/bulletin',
    [
        'headers' =&gt; [
            'Accept' =&gt; 'application/json',
            'Accept-Language' =&gt; 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
            'X-Timezone' =&gt; 'Asia/Taipei',
            'Authorization' =&gt; 'Bearer {access_token}',
        ],
        'query' =&gt; [
            'start'=&gt; '2020-10-07',
            'end'=&gt; '2020-10-10',
            'page'=&gt; '1',
            'rows'=&gt; '15',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<pre><code class="language-python">import requests
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
response.json()</code></pre>
<blockquote>
<p>Example response (200):</p>
</blockquote>
<pre><code class="language-json">{
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
}</code></pre>
<h3>HTTP Request</h3>
<p><code>GET api/v1/notice/bulletin</code></p>
<h4>Query Parameters</h4>
<table>
<thead>
<tr>
<th>Parameter</th>
<th>Status</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td><code>start</code></td>
<td>optional</td>
<td>Start range of query creation date</td>
</tr>
<tr>
<td><code>end</code></td>
<td>optional</td>
<td>End range of query creation date</td>
</tr>
<tr>
<td><code>page</code></td>
<td>required</td>
<td>Page number</td>
</tr>
<tr>
<td><code>rows</code></td>
<td>optional</td>
<td>Per page rows defaults to 15</td>
</tr>
</tbody>
</table>
<!-- END_44b268d0b645f408084847d51dc3cb54 -->
<!-- START_b42ab2dc8b009a7f8e5d7912fdb6b18a -->
<h2>Bulletin Info</h2>
<p>Get the bulletin notification info.</p>
<h3>Response Body</h3>
<p>success : true</p>
<p>data :</p>
<table>
<thead>
<tr>
<th>Parameter</th>
<th>Type</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td>id</td>
<td>STR</td>
<td>Bulletin serial id</td>
</tr>
<tr>
<td>subject</td>
<td>STR</td>
<td>Subject name</td>
</tr>
<tr>
<td>content</td>
<td>OBJ</td>
<td>Notify content</td>
</tr>
<tr>
<td>type</td>
<td>STR</td>
<td>User type code</td>
</tr>
<tr>
<td>type_name</td>
<td>STR</td>
<td>User type name</td>
</tr>
<tr>
<td>released_at</td>
<td>STR</td>
<td>Schedule the bulletin release datetime</td>
</tr>
<tr>
<td>expired_at</td>
<td>STR</td>
<td>Schedule the bulletin end datetime</td>
</tr>
<tr>
<td>status</td>
<td>BOOL</td>
<td>Bulletin status false: Disable true: Enable</td>
</tr>
<tr>
<td>created_at</td>
<td>STR</td>
<td>Datetime when the bulletin was created</td>
</tr>
<tr>
<td>updated_at</td>
<td>STR</td>
<td>Bulletin last updated datetime</td>
</tr>
</tbody>
</table>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "http://localhost/api/v1/notice/bulletin/ddc09c60-8385-4e64-8516-6ba3f6fd6a84" \
    -H "Accept: application/json" \
    -H "Accept-Language: zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2" \
    -H "X-Timezone: Asia/Taipei" \
    -H "Authorization: Bearer {access_token}"</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'http://localhost/api/v1/notice/bulletin/ddc09c60-8385-4e64-8516-6ba3f6fd6a84',
    [
        'headers' =&gt; [
            'Accept' =&gt; 'application/json',
            'Accept-Language' =&gt; 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
            'X-Timezone' =&gt; 'Asia/Taipei',
            'Authorization' =&gt; 'Bearer {access_token}',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<pre><code class="language-python">import requests
import json

url = 'http://localhost/api/v1/notice/bulletin/ddc09c60-8385-4e64-8516-6ba3f6fd6a84'
headers = {
  'Accept': 'application/json',
  'Accept-Language': 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
  'X-Timezone': 'Asia/Taipei',
  'Authorization': 'Bearer {access_token}'
}
response = requests.request('GET', url, headers=headers)
response.json()</code></pre>
<blockquote>
<p>Example response (200):</p>
</blockquote>
<pre><code class="language-json">{
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
}</code></pre>
<h3>HTTP Request</h3>
<p><code>GET api/v1/notice/bulletin/{id}</code></p>
<h4>URL Parameters</h4>
<table>
<thead>
<tr>
<th>Parameter</th>
<th>Status</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td><code>id</code></td>
<td>required</td>
<td>Bulletin serial id</td>
</tr>
</tbody>
</table>
<!-- END_b42ab2dc8b009a7f8e5d7912fdb6b18a -->
<!-- START_61262d541a3fcb5b3a0bc5028bb4fea1 -->
<h2>Notifiable User Types</h2>
<p>Get a list of user types for notification.</p>
<h3>Response Body</h3>
<p>success : true</p>
<p>data :</p>
<table>
<thead>
<tr>
<th>Parameter</th>
<th>Type</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td>type</td>
<td>STR</td>
<td>User type code</td>
</tr>
<tr>
<td>description</td>
<td>STR</td>
<td>User type about description</td>
</tr>
</tbody>
</table>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "http://localhost/api/v1/notice/bulletin/user/type" \
    -H "Accept: application/json" \
    -H "Accept-Language: zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2" \
    -H "X-Timezone: Asia/Taipei" \
    -H "Authorization: Bearer {access_token}"</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'http://localhost/api/v1/notice/bulletin/user/type',
    [
        'headers' =&gt; [
            'Accept' =&gt; 'application/json',
            'Accept-Language' =&gt; 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
            'X-Timezone' =&gt; 'Asia/Taipei',
            'Authorization' =&gt; 'Bearer {access_token}',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<pre><code class="language-python">import requests
import json

url = 'http://localhost/api/v1/notice/bulletin/user/type'
headers = {
  'Accept': 'application/json',
  'Accept-Language': 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
  'X-Timezone': 'Asia/Taipei',
  'Authorization': 'Bearer {access_token}'
}
response = requests.request('GET', url, headers=headers)
response.json()</code></pre>
<blockquote>
<p>Example response (200):</p>
</blockquote>
<pre><code class="language-json">{
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
}</code></pre>
<h3>HTTP Request</h3>
<p><code>GET api/v1/notice/bulletin/user/type</code></p>
<!-- END_61262d541a3fcb5b3a0bc5028bb4fea1 -->
<!-- START_5b7eaa4b6f7f8c5260d7b149cd9f8045 -->
<h2>Build Bulletin</h2>
<p>Build a bulletin notification message.</p>
<h3>Response Body</h3>
<p>success : true</p>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X POST \
    "http://localhost/api/v1/notice/bulletin/build/member" \
    -H "Accept: application/json" \
    -H "Accept-Language: zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2" \
    -H "X-Timezone: Asia/Taipei" \
    -H "Authorization: Bearer {access_token}" \
    -H "Content-Type: application/json" \
    -d '{"subject":"{subject}","message":"{message}","start":"{start}","end":"{end}"}'
</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;post(
    'http://localhost/api/v1/notice/bulletin/build/member',
    [
        'headers' =&gt; [
            'Accept' =&gt; 'application/json',
            'Accept-Language' =&gt; 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
            'X-Timezone' =&gt; 'Asia/Taipei',
            'Authorization' =&gt; 'Bearer {access_token}',
            'Content-Type' =&gt; 'application/json',
        ],
        'form_params' =&gt; [
            'subject' =&gt; '{subject}',
            'message' =&gt; '{message}',
            'start' =&gt; '{start}',
            'end' =&gt; '{end}',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<pre><code class="language-python">import requests
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
response.json()</code></pre>
<blockquote>
<p>Example response (200):</p>
</blockquote>
<pre><code class="language-json">{
    "success": true
}</code></pre>
<h3>HTTP Request</h3>
<p><code>POST api/v1/notice/bulletin/build/{type}</code></p>
<h4>URL Parameters</h4>
<table>
<thead>
<tr>
<th>Parameter</th>
<th>Status</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td><code>type</code></td>
<td>required</td>
<td>User type code</td>
</tr>
</tbody>
</table>
<h4>Body Parameters</h4>
<table>
<thead>
<tr>
<th>Parameter</th>
<th>Type</th>
<th>Status</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td><code>subject</code></td>
<td>STR</td>
<td>required</td>
<td>Subject name</td>
</tr>
<tr>
<td><code>message</code></td>
<td>STR</td>
<td>required</td>
<td>Push message</td>
</tr>
<tr>
<td><code>start</code></td>
<td>STR</td>
<td>required</td>
<td>Bulletin start range time yyyy-mm-dd hh:ii:ss</td>
</tr>
<tr>
<td><code>end</code></td>
<td>STR</td>
<td>required</td>
<td>Bulletin end range time yyyy-mm-dd hh:ii:ss</td>
</tr>
</tbody>
</table>
<!-- END_5b7eaa4b6f7f8c5260d7b149cd9f8045 -->
<!-- START_418935f2e497e100c36ca4d7ebd96d6b -->
<h2>Disable Bulletin</h2>
<p>Disable the bulletin notification.</p>
<h3>Response Body</h3>
<p>success : true</p>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X PATCH \
    "http://localhost/api/v1/notice/bulletin/ddc09c60-8385-4e64-8516-6ba3f6fd6a84/disable" \
    -H "Accept: application/json" \
    -H "Accept-Language: zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2" \
    -H "X-Timezone: Asia/Taipei" \
    -H "Authorization: Bearer {access_token}"</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;patch(
    'http://localhost/api/v1/notice/bulletin/ddc09c60-8385-4e64-8516-6ba3f6fd6a84/disable',
    [
        'headers' =&gt; [
            'Accept' =&gt; 'application/json',
            'Accept-Language' =&gt; 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
            'X-Timezone' =&gt; 'Asia/Taipei',
            'Authorization' =&gt; 'Bearer {access_token}',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<pre><code class="language-python">import requests
import json

url = 'http://localhost/api/v1/notice/bulletin/ddc09c60-8385-4e64-8516-6ba3f6fd6a84/disable'
headers = {
  'Accept': 'application/json',
  'Accept-Language': 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
  'X-Timezone': 'Asia/Taipei',
  'Authorization': 'Bearer {access_token}'
}
response = requests.request('PATCH', url, headers=headers)
response.json()</code></pre>
<blockquote>
<p>Example response (200):</p>
</blockquote>
<pre><code class="language-json">{
    "success": true
}</code></pre>
<h3>HTTP Request</h3>
<p><code>PATCH api/v1/notice/bulletin/{id}/disable</code></p>
<h4>URL Parameters</h4>
<table>
<thead>
<tr>
<th>Parameter</th>
<th>Status</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td><code>id</code></td>
<td>required</td>
<td>Bulletin serial id</td>
</tr>
</tbody>
</table>
<!-- END_418935f2e497e100c36ca4d7ebd96d6b -->
<!-- START_0d9f2111af691361c4d52e70cb3eab3f -->
<h2>Enable Bulletin</h2>
<p>Enable the bulletin notification.</p>
<h3>Response Body</h3>
<p>success : true</p>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X PATCH \
    "http://localhost/api/v1/notice/bulletin/ddc09c60-8385-4e64-8516-6ba3f6fd6a84/enable" \
    -H "Accept: application/json" \
    -H "Accept-Language: zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2" \
    -H "X-Timezone: Asia/Taipei" \
    -H "Authorization: Bearer {access_token}"</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;patch(
    'http://localhost/api/v1/notice/bulletin/ddc09c60-8385-4e64-8516-6ba3f6fd6a84/enable',
    [
        'headers' =&gt; [
            'Accept' =&gt; 'application/json',
            'Accept-Language' =&gt; 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
            'X-Timezone' =&gt; 'Asia/Taipei',
            'Authorization' =&gt; 'Bearer {access_token}',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<pre><code class="language-python">import requests
import json

url = 'http://localhost/api/v1/notice/bulletin/ddc09c60-8385-4e64-8516-6ba3f6fd6a84/enable'
headers = {
  'Accept': 'application/json',
  'Accept-Language': 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
  'X-Timezone': 'Asia/Taipei',
  'Authorization': 'Bearer {access_token}'
}
response = requests.request('PATCH', url, headers=headers)
response.json()</code></pre>
<blockquote>
<p>Example response (200):</p>
</blockquote>
<pre><code class="language-json">{
    "success": true
}</code></pre>
<h3>HTTP Request</h3>
<p><code>PATCH api/v1/notice/bulletin/{id}/enable</code></p>
<h4>URL Parameters</h4>
<table>
<thead>
<tr>
<th>Parameter</th>
<th>Status</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td><code>id</code></td>
<td>required</td>
<td>Bulletin serial id</td>
</tr>
</tbody>
</table>
<!-- END_0d9f2111af691361c4d52e70cb3eab3f -->
<h1>SMS Log</h1>
<!-- START_732439d5d924dc672dc350b0cd2c6531 -->
<h2>SMS Record Index</h2>
<p>Get the SMS sending index.</p>
<h3>Response Body</h3>
<p>success : true</p>
<p>data :</p>
<table>
<thead>
<tr>
<th>Parameter</th>
<th>Type</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td>serial</td>
<td>STR</td>
<td>SMS record serial id</td>
</tr>
<tr>
<td>source_id</td>
<td>STR</td>
<td>SMS operate source id</td>
</tr>
<tr>
<td>source</td>
<td>STR</td>
<td>SMS operate source type code</td>
</tr>
<tr>
<td>source_name</td>
<td>STR</td>
<td>SMS operate source type name</td>
</tr>
<tr>
<td>telecomer</td>
<td>STR</td>
<td>SMS telecomer type code</td>
</tr>
<tr>
<td>telecomer_name</td>
<td>STR</td>
<td>SMS telecomer type name</td>
</tr>
<tr>
<td>phone</td>
<td>STR</td>
<td>SMS to phone number</td>
</tr>
<tr>
<td>message.message</td>
<td>STR</td>
<td>SMS message</td>
</tr>
<tr>
<td>message.subject</td>
<td>STR</td>
<td>SMS subject</td>
</tr>
<tr>
<td>result</td>
<td>OBJ</td>
<td>SMS response result message</td>
</tr>
<tr>
<td>operate</td>
<td>STR</td>
<td>SMS operate type ( success, failure )</td>
</tr>
<tr>
<td>created_at</td>
<td>STR</td>
<td>Datetime when the SMS was sent</td>
</tr>
<tr>
<td>updated_at</td>
<td>STR</td>
<td>Datetime when the log was updated</td>
</tr>
</tbody>
</table>
<p>meta.pagination :</p>
<table>
<thead>
<tr>
<th>Parameter</th>
<th>Type</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td>total</td>
<td>INT</td>
<td>Total number of data</td>
</tr>
<tr>
<td>count</td>
<td>INT</td>
<td>Number of data displayed</td>
</tr>
<tr>
<td>per_page</td>
<td>INT</td>
<td>Number of displayed data per page</td>
</tr>
<tr>
<td>current_page</td>
<td>INT</td>
<td>Current page number</td>
</tr>
<tr>
<td>total_pages</td>
<td>INT</td>
<td>Total pages</td>
</tr>
</tbody>
</table>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "http://localhost/api/v1/sms/log?start=2018-10-01&amp;end=2020-10-30&amp;page=1&amp;rows=15" \
    -H "Accept: application/json" \
    -H "Accept-Language: zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2" \
    -H "X-Timezone: Asia/Taipei" \
    -H "Authorization: Bearer {access_token}"</code></pre>
<pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/v1/sms/log"
);

let params = {
    "start": "2018-10-01",
    "end": "2020-10-30",
    "page": "1",
    "rows": "15",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'http://localhost/api/v1/sms/log',
    [
        'headers' =&gt; [
            'Accept' =&gt; 'application/json',
            'Accept-Language' =&gt; 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
            'X-Timezone' =&gt; 'Asia/Taipei',
            'Authorization' =&gt; 'Bearer {access_token}',
        ],
        'query' =&gt; [
            'start'=&gt; '2018-10-01',
            'end'=&gt; '2020-10-30',
            'page'=&gt; '1',
            'rows'=&gt; '15',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<pre><code class="language-python">import requests
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
response.json()</code></pre>
<blockquote>
<p>Example response (200):</p>
</blockquote>
<pre><code class="language-json">{
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
}</code></pre>
<h3>HTTP Request</h3>
<p><code>GET api/v1/sms/log</code></p>
<h4>Query Parameters</h4>
<table>
<thead>
<tr>
<th>Parameter</th>
<th>Status</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td><code>start</code></td>
<td>optional</td>
<td>Start range of query creation date</td>
</tr>
<tr>
<td><code>end</code></td>
<td>optional</td>
<td>End range of query creation date</td>
</tr>
<tr>
<td><code>page</code></td>
<td>required</td>
<td>Page number</td>
</tr>
<tr>
<td><code>rows</code></td>
<td>optional</td>
<td>Per page rows defaults to 15</td>
</tr>
</tbody>
</table>
<!-- END_732439d5d924dc672dc350b0cd2c6531 -->
<!-- START_5a966e0a01ae4d1abfb64b6df679ba31 -->
<h2>SMS Record Serial Info</h2>
<p>Get the SMS sending serial info.</p>
<h3>Response Body</h3>
<p>success : true</p>
<p>data :</p>
<table>
<thead>
<tr>
<th>Parameter</th>
<th>Type</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td>serial</td>
<td>STR</td>
<td>SMS record serial id</td>
</tr>
<tr>
<td>source_id</td>
<td>STR</td>
<td>SMS operate source id</td>
</tr>
<tr>
<td>source</td>
<td>STR</td>
<td>SMS operate source type code</td>
</tr>
<tr>
<td>source_name</td>
<td>STR</td>
<td>SMS operate source type name</td>
</tr>
<tr>
<td>telecomer</td>
<td>STR</td>
<td>SMS telecomer type code</td>
</tr>
<tr>
<td>telecomer_name</td>
<td>STR</td>
<td>SMS telecomer type name</td>
</tr>
<tr>
<td>phone</td>
<td>STR</td>
<td>SMS to phone number</td>
</tr>
<tr>
<td>message.message</td>
<td>STR</td>
<td>SMS message</td>
</tr>
<tr>
<td>message.subject</td>
<td>STR</td>
<td>SMS subject</td>
</tr>
<tr>
<td>result</td>
<td>OBJ</td>
<td>SMS response result message</td>
</tr>
<tr>
<td>operate</td>
<td>STR</td>
<td>SMS operate type ( success, failure )</td>
</tr>
<tr>
<td>created_at</td>
<td>STR</td>
<td>Datetime when the SMS was sent</td>
</tr>
<tr>
<td>updated_at</td>
<td>STR</td>
<td>Datetime when the log was updated</td>
</tr>
</tbody>
</table>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "http://localhost/api/v1/sms/log/120201118" \
    -H "Accept: application/json" \
    -H "Accept-Language: zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2" \
    -H "X-Timezone: Asia/Taipei" \
    -H "Authorization: Bearer {access_token}"</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'http://localhost/api/v1/sms/log/120201118',
    [
        'headers' =&gt; [
            'Accept' =&gt; 'application/json',
            'Accept-Language' =&gt; 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
            'X-Timezone' =&gt; 'Asia/Taipei',
            'Authorization' =&gt; 'Bearer {access_token}',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<pre><code class="language-python">import requests
import json

url = 'http://localhost/api/v1/sms/log/120201118'
headers = {
  'Accept': 'application/json',
  'Accept-Language': 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
  'X-Timezone': 'Asia/Taipei',
  'Authorization': 'Bearer {access_token}'
}
response = requests.request('GET', url, headers=headers)
response.json()</code></pre>
<blockquote>
<p>Example response (200):</p>
</blockquote>
<pre><code class="language-json">{
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
}</code></pre>
<h3>HTTP Request</h3>
<p><code>GET api/v1/sms/log/{serial}</code></p>
<h4>URL Parameters</h4>
<table>
<thead>
<tr>
<th>Parameter</th>
<th>Status</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td><code>serial</code></td>
<td>required</td>
<td>SMS record serial id</td>
</tr>
</tbody>
</table>
<!-- END_5a966e0a01ae4d1abfb64b6df679ba31 -->
<h1>Support API Interface</h1>
<!-- START_2f8186a709e64de985791fb2a8d22755 -->
<h2>APIs</h2>
<p>Get a list of all API interfaces.</p>
<h3>Response Body</h3>
<p>success : true</p>
<p>data :</p>
<table>
<thead>
<tr>
<th>Parameter</th>
<th>Type</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td>code</td>
<td>STR</td>
<td>Interface code</td>
</tr>
<tr>
<td>interface</td>
<td>STR</td>
<td>Interface uri</td>
</tr>
<tr>
<td>description</td>
<td>STR</td>
<td>Interface about description</td>
</tr>
</tbody>
</table>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "http://localhost/api/v1/system/interface" \
    -H "Accept: application/json" \
    -H "Accept-Language: zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2" \
    -H "X-Timezone: Asia/Taipei" \
    -H "Authorization: Bearer {access_token}"</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'http://localhost/api/v1/system/interface',
    [
        'headers' =&gt; [
            'Accept' =&gt; 'application/json',
            'Accept-Language' =&gt; 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
            'X-Timezone' =&gt; 'Asia/Taipei',
            'Authorization' =&gt; 'Bearer {access_token}',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<pre><code class="language-python">import requests
import json

url = 'http://localhost/api/v1/system/interface'
headers = {
  'Accept': 'application/json',
  'Accept-Language': 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
  'X-Timezone': 'Asia/Taipei',
  'Authorization': 'Bearer {access_token}'
}
response = requests.request('GET', url, headers=headers)
response.json()</code></pre>
<blockquote>
<p>Example response (200):</p>
</blockquote>
<pre><code class="language-json">{
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
}</code></pre>
<h3>HTTP Request</h3>
<p><code>GET api/v1/system/interface</code></p>
<!-- END_2f8186a709e64de985791fb2a8d22755 -->
<!-- START_9590974ae3375ddcc7dd4436df7f2f81 -->
<h2>Managed APIs</h2>
<p>Get a list of managed API interfaces.</p>
<h3>Response Body</h3>
<p>success : true</p>
<p>data :</p>
<table>
<thead>
<tr>
<th>Parameter</th>
<th>Type</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td>code</td>
<td>STR</td>
<td>Interface code</td>
</tr>
<tr>
<td>interface</td>
<td>STR</td>
<td>Interface uri</td>
</tr>
<tr>
<td>description</td>
<td>STR</td>
<td>Interface about description</td>
</tr>
</tbody>
</table>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "http://localhost/api/v1/system/interface/managed" \
    -H "Accept: application/json" \
    -H "Accept-Language: zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2" \
    -H "X-Timezone: Asia/Taipei" \
    -H "Authorization: Bearer {access_token}"</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'http://localhost/api/v1/system/interface/managed',
    [
        'headers' =&gt; [
            'Accept' =&gt; 'application/json',
            'Accept-Language' =&gt; 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
            'X-Timezone' =&gt; 'Asia/Taipei',
            'Authorization' =&gt; 'Bearer {access_token}',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<pre><code class="language-python">import requests
import json

url = 'http://localhost/api/v1/system/interface/managed'
headers = {
  'Accept': 'application/json',
  'Accept-Language': 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
  'X-Timezone': 'Asia/Taipei',
  'Authorization': 'Bearer {access_token}'
}
response = requests.request('GET', url, headers=headers)
response.json()</code></pre>
<blockquote>
<p>Example response (200):</p>
</blockquote>
<pre><code class="language-json">{
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
}</code></pre>
<h3>HTTP Request</h3>
<p><code>GET api/v1/system/interface/managed</code></p>
<!-- END_9590974ae3375ddcc7dd4436df7f2f81 -->
<!-- START_fa21e5e4c0aba28e390b21e2faff1556 -->
<h2>Managed APIs By Ban</h2>
<p>Get a list of managed API interfaces by ban number.</p>
<h3>Response Body</h3>
<p>success : true</p>
<p>data :</p>
<table>
<thead>
<tr>
<th>Parameter</th>
<th>Type</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td>code</td>
<td>STR</td>
<td>Interface code</td>
</tr>
<tr>
<td>interface</td>
<td>STR</td>
<td>Interface uri</td>
</tr>
<tr>
<td>description</td>
<td>STR</td>
<td>Interface about description</td>
</tr>
</tbody>
</table>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "http://localhost/api/v1/system/interface/managed/ban/1" \
    -H "Accept: application/json" \
    -H "Accept-Language: zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2" \
    -H "X-Timezone: Asia/Taipei" \
    -H "Authorization: Bearer {access_token}"</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'http://localhost/api/v1/system/interface/managed/ban/1',
    [
        'headers' =&gt; [
            'Accept' =&gt; 'application/json',
            'Accept-Language' =&gt; 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
            'X-Timezone' =&gt; 'Asia/Taipei',
            'Authorization' =&gt; 'Bearer {access_token}',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<pre><code class="language-python">import requests
import json

url = 'http://localhost/api/v1/system/interface/managed/ban/1'
headers = {
  'Accept': 'application/json',
  'Accept-Language': 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
  'X-Timezone': 'Asia/Taipei',
  'Authorization': 'Bearer {access_token}'
}
response = requests.request('GET', url, headers=headers)
response.json()</code></pre>
<blockquote>
<p>Example response (200):</p>
</blockquote>
<pre><code class="language-json">{
    "success": true,
    "data": [
        {
            "code": "auth.client.index",
            "interface": "api\/v1\/auth\/client",
            "description": "Client Service Index"
        }
    ]
}</code></pre>
<h3>HTTP Request</h3>
<p><code>GET api/v1/system/interface/managed/ban/{number}</code></p>
<h4>URL Parameters</h4>
<table>
<thead>
<tr>
<th>Parameter</th>
<th>Status</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td><code>number</code></td>
<td>required</td>
<td>Ban number</td>
</tr>
</tbody>
</table>
<!-- END_fa21e5e4c0aba28e390b21e2faff1556 -->
<h1>Support Language</h1>
<!-- START_3b33f12749213e1b3333db4f1fd9170d -->
<h2>Language Index</h2>
<p>Get the language index.</p>
<h3>Response Body</h3>
<p>success : true</p>
<p>data :</p>
<table>
<thead>
<tr>
<th>Parameter</th>
<th>Type</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td>language</td>
<td>STR</td>
<td>Language code</td>
</tr>
<tr>
<td>description</td>
<td>STR</td>
<td>Language about description</td>
</tr>
</tbody>
</table>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "http://localhost/api/v1/system/language" \
    -H "Accept: application/json" \
    -H "Accept-Language: zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2" \
    -H "X-Timezone: Asia/Taipei" \
    -H "Authorization: Bearer {access_token}"</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'http://localhost/api/v1/system/language',
    [
        'headers' =&gt; [
            'Accept' =&gt; 'application/json',
            'Accept-Language' =&gt; 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
            'X-Timezone' =&gt; 'Asia/Taipei',
            'Authorization' =&gt; 'Bearer {access_token}',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<pre><code class="language-python">import requests
import json

url = 'http://localhost/api/v1/system/language'
headers = {
  'Accept': 'application/json',
  'Accept-Language': 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
  'X-Timezone': 'Asia/Taipei',
  'Authorization': 'Bearer {access_token}'
}
response = requests.request('GET', url, headers=headers)
response.json()</code></pre>
<blockquote>
<p>Example response (200):</p>
</blockquote>
<pre><code class="language-json">{
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
}</code></pre>
<h3>HTTP Request</h3>
<p><code>GET api/v1/system/language</code></p>
<!-- END_3b33f12749213e1b3333db4f1fd9170d -->
<!-- START_bebcb8f4fbeb05baaa755a4ed520a0c7 -->
<h2>Default Language</h2>
<p>Get the default language.</p>
<h3>Response Body</h3>
<p>success : true</p>
<p>data :</p>
<table>
<thead>
<tr>
<th>Parameter</th>
<th>Type</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td>language</td>
<td>STR</td>
<td>Language code</td>
</tr>
<tr>
<td>description</td>
<td>STR</td>
<td>Language about description</td>
</tr>
</tbody>
</table>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "http://localhost/api/v1/system/language/default" \
    -H "Accept: application/json" \
    -H "Accept-Language: zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2" \
    -H "X-Timezone: Asia/Taipei" \
    -H "Authorization: Bearer {access_token}"</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'http://localhost/api/v1/system/language/default',
    [
        'headers' =&gt; [
            'Accept' =&gt; 'application/json',
            'Accept-Language' =&gt; 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
            'X-Timezone' =&gt; 'Asia/Taipei',
            'Authorization' =&gt; 'Bearer {access_token}',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<pre><code class="language-python">import requests
import json

url = 'http://localhost/api/v1/system/language/default'
headers = {
  'Accept': 'application/json',
  'Accept-Language': 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
  'X-Timezone': 'Asia/Taipei',
  'Authorization': 'Bearer {access_token}'
}
response = requests.request('GET', url, headers=headers)
response.json()</code></pre>
<blockquote>
<p>Example response (200):</p>
</blockquote>
<pre><code class="language-json">{
    "success": true,
    "data": {
        "language": "en",
        "description": "English"
    }
}</code></pre>
<h3>HTTP Request</h3>
<p><code>GET api/v1/system/language/default</code></p>
<!-- END_bebcb8f4fbeb05baaa755a4ed520a0c7 -->
<h1>System Parameters</h1>
<!-- START_23171f241d6d390e3410bfe6a0981615 -->
<h2>Rewrite Parameter Value</h2>
<p>Rewrite the parameter value.</p>
<h3>Response Body</h3>
<p>success : true</p>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X PATCH \
    "http://localhost/api/v1/system/parameter/status" \
    -H "Content-Type: application/x-www-form-urlencoded" \
    -H "Accept: application/json" \
    -H "Accept-Language: zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2" \
    -H "X-Timezone: Asia/Taipei" \
    -H "Authorization: Bearer {access_token}"</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;patch(
    'http://localhost/api/v1/system/parameter/status',
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/x-www-form-urlencoded',
            'Accept' =&gt; 'application/json',
            'Accept-Language' =&gt; 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
            'X-Timezone' =&gt; 'Asia/Taipei',
            'Authorization' =&gt; 'Bearer {access_token}',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<pre><code class="language-python">import requests
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
response.json()</code></pre>
<blockquote>
<p>Example response (200):</p>
</blockquote>
<pre><code class="language-json">{
    "success": true
}</code></pre>
<h3>HTTP Request</h3>
<p><code>PATCH api/v1/system/parameter/{slug}</code></p>
<h4>URL Parameters</h4>
<table>
<thead>
<tr>
<th>Parameter</th>
<th>Status</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td><code>slug</code></td>
<td>required</td>
<td>Parameter key name</td>
</tr>
</tbody>
</table>
<!-- END_23171f241d6d390e3410bfe6a0981615 -->
<!-- START_539935877c78f1175fb1a70c68af3b40 -->
<h2>Parameter Index</h2>
<p>Get the parameter index.</p>
<h3>Response Body</h3>
<p>success : true</p>
<p>data :</p>
<table>
<thead>
<tr>
<th>Parameter</th>
<th>Type</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td>slug</td>
<td>STR</td>
<td>Parameter key name</td>
</tr>
<tr>
<td>value</td>
<td>STR</td>
<td>Parameter value</td>
</tr>
<tr>
<td>rule.description</td>
<td>STR</td>
<td>Parameter value description</td>
</tr>
<tr>
<td>rule.type</td>
<td>STR</td>
<td>Parameter value type</td>
</tr>
<tr>
<td>description</td>
<td>STR</td>
<td>Parameter about description</td>
</tr>
<tr>
<td>created_at</td>
<td>STR</td>
<td>Datetime when the parameter was created</td>
</tr>
<tr>
<td>updated_at</td>
<td>STR</td>
<td>Parameter last updated datetime</td>
</tr>
</tbody>
</table>
<p>meta.pagination :</p>
<table>
<thead>
<tr>
<th>Parameter</th>
<th>Type</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td>total</td>
<td>INT</td>
<td>Total number of data</td>
</tr>
<tr>
<td>count</td>
<td>INT</td>
<td>Number of data displayed</td>
</tr>
<tr>
<td>per_page</td>
<td>INT</td>
<td>Number of displayed data per page</td>
</tr>
<tr>
<td>current_page</td>
<td>INT</td>
<td>Current page number</td>
</tr>
<tr>
<td>total_pages</td>
<td>INT</td>
<td>Total pages</td>
</tr>
</tbody>
</table>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "http://localhost/api/v1/system/parameter?page=1&amp;rows=15" \
    -H "Accept: application/json" \
    -H "Accept-Language: zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2" \
    -H "X-Timezone: Asia/Taipei" \
    -H "Authorization: Bearer {access_token}"</code></pre>
<pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/v1/system/parameter"
);

let params = {
    "page": "1",
    "rows": "15",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'http://localhost/api/v1/system/parameter',
    [
        'headers' =&gt; [
            'Accept' =&gt; 'application/json',
            'Accept-Language' =&gt; 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
            'X-Timezone' =&gt; 'Asia/Taipei',
            'Authorization' =&gt; 'Bearer {access_token}',
        ],
        'query' =&gt; [
            'page'=&gt; '1',
            'rows'=&gt; '15',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<pre><code class="language-python">import requests
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
response.json()</code></pre>
<blockquote>
<p>Example response (200):</p>
</blockquote>
<pre><code class="language-json">{
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
}</code></pre>
<h3>HTTP Request</h3>
<p><code>GET api/v1/system/parameter</code></p>
<h4>Query Parameters</h4>
<table>
<thead>
<tr>
<th>Parameter</th>
<th>Status</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td><code>page</code></td>
<td>required</td>
<td>Page number</td>
</tr>
<tr>
<td><code>rows</code></td>
<td>optional</td>
<td>Per page rows defaults to 15</td>
</tr>
</tbody>
</table>
<!-- END_539935877c78f1175fb1a70c68af3b40 -->
<!-- START_9e89de3e705345bd9134a8c625532693 -->
<h2>Parameter Info</h2>
<p>Get the parameter info.</p>
<h3>Response Body</h3>
<p>success : true</p>
<p>data :</p>
<table>
<thead>
<tr>
<th>Parameter</th>
<th>Type</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td>slug</td>
<td>STR</td>
<td>Parameter key name</td>
</tr>
<tr>
<td>value</td>
<td>STR</td>
<td>Parameter value</td>
</tr>
<tr>
<td>rule.description</td>
<td>STR</td>
<td>Parameter value description</td>
</tr>
<tr>
<td>rule.type</td>
<td>STR</td>
<td>Parameter value type</td>
</tr>
<tr>
<td>description</td>
<td>STR</td>
<td>Parameter about description</td>
</tr>
<tr>
<td>created_at</td>
<td>STR</td>
<td>Datetime when the parameter was created</td>
</tr>
<tr>
<td>updated_at</td>
<td>STR</td>
<td>Parameter last updated datetime</td>
</tr>
</tbody>
</table>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "http://localhost/api/v1/system/parameter/status" \
    -H "Accept: application/json" \
    -H "Accept-Language: zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2" \
    -H "X-Timezone: Asia/Taipei" \
    -H "Authorization: Bearer {access_token}"</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'http://localhost/api/v1/system/parameter/status',
    [
        'headers' =&gt; [
            'Accept' =&gt; 'application/json',
            'Accept-Language' =&gt; 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
            'X-Timezone' =&gt; 'Asia/Taipei',
            'Authorization' =&gt; 'Bearer {access_token}',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<pre><code class="language-python">import requests
import json

url = 'http://localhost/api/v1/system/parameter/status'
headers = {
  'Accept': 'application/json',
  'Accept-Language': 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
  'X-Timezone': 'Asia/Taipei',
  'Authorization': 'Bearer {access_token}'
}
response = requests.request('GET', url, headers=headers)
response.json()</code></pre>
<blockquote>
<p>Example response (200):</p>
</blockquote>
<pre><code class="language-json">{
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
}</code></pre>
<h3>HTTP Request</h3>
<p><code>GET api/v1/system/parameter/{slug}</code></p>
<h4>URL Parameters</h4>
<table>
<thead>
<tr>
<th>Parameter</th>
<th>Status</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td><code>slug</code></td>
<td>required</td>
<td>Parameter key name</td>
</tr>
</tbody>
</table>
<!-- END_9e89de3e705345bd9134a8c625532693 -->
<h1>User Notify</h1>
<!-- START_649347262cba35069045e3a1a0d3ae4c -->
<h2>My Notify Messages</h2>
<p>Get the messages of the user notification.</p>
<h3>Response Body</h3>
<p>success : true</p>
<p>data :</p>
<table>
<thead>
<tr>
<th>Parameter</th>
<th>Type</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td>id</td>
<td>STR</td>
<td>Notice serial id</td>
</tr>
<tr>
<td>notice.subject</td>
<td>OBJ</td>
<td>Notice message subject</td>
</tr>
<tr>
<td>notice.content</td>
<td>OBJ</td>
<td>Notice message content object</td>
</tr>
<tr>
<td>notice.type</td>
<td>STR</td>
<td>Notice message type code</td>
</tr>
<tr>
<td>notice.type_name</td>
<td>STR</td>
<td>Notice message type name</td>
</tr>
<tr>
<td>read_at</td>
<td>STR</td>
<td>Datetime when the notice was read</td>
</tr>
<tr>
<td>created_at</td>
<td>STR</td>
<td>Datetime when the notice was created</td>
</tr>
</tbody>
</table>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "http://localhost/api/v1/notice" \
    -H "Accept: application/json" \
    -H "Accept-Language: zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2" \
    -H "X-Timezone: Asia/Taipei" \
    -H "Authorization: Bearer {access_token}"</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'http://localhost/api/v1/notice',
    [
        'headers' =&gt; [
            'Accept' =&gt; 'application/json',
            'Accept-Language' =&gt; 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
            'X-Timezone' =&gt; 'Asia/Taipei',
            'Authorization' =&gt; 'Bearer {access_token}',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<pre><code class="language-python">import requests
import json

url = 'http://localhost/api/v1/notice'
headers = {
  'Accept': 'application/json',
  'Accept-Language': 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
  'X-Timezone': 'Asia/Taipei',
  'Authorization': 'Bearer {access_token}'
}
response = requests.request('GET', url, headers=headers)
response.json()</code></pre>
<blockquote>
<p>Example response (200):</p>
</blockquote>
<pre><code class="language-json">{
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
}</code></pre>
<h3>HTTP Request</h3>
<p><code>GET api/v1/notice</code></p>
<!-- END_649347262cba35069045e3a1a0d3ae4c -->
<!-- START_fde37eddda385e6ee7a582ef3cea7af1 -->
<h2>My Unread Notify Messages</h2>
<p>Get the messages of the user unread notification.</p>
<h3>Response Body</h3>
<p>success : true</p>
<p>data :</p>
<table>
<thead>
<tr>
<th>Parameter</th>
<th>Type</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td>id</td>
<td>STR</td>
<td>Notice serial id</td>
</tr>
<tr>
<td>notice.subject</td>
<td>OBJ</td>
<td>Notice message subject</td>
</tr>
<tr>
<td>notice.content</td>
<td>OBJ</td>
<td>Notice message content object</td>
</tr>
<tr>
<td>notice.type</td>
<td>STR</td>
<td>Notice message type code</td>
</tr>
<tr>
<td>notice.type_name</td>
<td>STR</td>
<td>Notice message type name</td>
</tr>
<tr>
<td>read_at</td>
<td>STR</td>
<td>Datetime when the notice was read</td>
</tr>
<tr>
<td>created_at</td>
<td>STR</td>
<td>Datetime when the notice was created</td>
</tr>
</tbody>
</table>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "http://localhost/api/v1/notice/unread" \
    -H "Accept: application/json" \
    -H "Accept-Language: zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2" \
    -H "X-Timezone: Asia/Taipei" \
    -H "Authorization: Bearer {access_token}"</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'http://localhost/api/v1/notice/unread',
    [
        'headers' =&gt; [
            'Accept' =&gt; 'application/json',
            'Accept-Language' =&gt; 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
            'X-Timezone' =&gt; 'Asia/Taipei',
            'Authorization' =&gt; 'Bearer {access_token}',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<pre><code class="language-python">import requests
import json

url = 'http://localhost/api/v1/notice/unread'
headers = {
  'Accept': 'application/json',
  'Accept-Language': 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
  'X-Timezone': 'Asia/Taipei',
  'Authorization': 'Bearer {access_token}'
}
response = requests.request('GET', url, headers=headers)
response.json()</code></pre>
<blockquote>
<p>Example response (200):</p>
</blockquote>
<pre><code class="language-json">{
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
}</code></pre>
<h3>HTTP Request</h3>
<p><code>GET api/v1/notice/unread</code></p>
<!-- END_fde37eddda385e6ee7a582ef3cea7af1 -->
<!-- START_16dd607a882f3cd47fd63438e19600ae -->
<h2>My Unread Notify Counts</h2>
<p>Get the counts of the user unread notification.</p>
<h3>Response Body</h3>
<p>success : true</p>
<p>data :</p>
<table>
<thead>
<tr>
<th>Parameter</th>
<th>Type</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td>count</td>
<td>INT</td>
<td>Unread count</td>
</tr>
</tbody>
</table>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "http://localhost/api/v1/notice/count" \
    -H "Accept: application/json" \
    -H "Accept-Language: zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2" \
    -H "X-Timezone: Asia/Taipei" \
    -H "Authorization: Bearer {access_token}"</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'http://localhost/api/v1/notice/count',
    [
        'headers' =&gt; [
            'Accept' =&gt; 'application/json',
            'Accept-Language' =&gt; 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
            'X-Timezone' =&gt; 'Asia/Taipei',
            'Authorization' =&gt; 'Bearer {access_token}',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<pre><code class="language-python">import requests
import json

url = 'http://localhost/api/v1/notice/count'
headers = {
  'Accept': 'application/json',
  'Accept-Language': 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
  'X-Timezone': 'Asia/Taipei',
  'Authorization': 'Bearer {access_token}'
}
response = requests.request('GET', url, headers=headers)
response.json()</code></pre>
<blockquote>
<p>Example response (200):</p>
</blockquote>
<pre><code class="language-json">{
    "success": true,
    "data": {
        "count": 1
    }
}</code></pre>
<h3>HTTP Request</h3>
<p><code>GET api/v1/notice/count</code></p>
<!-- END_16dd607a882f3cd47fd63438e19600ae -->
<!-- START_66d36a88f2c09a3365595484b0c4d053 -->
<h2>Remove My Read</h2>
<p>Remove read notification messages of the user.</p>
<h3>Response Body</h3>
<p>success : true</p>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X DELETE \
    "http://localhost/api/v1/notice/ddc09c60-8385-4e64-8516-6ba3f6fd6a84" \
    -H "Accept: application/json" \
    -H "Accept-Language: zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2" \
    -H "X-Timezone: Asia/Taipei" \
    -H "Authorization: Bearer {access_token}"</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;delete(
    'http://localhost/api/v1/notice/ddc09c60-8385-4e64-8516-6ba3f6fd6a84',
    [
        'headers' =&gt; [
            'Accept' =&gt; 'application/json',
            'Accept-Language' =&gt; 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
            'X-Timezone' =&gt; 'Asia/Taipei',
            'Authorization' =&gt; 'Bearer {access_token}',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<pre><code class="language-python">import requests
import json

url = 'http://localhost/api/v1/notice/ddc09c60-8385-4e64-8516-6ba3f6fd6a84'
headers = {
  'Accept': 'application/json',
  'Accept-Language': 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
  'X-Timezone': 'Asia/Taipei',
  'Authorization': 'Bearer {access_token}'
}
response = requests.request('DELETE', url, headers=headers)
response.json()</code></pre>
<blockquote>
<p>Example response (200):</p>
</blockquote>
<pre><code class="language-json">{
    "success": true
}</code></pre>
<h3>HTTP Request</h3>
<p><code>DELETE api/v1/notice/{id}</code></p>
<h4>URL Parameters</h4>
<table>
<thead>
<tr>
<th>Parameter</th>
<th>Status</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td><code>id</code></td>
<td>required</td>
<td>Notice serial id</td>
</tr>
</tbody>
</table>
<!-- END_66d36a88f2c09a3365595484b0c4d053 -->
<!-- START_72bef1ddf848d05e292950ad1dc5c9a1 -->
<h2>Remove All My Read</h2>
<p>Remove all read notification messages of the user.</p>
<h3>Response Body</h3>
<p>success : true</p>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X DELETE \
    "http://localhost/api/v1/notice/all" \
    -H "Accept: application/json" \
    -H "Accept-Language: zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2" \
    -H "X-Timezone: Asia/Taipei" \
    -H "Authorization: Bearer {access_token}"</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;delete(
    'http://localhost/api/v1/notice/all',
    [
        'headers' =&gt; [
            'Accept' =&gt; 'application/json',
            'Accept-Language' =&gt; 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
            'X-Timezone' =&gt; 'Asia/Taipei',
            'Authorization' =&gt; 'Bearer {access_token}',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<pre><code class="language-python">import requests
import json

url = 'http://localhost/api/v1/notice/all'
headers = {
  'Accept': 'application/json',
  'Accept-Language': 'zh-TW,zh-CN;q=0.8,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
  'X-Timezone': 'Asia/Taipei',
  'Authorization': 'Bearer {access_token}'
}
response = requests.request('DELETE', url, headers=headers)
response.json()</code></pre>
<blockquote>
<p>Example response (200):</p>
</blockquote>
<pre><code class="language-json">{
    "success": true
}</code></pre>
<h3>HTTP Request</h3>
<p><code>DELETE api/v1/notice/all</code></p>
<!-- END_72bef1ddf848d05e292950ad1dc5c9a1 -->
<h1>Declaration</h1>
<p>This document is written by the development team. </p>
<p>If you have any questions, please ask the relevant person.</p>
<aside style="color:#FFFFFF">
© PROVIDER. ALL RIGHTS RESERVED.
</aside>
      </div>
      <div class="dark-box">
                        <div class="lang-selector">
                                    <a href="#" data-language-name="bash">bash</a>
                                    <a href="#" data-language-name="javascript">javascript</a>
                                    <a href="#" data-language-name="php">php</a>
                                    <a href="#" data-language-name="python">python</a>
                              </div>
                </div>
    </div>
  </body>
</html>