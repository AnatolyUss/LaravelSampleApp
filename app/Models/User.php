<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email'];

    /**
     * Get the posts of the user.
     *
     * @return HasMany
     */
    public function posts(): HasMany
    {
        return $this->hasMany('App\Models\Post');
    }

    /**
     * Creates a new user.
     *
     * @param array $parameters
     * @return User
     */
    public function createUser(array $parameters): User
    {
        return static::create($parameters);
    }

    /**
     * Returns a user with given id, if exists.
     *
     * @param int $userId
     * @return mixed
     */
    public function searchById(int $userId)
    {
        return static::find($userId);
    }
}
