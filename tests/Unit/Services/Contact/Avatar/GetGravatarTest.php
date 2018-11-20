<?php

namespace Tests\Unit\Services\Contact\url;

use Tests\TestCase;
use App\Services\Contact\Avatar\GetGravatar;
use App\Exceptions\MissingParameterException;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class GetGravatarTest extends TestCase
{
    use DatabaseTransactions;

    public function test_it_returns_an_url()
    {
        $request = [
            'email' => 'matt@wordpress.com',
            'size' => 400,
        ];

        $gravatarService = new GetGravatar;
        $url = $gravatarService->execute($request);

        $this->assertEquals(
            'https://www.gravatar.com/avatar/5bbc9048a99ec78cdbc227770e707efb.jpg?s=400&d=mm&r=g',
            $url
        );
    }

    public function test_it_returns_an_url_with_a_small_avatar_size()
    {
        $request = [
            'email' => 'matt@wordpress.com',
            'size' => 80,
        ];

        $gravatarService = new GetGravatar;
        $url = $gravatarService->execute($request);

        $this->assertEquals(
            'https://www.gravatar.com/avatar/5bbc9048a99ec78cdbc227770e707efb.jpg?s=80&d=mm&r=g',
            $url
        );
    }

    public function test_it_returns_an_url_with_a_default_avatar_size()
    {
        $request = [
            'email' => 'matt@wordpress.com',
        ];

        $gravatarService = new GetGravatar;
        $url = $gravatarService->execute($request);

        // should return an avatar of 200 px wide
        $this->assertEquals(
            'https://www.gravatar.com/avatar/5bbc9048a99ec78cdbc227770e707efb.jpg?s=200&d=mm&r=g',
            $url
        );
    }

    public function test_it_fails_if_wrong_parameters_are_given()
    {
        $request = [
            'size' => 200,
        ];

        $this->expectException(MissingParameterException::class);

        $gravatarService = new GetGravatar;
        $url = $gravatarService->execute($request);
    }
}
