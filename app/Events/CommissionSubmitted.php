<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Project;
use App\Models\User;

class CommissionSubmitted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $project;
    public $pm;
    public $commissionData;

    /**
     * Create a new event instance.
     */
    public function __construct(Project $project, User $pm, array $commissionData)
    {
        $this->project = $project;
        $this->pm = $pm;
        $this->commissionData = $commissionData;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('hod-notifications'),
        ];
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'commission.submitted';
    }

    /**
     * Get the data to broadcast.
     */
    public function broadcastWith(): array
    {
        return [
            'project_id' => $this->project->id,
            'project_title' => $this->project->judul,
            'pm_name' => $this->pm->name,
            'commission_count' => count($this->commissionData),
            'total_margin' => $this->commissionData['margin'] ?? 0,
            'timestamp' => now()->toISOString(),
        ];
    }
}