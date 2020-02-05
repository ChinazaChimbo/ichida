<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Image upload and generate thumbnail using ajax in PHP</title>
<script src="./js/jquery.min.js"></script>
<script src="./js/jquery.form.js"></script>
<script>
$(document).on('change', '#pic', function () {
var progressBar = $('.progressBar'), bar = $('.progressBar .bar'), percent = $('.progressBar .percent');

$('#image_upload_form').ajaxForm({
    beforeSend: function() {
		progressBar.fadeIn();
        var percentVal = '0%';
        bar.width(percentVal)
        percent.html(percentVal);
    },
    uploadProgress: function(event, position, total, percentComplete) {
        var percentVal = percentComplete + '%';
        bar.width(percentVal)
        percent.html(percentVal);
    },
    success: function(html, statusText, xhr, $form) {		
		obj = $.parseJSON(html);	
		if(obj.status){		
			var percentVal = '100%';
			bar.width(percentVal)
			percent.html(percentVal);
			$("#imgArea>img").prop('src',obj.image_medium);			
		}else{
			alert(obj.error);
		}
    },
	complete: function(xhr) {
		progressBar.fadeOut();			
	}	
}).submit();		

});
</script>
<style>
    #imgContainer {
width: 100%;
text-align: center;
position: relative;
}
#imgArea {
display: inline-block;
margin: 0 auto;
width: 150px;
height: 150px;
position: relative;
background-color: #eee;
font-family: Arial, Helvetica, sans-serif;
font-size: 13px;
}
#imgArea img {
outline: medium none;
vertical-align: middle;
width: 100%;
}
#imgChange {
background: url("../img/overlay.png") repeat scroll 0 0 rgba(0, 0, 0, 0);
bottom: 0;
color: #FFFFFF;
display: block;
height: 30px;
left: 0;
line-height: 32px;
position: absolute;
text-align: center;
width: 100%;
}
#imgChange input[type="file"] {
bottom: 0;
cursor: pointer;
height: 100%;
left: 0;
margin: 0;
opacity: 0;
padding: 0;
position: absolute;
width: 100%;
z-index: 0;
}

/* Progressbar */.progressBar {
background: none repeat scroll 0 0 #E0E0E0;
left: 0;
padding: 3px 0;
position: absolute;
top: 50%;
width: 100%;
display: none;
}
.progressBar .bar {
background-color: #FF6C67;
width: 0%;
height: 14px;
}
.progressBar .percent {
display: inline-block;
left: 0;
position: absolute;
text-align: center;
top: 2px;
width: 100%;
}
</style>
</head>

<body>

<br>


<div id="imgContainer">
  <form enctype="multipart/form-data" action="image_upload_demo_submit.php" method="post" name="image_upload_form" id="image_upload_form">
    <div id="imgArea"><img src="./img/default.jpg">
      <div class="progressBar">
        <div class="bar"></div>
        <div class="percent">0%</div>
      </div>
      <div id="imgChange"><span>Change Photo</span>
        <input type="file" accept="image/*" name="pic" id="pic">
      </div>
    </div>
  </form>
</div>
</body>
</html>
