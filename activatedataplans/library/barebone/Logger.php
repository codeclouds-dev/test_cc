<?php
/**
 * App
 * @author: Arindam Metya
 * @note: this is a cron process file
 */

namespace Application;

class Logger
{
	
	function __construct()

	{

		return;

	}

	public static function Write( $exception, $jobId = '' )

	{

		if( empty( $exception ) )

		{

			return;

		}

		if( !empty( $jobId ) )
		
		{

			$databaseHandler = new Database();

			$databaseHandler->Update(

		    	TABLENAME,

		    	array( 'API_LOG' => $exception ),

		    	array( 'WHERE `id` = ' . $jobId )

		    );

		}

		$fileHandler = fopen( 'ExceptionLogs.txt' , 'a' ) or die( 'can\'t open file' );

		fwrite( $fileHandler, sprintf( "%s >> %s \n\n", date( 'Y/m/d' ), $exception ) );

		fclose( $fileHandler );

	}

}