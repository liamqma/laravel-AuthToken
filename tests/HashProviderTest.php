<?php

Use Liamqma\AuthToken\HashProvider;

class HashProviderTest extends PHPUnit_Framework_TestCase {

    public function testMakeWithoutParams() {
        $h = new HashProvider('key');
        $this->assertNotEmpty($h->make());
    }

    public function testMakePrivate() {
        $h = new HashProvider('key');
        $this->assertNotEmpty($h->makePrivate($h->make()));
    }

    public function testCheckInvalidKeyPair() {
        $h = new HashProvider('key');

        $this->assertFalse($h->check('good', 'bad'));
    }

    public function testCheckValidKeyPair() {
        $h = new HashProvider('key');

        $pub = $h->make();
        $priv = $h->makePrivate($pub);

        $this->assertTrue($h->check($pub, $priv));
    }

}