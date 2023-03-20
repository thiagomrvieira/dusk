<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AuthTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_user_can_register_correctly()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                ->type('name', 'User')
                ->type('email', 'user02@user.com')
                ->type('password', 'password')
                ->type('password_confirmation', 'password')
                ->click('button[type="submit"]')
                ->assertSee("You're logged in!")
                ->clickLink('User', 'button')
                ->clickLink('Log Out')
                ->assertSee("Laracasts");
        });
    }

    /** @test */
    public function a_user_can_login_correctly()
    {
        User::create([
            'name' => 'User',
            'email' => 'user@user.com',
            'password' => bcrypt('password')
        ]);

        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->clickLink('Log in', 'a')
                ->type('email', 'user@user.com')
                ->type('password', 'password')
                ->click('button[type="submit"]')
                ->assertSee("You're logged in!");
        });
    }
}
