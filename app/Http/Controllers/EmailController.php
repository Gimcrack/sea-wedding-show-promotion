<?php

namespace App\Http\Controllers;

use App\Mail\SurveyResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function store()
    {
        Mail::to('jeremy@jeremybloomstrom.com')
            ->send( new SurveyResponse(request()->all()));
    }
}
