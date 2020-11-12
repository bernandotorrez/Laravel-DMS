<?php

namespace Tests\Browser\Login;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Tests\Browser\Pages\Login;

class LoginTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */

    // Negative Test
    public function test_should_see_email_validation_when_email_is_empty()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Login)
                    ->assertSee('Sign In')
                    ->type('@email', '')
                    ->pressLoginAndSeeEmailRequired();
        });
    }

    public function test_should_see_email_validation_when_email_is_not_valid()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Login)
                    ->assertSee('Sign In')
                    ->type('@email', 'asdadas')
                    ->pressLoginAndSeeEmailNotValid();
        });
    }

    public function test_should_see_password_validation_when_password_is_empty()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Login)
                    ->assertSee('Sign In')
                    ->type('@email', 'bernandotorrez4@gmail.com')
                    ->pressLoginAndSeePasswordRequired();
        });
    }

    public function test_should_see_password_validation_when_password_is_less_then_six_characters()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Login)
                    ->assertSee('Sign In')
                    ->type('@email', 'bernandotorrez4@gmail.com')
                    ->type('@password', '12345')
                    ->pressLoginAndSeePasswordLessThenGivenCharacters();
        });
    }

    public function test_should_go_to_home_when_email_and_password_is_not_correct()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Login)
                    ->assertSee('Sign In')
                    ->type('@email', 'bernandotorrez4@gmail.com')
                    ->type('@password', 'B3rnando12323')
                    ->pressLoginAndSeeWrongCredential();
        });
    }
    // Negative Test
    
    // Positive Test
    public function test_should_not_see_email_validation_when_email_is_valid()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Login)
                    ->assertSee('Sign In')
                    ->type('@email', 'bernandotorrez4@gmail.com')
                    ->pressLoginAndDontSeeEmailValidation();
        });
    }

    public function test_should_not_see_password_validation_when_password_is_valid()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Login)
                    ->assertSee('Sign In')
                    ->type('@email', 'bernandotorrez4@gmail.com')
                    ->type('@password', 'B3rnando')
                    ->pressLoginAndDontSeePasswordValidation();
        });
    }

    public function test_should_go_to_home_when_email_and_password_is_correct()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Login)
                    ->assertSee('Sign In')
                    ->type('@email', 'bernandotorrez4@gmail.com')
                    ->type('@password', 'B3rnando')
                    ->press('Log In')
                    ->pause(5000)
                    ->assertPathIs('/home');
        });
    }
    // Positive Test
}
