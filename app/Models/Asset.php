<?php

namespace App\Models;

use App\Helpers\EnsureSlug;
use App\Services\TwoCheckout;
use App\Support\Archievable;
use Eloquent;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Stringy\StaticStringy;

/**
 * @mixin Eloquent
 */
class Asset extends Model
{
    use EnsureSlug, Archievable;

    /**
     * @type string
     */
    protected $table = "assets";

    /**
     * @type array
     */
    protected $guarded = ['id'];

    /**
     * @type array
     */
    protected $fillable = [
        'id',
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
        'name',
        'type',
        'slug',
        'preview_url_w128',
        'preview_url_w512',
        'url_show',
        'purpose'
    ];

    protected $appends = ['preview_url_w128', 'preview_url_w512', 'url_show'];

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

    protected static function booted()
    {
        static::saved(
            function ($asset) {
                $asset->updateSearchContent();
            }
        );
    }

    protected function type(): Attribute
    {
        return Attribute::make(get: fn() => $this->family->type);
    }

    public function updateSearchContent()
    {
        $tags = $this->tags()->pluck('name')->join(' ');

        $name = bm_slug($this->name, ' ');

        \DB::statement(
            "UPDATE assets SET
                  search_content = setweight(to_tsvector('english', ?), 'A') || setweight(to_tsvector('english', ?), 'B')
                    where id = ?",
            [$name, $tags, $this->id]
        );
    }

    public function uploads()
    {
        return $this->belongsToMany(Upload::class);
    }

    public function packs()
    {
        return $this->belongsToMany(Pack::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function family()
    {
        return $this->belongsTo(Family::class);
    }

    public function path()
    {
        return $this->family_id . "/" . $this->id;
    }

    public function previewDir()
    {
        return "previews/" . $this->family->slug;
    }

    public function makePng()
    {
        if ($this->testPng()) {
            return;
        }

        shell_exec('convert-svg-to-png ' . Storage::disk('assets')->path($this->path()) . ' --width 1200');

        Storage::disk('assets')->setVisibility($this->path() . ".png", "public");

        if (!$this->testPng()) {
            $this->download_status = 'error';
        } else {
            $this->download_status = 'ok';
        }

        $this->save();
    }


    public function testPng()
    {
        return Storage::disk('assets')->exists($this->path() . ".png");
    }

    public function testPngPreview($width)
    {
        return Storage::disk('public')->exists($this->previewDir() . "/" . $this->id . "_w{$width}.png");
    }

    public function makePngPreviews($widths)
    {
        Storage::disk('public')->makeDirectory($this->previewDir());

        $source = Storage::disk('assets')->path($this->path());

        foreach ($widths as $width) {
            if ($this->testPngPreview($width)) {
                continue;
            }

            $tempFile = $source . ".png";

            $file = Storage::disk('public')->path($this->previewDir() . "/" . $this->id . "_w{$width}.png");

            try {
                $command = 'convert-svg-to-png ' . $source . ' --width ' . $width . ' 2>&1';

                $result = shell_exec($command);

                rename($tempFile, $file);
                $this->preview_status = 'ok';
            } catch (\Exception $e) {
                $this->preview_status = 'error';
                $message = "Make PNG preview error";
                bm_log($message, $this, ['widths' => $widths], 'error');
                break;
            }
        }

        $this->save();
    }

    public function previewName($width)
    {
        return $this->id . "_w" . $width . ".png";
    }

    public function previewUrl($width)
    {
//        return route('website.asset.inline', [$this->family->slug, $this->slug]);
        return Storage::disk('public')->url($this->previewDir() . "/" . $this->previewName($width));
    }

    public function getName()
    {
        $name = str_replace(array_keys(['.svg' => '', '-' => ' ']), array_values(['.svg' => '', '-' => ' ']), $this->name);

        return StaticStringy::upperCaseFirst($name);
    }

    public function url($type = 'svg')
    {
        return "/assets/" . $this->family->slug . "/" . $this->slug . "." . $type;
    }

    public static function suggestName($original)
    {
        $name = str_replace('.svg', '', $original);
        $name = str_replace('-', ' ', $name);
        $name = str_replace('_', ' ', $name);

        $name = StaticStringy::upperCaseFirst($name);

        return $name;
    }

    public function scopeTypeOf($q, $type)
    {
        $q->whereIn(
            'family_id',
            fn($sq) => $sq->select('id')->from('families')->where('type', $type)
        );

        return $q;
    }

    public function getPrice($license)
    {
        return ($this->{"price_" . $license} ?: config('boykomarket.prices.' . $this->type . '.' . $license));
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
        return "families/" . $this->slug . "/assets";
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
        return route('website.asset.download', [$this->family->slug, $this->slug]);
    }

    public function hasLicense($user, $type = false)
    {
        if (!$user) {
            return false;
        }

        // сперва проверяем, может есть ли лицензия на всё семейство
        $family = $this->family;

        foreach ($family->users as $buyer) {
            if ($user->id === $buyer->id && (!$type || $type === $buyer->pivot->license)) {
                return true;
            }
        }

        // затем на паки
        foreach ($this->packs as $pack) {
            foreach ($pack->users as $buyer) {
                if ($user->id === $buyer->id && (!$type || $type === $buyer->pivot->license)) {
                    return true;
                }
            }
        }

        // и на сам ассет
        foreach ($this->users as $buyer) {
            if ($user->id === $buyer->id && (!$type || $type === $buyer->pivot->license)) {
                return true;
            }
        }

        return false;
    }

    public function itemType()
    {
        return 'asset';
    }

    public function makeUniqueSlug($name)
    {
        if (!$this->family_id) {
            throw new \LogicException('Family ID not set, its needed to create slug');
        }

        $base = StaticStringy::slugify($name);

        $count = 2;

        $slug = $base;

        $query = Asset::where('slug', $slug)->where('family_id', $this->family_id);

        if ($this->exists) {
            $query->where('id', '!=', $this->id);
        }

        $slugExists = $query->exists();

        while ($slugExists) {
            $slug = $base . "-" . $count;

            $slugExists = Asset::where('slug', $slug)->where('family_id', $this->family_id)->exists();

            $count++;
        }

        $this->slug = $slug;
    }

    public function paymentLink($licenseType, $userID)
    {
        $params = [
            'merchant' => '250347688076',
            'nodata' => 1,
            'pay_type'=> 'paypal',
            'dynamic' => '1',
            'currency' => 'USD',
            'type' => 'digital',
            'qty' => '1',
            'return-url' => route('website.asset.show', [$this->family->slug, $this->slug]),
            'return-type' => 'redirect',
            'item-ext-ref' => 'asset_' . $this->id . '_' . $userID . '_' . $licenseType,
            'prod' => $this->name . " ({$this->type})",
            'price' => $this->getPrice($licenseType)
        ];

        if (config('boykomarket.test_payment_mode')) {
            $params['test'] = '1';
        }

        $sign = app(TwoCheckout::class)->sign($params);

        $params['signature'] = $sign;

        $link = "https://secure.2checkout.com/checkout/buy?" . http_build_query($params);

        return $link;
    }

    protected function previewUrlW128(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->previewUrl(128),
        );
    }

    protected function previewUrlW512(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->previewUrl(512),
        );
    }

    protected function urlShow(): Attribute
    {
        return Attribute::make(
            get: fn() => route('website.asset.show', [$this->family->slug, $this->slug]),
        );
    }

    protected function purpose(): Attribute
    {
        $asset = $this;

        return Attribute::get(
            function ($value) use ($asset) {
                if (!$value) {
                    $isFreebie = $asset->packs()->where('purpose', 'freebie')->exists();

                    if ($isFreebie) {
                        $value = 'freebie';
                    } else {
                        $value = 'paid';
                    }

                    $asset->update(['purpose' => $value]);

                    return $value;

                } else {
                    return $value;
                }
            },
        )->shouldCache();
    }

}
