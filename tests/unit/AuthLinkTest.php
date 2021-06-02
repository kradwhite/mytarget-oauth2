<?php
/**
 * Date: 02.06.2021
 * Time: 14:51
 * Author: Artem Aleksandrov
 */

declare (strict_types=1);

namespace kradwhite\myTarget\api\oauth2\tests\unit;

use kradwhite\myTarget\api\oauth2\Oauth2;
use kradwhite\myTarget\api\oauth2\Scopes;

/**
 * Class AuthLinkTest
 * @package kradwhite\myTarget\api\oauth2\tests\unit
 */
class AuthLinkTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    public function testAuthLink()
    {
        $link = (new Oauth2([]))->authorizeLink('12345', Scopes::all(), 'state');
        $this->assertStringContainsString('https://target.my.com/oauth2/authorize?', $link);
        $this->assertStringContainsString('response_type=code', $link);
        $this->assertStringContainsString('&client_id=1234', $link);
        $this->assertStringContainsString('&scope=' . urlencode(Scopes::all()), $link);
        $this->assertStringContainsString('&state=state', $link);
    }
}
