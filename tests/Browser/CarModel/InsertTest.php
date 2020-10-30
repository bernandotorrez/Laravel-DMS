<?php

namespace Tests\Browser\CarModel;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Support\Str;

class InsertTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */

    // Negative Test
    public function test_should_show_modelname_validation_when_empty()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/car-model')
                    ->type('#model_name', '')
                    ->click('#submit')
                    ->waitForText('The model name field is required.')
                    ->assertSee('The model name field is required.');
        });
    }

    public function test_should_show_modelname_validation_when_less_then_3_characters()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/car-model')
                    ->type('#model_name', '12')
                    ->click('#submit')
                    ->waitForText('The model name must be at least 3 characters.')
                    ->assertSee('The model name must be at least 3 characters.');
        });
    }
    // Negative Test

    public function test_should_not_show_modelname_validation_when_valid()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/car-model')
                    ->type('#model_name', Str::random(5))
                    ->click('#submit')
                    ->pause(5000)
                    ->assertDontSee('The model name field is required.')
                    ->assertDontSee('The model name must be at least 3 characters.');
        });
    }

    public function test_should_can_insert_modelname()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/car-model')
                    ->type('#model_name', Str::random(5))
                    ->click('#submit')
                    ->waitForText('Insert Success!')
                    ->assertSee('Insert Success!');
        });
    }
}
