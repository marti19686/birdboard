<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\TestCase;
use Illuminate\Database\Eloquent\Collection;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
    @test
     */
    public function has_projects()
    {
        $user = factory('\App\User::class')->create();

        $this->assertInstanceOf(Collection::class, $user->projects);

    }
}
