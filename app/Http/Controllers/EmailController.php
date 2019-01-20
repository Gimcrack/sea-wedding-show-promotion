<?php

namespace App\Http\Controllers;

use App\Mail\SurveyResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function store()
    {
        Mail::to(config('mail.to'))
            ->send( new SurveyResponse(request()->all()));
    }
}
