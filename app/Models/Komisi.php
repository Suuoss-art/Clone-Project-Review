<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Komisi extends Model
{
    use HasFactory;

    protected $table = 'project_commissions';

    protected $fillable = [
        'project_id',
        'project_personel_id',
        'user_id',
        'margin',
        'persentase',
        'nilai_komisi'
    ];

    public function projectPersonel()
    {
        return $this->belongsTo(ProjectPersonel::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

}
