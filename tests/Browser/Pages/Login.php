<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;

class Login extends Page
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/login';
    }

    /**
     * Assert that the browser is on the page.
     *
     * @param  Browser  $browser
     * @return void
     */
    public function assert(Browser $browser)
    {
        $browser->assertPathIs($this->url());
    }

    /**
     * Get the element shortcuts for the page.
     *
     * @return array
     */
    public function elements()
    {
        return [
            '@email' => '#email',
            '@password' => '#password'
        ];
    }

    public function pressLoginAndSeeEmailRequired(Browser $browser)
    {
        $browser->press('Log In')
                ->waitForText('The email field is required.')
                ->assertSee('The email field is required.');
    }

    public function pressLoginAndSeeEmailNotValid(Browser $browser)
    {
        $browser->press('Log In')
                ->waitForText('Please enter with Valid Email Address')
                ->assertSee('Please enter with Valid Email Address');
    }

    public function pressLoginAndSeePasswordRequired(Browser $browser)
    {
        $browser->press('Log In')
                ->waitForText('The password field is required.')
                ->assertSee('The password field is required.');
    }

    public function pressLoginAndSeePasswordLessThenGivenCharacters(Browser $browser)
    {
        $browser->press('Log In')
                ->waitForText('Please fill password minimal 6 Characters')
                ->assertSee('Please fill password minimal 6 Characters');
    }

    public function pressLoginAndSeeWrongCredential(Browser $browser)
    {
        $browser->press('Log In')
                ->waitForText('Email or Password is Wrong!')
                ->assertSee('Email or Password is Wrong!');
    }

    public function pressLoginAndDontSeeEmailValidation(Browser $browser)
    {
        $browser->press('Log In')
        ->pause(5000)
        ->assertDontSee('The email field is required.')
        ->assertDontSee('Please enter with Valid Email Address');
    }

    public function pressLoginAndDontSeePasswordValidation(Browser $browser)
    {
        $browser->pause(5000)
        ->assertDontSee('The password field is required.')
        ->assertDontSee('Please fill password minimal 6 Characters');
    }

    
}
