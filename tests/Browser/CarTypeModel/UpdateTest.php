<?php

namespace Tests\Browser\CarTypeModel;

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
    public function test_should_show_edit_form()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/car-type-model')
                    ->clickAtXPath('//*[@id="users-table"]/tbody/tr[1]/td[1]/input')
                    ->pause(2500)
                    ->click('#editButton');

            $browser->whenAvailable('#exampleModal', function($modal) {
                $modal->assertSee('Update');
            });
        });
    }

    // Negative Test
    public function test_should_show_modelname_validation_when_empty()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/car-type-model')
                    ->clickAtXPath('//*[@id="users-table"]/tbody/tr[1]/td[1]/input')
                    ->pause(2500)
                    ->click('#editButton');

            $browser->whenAvailable('#exampleModal', function($modal) {
                $modal->select('#id_model', '') 
                ->click('#update')
                ->waitForText('The Model Name cant be Empty!')
                ->assertSee('The Model Name cant be Empty!');
            });
        });
    }

    public function test_should_show_typemodelname_validation_when_empty()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/car-type-model')
                    ->clickAtXPath('//*[@id="users-table"]/tbody/tr[1]/td[1]/input')
                    ->pause(2500)
                    ->click('#editButton');

            $browser->whenAvailable('#exampleModal', function($modal) {
                $modal->type('#type_model_name', ' ')
                ->click('#update')
                ->waitForText('The Type Model Name Cant be Empty!')
                ->assertSee('The Type Model Name Cant be Empty!');
            });
        });
    }

    public function test_should_show_typemodelname_validation_when_less_then_3_characters()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/car-type-model')
                    ->clickAtXPath('//*[@id="users-table"]/tbody/tr[1]/td[1]/input')
                    ->pause(2500)
                    ->click('#editButton');

            $browser->whenAvailable('#exampleModal', function($modal) {
                $modal->select('#id_model')
                ->type('#type_model_name', '12')
                ->click('#update')
                ->waitForText('The Type Model Name must be at least 3 Characters')
                ->assertSee('The Type Model Name must be at least 3 Characters');
            });
        });
    }


    // Positive Test
    public function test_should_not_show_modelname_validation_when_valid()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/car-type-model')
                    ->clickAtXPath('//*[@id="users-table"]/tbody/tr[1]/td[1]/input')
                    ->pause(2500)
                    ->click('#editButton');

            $browser->whenAvailable('#exampleModal', function($modal) {
                $modal->select('#id_model')
                ->type('#type_model_name', ' ')
                ->click('#update')
                ->pause(5000)
                ->assertDontSee('The Model Name cant be Empty!');
            });
        });
    }

    public function test_should_not_show_typemodelname_validation_when_valid()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/car-type-model')
                    ->clickAtXPath('//*[@id="users-table"]/tbody/tr[1]/td[1]/input')
                    ->pause(2500)
                    ->click('#editButton');

            $browser->whenAvailable('#exampleModal', function($modal) {
                $modal->select('#id_model')
                ->type('#type_model_name', Str::random(5))
                ->click('#update')
                ->pause(5000)
                ->assertDontSee('The Type Model Name Cant be Empty!')
                ->assertDontSee('The Type Model Name must be at least 3 Characters');
            });
        });
    }

    public function test_should_can_update_typemodelname()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/car-type-model')
                    ->clickAtXPath('//*[@id="users-table"]/tbody/tr[1]/td[1]/input')
                    ->pause(2500)
                    ->click('#editButton');

            $browser->whenAvailable('#exampleModal', function($modal) {
                $modal->select('#id_model')
                ->type('#type_model_name', Str::random(5))
                ->click('#update');
            });

            $browser->waitForText('Update Success!')
            ->assertSee('Update Success!');
        });
    }
}
