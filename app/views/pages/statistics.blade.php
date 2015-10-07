@extends('layouts.default')
@section('content')
    <div id="page-content" class="container">
    	<div id="loadimg"><img src="{{URL::to('/assets/img/Preloader_10.gif')}}" style="width:50px;height:50px;display: block;margin: 0 auto;"/></div>
    	<div class="container none" style="display:none;">
    		<div class="row push">
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-heading panel-style" style="background:#d01b22;color:white;"> <span class="glyphicon glyphicon-stats"></span><b> {{ ucfirst($run); }} Run Statistics</b></div>
							<div class="panel-body">
								<div class="row">
									<div class="col-xs-12" style="overflow:auto;">
										<table id="stats" class="table table-striped borderless table-hover" cellspacing="0" width="100%">
											<thead>
            									<tr>
            										<th style="text-align: center;">#</th>
                									<th>Name</th>
                									<th style="text-align: center;">Total Time</th>
                									<th style="text-align: center;">Points</th>
                									<th style="text-align: center;"> </th>
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
			url: "{{URL::to('/api/data/statistics/'.$run)}}",
			type: "post",
			data: {'_token': '{{ csrf_token() }}'},
			success: function(data){
				var maps=data[0];
				var players=data[1];
				var page="";
        		var i=1;
        		var p=100;
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
      	 					page+='<td style="text-align: center;">'+player.totaltime+'</td>';
      	 					page+='<td style="text-align: center;"><b>'+p+'</b></td>';
      	 					page+='<td style="text-align: center;"><div class="details-button-'+i+'"><span class="glyphicon glyphicon-chevron-down"></span></div></td>';
      	 				page+='</tr>';
      	 				if(p>0){
      	 					p--;
      	 				}
      	 				for(var index in maps) { 
   							if (maps.hasOwnProperty(index)) {
      	 						var map = maps[index];
      	 						page+='<tr class="details-'+i+' hidden-content">';
      	 							page+='<td style="background:white;"></td>';
      	 							page+='<td style="background:white;"><span style="text-shadow: 0px 1px 1px gray;">'+map.Name+'</span></td>';
      	 							page+='<td style="background:white;text-align: center;">'+player.records[map.MapId]+'</td>';
      	 							page+='<td style="background:white;"></td>';
      	 							page+='<td style="background:white;"></td>';
      	 						page+='</tr>';
      	 					}
      	 				}
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
	<script type="text/javascript">
		function details (id) {
      		$content = $('.details-'+id);
      		$content.slideToggle(10, function () { 
       			if($('.details-'+id).is(":hidden"))
        		{
          			$('.details-button-'+id).html('<span class="glyphicon glyphicon-chevron-down"></span>');
        		}
        		else
        		{
         			$('.details-button-'+id).html('<span class="glyphicon glyphicon-chevron-up"></span>');
        		}
      		});
    	}
  </script>
@stop