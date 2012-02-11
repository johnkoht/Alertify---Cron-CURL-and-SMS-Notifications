<?php
	
/**************************************************************************
 **************************************************************************
 *
 *    Alertify v1.0
 *    By John Koht
 *    
 *    A cron will run this script, which will make a CURL
 *    request to website, if it exists, then send a group
 *    of people a SMS using Twilio's API
 *
*/

	
	// IMPORT TWILIO LIBRARY
	require "twilio.php";
	
	// ARRAY OF NUMBERS TO TEXT MESSAGE
	$numbers = array(
		'9005551234',
		'1234567890'
	);
		
	// THE TEXT MESSAGE
	$message = 'SOMETHING IS HAPPENING!';
	
	
	// TWILIO API CREDENTIALS
	$tw_phonenumber	= "YOUR-TWILIO-PHONE-NUMBER";
	$tw_ApiVersion = "TWILIO API DATE";
	$tw_AccountSid	= "TWILIO ACCOUNT SID";
	$tw_AuthToken	= "TWILIO AUTHENTICATION TOKEN";	
	
	$client = new TwilioRestClient($tw_AccountSid, $tw_AuthToken);
	
	
	// RUN THE CURL
	$ch = curl_init();	
	
	curl_setopt($ch, CURLOPT_URL, "HTTP://WWW.THE.URL/YOU/WANT/TO/CURL");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	
	$contents = curl_exec ($ch);
		
	curl_close ($ch);


		
	// If the CURL returns a valid page then send some text messages out
	
	if ($contents != null) {
		foreach ($numbers as $n => $value) {
			$response = $client->request("/".$tw_ApiVersion."/Accounts/".$tw_AccountSid."/SMS/Messages",
	        	"POST", array(
		            "To" => $numbers[$n],
		            "From" => $tw_phonenumber,
		            "Body" => $message
	        	)
	        );
	        if ($response->IsError) {
	            echo "Error: {$response->ErrorMessage}" . '<br />';
	        } else {
	        	echo 'WINRAR!';
	      	}
	      	
	     } // end foreach
	} // end if $content != null
	
	
	else
	
	
	// If the CURL return is false then try again :(
	{
		echo "try again!";		
	}


	
?>