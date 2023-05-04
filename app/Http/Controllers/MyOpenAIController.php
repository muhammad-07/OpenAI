<?php

namespace App\Http\Controllers;

use App\Models\MyOpenAI;
use Illuminate\Http\Request;
use OpenAI;

class MyOpenAIController extends Controller
{

    public function wishper()
    {
        if (!file_exists(public_path('muhammad.mp3')))
            die("input file not found");

        $ApiKey = env('OPENAI_API_KEY');
        $client = OpenAI::client($ApiKey);
        // $client = OpenAI::factory()
        //     ->withApiKey($ApiKey)

        //     ->withHttpClient($client = new \GuzzleHttp\Client(['defaults' => [
        //         'verify' => false
        //     ]])) // default: HTTP client found using PSR-18 HTTP Client Discovery

        //     ->make();
        $response = $client->audio()->transcribe([
            'model' => 'whisper-1',
            'file' => fopen('muhammad.mp3', 'r'),
            'response_format' => 'verbose_json',
        ]);

        $response->task; // 'transcribe'
        $response->language; // 'english'
        $response->duration; // 2.95
        $response->text; // 'Hello, how are you?'

        // foreach ($response->segments as $segment) {
        //     $segment->index; // 0
        //     $segment->seek; // 0
        //     $segment->start; // 0.0
        //     $segment->end; // 4.0
        //     $segment->text; // 'Hello, how are you?'
        //     $segment->tokens; // [50364, 2425, 11, 577, 366, 291, 30, 50564]
        //     $segment->temperature; // 0.0
        //     $segment->avgLogprob; // -0.45045216878255206
        //     $segment->compressionRatio; // 0.7037037037037037
        //     $segment->noSpeechProb; // 0.1076972484588623
        //     $segment->transient; // false
        // }

        return $response->toArray(); // ['task' => 'transcribe', ...]
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $search = "What is Laravel?";

        $client = new Client();
        $response = $client->post('https://api.openai.com/v1/chat/completions', [
            'verify' => false,

            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
            ],
            'json' => [
                // 'prompt' => $search, //$request->input('message'),
                'temperature' => 0.7,
                "model" => "gpt-3.5-turbo",
                'messages' => [
                    [
                        "role" => "user",
                        "content" => $search
                    ]
                ],
                'max_tokens' => 60,
                'top_p' => 1,
                'n' => 1,
                'stop' => ['\n'],
            ],
        ]);
        $result = json_decode($response->getBody()->getContents(), true);
        return response()->json($result['choices'][0]['message']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(MyOpenAI $myOpenAI)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MyOpenAI $myOpenAI)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MyOpenAI $myOpenAI)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MyOpenAI $myOpenAI)
    {
        //
    }
}
