<?php
session_start();
Class Action {
	private $db;

	public function __construct() {
   	include 'db_connect.php';
    
    $this->db = $conn;
	}
	function __destruct() {
	    $this->db->close();
	}

	function login(){
		extract($_POST);
		$qry = $this->db->query("SELECT * FROM users where username = '".$username."' and password = '".$password."' ");
		if($qry->num_rows > 0){
			foreach ($qry->fetch_array() as $key => $value) {
				if($key != 'passwors' && !is_numeric($key))
					$_SESSION['login_'.$key] = $value;
			}
			// var_dump($_SESSION);
			return 1;
		}else{
			return 2;
		}
	}
	function logout(){
		session_destroy();
		foreach ($_SESSION as $key => $value) {
			unset($_SESSION[$key]);
		}
		header("location:login.php");
	}
	function save_settings(){
		extract($_POST);
		$data = " name = '".$name."' ";
		$data .= ", address = '".$address."' ";
		if($_FILES['img']['tmp_name'] != ''){
			$fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['img']['name'];
			$move = move_uploaded_file($_FILES['img']['tmp_name'],'assets/img/'. $fname);
			$data .= ", img_path = '".$fname."' ";

		}
		$chk = $this->db->query("SELECT * from settings ");
		if($chk->num_rows > 0){
			$id = $chk->fetch_array()['id'];
			$save = $this->db->query("UPDATE settings set ".$data." where id = ".$id);
			if($save)
				return 1;
		}else{
			$save = $this->db->query("INSERT INTO settings set ".$data);
			if($save)
				return 1;
		}
	}
	function save_level_section(){
		extract($_POST);
		if(empty($id)){
			$chk = $this->db->query("SELECT * from level_section where level ='".$level."' and section = '".$section."' ")->num_rows;
			if($chk > 0){
				return json_encode(array('status'=>2,'msg'=>'Level and Section already exist'));
			}else{
				$save = $this->db->query("INSERT INTO level_section set level ='".$level."' , section = '".$section."' ");
				if($save)
					return json_encode(array('status'=>1));
			}
		}else{
			$chk = $this->db->query("SELECT * from level_section where level ='".$level."' and section = '".$section."' and id !='".$id."' ")->num_rows;
			if($chk > 0){
				return json_encode(array('status'=>2,'msg'=>'Level and Section already exist'));
			}else{
				$save = $this->db->query("UPDATE level_section set level ='".$level."' , section = '".$section."' where id=".$id);
				if($save)
					return json_encode(array('status'=>1));
			}
		}
	}
	function switch_year(){
		extract($_POST);
		$switch = $this->db->query("UPDATE school_year set is_on = 1 where id = ".$id);
		if($switch){
			$this->db->query("UPDATE school_year set is_on = 0 where id != ".$id);
			return 1;
		}
	}
	function save_school_year(){
		extract($_POST);
		if(empty($id)){
			$chk = $this->db->query("SELECT * from school_year where school_year ='".$school_year."' ")->num_rows;
			if($chk > 0){
				return json_encode(array('status'=>2,'msg'=>'Academic Year already exist'));
			}else{
				$save = $this->db->query("INSERT INTO school_year set school_year ='".$school_year."' ");
				if($save){
						$this->db->query("UPDATE school_year set is_on = 0 where id !=  ".$this->db->insert_id);
						return json_encode(array('status'=>1));
					}
			}
		}else{
			$chk = $this->db->query("SELECT * from school_year where school_year ='".$school_year."' and id !=  ".$id)->num_rows;
			if($chk > 0){
				return json_encode(array('status'=>2,'msg'=>'Academic Year already exist'));
			}else{
				$save = $this->db->query("UPDATE school_year set school_year ='".$school_year."' where id =  ".$id);
				if($save)
					return json_encode(array('status'=>1));
			}
			
		}
	}
	function save_faculty(){
		extract($_POST);
		if(empty($id)){
			$chk = $this->db->query("SELECT * from faculty where firstname ='".$firstname."' and lastname = '".$lastname."' and middlename = '".$middlename."' ")->num_rows;
			if($chk > 0){
				return json_encode(array('status'=>2,'msg'=>'Faculty already exist'));
			}else{
				$chk2 = $this->db->query("SELECT * from users where username = '".$username."' ")->num_rows;
				if($chk2 > 0){
				return json_encode(array('status'=>2,'msg'=>'Username already exist'));
				}else{
					// echo "INSERT INTO users set name ='".$firstname.' '.$middlename.' '.$lastname."' , user_type = 2 , username= '".$username."', password= '".$password."' ";
					$save = $this->db->query("INSERT INTO users set name ='".$firstname.' '.$middlename.' '.$lastname."' , user_type = 2 , username= '".$username."', password= '".$password."' ");
					if($save){
						$uid = $this->db->insert_id;
						$save2 = $this->db->query("INSERT INTO faculty set firstname ='".$firstname."' , lastname = '".$lastname."' , middlename = '".$middlename."' ,user_id = '".$uid."' , level_section_id = '".$level_section_id."'  ");
						if($save2)
						return json_encode(array('status'=>1));
					}
				}
				
			}
		}else{
			$chk = $this->db->query("SELECT * from faculty where firstname ='".$firstname."' and lastname = '".$lastname."' and middlename = '".$middlename."' and id != '".$id."' ")->num_rows;
			if($chk > 0){
				return json_encode(array('status'=>2,'msg'=>'Faculty already exist'));
			}else{
				$chk2 = $this->db->query("SELECT * from users where username = '".$username."' and id != '".$uid."' ")->num_rows;
				if($chk2 > 0){
				return json_encode(array('status'=>2,'msg'=>'Username already exist'));
				}else{
					// echo "INSERT INTO users set name ='".$firstname.' '.$middlename.' '.$lastname."' , user_type = 2 , username= '".$username."', password= '".$password."' ";
					$save = $this->db->query("UPDATE users set name ='".$firstname.' '.$middlename.' '.$lastname."' , user_type = 2 , username= '".$username."', password= '".$password."' where id ='".$uid."' ");
					if($save){
						$save2 = $this->db->query("UPDATE faculty set firstname ='".$firstname."' , lastname = '".$lastname."' , middlename = '".$middlename."' ,user_id = '".$uid."' , level_section_id = '".$level_section_id."' where id = '".$id."'  ");
						if($save2)
						return json_encode(array('status'=>1));
					}
				}
				
			}
			
		}
	}
	function save_student(){
		extract($_POST);
		
		$data = " firstname = '".$firstname."' ";
				$data .= ", middlename = '".$middlename."' ";
				$data .= ", lastname = '".$lastname."' ";
				$data .= ", dob = '".$dob."' ";
				$data .= ", gender = '".$gender."' ";
				$data .= ", type = '".$type."' ";
				$data .= ", address = '".$address."' ";
		
		if(empty($sid)){
				$code = $this->db->query("SELECT * FROM student_list where date_format(date_created,'%Y') = '".date('Y')."' order by student_code desc limit 1 ");
				if($code->num_rows > 0){
					$code = explode('-',$code->fetch_array()['student_code']);
					$code = $code[0].'-'.(sprintf("%'.05d\n", (intval($code[1])+1)));
				}else{
					$code = date('Y').'-'.(sprintf("%'.05d\n", 1));

				}
				$data .= ", student_code = '".$code."' ";
			$save = $this->db->query("INSERT INTO student_list set ".$data);
			if($save)
			return $this->db->insert_id;
				
			
		}else{
				$save = $this->db->query("UPDATE student_list set ".$data." where id =".$sid);
			if($save)
			return $sid;
		}
	}

	function save_enroll(){
		extract($_POST);
		if($type == 1 || $type == 3){


			$student_id = $this->save_student();
		}
			$data = " school_year = '".$school_year."' ";
			$data .= ", student_id = '".$student_id."' ";
			$data .= ", level_section_id = '".$level_section_id."' ";
			$fid = $this->db->query("SELECT * FROM faculty where level_section_id = '".$level_section_id."' and status = 1 ");
			$fid = $fid->fetch_array()['id'];
			$data .= ", faculty_id = '"	.$fid."' ";
			// echo "INSERT INTO enrollment set".$data;

			if(empty($id)){
				$save = $this->db->query("INSERT INTO enrollment set".$data);
				if($save){
					$data = " last_school = '".$sla."' ";
					$data .= ", last_address = '".$slaa."' ";
					$data .= ", enrollment_id = '".$this->db->insert_id."' ";
					$this->db->query("INSERT INTO last_school set".$data);
					return 1;
				}
			}else{
				$save = $this->db->query("UPDATE enrollment set".$data." where id =".$id);
				if($save){
					$data = " last_school = '".$sla."' ";
					$data .= ", last_address = '".$slaa."' ";
					$this->db->query("UPDATE last_school set".$data." where enrollment_id=".$id);

					return 1;
				}
			}

	}

	function load_level_section(){
		$qry = $this->db->query("SELECT * from level_section where status = 1");
		$data = array();
		while($row=$qry->fetch_assoc()){
			$data[] = $row;
		}
		echo json_encode($data);
	}
	function load_student(){
		$qry = $this->db->query("SELECT e.*,CONCAT(s.firstname,' ',s.middlename,' ',s.lastname) as name,CONCAT(f.firstname,' ',f.middlename,' ',f.lastname) as fname,CONCAT(ls.level,'-',ls.section) as ls,s.type from enrollment e inner join faculty f on f. id = e.faculty_id inner join level_section ls on e.level_section_id = ls.id inner join student_list s on s.id = e.student_id  where e.status = 1 and e.school_year in (SELECT id from school_year where is_on = 1 ) ");
		$data = array();
		while($row=$qry->fetch_assoc()){
			if($row['type'] == 1)
				$row['user_type'] = "New";
			if($row['type'] == 2)
				$row['user_type'] = "Regular";
			if($row['type'] == 3)
				$row['user_type'] = "Transferee";
			if($row['type'] == 4)
				$row['user_type'] = "Returnee";


			$data[] = $row;
		}
		echo json_encode($data);
	}
	function load_school_year(){
		$qry = $this->db->query("SELECT * from school_year where status = 1 order by school_year desc");
		$data = array();
		while($row=$qry->fetch_assoc()){
			$data[] = $row;
		}
		echo json_encode($data);
	}
	function load_faculty(){
		$qry = $this->db->query("SELECT f.*,concat(l.level,'-',l.section) as advisory from faculty f inner join level_section l on f.level_section_id = l.id where f.status = 1");
		$data = array();
		while($row=$qry->fetch_assoc()){
			$data[] = $row;
		}
		echo json_encode($data);
	}
	function load_post(){
			$qry = $this->db->query("SELECT p.*,c.name as category from posts p inner join category c on c.id = p.category_id ");
			$data = array();
			while($row=$qry->fetch_assoc()){
				$data[] = $row;
			}
			echo json_encode($data);
		}
	function remove_level_section(){
		extract($_POST);
		$remove = $this->db->query("UPDATE level_section set status = 0 where id =".$id);
		if($remove)
			return 1;
	}
	function remove_faculty(){
		extract($_POST);
		$remove = $this->db->query("UPDATE faculty set status = 0 where id =".$id);
		if($remove)
			return 1;
	}
	function remove_enroll(){
		extract($_POST);
		$remove = $this->db->query("UPDATE enrollment set status = 0 where id =".$id);
		if($remove)
			return 1;
	}
	function remove_school_year(){
		extract($_POST);
		$remove = $this->db->query("UPDATE school_year set status = 0 where id =".$id);
		if($remove)
			return 1;
	}
	function publish_post(){
		extract($_POST);
		$publish = $this->db->query("UPDATE posts set status = 1 where id =".$id);
		if($publish)
			return 1;
	}
	function remove_post(){
		extract($_POST);
		$remove = $this->db->query("DELETE FROM post where id =".$id);
		if($remove)
			return 1;
	}
	function save_post(){
		extract($_POST);
		$data = " title = '".$name."' ";
		$data .= ", post = '".htmlentities(str_replace("'","&#x2019;",$post))."' ";
		$data .= ", category_id = '".$category_id."' ";
		if($_FILES['img']['tmp_name'] != ''){
			$fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['img']['name'];
			$move = move_uploaded_file($_FILES['img']['tmp_name'],'../assets/img/'. $fname);
			$data .= ", img_path = '".$fname."' ";

		}
		if(empty($id)){
			$insert  = $this->db->query("INSERT INTO posts set".$data);
			if($insert){
				return json_encode(array('status'=>1,'id'=>$this->db->insert_id));
			}
		}else{
			$update  = $this->db->query("UPDATE posts set".$data." , date_published='".date('Y-m-d H:i')."' where id=".$id);
			if($update){
				return json_encode(array('status'=>1,'id'=>$id));
			}
		}
		
	}
}