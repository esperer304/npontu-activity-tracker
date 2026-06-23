<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityUpdate extends Model
{
    use HasFactory;

    public const STATUS_DONE = 'done';
    public const STATUS_PENDING = 'pending';

    public const STATUSES = [self::STATUS_DONE, self::STATUS_PENDING];

    protected $fillable = [
        'activity_id',
        'user_id',
        'status',
        'remark',
    ];

    public function activity(): BelongsTo
    {
        return $this->belongsTo(Activity::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
