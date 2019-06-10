<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CatalogPostalCodes
 * @package App\Models
 *
 * @property string $cp [PK]
 * @property string $town_name
 * @property integer $town_key
 * @property string $state_name
 * @property integer $state_key
 */
class CatalogPostalCodes extends Model
{

    protected $table      = 'catalog_postal_codes';
    public    $timestamps = false;

}