<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\AttendanceController;
use Illuminate\Http\Request;

class SendAbsenceNotifications extends Command
{
    protected $signature = 'attendance:send-absence-notifications';
    protected $description = 'Send automatic absence notifications at 8:00 AM';

    public function handle()
    {
        $controller = new AttendanceController();
        $request = new Request();
        
        $response = $controller->checkAndSendNotifications($request);
        $result = json_decode($response->getContent(), true);
        
        if ($result['success']) {
            $this->info($result['message']);
            if (isset($result['details'])) {
                $this->info('Detalles: ' . json_encode($result['details']));
            }
        } else {
            $this->error($result['message']);
        }
    }
}