<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'jenis_dokumen',
        'file_path',
        'nama_asli',
        'keterangan',
        'status',
        'approved_at',
        'approved_by'
    ];

    protected $casts = [
        'approved_at' => 'datetime',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
