<?php

require_once(__DIR__ . '/../init.php');

use Aws\CloudWatch\CloudWatchClient;

$client = CloudWatchClient::factory(array(
	'region' => 'us-east-1'
));

$client->putMetricData(array(
	'Namespace' => 'Custom: Time Metrics',
	'MetricData' => array(
		array(
			'MetricName' => 'Current Seconds',
			'Value' => date('s'),
			'Unit' => 'Seconds',
		),
	)
));

?>
