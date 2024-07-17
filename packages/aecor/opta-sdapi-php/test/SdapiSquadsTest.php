<?php

use Sdapi\Endpoints\SdapiSquads;
use Sdapi\SdapiClient;

class SdapiSquadTest extends PHPUnit_Framework_TestCase
{
    public function testGetSquad()
    {
        $client = new SdapiClient('sdapidocumentation');
        $matchQuery = new SdapiSquads($client);
        $response = $matchQuery->getSquadsByTournament('408bfjw6uz5k19zk4am50ykmh');
        $this->assertTrue($response->statusCode == 200);
    }
}
