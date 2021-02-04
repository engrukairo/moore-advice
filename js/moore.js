$("#newTask").on('submit', function (e) {e.preventDefault();
		taskname = $(".taskname").val();
		taskowner = $(".taskowner").val();
		taskstime = $(".taskstime").val();
		tasketime = $(".tasketime").val();
		taskdesc = $(".taskdesc").val();

		$.ajax({
			method: 'POST',
			dataType: 'text',
			async: false,
			data: {
				taskname: taskname,
				taskowner: taskowner,
				taskstime: taskstime,
				tasketime: tasketime,
				taskdesc: taskdesc
			},
			beforeSend: function(){
				$('#subTask').html('<i class="fa fa-spin fa-spinner"></i> Submitting task...');
			},
			success: function (response) {
				$('#tasknot').html("<i class='fa fa-check'></i> The task has been submitted.").addClass("alert alert-success").show().fadeOut(3000);
                $("#newTask").trigger("reset");
				$('#subTask').html('Submit Task').blur();
			}
		});
});

$("#editTask").on('submit', function (e) {e.preventDefault();
		taskname = $(".taskname").val();
		taskowner = $(".taskowner").val();
		taskstime = $(".taskstime").val();
		tasketime = $(".tasketime").val();
		taskdesc = $(".taskdesc").val();
		taskid = $(".taskid").val();

		$.ajax({
			method: 'POST',
			dataType: 'text',
			async: false,
			data: {
				taskname: taskname,
				taskowner: taskowner,
				taskstime: taskstime,
				tasketime: tasketime,
				taskdesc: taskdesc,
				taskid: taskid
			},
			beforeSend: function(){
				$('#updTask').html('<i class="fa fa-spin fa-spinner"></i> Updating task...');
			},
			success: function (response) {
				$('#tasknot').html("<i class='fa fa-check'></i> The task has been updated.").addClass("alert alert-success");
				$('#updTask').html('Submit Task').blur();
			}
		});
});

function deleteTask(id) {
		$.ajax({
			method: 'POST',
			dataType: 'text',
			async: false,
			data: {
				deleteTask: 1,
				id: id
			},
	beforeSend: function(){
		alert("Do you really want to delete this task?");
	},
	success: function(data){
		window.location = "https://moore.esperasoft.com";
	}
	});
}


	$('.subMoore').on('click', function() {
		$(".subMoore").html('<i class="fa fa-spin fa-spinner"></i> Processing...');
	});

 function load_data(query)
 {
  $.ajax({
   url:"https://moore.esperasoft.com/search",
   method:"POST",
   data:{query:query},
   success:function(data)
   {
    $('#result').html(data);
   }
  });
 }
 $('#search_text').keyup(function(){
  var search = $(this).val();
  if(search != '')
  {
   load_data(search);
  }
 });
