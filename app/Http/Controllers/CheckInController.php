<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\SlackNotification;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class CheckInController extends Controller
{
    public function get() {

        // Notification::route('slack', env('SLACK_WEBHOOK_URL'))
        // ->notify(new SlackNotification(123));
        $url = 'https://taskmanagement.d-soft.tech/web/dataset/call_kw/hr.employee/search_read';

        $headers = [
            'authority' => 'taskmanagement.d-soft.tech',
            'accept' => '*/*',
            'accept-encoding' => 'gzip, deflate, br',
            'accept-language' => 'vi,en-US;q=0.9,en;q=0.8',
            'content-length' => '264',
            'content-type' => 'application/json',
            'cookie' => 'cids=1; visitor_uuid=d59be1d43f51464fb9c56baf77ad499f; frontend_lang=en_US; tz=Asia/Saigon; session_id=bf1a5fc4f024ecd89e0f7a3a8c1a0458e4fdf4a6',
            'origin' => 'https://taskmanagement.d-soft.tech',
            'referer' => 'https://taskmanagement.d-soft.tech/web',
            'sec-ch-ua' => '"Chromium";v="112", "Google Chrome";v="112", "Not:A-Brand";v="99"',
            'sec-ch-ua-mobile' => '?0',
            'sec-ch-ua-platform' => '"Windows"',
            'sec-fetch-dest' => 'empty',
            'sec-fetch-mode' => 'cors',
            'sec-fetch-site' => 'same-origin',
            'user-agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36',
        ];

        $data = [
            'jsonrpc' => '2.0',
            'method' => 'call',
            'params' => [
                'model' => 'hr.employee',
                'method' => 'search_read',
                'args' => [
                    [
                        ['user_id', '=', 133],
                    ],
                    ['attendance_state', 'name', 'hours_today'],
                ],
                'kwargs' => [
                    'context' => [
                        'lang' => 'en_US',
                        'tz' => 'Asia/Bangkok',
                        'uid' => 133,
                        'allowed_company_ids' => [1],
                    ],
                ],
            ],
        ];
        $client = new Client();
        $response = $client->post($url, [
            'headers' => $headers,
            'json' => $data,
        ]);
    
        $body = $response->getBody()->getContents();

        $body = json_decode($body, true);

        return $body;
        return $body['result'][0]['name'];
    }
}
