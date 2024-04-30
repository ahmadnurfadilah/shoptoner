<?php

namespace App\Models\Payment;

use App\Models\Product\ProductUser;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Payment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'trx_id',
        'user_id',
        'amount',
        'total_amount',
        'surcharge',
        'note',
        'boc',
        'status',
        'due_at',
        'paid_at',
    ];

    protected $casts = [
        'surcharge' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(PaymentItem::class, 'payment_id');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function setPending()
    {
        $this->attributes['status'] = 'pending';
        $this->save();
    }

    public function setExpired()
    {
        if ($this->attributes['status'] != 'success') {
            $this->attributes['status'] = 'expired';
        }
        $this->save();
    }

    public function setFailed()
    {
        if ($this->attributes['status'] != 'success') {
            $this->attributes['status'] = 'failed';
        }
        $this->save();
    }

    public function setCanceled()
    {
        if ($this->attributes['status'] === 'pending') {
            $this->attributes['status'] = 'canceled';
        }
    }

    public function setSuccess()
    {
        if ($this->attributes['status'] !== 'pending') {
            return;
        }

        DB::transaction(function () {
            $this->attributes['status'] = 'success';
            if ($this->paid_at == null) {
                $this->attributes['paid_at'] = now();
            }

            foreach ($this->items as $item) {
                if ($item->payable_type == 'product') {
                    ProductUser::updateOrCreate([
                        'product_id' => $item->payable_id,
                        'user_id' => $item->user_id,
                    ], [
                        'updated_at' => now(),
                    ]);
                }
            }
            $this->save();
        });
    }
}
