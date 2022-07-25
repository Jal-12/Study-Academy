<?php
include '../inc/top.php';
?>

<body>
	<div class="container bg-white">	
		<div class="card-header">
			<div class="row">
				<div class="col-md-12">
					<h3 class="card-title text-lg-center">Manage Subejcts</h3>
				</div>
				<div class="col-md-3" align="right">
				</div>
			</div>
		</div>

		<div class="card-body">
		<!-- Button trigger modal -->
			<div class="modal fade" id="subjectModal" tabindex="-1" role="dialog" aria-labelledby="subjectModalLabel" aria-hidden="true">
			    <div class="modal-dialog" role="document">
			    	<div class="modal-content">
			      		<div class="modal-header">
			       		 	<h5 class="modal-title" id="subjectModalLabel">Update subject</h5>
			        			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          				<span aria-hidden="true">&times;</span>
			        			</button>
			      		</div>
			      		<div class="modal-body">
				    		<label for="subject">Update Subject:</label>
							<form method="post" id="updateSubject">
								<input id="updateSub" class="form-control mr-sm-2 " type="text" name="subject" placeholder="Enter subject">
							</form>  
						</div>
				      	<div class="modal-footer">
				        	<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				        	<button type="button" class="btn btn-primary" id="updatebtn">Save changes</button>
				      	</div>
				    </div>
				</div>
			</div>
		<!-- Button trigger modal ends -->

		<!-- Button trigger modal unit start-->
			<div class="modal fade" id="unitModal" tabindex="-1" role="dialog" aria-labelledby="unitModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
				    <div class="modal-content">
				      	<div class="modal-header">
				        	<h5 class="modal-title" id="unitModalLabel">Update Unit</h5>
				        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				          			<span aria-hidden="true">&times;</span>
				        		</button>
				      	</div>
				      	<div class="modal-body">
				      		<label for="unit">Update Unit No:</label>
								<form method="post" id="updateUnits">
								</form>
				      	</div>
				      	<div class="modal-footer">
				        	<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				       	 	<button type="button" class="btn btn-primary" id="updateubtn" >Save changes</button>
				      	</div>
				    </div>
				</div>
			</div>
		<!-- Button trigger modal unit ends -->

		<div class="table-responsive">
		<!-- Empty Valure Alert start -->
			<div style="display: none;" id="alertshow" class="alert alert-danger alert-dismissible fade show " role="alert">
				<strong>Plase Enter Values!</strong>
				   	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				    	<span aria-hidden="true">&times;</span>
				  	</button>
			</div>
			<div style="display: none;" id="alertsub" class="alert alert-success alert-dismissible fade show " role="alert">
				<strong>Subject Inserted !</strong>
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				    	<span aria-hidden="true">&times;</span>
				  	</button>
			</div>
			<div style="display: none;" id="alertshowsuc" class="alert alert-success alert-dismissible fade show " role="alert">
				<strong>Subject updated!</strong>
				  	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				    	<span aria-hidden="true">&times;</span>
				  	</button>
			</div>
		<!-- Empty Valure Alert Ends -->
			<table class="table thover ts ">
				<tr>
					<td id="label"><label>Department:</label></td>
					<td>
					<?php	echo department();	?>
					</td>
				</tr>
				<tr>
					<td id="label"><label for="semester">Semester:</label></td>
					<td>
					<?php 	echo semester();	?>
					</td>
				</tr>
				<tr>
					<td id="label"><label for="subject">Add Subject:</label></td>
					<td>
						<form method="post" id="addForm">
							<input id="subject" class="form-control mr-sm-2 " type="text" name="subject" placeholder="Enter subject">
						</form>
					</td>
				</tr>
				<tr>
					<td colspan="2" align="center">
						<input type="submit" class="btn btn-lg btn-primary" name="add_subject" id="add_subject"  value="Add Sujbect">
					</td>
				</tr>
				<tr>
					<table id="sub" class="table table-bordered"  border="1"></table>
				</tr>
			</table>
		<!-- Units header below -->
			<div class="card-header ">
				<hr>
					<center>
						<h3 class="card-title">Manage Units</h3>
					</center>
			</div>
		<!-- Units error/success messages below -->
			<div style="display: none;" id="alertunit" class="alert alert-success alert-dismissible fade show " role="alert">
				<strong>Subject Inserted !</strong>
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
			</div>
			<div style="display: none;" id="alertshowu" class="alert alert-danger alert-dismissible fade show " role="alert">
				<strong>Plase Enter Values!</strong>
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
			</div>
			<div style="display: none;" id="alertshowsucu" class="alert alert-success alert-dismissible fade show " role="alert">
				<strong>Unit updated!</strong>
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
			</div>

		<!-- Units showing below -->
			<table id="units" class="table table-bordered"  border="1"></table>
				<div class="addu border-0 p-2" id="addu" style="display: none; background-color: rgba(0, 0, 0, 0.05);" >
					<table width="100%">
						<tr style="">
							<form method="post" id="addUnitForm">
								<td id="label" width="40%" align="right"><label for="uno">Add Unit Number</label></td>
								<td >
									<input id="unitNumber" class="form-control mr-sm-2 m-2" type="text" name="unitNumber" placeholder="Unit Number">
								</td>
						</tr>
						<tr>
							<td id="label" width="40%" align="right"><label for="una">Add Unit Name:</label></td>
							<td >
								<input id="unitName" class="form-control mr-sm-2 m-2" type="text" name="unitName" placeholder="Enter Unit Name">
							</td>
							</form>
						</tr>
						<tr>
							<td colspan="4" align="center">
								<button class="btn btn-primary" id="add_unit">Add Unit</button>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
	<script>		
	$(document).ready(function()
	{
	// load table automatically
				function loadSubjects(){

					var d_id=$("#department").val();
					var semester=$("#semester").val();
					
					$.ajax({
						url:"ajax.subject_load.php",
						type: "POST",
						data: {semester:semester,  d_id:d_id},
						success:function(data){
							console.log(data);
							$("#sub").html(data);
						}
					});
				}


//on change department
				$("#department").change(function(){
					var d_id=$("#department").val();
					var semester=$("#semester").val();
					// console.log(d_id);
					// console.log(semester);
					
						$.ajax({
							url:"ajax.subject_load.php",
							type: "POST",
							data: {semester:semester,  d_id:d_id},
							success:function(data){
								console.log(data);
								$("#sub").html(data);
								$("#units").hide();
								$("#addu").hide();
							}
						});
					});
			
			loadSubjects();

			
// on chnage semester
				$("#semester").change(function(){
					var d_id=$("#department").val();
					var semester=$("#semester").val();
					// console.log(d_id);
					// console.log(semester);
					
						$.ajax({
							url:"ajax.subject_load.php",
							type: "POST",
							data: {semester:semester,  d_id:d_id},
							success:function(data){
								// console.log(data);
								$("#sub").html(data);
								$("#units").hide();
								$("#addu").hide();


							}
						});
					});
			
			loadSubjects();

// add subjects according to semester and depatmentswise
			$("#add_subject").on("click",function(){
				var add_d_id=$("#department").val();
				var add_semester=$("#semester").val();
				var add_subject=$("#subject").val();
					if(add_d_id=="" || add_semester=="" || add_subject==""){
						$("#alertshow").show();
						
					} else {

					$.ajax({
						url:"ajax.subject_load.php",
						type: "POST",
						data: {add_d_id:add_d_id, add_semester:add_semester, add_subject:add_subject},
						success:function(data){
							if(data==1){							
								$("#addForm").trigger("reset");

								loadSubjects();
								$("#alertsub").show();


							}else{
								alert(data);
							}
						}
					});
				}
			});



// Update subjects according to semester and depatmentswise
			$(document).on("click",".edit-btn", function(){

				var sub_id= $(this).data("eid");
				// var element=this;
				$.ajax({
					url:"ajax.subject_load.php",
					type:"POST",
					data:{update_sub_id: sub_id},
					success: function(data){
						if(data==1){

							// loadSubjects();
							alert(data);
						}else{
							$("#updateSubject").html(data);
						}
					}
				});
			});

			$(document).on("click","#updatebtn", function(){
				//imp thing
				$("[data-dismiss=modal]").trigger({ type: "click" });
				//
				var updateSubject= $("#updateSub").val();
				var updateSub_id= $("#updateSub_id").val();
				if(updateSubject==""){
						
					} else {
				// var element=this;
				$.ajax({
					url:"ajax.subject_load.php",
					type:"POST",
					data:{updateSubject:updateSubject, updateSub_id:updateSub_id},
					success: function(data){
							if(data==1){
							// $("#subjectModal").hide();
							// $('#subjectModal').modal('hide');
							// window.location.href=window.location.href;

							$("#alertshowsuc").show();
							// alert("Subject updated");
							}else{
								alert("Subject Not");
							// $("#updateSubject").html(data);
							}
							loadSubjects();
						}
					});
				}
			});

// delete subjects according to semester and depatmentswise

			$(document).on("click",".delete-btn", function(){
			if(confirm("Do you realy want to delete this record")){
				var sub_id= $(this).data("did");
				var element=this;
					$.ajax({
						url:"ajax.subject_load.php",
						type:"POST",
						data:{sub_id: sub_id},
						success: function(data){
							if(data==1){
								$(element).closest("tr").fadeOut();
								loadSubjects();
							}else{
								alert(data);
							}
						}
					});
				}
			});




//units codes are bellow add load, upadtea and delte

			function loadUnits(sub_id){
				$.ajax({
						url:"ajax.subject_load.php",
						type:"GET",
						data: {sub_id:sub_id },
						success: function(data){
							
								$("#units").html(data);
								$("#units").show();

						}
					});

			}

			$(document).on("click",".unit", function(){

				// var d_id=$("#department").val();
				// var semester=$("#semester").val();
				var sub_id= $(this).data("unit");


				// console.log(sub_id);
				$("#addu").show();
				loadUnits(sub_id);
				// console.log(semester+"= sem");
				// console.log(d_id+"= dpt");
					
			});
			$(document).on("click","#add_unit", function(){
				var add_unitNumber=$("#unitNumber").val();
				var add_unitName=$("#unitName").val();
				var add_unit_sub_id=$("#add_unit_sub_id").val();

				console.log("click");
				console.log(add_unitNumber);
				console.log(add_unitName);
				console.log(add_unit_sub_id);
					if(add_unitNumber=="" || add_unitName=="" || add_unit_sub_id==""){
						$("#alertshowu").show();
						
					} else {

					$.ajax({
						url:"ajax.subject_load.php",
						type: "POST",
						data: {add_unitNumber:add_unitNumber, add_unitName:add_unitName, add_unit_sub_id:add_unit_sub_id},
						success:function(data){
							if(data==1){							
								$("#addUnitForm").trigger("reset");

								$("#alertunit").show();
								loadUnits(add_unit_sub_id);


							}else{
								alert(data);
							}
						}
					});
				}


			});
			// add subjects according to semester and depatmentswise



// Update subjects according to semester and depatmentswise
			$(document).on("click",".edit-ubtn", function(){

				var unit_id= $(this).data("euid");
				// var element=this;
				$.ajax({
					url:"ajax.subject_load.php",
					type:"POST",
					data:{update_unit_id: unit_id},
					success: function(data){
						if(data==1){

							// loadSubjects();
							alert(data);
						}else{
							$("#updateUnits").html(data);
						}
					}
				});
			});

			$(document).on("click","#updateubtn", function(){
				//imp thing
				$("[data-dismiss=modal]").trigger({ type: "click" });
				//
				var updateUnitName= $("#updateUnitName").val();
				var updateUnitNo= $("#updateUnitNo").val();
				var update_unit_id= $("#update_unit_id").val();
				var add_unit_sub_id=$("#add_unit_sub_id").val();

				// console.log(add_unit_sub_id+"sub_id");
				// console.log(updateUnitName);
				// console.log(updateUnitNo);
				// console.log(update_unit_id);
				if(updateUnitName=="" || updateUnitNo=="" || update_unit_id==""){
						
				} else {
				// var element=this;
				$.ajax({
					url:"ajax.subject_load.php",
					type:"POST",
					data:{updateUnitName:updateUnitName, updateUnitNo:updateUnitNo, update_unit_id:update_unit_id},
					success: function(data){
							if(data==1){

								loadUnits(add_unit_sub_id);
								$("#alertshowsucu").show();

							}else{
								alert(data);
							}

						}
					});
				}
			});


			$(document).on("click",".delete-ubtn", function(){
			if(confirm("Do you realy want to delete this record")){
				var unit_id= $(this).data("duid");
				var add_unit_sub_id=$("#add_unit_sub_id").val();
				var element=this;
					$.ajax({
						url:"ajax.subject_load.php",
						type:"POST",
						data:{unit_id: unit_id},
						success: function(data){
							if(data==1){
								$(element).closest("tr").fadeOut();
								loadUnits(add_unit_sub_id);
							}else{
								alert(data);
							}
						}
					});
				}
			});


});


		</script>
<?php include 'footer.php'; ?>