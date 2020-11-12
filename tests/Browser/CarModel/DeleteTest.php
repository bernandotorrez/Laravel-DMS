<?php

namespace Tests\Browser\CarModel;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;

class DeleteTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function test_should_can_delete_modelname()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/car-model')
                    ->clickAtXPath('//*[@id="users-table"]/tbody/tr[1]/td[1]/input')
                    ->pause(2500)
                    ->click('#deleteButton')
                    ->press('Delete!')
                    ->waitForText('Delete Data Success!')
                    ->assertSee('Delete Data Success!');
        });
    }
}
