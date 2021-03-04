<html>
<?php 
    session_start();

    $conn = mysqli_connect("localhost","root","root","hw3");
    if(!$conn){
        echo "Database connection failed!!!";
    }
?>


<body>
    
    <h1>Popular Baby Names:</h1>
    <form action="babynames.php" method="post">
        <label for="year">Year:</label>

        <select id="year" name="year">
            <option value="All" selected="selected">All years</option>
            <?php 
                for($i=2005;$i<=2015;$i++){
                    echo "<option value='".$i."'>".$i."</option>";
                }
            ?>
            <!-- <option value="2005">2005</option>
            <option value="2006">2006</option>
            <option value="2007">2007</option> -->
        </select> 
        <select id="gender" name="gender">
            <option value="Both" selected="selected">Both</option>
            <option value="M">Male</option>
            <option value="F">Female</option>
        </select>
        <input type="submit" value="Go"/> 
    </form>

    <?php 
        $y = "All";
        $g = "Both";

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $y = $_POST["year"];
            $g = $_POST["gender"];
        }

        if(!empty($y) && !empty($g)){
            
            $sql = "SELECT * FROM babynames";
            if($y!="All"){
                $sql = $sql." WHERE year='".$y."'";
                if($g!="Both"){
                    $sql = $sql." AND gender='".$g."'";
                }
            }else if($g!="Both"){
                $sql = $sql." WHERE gender='".$g."'";
                
            }
            $sql= $sql." ORDER BY year,ranking,gender";
        
            // echo $sql;
            $result = mysqli_query($conn,$sql);

            if(mysqli_num_rows($result)>0){
                echo "<table id='result' border='1'>";
                echo "<tr><th>Name</th><th>Year</th><th>Ranking</th><th>Gender</th></tr>";
                // echo "<tr><td></td><td></td><td></td><td></td></tr>";
                while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
                    echo "<tr><td>".$row["name"]."</td><td>".$row["year"]."</td><td>".$row["ranking"]."</td><td>".$row["gender"]."</td></tr>";
                }

                echo "</table>";
                exit();
            }else{
                echo "No records found!!!";
            }
        }

    ?>
    
    <table id="result">


    </table>

</body>

</html>
