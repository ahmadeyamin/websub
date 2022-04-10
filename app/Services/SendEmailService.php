<?php

namespace App\Services;

use App\Models\Post;
use App\Models\User;
use App\Models\Website;
use App\Notifications\NewPostEmailNotification;

class SendEmailService{

    public $post_id;
    public $website_id;

    public function __construct($post_id, $website_id) {
        $this->post_id = $post_id;
        $this->website_id = $website_id;
    }


    public function sendMail()
    {
        $post = Post::find($this->post_id);
        $website = Website::find($this->website_id);

        // $post->notify();

        $website->users()->each(function (User $user) use ($post) {
            $user->notify(new NewPostEmailNotification($post));
        });

        $post->is_notified = true;
        $post->save();

        return true;
    }
}