<?php
/**
 * Database
 * Version: 1.0
 * Author: Arindam Metya
 * @param datatype array
 */

namespace Application;
//echo dirname(__DIR__) . DIRECTORY_SEPARATOR .  'Config.php';
//require dirname(__DIR__) . DIRECTORY_SEPARATOR .  'Config.php';

use PDO;

class Database {
	function __construct()
	{
		
			$this->Connect();
		
		return;
	}

	protected $db;
	protected $message;

	protected function ThrowMessage( $message, $data_type = '' )
	{
		if( $data_type == 'json' )
		{
			print_r( json_encode( $message ) );
			$this->message = true;
			exit;
		}
		if( $data_type == 'array' )
		{
			print_r( $message );
			$this->message = true;
			return;
		}
		else
		{
			$this->message = $message;
			return;
		}
	}
	protected function Connect ()
	{

		try {

				$this->db = new PDO ( 'mysql:host=' . DBHOST . ';dbname=' . DBNAME , DBUSER, DBPASSWORD );
				$this->db->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
			
		}
		catch ( PDOException $e ) {
		    echo $e->getMessage();
		}
		return;
	}

	public function Select( $data = array() )
	{
		//print_r($data);

		if( 
			!empty( $data ) && 
			array_key_exists( 'table', $data ) && 
			array_key_exists( 'selector', $data ) 
		)
		{
			if( array_key_exists( 'condition', $data ) && !empty( $data['condition'] ) )
			{
				//$condition = implode( ' ', $data['condition'] );

				// echo 'SELECT ' . $data['selector'] . ' FROM `' . $data['table'] . '` ' . $condition;
				// die();

				$query = $this->db->query ( 'SELECT ' . $data['selector'] . ' FROM `' . $data['table'] . '` ' . $data['condition'] );
				$result = $query->fetchAll ( PDO::FETCH_ASSOC );
			}
			else
			{
				$query = $this->db->query ( 'SELECT ' . $data['selector'] . ' FROM `' . $data['table'] . '`' );
				$result = $query->fetchAll ( PDO::FETCH_CLASS );
			}
			return $result;
		}
		else
		{
			throw new Exception("Invalid data given", 1);
		}
	}


	public function SelectRaw( $data )
	{
		//print_r($data);

		if( 
			!empty( $data ) &&
			array_key_exists( 'query', $data ) 
		)
		{
			
				$query = $this->db->query ( $data['query'] );
				$result = $query->fetchAll ( PDO::FETCH_ASSOC );
			
			return $result;
		}
		else
		{
			throw new Exception("Invalid data given", 1);
		}
	}



	public function SelectUnion( $data = array() )
	{



		if( 
			!empty( $data ) && 
			array_key_exists( 'table', $data ) && 
			array_key_exists( 'selector', $data ) &&
			count($data['table']) >= 2
			
		)
		{
			if( array_key_exists( 'condition', $data ) && !empty( $data['condition'] ) )
			{
				$condition = implode( ' ', $data['condition'] );


				$table = ""; 
				$i=1;

				foreach ($data['table'] as $tableName) {

					
					
					if ($i == count($data['table'])) {
						
						$table .= "select ". $data['selector']." from $tableName";

					}else{


						$table .= "select ". $data['selector']." from $tableName union all  ";

					}
					

					$i++;

				}

				

				 // echo 'SELECT ' . $data['selector'] . ' FROM (' . $table . ') newtable ' . $condition;
				 // die();

				$query = $this->db->query ( 'SELECT ' . $data['selector'] . ' FROM (' . $table . ') newtable ' . $condition);
				$result = $query->fetchAll ( PDO::FETCH_CLASS );
			}
			else
			{
				$query = $this->db->query ( 'SELECT ' . $data['selector'] . ' FROM `' . $data['table'] . '`' );
				$result = $query->fetchAll ( PDO::FETCH_CLASS );
			}
			return $result;
		}
		else
		{
			throw new Exception("Invalid data given", 1);
		}
	}

	public function Insert( $table, $data = array() )
	{
		
		if( empty( $table ) )
		{
			throw new Exception("Table name not given", 1);
		} 

		if( !empty( $data ) )
		{
			$query = $this->db->query( 'DESCRIBE ' . $table );
			$column = $query->fetchAll( PDO::FETCH_COLUMN );
			
			$column_t = array();
			$column_v = array();
			foreach ($data as $data_k => $data_v ) {
				if( in_array( $data_k, $column ) ){
					array_push( $column_t, $data_k );
					array_push( $column_v, ':' . $data_k );
				}
				else{
					throw new Exception("Invalid data given", 1);
				}
			}
			$prepare_string_t = implode( ', ', $column_t );
			$prepare_string_v = implode( ', ', $column_v );
			$query = $this->db->prepare ( 'INSERT INTO ' . $table . '(' . $prepare_string_t . ') VALUES(' . $prepare_string_v . ')' );
			$result = $query->execute ( $data );
			if ( $result ){
				return $this->db->lastInsertId();
			}
		}

		else
		{
			throw new Exception("Invalid data given", 1);
		}
	}

	public function Update( $table, $data = array(), $condition = array() )
	{
		
		if( empty( $table ) )
		{
			throw new Exception("Table name not given", 1);
		} 

		if( empty( $condition ) ) {
			throw new Exception("Update condition is not given", 1);
		}

		if( !empty( $data ) )
		{
			$query = $this->db->query( 'DESCRIBE ' . $table );
			$column = $query->fetchAll( PDO::FETCH_COLUMN );
			
			$column_t = array();
			foreach ($data as $data_k => $data_v ) {
				if( in_array( $data_k, $column ) ){
					array_push( $column_t, $data_k . '=:' . $data_k );
				}
				else{
					throw new Exception("Invalid data given", 1);
				}
			}
			$prepare_string_t = implode( ', ', $column_t );
			$condition = implode( ' ', $condition );

			// echo 'UPDATE ' . $table . ' SET ' . $prepare_string_t . ' ' . $condition;

			// echo "<br><pre>";

			// print_r($data);

			$query = $this->db->prepare ( 'UPDATE ' . $table . ' SET ' . $prepare_string_t . ' ' . $condition );
			$result = $query->execute ( $data );
			if ( $result ){
				return $result;
			}
		}

		else
		{
			throw new Exception("Invalid data given", 1);
		}
	}

	public function CreateTable( $table_name, $args )
	{
		if( empty( $table_name ) )
		{
			throw new Exception("Table name not given", 1);
			
		}
		$query = $this->db->query( 'SELECT count(table_name) FROM information_schema.tables WHERE table_schema = "' . DBNAME . '" AND table_name = "' . $table_name . '"' );
		$column = $query->fetchAll( PDO::FETCH_COLUMN );

		if( !$column[0] )
		{
			$dataArgs = array();
			foreach ($args as $args_key => $args_value ) {
				array_push( $dataArgs, $args_key . ' ' . $args_value );
			}
			$prepareArgs = implode( ', ', $dataArgs );
			$result = $this->db->query ( 'CREATE TABLE `' . $table_name . '`(' . $prepareArgs . ')' );

			if ( $result ){
				$query = $this->db->query( 'DESCRIBE ' . $table_name );
				$column = $query->fetchAll( PDO::FETCH_COLUMN );

				return $column;
				
			}
			else {
				return [];
			}
		}
		else
		{
			$query = $this->db->query( 'DESCRIBE ' . $table_name );
			$column = $query->fetchAll( PDO::FETCH_COLUMN );

			return $column;
		}
	}

	public function TableExist($table_name){
		$query = $this->db->query( 'SELECT count(table_name) FROM information_schema.tables WHERE table_schema = "' . DBNAME . '" AND table_name = "' . $table_name . '"' );
		$column = $query->fetchAll( PDO::FETCH_COLUMN );
		return $column[0];
	}
}
// $db=new Database();

          
// $arr=array();
// $arr['table']="user_mstr";
// $arr['selector']="id";
// $arr['condition']="where md5(id)!='a5771bce93e200c36f7cd9dfd0e5deaa'";
// print($arr);

//           // $getUserDtls=$db->Select($arr);
//            $getUserDtls=$db->Update('device_details',array('status'=>4),array('where md5(id)!="a5771bce93e200c36f7cd9dfd0e5deaa"',' and staus=1'));
           
//             print_r($getUserDtls);