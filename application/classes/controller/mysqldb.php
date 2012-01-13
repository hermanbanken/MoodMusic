<?php 
	// create table 'USERS' and insert sample data
	class MysqlDb {
		var $isMysql = true;
		
		function __construct($db, $mode, &$error){
			$this->c = mysql_connect('sql.ewi.tudelft.nl', 'ike', 'supermooi');
			mysql_select_db($db);
		}
		function handle(){
			return $this->c;
		}
		function query($q){
			return mysql_query($q);
		}
		function fetch_object($result){
			return mysql_fetch_object($result);
		}
		function sqlite_fetch_object($result){
			return mysql_fetch_object($result);
		}
	}
	
	class IkeMusicDb {
		private $db;
		
		public function __construct(){
			if($this->db = new SQLiteDatabase('../db5.sqlite', 0777, $error)){
			//if($this->db = new MysqlDb('ike', 0777, $error)){
				$this->make_tables();
			} else
				die("Error: ".$error);
		}
		
		public function make_tables(){
			$q1 = @$this->db->query('CREATE TABLE music (
				id varchar(30), 
				artist varchar(50),
				song varchar(50),
				album varchar(50),
				genres varchar(50),
				additionaldata text,
				PRIMARY KEY (id))');
			$q2 = @$this->db->query('CREATE TABLE features (
				id varchar(30), 
				feature varchar(50),
				value int(11),
				date int(11),
				PRIMARY KEY (id, feature))');
			$q3 = @$this->db->query('CREATE TABLE echonest (
				id varchar(20), 
				artist_id varchar(20),
				artist_name varchar(50),
				title varchar(50),
				PRIMARY KEY (id),
				CONSTRAINT song UNIQUE (artist_name, title))');
			$q4 = @$this->db->query('CREATE TABLE audio_summary (
				echonest_id varchar(20), 
				audiokey int(2),
				mode int(1),
				time_signature int(1),
				duration decimal(20, 15),
				loudness decimal(20, 15),
				energy float,
				tempo decimal(20, 15),
				audio_md5 varchar(33),
				analysis_url text,
				danceability float,
				ike_mood varchar(200),
				PRIMARY KEY (echonest_id))');
		}
		
		/* Params: 
			$id - spotify id
			$artist - string artist
			$song - string song
			$album - string album
			$genres - string[] genres 
			$data - object{} additional data
		*/
		public function store_spotify($id, $artist, $song, $album, $genres, $data){
			@$this->db->query(sprintf(
				"INSERT INTO music (id, artist, song, album, genres, additionaldata) VALUES (
								   '%s','%s',   '%s', '%s',  '%s',   '%s');",
				$id,
				$artist,
				$song,
				$album,
				json_encode($genres),
				json_encode($data)
			));
		}
		
		public function store_nestsong($id, $artist_id, $artist_name, $title, $audio_summary){
			$query = sprintf(
				"INSERT INTO echonest (id, artist_id, artist_name, title) VALUES (
								   	  '%s','%s',   	  '%s', 	   '%s');",
				sqlite_escape_string($id),
				sqlite_escape_string($artist_id),
				sqlite_escape_string($artist_name),
				sqlite_escape_string($title)
			);
			if(!@$this->db->query($query) && false) echo $query;
			
			$fields = array(); $values = array($id);
			$i = 0;
			foreach($audio_summary as $key => $feat){
				if(in_array($i, array(0, 8, 9)))
					$values[] = sqlite_escape_string($feat);
				else
					$values[] = $feat;
				$i++;
			}
			
			$query = vsprintf(
				"INSERT INTO audio_summary (echonest_id, audiokey,mode,time_signature,duration,loudness,energy,tempo,audio_md5,analysis_url,danceability) VALUES (
					'%s', %d, %d, %d, %f, %f, %f, %f, '%s', '%s', %f);",
				$values
			);
			if(!@$this->db->query($query) && false) echo $query;
			flush();
		}
		
		public function getNextSong(){
			$result = $this->db->query("SELECT * FROM echonest, audio_summary WHERE echonest_id = id AND ike_mood IS NULL LIMIT 1");
			return $result->fetchObject();
		}
		
		// Do direct query
		public function query($q){
			return $this->db->query($q);
		}
		
		public function fetch_object($result){
			if($this->db->isMysql){
				return mysql_fetch_object($result);
			}else
				return sqlite_fetch_object($result);
		}
		
		public function store_feature($id, $feature, $value){
			$this->db->query(sprintf(
				"INSERT INTO features (id, feature, value, date) VALUES (
									'%s', '%s', %d, %d);",
				$id, $feature, $value, time()
			));
		}
		
		public function list_features(){
			return $this->db->query("SELECT DISTINCT feature FROM features");
		}
		
		/* Params: 
			$features - a array of features to return as columns.
		*/
		public function generate_dataset($features){
			$qb = array("SELECT id,");
			$f = array();
			$qe = array("FROM music");
			foreach($features as $f){
				$f[] = "(SELECT `$f` FROM features WHERE features.id = music.id) AS `$f`";
			}
			$q = implode(" ", array_merge($qb, $f, $qe));
			$result = $this->db->query($q);
			return $result;
		}
	}
	
	class IkeLyrDb {
		const AGENT = "TUDelft IKE project";
		
		public static function curl($url){
			$file = fopen ($url, "r");
			if (!$file) {
			    echo "<p>Unable to open remote file.\n";
			    exit;
			}
			$total = array();
			while (!feof ($file)) {
			    $total[] = fgets ($file, 1024);
			}
			fclose($file);
			
			return $total;
		}
		
		public static function getLyricsById($id){
			$lyr = self::curl("http://www.lyrdb.com/getlyr.php?q=$id");
			return implode('', $lyr);
		}
		
		public static function getLyrics($artist, $track){
			$url = "http://www.lyrdb.com/lookup.php?q=".urlencode($artist)."|".urlencode($track)."&for=match&agent=".IkeLyrDb::AGENT;
			$lyrs = self::curl($url);
			
			while($line = next($lyrs)){
				list($id, $song, $singer) = explode("\\", $line);
				if($l = self::getLyricsById($id)){
					return $l;
				} 
			}
		}
	}
	
	//$ike = new IkeMusicDb();
	//var_dump( IkeLyrDb::getLyrics("Maroon 5", "This Love") );
?>