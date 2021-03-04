<html>
<?php 
  //  session_start();
   
   $con = mysqli_connect("localhost","root","root","ssa");
    if(!$con){
        echo "Database connection failed!!!";
    } else {
       // echo "connected to DB";
    }
?> 
<body>
<form action="babynames.php" method="POST">
year:<select name="year" id="year">
    <option value=10 selected="selected">All Years</option>
    <option value=2005>2005</option>
    <option value=2006>2006</option>
    <option value=2007>2007</option>
    <option value=2008>2008</option>
    <option value=2009>2009</option>
    <option value=2010>2010</option>
    <option value=2011>2011</option>
    <option value=2012>2012</option>
    <option value=2013>2013</option>
    <option value=2014>2014</option>
    <option value=2015>2015</option>
  </select>
<br>
gender:<select name="gender" id="gender">
    <option value="B" selected="selected">Both</option>
    <option value="M">male</option>
    <option value="F">female</option>
    </select>
<input id="formsubmit" type="submit" value="Submit">
</form>

<?php

try {

  $year = 0;
  $gender = "";

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $year = $_POST["year"];
    $gender = $_POST["gender"];
}


if($con && $year!=0 && !empty($gender)){

  if($year==10 && $gender == 'B'){
    $sql = "SELECT name,ranking,gender,year FROM BabyNames order by year,gender,ranking ";
  } else if($year==10) {
    $sql = "SELECT name,ranking,gender,year FROM BabyNames where gender = '$gender' order by year,gender,ranking ";
  } else if($gender == 'B') {
    $sql = "SELECT name,ranking,gender,year FROM BabyNames where year = '$year' order by year,gender,ranking ";
  } else {
    $sql = "SELECT name,ranking,gender,year FROM BabyNames where gender = '$gender' and year = '$year' order by year,gender,ranking ";
  }
   

	//echo $sql;
	
	$result = mysqli_query($con, $sql);

	if (mysqli_num_rows($result) != 0 ){

    echo "fetched results successfully \n\n";

    echo "<table border=\"1\"><tr><th>Name</th><th>Ranking</th><th>Gender</th><th>Year</th></tr>";

    while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
      echo "<tr><td>".$row["name"]."</td><td>".$row["ranking"]."</td><td>".$row["gender"]."</td><td>".$row["year"]."</td></tr>";
    }

    echo "</table>";
  } 
  else{
    echo "No records found!!!";
  }

} else {
//  echo "year or gender is empty !!!";
//	echo "Debugging errno: " . mysqli_real_connect_errno();
}

}
 catch(Exception $e) {

  echo 'Message: ' .$e->getMessage();

}

?>

</body>
</html> 


