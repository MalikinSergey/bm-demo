<?php

namespace App\Models;

use App\Helpers\EnsureSlug;
use App\Services\TwoCheckout;
use App\Support\Archievable;
use App\Support\HasLicense;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Class Family
 * @package App\Models
 *
 *
 * @method Builder active()
 * @method Builder icons()
 * @method Builder illustrations()
 */
class Family extends \Eloquent implements Downloable
{
    use EnsureSlug, Archievable;

    /**
     * @type string
     */
    protected $table = "families";

    /**
     * @type array
     */
    protected $guarded = ['id'];

    /**
     * @type array
     */
    protected $fillable = [
        'name',
        'type',
        'price_personal',
        'price_commercial',
        'price_commercial_ext',
        'slug',
        'data',
        'status',
        'position'
    ];

    protected $visible = [
        'id',
        'name',
        'type',
        'type_plural',
        'slug'
    ];

    protected $appends = [
        'type_plural'
    ];

    /**
     * @type array
     */
    protected $casts = [];

    /**
     * @type array
     */
    protected $dates = [];

    /**
     * @type bool
     */
    public $timestamps = true;

    public function uploads()
    {
        return $this->hasMany(Upload::class)->latest();
    }

    public function assets()
    {
        return $this->hasMany(Asset::class);
    }

    public function packs()
    {
        return $this->hasMany(Pack::class);
    }

    public function url()
    {
        return route('website.family.show', $this->slug);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeIcons($query)
    {
        return $query->where('type', 'icon');
    }

    public function scopeIllustrations($query)
    {
        return $query->where('type', 'illustration');
    }

    public function getTypePlural()
    {
        return $this->type . "s";
    }

    public function typePlural(): Attribute
    {
        return Attribute::make(get: fn() => $this->type . "s");
    }

    public function uploadCover(UploadedFile $cover)
    {
        Storage::disk('public')->putFileAs('covers/', $cover, $this->slug . ".svg");
    }

    public function hasCover()
    {
        return Storage::disk('public')->exists('covers/' . $this->slug . ".svg");
    }

    public function getCoverUrl()
    {
        return Storage::disk('public')->url('covers/' . $this->slug . ".svg");
    }

    public function getPrice($type)
    {
        if ($this->{"price_" . $type}) {
            return $this->{"price_" . $type};
        }

        $d = 0.2;

        switch ($type) {
            case "personal":
                $m = 1;
                break;
            case "commercial":
                $m = 2;
                break;
            case "commercial_ext":
                $m = 10;
                break;
        }

        $count = $this->assets()->count();

        $assetPrice = config('boykomarket.prices.' . $this->type . '.personal');

        $price = $count * $assetPrice * $d * $m;

        $price = floor($price);

        return $price;
    }

    public function users()
    {
        return $this->morphToMany(User::class, 'purchase')
            ->withTimestamps()
            ->withPivot('license', 'created_at', 'updated_at')
            ->using(Purchase::class);
    }

    public function downloadDir()
    {
        return "families/" . $this->slug;
    }

    public function downloadPath()
    {
        return $this->downloadDir() . "/" . $this->downloadName();
    }

    public function downloadName()
    {
        return $this->slug . ".zip";
    }


    public function hasLicense($user, $type = false)
    {
        if (!$user) {
            return false;
        }

        foreach ($this->users as $buyer) {
            if ($user->id === $buyer->id && (!$type || $type === $buyer->pivot->license)) {
                return true;
            }
        }

        return false;
    }


    public function itemType()
    {
        return 'family';
    }


    public function downloadLink()
    {
        return route('website.family.download', $this->slug);
    }

    public function paymentLink($licenseType)
    {
        $params = [
            'merchant' => '250347688076',
            'nodata' => 1,
            'pay_type' => 'paypal',
            'dynamic' => '1',
            'currency' => 'USD',
            'type' => 'digital',
            'qty' => '1',
            'return-url' => route('website.family.show', [$this->slug]),
            'return-type' => 'redirect',
            'item-ext-ref' => 'family_' . $this->id . '_' . $licenseType,
            'prod' => $this->name . " ({$this->type})",
            'price' => $this->getPrice($licenseType)
        ];

        if (config('boykomarket.test_payment_mode')) {
            $params['test'] = '1';
        }

        $sign = app(TwoCheckout::class)->sign($params);

        $params['signature'] = $sign;

        $link = 'https://secure.2checkout.com/checkout/buy?' . http_build_query($params);

        return $link;
    }
}
