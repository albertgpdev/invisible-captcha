<?php

namespace Albertgpdev\InvisibleCaptcha\Test;

use Albertgpdev\InvisibleCaptcha\Test\TestCase;
use Albertgpdev\InvisibleCaptcha\InvisibleCaptcha;
use Albertgpdev\InvisibleCaptcha\InvisibleCaptchaServiceProvider;
use Illuminate\Container\Container;
use Illuminate\Filesystem\Filesystem;
use Illuminate\View\Compilers\BladeCompiler;

class CaptchaTest extends TestCase
{
    const PUBLIC_KEY = '6LdljUMUAAAAACNaMBD5ZRqcqSoyBdhE9inyvlD-';
    const PRIVATE_KEY = '6LdljUMUAAAAAEJVPw8mIHcbRobhtvJ67yAdBNMZ';
    // const PUBLIC_KEY = 'insert_here_your_public_key';
    // const PRIVATE_KEY = 'insert_here_your_private_key';

    protected function setUp()
    {
        $this->captcha = new InvisibleCaptcha(
            static::PUBLIC_KEY,
            static::PRIVATE_KEY
        );
    }

    public function testSomethingIsTrue()
    {
        $this->assertTrue(true);
    } 

    public function testConstructor()
    {
        $this->assertEquals(static::PRIVATE_KEY, $this->captcha->getPrivateKey());
        $this->assertEquals(static::PUBLIC_KEY, $this->captcha->getPublicKey());
        $this->assertTrue($this->captcha->getClient() instanceof \GuzzleHttp\Client);
    }

    public function testBladeDirective()
    {
        $app = Container::getInstance();
        $app->instance('captcha', $this->captcha);
        $blade = new BladeCompiler(
            $this->getMockBuilder(Filesystem::class)->disableOriginalConstructor()->getMock(),
            __DIR__
        );
        $provider = new InvisibleCaptchaServiceProvider($app);
        $provider->addBladeDirective($blade);
        $result = $blade->compileString('@captcha()');
        $this->assertEquals(
            "<?php echo app('captcha')->render(); ?>",
            $result
        );
    }
}
