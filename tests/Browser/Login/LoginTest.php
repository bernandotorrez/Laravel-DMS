<?php

namespace Tests\Browser\Login;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

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
            $browser->visit('/login')
                    ->assertSee('Sign In')
                    ->type('email', '')
                    ->press('Log In')
                    ->waitForText('The email field is required.')
                    ->assertSee('The email field is required.');
        });
    }

    public function test_should_see_email_validation_when_email_is_not_valid()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->assertSee('Sign In')
                    ->type('email', 'asdadas')
                    ->press('Log In')
                    ->waitForText('Please enter with Valid Email Address')
                    ->assertSee('Please enter with Valid Email Address');
        });
    }

    public function test_should_see_password_validation_when_password_is_empty()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->assertSee('Sign In')
                    ->type('email', 'bernandotorrez4@gmail.com')
                    ->press('Log In')
                    ->waitForText('The password field is required.')
                    ->assertSee('The password field is required.');
        });
    }

    public function test_should_see_password_validation_when_password_is_less_then_six_characters()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->assertSee('Sign In')
                    ->type('email', 'bernandotorrez4@gmail.com')
                    ->type('password', '12345')
                    ->press('Log In')
                    ->waitForText('Please fill password minimal 6 Characters')
                    ->assertSee('Please fill password minimal 6 Characters');
        });
    }

    public function test_should_go_to_home_when_email_and_password_is_not_correct()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->assertSee('Sign In')
                    ->type('email', 'bernandotorrez4@gmail.com')
                    ->type('password', 'B3rnando12323')
                    ->press('Log In')
                    ->waitForText('Email or Password is Wrong!')
                    ->assertSee('Email or Password is Wrong!');
        });
    }
    // Negative Test
    
    // Positive Test
    public function test_should_not_see_email_validation_when_email_is_valid()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->assertSee('Sign In')
                    ->type('email', 'bernandotorrez4@gmail.com')
                    ->press('Log In')
                    ->pause(5000)
                    ->assertDontSee('The email field is required.')
                    ->assertDontSee('Please enter with Valid Email Address');
        });
    }

    public function test_should_not_see_password_validation_when_password_is_valid()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->assertSee('Sign In')
                    ->type('email', 'bernandotorrez4@gmail.com')
                    ->type('password', 'B3rnando')
                    ->pause(5000)
                    ->assertDontSee('The password field is required.')
                    ->assertDontSee('Please fill password minimal 6 Characters');
        });
    }

    public function test_should_go_to_home_when_email_and_password_is_correct()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->assertSee('Sign In')
                    ->type('email', 'bernandotorrez4@gmail.com')
                    ->type('password', 'B3rnando')
                    ->press('Log In')
                    ->pause(5000)
                    ->assertPathIs('/home');
        });
    }
    // Positive Test
}
