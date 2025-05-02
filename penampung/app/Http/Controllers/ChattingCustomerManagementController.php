<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Branch;
use App\Models\Message;
use App\Models\Regional;
use App\Models\Percakapan;
use App\Models\Participant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChattingCustomerManagementController extends Controller
{
    //

    public function index()
    {
        $branch = Branch::where('id_cabang', Auth::user()->kd_cabang)->first();
        $regions = Regional::where('id_kanwil', $branch->kd_wilayah)->first();
        $percakapan = Percakapan::where('kd_customer', Auth::user()->kd_customer)->first();
        $getBranch = Branch::where('is_delete', 'N')->get();

        // dd($percakapan);

        return view('customer-chat.index', compact('regions', 'branch', 'percakapan', 'getBranch'));
    }
    public function createConversation(Request $request)
    {

        $wilayah = Branch::with('wilayah')->where('kd_cabang', $request->cabang_id)->first();

        $conversation = Percakapan::create([
            'kd_cabang' => $request->cabang_id,
            'kd_wilayah' => $wilayah->wilayah->kd_wilayah,
            'kd_customer' => Auth::user()->kd_customer,
            'created_by' => Auth::user()->nama_customer,
            'created_date' => date('Y-m-d H:i:s')
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
            'created_by' => Auth::user()->nama_customer,
            'created_date' => date('Y-m-d H:i:s')

        ]);


        return response()->json($conversation);
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'conversation_id' => 'required',
            'message' => 'required|string|max:1000',
        ]);

        $message = Message::create([
            'conversation_id' => $request->conversation_id,
            'send_id' => Auth::user()->kd_customer,
            'message' => $request->message,
            'created_date' => $request->created_date,
            'type_message' => $request->type,
        ]);

        return response()->json($message);
    }

    public function getMessages($conversationId)
    {
        $messages = Message::with(['user.cabang'])->where('conversation_id', $conversationId)->get();

        return $messages;
        return response()->json($messages);
    }

    public function getConversations()
    {
        $user = Auth::user();
        $conversations = Percakapan::with(['latestMessage', 'customer', 'branch', 'user'])
            ->where('kd_customer', $user->kd_customer)
            ->orderByDesc(
                Message::select('created_date')
                    ->whereColumn('conversation_id', 't_percakapan.id')
                    ->latest()
                    ->take(1)
            )
            ->get();

        return response()->json($conversations);
    }

    // public function getConversations()
    // {
    //     $user = Auth::user();
    //     $conversations = Percakapan::where('kd_customer', $user->kd_customer)->get();

    //     return response()->json($conversations);
    // }

    public function readMessage(Request $request)
    {
        $messages = Message::where('conversation_id', $request->conversationId)->where('send_id', $request->user_id)->where('is_read', 'FALSE')->get();
        foreach ($messages as $message) {
            $message->update(['is_read' => 'TRUE']);
        }
        return response()->json(['status' => 'success'], 200);
    }

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
                'send_id' => $request->sender_id
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
                'send_id' => $request->sender_id
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
                'send_id' => $request->sender_id
            ]);
            return response()->json($message);
        }
    }
    public function checkReceive(Request $request)
    {
        $date = Carbon::now();
        $percakapan = Percakapan::where('kd_customer', $request->user_id)->first('receive_id');


        $result = false;
        if (is_null($percakapan->receive_id)) {
            $message = Message::create([
                'conversation_id' => $request->conversation_id,
                'message' => $request->message,
                'type_message' => 'TEXT',
                'status' => 1,
                'created_date' => $date,
                'send_id' => 0,
            ]);
            $result = true;
        }

        return response()->json($result);
    }



    public function fetchMessages(Request $request)
    {
        // // Header SSE
        // header('Content-Type: text/event-stream');
        // header('Cache-Control: no-cache');
        // header('Connection: keep-alive');

        // // Loop untuk mengirimkan pesan secara real-time
        // while (true) {
        //     $lastEventId = $request->header('Last-Event-ID', 0);
        //     // dd(Carbon::now()->subSecond(5));

        //     // // Ambil pesan baru berdasarkan ID terakhir
        //     // $messages = Chat::where('id', '>', $lastEventId)
        //     //     ->orderBy('created_at', 'asc')
        //     //     ->get();

        //     foreach ($messages as $message) {
        //         echo "id: {$message->id}\n";
        //         echo "event: message\n";
        //         echo "data: " . json_encode($message) . "\n\n";
        //         ob_flush();
        //         flush();
        //     }

        //     // Tunda sejenak untuk mengurangi beban server
        //     sleep(2);
        // }
        $percakapanId = Percakapan::where('kd_customer', $request->userId)->pluck('id');
        // $percakapanCus = Percakapan::where('kd_cabang', $request->cabangId)->pluck('kd_customer');
        // dd($percakapan->receive_id);
        $messages = Message::with('user')->whereIn('conversation_id', $percakapanId)->where('created_date', '>', now()->subSecond(7)) // Mendapatkan pesan terbaru
            ->orderBy('created_date', 'asc')
            ->get();
        return response()->json(['messages' => $messages]);
    }

    public function warningMessages(Request $request)
    {
        // dd(Carbon::now()->subSecond(5));
        $percakapan = Percakapan::where('kd_customer', $request->userId)->first('receive_id');
        // dd($percakapan->receive_id);
        $messages = Message::with('user')->where('conversation_id', $request->conversationId)->where('send_id', $percakapan->receive_id)->where('created_date', '>', carbon::now()->subMinutes(5)) // Mendapatkan pesan terbaru
            ->orderBy('created_date', 'asc')
            ->get();

        return response()->json(['messages' => $messages]);
    }

    public function checkConversation(Request $request)
    {

        $percakapan = Percakapan::where(['kd_customer' => $request->user_id, 'kd_cabang' => $request->cabangId])->first();
        if ($percakapan) {
            return response()->json($percakapan);
        } else {
            $wilayah = Branch::where('id_cabang', $request->cabangId)->first();


            $conversation = Percakapan::create([
                'kd_cabang' => $request->cabangId,
                'kd_wilayah' => $wilayah->kd_wilayah,
                'kd_customer' => Auth::user()->kd_customer,
                'created_by' => Auth::user()->nama_customer
            ]);

            // foreach ($request->user_ids as $user_id) {
            //     Participant::create([
            //         'conversation_id' => $conversation->id,
            //         'user_id' => $user_id,
            //     ]);
            // }
            Participant::create([
                'conversation_id' => $conversation->id,
                'send_id' => $request->user_id,
                'created_by' => Auth::user()->nama_customer

            ]);
            return response()->json($conversation);
        }
    }
}
