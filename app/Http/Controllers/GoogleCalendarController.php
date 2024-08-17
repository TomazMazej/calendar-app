<?php

namespace App\Http\Controllers;

use App\Services\GoogleCalendarService;
use Illuminate\Http\Request;

class GoogleCalendarController extends Controller{
    protected $googleCalendarService;

    public function __construct(GoogleCalendarService $googleCalendarService){
        $this->googleCalendarService = $googleCalendarService;
    }

    public function redirectToGoogle(){
        $authUrl = $this->googleCalendarService->getClient()->createAuthUrl();
        return redirect($authUrl);
    }

    public function handleGoogleCallback(Request $request){
        $this->googleCalendarService->getClient()->fetchAccessTokenWithAuthCode($request->code);
        session(['google_access_token' => $this->googleCalendarService->getClient()->getAccessToken()]);
        return redirect('/events');
    }

    public function listEvents(){
        $this->googleCalendarService->fetchCalendarEvents();
        return view('events');
    }

    public function refreshEvents(){
        $this->googleCalendarService->fetchCalendarEvents();
    }
}