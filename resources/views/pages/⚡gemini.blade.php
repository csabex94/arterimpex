<?php

use Livewire\Component;
use App\Agents\GeminiAgent;

new class extends Component {
    public string $prompt = '';

    public string $response = '';

    public function handlePrompt(GeminiAgent $agent)
    {
        $response = $agent->ask(prompt: $this->prompt, systemInstruction: 'Te egy profi Laravel fejlesztő vagy. Válaszolj röviden és magyarul.');

        $this->response .= "\n $response";
        $this->prompt = '';
    }
};
?>

<div class="flex flex-col gap-5">
    <div class="flex items-start w-full justify-center">
        <flux:textarea wire:model='prompt' placeholder="Adjon utasitast a Gemininek" class="min-w-5xl" rows="auto" />
        <flux:button wire:click='handlePrompt' icon="paper-airplane" class='p-5 ms-4' variant="primary" />
    </div>
    @if (strlen($response) > 0)

        <div class="prose prose-slate max-w-none dark:prose-invert">
            @markdown($response)
        </div>
    @endif
</div>
