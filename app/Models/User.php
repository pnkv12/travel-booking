<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $table = 'users';

    protected $fillable = [
        'id',
        'fullname',
        'email',
        'password',
        'password_confirmation',
        'phone',
        'created_at',
        'updated_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //Add new account into database
    public function regUser($user)
    {
        return $this->insert($user);
    }

    //Show a list of admin's contacts
    public function getList($search)
    {
        $data = $this->select(
            'id',
            'fullname',
            'username',
            'email',
            'phone'
        );
        if (!empty($search['query'])) {
            $data->where('fullname', 'LIKE', '%' . $search['query'] . '%')
                ->orWhere('id', '=', $search['query'])
                ->orWhere('username', 'LIKE', '%' . $search['query'] . '%');
        }
        return $data->paginate(5);
    }

    //Show each Admin's data
    public function viewProfile($id)
    {
        $data = $this->select(
            'id',
            'username',
            'fullname',
            'email',
            'phone'
        )
            ->where('id', $id);
        return $data->first();
    }

    //Show data in edit page
    public function getUserById($id)
    {
        $data = $this->select(
            'id',
            'username',
            'fullname',
            'email',
            'phone'
        )
            ->where('id', $id);
        return $data->first();
    }

    public function updateAdmin($update)
    {
        return $this->where('id', $update['id'])
            ->update($update);
    }

    //Open admin's change password page
    public function getUserPassword($id)
    {
        $data = $this->select(
            'id',
            'username',
            'password',
            'password_confirmation'
        )
            ->where('id', $id);
        return $data->first();
    }

    public function updatePw($update)
    {
        return $this->where('id', $update['id'])
            ->update($update);
    }
}
