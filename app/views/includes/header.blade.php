<div class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon-bar"></span>
        		<span class="icon-bar"></span>
        		<span class="icon-bar"></span>
      		</button>
            <a class="navbar-brand"><img src="{{URL::to('/assets/img/dorelogo3.png')}}" style="width:130px;height:130px;"/></a>
    	</div>
    	<div class="collapse navbar-collapse">
      		<ul id="menu-buttons" class="nav navbar-nav">
            	<li class="hidden-xs"><a></a></li><li class="hidden-xs"><a></a></li><li class="hidden-xs"><a></a></li>
      			<li><a href="{{URL::to('/')}}">Home</a></li>
             	<li class="dropdown statsnav">
                    <!---->
                </li>
                <li><a href="{{URL::to('/servers')}}">Servers</a></li>
                <li><a href="http://dore2cuo.de/index/board/list" target="_blank">Forum</a></li>
      		</ul>
      		<ul class="nav navbar-nav navbar-right">
                <li><a href="{{URL::to('/admin')}}">Admin</a></li>
                <li><a><b>Players: <span id="ptotal" style="color:#d01b22;">-</span></b></a></li>
                <li><a><b>Online: <span id="ponline" style="color:#d01b22;">-</span></b></a></li>
      		</ul>
    	</div>
    </div>
</div>