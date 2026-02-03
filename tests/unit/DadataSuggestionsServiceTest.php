<?php

namespace unit;

use DadataSuggestions\DadataSuggestionsService;
use DadataSuggestions\Data\Address;
use DadataSuggestions\Response;
use PHPUnit\Framework\TestCase;

class DadataSuggestionsServiceTest extends TestCase
{
    public function testSuggestAddressSimple()
    {
        $service = $this->getService();
        $response = $service->suggestAddress('moskv');
        $this->assertNotEmpty($response);
        $this->assertInstanceOf(Response::class, $response);
        $this->assertNotEmpty($response->getSuggestions());
        $this->assertIsArray($response->getSuggestions());
        foreach ($response->getSuggestions() as $suggestion) {
            $this->assertNotEmpty($suggestion->getValue());
            $this->assertNotEmpty($suggestion->getUnrestrictedValue());
            /** @var Address $data */
            $data = $suggestion->getData();
            $this->assertInstanceOf(Address::class, $data);
            $this->assertNotEmpty($data->country);
            $this->assertNotEmpty($data->city);
        }
    }

    public function testSuggestAddressFlat()
    {
        $service = $this->getService();
        $response = $service->suggestAddress('мск балтийская 6к1 5');
        $this->assertNotEmpty($response);
        $this->assertInstanceOf(Response::class, $response);
        $this->assertNotEmpty($response->getSuggestions());
        $this->assertIsArray($response->getSuggestions());
        foreach ($response->getSuggestions() as $suggestion) {
            /** @var Address $data */
            $data = $suggestion->getData();
            $this->assertInstanceOf(Address::class, $data);
            $this->assertNotEmpty($data->country);
            $this->assertNotEmpty($data->city);
            $this->assertNotEmpty($data->street_with_type);
            $this->assertNotEmpty($data->house);
            $this->assertNotEmpty($data->block);
            $this->assertNotEmpty($data->flat);
        }
    }

    /**
     * @return DadataSuggestionsService
     */
    protected function getService()
    {
        $service = new DadataSuggestionsService();
        $service->setToken('ab626ac37b47868748ea2f408293ed6a1e420944');
        return $service;
    }
}
