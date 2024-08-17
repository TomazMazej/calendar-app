<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\GoogleCalendarService;

class FetchCalendarEvents extends Command{
    protected $signature = 'calendar:fetch-events';
    protected $description = 'Fetch calendar events from Google Calendar';

    protected $googleCalendarService;

    public function __construct(GoogleCalendarService $googleCalendarService){
        parent::__construct();
        $this->googleCalendarService = $googleCalendarService;
    }

    public function handle(){
        $this->info('Fetching calendar events...');
        $this->googleCalendarService->fetchCalendarEvents();
        $this->info('Calendar events fetched successfully.');
    }
}