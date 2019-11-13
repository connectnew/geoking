<?php

namespace App\Console\Commands;

use \Igaster\LaravelCities\commands\helpers\geoItem as geoItem;
use \Igaster\LaravelCities\commands\helpers\geoCollection as geoCollection;

use Illuminate\Console\Command as Command;
use \Illuminate\Support\Facades\Schema as Schema;
use \Illuminate\Support\Facades\DB as DB;
use \Symfony\Component\Console\Helper\ProgressBar as ProgressBar;

use \PDO as PDO;
use \Exception as Exception;

class SeedGeoCitiesFile extends Command
{
	protected $signature = 'geo:seed-cities {cities} {--append}';
	protected $description = 'Load + Parse + Save to DB a geodata (cities) file.';
	/**
	 * @var \Doctrine\DBAL\Driver\PDOConnection
	 */
	private $pdo = null;
	/**
	 * @var string|null
	 */
	private $driver = null;
	/**
	 * @var geoCollection|null
	 */
	protected $geoItems = null;

	public function __construct()
	{
		parent::__construct();
		$connection = config('database.default');
		$this->driver = strtolower(config("database.connections.{$connection}.driver"));

		$this->pdo = DB::connection()->getPdo(PDO::FETCH_ASSOC);
		if (!Schema::hasTable('geo'))
			return;

		$this->geoItems = new geoCollection();

	}

	public function handle()
	{
		$start = microtime(true);

		$fileName = \strtoupper($this->argument('cities'));
		$fileName = storage_path("geo/{$fileName}.txt");
		$append = $this->option('append');

		// Read Raw file
		$this->info("Reading File '$fileName'");
		$filesize = filesize($fileName);
		$handle = fopen($fileName, 'r');
		$count = 0;

		$progressBar = new ProgressBar($this->output, 100);
		while (($line = fgets($handle)) !== false) {
			// ignore empty lines and comments
			if (!$line or $line === '' or strpos($line, '#') === 0) continue;

			// Convert TAB sepereted line to array
			$line = explode("\t", $line);

			// Check for errors
			if (count($line) !== 19) dd($line[0], $line[2]);

			//cities
			switch ($line[7]) {
				case 'PPL':
				case 'PPLC':    // Capital
				case 'PPLA':
				case 'PPLA2':
				case 'PPLA3':
				case 'PPLA4':
					$this->geoItems->add(new geoItem($line, $this->geoItems));
					$count++;
					break;
			}
			$progress = ftell($handle) / $filesize * 100;
			$progressBar->setProgress($progress);
		}
		$progressBar->finish();
		$this->info(" Finished Reading File. $count items loaded</info>");

		// Empty Table
		if (!$append) {
			$this->info("Truncating 'geo' table...");
			DB::table('geo_cities')->truncate();
		}

		// Store Tree in DB
		$this->info("Writing in Database</info>");

		if ($this->driver == 'mysql') {
			$stmt = $this->pdo->prepare("INSERT INTO `geo_cities` (`id`,  `name`, `alternames`, `country`, `level`, `population`, `lat`, `long`) VALUES (:id, :name, :alternames, :country, :level, :population, :lat, :long)");
		} else {
			$stmt = $this->pdo->prepare("INSERT INTO `geo_cities` (\"id\", \"name\", \"alternames\", \"country\", \"level\", \"population\", \"lat\", \"long\") VALUES (:id, :name, :alternames, :country, :level, :population, :lat, :long)");
		}

		$count = 0;
		$totalCount = count($this->geoItems->items);
		$progressBar = new ProgressBar($this->output, 100);
		foreach ($this->geoItems->items as $item) {
			if ($stmt->execute([
					':id' => $item->getId(),
					':name' => substr($item->data[2], 0, 40),
					':alternames' => $item->data[3],
					':country' => $item->data[8],
					':level' => $item->data[7],
					':population' => $item->data[14],
					':lat' => $item->data[4],
					':long' => $item->data[5]
				]) === false) {
				//Before throwing enabling key checks
				DB::statement('SET FOREIGN_KEY_CHECKS=1;');
				$this->info('Relation checks enabled');
				throw new Exception("Error in SQL : \n" . PDO::errorInfo(), 1);
			}
			$progress = $count++ / $totalCount * 100;
			$progressBar->setProgress($progress);
		}
		$progressBar->finish();

		//Lets get back FOREIGN_KEY_CHECKS to laravel
		DB::statement('SET FOREIGN_KEY_CHECKS=1;');
		$this->info('Relation checks enabled');

		$this->info(" Done</info>");
		$time_elapsed_secs = microtime(true) - $start;
		$this->info("Timing: $time_elapsed_secs sec</info>");


	}
}