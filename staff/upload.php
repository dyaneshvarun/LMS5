<?php
if ( 0 < $_FILES['file']['error'] ) {
        //echo 'Error: ' . $_FILES['file']['error'] . '<br>';
		echo "ERRUPLOAD";
    }
    else {
		$fileName = uniqid("IST_LEAVE").$_FILES['file']['name'];
        move_uploaded_file($_FILES['file']['tmp_name'], 'uploads/' . $fileName);
		echo $fileName;
		//echo "DONE_UPLOAD";
	}

?>