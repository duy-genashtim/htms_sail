<?php 
namespace App\Services;

use Illuminate\Support\Facades\Http;

class GraphMailer
{
    protected $tenantId;
    protected $clientId;
    protected $clientSecret;
    protected $baseUrl;
    protected $token;

    public function __construct() {
        $this->tenantId = env('MSGRAPH_TENANT_ID');
        $this->clientId = env('MSGRAPH_CLIENT_ID');
        $this->clientSecret = env('MSGRAPH_SECRET_ID');
        $this->baseUrl = 'https://graph.microsoft.com/v1.0/';
        $this->token = $this->getToken();
    }

    public function getToken() {
        $response = Http::asForm()->post("https://login.microsoftonline.com/{$this->tenantId}/oauth2/v2.0/token", [
            'client_id' => $this->clientId,
            'scope' => 'https://graph.microsoft.com/.default',
            'client_secret' => $this->clientSecret,
            'grant_type' => 'client_credentials',
        ]);

        return $response->json()['access_token'];
    }

    public function getMessages($mailbox) {
        // $token = $this->getToken();

        if (! $this->token ) {
            throw new \Exception('No token defined');
        }

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' .  $this->token ,
            'Content-Type' => 'application/json'
        ])->get($this->baseUrl . "users/{$mailbox}/mailFolders/Inbox/Messages");

        $messageList = $response->json();

        if (isset($messageList['error'])) {
            throw new \Exception($messageList['error']['code'] . ' ' . $messageList['error']['message']);
        }

        // Process messages as needed
        return $messageList;
    }

    public function getAvatarImage($email){
        $url = $this->baseUrl . 'users/' . $email . '/photo/$value';
        return $this->sendGetRequest($url);
    }

    public function sendPostRequest($url, $fields, $headers = []) {
        // $token = $this->getToken();
        $headers = array_merge([
            'Authorization' => 'Bearer ' . $this->token ,
            'Content-Type' => 'application/json'
        ], $headers);

        $response = Http::withHeaders($headers)->post($url, $fields);

        return [
            'code' => $response->status(),
            'data' => $response->json()
        ];
    }

    // Sending a GET request using Laravel's HTTP Client
    public function sendGetRequest($url) {
        return  Http::withHeaders([
            'Authorization' => 'Bearer ' .  $this->token,
            'Content-Type' => 'application/json'
        ])->get($url);

        // $response->json();
    }
}