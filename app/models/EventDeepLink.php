<?php
use Illuminate\Database\Eloquent\Model as Eloquent;
class EventDeepLink extends Eloquent {
	protected $table = 'eventdeeplink';
	protected $fillable = ['id', 'code'];

	protected $guarded = ['id'];
	public $timestamps = true;
}