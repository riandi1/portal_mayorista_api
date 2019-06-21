<?php

namespace App\Http\Controllers;

use App\Models\System\Parameter;
use Spatie\Permission\Models\Role;
use App\Models\System\User;
use App\Notifications\UserNotification;
use App\Notifications\WelcomeNotification;
use Auth;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Spatie\Permission\Exceptions\UnauthorizedException;


class UserController extends Controller
{

    public function __construct()
    {
        parent::__construct(User::class);
    }

    /**
     * Create new user on system
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Throwable
     */
    public function store(Request $request)
    {
        $default_password = Parameter::byCode('USER_DEFAULT_PASSWORD');
        if (!$default_password)
            $default_password = '123456';
        $password = $request->get('password', $default_password);
        $request->merge(['password' => bcrypt($password)]);
        $response = parent::store($request);
        /*$data = $response->getData(true);
        if ($data["status"] == "success") {
            $user = User::find($data["data"]["id"]);
            if (!!$user) {
                $names = $request->get('roles', []);
                $this->sync_roles($user, $names);
                $user->notify(new WelcomeNotification($password));
            }
        }*/
        return $response;
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function updateImage(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $image = $request->image;
        if ($image instanceof UploadedFile) {
            if (!check_file_format($image, ['regex:/.*\.(jpe?g|png|gif|svg)/']))
                return jsend_error(trans('messages.request.errors.invalid-format'));
            $path = save_file($image, "image-profile");
            if ($path) {
                $user->fill(["image" => $path]);
                $user->saveOrFail();
                return jsend_success(trans('messages.request.process_success'));
            }
        }
        return jsend_error(trans('messages.request.errors.bad'), 400);
    }

    /**
     * Edit an user
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function update(Request $request, $id)
    {

        $user_target = User::findOrFail($id);


        if ($user_target->id !== Auth::id())
            check_required_lvl(get_user_lvl($user_target));
        if ($request->has('password'))
            $request->merge(['password' => bcrypt($request->get('password'))]);

        $response = parent::update($request, $id);

        $data = $response->getData(true);
        /* Error  update rol*/
       /* if ($data["status"] == "success" && $request->has('roles')) {

            $names = $request->get('roles', []);
            $this->sync_roles($user_target, $names);
        }*/
        return $response;
    }

    public function destroy(Request $request, $id)
    {
        $user_target = User::findOrFail($id);
        check_required_lvl(get_user_lvl($user_target));

        return parent::destroy($request, $id);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws Exception
     */
    public function updateRoles(Request $request, $id)
    {

        $names = $request->get('roles', []);
        if (!$names)
            throw new Exception(trans("messages.request.errors.bad"), 404);

        /** @var User $user_target */
        $user_target = User::findOrFail($id);
        $this->sync_roles($user_target, $names, true);
        return jsend_success($user_target, 200, trans("messages.request.update", ["module" => "Roles"]));
    }

    /**
     * @param User $user_target
     * @param string[] $role_names
     * @param bool $throw
     */
    public function sync_roles($user_target, $role_names, $throw = false)
    {
        try {
            check_permission("ROLE_ASSIGN");
        } catch (UnauthorizedException $e) {
            if ($throw)
                throw $e;
            else
                return;
        }

        check_required_lvl(get_user_lvl($user_target), !$throw);
        $roles = Role::query()->whereIn('name', $role_names)->get();
        foreach ($roles as $role)
            check_required_lvl($role->level, !$throw);
        $user_target->syncRoles($role_names);
    }

    /**
     * @param Request $request
     * @param $user_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function message(Request $request, $user_id)
    {
        if ($request->has('message')) {
            $message = $request->get('message');
            $user = User::findOrFail($user_id);
            $user->notify(new UserNotification($message));
            return jsend_success(null, 202, 'Message sent successfully');
        }
        return jsend_error("Message is required");
    }
}
