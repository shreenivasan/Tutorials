<?php

class User {
	
	private $dbh;
	
	public function __construct($host,$user,$pass,$db)	{		
		$this->dbh = new PDO("mysql:host=".$host.";dbname=".$db,$user,$pass);		
	}

	public function getUsers(){
            
            $params = [];
            $whereClause = ' WHERE 1=1 ';
            $postData = $_POST['data'];
            
            if(isset($postData['name']) && !empty($postData['name'])){
                $whereClause.=" AND name like :name ";
                $params['name'] = "%".$postData['name']."%";
            }
            
            if(isset($postData['email']) && !empty($postData['email'])){
                $whereClause.=" AND email like :email ";
                $params['email'] = "%".$postData['email']."%";
            }
            
            if(isset($postData['mobile']) && !empty($postData['mobile'])){
                $whereClause.=" AND mobile like :mobile ";
                $params['mobile'] = "%".$postData['mobile']."%";
            }
            
            if(isset($postData['address']) && !empty($postData['address'])){
                $whereClause.=" AND address like :address ";
                $params['address'] = "%".$postData['address']."%";
            }
            
            $sth = $this->dbh->prepare("SELECT * FROM users $whereClause ");
            $sth->execute($params);
            return json_encode($sth->fetchAll());
	}

	public function add($user){		
		$sth = $this->dbh->prepare("INSERT INTO users(name, email, mobile, address) VALUES (?, ?, ?, ?)");
		$sth->execute(array($user->name, $user->email, $user->mobile, $user->address));		
		return json_encode($this->dbh->lastInsertId());
	}
	
	public function delete($user){				
		$sth = $this->dbh->prepare("DELETE FROM users WHERE id=?");
		$sth->execute(array($user->id));
		return json_encode(1);
	}
	
	public function updateValue($user){		
		$sth = $this->dbh->prepare("UPDATE users SET ". $user->field ."=? WHERE id=?");
		$sth->execute(array($user->newvalue, $user->id));				
		return json_encode(1);	
	}
}
?>