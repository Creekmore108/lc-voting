<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test  */
    public function user_can_generate_gravatar_default_image_when_no_email_found_first_character_a(){
        $user = User::factory()->create([
            'name'  => 'Andre',
            'email' => 'afakeemail@fakeemail.com',
        ]);

        $gravatarUrl = $user->getAvatar();

        // dd($gravatarUrl);

        $this->assertEquals(
            'https://www.gravatar.com/avatar/'.md5($user->email).'?2=200&d=https://s3.amazonaws.com/laracasts/images/forum/avatars/default-avatar-1.png',
            $gravatarUrl
        );
    }

    /** @test  */
    public function user_can_generate_gravatar_default_image_when_no_email_found_first_character_z(){
        $user = User::factory()->create([
            'name'  => 'Andre',
            'email' => 'zfakeemail@fakeemail.com',
        ]);

        $gravatarUrl = $user->getAvatar();

        // dd($gravatarUrl);

        $this->assertEquals(
            'https://www.gravatar.com/avatar/'.md5($user->email).'?2=200&d=https://s3.amazonaws.com/laracasts/images/forum/avatars/default-avatar-26.png',
            $gravatarUrl
        );
    }

    /** @test  */
    public function user_can_generate_gravatar_default_image_when_no_email_found_first_character_0(){
        $user = User::factory()->create([
            'name'  => 'Andre',
            'email' => '0fakeemail@fakeemail.com',
        ]);

        $gravatarUrl = $user->getAvatar();

        // dd($gravatarUrl);

        $this->assertEquals(
            'https://www.gravatar.com/avatar/'.md5($user->email).'?2=200&d=https://s3.amazonaws.com/laracasts/images/forum/avatars/default-avatar-27.png',
            $gravatarUrl
        );
    }

    /** @test  */
    public function user_can_generate_gravatar_default_image_when_no_email_found_first_character_9(){
        $user = User::factory()->create([
            'name'  => 'Andre',
            'email' => '9fakeemail@fakeemail.com',
        ]);

        $gravatarUrl = $user->getAvatar();

        // dd($gravatarUrl);

        $this->assertEquals(
            'https://www.gravatar.com/avatar/'.md5($user->email).'?2=200&d=https://s3.amazonaws.com/laracasts/images/forum/avatars/default-avatar-36.png',
            $gravatarUrl
        );
    }
}
