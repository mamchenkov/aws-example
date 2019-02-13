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
echo '<html>';
echo '<body>';
echo 'DB Server Time: ' . $date;
echo '<hr />';
echo '<address>Hostname: ' . php_uname('n') . '</address>';
echo '</body>';
echo '</html>';

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
				->expect('DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASS')
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
