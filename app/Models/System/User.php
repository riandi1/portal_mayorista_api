<?php

namespace App\Models\System;

use App\Conversation;
use App\Models\Store\Favorite;
use App\Models\Store\Product;
use App\Models\System\Parametrics\City;
use App\Models\System\Parametrics\Country;
use App\Models\System\Parametrics\DocumentType;
use App\Models\Store\UserPlan;
use App\Models\System\Parametrics\State;
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

    public $relationships = ['roles', 'permissions', 'documentType', 'country', 'state', 'city'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $merge_fillable_searchables = false;
    protected $searchables_columns = [
        'name' => 1,
        'email' => 8
    ];

    protected $fillable = [
        'name',
        'email',
        'image',
        'password',
        'fcm_token',
        'document_type_id',
        'document_number',
        'first_surname',
        'last_surname',
        'first_name',
        'last_name',
        'country_id',
        'state_id',
        'city_id',
        'telephone',
        'mobile',
        'address',
        'gender',
        'birthdate',
        'provider_access',
        'record_origin',
        'web',
        'schedule',
        'description',
        'seller',
        'balance',
        'accept_terms'
    ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    protected $rules = [
        'name' => 'required|min:3',
        'document_number' => 'required|min:3',
        'password' => 'required',
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'document_type_id' => 'required|exists:document_types,id',
        'country_id' => 'required|exists:countries,id',
        'state_id' => 'required|exists:states,id',
        'city_id' => 'required|exists:cities,id'
    ];

    /* protected $appends = ['level'];

     public static function getByEmail($email)
     {
         return User::query()->where('email', '=', $email)->get()->first();
     }

     public function getLevelAttribute()
     {
         return get_user_lvl($this);
     }*/

    public function created_comments()
    {
        return $this->hasMany(Comment::class, 'user_id', 'id');
    }

    public function userPlans(): HasMany
    {
        return $this->hasMany(UserPlan::class, 'user_id', 'id');
    }


    public function documentType(): BelongsTo
    {
        return $this->belongsTo(DocumentType::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'user_id', 'id');
    }

    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class, 'user_id', 'id');
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function conversationSender(){
        return $this->hasMany(Conversation::class, 'user_sender_id', 'id');
    }


    public function conversationReceiver(){
        return $this->hasMany(Conversation::class, 'user_receiver_id', 'id');
    }
 /*  public function conversations()
    {
        return $this->belongsToMany(Conversation::class, 'user_conversation');
    }
*/
}
