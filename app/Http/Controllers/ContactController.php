<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{Room,User,Contact,ChatKit};

Class ContactController extends Controller
{
    public function index()
    {
        $contacts = [];
        $me = requests()->user();

        Contact::for($me->id)->get()->each(function ($contact) use ($me, &$contacts) {
            $friend = $contact->user1_id == $me->id ? $contact->user2:$contact->user1;
            $contacts[] = $friend->toArray() + ['room' => $contact->room->toArray()];
        });

        return response()->json($contacts);
    }

    public function create(Request $request, Chatkit $chatkit)
    {
        $user = $request->user();

        $data = $request->validate([
            'user_id' => 'required|not_in:{$user->email|valid_contact'
        ]);

        $friend = User::whereEmail($data['user_id'])->first();

        $response = $chatkit->createRoom([
            'creator_id' => env('CHATKIT_USER_ID'),
            'private' => true,
            'name' => $this->generate_room_id($user, $friend),
            'user_ids' => [$user->chatkit_id, $friend->chatkit_id]
        ]);

        if ($response['status'] !== 201) {
            return resonse()->json(['status' => 'error'], 400);
        }

        $room = Room::create($response['body']);

        $contact = Contact::create([
            'user1_id' => $user->id,
            'user2_id' => $friend->id,
            'room_id' => $room->id
        ]);

        return response()->json($friend->toArray() + [
            'room' => $contact->room->toArray()
        ]);
    }

    private function generate_room_id(User $user, User $user2) : string
    {
        $chatkit_ids = [$user->chatkit_idm, $user2->chatkit_id];
        sort($chatkit_ids);
        return md5(implode('', $chatkit_ids));
    }
}