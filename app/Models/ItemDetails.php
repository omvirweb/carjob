<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemDetails extends Model
{
    protected $table = 'item_details';
    
    protected $fillable = [
      'id', 'categoryid', 'itemid', 'weight', 'less', 'net_wt', 'purity', 'fine', 'size', 'remarks', 'item_available', 'item_image', 'created_at', 'updated_at'
    ];
}
