<!DOCTYPE html>
<html>
	<head>
		<title>Upload database berita 2023</title>
		<style type="text/css">
			h3{font-family:tahoma;background:#00ccdd;padding:5px 10px;color:#FFF;text-align:center;}
			table tr td label{font:14px tahoma;}
		</style>
	</head>
	<body>
    <!-- create a form interface to be read and insert data into database -->
		<form action="import.php" name="readfile" method="post" enctype="multipart/form-data">
			<a href="index.php" class="btn btn-danger">Kembali</a>
		<table cellpadding="10" align="center" rules="all" frame="box">
			<tr>
				<td colspan="2">
					<h3>
						Upload Berita 2023
					</h3>
				</td>
			</tr>
			<tr>
				<td>
					<label for="txt-file">Open File(*.txt):</label>
				</td>
				<td>
					<input type="file" name="file1"><!--file to read-->
				</td>
			</tr>
			<tr valign="top">
				<td>
					<label></label><!--what character to terminate as column into table-->
				</td>
				<td>
					<input type="radio" name="deli" value="" />Upload<br /><!--terminated by simicolum-->
				</td>
			</tr>
			<tr>
				<td colspan="2" align="right">
					<input type="submit" name="read" value="Insert"><!--button to submit the form to read data from the file-->
				</td>
			</tr>
		</table>
		</form>
	</body>
</html>
<?php
	include 'config.php';
	if(isset($_POST['read'])){//check if button have been click or not
		mysqli_connect('localhost','root','','mahasiswa') or die('could not connect to database'.mysqli_error());//connection to database server
		//mysqli_connect(servername,username,password)
		mysqli_select_db($con,'mahasiswa');//select database
		//mysqli_select_db(databasename);
		$terminated=$_POST['deli'];//get the value of terminated character from a form with post method
		$file_type=$_FILES['file1']['type'];//get file type of selected file to read
		$allow_type=array('text/plain');//allow only file that have extesion with .txt
		$fieldall="";
		if(in_array($file_type,$allow_type)){//check if selected file type is match to the allow file type we have defined
		  move_uploaded_file($_FILES['file1']['tmp_name'],"files/".$_FILES['file1']['name']);//move file to specifice directory to be read
		  $file=fopen("files/".$_FILES['file1']['name'],"r") or die ("Unable to open file!");//open file to read
          $file_array = file('files/'.$_FILES['file1']['name']); # read file into array
          $count = count($file_array);
		print_r($count);
		//print_r($file_array);
         //if($count > 0){ # file is not empty

  
             //mysqli_query($con, $milestone_query) or die(mysqli_error());
             //$milestone_query = "INSERT into berita23('2',name) values";
             $i = 0;
			 $milestone = "";
             foreach($file_array as $row){
                 $milestone =$milestone .' '. $file_array[$i];
				 //$milestone = $milestone&&$milestone;
				 //$milestone_query = $i < $count ? ',':'';
				 $i++;
				}
             //mysqli_query($con, $milestone_query) or die(mysqli_error());
            //print_r($milestone);
			$query = mysqli_query($con, "INSERT INTO berita23 (id, nama) VALUES('-', '$milestone')");
                if($query){
                    echo 'FILE BERHASIL DI UPLOAD!';
                }
                else{
                    echo 'FILE GAGAL DI UPLOAD!';
                }
             
		   
		   
		 fclose($file);//close the file after read
		 //unlink("files/".$_FILES['file1']['name']);//delete selected file after read to free up space
		 //or you can move it to backup table is fine
		}else{
			echo "Please select only text file(.txt file is recomended)!";
			//if file type doesn't allow we will return this message
		}
	}
?>