<?php

namespace Tests\Browser\CarTypeModel;

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
    public function testExample()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/car-type-model')
                    ->clickAtXPath('//*[@id="users-table"]/tbody/tr[1]/td[1]/input')
                    ->pause(2500)
                    ->click('#deleteButton')
                    ->press('Delete!')
                    ->waitForText('Delete Data Success!')
                    ->assertSee('Delete Data Success!');
        });
    }
}
