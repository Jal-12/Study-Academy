<script>
			$(document).ready(function(){

//on change department
				$("#department").change(function(){
					var department=$("#department").val();
					var semester=$("#semester").val();
					
				$.ajax({
					url:"ajax.subject_load.php",
					type: "POST",
					data: {semester:semester, department:department},
					success:function(data){
						// console.log(data);
						if ($("#subject").html(data)) {
							var uploadEditsub_id=$("#subject").val();

							$.ajax({
								url:"ajax.subject_load.php",
								type: "POST",
								data: {uploadEditsub_id:uploadEditsub_id},
								success:function(udata){
									console.log(udata);
									$("#unit").html(udata);
									}
								});
							}
						}
					});
				});
			
// on chnage semester
				$("#semester").change(function(){
				var department=$("#department").val();
				var semester=$("#semester").val();
				
				$.ajax({
					url:"ajax.subject_load.php",
					type: "POST",
					data: {semester:semester, department:department},
					success:function(data){
						// console.log(data);
							if ($("#subject").html(data)) {
								var uploadEditsub_id=$("#subject").val();

							$.ajax({
								url:"ajax.subject_load.php",
								type: "POST",
								data: {uploadEditsub_id:uploadEditsub_id},
								success:function(udata){
									console.log(udata);
									$("#unit").html(udata);
									}
								});
							}
						}
					});
				});

// units change
				$("#subject").change(function(){
				var uploadEditsub_id=$("#subject").val();
			
				console.log(uploadEditsub_id);
				var uploadEditsub_id=$("#subject").val();

							$.ajax({
								url:"ajax.subject_load.php",
								type: "POST",
								data: {uploadEditsub_id:uploadEditsub_id},
								success:function(udata){
									console.log(udata);
									$("#unit").html(udata);
									}
								});
							});
						});
						
const input = document.getElementById('file')

input.addEventListener('change', (event) => {
  const target = event.target
  	if (target.files && target.files[0]) {

      /*Maximum allowed size in bytes
        5MB Example
        Change first operand(multiplier) for your needs*/
      const maxAllowedSize = 40 * 1024 * 1024;
      if (target.files[0].size > maxAllowedSize) {
      	// Here you can ask your users to load correct file
       	target.value = ''
       alert("File too big! Maximum 40MB Accepted");
      }
  }
});
	
		</script>

<div class="bg-dark my-4 text-white text-center p-2" style="font-size: 15px;">Copyright &#169; <?php echo date('Y'); ?> STUDY-ACADEMY | All Rights Reserved</div>
	</body>
</html>
