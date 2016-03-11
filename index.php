<?php

try
{
	$db = new PDO("mysql:host=localhost;dbname=graham_db;" , "graham" , "test_password") ;
	
	$stmt = $db->prepare("INSERT INTO application "
						."(first_name , last_name , email , job_role) " 
						."VALUES "
						."(:first_name , :last_name , :email , :job_role)") ;

	if(isset($_POST['people']))
	{
		$db->query("TRUNCATE application") ;
		
		foreach((array)@$_POST['people'] as $person)
		{
			if(!@$person['delete'] and !array_search('', $person))
			{
				$stmt->bindValue(":first_name" , $person['firstname']) ;
				$stmt->bindValue(":last_name"  , $person['lastname'] ) ;
				$stmt->bindValue(":email"      , $person['email']    ) ;
				$stmt->bindValue(":job_role"   , $person['job_role'] ) ;
				$stmt->execute() ;
			}
		}
	}
	
	$data = $db->query("SELECT * FROM application")->fetchAll() ;
	@array_walk_recursive($rawData , function($parameter){return htmlentities($parameter);}) ; 
	
}
catch(\PDOException $e)
{
	echo $e->getMessage() ;
	exit(1) ;
}
?>
<form action="" method="post">
    <table>
        <tr>
            <th>First name</th>
            <th>Last name</th>
            <th>Email Address</th>
            <th>Job Role</th>
            <th>Delete</th>
        </tr>
        <?php for($index = 0 ; $index < count($data) ; $index++):?>
        <tr>
            <td><input type="text" name="people[<?= $index ?>][firstname]" value="<?= $data[$index]['first_name']?>" /></td>
            <td><input type="text" name="people[<?= $index ?>][lastname]" value="<?= $data[$index]['last_name']?>" /></td>
            <td><input type="text" name="people[<?= $index ?>][email]" value="<?= $data[$index]['email']?>" /></td>
            <td><input type="text" name="people[<?= $index ?>][job_role]" value="<?= $data[$index]['job_role']?>" /></td>
            <td><input type="checkbox" name="people[<?= $index ?>][delete]" value="1" /></td>
        </tr>        	
        <?php endfor ;?>
        <?php if($index < 10): ?>
            <tr>
	            <td><input type="text" name="people[<?= $index ?>][firstname]" placeholder="Add new..." /></td>
	            <td><input type="text" name="people[<?= $index ?>][lastname]" placeholder="Add new..." /></td>
	            <td><input type="text" name="people[<?= $index ?>][email]" placeholder="Add new..." /></td>
	            <td><input type="text" name="people[<?= $index ?>][job_role]" placeholder="Add new..." /></td>
        	</tr>
        <?php endif ;?>
    </table>
    <input type="submit" value="Submit!" />
</form>        