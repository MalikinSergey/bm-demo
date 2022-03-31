<?php

namespace App\Models;

use App\Helpers\EnsureSlug;
use App\Services\TwoCheckout;
use App\Support\Archievable;
use App\Support\HasLicense;
use Illuminate\Support\Facades\Storage;
use Spatie\Image\Image;
use Spatie\Image\Manipulations;
use Stringy\StaticStringy;

class Asset extends \Eloquent
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

        static::saving(
            function ($asset) {
                if ($asset->family) {
                    $asset->type = $asset->family->type;
                }
            }
        );
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

    public function inlineSvg()
    {
        return \Storage::disk('assets')->get($this->path());
    }

    public function previewDir()
    {
        return "previews/" . $this->Family->slug;
    }

    public function makePng()
    {
        shell_exec('convert-svg-to-png ' . Storage::disk('assets')->path($this->path()) . ' --width 1200');

        if(!$this->testPng()){
            $this->download_status = 'error';
        }
        else{
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
                $result = shell_exec('convert-svg-to-png ' . $source . ' --width ' . $width.' 2>&1');
                rename($tempFile, $file);
                $this->preview_status = 'ok';
            } catch (\Exception $e) {
                $this->preview_status = 'error';
                $message = "Make PNG preview error: " . $result;
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
        return "/assets/" . $this->Family->slug . "/" . $this->slug . "." . $type;
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

    public function getPrice($type)
    {
        return ($this->{"price_" . $type} ?: config('boykomarket.prices.' . $this->type . '.' . $type));
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

    public function paymentLink($licenseType, $userID)
    {
        $params = [
            'merchant' => '250347688076',
            'dynamic' => '1',
            'currency' => 'USD',
            'tpl' => 'default',
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

}
