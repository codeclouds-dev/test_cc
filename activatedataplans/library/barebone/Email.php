<?php

/**

 * Cron

 * Version: 1.0

 * Author: Arindam Metya

 */

namespace Application;

class Email

{

	function __construct(){

		return;

	}



	protected $customers;

	protected $response = [];



	public function listScheduledCustomers( $limit ) {



		$dateLimit = date( 'Y-m-d H:i:s', strtotime( '-5 day', strtotime( date('now') ) ) );



		$db = new Database();

		$this->customers = $db->Select([

			'table' => TABLENAME,

			'selector' => '*',

			'condition' => [

				'WHERE (`processed` = "Processed" OR `processed` = "Duplicate")',

				'AND `is_sent` IS NULL',

				'AND `created_at` > "'. $dateLimit .'"',

				'ORDER BY `id` ASC',

				'LIMIT '. $limit

			],

		]);



	}

	public function queryCustomer($customerId) {



		if( empty($customerId) ) {

			return;

		}



		$crm = new Konnektive();

		$orderQuery = $crm->queryCustomer($customerId);

		$orderQueryArr = json_decode($orderQuery, true);



		if( !empty($orderQueryArr) && $orderQueryArr['result'] == 'SUCCESS' ) {



			$firstName = isset($orderQueryArr['message']['data']['0']['firstName']) ? $orderQueryArr['message']['data']['0']['firstName'] : '';

			$lastName = isset($orderQueryArr['message']['data']['0']['lastName']) ? $orderQueryArr['message']['data']['0']['lastName'] : '';

			$emailAddress = isset($orderQueryArr['message']['data']['0']['emailAddress']) ? $orderQueryArr['message']['data']['0']['emailAddress'] : '';

			return array(

				'name' => sprintf( '%s %s', $firstName, $lastName ),

				'email' => $emailAddress,

			);

		}

	}

	public function send( $limit ) {



		require_once dirname( __FILE__ ) . '/Sendgrid/sendgrid-php.php';



		$this->listScheduledCustomers($limit);



		if( !empty($this->customers) ) {



			foreach ($this->customers as $customer) {



				$uniqueId = $customer->id;

				$customerId = $customer->customer_id;

				$orderId = $customer->order_id;

				$product = $customer->product;

				$crm = new Konnektive();

				// $orderQuery = $crm->transactionQuery($customerId, $orderId);

				$orderQuery = $crm->customerQuery($customerId);

				$orderQueryArr = json_decode($orderQuery, true);



				if( !empty($orderQueryArr) && $orderQueryArr['result'] == 'SUCCESS' ) {



					$firstName = isset($orderQueryArr['message']['data']['0']['firstName']) ? $orderQueryArr['message']['data']['0']['firstName'] : '';

					$lastName = isset($orderQueryArr['message']['data']['0']['lastName']) ? $orderQueryArr['message']['data']['0']['lastName'] : '';

					$emailAddress = isset($orderQueryArr['message']['data']['0']['emailAddress']) ? $orderQueryArr['message']['data']['0']['emailAddress'] : '';

					// $descriptor = isset($orderQueryArr['message']['data']['0']['merchantDescriptor']) ? $orderQueryArr['message']['data']['0']['merchantDescriptor'] : '';

					

					$name = sprintf('%s %s', $firstName, $lastName);

					$couponCode = $customer->coupon;

					$discountAmount = $customer->amount;

					$log = json_decode($customer->api_log, true);



					if( 
						file_exists( sprintf( '%s/Template/%s/order-confirmation.html', CLASSPATH, $product ) ) && 
						is_file( sprintf( '%s/Template/%s/order-confirmation.html', CLASSPATH, $product ) ) 
					) {

						$template = file_get_contents( sprintf( '%s/Template/%s/order-confirmation.html', CLASSPATH, $product ) );

					}

					else {

						$template = file_get_contents( CLASSPATH . '/Template/flag/order-confirmation.html' );

					}

					



					$template = preg_replace('/{+?(\s+|\s*)?+(coupon_code)+?(\s+|\s*)?+}/i', $couponCode, $template );

					$template = preg_replace('/{+?(\s+|\s*)?+(discount_amount)+?(\s+|\s*)?+}/i', $discountAmount, $template );

					// $template = preg_replace('/{+?(\s+|\s*)?+(descriptor)+?(\s+|\s*)?+}/i', $descriptor, $template );



					$email = new \SendGrid\Mail\Mail();

					$email->setFrom("support@patriotusanation.com");

					$email->setSubject("USA Patriot Nation Club Membership");

					$email->addTo($emailAddress);

					$email->addContent("text/html", $template);



					$sendgrid = new \SendGrid('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');



					try {



					    $response = $sendgrid->send($email);



					    if( ( $response->statusCode() == '200' ) || ( $response->statusCode() == '202' ) ) {



					    	$log['EMAIL'] = 'An Order Confirmation email has been sent to ' . $emailAddress;

					    	array_push( 

					    		$this->response, 

					    		sprintf( 

					    			'--EMAIL-SENT|CUSTOMER_ID:%d--', 

					    			$customerId 

					    		) 

					    	);



					    	$db = new Database();

					    	$db->Update(

					    		TABLENAME,

					    		array(

					    			'name' 	  => $name,

	        						'email'   => $emailAddress,

	    		        			'is_sent' => 'Sent',

	    		        			'api_log' => json_encode($log)

	    		        		),

					    		array(

					    			'WHERE `id` = ' . $uniqueId,

					    		)

					    	);

					    }

					} 

					catch (Exception $e) {



						$log['EMAIL'] = $e->getMessage();



					    array_push( 

					    	$this->response, 

					    	sprintf( 

					    		'--%s|CUSTOMER_ID:%d--', 

					    		$e->getMessage(), 

					    		$customerId

					    	) 

					    );



					    $db = new Database();

					    $db->Update(

					    	TABLENAME,

				    		array(

				    			'name' 	  => $name,

	        					'email'   => $emailAddress,

			        			'is_sent' => 'Failed',

			        			'api_log' => json_encode($log)

			        		),

					    	array(

					    		'WHERE `id` = ' . $uniqueId,

					    	)

					    );

					}

				}

			}

			if( !empty($this->response) ) {



				echo implode('<br>', $this->response);



			}

		}

		else {



			echo '--NO-CUSTOMER-FOUND--';



		}

	}

}