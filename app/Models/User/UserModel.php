<?php

namespace App\Models\User;

use App\Models\BaseAuthModel;
use Illuminate\Notifications\Notifiable;

class UserModel extends BaseAuthModel
{
  use Notifiable;

  protected $table = 'users';

  protected $fillable = [
    'name',
    'email',
    'password',
    'email_verified_at',
    'status'
  ];

  protected $hidden = [
    'id',
    'password',
    'remember_token',
  ];

  protected $casts = [
    'email_verified_at' => 'datetime',
  ];
}