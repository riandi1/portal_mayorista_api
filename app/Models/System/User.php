<?php

namespace App\Models\System;

use App\Conversation;
use App\Models\Store\Favorite;
use App\Models\Store\Product;
use App\Models\Store\UserPlan;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Watson\Validating\ValidatingTrait;
use App\Models\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\System\User
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Client[] $clients
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Token[] $tokens
 * @mixin \Eloquent
 */
class User extends Model implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract
{
    use Authenticatable,
        Authorizable,
        CanResetPassword,
        HasApiTokens,
        Notifiable,
        HasRoles;

    public $relationships = ['roles', 'permissions','products'];

    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $merge_fillable_searchables = false;
    protected $searchables_columns = [
        'email' => 8
    ];

    protected $fillable = [
        'email',
        'image',
        'password',
        'first_surname',
        'last_surname',
        'first_name',
        'last_name',
        'latitude',
        'longitude',
        'extension',
        'telephone',
        'active_telephone',
        'activation_telephone',
        'gender',
        'birthdate',
        'schedule',
        'description',
        'seller',
        'balance',
        'web',
        'active',
        'activation_token',
        'social_id',
        'provider_access',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token', 'activation_token','social_id','active','active_telephone'];

    protected $rules = [
        'password' => 'required',
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
    ];




    public function userPlans(): HasMany
    {
        return $this->hasMany(UserPlan::class, 'user_id', 'id');
    }


    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'user_id', 'id');
    }



}
