<?php

Use Liamqma\AuthToken\AuthToken;
Use \Mockery as m;

class AuthTokenTest extends PHPUnit_Framework_TestCase {

    private $userId;
    private $userTable;
    private $publicKey;
    private $privateKey;
    private $token;

    public function setUp() {
        $this->userId = 1;
        $this->userTable = 'User';
        $this->publicKey = 'publickey';
        $this->privateKey = 'privatekey';
        $this->token = 'token';
    }

    public function tearDown() {
        m::close();
    }

    public function testCreateToken() {
        $repo = m::mock('Liamqma\AuthToken\AuthTokenRepository');
        $repo->shouldReceive('purge')->with($this->userId, $this->userTable)->once();
        $repo->shouldReceive('store')->with($this->userId, $this->userTable, $this->publicKey, $this->privateKey)->once();

        $hasher = m::mock('Liamqma\AuthToken\HashProvider');
        $hasher->shouldReceive('make')->once()->andReturn($this->publicKey);
        $hasher->shouldReceive('makePrivate')->once()->with($this->publicKey)->andReturn($this->privateKey);

        $encrypter = m::mock('Illuminate\Encryption\Encrypter');
        $encrypter->shouldReceive('encrypt')->once()->with(array('id' => $this->userId, 'table' => $this->userTable, 'key' => $this->publicKey))->andReturn($this->token);
        
        $authToken = new AuthToken($repo, $hasher, $encrypter);
        $this->assertEquals($authToken->createToken($this->userId, $this->userTable), $this->token);
    }

    public function testValidateToken() {
        
        $data = array('id' => $this->userId, 'table' => $this->userTable, 'key' => $this->publicKey);
        
        $repo = m::mock('Liamqma\AuthToken\AuthTokenRepository');
        $repo->shouldReceive('getOrFail')->with($this->userId,$this->publicKey,$this->userTable)->once()->andReturn($this->userId);

        $hasher = m::mock('Liamqma\AuthToken\HashProvider');

        $encrypter = m::mock('Illuminate\Encryption\Encrypter');
        $encrypter->shouldReceive('decrypt')->once()->with($this->token)->andReturn($data);
        
        $authToken = new AuthToken($repo, $hasher, $encrypter);
        $this->assertTrue($authToken->validateToken($this->token));
    }

}

?>
