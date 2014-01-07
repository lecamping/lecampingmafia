<?php

namespace LCM\AdminBundle\Tests\Controller;
namespace LCM\AdminBundle\Entity;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * {@inheritDoc}
     */
    public function setUp()
    {
        static::$kernel = static::createKernel();
        static::$kernel->boot();
        $this->em = static::$kernel->getContainer()->get('doctrine')->getManager();
    }

    /**
     * {@inheritDoc}
     */
    protected function tearDown()
    {
        parent::tearDown();
        $this->em->close();
    }
    public function testAccess()
    {
        // Try to access without login & password
        $client = static::createClient(array(), array());
        $crawler = $client->request('GET', '/admin/user/');
        $this->assertTrue(401 === $client->getResponse()->getStatusCode());
        
        
        // Try to access with good login & password
        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW'   => 'adminpass',
        ));
        $crawler = $client->request('GET', '/admin/user/');
        $this->assertTrue(200 === $client->getResponse()->getStatusCode());
    }

    public function testCompleteScenario()
    {
        // Create a new client to browse the application
        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW'   => 'adminpass',
        ));

        // Create a new entry in the database
        $crawler = $client->request('GET', '/admin/user/');
        $this->assertTrue(200 === $client->getResponse()->getStatusCode());
        $crawler = $client->click($crawler->selectLink('Create a new entry')->link());
        
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        
        $fields = array();
        $cl = $this->em->getClassMetadata('SmiirlAdminBundle:User');
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
        
        $el = new User();
        
        
        // Fill in the form and submit it
        $form = $crawler->selectButton('Create')->form(array(
            'lcm_adminbundle_usertype'  => $fields,
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
    
}