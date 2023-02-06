<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Companies extends Model
{
    use HasFactory;

    protected $table = 'companies';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'name',
        'email',
        'logo',
        'website'
    ];

    /**
     * Get all employees that owns the company.
     */
    public function employees()
    {
        return $this->hasMany(Employees::class,'company_id');
    }
}
