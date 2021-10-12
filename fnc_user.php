<?php
	$database = "if21_martin_lu";
	
	function sign_up($firstname,$surname,$email,$gender,$birth_date,$password){
		$notice = null;
		$conn = new mysqli($GLOBALS["server_host"],$GLOBALS["sever_user_name"],$GLOBALS["server_password"],$GLOBALS["database"]);
		
		$conn->set_charset("utf8");
		$stmt = $conn->prepare("SELECT id FROM vpr_users WHERE email = ?");
			$stmt->bind_param("s", $email);
			$stmt->bind_result($id_from_db);
			$stmt->execute();
			if($stmt->fetch()){
			//kasutaja juba olemas
			$notice = "Sellise tunnusega (" .$email .") kasutaja on <strong>juba olemas</strong>!";
		} else {
			//sulgen eelmise käsu
			$stmt->close();
		$stmt = $conn->prepare("INSERT INTO vpr_users(firstname,lastname,birthdate,gender,email,password) VALUES (?,?,?,?,?,?)");
		echo $conn->error;
		//krypteerime parooli
		$option = ["cost"=>12];
		$pwd_hash = password_hash($password, PASSWORD_BCRYPT, $option);
		$stmt->bind_param("sssiss",$firstname,$surname,$birth_date,$gender,$email,$pwd_hash);
		if($stmt->execute()){
			$notice="Uus kasutaja edukalt loodud";
		}
		else{
			$notice="Uue kasutaja loomisel tekkis viga" .$stmt_error;
		}
		}
		$stmt->close();
		$conn->close();
		return $notice;
		
	}
	function sign_in($email, $password){
        $notice = null;
        $conn = new mysqli($GLOBALS["server_host"],$GLOBALS["sever_user_name"],$GLOBALS["server_password"],$GLOBALS["database"]);
        $conn->set_charset("utf8");
        $stmt = $conn->prepare("SELECT id, firstname, lastname, password FROM vpr_users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->bind_result($id_from_db, $firstname_from_db, $lastname_from_db, $password_from_db);
        echo $conn->error;
        $stmt->execute();
		$_SESSION["user_id"] = $id_from_db;
        if($stmt->fetch()){
            //kasutaja on olemas, kontrollime parooli
            if(password_verify($password, $password_from_db)){
                //ongi õige
				$_SESSION["user_id"] = $id_from_db;
				$_SESSION["first_name"] = $firstname_from_db;
                $_SESSION["last_name"] = $lastname_from_db;
				//siin edaspidi sisselogimisel parime sqliga kasutaja profiili kui see on olemas,ss loeme sealt tausta- ja tekstivarvid muidu kasutame vaikevarve
				$stmt->close();
					$stmt = $conn->prepare("SELECT bgcolor,txtcolor FROM vpr_userprofiles WHERE userid=?");
					$stmt->bind_param("i", $_SESSION["user_id"]);
					$stmt->bind_result($bg_color_from_db, $txt_color_from_db);
					$stmt->execute();
					$_SESSION["bg_color"] = "#FFFFFF"; //valge #FFFFFF
					$_SESSION["text_color"]="#000000"; //must #000000
						if($stmt->fetch()){
							if(!empty($txt_color_from_db)){
								$_SESSION["text_color"]=$txt_color_from_db;
							}
							if(!empty($bg_color_from_db)){
								$_SESSION["bg_color"]=$bg_color_from_db;
							}
						}
					$stmt->close();
					$conn->close();
                header("Location: home.php");
                exit();
            } else {
                $notice = "Kasutajanimi või salasõna oli vale!";
            }
        } else {
            $notice = "Kasutajanimi või salasõna oli vale!";
        }
        
        $stmt->close();
        $conn->close();
        return $notice; 
    }
		function read_user_description(){
		//kui profiil on olemas, loeb kasutaja lühitutvustuse
		$notice = null;
		$conn = new mysqli($GLOBALS["server_host"],$GLOBALS["sever_user_name"],$GLOBALS["server_password"],$GLOBALS["database"]);
		$conn->set_charset("utf8");
		//vaatame, kas on profiil olemas
		$stmt = $conn->prepare("SELECT description FROM vpr_userprofiles WHERE userid = ?");
		echo $conn->error;
		$stmt->bind_param("i", $_SESSION["user_id"]);
		$stmt->bind_result($description_from_db);
		$stmt->execute();
		if($stmt->fetch()){
			$notice = $description_from_db;
		}
		$stmt->close();
		$conn->close();
		return $notice;
	}
	
	function profile_save($description,$bgcolor,$txtcolor){
		$notice = null;
		$conn = new mysqli($GLOBALS["server_host"],$GLOBALS["sever_user_name"],$GLOBALS["server_password"],$GLOBALS["database"]);
		
		$conn->set_charset("utf8");

$stmt = $conn->prepare("SELECT id FROM vpr_userprofiles WHERE userid = ?");
		echo $conn->error;
		$stmt->bind_param("i", $_SESSION["user_id"]);
		$stmt->bind_result($id_from_db);
		$stmt->execute();
		if($stmt->fetch()){
			$stmt->close();
			//uuendame profiili
			$stmt= $conn->prepare("UPDATE vpr_userprofiles SET description = ?, bgcolor = ?, txtcolor = ? WHERE userid = ?");
			echo $conn->error;
			$stmt->bind_param("sssi", $description, $bg_color, $txt_color, $_SESSION["user_id"]);
		} else {
			$stmt->close();
			//tekitame uue profiili
			$stmt = $conn->prepare("INSERT INTO vpr_userprofiles (userid, description, bgcolor, txtcolor) VALUES(?,?,?,?)");
			echo $conn->error;
			$stmt->bind_param("isss", $_SESSION["user_id"], $description, $bg_color, $txt_color);
		}
		if($stmt->execute()){
			$_SESSION["bg_color"] = $_POST["bg_color_input"];
			$_SESSION["text_color"] = $_POST["text_color_input"];
			$notice = "Profiil salvestatud!";
		} else {
			$notice = "Profiili salvestamisel tekkis viga: " .$stmt->error;
		}
		$stmt->close();
		$conn->close();
		return $notice;
	}
		//	$stmt = $conn->prepare("SELECT id FROM vpr_userprofiles WHERE userid = ?");
		//$stmt->bind_param("i", $_SESSION["user_id"]);
			//$stmt->bind_result($id_from_db);
			//$stmt->execute();
		//($stmt->fetch())
		//	$stmt = $conn->prepare("SELECT description,bgcolor,txtcolor FROM vpr_userprofiles WHERE id=?");
			//$stmt->bind_param("i", $id);
			//$stmt->bind_result( $description_from_db, $bgcolor_from_db, $textcolor_from_db);
			//echo $conn->error;
			//if($stmt->execute()){
			//$_SESSION["description"] = $description_from_db;
			//$_SESSION["bg_color"] = $bgcolor_from_db ; //valge #FFFFFF
			//$_SESSION["text_color"]= $textcolor_from_db ;
		//}
		