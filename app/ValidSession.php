<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

use Carbon\Carbon;

use Auth;

class ValidSession extends Model
{
	
	public $timestamps = false;
	
	protected $fillable = [
		'hash', 'user_id', 'ip', 'useragent', 'last_active',
	];
	
	 protected $dates = ['last_active'];
	
	public function user()
	{
		return $this->belongsTo('App\User');
	}
	
	static public function generateFingerprint(Request $request)
	{
		$fingerprint = [
			'user_id'   => Auth::user()->id,
			'ip'        => $request->ip(),
			'useragent' => $request->header('User-Agent'),  
		];
		
		$fingerprint['hash'] = sha1($fingerprint['user_id'] . '/' . $fingerprint['ip'] . '/' . $fingerprint['useragent']);
		
		return $fingerprint;
	}
	
	static public function findSession($fingerprint)
	{
		$session = ValidSession::where('hash', $fingerprint['hash'])->first();
		
		if($session)
		{
			$session->last_active = Carbon::now();
			$session->save();
		}
		
		return $session;
	}
	
	static public function makeSession($fingerprint)
	{
		$fingerprint['last_active'] = Carbon::now();
		
		$session = ValidSession::create($fingerprint);
		
		return $session;
	}
	
}
