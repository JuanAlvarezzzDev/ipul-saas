<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransactionType extends Model
{
    protected $fillable  = ['name', 'active'];

    public function workspace(): BelongsTo{
        return $this->belongsTo(Workspace::class);
    }
    public function transactionsConcepts()
    {
        return $this->hasMany(TransactionConcepts::class, 'transaction_type_id');  // 'transaction_type_id' es la clave foránea en 'transactions'
    }
}
