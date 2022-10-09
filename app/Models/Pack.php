<?php

namespace App\Models;

use App\Helpers\EnsureSlug;
use App\Support\Archievable;
use DB;
use Eloquent;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin Eloquent
 */
class Pack extends Model
{

    use EnsureSlug, Archievable;

    /**
     * @type string
     */
    protected $table = "packs";

    /**
     * @type array
     */
    protected $guarded = ['id'];

    /**
     * @type array
     */
    protected $fillable = [
        'name',
        'slug',
        'data',
        'status',
        'position',
        'price_personal',
        'price_commercial',
        'price_commercial_ext',
        'purpose'
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

    protected function type(): Attribute
    {
        return Attribute::make(get: fn() => $this->family->type);
    }

    protected static function booted()
    {
        static::saved(
            function ($pack) {
                $pack->updateSearchContent();
            }
        );
    }

    public function updateSearchContent()
    {
        $tags = $this->assets()->with('tags')->get()
            ->pluck('tags')->flatten()->pluck('name')->unique()->join(' ');

        $name = bm_slug($this->name, ' ');

        DB::statement(
            "UPDATE packs SET 
                  search_content = setweight(to_tsvector('english', ?), 'A') || setweight(to_tsvector('english', ?), 'B') 
                    where id = ?",
            [$name, $tags, $this->id]
        );
    }

    public function assets()
    {
        return $this->belongsToMany(Asset::class);
    }

    public function family()
    {
        return $this->belongsTo(Family::class);
    }

    public function url()
    {
        return route('website.pack.show', [$this->family->slug, $this->slug]);
    }

    public function scopeTypeOf($q, $type)
    {
        $q->whereIn(
            'family_id',
            fn($sq) => $sq->select('id')->from('families')->where('type', $type)
        );

        return $q;
    }

    public function getPrice($type)
    {
        if ($this->{"price_" . $type}) {
            return $this->{"price_" . $type};
        }

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

        $price = $count * $assetPrice * $m * $this->getDiscountMultiplier($type);

        $price = floor($price);

        return $price;
    }

    public function getDiscountMultiplier()
    {
        $d = 0.45;

        $count = $this->assets()->count();

        $e = 1;

        if ($count >= 20) {
            $e = 0.75;
        }

        if ($count >= 30) {
            $e = 0.5;
        }

        return $d * $e;
    }

    public function getDiscountPercent()
    {
        return ceil((1 - $this->getDiscountMultiplier()) * 100);
    }

    public function getTypePlural()
    {
        return $this->type . "s";
    }

    public function users()
    {
        return $this->morphToMany(User::class, 'purchase')->using(Purchase::class);
    }

    public function downloadDir()
    {
        return "families/" . $this->slug . "/packs/";
    }

    public function downloadPath()
    {
        return $this->downloadDir() . "/" . $this->downloadName();
    }

    public function downloadName()
    {
        return $this->slug . ".zip";
    }

    public function downloadLink()
    {
        return route('website.pack.download', [$this->family->slug, $this->slug]);
    }

    public function hasLicense($user, $type = false)
    {
        if (!$user) {
            return false;
        }

        // сперва проверяем, может есть лицензия на всё семейство
        $family = $this->family;

        foreach ($family->users as $buyer) {
            if ($user->id === $buyer->id && (!$type || $type === $buyer->pivot->license)) {
                return true;
            }
        }

        // а затем на сам пак
        foreach ($this->users as $buyer) {
            if ($user->id === $buyer->id && (!$type || $type === $buyer->pivot->license)) {
                return true;
            }
        }

        return false;
    }

    public function itemType()
    {
        return 'pack';
    }

}

