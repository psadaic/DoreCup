@extends('layouts.default')
@section('content')
    <div id="page-content" class="container">
    	<div id="loadimg"><img src="{{URL::to('/assets/img/Preloader_10.gif')}}" style="width:50px;height:50px;display: block;margin: 0 auto;"/></div>
    	<div class="container none" style="display:none;">
    		<div class="row push">
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-heading panel-style" style="background:#d01b22;color:white;"> <span class="glyphicon glyphicon-stats"></span><b> Total Statistics</b></div>
							<div class="panel-body">
								<div class="row">
									<div class="col-xs-12" style="overflow:auto;">
										<table id="stats" class="table table-striped borderless table-hover" cellspacing="0" width="100%">
											<thead>
            									<tr>
            										<th style="text-align: center;">#</th>
                									<th>Name</th>
                									<th style="text-align: center;">Total Points</th>
            									</tr>
        									</thead>
        									<tbody class="stats">
        										<!---->
        									<tbody>
										</table>
									</div>
								</div>
							</div>
						<div class="panel-footer panel-style" style="background:#d01b22;color:white;"> </div>
					</div>
				</div>
			</div>
    	</div>
    </div>
@stop
@section('scripts')
	<script type="text/javascript">
		setTimeout(function(){
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
			url: "{{URL::to('/api/data/stats/total')}}",
			type: "post",
			data: {'_token': '{{ csrf_token() }}'},
			success: function(data){
				var players=data;
				var i=1;
				var page="";
        		for(var index in players) { 
   					if (players.hasOwnProperty(index)) {
      	 				var player = players[index];
      	 				page+='<tr onclick="details('+i+');">';
      	 				if(i==1)
      	 				{
      	 					page+='<td><center><img src="{{URL::to('/assets/img/medal-award-gold-icon.png')}}" style="width:20px;height:20px;"/></center></td>';
      	 				}
      	 				else if(i==2)
      	 				{
      	 					page+='<td><center><img src="{{URL::to('/assets/img/medal-silver-3-icon.png')}}" style="width:20px;height:20px;"/></center></td>';
      	 				}
      	 				else if(i==3)
      	 				{
      	 					page+='<td><center><img src="{{URL::to('/assets/img/medal-bronze-3-icon.png')}}" style="width:20px;height:20px;"/></center></td>';
      	 				}
      	 				else
      	 				{
      	 					page+='<td><center>'+i+'</center></td>';
      	 				}
      	 					page+='<td><span style="text-shadow: 0px 1px 1px gray;">'+player.Nickname+'</span></td>';
      	 					page+='<td style="text-align: center;"><b>'+player.points+'</b></td>';
      	 				page+='</tr>';
      	 				i++;
   					}
				}
				setTimeout(function(){
					$('#loadimg').html("");
					$('.stats').html(page);
				}, 1000);
			}
		});
	}
	</script>
@stop