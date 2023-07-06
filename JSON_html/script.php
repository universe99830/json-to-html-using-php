<?php
    $field='fileToUpload';
		$outurl = "output.html";
    if( $_SERVER['REQUEST_METHOD']=='POST' && !empty( $_FILES ) ){
			$obj=(object)$_FILES[ $field ];
			$error=$obj->error;
			$name = $obj -> name;
        if( $error==UPLOAD_ERR_OK ){
            /* 
                This is where you would process the uploaded file
                with various tests to ensure the file is OK before
                saving to disk.

                What you send back to the user is up to you - it could
                be json,text,html etc etc but here the ajax callback 
                function simply receives the name of the file chosen.
            */
						$data = file_get_contents($_FILES["fileToUpload"]["tmp_name"]);
						include ('outsample.php');
						$target_dir = "uploads/";
            $file_name = basename( $_FILES["fileToUpload"]["name"]);
            $target_file = $target_dir . $file_name;
						move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
        } else {
            echo "No json file!";
        }
				ob_start();
				include('outsample.php');
				file_put_contents("uploads/generate.html", ob_get_clean());
				exit();
			}
?>
<!doctype html>
<html>
    <head>
        <title>Convert JSON to HTML</title>
        <script>
					document.addEventListener('DOMContentLoaded',function(e){
							var btn=document.getElementById('ubtn');
							btn.onclick=function(e){
									/* Assign a new FormData object using the buttons parent ( the form ) as the argument */
									var data=new FormData( e.target.parentNode );
									var xhr=new XMLHttpRequest();
									xhr.onload=function(e){
											document.getElementById('status').innerHTML=this.response;
									}
									xhr.onerror=function(e){
											alert(e);
									}
									xhr.open('POST',location.href,true);
									xhr.send(data);
							};
					}, false);										
				</script>
				 <style type="text/css">
					.form-class {
						margin: 10px 10px;
						display: flex;
					}
					p {
						font-size:20px;

					}
					.input {
						margin-top:10px;
						font-size: 16px;
						cursor: pointer;
				
					}
					.input-btn {
						--mdb-btn-bg: #3b71ca;
            --mdb-btn-color: #fff;
            --mdb-btn-box-shadow: 0 4px 9px -4px #3b71ca;
            --mdb-btn-hover-bg: #386bc0;
            --mdb-btn-hover-color: #fff;
            --mdb-btn-focus-bg: #386bc0;
            --mdb-btn-focus-color: #fff;
            --mdb-btn-active-bg: #3566b6;
            --mdb-btn-active-color: #fff;
		        --backgroun-color:#3566b6;
						background-color:#386bc0;
						outline:none;
						color:white;
						cursor: pointer;
					}
					.input-btn:hover {
						box-shadow: 0 8px 9px -4px rgba(59,113,202,.3), 0 4px 18px 0 rgba(59,113,202,.2);
					}
				 </style>
    </head>
    <body>
			<div class='header' style="display: flex">
				<p>Select image to upload:</p>
        <form method='post' enctype='multipart/form-data' class="form-class">
            <input type='file' name='fileToUpload' class="input">
            <input type='button' id='ubtn' value='Upload' class="input-btn"/>		
				</form>
        <form method='post' enctype='multipart/form-data' action="download.php" class="form-class">
            <input type='submit' id='ubtn' value='Download' class="input-btn" />		
				</form>
			</div>
			<div id='status'></div>
    </body>
</html>