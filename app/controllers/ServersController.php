<?php

require app_path().'/libraries/MadRemote.class.php';
require app_path().'/libraries/tmfcp.class.php';

class ServersController extends BaseController {

	public $config;

	public function getServers() {

		return View::make('pages.servers');
	}

	public function getServerInfo() {

		if(!Request::ajax()) { die(); }

		$this->setServers();

		$cp = new TMFColorParser();
		$output=array();
		foreach($this->config['servers'] as $server)
		{
			$client = new MadRemote();
			if($client->connect($server['ip'],$server['port']))
			{
				$client->Authenticate($server['user'], $server['pass']);
				$version = $client->GetVersion();
				$srvdata = $client->GetServerOptions();
				$players = $client->GetPlayerList(300,0);
				$cmap = $client->GetCurrentMapInfo();
				$nmap = $client->GetNextMapInfo();
				if(!empty($version)&&!empty($srvdata))
				{
					$out=array();
					$env=$version['TitleId'];
					$link='maniaplanet://‪#‎join‬='.$server['login'].'@'.$env;
					$name=$srvdata['Name'];
					$playermax=$srvdata['CurrentMaxPlayers'];
					$spectatormax=$srvdata['CurrentMaxSpectators'];
					if(!empty($players))
					{
						$pc=0;
						$sc=0;
						foreach($players as $player)
						{
							if($player['IsSpectator']==1)
							{
								$sc++;
							}
							else
							{
								$pc++;
							}
						}
						$pm=$pc.' / '.$playermax;
						$sm=$sc.' / '.$spectatormax;
					}
					else
					{
						$pm='0 / '.$playermax;
						$sm='0 / '.$spectatormax;
					}
					$out['name']=$cp->toHTML($name);
					$out['players']=$pm;
					$out['spectators']=$sm;
					$out['login']=$server['login'];
					$out['env']=$env;
					$out['cmap']=$cp->toHTML($cmap['Name']);
					$out['nmap']=$cp->toHTML($nmap['Name']);
					array_push($output, $out);
				}
			}
			$client->close();
		}

		return Response::json($output);
	}

	private function setServers() {

		$results = DB::select('select id, ip, port, user, pass, login from dsc_servers');
		$this->config['servers']=array();

		$i=0;
		foreach($results as $res)
		{
			$this->config['servers'][$i]['ip']=$res->ip;
			$this->config['servers'][$i]['port']=$res->port;
			$this->config['servers'][$i]['user']=$res->user;
			$this->config['servers'][$i]['pass']=$res->pass;
			$this->config['servers'][$i]['login']=$res->login;
			$i++;
		}
	}
}