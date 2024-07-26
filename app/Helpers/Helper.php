<?php 
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

if(!function_exists('emailToFileName')){
    function emailToFileName($email){
        return preg_replace('/[^a-zA-Z0-9]/', '_', $email);
    }
}

if(!function_exists('reFormatDepartments')){
    function reFormatDepartments($departments,&$flattened = [],$depth=0,$char= ""){

        foreach($departments as $deptValue){
           
                $flattened[] = [
                    'id' => $deptValue['id'], 
                    'name' => $deptValue['name'],
                    'description' => $deptValue['description'],
                    'parent_id' => $deptValue['parent_id'],
                    'current_status' => $deptValue['current_status'],
                    'created_at' => $deptValue['created_at'],
                    'updated_at' => $deptValue['updated_at'],
                    'depth' => $depth,
                    'char' => $char,
                ];
                if (!empty($deptValue['departments'])) {
                    reFormatDepartments($deptValue['departments'], $flattened,$depth+1, $char . "--|");
                }
         
        }
        return $flattened;
    }
}

if(!function_exists('isGenashtimEmail')){
    function isGenashtimEmail($email) {
        // Check if the string is a valid email
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // Extract the domain part of the email
            $domain = substr(strrchr($email, "@"), 1);

            // Define the list of allowed domains
            $allowedDomains = explode(",",env('SITE_CONFIG_ALLOWED_DOMAINS', 'genashtim.com'));

            // Check if the domain is in the list of allowed domains
            if (in_array($domain, $allowedDomains)) {
                return true; // Email is valid and from an allowed domain
            }
        }
        return false; // Email is not valid or not from an allowed domain
    }
}


if (!function_exists('logActivity')) {
    /**
     * Log activity in the system.
     *
     * @param string $action The action performed, e.g., 'create', 'update', 'delete'.
     * @param string|null $description Optional description of the activity.
     * @param array|object|null $detailLog Detailed data about the activity.
     */
    function logActivity($action, $detailLog = null, $description = null, $id=0,$email= '')
    {   
        if(Auth::check()){
            $user = Auth::user();
            $userId = $user->id;
            $userEmail = $user->email ;
        }else{
            $userId = $id;
            $userEmail = $email !='' ? $email : env('MAIL_FROM_ADDRESS') ;
        }
        echo $userEmail;
      exit;
        ActivityLog::create([
            'user_id' => $userId,
            'email' => $userEmail,
            'action' => $action,
            'description' => $description,
            'detail_log' => json_encode($detailLog), // Encode detail log to JSON
        ]);
    }
}

