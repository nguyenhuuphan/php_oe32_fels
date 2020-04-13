<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use App\Http\Controllers\UserController;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use App\Models\User;
use Symfony\Component\HttpFoundation\ParameterBag;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\UserRequest;

class UserControllerTest extends TestCase
{
    protected $mockUserRepo;
    protected $controller;
    protected $request;
    protected $user;
    protected $dataRequest;

    protected function setUp() :void
    {
        parent::setUp();

        $this->afterApplicationCreated(function() {
           $this->mockUserRepo = Mockery::mock(UserRepository::class);
        });

        $this->controller = new UserController($this->mockUserRepo);
        $this->request = new UserRequest();
        $this->user = factory(User::class)->make();
        $this->user->id = 1;
        $this->user->role = 1;
        $this->dataRequest = $this->user->toArray();
    }

    protected function tearDown() : void
    {
        parent::tearDown();
    }

    public function test_index_return_view()
    {
        $this->mockUserRepo->shouldReceive('paginate')->once();

        $view = $this->controller->index();

        $this->assertEquals('user.index',$view->getName());
        $this->assertArrayHasKey('users', $view->getData());
    }

    public function test_create_return_view()
    {
        $view = $this->controller->create();
        $this->assertEquals('user.create',$view->getName());
    }

    public function test_store_new_user()
    {
        $this->mockUserRepo->shouldReceive('create')
            ->andReturn($this->user)->once();

        $request = $this->request;
        $request->request->add($this->dataRequest);
        $request->setMethod('POST');
        $redirect = $this->controller->store($request);

        $this->assertInstanceOf(RedirectResponse::class, $redirect);
        $this->assertEquals(302, $redirect->status());
        $this->assertEquals(route('user.index'), $redirect->headers->get('Location'));
        $this->assertEquals($this->user->id, $redirect->getSession()->get('created'));
    }

    public function test_edit_return_view()
    {
        $this->mockUserRepo->shouldReceive('find');

        $view = $this->controller->edit($this->user->id);

        $this->assertEquals('user.edit',$view->getName());
    }

    public function test_update_a_user()
    {
        $this->mockUserRepo->shouldReceive('update', 'find');

        $request = $this->request;
        $request->request->add($this->dataRequest);
        $request->setMethod('PUT');
        $redirect = $this->controller->update($request, $this->user->id);

        $this->assertInstanceOf(RedirectResponse::class, $redirect);
        $this->assertEquals(302, $redirect->status());
        $this->assertEquals($this->user->id, $redirect->getSession()->get('updated'));
    }

    public function test_show_a_user()
    {
        $this->mockUserRepo->shouldReceive('find');

        $view = $this->controller->show($this->user->id);

        $this->assertEquals('user.show', $view->getName());
        $this->assertArrayHasKey('user', $view->getData());
    }

    public function test_destroy_a_user()
    {
        $this->mockUserRepo->shouldReceive('find', 'delete')
        ->andReturn($this->user)->once();
        $redirect = $this->controller->destroy($this->user->id);

        $this->assertInstanceOf(RedirectResponse::class, $redirect);
        $this->assertEquals(route('user.index'), $redirect->headers->get('Location'));
        $this->assertEquals(302, $redirect->status());
    }

    public function test_user_choose_course()
    {
        $user = $this->user;
        $request = $this->request;
        $request->setUserResolver(function () use ($user) {
            return $user;
        });

        $redirect = $this->controller->chooseCourse($request, 1);

        $this->assertInstanceOf(RedirectResponse::class, $redirect);
        $this->assertEquals(route('course.show', 1), $redirect->headers->get('Location'));
        $this->assertEquals(302, $redirect->status());
        $this->assertEquals(1, $redirect->getSession()->get('chooseSuccess'));
    }
}
