<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Message;
use App\Models\Percakapan;
use App\Models\Participant;
use App\Models\Regional;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Events\ConversationChatSentEvent;

class ChattingCustomerManagementController extends Controller
{
    //
    public function index()
    {
        $branch = Branch::where('id_cabang', Auth::user()->kd_cabang)->first();
        $regions = Regional::where('id_kanwil', $branch->kd_wilayah)->first();
        $percakapan = Percakapan::where('kd_customer', Auth::user()->kd_customer)->first();

        // dd($percakapan); 

        return view('customer-chat.index', compact('regions', 'branch', 'percakapan'));
    }


    public function createConversation(Request $request)
    {

        $wilayah = Branch::with('wilayah')->where('id_cabang', $request->cabang_id)->first();
 
        $conversation = Percakapan::create([
            'kd_cabang' => $request->cabang_id,
            'kd_wilayah' => $wilayah->wilayah->id_kanwil,
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
            'send_id' => $request->cabang_id, 'created_by' => Auth::user()->nama_customer

        ]);


        return response()->json($conversation);
    }

    public function sendMessage(Request $request)
    {
        
       if($request['type'] == 'FILE'){
            
          $filename = uniqid() . '.' . $request['file']->getClientOriginalExtension();
                $file  = $request->file('file');
                $file->move(base_path('../assets/files'),  $filename);
                // $product->images_produk = $filename;
                $createdMessage = Message::create([
                    'conversation_id' => $request->conversation_id,
                    'send_id' => Auth::id(),
                    'type_message' => 'FILE',
                    'message' => $filename,
                    'created_date' => $request->created_date,
          
                ]);

        $message = Message::with('User', 'Customer')->findOrFail($createdMessage->id);

        broadcast(new ConversationChatSentEvent(auth()->user(), $message))->toOthers();

        return response()->json($message);
        }
        if($request['type'] == 'IMAGE'){
            
          $filename = uniqid() . '.' . $request['file']->getClientOriginalExtension();
                $file  = $request->file('file');
                $file->move(base_path('../assets/files'),  $filename);
                // $product->images_produk = $filename;
                $createdMessage = Message::create([
                    'conversation_id' => $request->conversation_id,
                    'send_id' => Auth::id(),
                    'type_message' => 'IMAGE',
                    'message' => $filename,
                    'created_date' => $request->created_date,
         
                ]);

        $message = Message::with('User', 'Customer')->findOrFail($createdMessage->id);

        broadcast(new ConversationChatSentEvent(auth()->user(), $message))->toOthers();

        return response()->json($message);
        }
        if($request['type'] == 'VIDEO'){
            
          $filename = uniqid() . '.' . $request['file']->getClientOriginalExtension();
                $file  = $request->file('file');
                $file->move(base_path('../assets/files'),  $filename);
                // $product->images_produk = $filename;
                $createdMessage = Message::create([
                    'conversation_id' => $request->conversation_id,
                    'send_id' => Auth::id(),
                    'type_message' => 'VIDEO',
                    'message' => $filename,
                    'created_date' => $request->created_date,
                 
                ]);

        $message = Message::with('User', 'Customer')->findOrFail($createdMessage->id);

        broadcast(new ConversationChatSentEvent(auth()->user(), $message))->toOthers();

        return response()->json($message);
        }
        $request->validate([
            'conversation_id' => 'required',
            'message' => 'required|string|max:1000',
        ]);

        $createdMessage = Message::create([
            'conversation_id' => $request->conversation_id,
            'send_id' => Auth::user()->kd_customer,
            'message' => $request->message,
            'created_date' => $request->created_date,
        ]);

        $message = Message::with('Customer', 'User')->findOrFail($createdMessage->id);

        broadcast(new ConversationChatSentEvent(auth()->user(), $message))->toOthers();

        return response()->json($message);
    }

        public function getMessages($conversationId)
    {
        $messages = Message::with(['customer', 'user'])->where('conversation_id', $conversationId)->get();
  return response()->json($messages);
        // return view('chat-management.message', compact('conversationId', 'messages'));
    }

     public function getConversations()
    {
        $user = Auth::user();
        $conversations = Percakapan::where('kd_cabang', $user->kd_cabang)->get();

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
}