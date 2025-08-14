<?php

namespace App\Listeners;

use App\Events\CommissionSubmitted;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CommissionNotificationListener implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(CommissionSubmitted $event): void
    {
        // Get all HOD users
        $hodUsers = User::where('role', 'hod')->where('is_active', 1)->get();

        foreach ($hodUsers as $hod) {
            Notification::create([
                'user_id' => $hod->id,
                'message' => "Komisi baru telah diinput oleh PM {$event->pm->name} untuk proyek '{$event->project->judul}'. Total margin: Rp " . number_format($event->commissionData['margin'] ?? 0, 0, ',', '.'),
                'is_read' => false,
                'type' => 'commission_submitted',
                'data' => json_encode([
                    'project_id' => $event->project->id,
                    'project_title' => $event->project->judul,
                    'pm_id' => $event->pm->id,
                    'pm_name' => $event->pm->name,
                    'margin' => $event->commissionData['margin'] ?? 0,
                    'commission_count' => count($event->commissionData['komisi'] ?? []),
                ])
            ]);
        }
    }
}