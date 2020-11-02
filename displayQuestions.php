<?php
	session_start();
	$roll=$_SESSION['USER_ID'];
	$host = 'localhost'; $user = 'root'; $pass = '';
	$link = mysqli_connect($host, $user, $pass);
	mysqli_select_db($link,'linker');
	$query='select count(question) from questions_all order by dateq DESC';
	$result=mysqli_query($link,$query);
	//mysqli_error($link);
	echo mysqli_error($link);
	//$array_result=array();
	/*while($questions=mysqli_fetch_array($result,MYSQLI_NUM))
	{
		$array_result[]=$questions;
	}*/
	//print_r($array_result);
	//echo count($array_result);
	//echo $result;
	$n=mysqli_fetch_array($result,MYSQLI_NUM);
	if(!$n[0])
	{
		echo "No Previous Questions found";
	}
	else
	{
		//$idq=mysqli_fetch_array($result,MYSQLI_BOTH);
		echo "<table border = 2 wit  style='width:100%;border-collapse: collapse; text-align:center; padding:5px'>";
		echo "<caption>Previous Questions</caption>";
		$query='select * from questions_all order by dateq DESC';
		$result=mysqli_query($link,$query);
		for($i=1;$i<=$n[0];$i++)
		{
			$row=mysqli_fetch_array($result,MYSQLI_ASSOC);
			echo "<tr>";
				echo "<td style='text-align:left;' rowspan=2>Q$i. ".$row['question']."</td>";
				echo "<td >".$row['downvoteq']." Downvotes</td>";
				echo "<td >".$row['upvoteq']." Upvotes</td>";
				echo "<td >".$row['dateq']."</td>";
			echo"</tr>";
			
			$query='select count(*) from upvoteq where roll='.$roll.' AND idq="'.$row['question'].'";';
			//echo $query;
			$result=mysqli_query($link,$query);
			echo mysqli_error($link);
			$upq=mysqli_fetch_array($result,MYSQLI_NUM);
			if(!$upq[0])
			{
				$query='select count(*) from downvoteq where roll='.$roll.' AND idq="'.$row['question'].'";';
				$result=mysqli_query($link,$query);
				echo mysqli_error($link);
				$downq=mysqli_fetch_array($result,MYSQLI_NUM);
				if(!$downq[0])
				{
					echo "<tr><form method='post' action='vote.php'>";
						echo "<td ><input type='button' style='width:100%;' name='upvote' value='Upvote'></td>";
						echo "<td '><input type='button' style='width:100%;' name='downvote' value='Downvote'></td>";
						echo "<td ><a href='#' ><input type='button' style='width:100%;' name='answers' value='View all previous Answers'></td>";
					echo"</tr>";
				}
				else
				{
					echo "<tr><form method='post' action='vote.php'>";
						echo "<td ><input type='button' style='width:100%;' name='upvote' value='Upvote'></td>";
						echo "<td '><input type='button' style='width:100%;' name='downvote' value='Downvoted'></td>";
						echo "<td ><a href='#' ><input type='button' style='width:100%;' name='answers' value='View all previous Answers'></td>";
					echo"</tr>";
				}
			}
			else
			{
				echo "<tr><form method='post' action='vote.php'>";
					echo "<td ><input type='button' style='width:100%;' name='upvote' value='Upvoted'></td>";
					echo "<td '><input type='button' style='width:100%;' name='downvote' value='Downvote'></td>";
					echo "<td ><a href='#' ><input type='button' style='width:100%;' name='answers' value='View all previous Answers'></td>";
				echo"</tr>";
			}
			
			/*echo "<tr><form method='post' action='vote.php'>";
				echo "<td ><input type='button' style='width:100%;' name='upvote' value='Upvote'></td>";
				echo "<td '><input type='button' style='width:100%;' name='downvote' value='Downvote'></td>";
				echo "<td ><a href='#' ><input type='button' style='width:100%;' name='answers' value='View all previous Answers'></td>";
			echo"</tr>";*/
		}
		echo "</table>";
	}
	mysqli_close($link);
?>
	