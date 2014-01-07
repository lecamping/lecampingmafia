
    public function testCompleteScenario()
    {
        // Create a new client to browse the application
        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW'   => 'adminpass',
        ));

        // Create a new entry in the database
        $crawler = $client->request('GET', '/admin/{{ route_prefix }}/');
        $this->assertTrue(200 === $client->getResponse()->getStatusCode());
        $crawler = $client->click($crawler->selectLink('Create a new entry')->link());
        
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        
        $fields = array();
        $cl = $this->em->getClassMetadata('SmiirlAdminBundle:{{ entity_class }}');
        foreach($cl->getFieldNames() as $field)
        {
            if($field != "id")
            {
                $arg = '';
                switch($cl->getTypeOfField($field))
                {
                    case 'integer':
                        $arg = 1;
                        break;
                    case 'string':
                        $arg = "test string";
                        break;
                    case 'float':
                        $arg = '1.2';
                        break;
                    case 'boolean':
                        $arg = true;
                        break;
                    case 'smallint':
                        $arg = 2;
                        break;
                    case 'object':
                        break;
                    case 'date':
                        $arg['year'] = '2012';
                        $arg['month'] = '12';
                        $arg['day'] = '21';
                        break;
                    case 'array':
                        break;
                    case 'text':
                        $arg = 'test text';
                        break;
                    default:
                        echo "!\n! No rules for ".$cl->getTypeOfField($field)." ($field)\n!\n";
                        break;
                }
                $fields[$field] = $arg;   
            }
        }
        
        $el = new {{ entity_class }}();
        
        
        // Fill in the form and submit it
        $form = $crawler->selectButton('Create')->form(array(
            '{{ form_type_name|lower }}'  => $fields,
        ));

        $client->submit($form);
        $crawler = $client->followRedirect();
        
        // Check if page is ok
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        
        //print_r($client->getResponse()->getContent());
        //echo "\n\n\n\n";
        
        // TODO CHECK IF PRESET

        // Delete the entity
        $client->submit($crawler->selectButton('Delete')->form());
        $crawler = $client->followRedirect();
    }
