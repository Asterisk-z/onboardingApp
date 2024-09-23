<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ExampleTest extends DuskTestCase
{
    /**
     * A basic browser test example.
     *
     * @return void
     */
    public function testBasicExample()
    {
        static::startChromeDriver();

        $this->browse(function (Browser $browser) {
            $browser->visit('/')->screenshot('testfile.pdf');
        });
    }
}
