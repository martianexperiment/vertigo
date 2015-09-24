<!--
TODO
1. Yet to create SQLite database with more columns
2. Handle Exception for the username = a' 
3. USMilitia page updates field to be written properly
-->

<html>
<head><title>Login Validation</title>

<style>
		
table.db-table 		{ border-right:1px solid #ccc; border-bottom:1px solid #ccc; }
table.db-table th	{ background:#eee; padding:5px; border-left:1px solid #ccc; border-top:1px solid #ccc; }
table.db-table td	{ padding:5px; border-left:1px solid #ccc; border-top:1px solid #ccc; }

</style>
</head>

<body>

<?php

if(isset($_POST['username'])) {

$input1 =  $_POST['username'];
$input2 =  $_POST['password'];

$db = new PDO('sqlite:federal.sqlite');
$query = "SELECT * FROM users where name = '$input1' and password = '$input2' ";
$result = $db->query($query);

try{	   
		
    if($result)
	   $rows = $result->fetchAll();
    if(isset($rows))
        $row_count = count($rows);
    if(isset($row_count)){

     if($row_count > 1){ 
     //print("LS!");
    
     echo "<b>Your Credentials</b></br>" ;
     echo "</br>";
     echo '<table cellpadding="1" cellspacing="1" class="db-table">';
     echo '<tr><th>Username</th><th>Password</th></tr>';

     foreach($rows as $row){
         echo "<tr>";   
         $username = $row['name'];
         $password = $row['password'];

         echo "<td>$username</td>";
         echo "<td>$password</td>";

         echo "</tr>\n";    
         }
     }

     else if($row_count == 1){
        $query2  = "SELECT SocialSecNumber FROM users where name = '$input1' and password = '$input2' ";
        $result2 = $db->query($query);
        
        if($result2)
        $rows2 = $result->fetchAll();   
        
        foreach($rows as $row){
         $ssn = $row['SocialSecNumber'];   

         echo "Hello <b>$input1</b>! Please secure your new access rights. <br/><br/><br/><br/>";        
         echo "<p style='color:white'>Your new Access code is :</p>" ;        
         echo "<p style='color:white'> $ssn</p><br/>";
         echo "";
        }
     }
          
     else{
     print "Invalid Login! Contact Pentagon MR-314, in case you have forgotten the credentials.";
     }

    }
}

catch(Exception $ex){
    echo "SQL injection Detected. Any further action would put you in legal trouble.";
}


}

?>

</body>
</html>

