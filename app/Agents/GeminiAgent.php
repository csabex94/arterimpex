<?php

namespace App\Agents;

use Illuminate\Support\Facades\Http;

class GeminiAgent
{
    protected string $apiKey;
    protected string $baseUrl;

    public function __construct()
    {
        $this->apiKey = env('GEMINI_API_KEY', '');
        $this->baseUrl = env('GEMINI_BASE_URL', '');
    }

    public function ask(string $prompt, string $systemInstruction = 'You are a helpful assistant.')
    {
        // A Gemini 2.0 Flash modell használata (vagy amit a ListModels megenged)
        // $model = 'gemini-3.1-flash-lite-preview';
        $model = 'gemini-2.5-flash-lite';

        $response = Http::post("{$this->baseUrl}{$model}:generateContent?key={$this->apiKey}", [
            'contents' => [
                [
                    'role' => 'user',
                    'parts' => [['text' => $prompt]]
                ]
            ],
            'system_instruction' => [
                'parts' => [['text' => $systemInstruction]]
            ],
            'generationConfig' => [
                'temperature' => 0.7,
                'maxOutputTokens' => 1800,
                'topP' => 0.8, // Focuses on the top 80% of probability mass
                'topK' => 40,  // Limits the pool to the top 40 most likely words
            ]
        ]);

        if ($response->failed()) {
            return "Hiba: " . $response->json('error.message', 'Ismeretlen hiba történt.');
        }

        return $response->json('candidates.0.content.parts.0.text');
    }
}
