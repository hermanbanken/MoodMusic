<?php 
	$db=new SQLiteDatabase("db.sqlite");
	
	// create table 'USERS' and insert sample data
	class IkeMusicDb {
		private $db;
		
		public function __construct(){
			$this->db = new SQLiteDatabase("db.sqlite");
			$this->make_tables();
		}
		
		public function make_tables(){
			$q1 = @$this->db->query('CREATE TABLE IF NOT EXISTS music (
				id varchar(30), 
				artist varchar(50),
				song varchar(50),
				album varchar(50),
				genres varchar(50),
				addionaldata text,
				PRIMARY KEY (id))';
			$q2 = @$this->db->query('CREATE TABLE IF NOT EXISTS features (
				id varchar(30), 
				feature varchar(50),
				value int(11),
				when int(11),
				PRIMARY KEY (id, feature))';
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
			$this->db->query(sprintf(
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
		
		// Do direct query
		public function query($q){
			return $this->db->query($q);
		}
		
		public function store_feature($id, $feature, $value){
			$this->db->query(sprintf(
				"INSERT INTO features (id, feature, value, when) VALUES (
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
				$f[] = "(SELECT `$f` FROM features WHERE features.id = music.id) AS `$f`"
			}
			$q = implode(" ", array_merge($qb, $f, $qe));
			$result = $this->db->query($q);
			return $result;
		}
	}
?>