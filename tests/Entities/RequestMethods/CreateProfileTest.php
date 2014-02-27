<?php

use Gufran\AuthNet\Entities\RequestMethods\CreateProfile;

class CreateProfileTest extends PHPUnit_Framework_TestCase {

    private $object;

    private $method;

    public function setUp()
    {
        parent::setUp();
    }

    public function tearDown()
    {
        Mockery::close();
    }

    public function test_it_accepts_object_model()
    {
        $this->object = Mockery::mock('Gufran\AuthNet\Entities\RequestObjects\BaseObject');

        $this->object->shouldReceive('respondTo')
                     ->andReturn(true);

        $this->object->shouldReceive('getObjectData')
                     ->andReturn(array('name' => 'firstName', 'type' => 'request', 'userProfile' => '1001'));

        $this->method = new CreateProfile($this->object);

    }

    /**
     * @expectedException Gufran\AuthNet\Exceptions\InvalidDataObjectException
     */
    public function test_it_fails_if_object_does_not_respond_to_method()
    {
        $this->object = Mockery::mock('Gufran\AuthNet\Entities\RequestObjects\BaseObject');

        $this->object->shouldReceive('respondTo')
                     ->andReturn(false);

        $this->method = new CreateProfile($this->object);
    }

    /**
     * @expectedException \ErrorException
     */
    public function test_throws_exception_without_credentials()
    {
        $this->object = Mockery::mock('Gufran\AuthNet\Entities\RequestObjects\BaseObject');

        $this->object->shouldReceive('respondTo')
                     ->andReturn(true);

        $this->object->shouldReceive('getObjectData')
                     ->andReturn(array('name' => 'firstName', 'type' => 'request', 'userProfile' => '1001'));

        $this->method = new CreateProfile($this->object);

        $this->method->getFormattedXml();
    }

    public function test_get_formatted_xml_with_credentials()
    {
        $this->object = Mockery::mock('Gufran\AuthNet\Entities\RequestObjects\BaseObject');

        $this->object->shouldReceive('respondTo')
                     ->andReturn(true);

        $this->object->shouldReceive('getObjectData')
                     ->andReturn(array('name' => 'firstName', 'type' => 'request', 'userProfile' => '1001'));

        $this->method = new CreateProfile($this->object);
        $this->method->setAuthentication('gufran', 'key');

        $xml = $this->method->getFormattedXml();

        $this->assertRegExp('/<name>firstName<\/name>/', $xml);
        $this->assertRegExp('/<type>request<\/type>/', $xml);
        $this->assertRegExp('/<userProfile>1001<\/userProfile>/', $xml);
    }

    public function test_can_build_xml_with_nested_array()
    {
        $this->object = Mockery::mock('Gufran\AuthNet\Entities\RequestObjects\BaseObject');

        $this->object->shouldReceive('respondTo')
                     ->andReturn(true);

        $this->object->shouldReceive('getObjectData')
                     ->andReturn(
                        array(
                            'name' => 'firstName',
                            'type' => 'request',
                            'userProfile' => '1001',
                            'nested' => array(
                                'element' => 'oneLevelDeep',
                                'second' => 'anotherElement'
                            )
                        )
                     );

        $this->method = new CreateProfile($this->object);
        $this->method->setAuthentication('gufran', 'key');

        $xml = $this->method->getFormattedXml();
        $this->assertRegExp('/<nested><element>oneLevelDeep<\/element><second>anotherElement<\/second>/', $xml);

    }

    public function test_can_parse_nested_non_associative_array_to_crete_multiple_elements()
    {
        $this->object = Mockery::mock('Gufran\AuthNet\Entities\RequestObjects\BaseObject');

        $this->object->shouldReceive('respondTo')
                     ->andReturn(true);

        $this->object->shouldReceive('getObjectData')
                     ->andReturn(
                     array(
                         'name' => 'firstName',
                         'type' => 'request',
                         'userProfile' => '1001',
                         'nested' => array(
                            array('levelOne' => 'oneLevelDeep'),
                            array('oneLevel' => 'secondElement')
                         )
                     )
            );

        $this->method = new CreateProfile($this->object);
        $this->method->setAuthentication('gufran', 'key');

        $xml = $this->method->getFormattedXml();

        $this->assertRegExp('/<nested><levelOne>oneLevelDeep<\/levelOne><\/nested>/', $xml);
        $this->assertRegExp('/<nested><oneLevel>secondElement<\/oneLevel><\/nested>/', $xml);
    }

    public function test_it_can_generate_xml_with_nested_objects_in_array()
    {
        $this->object = Mockery::mock('Gufran\AuthNet\Entities\RequestObjects\BaseObject');

        $this->object->shouldReceive('respondTo')
                     ->andReturn(true);

        $elementObject = Mockery::mock('Gufran\AuthNet\Entities\RequestObjects\BaseObject');

        $elementObject->shouldReceive('getObjectData')->andReturn(array('hello' => 'world'));

        $this->object->shouldReceive('getObjectData')
                     ->andReturn(
                     array(
                         'name' => 'firstName',
                         'type' => 'request',
                         'userProfile' => '1001',
                         'object' => $elementObject
                     )
            );

        $this->method = new CreateProfile($this->object);
        $this->method->setAuthentication('gufran', 'key');

        $xml = $this->method->getFormattedXml();
        $this->assertRegExp('/<object><hello>world<\/hello><\/object>/', $xml);

    }
}