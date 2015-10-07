@extends('layouts.default')
@section('content')
    <div id="page-content" class="container">
    	<div id="loadimg"><img src="{{URL::to('/assets/img/Preloader_10.gif')}}" style="width:50px;height:50px;display: block;margin: 0 auto;"/></div>
    	<div class="container none" style="display:none;">
    		<div class="row push">
    			<div class="col-md-4">
					<div class="panel panel-default">
						<div class="panel-heading panel-style" style="background:#d01b22;color:white;"> <span class="glyphicon glyphicon-list-alt"></span><b> Info Box</b></div>
							<div class="panel-body">
								<div class="row">
									<div id="news" class="col-xs-12">
										<!---->
									</div>
								</div>
							</div>
						<!--<div class="panel-footer panel-style"> </div>-->
					</div>
				</div>
				<div class="col-md-8">
					<div class="panel panel-default">
						<div class="panel-heading panel-style" style="background:#d01b22;color:white;"> <span class="glyphicon glyphicon-th-list"></span><b> Runs</b></div>
							<div class="panel-body">
								<div class="row">
									<div id="runs" class="col-xs-12" style="overflow:auto;">
										<table id="stats" class="table table-striped borderless" cellspacing="0" width="100%">
											<tbody class="runs">
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
		getNews();
		getRuns();

		var auto_refresh = setInterval(
		function () {
			getNews();
			getRuns();
		}, 30000);

		function getNews() {
			$.ajax({
				url: "{{URL::to('/api/admin/data/info')}}",
				type: "post",
				data: {'_token': '{{ csrf_token() }}'},
				success: function(data) {
					$('#news').html(data);
				}
			});
		}
		function getRuns() {
			$.ajax({
				url: "{{URL::to('/api/admin/data/runs')}}",
				type: "post",
				data: {'_token': '{{ csrf_token() }}'},
				success: function(data) {
					if(data!=0)
					{
						$('.runs').html("");
						for(var i in data) {
							var out="";
							out+='<tr style="background:white;">';
								name=data[i];
								out+='<td><b>'+(name.substr(0, 1).toUpperCase() + name.substr(1))+'</b></td>';
								link="{{URL::to('/statistics/"+data[i].toLowerCase()+"')}}"
								out+='<td><center><a href="'+link+'">View Statistics</a></center></td>';
							out+='</tr>';
							$('.runs').append(out);
						}
						if(data.length>1)
						{
							var out="";
							out+='<tr><td></td><td></td></tr>';
							out+='<tr style="background:white;">';
								out+='<td><b>Total</b></td>';
								link="{{URL::to('/statistics/total')}}"
								out+='<td><center><a href="'+link+'">View Statistics</a></center></td>';
							out+='</tr>';
							$('.runs').append(out);
						}
					}
					else
					{
						$('.runs').html("No runs.");
					}
				}
			});
		}
	</script>
@stop