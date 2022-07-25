<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
</head>
<body>
	<p id="id"></p>
<button type="button" id="exam" >CLick</button>

	<script type="text/javascript">
			let exam=document.getElementById("exam");
			exam.addEventListener('click',exam_session)

			function exam_session() {
				console.log("cik");

				const xhr = new XMLHttpRequest();

				

				// xhr.onprogress=function(){
				// 	console.log("On progress");
				// }

				// xhr.onload=function(){
				// 	console.log(this.responseText);
				// }


				  xhr.onreadystatechange = function() {
				    if (xhr.readyState == 4 && xhr.status == 200) {
				      // document.getElementById("semester").innerHTML =xhttp.responseText;
				      console.log(this.responseText);
				  }
				};
				  xhr.open("GET", "ajax/exam_session.php", true);
			// 	// xhr.open('GET','ajax/exam_session.php?group_token='+ group_token'&enrollment='+ enrollment,true);
				 
				xhr.send(null);
			}
		</script>
</body>
</html>