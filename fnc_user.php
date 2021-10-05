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
				$_SESSION["bg_color"] = "#AAAAAA"; //valge #FFFFFF
				$_SESSION["text_color"]="#0000AA"; //must #000000
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