<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Laravel\Airlock\Airlock;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_authenicated_user_can_get_its_own_data()
    {
        $user = Airlock::actingAs(
            factory(User::class)->create(),
            ['user:show']
        );

        $response = $this->getJson("/api/users/{$user->id}");

        $response->assertOk();
    }

    /** @test */
    public function an_authenicated_user_can_not_get_other_user()
    {
        Airlock::actingAs(
            factory(User::class)->create(),
            ['user:show']
        );

        $otherUser = factory(User::class)->create();

        $this->getJson("/api/users/{$otherUser->id}")
            ->assertForbidden();
    }

    /** @test */
    public function a_guest_user_can_not_get_its_own_data()
    {
        $this->getJson("/api/users/1")
            ->assertUnauthorized();
    }

     /** @test */
    public function an_authenicated_user_who_has_right_ability_can_update_its_own_data()
    {
        $user = Airlock::actingAs(
            factory(User::class)->create(),
            ['user:update']
        );

        $this->patchJson("/api/users/{$user->id}", ['name' => 'Change User Name'])
            ->assertOk();
    }

    /** @test */
    public function an_authenicated_user_can_not_update_other_user()
    {
        Airlock::actingAs(
            factory(User::class)->create(),
            ['user:update']
        );

        $otherUser = factory(User::class)->create();

        $this->patchJson("/api/users/{$otherUser->id}")
            ->assertForbidden();
    }

    /** @test */
    public function a_guest_user_can_not_update_its_own_data()
    {
        $this->patchJson("/api/users/1")
            ->assertUnauthorized();
    }

    /** @test */
    public function an_authenicated_user_who_has_right_ability_can_delete_its_own_data()
    {
        $user = Airlock::actingAs(
            factory(User::class)->create(),
            ['user:delete']
        );

        $this->deleteJson("/api/users/{$user->id}")
            ->assertOk();
    }

    /** @test */
    public function an_authenicated_user_can_not_delete_other_user()
    {
        Airlock::actingAs(
            factory(User::class)->create(),
            ['user:delete']
        );

        $otherUser = factory(User::class)->create();

        $this->deleteJson("/api/users/{$otherUser->id}")
            ->assertForbidden();
    }

    /** @test */
    public function a_guest_user_can_not_delete_its_own_data()
    {
        $this->deleteJson("/api/users/1")
            ->assertUnauthorized();
    }
}
