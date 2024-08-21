<?php

namespace App\Services;

use Google\Client;
use Google\Service\Calendar;
use App\Models\Event;

class GoogleCalendarService{
    protected $client;

    public function __construct(){
        $this->client = new Client();
        $this->client->setAuthConfig(storage_path('app/credentials.json'));
        $this->client->addScope(Calendar::CALENDAR_READONLY);
        $this->client->setRedirectUri(config('app.url') . '/auth/google/callback');
    }

    public function getClient(){
        return $this->client;
    }

    public function handleGoogleCallback(Request $request){
        $token = $this->googleCalendarService->getClient()->fetchAccessTokenWithAuthCode($request->code);
        session(['google_access_token' => $token]);
    
        return redirect('/events');
    }
    
    public function fetchCalendarEvents() {
        try {
            $accessToken = session('google_access_token');
    
            if (!$accessToken) {
                throw new \Exception('No access token found');
            }
    
            $this->client->setAccessToken($accessToken);
    
            if ($this->client->isAccessTokenExpired()) {
                $this->client->fetchAccessTokenWithRefreshToken($this->client->getRefreshToken());
                session(['google_access_token' => $this->client->getAccessToken()]);
            }
    
            $service = new \Google_Service_Calendar($this->client);
            $calendarId = 'primary';
            $events = $service->events->listEvents($calendarId);
    
            $fetchedEventIds = [];
    
            foreach ($events->getItems() as $event) {
                $startDateTime = $event->getStart()->getDateTime();
                $startDate = $event->getStart()->getDate();
    
                $date = $startDateTime ?: $startDate;
    
                if ($startDateTime) {
                    $date = (new \DateTime($startDateTime))->format('Y-m-d H:i:s');
                } elseif ($startDate) {
                    $date = (new \DateTime($startDate))->format('Y-m-d 00:00:00');
                }
    
                $fetchedEventIds[] = $event->id;
    
                Event::updateOrCreate(
                    ['event_id' => $event->id],
                    [
                        'title' => $event->getSummary(),
                        'description' => $event->getDescription(),
                        'date' => $date,
                    ]
                );
            }
            Event::whereNotIn('event_id', $fetchedEventIds)->delete();
        } catch (\Exception $e) {
            \Log::error('Error fetching calendar events: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch events'], 500);
        }
    }
}