<div class="container">
    <p class="pull-left" style="font-size: 11px; padding: 18px 0 0 20px;">
        &copy; 2015 by <a href="http://www.linkedin.com/profile/view?id=386773955" target="_blank">psadaic</a> <a href="http://www.linkedin.com/profile/view?id=386773955" target="_blank"><img src="{{URL::to('/assets/img/icon-linkedin.gif')}}" alt="psadaic" style="width:10px;height:10px;"/></a> <br/> Data updates each 30 seconds
    </p>
    <p class="pull-right" style="padding: 22px 10px 0 0;">
        <a href="http://www.dore2cuo.de" target="_blank"><strong style="font-size: 18px;"><span style="color: #d01b22;">dore<sup>2</sup></span><span style="color: #737373;">cuo<span style="font-size:80%">.de</span></span></strong></a>
    </p>
</div>
<script type="text/javascript">
    $.ajaxSetup({
        headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
    });
</script>
<script type="text/javascript">
	getStatsNav();
	loadPlayerNum();

	var auto_refresh = setInterval(
    	function () {
        	getStatsNav();
        	loadPlayerNum();
    	}, 30000);

	function loadPlayerNum() {
		$.ajax({
			url: "{{URL::to('/api/data/player/num')}}",
			type: "post",
			data: {'_token': '{{ csrf_token() }}'},
			success: function(data){
            	$('#ptotal').html(data[0]);
				$('#ponline').html(data[1]);
			}
		});
	}

    function getStatsNav() {
        $.ajax({
        	url: "{{URL::to('/api/admin/data/runs')}}",
            type: "post",
            data: {'_token': '{{ csrf_token() }}'},
            success: function(data) {
                if(data!=0)
                {
                    var out="";
                    out+='<a href="#" data-toggle="dropdown" class="dropdown-toggle">Statistics <b class="caret"></b></a>';
                    out+='<ul class="dropdown-menu">';
                    for(var i in data) {
                        name=data[i];
                        link="{{URL::to('/statistics/"+data[i].toLowerCase()+"')}}"
                        out+='<li><a href="'+link+'"><center>'+(name.substr(0, 1).toUpperCase() + name.substr(1))+'</center></a></li>';
                    }
                    if(data.length>1)
                    {
                        link="{{URL::to('/statistics/total')}}"
                        out+='<li><a href="'+link+'"><center><b>Total</b></center></a></li>';
                    }
                    out+='</ul>';
                    $('.statsnav').html(out);
                }
             }
        });
    }
</script>