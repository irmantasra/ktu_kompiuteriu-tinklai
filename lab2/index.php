<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>php.lab</title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	</head>
	<body>
		<div class='container text-center'>
			<h2>Žinučių sistema</h2>
			<?php
				$db = mysqli_connect('localhost', 'stud', 'stud', 'stud');
				if(!$db) {
					die ("No database connection: ".mysqli_error($db));
				}

				$selectQr = "SELECT * FROM irmantasramanauskas";
				$result = mysqli_query($db, $selectQr);

				echo '<table class="table table-striped table-bordered">';
				echo '<thead><tr><th>Nr.</th><th>Kas siuntė</th><th>Siuntėjo e-paštas</th><th>Gavėjas</th><th>Data (IP)</th><th>Žinutė</th></tr></thead>';
				while ($row = mysqli_fetch_assoc($result)) {
					$tableRow = '';
					$tableRow .= '<tr>';
					$tableRow .= '<td>'.$row['id'].'</td>';
					$tableRow .= '<td>'.$row['vardas'].'</td>';
					$tableRow .= '<td>'.$row['epastas'].'</td>';
					$tableRow .= '<td>'.$row['kam'].'</td>';
					$tableRow .= '<td>'.$row['data'].'('.$row['ip'].')</td>';
					$tableRow .= '<td>'.$row['zinute'].'</td>';
					$tableRow .= '</tr>';
					echo $tableRow;
				}
				echo '</table>';
			
				if($_POST != null) {					
					$insertQr = "INSERT INTO irmantasramanauskas (vardas, epastas, kam, data, ip, zinute)
							VALUES (
								'".$_POST['from']."',
								'".$_POST['email']."',
								'".$_POST['to']."',
								'".date('Y-m-d H:i:s')."',
								'".$_SERVER['REMOTE_ADDR']."',
								'".$_POST['message']."'
							)";

					if (!mysqli_query($db, $insertQr)) {
						die ("Klaida įrašant: ".mysqli_error($db));
					} else {
						header("Location: /");
						exit;
					}					
				};
			?>
			<h2>Įveskite naują žinutę</h2>
			<form method='post' action="<?php echo $_SERVER['PHP_SELF']; ?>">
				<div class="row">
					<div class="form-group col">
						<label for="from">Siuntėjo vardas:</label>
						<input type="text" class="form-control" id="from" name="from" required>
					</div>
					<div class="form-group col">
						<label for="email">Siuntėjo e-paštas:</label>
						<input type="email" class="form-control" id="email" name="email" required>
					</div>
					<div class="form-group col">
						<label for="to">Kam skirta:</label>
						<input type="text" class="form-control" id="to" name="to" required>
					</div>
				</div>
				<div class="form-group">
					<label for="message">Žinutė:</label>
					<textarea type="text" class="form-control" id="message" name="message" required></textarea>
				</div>
				<button type="submit" class="btn btn-primary">Siųsti</button>
			</form>
		</div>
	</body>
</html>