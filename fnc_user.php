<?php
	$database = "if21_martin_lu";
	
	function sign_up($firstname,$surname,$email,$gender,$birth_date,$password){
		$notice = null;
		$conn = new mysqli($GLOBALS["server_host"],$GLOBALS["sever_user_name"],$GLOBALS["server_password"],$GLOBALS["database"]);
		
		$conn->set_charset("utf8");
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
		$stmt->close();
		$conn->close();
		return $notice;
	}