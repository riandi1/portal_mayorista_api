<?php

namespace App\Http\Controllers;

use App\Models\System\TagAssignment;
use Auth;
use Spatie\Permission\Exceptions\UnauthorizedException;

class TagAssignmentController extends Controller
{

    public function __construct()
    {
        parent::__construct(TagAssignment::class);
    }

    public function validate_lvl($record_id, $boolean_return = false)
    {
        $record = TagAssignment::with(TagAssignment::$_relations)->findOrFail($record_id);
        $user_lvl = get_user_lvl(Auth::user());
        $required_lvl = $record->tag['required_lvl'];
        if ($user_lvl > $required_lvl) {
            if ($boolean_return)
                return false;
            throw new UnauthorizedException(403, trans("messages.acl.errors.level", [
                'lvl' => $user_lvl,
                'req' => $required_lvl
            ]));
        }
        return true;
    }
}
