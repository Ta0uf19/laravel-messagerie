<?php

namespace App;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'messages';
    protected $fillable = [
        'content', 'from_id', 'to_id', 'read_at', 'created_at',
    ];

    public $timestamps = false;
    protected $dates = ['created_at', 'read_at'];

    /**
     * Récupérer le message qui appartient à Utilisateur.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'from_id');
    }

    /**
     * Timezone dans la date.
     *
     * @param DateTimeInterface $date
     *
     * @return string
     */
    public function serializeDate(DateTimeInterface $date)
    {
        return $date->format('c');
    }
}
