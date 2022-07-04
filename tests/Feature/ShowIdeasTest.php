<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Idea;
use App\Models\Category;

class ShowIdeasTest extends TestCase
{
   use RefreshDatabase;

   /** @test */
    public function list_of_ideas_shows_on_main_page()
    {
        $categoryOne = Category::factory()->create(['name' => 'Category 1']);
        $categoryTwo = Category::factory()->create(['name' => 'Category 2']);

        $ideaOne = Idea::factory()->create([
            'title'     => 'My First Idea',
            'category_id'   => $categoryOne->id,
            'description' => 'Description of my first idea',
        ]);

        $ideaTwo = Idea::factory()->create([
            'title'     => 'My Second Idea',
            'category_id'   => $categoryTwo->id,
            'description' => 'Description of my second idea',
        ]);

        $response = $this->get(route('idea.index'));

        $response->assertSuccessful();
        $response->assertSee($ideaOne->title);
        $response->assertSee($ideaOne->description);
        $response->assertSee($categoryOne->name);
        $response->assertSee($ideaTwo->title);
        $response->assertSee($ideaTwo->description);
        $response->assertSee($categoryTwo->name);
    }

    /** @test */
    public function single_idea_shows_correctly_on_the_show_page()
    {
        $categoryOne = Category::factory()->create(['name' => 'Category 1']);

        $idea = Idea::factory()->create([
            'category_id'   => $categoryOne->id,
            'title'     => 'My First Idea',
            'description' => 'Description of my first idea',
        ]);


        $response = $this->get(route('idea.show', $idea));

        $response->assertSuccessful();
        $response->assertSee($idea->title);
        $response->assertSee($idea->description);
        $response->assertSee($categoryOne->name);
        
    }

    /** @test */
    public function ideas_pagination_works()
    {
        // Idea::factory(Idea::PAGINATION_COUNT + 1)->create();
        $categoryOne = Category::factory()->create(['name' => 'Category 1']);

        Idea::factory(Idea::PAGINATION_COUNT + 1)->create([
            'category_id' => $categoryOne->id,
        ]);

        $ideaOne = Idea::find(1);
        $ideaOne->title = 'My First Idea';
        $ideaOne->save();

        $ideaSixth = Idea::find(6);
        $ideaSixth->title = 'My Sixth Idea';
        $ideaSixth->save();

        $response = $this->get('/');

        $response->assertSee($ideaOne->title);
        $response->assertDontSee($ideaSixth->title);

        $response = $this->get('/?page=2');

        $response->assertDontSee($ideaOne->title);
        $response->assertSee($ideaSixth->title);

    }

    /** @test  */
    public function same_idea_title_different_slugs()
    {
        $categoryOne = Category::factory()->create(['name' => 'Category 1']);

        $ideaOne = Idea::factory()->create([
            'category_id'  => $categoryOne->id,
            'title' => 'My First Idea',
            'description' => 'Description for my first idea',
        ]);

        $ideaTwo = Idea::factory()->create([
            'category_id'  => $categoryOne->id,
            'title' => 'My First Idea',
            'description' => 'Description for my first idea',
        ]);

        $response = $this->get(route('idea.show', $ideaOne));

        $response->assertSuccessful();
        $this->assertTrue(request()->path() === 'ideas/my-first-idea');

        $response = $this->get(route('idea.show', $ideaTwo));

        $response->assertSuccessful();
        $this->assertTrue(request()->path() === 'ideas/my-first-idea-2');


    }
}
