<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User\UserModel;
use Illuminate\Database\Eloquent\Relations\Pivot;


abstract class BaseModelPivot extends Pivot
{
  use SoftDeletes;

  protected $dates = [
      'created_at',
      'updated_at',
      'deleted_at',
  ];

  protected $fillable = [];

  protected $hidden = [
      'created_by',
      'updated_by',
      'deleted_by',
      'deleted_at',
  ];

  /**
   * Boot model
   *
   * @return void
   */
  protected static function boot()
  {
      parent::boot();

      //Adicionar os parâmetros do usuário ao utilizar os métodos padrão de Create, Update e Delete

      static::creating(function ($model) {
          if (auth()->check()) {
              $model->created_by = auth()->id();
          }
      });

      static::updating(function ($model) {
          if (auth()->check()) {
              $model->updated_by = auth()->id();
          }
      });

      static::deleting(function ($model) {
          if (auth()->check()) {
              $model->deleted_by = auth()->id();
              $model->save();
          }
      });
  }

 
  /**
   * Retornar nome da table pelo Model
   */
  public static function getTableName(): string
  {
      return (new static())->getTable();
  }
}