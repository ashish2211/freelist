
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php 	echo('<ul>');

	require('config.php');
	$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, 'allname');
    
	$p_name= strval($_GET['n']);
    if (isset($_GET['d']))
    $p_newlink = strval($_GET['d']);
    $p_id = 0;
    
	//check if listname exists
	$result = $conn->query("SELECT * FROM lists WHERE name = '$p_name'");
	if ($result->num_rows > 0){   // if list exists , find id and displayor insert content
         while($row = $result->fetch_assoc()) 
    		if ($row['name'] == $p_name )
              $p_id =  $row['id'];
            
        if (isset($p_newlink)){   //inserting the new link
            	$stmt = $conn->prepare("INSERT INTO contents (id,url) VALUES (?,?)");
                $stmt->bind_param("is",$p_id,$p_newlink);
                $stmt->execute();
        }
        
        
                // display contents
               $items =  $conn->query("SELECT * FROM contents");  
		          while($newr = $items->fetch_assoc()) {
    		        if ($newr['id'] == $p_id ){
			            	$s = $newr['url'];
				             echo("<li><a href ='$s'</a>$s</li>");
		           }
       }
        
    }  // if no list with the name exists, create a new one
    else {
            $stmt = $conn->prepare("INSERT INTO lists (name) VALUES (?)");
            $stmt->bind_param("s",$p_name);
            $stmt->execute();
        header("Refresh:1");
         }
    
echo ('</a>');   
echo('<li><form ><input type="text" id = "addnewfield" placeholder="Add a new link" > <input type="button" id="addnewbutton" value="Add" onClick="putdata()" >   </form></li>');    
echo('</ul'); ?>
</body>
</html>