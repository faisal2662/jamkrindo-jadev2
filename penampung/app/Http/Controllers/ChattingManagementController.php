<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Message;
use App\Models\Percakapan;
use App\Models\Participant;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class ChattingManagementController extends Controller
{

    public function index()
    {
	header("Access-Control-Allow-Origin: *");
        return view('chat-management.index');
    }
    //
    public function createConversation(Request $request)
    {
        $conversation = Percakapan::create([
            'kd_cabang' => $request->cabang_id,
        ]);

        // foreach ($request->user_ids as $user_id) {
        //     Participant::create([
        //         'conversation_id' => $conversation->id,
        //         'user_id' => $user_id,
        //     ]);
        // }
        Participant::create([
            'conversation_id' => $conversation->id,
            'send_id' => $request->cabang_id,
        ]);


        return response()->json($conversation);
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'conversation_id' => 'required|exists:t_percakapan,id',
            'message' => 'required|string|max:1000',
        ]);
 
        $message = Message::create([
            'conversation_id' => $request->conversation_id,
            'send_id' => Auth::user()->kd_user,
            'message' => $request->message,
            'status' => 1,
            'created_date' => date('Y-m-d H:i:s'),
        ]);

        return response()->json($message);
    }

    public function getMessages($conversationId)
    {
        $messages = Message::with(['User', 'customer'])->where('conversation_id', $conversationId)->get();

        return $messages;
        return response()->json($messages);
    }

    public function getConversations()
    {
        $user = Auth::user();
        $conversations = Percakapan::with(['latestMessage', 'customer', 'branch', 'user'])
            ->where('kd_cabang', $user->branch_code)
            ->orderByDesc(
                Message::select('created_date')
                    ->whereColumn('conversation_id', 't_percakapan.id')
                    ->latest()
                    ->take(1)
            )
            ->get();

        return response()->json($conversations);
    }

    public function readMessage(Request $request)
    {
        $messages = Message::where('conversation_id', $request->conversationId)->where('send_id', $request->user_id)->where('is_read', 'FALSE')->get();
        foreach ($messages as $message) {
            $message->update(['is_read' => 'TRUE']);
        }
        return response()->json(['status' => 'success'], 200);
    }

    public function unreadConversation(Request $request)
    {
        // $percakapan = Percakapan::with('message')->where('kd_cabang', $request->cabangId)->get()->where('is_read', 'FALSE');
        $percakapan = Percakapan::with(['latestMessage', 'customer', 'branch'])->whereHas('message', function ($query) {
            $query->where('status', 0)->where('is_read', 'FALSE');
        })->where('kd_cabang', $request->cabangId)->count();

        return response()->json($percakapan);
    }

    public function unreadMessage(Request $request)
    {
        $message = Message::where('conversation_id', $request->conversationId)->where('status', 0)->where('is_read', 'FALSE')->count();

        return response()->json($message);
    }

    public function chatReply(Request $request)
    {
        $user = '';
        $percakapan = Percakapan::where('id', $request->conversationId)->first()->update(['receive_id' => $request->user_id]);
        $percakapan = Percakapan::where('id', $request->conversationId)->first();
        $user = User::where('kd_user', $percakapan->receive_id)->first();
        return response()->json($user);
    }

    public function chatClose(Request $request)
    {
        // return $request;
        $percakapan = Percakapan::where('id', $request->conversationId)->first()->update(['receive_id' => null]);
        return response()->json($percakapan);
    }
    //    public function uploadFile(Request $request)
    // {
    //     if ($request['type'] == 'FILE') {

    //         $filename = uniqid() . '.' . $request['file']->getClientOriginalExtension();
    //         $file  = $request->file('file');
    //         $file->move(base_path('../assets/files'),  $filename);


    //         $message = [
    //             'message' => $filename,
    //             'type_message' => 'FILE'
    //         ];
    //         return response()->json($message);
    //     }
    //     if ($request['type'] == 'IMAGE') {

    //         $filename = uniqid() . '.' . $request['file']->getClientOriginalExtension();
    //         $file  = $request->file('file');
    //         $file->move(base_path('../assets/files'),  $filename);

    //         $message = [
    //             'message' => $filename,
    //             'type_message' => 'IMAGE'
    //         ];


    //         return response()->json($message);
    //     }
    //     if ($request['type'] == 'VIDEO') {

    //         $filename = uniqid() . '.' . $request['file']->getClientOriginalExtension();
    //         $file  = $request->file('file');
    //         $file->move(base_path('../assets/files'),  $filename);

    //         $message = [
    //             'message' => $filename,
    //             'type_message' => 'VIDEO'
    //         ];


    //         return response()->json($message);
    //     }
    // }
    public function checkReceive(Request $request)
    {
        $percakapan = Percakapan::with('user')->where('id', $request->conversationId)->first();

        return response()->json($percakapan);
    }
    
    // js
    public function uploadFile(Request $request)
    {
        if ($request['type'] == 'FILE') {

            $filename = uniqid() . '.' . $request['file']->getClientOriginalExtension();
            $file  = $request->file('file');
            $file->move(base_path('../assets/files'),  $filename);


            $message = Message::create([
                'message' => $filename,
                'type_message' => $request->type,
                'conversation_id' => $request->conversation_id,
                'created_date' => $request->created_date,
                'send_id' => $request->sender_id,
                'status' => $request->status,
                'admin' => $request->admin,
            ]);
            return response()->json($message);
        }
        if ($request['type'] == 'IMAGE') {

            $filename = uniqid() . '.' . $request['file']->getClientOriginalExtension();
            $file  = $request->file('file');
            $file->move(base_path('../assets/files'),  $filename);

            $message = Message::create([
                'message' => $filename,
                'type_message' => $request->type,
                'conversation_id' => $request->conversation_id,
                'created_date' => $request->created_date,
                'send_id' => $request->sender_id,
                'status' => $request->status,
                'admin' => $request->admin,
            ]);

            return response()->json($message);
        }
        if ($request['type'] == 'VIDEO') {

            $filename = uniqid() . '.' . $request['file']->getClientOriginalExtension();
            $file  = $request->file('file');
            $file->move(base_path('../assets/files'),  $filename);

            $message = Message::create([
                'message' => $filename,
                'type_message' => $request->type,
                'conversation_id' => $request->conversation_id,
                'created_date' => $request->created_date,
                'send_id' => $request->sender_id,
                'status' => $request->status,
                'admin' => $request->admin,
            ]);

            return response()->json($message);
        }
    }

    public function fetchMessages(Request $request)
    {

        $percakapanId = Percakapan::where('kd_cabang', $request->cabangId)->pluck('id');
        $percakapanCus = Percakapan::where('kd_cabang', $request->cabangId)->pluck('kd_customer');
        // dd($percakapanCus);
        // $percakapan = Percakapan::where('kd_cabang', $request->cabangId)->pluck('id');

        // Mengambil pesan berdasarkan percakapan yang ada, dan filter waktu kurang dari 5 detik
        $getTImeNow = now()->subSeconds(7);
       
        $messages = Message::with('customer')
            ->whereIn('send_id', $percakapanCus)
            ->whereIn('conversation_id', $percakapanId)  // Mengambil pesan berdasarkan percakapan
            ->where('created_date', '>', $getTImeNow)  // Mendapatkan pesan terbaru dalam 5 detik terakhir
            ->orderBy('created_date', 'desc')
            ->get();


        return response()->json(['messages' => $messages]);
    }

}
