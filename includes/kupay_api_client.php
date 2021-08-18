<?php

use GuzzleHttp\Client;

class KuPayApiClient {

	public $kupay_http_client = null;

	public function __construct() {
		$this->kupay_http_client = new Client([
			'base_uri' => 'localhost:3000/dev/',
			'timeout'  => 3.0,
		]);
	}

	public function executePostRequest($body, $uri): array {

		try {

			$response = $this->kupay_http_client->post($uri, [
				GuzzleHttp\RequestOptions::JSON => $body
			]);

			return [
				'status_code' => $response->getStatusCode(),
				'data' => json_decode($response->getBody(), true)['data']
			];

		} catch ( \GuzzleHttp\Exception\GuzzleException $e ) {

			print_r($e->getMessage());

			return [
				'status_code' => $e->getCode(),
				'message' => $e->getMessage(),
			];
		}

	}

}