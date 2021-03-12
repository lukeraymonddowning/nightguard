<?php


namespace Lukeraymonddowning\Nightguard\Tests;


use Illuminate\Support\Facades\Auth;
use Lukeraymonddowning\Nightguard\Facades\Nightguard;

class DatabaseLoginTest extends TestCase
{
    /** @test */
    public function the_full_auth_check_process_works()
    {
        Nightguard::create(\App\Models\Administrator::class, 'admin');

        (new \App\Models\Administrator(
            ['email' => 'foo@bar.com', 'password' => \Hash::make('password'), 'name' => 'Bob']
        ))->save();

        expect(Auth::guard('admin')->attempt(['email' => 'foo@bar.com', 'password' => 'password']))->toBeTrue();
    }

}
