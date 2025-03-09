<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    use HasFactory;

    protected $table = 'menu_items';

    protected $fillable = [
        'menu_id',
        'name',
        'description',
        'price',
        'image',
        'is_available'
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
