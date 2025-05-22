<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User\UserModel;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

abstract class BaseAuthModel extends Authenticatable
{
	use SoftDeletes, HasApiTokens;

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
   * Retornar usuário que criou o dado
   */
  public function createdBy(): BelongsTo
  {
      return $this->belongsTo(UserModel::class, 'created_by');
  }

  /**
   * Retornar usuário que atualizou o dado por último
   */
  public function updatedBy(): BelongsTo
  {
      return $this->belongsTo(UserModel::class, 'updated_by');
  }

  /**
   * Retornar usuário que apagou o dado
   */
  public function deletedBy(): BelongsTo
  {
      return $this->belongsTo(UserModel::class, 'deleted_by');
  }

  /**
   * Tazer somente dados ativos - sem deleted_at marcados
   */
  public function scopeActive($query)
  {
      return $query->whereNull('deleted_at');
  }

  /**
   * Tazer somente dados inativos - com deleted_at marcados
   */
  public function scopeInactive($query)
  {
      return $query->whereNotNull('deleted_at');
  }

  /**
   * Retornar nome da table pelo Model
   */
  public static function getTableName(): string
  {
      return (new static())->getTable();
  }
}