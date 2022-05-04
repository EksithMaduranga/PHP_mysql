<?php  session_start(); ?>
<?php require_once('inc/connection.php'); ?>
<?php require_once('inc/function.php'); ?>



<!DOCTYPE html>
<?php 
	//Checking if a user is logged in
	if (!isset($_SESSION['EmpId'])) {
		header('Location: index.php');
		// code...
	}

	$finance_list = '';

	//get the list of finance
	if (isset($_GET['search'])) {
		// code...
		$search = mysqli_real_escape_string($connection, $_GET['search']);
			$query = "SELECT * FROM finance WHERE (recNo LIKE '%{$search}%' OR recType LIKE '%{$search}%' OR EmpId LIKE '%{$search}%') AND is_deleted=0 ORDER BY EmpId";
	} else {
			$query = "SELECT * FROM finance WHERE is_deleted=0 ORDER BY EmpId";

	}

	
	$finances = mysqli_query($connection, $query);

	
	verify_query($finances);
	//if ($finances) 
	{
		// code...
		while ($finance = mysqli_fetch_assoc($finances)) {
			// code...
			$finance_list .="<tr>";

				$finance_list .="<td>{$finance['recNo']}</td>";
				$finance_list .="<td>{$finance['recType']}</td>";
				$finance_list .="<td>{$finance['ammount']}</td>";
				$finance_list .="<td>{$finance['EmpId']}</td>";
				$finance_list .="<td>{$finance['dateofrecord']}</td>";
				$finance_list .="<td><a href=\"modify-finance.php?finance_id={$finance['id']}\">Edit</a></td>";
				$finance_list .="<td><a href=\"delete-finance.php?finance_id={$finance['id']}\">delete</a></td>";
				

			$finance_list .="</tr>";
		}

	}
	
?>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Finance</title>
	<link rel="stylesheet" type="text/css" href="css/main.css">
</head>
<body>
	<header>
		<div class="appname">Finance Managemnet System</div>
		<div class="loggedin">Welcome <?php echo $_SESSION['EmpId']; ?>! <a href="logout.php">Log Out</a></div>
	</header>
	<main>
		<h1>Finance<span><a href="add-finance.php">Add New Finance</a> | <a href="finance.php">Refresh</a></span></h1>
		<div class="search">
			<form action="finance.php" method="get">
				<p>
					<input type="text" name="search" placeholder="Enter Record No, Record Type Or Emplooyee ID" required autofocus>
				</p>
			</form>
		</div>
		
		<table class="masterlist">
			<tr>
				<th>Record Number</th>
				<th>Record Type</th>
				<th>Ammount</th>
				<th>Authorized Emplooyee ID</th>
				<th>Date of the record</th>
				<th>Edit</th>
				<th>Delete</th>
			</tr>

			<?php echo $finance_list;?>

			
		</table>

	</main>

</body>
</html>