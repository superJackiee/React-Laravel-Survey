<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branchs extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @param array
     */
    protected $fillable = [
        'name', 'country', 'city', 'picture', 'manager_id',
    ]; 
    
    public static function getById($id)
    {
        return (
        $branches  = self::where('id', '=', $id)
            ->limit(1)
            ->get()
        ) &&
            count($branches) ===1
        ? $branches[0]
        : null;
    }

    public static function destroyByOwner($id)
    {
        return self::where([
            'id' => $id
        ])->delete();
    }

    public static function getAllByOwner($owner_id)
    {
        $branchs = self::where('owner_id', '=', $owner_id)
            ->orderBy('updated_at', 'desc')->get();
        return $branchs;
    }
}
