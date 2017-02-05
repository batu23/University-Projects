<?php
    function confirm_query($result_set) {
		if (mysqli_connect_errno()) {
			die("Database query failed: " . mysqli_connect_errno());
		}
	}
    
    function get_all_doctors() {
		global $conn;
		$query = "SELECT * FROM docs";
        $doctor_set = mysqli_query($conn,$query);
		confirm_query($doctor_set);
		return $doctor_set;
	}
        
    function get_all_patients() {
		global $conn;
		$query = "SELECT * 
				FROM pats 
				ORDER BY id ASC";
		$NSpatient_set = mysqli_query($conn,$query);
		confirm_query($NSpatient_set);
		return $NSpatient_set;
	}

	function get_doctor_by_id($doctor_id) {
		global $conn;
		$query = "SELECT * ";
		$query .= "FROM docs ";
		$query .= "WHERE id='{$doctor_id}' LIMIT 1";
		$result_set = mysqli_query($conn,$query);
		confirm_query($result_set);
		// REMEMBER:
		// if no rows are returned, fetch_array will return false
		if ($subject = mysqli_fetch_array($result_set)) {
            return $subject;
		} else {
			return NULL;
		}
	}

    	function get_patient_by_id($patient_id) {
		global $conn;
		$query = "SELECT * ";
		$query .= "FROM pats ";
		$query .= "WHERE id='{$patient_id}' LIMIT 1";
		$result_set = mysqli_query($conn,$query);
		confirm_query($result_set);
		// REMEMBER:
		// if no rows are returned, fetch_array will return false
		if ($subject = mysqli_fetch_array($result_set)) {
			return $subject;
		} else {
			return NULL;
		}
	}

    
    function find_selected_doc() {
        global $selected_doc;
        if (isset($_POST['doctor_id'])) {
			$selected_doc = get_doctor_by_id($_POST['doctor_id']);
            return $selected_doc;
		} else {
			$selected_doc = NULL;
		}
    }

        function find_selected_patient() {
        if (isset($_POST['patient_id'])) {
			$row_patient = get_patient_by_id($_POST['patient_id']);
            return $row_patient;
		} else {
			return NULL;
		}
	}

	
    function check_if_patient_exists($NSpatient_id){

        if(!isset($NSpatient_id))
            return FALSE;

        global $conn;
		$query = "SELECT * ";
		$query .= "FROM pats ";
		$query .= "WHERE id='{$NSpatient_id}' LIMIT 1";
		$result_set = mysqli_query($conn,$query);
		confirm_query($result_set);
		// REMEMBER:
		// if no rows are returned, fetch_array will return false
		if (mysqli_num_rows($result_set)!=0) {
			return TRUE;
		} else {
			return FALSE;
		}
    }

    
	function redirect_to( $location = NULL ) {
		if ($location != NULL) {
			header("Location: {$location}");
			exit;
		}
	}

    //     function search_patient() {
    //     global $conn;
    //     global $result;
    //     global $message;
    //     $and_needed = FALSE;

    //     $query = "SELECT * FROM pats WHERE ";
                
    //             if (!empty($_POST['search_id'])) {$query .= "id LIKE '%" . $_POST['search_id'] . "%' "; $and_needed = TRUE; }
    //             if (!empty($_POST['search_name'])) {
    //                 if ($and_needed)  $query .= " AND ";
    //                 $query .= "id LIKE '%" . $_POST['search_name'] . "%'"; 
    //                 $and_needed = TRUE;
    //             }

				// $result = mysqli_query($conn,$query);
    //             //echo $query;

				// if (count($result) > 0) {
				// 	// Success
				// 	$message = "Yes here are the results";
				// } else {
				// 	// Failed
				// 	$message = "No result.";
				// 	$message .= "<br />". sqlsrv_errors();
				// }
    // }

    function search_doctor() {
        global $conn;
        global $result;
        global $message;
        $and_needed = FALSE;

        $query = "SELECT * FROM docs WHERE ";
                
                if (!empty($_POST['search_id'])) {$query .= "id LIKE '%" . $_POST['search_id'] . "%' "; $and_needed = TRUE; }
                if (!empty($_POST['search_name'])) {
                    if ($and_needed)  $query .= " AND ";
                    $query .= "name LIKE '%" . $_POST['search_name'] . "%'"; 
                    $and_needed = TRUE;
                }
                if (!empty($_POST['search_dep'])) {
                    if ($and_needed)  $query .= " AND ";
                    $query .= "branch LIKE '%" . $_POST['search_dep'] . "%'"; 
                    $and_needed = TRUE;
                }

				$result = mysqli_query($conn,$query);
                //echo $query;

				if (count($result) > 0) {
					// Success
					$message = "Yes here are the results";
				} else {
					// Failed
					$message = "No result.";
					$message .= "<br />". sqlsrv_errors();
				}
    }

     function search_doctor_from_view($name) {
        global $conn;
        
        $query = "SELECT * FROM docs WHERE name LIKE '%{$name}%'";

				$result = mysqli_query($conn,$query);
                confirm_query($result);
                //echo $query;
        return $result;
    }

    function search_visit($doctor, $patient, $date) {
        global $conn;

        $query = "SELECT * FROM appons WHERE  docname = '" . $doctor . "' AND datetime =  '" . $date . "' AND pat ='" . $patient . "' ";
                
                // if (!empty($doctor)) {$query .= " docname = '" . $doctor . "' AND "; }
                // if (!empty($date)) {$query .= " datetime =  '" . $date . "' AND "; }
                // if (!empty($patient)) {$query .= " pat ='" . $patient . "' "; }

				$result = mysqli_query($conn,$query);
				$result = mysqli_fetch_array($result);
				confirm_query($result);
        return $result;
    }



  //   function get_visit($datetime) {
  //       global $conn;
		// $query = "SELECT CONVERT(VARCHAR(20), datetime, 126) FROM appons WHERE datetime ='".$datetime."'";
	
		// $result_set = mysqli_query($conn,$query);
		// confirm_query($result_set);
		// // REMEMBER:
		// // if no rows are returned, fetch_array will return false
  //        echo $query;
		// if ($subject = mysqli_fetch_array($result_set)) {
		// 	// echo $subject;
		// 	return $subject;
		// } else {
		// 	return NULL;
		// }
  //   }

    function get_doc_name($doctor_id) {
        global $conn;
		$query = "SELECT  name ";
		$query .= "FROM docs ";
		$query .= "WHERE id='{$doctor_id}' ORDER BY name LIMIT 1";
		$result_set = mysqli_query($conn,$query);
		confirm_query($result_set);
		// REMEMBER:
		// if no rows are returned, fetch_array will return false
		if ($subject = mysqli_fetch_array($result_set)) {
			return $subject['name'];
		} else {
			return NULL;
		}
    }

    function get_patient_name($patient_id) {
        global $conn;
		$query = "SELECT name ";
		$query .= "FROM pats ";
		$query .= "WHERE id='{$patient_id}' ORDER BY name LIMIT 1";
		$result_set = mysqli_query($conn,$query);
		confirm_query($result_set);
		// REMEMBER:
		// if no rows are returned, fetch_array will return false
		if ($subject = mysqli_fetch_array($result_set)) {
			return $subject['name'];
		} else {
			return NULL;
		}
    }

 
?>
