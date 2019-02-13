<?php
require_once '../vendor/autoload.php';

try {
	$config = getConfig('../.env');
	$dbConn = connect($config);
	$date = getDbDate($dbConn);
	disconnect($dbConn);
} catch (Exception $e) {
	die("Things went wrong: " . $e->getMessage());
}

session_start();

echo <<<EOF
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.0/css/bootstrap.min.css" integrity="sha384-PDle/QlgIONtM1aqA2Qemk5gPOE7wFq8+Em+G/hmo5Iq0CCmYZLv3fVRDJ4MMwEA" crossorigin="anonymous">

    <title>Hello, world!</title>
  </head>
  <body>
    <div class="jumbotron jumbotron-fluid">
      <div class="container">
		<h1>Hello, world!</h1>
		<p class="lead">DB Server Time: $date</p>
		<hr />
		<address>Hostname: {$config['WEB_HOST']} </address>
      </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.0/js/bootstrap.min.js" integrity="sha384-7aThvCh9TypR7fIc2HV4O/nFMVCBwyIUKL8XCtKE+8xgCgl/PQGuFsvShjr74PBp" crossorigin="anonymous"></script>
  </body>
</html>
EOF;

/**
 * Read configuration file and return as array
 *
 * @param string $path Path to .env file to read from
 * @return string[]
 */
function getConfig(string $path): array
{
	$result = (new josegonzalez\Dotenv\Loader($path))
				->parse()
				->expect('WEB_HOST', 'DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASS')
				->toArray();

	return $result;
}

/**
 * Connect to the database
 *
 * @throws RuntimeException when cannot connect
 * @param string[] $config Configuration array
 * @return resource
 */
function connect(array $config)
{
	if (!function_exists('pg_connect')) {
		throw new RuntimeException("pgsql extension is missing");
	}

	$connString = sprintf("host=%s dbname=%s user=%s password=%s",
		$config['DB_HOST'],
		$config['DB_NAME'],
		$config['DB_USER'],
		$config['DB_PASS']
	);
	$result = pg_connect($connString);

	if (!is_resource($result)) {
		throw new RuntimeException("Failed to connect to DB: " . pg_last_error());
	}

	return $result;
}

/**
 * Disconnect from the database
 *
 * @param resource $conn Connection
 * @return void
 */
function disconnect($conn)
{
	pg_close($conn);
}

/**
 * Get current timestamp from DB
 *
 * @throws RuntimeException when fails to run SQL
 * @param resource $conn Database connection
 * @return string
 */
function getDbDate($conn): string
{
	$query = "SELECT NOW()";
	$result = pg_query($conn, $query);

	if (!is_resource($result)) {
		throw new RuntimeException("Failed to run SQL query: " . pg_last_error());
	}

	$result = pg_fetch_assoc($result);
	$result = $result['now'];

	return $result;
}
