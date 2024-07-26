<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Employee;
use App\Services\GraphMailer;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Dcblogdev\MsGraph\Facades\MsGraph;

class AuthController extends Controller
{
    public function login()
    {
        if (! MsGraph::isConnected()) {
            return view('auth.login');
        }else{
            return redirect('admin/dashboard');
        }
    }

    public function connect()
    {
        return MsGraph::connect();
    }

    public function logout()
    {
        return MsGraph::disconnect();
    }

    public function getAvatar(Request $request,$email){
        $avatar =  MsGraph::images()->get($email);
        if($avatar != ''){
            return response()->json(['message' => 'Image downloaded', 'imageUrl' => $avatar], 201);
        }else{
            return response()->json(['message' => 'No Image found'], 404);
        }
    }

    public function getCurrentUser(){
        
        if (!Auth::check()) {
            return response()->json([
                'error' => 'User not authenticated'
            ], 401); // 401 Unauthorized HTTP status code
        }
        $user = Auth::user();
        $user->makeHidden('email_verified_at');
        $user->makeHidden('created_at');
        $user->makeHidden('updated_at');

        $avatarName = emailToFileName($user->email);
        $path = storage_path('app/public/images/avatars/' . $avatarName . '.jpg');
        if(File::exists($path)){
            $user->avatar = "storage/images/avatars/" . $avatarName . '.jpg';
        }else{
            $user->avatar = "storage/images/avatars/no_image.jpg";
        }
        $user->roles = $user->getRoleNames();
        
        // $user = MsGraph::get('me');
        return response()->json($user);
    }

    public function test(){
        echo "<div style='background-color: #ffffff; color: #000000;'>";
            echo "  <pre>";
            print_r( Auth::user() );
            echo "  </pre>";
            echo "</div>";
            logActivity('create',null,'test');
    }

    public function runCommand(){
        
       $graph = new GraphMailer();
       dd($graph->getMessages('tms@genashtim.com'));
       
        $query = 'users?$expand=manager($levels=1;$select=id,displayName,givenName,mail,department)&$select=id,displayName,givenName,jobTitle,mail,mobilePhone,officeLocation,preferredLanguage,surname,userPrincipalName,department';
        $contacts = MsGraph::contacts()->getAllByQuery($query);
        $i = 1;
        exit();
        foreach ($contacts['value'] as $contact) {
           
            if(isGenashtimEmail($contact['mail']) && $i < 5){
                echo "<div style='background-color: #ffffff; color: #000000;'>";
                echo "  <pre>";
                print_r( $contact );
                echo "  </pre>";
                echo "</div>";
                echo $i;
                 // Create a new Employee instance and save the data
                 $employee = new Employee([
                    'first_name' => $contact['displayName'], // Assuming displayName is always available
                    'last_name' => $contact['displayName'], // Assuming the last name is the same as displayName for simplicity
                    'email' => $contact['mail'], // Assuming mail is always available
                    'nick_name' => $contact['givenName'] ?? '', // Use givenName if available, otherwise empty string
                    'phone_number' => $contact['mobilePhone'] ?? '0', // Use mobilePhone if available, otherwise '0'
                    'photo' => null, // No photo available, set to null
                    'middle_name' => null, // No middle name data, set to null
                    'extension_name' => null, // No extension name data, set to null
                    'date_of_birth' => '2020-01-01', // No date of birth data, set to null
                    'gender' => 'Female', // Default gender if Others
                    'marital_status' => 'Single', // Default marital status if unknown
                    'country' => 'Bahrain', // Default nationality if unknown
                    'time_zone' => '+08:00', // Default time zone, adjust as necessary
                    'member_category' => 'N/A', // Default member category if unknown
                    'address' => '', // Default empty string if no address data
                    'personal_email' => null, // No personal email data, set to null
                    'core_folder' => null, // No core folder data, set to null
                    'hire_date' => '2020-01-01', // No hire date data, set to null
                ]);

            $employee->save();
                $i++;
            }
        }
        exit();
        echo "<div style='background-color: #ffffff; color: #000000;'>";
            echo "  <pre>";
            print_r( $contact );
            echo "  </pre>";
            echo "</div>";
            $user = Auth::user();
            $role = Role::create(['name' => 'admin']);
            $role = Role::create(['name' => 'hr']);
            $user->assignRole('hr');
            $user->assignRole('admin');
            exit();
        echo "<div style='background-color: #ffffff; color: #000000;'>";
            echo "  <pre>";
            print_r( $user->getRoleNames() );
            echo "  </pre>";
            echo "</div>";
        dd($user);
    }
}
