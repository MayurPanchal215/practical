<link href="{{ asset('css/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/jquery.dataTables.min.css') }}">
<div class="container">
  	<div class="row">
  		<div class="col-lg-12">
  			<form method="post" action="">
		  		<div class="form-group row">
					<label class="col-lg-1 col-form-label">Start Date</label>
					<div class="col-lg-4">
			  			<div class="input-group date" data-date-format="dd/mm/yyyy">
			    			<input type="text" class="form-control" placeholder="dd/mm/yyyy" name="start_date">
			    			<div class="input-group-addon" >
			      				<span class="glyphicon glyphicon-calendar"></span>
			    			</div>
			  			</div>
			  		</div>
		  		</div>
		  		<div class="form-group row">
					<label class="col-lg-1 col-form-label">End Date</label>
					<div class="col-lg-4">
			  			<div class="input-group date" data-date-format="dd/mm/yyyy">
			    			<input type="text" class="form-control" placeholder="dd/mm/yyyy" name="end_date">
			    			<div class="input-group-addon" >
			      				<span class="glyphicon glyphicon-calendar"></span>
			    			</div>
			  			</div>
			  		</div>
		  		</div>
		  		<div class="form-group row">
					<div class="col-lg-4">
			  			<a href="javascript:void(0);" class="btn btn-success" id="submit_btn">Save</a>
			  		</div>
		  		</div>
		  	</form>
	  	</div>
	  	<div id="tableDiv" style="display: none;">
		  	<table class="table table-striped table-bordered" id="eventList">
		  	    <thead>
		  	        <tr> 
		  	            <th>Event Name</th>
		  	            <th>Start Date</th>
		  	            <th>End Date</th>
		  	            <th>Location</th>
		  	        </tr>
		  	    </thead>
		  	    <tbody>
		  	        
		  	    </tbody>
		  	</table>
		  	<br/>
		  	<a href="javascript:void(0);" class="btn btn-primary" id="sendNotification">
	  			Send Notification
	  		</a>
		</div>
  	</div>
</div>

<script src="{{ asset('js/jquery.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/jquery.dataTables.min.js') }}" type="text/javascript"></script>
<script type="text/javascript">
	$(document).ready(function () {
		var start_date,end_date;
		
	 	$('.input-group.date').datepicker({
	 		format: "dd/mm/yyyy",
	 		autoclose: true,
	 	}); 

	 	$(document).on("click",'#submit_btn',function(){
	 		start_date = $("input[name='start_date']").val();
	 		end_date   = $("input[name='end_date']").val();
	 		$.ajax({
                url : "{{ route('event.get.list') }}",
                type : 'POST',
                data : { 
                    "start_date" : start_date,
                    "end_date" : end_date,
                    _token : '{{ csrf_token() }}'
                },
                success : function(result){
                	if( result.status == true ) {
                		var jsonData = result.tableData;
                		$("#tableDiv").css("display","block");
                		$("#eventList").DataTable({
                			"bDestroy": true,
                			data: jsonData,
                			columns: [
						      { data: 'name' },
						      { data: 'start_date' },
						      { data: 'end_date' },
						      { data: 'location' },
						    ]
                		});
                	}
                }
            });
		});

	 	$(document).on("click",'#sendNotification',function(){
	 		start_date = $("input[name='start_date']").val();
	 		end_date   = $("input[name='end_date']").val();
	 		$.ajax({
                url : "{{ route('event.send.notification') }}",
                type : 'POST',
                data : {
                	"start_date" : start_date,
                    "end_date" : end_date,
                    _token : '{{ csrf_token() }}'
                },
                success : function(result){
                	
                }
            });
		});
	});
</script>