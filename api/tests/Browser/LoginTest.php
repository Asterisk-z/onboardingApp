<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testExample()
    {
        static::startChromeDriver(['win']);
        $this->browse(function (Browser $browser) {
            $browser->visit('/');
            // ->assertSee('Laravel');
        });
    }
}
