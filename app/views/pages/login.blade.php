@extends('layouts.default')
@section('content')
    <div id="page-content" class="container">
    	<div id="loadimg"><img src="{{URL::to('/assets/img/Preloader_10.gif')}}" style="width:50px;height:50px;display: block;margin: 0 auto;"/></div>
    	<div class="container none" style="display:none;">
        	<div class="row">
            	<div class="col-md-4 col-md-offset-4">
                	<div class="login-panel panel panel-default">
                    	<div class="panel-heading" style="background:#d01b22;color:white;">
                        	<h3 class="panel-title"><b>Login</b></h3>
                    	</div>
                    	<div class="panel-body">
                            <fieldset>
                            	<div id="loginalert"></div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Username" name="username" type="username" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="password" type="password" value="">
                                </div>
                                <button class="btn btn-lg btn-dore btn-block" onclick="validateForm()">Login</button>
                            </fieldset>
                    	</div>
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
		function validateForm() {
			var username=document.getElementsByName('username')[0].value;
            var password=document.getElementsByName('password')[0].value;
            if((username==null || username=="")||(password==null || password=="")) {
                $('#loginalert').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert">&times;</a><strong>Warning!</strong> Please fill in all fields!</div>');
            }
            else {
            	$.ajax({
					url: "{{URL::to('/api/admin/login')}}",
					type: "post",
					data: {'_token': '{{ csrf_token() }}', 'username': username, 'password': password},
					success: function(data){
						if(data!=0)
						{
							window.location = "{{URL::to('admin')}}";
						}
						else
						{
							$('#loginalert').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert">&times;</a><strong>Error!</strong> Invalid login data!</div>');
						}
					}
				});
            }
		}
	</script>
@stop