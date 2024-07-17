<?php

use Sdapi\Endpoints\SdapiStandings;
use Sdapi\SdapiClient;

class SdapiStandingsTest extends PHPUnit_Framework_TestCase
{
    public function testGetStandingsByTournament()
    {
        $client = new SdapiClient('sdapidocumentation');
        $matchQuery = new SdapiStandings($client);
        $response = $matchQuery->getStandingsByTournament('408bfjw6uz5k19zk4am50ykmh');
        $this->assertTrue($response->statusCode == 200);
    }
}
