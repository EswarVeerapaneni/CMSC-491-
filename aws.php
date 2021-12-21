<?php

require_once(__DIR__ . '/vendor/autoload.php');

use Aws\S3\S3Client;
use Aws\Rekognition\RekognitionClient;


$bucket = '491project';

$s3 = new S3Client([
	'region' 	=> 'us-east-2',
	'version' 	=> '20206-12-08'
]);

try {
	$result = $s3->putObject([
		'Bucket' 		=> $bucket,
		'Key'    		=> $keyname,
		'SourceFile'   	=> __DIR__. "/$keyname",
		'ACL'    		=> 'public-read-write'
	]);

	$imageUrl = $result['ObjectURL'];
	if($imageUrl) {
		echo "Image uploded " . $imageUrl;

		$rekognition = new RekognitionClient([
			'region' 	=> 'us-east-2',
			'version' 	=> 'latest',
		]);

		$result = $rekognition->detectFaces([
			'Attributes'	=> ['DEFAULT'],
			'Image' => [
				'S3Object' => [
					'Bucket' => $bucket,
					'Name' 	=> 	$keyname,
					'Key' 	=> 	$keyname,
				],
			],
		]);

		echo "Totally there are " . count($result["FaceDetails"]) . " faces";
	}
} catch (Exception $e) {
	echo $e->getMessage() . PHP_EOL;
}
