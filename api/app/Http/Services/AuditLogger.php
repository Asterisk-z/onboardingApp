<?php
// app/Services/AuditLogger.php

namespace App\Services;

use App\Models\Audit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class AuditLogger
{
    public static function logActivity(string $user, string $actionPerformed, string $actionTime, string $ipAddress)
    {
        // Logic to log activities into the 'audits' table
        $user = Auth::user()->email;
        $actionTime = now();
        $userIp = Request::ip();

        Audit::create([
            'user' => $user,
            'action_performed' => $actionPerformed,
            'action_time' => $actionTime,
            'ip_address' => $userIp
        ]);
    }
}
