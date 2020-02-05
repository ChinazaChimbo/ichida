
<script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>
  <script src="js/parsley.min.js"></script>
  <script src="js/wow.min.js"></script>

<script>
  function printDiv(divName) {
    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;

    document.body.innerHTML = printContents;

    window.print();

    document.body.innerHTML = originalContents;
  }

  $(document).ready(function() {
	$('#printbtn').on('click', function() {
		$("#printbtn").attr("disabled", "disabled");
		var name = $('#url').val();
		if(name!=""){
			$.ajax({
				url: "save.php",
				type: "POST",
				data: {
					name: name			
				},
				cache: false,
				success: function(dataResult){
					var dataResult = JSON.parse(dataResult);
					if(dataResult.statusCode==200){
						location.reload(forceGet);			
					}
					else if(dataResult.statusCode==201){
					   alert("Error occured !");
					}
					
				}
			});
		}
		else{
			alert('Please fill all the field !');
		}
	});
});

function show(){
	var cashform = document.getElementById("cashform");
	var checkform = document.getElementById("chequeform");
	var transform = document.getElementById("transform");
	var type = document.getElementById("itype");

	if(type.value == "none"){
		cashform.style.display = "none";
		checkform.style.display = "none";
		transform.style.display = "none";
	}else if(type.value == "cash"){
		cashform.style.display = "block";
		checkform.style.display = "none";
		transform.style.display = "none";
	}else if(type.value == "cheque"){
		cashform.style.display = "none";
		checkform.style.display = "block";
		transform.style.display = "none";
	}else if(type.value == "transfer"){
		cashform.style.display = "none";
		checkform.style.display = "none";
		transform.style.display = "block";
	}
}
</script>
