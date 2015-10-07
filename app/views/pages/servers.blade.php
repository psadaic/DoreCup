@extends('layouts.default')
@section('content')
    <div id="page-content" class="container">
    	<div id="loadimg"><img src="{{URL::to('/assets/img/Preloader_10.gif')}}" style="width:50px;height:50px;display: block;margin: 0 auto;"/></div>
    	<div class="container none" style="display:none;">
    		<div class="row push">
    			<div class="col-md-12">
    				<div class="panel panel-default">
						<div class="panel-heading panel-style" style="background:#d01b22;color:white;"> <span class="glyphicon glyphicon-tasks"></span><b> Servers</b></div>
							<div class="panel-body">
								<div class="row">
									<div id="servers" class="col-xs-12" style="overflow:auto;">
										<table id="stats" class="table table-striped borderless table-hover" cellspacing="0" width="100%">
											<thead>
												<tr>
													<th>Name</th>
													<th><center>Players</center></th>
													<th><center>Spectators</center></th>
													<th><center>Current Map</center></th>
													<th><center>Next Map</center></th>
													<th><center></center></th>
												</tr>
											</thead>
											<tbody class="servers">
												<!---->
											</tbody>
										</table>
									</div>
								</div>
							</div>
						<!--<div class="panel-footer panel-style"> </div>-->
					</div>
    			</div>
    		</div>
		</div>
    </div>
@stop
@section('scripts')
	<script type="text/javascript">
		setTimeout(function(){
			$('#loadimg').html("");
			$(".none").removeAttr("style");
		}, 1000);
	</script>
	<script type="text/javascript">
	loadPage();

	var auto_refresh = setInterval(
		function () {
			loadPage();
		}, 30000);

	function loadPage() {
		$.ajax({
			url: "{{URL::to('/api/data/servers')}}",
			type: "post",
			data: {'_token': '{{ csrf_token() }}'},
			success: function(data) {
				$('.servers').html("");
				var out="";
				for(var i in data) {
					out+='<tr style="background:white;">';
						out+='<td><span style="text-shadow: 0px 1px 1px gray;">'+data[i].name+'</span></td>';
						out+='<td><center>'+data[i].players+'</center></td>';
						out+='<td><center>'+data[i].spectators+'</center></td>';
						out+='<td><span style="text-shadow: 0px 1px 1px gray;"><center>'+data[i].cmap+'</center></span></td>';
						out+='<td><span style="text-shadow: 0px 1px 1px gray;"><center>'+data[i].nmap+'</center></span></td>';
						out+='<td><center><a href="maniaplanet://#join='+data[i].login+'@'+data[i].env+'"><button class="btn btn-xs btn-dore">Join Server</button></a></center></td>';
					out+='</tr>';
				}
				$('.servers').html(out);
			}
		});
	}
	</script>
@stop