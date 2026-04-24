<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Agents\GeminiAgent;

class AiAgentsController extends Controller
{
    public function weather(Request $request, GeminiAgent $agent)
    {
        $response = $agent->ask(
            prompt: "Hany ora van Romania, Harghita, Gheorgheni?",
            systemInstruction: 'Te egy profi Laravel fejlesztő vagy. Válaszolj röviden és magyarul.'
        );

        return response()->json(['reply' => $response], 200, [], JSON_UNESCAPED_UNICODE);
    }
}
