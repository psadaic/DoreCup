<?php

class HomeController extends BaseController {

	public function getHome()
	{
		$this->checkTables();
		return View::make('pages.home');
	}

	private function checkTables()
	{
		if (!Schema::hasTable('user'))
		{
    		Schema::create('user', function($table)
			{
    			$table->increments('id');
    			$table->string('user');
    			$table->string('pass');
			});
			$user = 'admin';
			$pass = Hash::make('foobar');
			DB::insert('insert into dsc_user (id, user, pass) values (?, ?, ?)', array(1, $user, $pass));
		}
		if (!Schema::hasTable('info'))
		{
    		Schema::create('info', function($table)
			{
    			$table->increments('id');
    			$table->longText('data');
			});
			DB::insert('insert into dsc_info (id, data) values (?, ?)', array(1, 'Placeholder'));
		}
		if (!Schema::hasTable('servers'))
		{
    		Schema::create('servers', function($table)
			{
    			$table->increments('id');
    			$table->string('ip');
    			$table->string('port');
    			$table->string('user');
    			$table->string('pass');
    			$table->string('login');
			});
		}
		if (!Schema::hasTable('runs'))
		{
			Schema::create('runs', function($table)
			{
    			$table->increments('id');
    			$table->string('name');
    			$table->longText('maps');
			});
		}	
	}
}
