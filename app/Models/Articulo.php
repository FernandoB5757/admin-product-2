<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Awcodes\Curator\Models\Media;
use Milon\Barcode\DNS1D;
use Milon\Barcode\Facades\DNS1DFacade;

class Articulo extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
        'clave',
        'clave_alterna',
        'producto_id',
        'valor_equivalente',
        'descripcion',
        'insumo',
        'usa_embace',
        'precio',
        'precio_embase',
        'imagenes'
    ];

    protected $casts = [
        'imagenes' => 'array',
    ];

    public const IMAGE_DIRECTORY = 'imagenes/articulos/';

    /**
     * Pertenece a un producto
     */
    public function producto(): BelongsTo
    {
        return $this->belongsTo(Producto::class);
    }

    /**
     * Relacion N - N articulo almacen
     */
    public function stocks(): BelongsToMany
    {
        return $this->belongsToMany(Almacen::class)
            ->withPivot('stock');
    }

    /*  public function registerMediaCollections(): void
    {
        $this->addMediaCollection('articulos')
            ->acceptsMimeTypes([
                'image/jpeg', 'image/png', 'image/bmp',
                'image/gif', 'image/webp', 'image/svg+xml'
            ])
            ->singleFile();
    } */

    protected function precioFormat(): Attribute
    {
        return Attribute::make(
            get: fn () => '$ ' . number_format($this->precio, 2),
        );
    }

    protected function nombre(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ucfirst($value),
        );
    }

    public function imagen(): Attribute
    {
        return Attribute::make(
            get: fn () =>  current($this->imagenes) ? current($this->imagenes) : null,
        );
    }

    protected function esInsumo(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->insumo ? 'Insumo' : 'Articulo',
        );
    }

    protected function unidad(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->producto->unidad,
        );
    }

    protected function barcode(): Attribute
    {
        return Attribute::make(
            get: fn () =>  DNS1DFacade::getBarcodeHTML('4445645656', 'PHARMA2T', 3, 33),
        );
    }

    protected function barcodeImage(): Attribute
    {
        return Attribute::make(
            get: fn () =>  DNS1DFacade::getBarcodePNGPath(code: fake()->uuid(), type: 'C128', showCode: true),
        );
    }
}
