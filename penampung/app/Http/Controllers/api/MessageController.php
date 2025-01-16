<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Events\ConversationChatSentEvent;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;

use Auth;
use App\Models\Message;
use App\Models\Percakapan;

class MessageController extends Controller
{
    public function getMessages()
    {
        $customer = Auth::user();

        $messages = Message::with('User')
            ->whereHas('Chat', function ($query) use ($customer) {
                $query->where([
                    'kd_customer' => $customer->kd_customer,
                    'is_delete' => 'N'
                ]);
            })
            ->where('is_delete', 'N')
            ->get()
            ->map(function ($item) {
                if ($item->type_message != "TEXT") {
                    $item->message = url('assets/files/'.$item->message);
                }
                return $item;
            });

        return response()->json([
            'data' => $messages
        ]);
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'nullable|string',
            'file' => 'nullable|file|max:10240'
        ]);

        if (is_null($request->message) && is_null($request->file)) {
            return response()->json([
                'message' => 'Message or File is required'
            ], 400);
        }

        $customer = Auth::user();
        
        $conversation = Percakapan::where([
                'kd_customer' => $customer->kd_customer,
                'kd_cabang' => $customer->kd_cabang,
                'is_delete' => 'N'
            ])
            ->first();

        if (is_null($conversation)) {
            $conversation = Percakapan::create([
                'kd_customer' => $customer->kd_customer,
                'kd_cabang' => $customer->kd_cabang
            ]);
        }

        $message = $request->message;
        $typeMessage = "TEXT";

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $ext = $file->getClientOriginalExtension();
            $name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME).'-'.uniqid();
            $filename = $name.'.'.$ext;
            $file->move(base_path('../assets/files'),  $filename);
            $message = $filename;
            $imageExt = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg'];
            $videoExt = ['webm', 'mkv', 'flv', 'avi', 'mov', 'wmv', 'amv', 'mp4', '3gp'];
            $isImage = in_array(strtolower($ext), $imageExt);
            $isVideo = in_array(strtolower($ext), $videoExt);
            $typeMessage = ($isImage ? "IMAGE" : $isVideo) ? "VIDEO" : "FILE";
            // if ($isVideo) {
            //     $ffmpeg = \FFMpeg\FFMpeg::create();
            //     $video = $ffmpeg->open(base_path('../assets/files')."/".$filename);
            //     $frame = $video->frame(FFMpeg\Coordinate\TimeCode::fromSeconds(0));
            //     $frame->save($name.".jpg");
            // }
        }
        
        $createdDate = date('Y-m-d H:i:s');
        if (!is_null($request->created_date)) {
            $createdDate = date('Y-m-d H:i:s', strtotime($request->created_date));
        }

        $createdMessage = Message::create([
            'conversation_id' => $conversation->id,
            'send_id' => "$customer->kd_customer",
            'message' => $message,
            'type_message' => $typeMessage,
            'status' => 0,
            'created_date' => $createdDate
        ]);

        $createdMessage['message'] = $typeMessage == "TEXT" ? $message : url('assets/files/'.$message);
        
        broadcast(new ConversationChatSentEvent(auth()->user(), $createdMessage))->toOthers();

        return response()->json([
            'data' => $createdMessage
        ], 201);
    }

    public function sendFirebaseMessaging($data, $deviceTokens)
    {
        // $data = [
        //     'notification' => [
        //         'title' => 'Hello',
        //         'body' => 'World',
        //     ],
        //     'data' => [
        //         'key' => 'value',
        //         'hello' => 'world',
        //     ],
        // ];
        // $deviceTokens = ['...'];
        $factory = (new Factory)->withServiceAccount(__DIR__.'/../../../../jade-jamkrindo-69b5962f8fff.json');
        $messaging = $factory->createMessaging();
        $message = CloudMessage::fromArray($data);
        $report = $messaging->sendMulticast($message, $deviceTokens);
    }
}
