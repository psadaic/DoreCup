<?php

class AdminController extends BaseController {

	public function getAdmin()
	{
		$loggedin = Session::get(md5('loggedin'));
		$user = Session::get('user');
		if(isset($loggedin)&&isset($user))
			return View::make('pages.dashboard');
		else
			return Redirect::to('admin/login');
	}

	public function adminLogin()
	{
		$loggedin = Session::get(md5('loggedin'));
		$user = Session::get('user');
		if(isset($loggedin)&&isset($user))
			return Redirect::to('admin');
		else
			return View::make('pages.login');
	}

	public function adminLogout()
	{
		Session::forget(md5('loggedin'));
		Session::forget('user');
		return Redirect::to('/');
	}

	public function handleLogin()
	{
		if(!Request::ajax()) { die(); }
		if(!empty($_POST['username'])&&!empty($_POST['password']))
		{
			$user = $_POST['username'];
			$pass = $_POST['password'];
			$results = DB::select('select id, user, pass from dsc_user where user = ?', array($user));
			if(!empty($results))
			{
				$hash = $results[0]->pass;
				if (Hash::check($pass, $hash))
				{
					Session::put(md5('loggedin'), md5('1'));
					Session::put('user', $user);
    				return 1;
				}
				else
					return 0;
			}
			else
				return 0;
		}
		else
			return 0;
	}

	public function getInfo()
	{
		if(!Request::ajax()) { die(); }
		$results = DB::select('select data from dsc_info where id = ?', array(1));
		return $results[0]->data;
	}

	public function getRuns()
	{
		if(!Request::ajax()) { die(); }
		$results = DB::select('select name from dsc_runs');
		if(!empty($results))
		{
			$out=array();
			foreach($results as $res)
			{
				array_push($out, $res->name);
			}
			return Response::json($out);
		}
		else
			return 0;
	}

	public function getUsername()
	{
		if(!Request::ajax()) { die(); }
		$results = DB::select('select user from dsc_user where id = ?', array(1));
		return $results[0]->user;
	}

	public function getServers()
	{
		if(!Request::ajax()) { die(); }
		$results = DB::select('select id, ip, port, user, pass, login from dsc_servers');
		return Response::json($results);
	}

	public function getRun()
	{
		if(!Request::ajax()) { die(); }
		$results = DB::select('select id, name, maps from dsc_runs');
		return Response::json($results);
	}

	public function changeInfo() 
	{
		if(!Request::ajax()) { die(); }
		if(!empty($_POST['info']))
		{
			$info = $_POST['info'];
			DB::update('update dsc_info set data = ? where id = ?', array($info, 1));
			return 1;
		}
		else
			return 0;
	}

	public function changeUsername() 
	{
		if(!Request::ajax()) { die(); }
		if(!empty($_POST['username']))
		{
			$username = $_POST['username'];
			DB::update('update dsc_user set user = ? where id = ?', array($username, 1));
			return 1;
		}
		else
			return 0;
	}

	public function changePassword() 
	{
		if(!Request::ajax()) { die(); }
		if(!empty($_POST['password']))
		{
			$password = Hash::make($_POST['password']);
			DB::update('update dsc_user set pass = ? where id = ?', array($password, 1));
			return 1;
		}
		else
			return 0;
	}

	public function addServer() 
	{
		if(!Request::ajax()) { die(); }
		if(!empty($_POST['ip'])&&!empty($_POST['port'])&&!empty($_POST['user'])&&!empty($_POST['pass'])&&!empty($_POST['login']))
		{
			$ip = $_POST['ip'];
			$port = $_POST['port'];
			$user = $_POST['user'];
			$pass = $_POST['pass'];
			$login = $_POST['login'];
			DB::insert('insert into dsc_servers (ip, port, user, pass, login) values (?, ?, ?, ?, ?)', array($ip, $port, $user, $pass, $login));
			return 1;
		}
		else
			return 0;
	}

	public function addRun()
	{
		if(!Request::ajax()) { die(); }
		if(!empty($_POST['run'])&&!empty($_POST['maps']))
		{
			$run = $_POST['run'];
			$maps = $_POST['maps'];
			DB::insert('insert into dsc_runs (name, maps) values (?, ?)', array($run, $maps));
			return 1;
		}
		else
			return 0;
	}

	public function deleteServer()
	{
		if(!Request::ajax()) { die(); }
		if(!empty($_POST['id']))
		{
			$id = $_POST['id'];
			DB::delete('delete from dsc_servers where id = ?', array($id));
			return 1;
		}
		else
			return 0;
	}

	public function deleteRun()
	{
		if(!Request::ajax()) { die(); }
		if(!empty($_POST['id']))
		{
			$id = $_POST['id'];
			DB::delete('delete from dsc_runs where id = ?', array($id));
			return 1;
		}
		else
			return 0;
	}
}