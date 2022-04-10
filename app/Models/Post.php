<?php

namespace App\Models;

use App\Services\SendEmailService;
use Illuminate\Database\Eloquent\Model;
use App\Notifications\NewPostEmailNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    
    protected $guarded = ['id'];

    public static function boot()
    {
        parent::boot();
        self::created(function($model){
            $send_service = new SendEmailService($model->id, $model->website_id);
            $send_service->sendMail();
        });
    }

    public function website()
    {
        return $this->belongsTo(Website::class);
    }
}
