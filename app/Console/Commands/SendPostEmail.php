<?php

namespace App\Console\Commands;

use App\Models\Post;
use App\Models\Website;
use App\Services\SendEmailService;
use Illuminate\Console\Command;

class SendPostEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'post:notify {domain}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Notification to a specific website subscriber';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $domain = $this->argument('domain');
        
        $website = Website::where('domain', $domain)->first();

        if (!$website) {
            return $this->error('Website not found');
        }

        Post::where('website_id', $website->id)
        ->where('is_notified',false)
        ->get()
        ->each(function ($post) {
            // $post->notify();

            $send_service = new SendEmailService($post->id, $post->website_id);
            $send_service->sendMail();

            
        });
        return 0;
    }
}
