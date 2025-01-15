<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReferredLink extends Model
{
    protected $fillable = ['user_id', 'link_id', 'slug','short_links', 'clicks', 'is_active'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function link()
    {
        return $this->belongsTo(Link::class);
    }
}
