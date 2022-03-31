<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'roles';

	//primary key
    public $primaryKey = 'id';

	/**
	 * The timestamps.
	 *
	 * @var bool
	 */
	public $timestamps = true;

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'name',
    	'slug',
    	'permissions'
	];
	
	// Relationship with users
	public function users()
	{
		return $this->belongsToMany('App\User', 'user_roles', 'role_id', 'user_id');
	}
}
