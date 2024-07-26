<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GraphMailer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class GraphMailerController extends Controller
{
    protected $mailer;

    public function __construct(GraphMailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function fetchMessages()
    {
        
        $messages = $this->mailer->getMessages('tms@genashtim.com');
        dd($messages );
        return response()->json($messages);
        // return $this->mailer->getMessages('tms@genashtim.com');
    }

    public function getAvatarImage($email){
        
        try {
            $imageData = $this->mailer->getAvatarImage($email);
            $imageName = emailToFileName($email).".jpg";
            $filePath = "public/images/avatars/" . $imageName;
            Storage::disk('local')->put($filePath, $imageData);
            $avatar = 'storage/images/avatars/' . $imageName;
            return response()->json(['message' => 'Image downloaded', 'imageUrl' => $avatar], 201);
            // echo $imageUrl;
        } catch (\Exception $e) {
            return response()->json(['message' => 'No Image found'], 404);
            // echo $e->getMessage();
        }
    }
    public function test(){
        echo "<div style='background-color: #ffffff; color: #000000;'>";
            echo "  <pre>";
            print_r( Auth::user() );
            echo "  </pre>";
            echo "</div>";
            logActivity('create',null,'test');
    }
}
