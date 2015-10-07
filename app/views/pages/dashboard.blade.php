@extends('layouts.admin')
@section('content')
    <div id="page-content" class="container">
    	<div id="loadimg"><img src="{{URL::to('/assets/img/Preloader_10.gif')}}" style="width:50px;height:50px;display: block;margin: 0 auto;"/></div>
    	<div class="container none" style="display:none;">
    		<div class="row push">
    			<div class="col-md-6">
					<div class="panel panel-default">
						<div class="panel-heading panel-style" style="background:#d01b22;color:white;"> <span class="glyphicon glyphicon-list-alt"></span><b> Info Box</b></div>
							<div class="panel-body">
								<div class="row">
									<div id="news" class="col-xs-12">
										<div class="news"></div>
                                		<button class="btn btn-md btn-dore" style="float:right;" onclick="changeInfo()">Update Info</button>
									</div>
								</div>
							</div>
						<!--<div class="panel-footer panel-style"> </div>-->
					</div>
				</div>
				<div class="col-md-6">
					<div class="panel panel-default">
						<div class="panel-heading panel-style" style="background:#d01b22;color:white;"> <span class="glyphicon glyphicon-th-list"></span><b> Runs</b></div>
							<div class="panel-body">
								<div class="row">
									<div id="runs" class="col-xs-12">
										<div class="runs" style="word-wrap: break-word;"></div>
										<div class="form-group">
                                    		<input class="form-control" placeholder="Run" name="run" type="run" autofocus>
                                		</div>
                                		<div class="form-group">
                                    		<input class="form-control" placeholder="MapId1,MapId2,MapId3,..." name="maps" type="maps" autofocus>
                                		</div>
                                		<button class="btn btn-md btn-dore" style="float:right;" onclick="addRun()">Add Run</button>
									</div>
								</div>
							</div>
						<!--<div class="panel-footer panel-style"> </div>-->
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="panel panel-default">
						<div class="panel-heading panel-style" style="background:#d01b22;color:white;"> <span class="glyphicon glyphicon-tasks"></span><b> Servers</b></div>
							<div class="panel-body">
								<div class="row">
									<div id="servers" class="col-xs-12" style="overflow:auto;">
										<table id="stats" class="table table-striped borderless" cellspacing="0" width="100%">
											<thead>
												<tr>
													<th><center>IP</center></th>
													<th><center>Port</center></th>
													<th><center>User</center></th>
													<th><center>Pass</center></th>
													<th><center>Login</center></th>
													<th><center><!--Delete--></center></th>
												</tr>
											</thead>
											<tbody class="servers">
												<!---->
											</tbody>
										</table>
										<hr/>
										<div class="form-group">
                                    		<input class="form-control" placeholder="IP" name="ip" type="ip" autofocus>
                                		</div>
                                		<div class="form-group">
                                			<input class="form-control" placeholder="Port" name="port" type="port" autofocus>
                                		</div>
                                		<div class="form-group">
                                    		<input class="form-control" placeholder="User" name="user" type="user" autofocus>
                                		</div>
                                		<div class="form-group">
                                    		<input class="form-control" placeholder="Pass" name="pass" type="pass" autofocus>
                                		</div>
                                		<div class="form-group">
                                    		<input class="form-control" placeholder="Login" name="login" type="login" autofocus>
                                		</div>
                                		<button class="btn btn-md btn-dore" style="float:right;" onclick="addServer()">Add Server</button>
									</div>
								</div>
							</div>
						<!--<div class="panel-footer panel-style"> </div>-->
					</div>
				</div>
				<div class="col-md-6">
					<div class="panel panel-default">
						<div class="panel-heading panel-style" style="background:#d01b22;color:white;"> <span class="glyphicon glyphicon-cog"></span><b> Settings</b></div>
							<div class="panel-body">
								<div class="row">
									<div id="settings" class="col-xs-12">
										<div class="username"></div>
                                		<div class="form-group">
                                			<button class="btn btn-md btn-dore" onclick="changeUsername()">Update Username</button>
                                		</div>
                                		<div class="form-group">
                                    		<input class="form-control" placeholder="Password" name="password" type="password" autofocus>
                                		</div>
                                		<div class="form-group">
                                    		<input class="form-control" placeholder="Repeat Password" name="rpassword" type="password" autofocus>
                                		</div>
                                		<button class="btn btn-md btn-dore" style="float:right;" onclick="changePassword()">Update Password</button>
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
		getUsername();
		getServers();
		getRuns();

		var auto_refresh = setInterval(
		function () {
			getNews();
			getUsername();
			getServers();
			getRuns();
		}, 30000);

		function getNews() {
			$.ajax({
				url: "{{URL::to('/api/admin/data/info')}}",
				type: "post",
				data: {'_token': '{{ csrf_token() }}'},
				success: function(data) {
					var out="";
					out+=data;
					out+='<hr/>';
					out+='<div class="form-group">';
                    	out+='<input class="form-control input-lg" value="'+data+'" name="info" type="info" autofocus>';
                    out+='</div>';
					$('.news').html(out);
				}
			});
		}

		function getUsername() {
			$.ajax({
				url: "{{URL::to('/api/admin/data/username')}}",
				type: "post",
				data: {'_token': '{{ csrf_token() }}'},
				success: function(data) {
					var out="";
					out+='<div class="form-group">';
                        out+='<input class="form-control" value="'+data+'" name="username" type="username" autofocus>';
                    out+='</div>';
					$('.username').html(out);
				}
			});
		}

		function getServers() {
			$.ajax({
				url: "{{URL::to('/api/admin/data/servers')}}",
				type: "post",
				data: {'_token': '{{ csrf_token() }}'},
				success: function(data) {
					$('.servers').html("");
					for(var i in data) {
						var out="";
						out+='<tr style="background:white;">';
							out+='<td><center>'+data[i].ip+'</center></td>';
							out+='<td><center>'+data[i].port+'</center></td>';
							out+='<td><center>'+data[i].user+'</center></td>';
							out+='<td><center>'+data[i].pass+'</center></td>';
							out+='<td><center>'+data[i].login+'</center></td>';
							out+='<td><center><button class="btn btn-xs btn-dore" onclick="deleteServer('+data[i].id+')">Delete</button></center></td>';
						out+='</tr>';
						$('.servers').append(out);
					}
				}
			});
		}

		function getRuns() {
			$.ajax({
				url: "{{URL::to('/api/admin/data/run')}}",
				type: "post",
				data: {'_token': '{{ csrf_token() }}'},
				success: function(data) {
					$('.runs').html("");
					for(var i in data) {
						var out="";
						name=data[i].name;
						out+='<b>'+(name.substr(0, 1).toUpperCase() + name.substr(1))+'</b> <button class="btn btn-xs btn-dore" style="float:right;" onclick="deleteRun('+data[i].id+')">Delete</button>';
						out+='<ul>';
							out+='<li><b>Maps</b><br/>';
								out+=data[i].maps;
							out+='</li>';
						out+='</ul>';
						out+='<hr/>';
						$('.runs').append(out);
					}
				}
			});
		}

		function changeInfo() {
			var info=document.getElementsByName('info')[0].value;
            $.ajax({
				url: "{{URL::to('/api/admin/change/info')}}",
				type: "post",
				data: {'_token': '{{ csrf_token() }}', 'info': info},
				success: function(data){
					if(data!=0)
					{
						getNews();
					}
				}
			});
		}

		function changeUsername() {
			var username=document.getElementsByName('username')[0].value;
            $.ajax({
				url: "{{URL::to('/api/admin/change/username')}}",
				type: "post",
				data: {'_token': '{{ csrf_token() }}', 'username': username},
				success: function(data){
					if(data!=0)
					{
						getUsername();
					}
				}
			});
		}

		function changePassword() {
			var password=document.getElementsByName('password')[0].value;
			var rpassword=document.getElementsByName('rpassword')[0].value;
			if(password===rpassword)
			{
				$.ajax({
					url: "{{URL::to('/api/admin/change/password')}}",
					type: "post",
					data: {'_token': '{{ csrf_token() }}', 'password': password},
					success: function(data){
						if(data!=0)
						{
							alert('Password updated successfully!');
						}
					}
				});
			}
			else 
			{
				alert('Passwords does not match!');
			}
		}

		function addServer() {
			var ip=document.getElementsByName('ip')[0].value;
			var port=document.getElementsByName('port')[0].value;
			var user=document.getElementsByName('user')[0].value;
			var pass=document.getElementsByName('pass')[0].value;
			var login=document.getElementsByName('login')[0].value;
			$.ajax({
				url: "{{URL::to('/api/admin/add/server')}}",
				type: "post",
				data: {'_token': '{{ csrf_token() }}', 'ip': ip, 'port': port, 'user': user, 'pass': pass, 'login': login},
				success: function(data){
					if(data!=0)
					{
						getServers();
					}
				}
			});
		}

		function deleteServer(id) {
			$.ajax({
				url: "{{URL::to('/api/admin/delete/server')}}",
				type: "post",
				data: {'_token': '{{ csrf_token() }}', 'id': id},
				success: function(data){
					if(data!=0)
					{
						getServers();
					}
				}
			});
		}

		function addRun() {
			var run=document.getElementsByName('run')[0].value;
			var maps=document.getElementsByName('maps')[0].value;
			$.ajax({
				url: "{{URL::to('/api/admin/add/run')}}",
				type: "post",
				data: {'_token': '{{ csrf_token() }}', 'run': run, 'maps': maps},
				success: function(data){
					if(data!=0)
					{
						getRuns();
					}
				}
			});
		}

		function deleteRun(id) {
			$.ajax({
				url: "{{URL::to('/api/admin/delete/run')}}",
				type: "post",
				data: {'_token': '{{ csrf_token() }}', 'id': id},
				success: function(data){
					if(data!=0)
					{
						getRuns();
					}
				}
			});
		}
	</script>
@stop