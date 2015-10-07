<?php

require app_path().'/libraries/tmfcp.class.php';

class StatisticsController extends BaseController {

	public $maps;
	private $runs;

	public function getRun($run)
	{
		$this->checkRuns();
		if(($run==='total')&&(count($this->runs)>1))
		{
			return View::make('pages.total');
		}
		else if(in_array($run, $this->runs))
		{
			return View::make('pages.statistics', array('run' => $run));
		}
		else
		{
			return Response::view('errors.404', array(), 404);
		}
	}

	public function getStatistics($run)
	{
		if(!Request::ajax()) { die(); }
		$cp = new TMFColorParser();
		$this->getMaps($run);
		$maps = $this->maps;
		$norectime=720000;

		$mapinfo=array();
		$n=0;
		foreach($maps as $map)
		{
			$results = DB::select('select MapId, Uid, Name from dsc_uaseco_maps where Uid = ?', array($map));
			if(!empty($results))
			{
				foreach($results as $res)
				{
					$mapinfo[$n]['MapId']=$res->MapId;
					$mapinfo[$n]['Uid']=$res->Uid;
					$mapinfo[$n]['Name']=$cp->toHTML($res->Name);
				}
				$n++;
			}
		}
		$this->array_sort_by_column($mapinfo, 'MapId');

		$playerinfo=array();
		$n=0;
		foreach($mapinfo as $map)
		{
			$results = DB::select('select PlayerId from dsc_uaseco_records where MapId = ?', array($map['MapId']));
			if(!empty($results))
			{
				foreach($results as $res)
				{
					if(!$this->in_array_r($res->PlayerId, $playerinfo))
					{
						$results2 = DB::select('select PlayerId, Login, Nickname, Nation from dsc_uaseco_players where PlayerId = ?', array($res->PlayerId));
						if(!empty($results2))
						{
							foreach($results2 as $res2)
							{
								$playerinfo[$n]['PlayerId']=$res2->PlayerId;
								$playerinfo[$n]['Login']=$res2->Login;
								$playerinfo[$n]['Nickname']=$cp->toHTML($res2->Nickname);
								$playerinfo[$n]['Nation']=$res2->Nation;
							}
							$n++;
						}
					}
				}
			}
		}
		$this->array_sort_by_column($playerinfo, 'PlayerId');

		foreach($playerinfo as &$player)
		{
			$totaltime=0;
			$check=false;
			foreach($mapinfo as $map)
			{
				$results = DB::select('select MapId, PlayerId, Date, Score, Checkpoints from dsc_uaseco_records where MapId = ? and PlayerId = ?', array($map['MapId'], $player['PlayerId']));
				if(!empty($results))
				{
					foreach($results as $res)
					{
						$totaltime+=(int)$res->Score;
						$tmp[$map['MapId']]=$this->scoreToTime($res->Score);
						$player['records']=$tmp;
					}
				}
				else
				{
					$check=true;
					$totaltime+=(int)$norectime;
					$tmp[$map['MapId']]='<span style="color:red;">'.$this->scoreToTime($norectime).'</span>';
					$player['records']=$tmp;
				}
			}
			if(!$check)
			{
				$player['totaltime']=$this->scoreToTime($totaltime);
				$player['totaltimeclean']=$totaltime;
			}
			else
			{
				$player['totaltime']='<span style="color:red;">'.$this->scoreToTime($totaltime).'</span>';
				$player['totaltimeclean']=$totaltime;
			}
		}
		$this->array_sort_by_column($playerinfo, 'totaltimeclean');
		$playerinfo = array_map("unserialize", array_unique(array_map("serialize", $playerinfo)));

		$output=array($mapinfo, $playerinfo);

		return Response::json($output);
	}

	public function getStatsTotal() 
	{
		if(!Request::ajax()) { die(); }
		$this->checkRuns();
		$cp = new TMFColorParser();

		$pls=array();
		foreach($this->runs as $run)
		{
			$this->getMaps($run);
			$maps = $this->maps;
			$norectime=720000;

			$mapinfo=array();
			$n=0;
			foreach($maps as $map)
			{
				$results = DB::select('select MapId, Uid, Name from dsc_uaseco_maps where Uid = ?', array($map));
				if(!empty($results))
				{	
					foreach($results as $res)
					{
						$mapinfo[$n]['MapId']=$res->MapId;
						$mapinfo[$n]['Uid']=$res->Uid;
						$mapinfo[$n]['Name']=$cp->toHTML($res->Name);
					}
					$n++;
				}
			}
			$this->array_sort_by_column($mapinfo, 'MapId');

			$playerinfo=array();
			$n=0;
			foreach($mapinfo as $map)
			{
				$results = DB::select('select PlayerId from dsc_uaseco_records where MapId = ?', array($map['MapId']));
				if(!empty($results))
				{
					foreach($results as $res)
					{
						if(!$this->in_array_r($res->PlayerId, $playerinfo))
						{
							$results2 = DB::select('select PlayerId, Login, Nickname, Nation from dsc_uaseco_players where PlayerId = ?', array($res->PlayerId));
							if(!empty($results2))
							{
								foreach($results2 as $res2)
								{
									$lgn=$res2->Login;
									$playerinfo[$lgn]['PlayerId']=$res2->PlayerId;
									$playerinfo[$lgn]['Login']=$res2->Login;
									$playerinfo[$lgn]['Nickname']=$cp->toHTML($res2->Nickname);
									$playerinfo[$lgn]['Nation']=$res2->Nation;
								}
								$n++;
							}
						}
					}
				}
			}
			$this->array_sort_by_column($playerinfo, 'PlayerId');

			foreach($playerinfo as &$player)
			{
				$totaltime=0;
				$check=false;
				foreach($mapinfo as $map)
				{
					$results = DB::select('select MapId, PlayerId, Date, Score, Checkpoints from dsc_uaseco_records where MapId = ? and PlayerId = ?', array($map['MapId'], $player['PlayerId']));
					if(!empty($results))
					{
						foreach($results as $res)
						{
							$totaltime+=(int)$res->Score;
						}
					}
					else
					{
						$check=true;
						$totaltime+=(int)$norectime;
					}
				}
				if(!$check)
				{
					$player['totaltimeclean']=$totaltime;
				}
				else
				{
					$player['totaltimeclean']=$totaltime;
				}
			}
			$this->array_sort_by_column($playerinfo, 'totaltimeclean');
			$playerinfo = array_map("unserialize", array_unique(array_map("serialize", $playerinfo)));

			$i=100;
			$playerout=array();
			foreach($playerinfo as &$player)
			{
				if($i>0)
				{
					$player['points']=$i;
					array_push($playerout, $player);
					$i--;
				}
			}

			$pls[$run]=$playerout;
		}

		$total=array();
		$i=0;
		foreach ($pls as $run) 
		{
			foreach ($run as $key => $plyr) 
			{
				if(isset($total[$plyr['Login']]))
				{
					if(isset($total[$plyr['Login']]['points']))
					{
						$points=$plyr['points'];
						if(isset($total[$plyr['Login']]['points']))
						{
							$total[$plyr['Login']]['points']+=$points;
						}
						else
						{
							$total[$plyr['Login']]['points']=$points;
						}
					}
					else
					{
						$total[$plyr['Login']]['points']=0;
					}
				}
				else
				{
					$total[$plyr['Login']]=$plyr;
				}
				if(!isset($total[$plyr['Login']]['runs']))
				{
					$total[$plyr['Login']]['runs']=array();
				}
				if(!array_key_exists($i, $total[$plyr['Login']]['runs']))
				{
					if(isset($points))
					{
						$total[$plyr['Login']]['runs'][$i]=$points;
					}
					else
					{
						$total[$plyr['Login']]['runs'][$i]=$total[$plyr['Login']]['points'];
					}
				}
			}
			$i++;
		}
		$this->array_sort_by_column($total, 'points', SORT_DESC);

		for($i=0;$i<count($pls);$i++)
		{
			foreach($total as &$player)
			{
				if(!isset($player['runs'][$i]))
				{
					$player['runs'][$i]=0;
				}
				ksort($player['runs']);
			}
		}

		return Response::json($total);
	}

	private function checkRuns()
	{
		$this->runs=array();

		$results = DB::select('select name from dsc_runs');
		if(!empty($results))
		{
			$i=0;
			foreach($results as $res)
			{
				array_push($this->runs, $res->name);
			}
		}
	}

	private function getMaps($run)
	{
		$this->maps=array();

		$results = DB::select('select maps from dsc_runs where name = ?', array(urldecode($run)));
		if(isset($results[0]->maps))
		{
			$this->maps=explode(",", $results[0]->maps);
		}
	}

	private function array_sort_by_column(&$arr, $col, $dir = SORT_ASC)
	{
    	$sort_col = array();
    	foreach ($arr as $key=> $row) {
        	$sort_col[$key] = $row[$col];
    	}

	    array_multisort($sort_col, $dir, $arr);
	}

	private function in_array_r($needle, $haystack, $strict = false) 
	{
    	foreach ($haystack as $item) {
        	if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && $this->in_array_r($needle, $item, $strict))) {
            	return true;
        	}
    	}
    	return false;
	}

	private function scoreToTime($data)
	{
		$tmp=(int)$data;
		$uSec=$tmp % 1000;
		$minutes=floor($tmp / 60000);
		$seconds=floor(($tmp / 1000) % 60);
		$format = '%02u:%02u.%03u';
    	$time = sprintf($format, $minutes, $seconds, $uSec);
    	return $time;
	}
}