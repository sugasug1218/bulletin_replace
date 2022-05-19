<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens; // passportでもいいが標準APIで実装した方がよさそう
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime:Y-m-d H:s:m',
        'updated_at' => 'datetime:Y-m-d H:s:m',
        'created_at' => 'datetime:Y-m-d H:s:m'
    ];

    public function post()
    {
        return $this->hasMany(Post::class);
    }

    public function scopeLikeUserId($query, $id)
    {
        return $query->find($id);
    }

    /**
     * users idで検索
     *
     * @param integer $id
     * @return array
     */
    public function getUserById(int $id)
    {
        $data = User::find($id);
        if (is_null($data)) {
            return $data;
        }
        return $data->toArray();
    }

    public function getUserAllByRequest()
    {
        $users = User::all();
        return $users->toArray();
    }

    /**
     * users create
     *
     * @param array $option
     * @return array
     */
    public function storeUserByRequest(array $option)
    {
        $result = $this->create([
            'name' => $option['name'],
            'email' => $option['email'],
            'password' => password_hash($option["password"], PASSWORD_DEFAULT)
        ]);
        return $result->toArray();
    }

    public function updateUserByRequest(array $option, int $id)
    {
        $target = $this->likeUserId($id);
        return $target->fill($option)->save();
    }

    public function deleteUserByRequest(int $id)
    {
        $target = $this->likeUserId($id);
        return $target->delete();
    }
}
