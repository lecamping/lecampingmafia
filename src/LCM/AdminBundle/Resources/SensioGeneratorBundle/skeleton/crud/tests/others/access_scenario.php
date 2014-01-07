
    public function testAccess()
    {
        // Try to access without login & password
        $client = static::createClient(array(), array());
        $crawler = $client->request('GET', '/admin/{{ route_prefix }}/');
        $this->assertTrue(401 === $client->getResponse()->getStatusCode());
        
        
        // Try to access with good login & password
        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW'   => 'adminpass',
        ));
        $crawler = $client->request('GET', '/admin/{{ route_prefix }}/');
        $this->assertTrue(200 === $client->getResponse()->getStatusCode());
    }
