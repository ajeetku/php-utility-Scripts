<?php
function convert($datetime){
				//$timezone = $_SESSION['time'];
				$ip     = $_SERVER['REMOTE_ADDR']; // means we got user's IP address 
				
				/*Or We can also use it to get users Ip address
				// Get IP address
					$ip = getenv('HTTP_CLIENT_IP') ?: getenv('HTTP_X_FORWARDED_FOR') ?: getenv('HTTP_X_FORWARDED') ?: getenv('HTTP_FORWARDED_FOR') ?: getenv('HTTP_FORWARDED') ?: getenv('REMOTE_ADDR');
				*/

				$json   = file_get_contents( 'https://timezoneapi.io/api/ip/?' . $ip); 
				$ipData = json_decode( $json, true);
				$timezone = @$ipData['data']['timezone']['id'];
				
				//$datetime = '10:00PM';
				$tz_from = 'Europe/London';
				$tz_to = $timezone;
				$format = 'H:iA';

				$dt = new DateTime($datetime, new DateTimeZone($tz_from));
				$dt->setTimeZone(new DateTimeZone($tz_to));
				return $dt->format($format) . "\n";
			}