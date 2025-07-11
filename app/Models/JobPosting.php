<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobPosting extends Model
{
    /** @use HasFactory<\Database\Factories\JobPostingFactory> */
    use HasFactory;

    protected $fillable = [
        "title",
        "description",
        "salary",
        "published_at"
    ];

    protected function casts()
    {
        return [
            "published_at" => "datetime"
        ];
    }

    public function scopePublished(Builder $query): void
    {
        $query->whereNotNull("published_at");
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(User::class, "user_id");
    }
}
