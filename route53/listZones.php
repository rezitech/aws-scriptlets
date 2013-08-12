<?php

require_once(__DIR__ . '/../init.php');

use Aws\Route53\Route53Client;

$client = Route53Client::factory();

$zones = $client->listHostedZones()->get('HostedZones');

$myZones = array();
foreach ($zones as $zone) {
	$myZone = new \stdClass();
	$myZone->Name = $zone['Name'];
	$myZone->Id = $zone['Id'];
	$myZone->Records = array();
	$records = $client->listResourceRecordSets(array('HostedZoneId' => $zone['Id']))->get('ResourceRecordSets');
	foreach ($records as $record) {
		$myZone->Records[$record['Name']] = new \stdClass();
		$myZone->Records[$record['Name']]->Type = $record['Type'];
		$myZone->Records[$record['Name']]->Values = array();
		if (!empty($record['ResourceRecords'])) {
			foreach ($record['ResourceRecords'] as $resourceRecord) {
				$myZone->Records[$record['Name']]->Values[] = $resourceRecord['Value'];
			}
		} else if (!empty($record['AliasTarget'])) {
			// This record is an Alias
		}
	}
	$myZones[] = $myZone;
}

var_dump($myZones);
?>
