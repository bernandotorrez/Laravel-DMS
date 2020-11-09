<?php

namespace Tests\Browser\CarModel;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;
use Illuminate\Support\Str;

class UpdateTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function test_should_show_update_button()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/car-model')
                    ->clickAtXPath('//*[@id="users-table"]/tbody/tr[1]/td[1]/input')
                    ->pause(2500)
                    ->click('#editButton');

            $browser->whenAvailable('#exampleModal', function($modal) {
                $modal->waitForTextIn('#update', 'Update')
                ->assertPresent('#update');
            });
        });
    }

    // Negative Test
    // public function test_should_show_modelname_validation_when_empty()
    // {
    //     $this->browse(function (Browser $browser) {
    //         $browser->loginAs(User::find(1))
    //                 ->visit('/car-model')
    //                 ->clickAtXPath('//*[@id="content"]/div[1]/div/div/div/div/div/table/tbody[1]/tr[1]/td[3]/button[1]')
    //                 ->waitForTextIn('#update', 'Update')
    //                 ->assertPresent('#update')
    //                 ->value('#model_name', '')
    //                 ->pause(3000)
    //                 ->click('#update')
    //                 ->waitForText('The model name field is required.')
    //                 ->assertSee('The model name field is required.');
    //     });
    // }

    public function test_should_show_modelname_validation_when_less_then_3_characters()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/car-model')
                    ->clickAtXPath('//*[@id="users-table"]/tbody/tr[1]/td[1]/input')
                    ->pause(2500)
                    ->click('#editButton');

            $browser->whenAvailable('#exampleModal', function($modal) {
                $modal->waitForTextIn('#update', 'Update')
                ->assertPresent('#update')
                ->type('#model_name', '12')
                ->pause(2500)
                ->click('#update')
                ->waitForText('The Model Name must be at least 3 Characters')
                ->assertSee('The Model Name must be at least 3 Characters');
            });
        });
    }
    // Negative Test

    public function test_should_not_show_modelname_validation_when_valid()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/car-model')
                    ->clickAtXPath('//*[@id="users-table"]/tbody/tr[1]/td[1]/input')
                    ->pause(2500)
                    ->click('#editButton');
            
            $browser->whenAvailable('#exampleModal', function($modal) {
                $modal->waitForTextIn('#update', 'Update')
                ->assertPresent('#update')
                ->pause(2500)
                ->assertDontSee('The Model Name Cant be Empty!')
                ->assertDontSee('The Model Name must be at least 3 Characters');
            });
        });
    }

    public function test_should_can_update_modelname()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/car-model')
                    ->clickAtXPath('//*[@id="users-table"]/tbody/tr[1]/td[1]/input')
                    ->pause(2500)
                    ->click('#editButton');

            $browser->whenAvailable('#exampleModal', function($modal) {
                $modal->waitForTextIn('#update', 'Update')
                ->assertPresent('#update')
                ->type('#model_name', Str::random(10))
                ->click('#update');
            });

            $browser->waitForText('Update Success!')
            ->assertSee('Update Success!');
        });
    }
}
