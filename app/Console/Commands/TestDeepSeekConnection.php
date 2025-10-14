<?php
// app/Console/Commands/TestDeepSeekConnection.php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TestDeepSeekConnection extends Command
{
    protected $signature = 'deepseek:test';
    protected $description = 'Test koneksi OpenRouter API dengan model DeepSeek';

    public function handle()
    {
        $apiKey = config('services.deepseek.api_key');
        $baseUrl = config('services.deepseek.base_url');
        
        $this->info("🔍 Checking OpenRouter Configuration...");
        $this->line("API Key: " . ($apiKey ? '✅ Set' : '❌ Missing'));
        $this->line("Base URL: " . $baseUrl);

        if (!$apiKey) {
            $this->error('❌ OPENROUTER_API_KEY tidak ditemukan di .env file');
            $this->line('💡 Tambahkan ini ke .env file:');
            $this->line('OPENROUTER_API_KEY=your_openrouter_api_key_here');
            return 1;
        }

        $this->info("\n🚀 Testing OpenRouter API Connection with DeepSeek Model...");

        try {
            $response = Http::timeout(30)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $apiKey,
                    'HTTP-Referer' => config('app.url'), // Required by OpenRouter
                    'X-Title' => 'Meal Planner App', // Required by OpenRouter
                    'Content-Type' => 'application/json',
                ])->post($baseUrl . '/chat/completions', [
                    'model' => 'deepseek/deepseek-chat', // Model melalui OpenRouter
                    'messages' => [
                        [
                            'role' => 'user',
                            'content' => 'Hello, please respond with "OK" if you can read this.'
                        ]
                    ],
                    'max_tokens' => 10,
                ]);

            $this->info("📊 Response Status: " . $response->status());
            
            if ($response->successful()) {
                $data = $response->json();
                $this->info('✅ OpenRouter API Connection Successful!');
                $this->info('🤖 AI Response: ' . ($data['choices'][0]['message']['content'] ?? 'No content'));
                $this->info('🔧 Model: ' . ($data['model'] ?? 'Unknown'));
            } else {
                $this->error('❌ API Error: ' . $response->body());
                
                // Detailed error analysis
                $status = $response->status();
                switch ($status) {
                    case 401:
                        $this->error('💡 Error 401: API Key tidak valid');
                        $this->line('   Dapatkan API key dari: https://openrouter.ai/keys');
                        break;
                    case 402:
                        $this->error('💡 Error 402: Payment required - top up credit di OpenRouter');
                        break;
                    case 404:
                        $this->error('💡 Error 404: Model tidak ditemukan');
                        break;
                    case 429:
                        $this->error('💡 Error 429: Rate limit exceeded');
                        break;
                    default:
                        $this->error("💡 Error {$status}: Unknown error");
                }
            }

        } catch (\Exception $e) {
            $this->error('❌ Exception: ' . $e->getMessage());
            $this->line('💡 Check your internet connection and API endpoint');
        }

        return 0;
    }
}