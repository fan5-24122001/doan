<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Umutphp\LaravelModelRecommendation\HasRecommendation;
use Umutphp\LaravelModelRecommendation\InteractWithRecommendation;

class User extends Authenticatable implements InteractWithRecommendation
{
    use Notifiable, HasFactory, HasRecommendation;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','role','photo','status','provider','provider_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function orders(){
        return $this->hasMany('App\Models\Order');
    }

    public static function getRecommendationConfig() :array
    {
        return [
            'possible_match' => [
                'recommendation_algorithm'         => 'db_relation',
                'recommendation_data_table'        => 'product_reviews',
                'recommendation_data_table_filter' => [],
                'recommendation_data_field'        => 'product_id',
                'recommendation_data_field_type'   => self::class,
                'recommendation_group_field'       => 'user_id',
                'recommendation_count'             => 5
            ]
        ];
    }
}
