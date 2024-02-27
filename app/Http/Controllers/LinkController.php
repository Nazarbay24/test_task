<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class LinkController extends Controller
{
    public function createLink(Request $request)
    {
        $request->validate([
            "link" => "required",
            "token" => "nullable",
            "private_status" => "nullable|boolean"
        ]);

        $user = auth()->user();
        $linkToken = $request->token ?: random_int(10000, 99999);
        $privateStatus = $request->private_status ? 1 : 0;


        $link = Link::where("user_id", "=", $user->id)
            ->where("token", "=", $linkToken)
            ->first();

        if ($link) {
            return response()->json([
                "message" => __('Ссылка с таким токеном уже существует')
            ], 400);
        }


        $user->links()->create([
            "link" => $request->link,
            "token" => $linkToken,
            "private_status" => $privateStatus
        ]);

        return response()->json([
            "link_token" => $linkToken
        ]);
    }


    public function userLinks()
    {
        $links = auth()->user()->links;

        return response()->json([
            "links" => $links
        ]);
    }


    public function goLink($username, $token)
    {
        $user = User::where("username", "=", $username)->firstOrFail();
        $link = Link::where("user_id", "=", $user->id)
            ->where("token", "=", $token)
            ->where("private_status", "=", 0)
            ->firstOrFail();

        return Redirect::away($link->link);
    }
}
