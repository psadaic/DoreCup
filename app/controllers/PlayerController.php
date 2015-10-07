<?php

require app_path().'/libraries/MadRemote.class.php';

class PlayerController extends BaseController {

	public $config;

	public function servers()
	{
		$results = DB::select('select id, ip, port, user, pass from dsc_servers');

		$this->config['servers']=array();

		$i=0;
		foreach($results as $res)
		{
			$this->config['servers'][$i]['ip']=$res->ip;
			$this->config['servers'][$i]['port']=$res->port;
			$this->config['servers'][$i]['user']=$res->user;
			$this->config['servers'][$i]['pass']=$res->pass;
			$i++;
		}
	}

	public function getPlayerNum()
	{
		if(Request::ajax()) 
		{
			$this->servers();
			$player_count = 0;
			foreach($this->config['servers'] as $server)
			{
				$client = new MadRemote();
				if($client->connect($server['ip'],$server['port']))
				{
					$client->Authenticate($server['user'], $server['pass']);
					$version = $client->GetVersion();
					if(!empty($version)) 
					{
						$players = $client->GetPlayerList(100,0);
						$num = count($players);
						$player_count+=$num;
					}
				}
				$client->close();
			}
			$total=$this->playerTotal();
			$online=$player_count;
			$output=array($total, $online);
			return Response::json($output);
    	}
	}

	private function playerTotal()
	{
		$count=0;
		$results = DB::select('select PlayerId from dsc_uaseco_players');
		if(!empty($results))
		{
			$count=count($results);
		}
		return $count;
	}
}