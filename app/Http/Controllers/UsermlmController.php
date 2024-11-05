<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usermlm;
use App\Models\Admin;
use App\Models\Pin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class UsermlmController extends Controller
{
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'statusCode' => 0,
            'message' => 'Successfully logged out'
        ]);
    }

    public function adminSignin(Request $request)
    {
        try {
            // Validate the request
            $credentials = $request->validate([
                'username' => 'required|string',
                'password' => 'required|string',
            ]);
    
            // Attempt to find the admin by username
            $useradmin = Admin::where('username', $credentials['username'])->first();
    
            // Check if the user exists and the password is correct
            if ($useradmin && $useradmin->password === $credentials['password']) {
                // Generate an access token (assuming you are using Laravel Passport or Sanctum)
                $accessToken = $useradmin->createToken('AdminFKDIWIJdfdsfdsjhkgyW IEW J77872 78*&*&839039J DKSJH!#@^*&(')->accessToken;
                return response()->json([
                    'statusCode' => 1,
                    'message' => 'Login successful.',
                    'user' => [
                        'id'=>$useradmin->id,
                        'name' => $useradmin->username,
                        'role' => $useradmin->role,
                    ],
                    'access_token' => [
                        'token' => $accessToken,
                        'token_type' => 'Bearer',
                    ],
                ], 200);
            }
    
            // Unauthorized response if credentials are incorrect
            return response()->json(['statusCode' => 0, 'error' => 'Unauthorized'], 200);
        } catch (\Exception $e) {
            return response()->json([
                'statusCode' => 0,
                'message' => 'An error occurred during login.',
                'error' => $e->getMessage(),
            ], 200); // Changed to 500 for server errors
        }
    }
    

public function signin(Request $request)
{
    try {
        // Validate the request inputs
        $request->validate([
            'mobile' => 'required|string',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);

        // Get the credentials from the request
        $credentials = $request->only(['mobile', 'password']);
        // Find the user by their contact (or email)
        $user = Usermlm::where('email', $credentials['mobile'])
                        ->orWhere('mobile', $credentials['mobile'])
                        ->first();

         if(!$user){
            return response()->json([
                'statusCode' => 0,
                'message' => "Invalid Credentials "
            ], 200);
         }               
        // Check if the user exists and if the password is correct
         
      //  if (!$user || !Hash::check($credentials['password'], $user->password)) {
        if ($user && $credentials['password'] !== $user->password) {
            // Return the response for invalid credentials
            return response()->json([
                'statusCode' => 0,
                'message' => "Invalid Credentials"
            ], 200);
        }

        // Create token
        $tokenResult = $user->createToken('FKDIWIJdfdsfdsjhkgyW IEW J77872 78*&*&839039J DKSJH!#@^*&(');
        $accessToken = $tokenResult->accessToken;  // for Passport

        if ($user) {
            $userData = $user->toArray();
            //$userData['role']='user';
            if (array_key_exists('api_token', $userData)) {
                unset($userData['api_token']);
                unset($userData['level']);
            }

            foreach ($userData as $key => $value) {
                if (is_null($value)) {
                    $userData[$key] = ''; // Set to an empty string if null
                }
            }
        }

        return response()->json([
            'statusCode' => 1,
            'message' => 'Login successful.',
            'user' => $userData,
            'access_token' => [
                // 'full'=>$tokenResult,
                'token' => $accessToken,
                'token_type' => 'Bearer',
                // 'expires_at' => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString(),
                'name' => $user->name,
                'email' => $user->email,
            ],
        ], 200);

    } catch (Exception $e) {
        // Handle the exception and return a custom error message
        return response()->json([
            'statusCode' => 0,
            'error' => $e->getMessage()
        ], 200);
    }
}


public function findbyfield(Request $request)
{
    // Manually creating a validator instance
    $validator = Validator::make($request->all(), [
        'field' => 'required|string',
        'value' => 'required|string',
    ]);

    // Check if validation fails
    if ($validator->fails()) {
        return response()->json(['statusCode' => 0,'error' => 'Validation failed', 'message' => $validator->errors()], 200);
    }
    // Extract both 'field' and 'value' from the request
    $req = $request->only(['field', 'value']);
    $userData = Usermlm::where($req['field'], $req['value'])->first();
    // Search in the Usermlm model based on the given field and value
    if ($userData) {
        $userData = $userData->toArray();
        
        foreach ($userData as $key => $value) {
            if (is_null($value)) {
                $userData[$key] = ''; // Set to an empty string if null
            }
        }
    } else {
        $userData = []; // or handle the "no data found" scenario as needed
    } 
    
  

    foreach ($userData as $key => $value) {
        if (is_null($value)) {
            $userData[$key] = ''; // Set to an empty string if null
        }
    }

    // Check if the user was found
    if ($userData) {
        return response()->json(['statusCode'=>1,'message' => 'User details', 'user' => $userData], 200);
    } else {
        return response()->json(['statusCode'=>0,'message' => 'User not found'], 200);
    }
}


    public function pairlevel(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required'
        ]);

      $RDownline=$this->RightDownline($request->id);
      $RUpline= $this->RightUpline($request->id);

      $LDownline=$this->LeftDownline($request->id);
      $LUpline= $this->LeftUpline($request->id);
    
      $PairMatches= $this->checkPairMatches($request->id);
      $CompleteLevels= $this->checkCompleteLevels2($request->id)-1;


      $getAllDescendants=$this->getAllDescendants($request->id);

      $getBinaryTreeStructureJson=$this->getBinaryTreeStructureJson($request->id);
      

     // $getAllLeftDescendants=$this->getAllLeftDescendants($request->id);

      //$getAllLeftDescendantsWithSubChildren=$this->getAllLeftDescendantsWithSubChildren($request->id);

      return response()->json(['statusCode' => 1,'message' => 'Tree successfully', 'PairMatches' => $PairMatches,'CompleteLevels'=> $CompleteLevels,"RDownline"=>$RDownline,"RUpline"=>$RUpline,"LDownline"=>$LDownline,"LUpline"=>$LUpline,"getAllDescendants"=>$getAllDescendants,"getBinaryTreeStructureJson"=>$getBinaryTreeStructureJson], 200);
    }

    public function store(Request $request)
    {

        // Validation
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'mobile' => 'required|string|max:15',
            'email' => 'nullable|email|max:255|unique:users',
            'whatsapp' => 'nullable|max:15',
            'pan' => 'nullable|max:10',
            'adhar' => 'nullable|max:12',
            'relation' => 'nullable|max:255',
            'relation_name' => 'nullable|string|max:255',
            'gender' => 'nullable',
            'dob' => 'nullable',
            'self_code' => 'nullable|string|max:255',
            'used_code' => 'nullable',
            'status' => 'nullable',
            'password' => 'required|string|min:8', // password confirmation rule
            'added_below'=>'nullable',
            'parent_code'=>'required|string',
             
        ]);

        // Handle validation failure
        if ($validator->fails()) {
            return response()->json(['statusCode' => 0,'error' => 'Validation failed', 'message' => $validator->errors()], 200);
            //return response()->json($validator->errors(), 200);
        }

        //$lastUser = Usermlm::latest('id')->first();
        $lastUser = Usermlm::max('id')?? 0;
        if ($lastUser == 0) {
            $sql = "INSERT INTO `usermlms` (`id`, `child_left`, `child_right`, `last_left`, `last_right`, `name`, `level`, `paid_level`, `self_code`, `mobile`, `email`, `whatsapp`, `pan`, `adhar`, `relation`, `relation_name`, `gender`, `used_code`, `dob`, `referral_code`, `parent_code`, `role`, `side`, `powerleg`, `parent_id`, `status`, `password`, `plain_password`, `api_token`, `added_below`, `created_at`, `updated_at`) 
            VALUES 
            (1, '', '', '', '', 'Admin', 0, NULL, '', '7985003120', 'admin@gmail.com', '', '', '', '', '', 'Male', '', '31/10/1989', NULL, '0', '2', 0, NULL, NULL, 1, 'password@123', NULL, NULL, NULL, '2024-10-28 11:41:41', '2024-10-28 11:41:41'),
            (2, '', '', '', '', 'Root', 0, NULL, 'GGB22024', '8800318153', 'ggbroot@gmail.com', '', '', '', '', 'root', 'Male', '0', '31/10/1989', NULL, '0', '1', 0, NULL, NULL, 1, 'password@123', NULL, NULL, NULL, '2024-10-29 16:21:05', '2024-10-29 16:21:05')";
            DB::statement($sql);
            $lastUser = Usermlm::max('id')?? 0;
        }

        $id = $lastUser ? $lastUser + 1 : 1;
        $isUnique = DB::table('usermlms')->where('mobile', $request->mobile)->exists();
        $result = $isUnique ? 1 : 0; // 1 if unique, 0 if duplicate
        if($result){
          return response()->json(['statusCode'=>0,'message' => 'Mobile number already exist'], 200); // 409 Conflict
        }

        $sponsoredCode=$request->parent_code;

        $getBinaryTreeStructureJson1 = $this->getBinaryTreeStructureJson1($sponsoredCode);
        $nodeAdd = !empty($getBinaryTreeStructureJson1) ? $getBinaryTreeStructureJson1[0][0] : null;
        if (!$nodeAdd) {
            return response()->json(['status' => 0, 'message' => 'Parent code not found or invalid'], 200); // 404 Not Found
        }

        // $getBinaryTreeStructureJson1=$this->getBinaryTreeStructureJson1($request->parent_code);
        // if(count($getBinaryTreeStructureJson1)>0){
        //     $nodeAdd=$getBinaryTreeStructureJson1[0][0];
        // }

        if($request->side!=1 && $request->side!=2){//agar user ne nhi bheja
            if($nodeAdd['empty']==3){
                $request->side = 1;
            }else{
                $request->side = $nodeAdd['empty'];
            }
        } 

        $request->parent_code = $nodeAdd['id'];
        $request->used_code = $sponsoredCode;

        $usermlm = Usermlm::create([
            'name' => $request->name,
            'mobile' => $request->mobile,
            'email' => $request->email,
            'whatsapp' => $request->whatsapp,
            'pan' => $request->pan,
            'adhar' => $request->adhar,
            'relation' => $request->relation,
            'relation_name' => $request->relation_name,
            'gender' => $request->gender,
            'dob' => $request->dob,
            'self_code' => "GGB" . $id . "2024",
            'used_code' => $request->used_code,
            'side' => $request->side,
            'status' => 0,
            'password' =>$request->password, // Password encryption
            'plain_password'=>$request->password,
            'level' => 0,
            'added_below' => $request->added_below,
            'parent_code'=> $request->parent_code,
        ]);

       $Tuser = Usermlm::latest('id')->first();
       $get = DB::select("SELECT * FROM usermlms WHERE id = $request->parent_code");
       $pr=$get[0];
       $uid=$usermlm->id;

        if($request->side==1){
            $Downline=$this->LeftDownline($request->parent_code);
            $Upline=$this->LeftUpline($request->parent_code);
            $results_string = $Downline.",".$Upline;
            DB::update("UPDATE usermlms SET last_left = $usermlm->id WHERE id in($results_string)");

            if($pr->child_left==''){
              DB::update("UPDATE usermlms SET child_left = $usermlm->id WHERE id = $request->parent_code");
            }else{
              DB::update("UPDATE usermlms SET child_left = $usermlm->id WHERE id = $pr->last_left");
            }

        }elseif($request->side==2){
            $Downline=$this->RightDownline($request->parent_code);
            $Upline= $this->RightUpline($request->parent_code);
            $results_string = $Downline.",".$Upline;
            DB::update("UPDATE usermlms SET last_right = $usermlm->id WHERE id in($results_string)");
            if($pr->child_right==''){
              DB::update("UPDATE usermlms SET child_right = $usermlm->id WHERE id = $request->parent_code");
            }else{
              DB::update("UPDATE usermlms SET child_right = $usermlm->id WHERE id = $pr->last_right");
            }
        } 


        //CompleteLevel($rootId)
        $getv = DB::select("SELECT * FROM usermlms WHERE id = ?", [$usermlm->id]);
        $rs1 = $getv[0];
        // Loop through each property of the record
        foreach ($rs1 as $key => $value) {
            // Check if the value is null and convert it to an empty string
            if (is_null($value)) {
                $rs1->$key = ''; // Convert null to empty string
            }
        }
        // Set the password property to the value of plain_password
        $rs1->password = $rs1->plain_password;
        // Remove the plain_password property
        unset($rs1->plain_password);
        return response()->json(['statusCode'=>1,'message' => 'User created successfully', 'user' => $rs1], 200);
    }

    public function LeftDownline($parent_code){
        //$parent_code = $request->parent_code;  // Initial parent code
        $pp=$parent_code;
        $get = DB::select("SELECT child_left FROM usermlms WHERE id =$parent_code");
        $child_left = null;
        $results = [];
        do {
            // echo "adfa";
            $get = DB::select("SELECT child_left FROM usermlms WHERE id =$parent_code");
            if (!empty($get)) {
                $child_left = $get[0]->child_left;  // Get the first result's child_left
                if ($child_left !== null && $child_left>0) {
                    $results[] = $child_left;  // Add the child_left value to results
                    $parent_code = $child_left;  // Set parent_code for the next iteration
                }
            } else {
                $child_left = null;  // Break the loop if no record is found
            }
        } while ($child_left !== null && $child_left>0);
       array_push($results, $pp);
       $results_string = implode(', ', $results);
      // DB::update("UPDATE usermlms SET last_left = $uid WHERE id in($results_string)");
       return $results_string;
    } 

    public function RightDownline($parent_code){
        $pp=$parent_code;
        $get = DB::select("SELECT child_right FROM usermlms WHERE id =$parent_code");
        $child_right = null;
        $results = [];
        do {
            $get = DB::select("SELECT child_right FROM usermlms WHERE id =$parent_code");
            if (!empty($get)) {
                $child_right = $get[0]->child_right;   
                if ($child_right !== null && $child_right>0) {
                    $results[] = $child_right;  
                    $parent_code = $child_right;   
                }
            } else {
                $child_right = null;  
            }
        } while ($child_right !== null && $child_right>0);
       array_push($results, $pp);
       $results_string = implode(', ', $results);
       //DB::update("UPDATE usermlms SET last_right = $uid WHERE id in($results_string)");
       return $results_string;
    } 


    public function LeftUpline($initial_parent_code) {
        $parent_code = $initial_parent_code;  // Initialize the parent code
        $results = []; // Array to store the results
        // Start the loop
        do {
            // Fetch the ID where child_right matches the current parent_code
            $get = DB::select("SELECT id FROM usermlms WHERE child_left = $parent_code");
    
            if (!empty($get)) {
                $current_id = $get[0]->id;  // Get the first matching ID
                $results[] = $current_id;    // Add the ID to results
                $parent_code = $current_id;  // Update parent_code to the new current_id
            } else {
                // No more matching child_right found
                break;  // Exit the loop if no match is found
            }
        } while (true); // Infinite loop that will break when there are no matches
        // Convert the results array to a comma-separated string if needed
        array_push($results, $initial_parent_code);
        $results_string = implode(', ', $results);
        return $results_string; // Return the result string
    }

    public function RightUpline($initial_parent_code) {
        $parent_code = $initial_parent_code;  // Initialize the parent code
        $results = []; // Array to store the results
        // Start the loop
        do {
            // Fetch the ID where child_right matches the current parent_code
            $get = DB::select("SELECT id FROM usermlms WHERE child_right = $parent_code");
    
            if (!empty($get)) {
                $current_id = $get[0]->id;  // Get the first matching ID
                $results[] = $current_id;    // Add the ID to results
                $parent_code = $current_id;  // Update parent_code to the new current_id
            } else {
                // No more matching child_right found
                break;  // Exit the loop if no match is found
            }
        } while (true); // Infinite loop that will break when there are no matches
        // Convert the results array to a comma-separated string if needed
        array_push($results, $initial_parent_code);
        $results_string = implode(', ', $results);
        return $results_string; // Return the result string
    }

   // Function to find the depth of the MLM tree
//    public function getTreeDepth($id)
//    {
//        $get = DB::select("SELECT * FROM usermlms WHERE id = $id");
//        $get[0]->child_left;
//        $get[0]->child_right;


       
       
       
//     //    $node = UserMlm::find($id);
//     //    if (!$node) {
//     //        return 0;
//     //    }
//     //    //$this->getTreeDepth($node->child_left);
     
//        return 1 + $node->child_left;
//    }

   public function Tindex()
    {
        $rootId = 1; // Assuming the root ID is 1
        $depth = $this->getTreeDepth($rootId);

        return response()->json([
            'depth' => $depth
        ]);
    }




function minCompleteLevels($node, $level = 1) {
    // If node is null, treat it as fully filled for the current level
    if ($node === null) {
        return $level - 1;
    }
    
    // Check both left and right subtrees
    $leftLevel = $this->minCompleteLevels($node[1], $level + 1);
    $rightLevel = $this->minCompleteLevels($node[2], $level + 1);

    // If both the left and right subtrees are complete at the same level,
    // the current level is complete, so return that.
    if ($leftLevel === $rightLevel) {
        return $leftLevel;
    }
    
    // Otherwise, return the minimum level which was incomplete.
    return min($leftLevel, $rightLevel);
}

// Function to check the number of completely filled levels
function checkCompleteLevels($tree) {
    $completedLevels = $this->minCompleteLevels($tree);
    return "The tree has $completedLevels completely filled levels.";
}


public function countPairMatches($userId, $level = 1)
{
    // Fetch left and right child for the current user
    $user = DB::selectOne("SELECT child_left, child_right FROM usermlms WHERE id = ?", [$userId]);

    // If user doesn't exist or has no children, treat it as no match
    if (!$user || ($user->child_left === null && $user->child_right === null)) {
        return 0;
    }

    // Check if there is a pair match at the current node (both children exist)
    $currentMatch = ($user->child_left !== null && $user->child_right !== null) ? 1 : 0;

    // Recursively check both subtrees (left and right children)
    $leftMatches = $user->child_left ? $this->countPairMatches($user->child_left, $level + 1) : 0;
    $rightMatches = $user->child_right ? $this->countPairMatches($user->child_right, $level + 1) : 0;

    // Total matches at current and subsequent levels
    return $currentMatch + $leftMatches + $rightMatches;
}

// Method to check total pair matches starting from the root user
public function checkPairMatches($rootUserId)
{
    return $pairMatches = $this->countPairMatches($rootUserId);
    
    // return response()->json([
    //     'message' => "The tree has $pairMatches fully matched pairs (both left and right children)."
    // ]);
}

public function minCompleteLevels2($rootId) {
    $query = "
        WITH RECURSIVE MLMTree AS (
            SELECT id, child_left, child_right, 1 AS level
            FROM usermlms
            WHERE id = :rootId
            UNION ALL
            SELECT u.id, u.child_left, u.child_right, t.level + 1
            FROM usermlms u
            JOIN MLMTree t ON u.id = t.child_left OR u.id = t.child_right
        )
        SELECT level, COUNT(*) AS node_count
        FROM MLMTree
        GROUP BY level
        HAVING COUNT(*) = POWER(2, level - 1)  -- Check for complete binary tree level
        ORDER BY level
    ";

      $completedLevels = DB::select($query, ['rootId' => $rootId]);

    return count($completedLevels);
    // return response()->json([
    //     'ompletedLevels' => count($completedLevels),
    //     'message' => "The tree has " . count($completedLevels) . " completely filled levels."
    // ]);
}

public function checkCompleteLevels2($rootId) {
    return $this->minCompleteLevels2($rootId);
}



public function getAllDescendants($parent_code) {
    $results = []; // Array to hold all descendants

    // Start recursive search from the initial parent
    $this->retrieveDescendants($parent_code, $results);

    // Add the root node itself
    $results[] = $parent_code;
    $results_string = implode(', ', $results);

    return $results_string;
}

// Recursive helper function to find both left and right descendants
private function retrieveDescendants($node, &$results) {
    // Query to get left and right children
    $children = DB::select("SELECT child_left, child_right FROM usermlms WHERE id = ?", [$node]);

    if (!empty($children)) {
        $child_left = $children[0]->child_left;
        $child_right = $children[0]->child_right;

        // Process left child
        if ($child_left !== null && $child_left > 0) {
            $results[] = $child_left; // Add left child to results
            $this->retrieveDescendants($child_left, $results); // Recursive call for left child
        }

        // Process right child
        if ($child_right !== null && $child_right > 0) {
            $results[] = $child_right; // Add right child to results
            $this->retrieveDescendants($child_right, $results); // Recursive call for right child
        }
    }
}


public function getAllLeftDescendants($parent_code) {
    $results = []; // Array to hold all left descendants

    // Start recursive search from the initial parent for left nodes
    $this->retrieveLeftDescendants($parent_code, $results);

    // Add the root node itself
    $results[] = $parent_code;
    $results_string = implode(', ', $results);

    return $results_string;
}

// Recursive helper function to find only left descendants
private function retrieveLeftDescendants($node, &$results) {
    // Query to get only the left child
    $children = DB::select("SELECT child_left FROM usermlms WHERE id = ?", [$node]);

    if (!empty($children)) {
        $child_left = $children[0]->child_left;

        // Process left child if it exists
        if ($child_left !== null && $child_left > 0) {
            $results[] = $child_left; // Add left child to results
            $this->retrieveLeftDescendants($child_left, $results); // Recursive call for left child
        }
    }
}



public function getAllLeftDescendantsWithSubChildren($parent_code) {
    $results = []; // Array to hold all descendants including left subtree nodes and their children

    // Start recursive search from the initial parent for left subtree nodes
    $this->retrieveLeftDescendantsWithSubChildren($parent_code, $results);

    // Add the root node itself
    $results[] = $parent_code;
    $results_string = implode(', ', $results);

    return $results_string;
}

// Recursive helper function to find all descendants on the left side, including their sub-children
private function retrieveLeftDescendantsWithSubChildren($node, &$results) {
    // Query to get both left and right children
    $children = DB::select("SELECT child_left, child_right FROM usermlms WHERE id = ?", [$node]);

    if (!empty($children)) {
        $child_left = $children[0]->child_left;
        $child_right = $children[0]->child_right;

        // Process left child and its subtree if it exists
        if ($child_left !== null && $child_left > 0) {
            $results[] = $child_left; // Add left child to results
            $this->retrieveLeftDescendantsWithSubChildren($child_left, $results); // Recursive call for left child's subtree
        }

        // Process right child and its subtree if it exists
        if ($child_right !== null && $child_right > 0) {
            $results[] = $child_right; // Add right child to results
            $this->retrieveLeftDescendantsWithSubChildren($child_right, $results); // Recursive call for right child's subtree
        }
    }
}



public function getBinaryTreeStructureJson($rootId) {
    $treeLevels = [];  // Array to hold all levels of the tree

    // Start level-order traversal from the root node
    $this->retrieveLevelNodes([$rootId], $treeLevels);

    // Convert the result to JSON format
    //return json_encode($treeLevels, JSON_PRETTY_PRINT);
    return $treeLevels;
}

// Helper function to retrieve nodes level-wise
private function retrieveLevelNodes($currentLevelNodes, &$treeLevels) {
    if (empty($currentLevelNodes)) {
        return;  // Base case: if there are no nodes at this level, stop recursion
    }

    $nextLevelNodes = []; // Array to hold the next level nodes
    $currentLevel = [];   // Array to hold current level nodes in structured format

    foreach ($currentLevelNodes as $nodeId) {
        // Query to fetch left and right children of the current node
        $children = DB::select("SELECT id, child_left, child_right FROM usermlms WHERE id = ?", [$nodeId]);

        if (!empty($children)) {
            $node = $children[0];
            
            // Add the current node and its children to the current level structure
            $currentLevel[] = [
                'id' => $node->id,
                'left' => $node->child_left,
                'right' => $node->child_right
            ];

            // Append the left and right children to the next level array
            if ($node->child_left !== null) {
                $nextLevelNodes[] = $node->child_left;
            }
            if ($node->child_right !== null) {
                $nextLevelNodes[] = $node->child_right;
            }
        }
    }

    // Append the current level nodes to the tree structure
    $treeLevels[] = $currentLevel;

    // Recursive call for the next level
    $this->retrieveLevelNodes($nextLevelNodes, $treeLevels);
}



public function getBinaryTreeStructureJson1($rootId) {
    $treeLevels = [];  // Array to hold all levels of the tree
    // Start level-order traversal from the root node
    $this->retrieveLevelNodes1([$rootId], $treeLevels);
   // echo count($treeLevels);
    if(count($treeLevels)>0){
        return $treeLevels;
    }
    

    // Convert the result to JSON format
    //return json_encode($treeLevels, JSON_PRETTY_PRINT);
    
}
 
private function retrieveLevelNodes1($currentLevelNodes, &$treeLevels) {
    if (empty($currentLevelNodes)) {
        return;  // Base case: if there are no nodes at this level, stop recursion
    }

    $nextLevelNodes = []; // Array to hold the next level nodes
    $currentLevel = [];   // Array to hold current level nodes in structured format

    foreach ($currentLevelNodes as $nodeId) {
        // Query to fetch left and right children of the current node
        $children = DB::select("SELECT id, child_left,child_right,mobile,name,self_code FROM usermlms WHERE id = ?", [$nodeId]);

        if (!empty($children)) {
            $node = $children[0];

            if (empty($node->child_left) && empty($node->child_right)) {
                $empt = 3; // Both are empty
            } elseif (empty($node->child_left)) {
                $empt = 1; // Only child_left is empty
            } elseif (empty($node->child_right)) {
                $empt = 2; // Only child_right is empty
            } else {
                $empt = 4; // Both are not empty
            }
            
            // Add the current node and its children to the current level structure

            if($empt!=4){
                $currentLevel[] = [
                    'id' => $node->id,
                    'left' => $node->child_left ?? '', 
                    'right' => $node->child_right ?? '', 
                    'self_code'=>$node->self_code ?? '', 
                    'name'=> $node->name ?? '', 
                    'mobile'=> $node->mobile ?? '', 
                    'empty'=>$empt,
                ];
            }

            // Append the left and right children to the next level array
            if ($node->child_left !== null) {
                $nextLevelNodes[] = $node->child_left;
            }
            if ($node->child_right !== null) {
                $nextLevelNodes[] = $node->child_right;
            }
        }
    }

    if($currentLevel){
        $treeLevels[] = $currentLevel;
    }
    
    if (count($treeLevels) > 0) {
        return;
    }

    // Recursive call for the next level
    $this->retrieveLevelNodes1($nextLevelNodes, $treeLevels);
}

public function CompleteLevel($childId) {
    return $this->innerCompleteLevel($childId);
}

public function innerCompleteLevel22($childId) {
    $currentNodeId = $childId;  // Start with the child node
    $completedLevels = 0;

    while (!is_null($currentNodeId)) {
        // Fetch the parent node for the current node
        $parentNode = DB::select("SELECT parent_code FROM usermlms WHERE id = $currentNodeId");

        if (empty($parentNode)) {
            break;  // If no parent found, stop traversing
        }

        $parentCode = $parentNode[0]->parent_code;

        // Check if the parent node is valid and exists
        if (!is_null($parentCode) && $parentCode > 0) {
            $currentNodeId = $parentCode;  // Move to the parent node
        } else {
            break;  // If there's no valid parent node, stop
        }

        $completedLevels++;
    }

    return $completedLevels;
}

public function MyDownline1Sts($parent_code) {
    $results = [];
    $initial_parent = $parent_code;

    // Use a stack to traverse both left and right children
    $stack = [$parent_code];

    while (!empty($stack)) {
        $current_parent = array_pop($stack);

        // Fetch child_left, child_right, and status for the current parent
        $children = DB::select("SELECT child_left, child_right, status FROM usermlms WHERE id = ?", [$current_parent]);

        // Ensure we have valid children data
        if (!empty($children)) {
            $child_left = $children[0]->child_left;
            $child_right = $children[0]->child_right;
            $current_status = $children[0]->status; // Get the status for the current parent

            // Add current parent with its status to results
            if($current_status==1){
                //$results[] = "$current_parent (Status: $current_status)";
                $results[] = $current_parent;
            }

            // Push right child first so left child is processed first (DFS)
            if (!is_null($child_right) && $child_right > 0) {
                $stack[] = $child_right;
            }
            if (!is_null($child_left) && $child_left > 0) {
                $stack[] = $child_left;
            }
        }
    }

    // Convert the results array into a string
    //$results_string = implode(', ', $results);

    // Optionally, update the database for the gathered results (if needed).
    // DB::update("UPDATE usermlms SET last_processed = ? WHERE id IN($results_string)", [$uid]);
    return $results;
   // return $results_string;
}

public function advisorList() {
    // Fetch advisor list from the usermlms table
    $authUser = auth()->guard('api')->user();
        if(!$authUser){
            return response()->json([
                "statusCode"=> 0,
                'error' => "Unauthorized User"
            ], 200);

        }
        $userId=$authUser->id;
        $users = Usermlm::select('name', 'id', 'child_left', 'child_right', 'self_code', 'parent_code', 'status')
        ->where('id', $userId)
        ->get();

      $LDownline = $this->MyDownline1Sts($users[0]->child_left);
      $RDownline = $this->MyDownline1Sts($users[0]->child_right);
      $Down=array_merge($LDownline,$RDownline);

      $x = Usermlm::select('name', 'id', 'self_code', 'parent_code', 'status')
        ->whereIn('id', $Down) // Use whereIn with the merged array
        ->get();

      // Return the result as a JSON response
    return response()->json([
        'statusCode' => 1,
        // 'data1' => $LDownline,
        // 'data2' => $RDownline,
        // 'data4'=>$Down,
        'data' => $x

    ], 200);
}



public function AdminAdvisorList() {
    // Fetch advisor list from the usermlms table
        //$authUser = auth()->guard('api')->user();
        // if(!$authUser){
        //     return response()->json([
        //         "statusCode"=> 0,
        //         'error' => "Unauthorized User"
        //     ], 200);

        // }
       // $userId=$authUser->id;
        $users = Usermlm::select('name', 'id', 'child_left', 'child_right', 'self_code', 'parent_code', 'status')
        ->get();

    //   $LDownline = $this->MyDownline1Sts($users[0]->child_left);
    //   $RDownline = $this->MyDownline1Sts($users[0]->child_right);
    //   $Down=array_merge($LDownline,$RDownline);

    //   $x = Usermlm::select('name', 'id', 'self_code', 'parent_code', 'status')
    //     ->whereIn('id', $Down) // Use whereIn with the merged array
    //     ->get();

      // Return the result as a JSON response
    return response()->json([
        'statusCode' => 1,
        // 'data1' => $LDownline,
        // 'data2' => $RDownline,
        // 'data4'=>$Down,
        'data' => $users

    ], 200);
}


public function uplineListUntilRoot(Request $request) {
    // Start with the child node
   // $user = auth()->guard('api')->user();
    $request->validate([
        'id' => 'required',
        'typeStatus' => 'nullable'
    ]);
    $req = $request->only(['id']);
    $childId =$req['id'];

   // $childId = 103;
   // $uplineList = [];
    
    // Fetch the parent nodes until parent_code is 0
    while ($childId != 0) {
        // Get the parent node for the current child
        $result = DB::select("SELECT id, name, parent_code FROM usermlms WHERE id = ?", [$childId]);

        // If no result found, break the loop
        if (empty($result)) {
            break;
        }

        // Get the first result (assuming there's only one result)
        $node = $result[0];
      //  print_r($node);
        
        $completedLevel=$this->minCompleteLevels1Status($node->id);
        

        // Add the current node to the upline list
        $uplineList[] = [
            'id' => $node->id,
            'name' => $node->name,
            'completeLevel'=>$completedLevel,
            'parent_code' => $node->parent_code
        ];

        // Set the next childId to the parent_code for the next iteration
        $childId = $node->parent_code;
    }

    // Return the full upline list as a response
    return response()->json([
        'statusCode' => 1,
        'data' => $uplineList
    ], 200);
}




public function uplineUpdateLevelBreakFirstZero($childId) {
    // Fetch the parent nodes until parent_code is 0
    while ($childId != 0) {
        // Get the parent node for the current child
        $result = DB::select("SELECT id, name, parent_code FROM usermlms WHERE id = ?", [$childId]);

        // If no result found, break the loop
        if (empty($result)) {
            break;
        }

        // Get the first result (assuming there's only one result)
        $node = $result[0];
      //  print_r($node);
        
        $completedLevel=$this->minCompleteLevels1StatusBreak($node->id);

        // Add the current node to the upline list
        $uplineList[] = [
            'id' => $node->id,
            'name' => $node->name,
            'completeLevel'=>$completedLevel,
            'parent_code' => $node->parent_code
        ];

        DB::table('usermlms')->where('id', $node->id)->update(['level' => $completedLevel]);

        // Set the next childId to the parent_code for the next iteration
        $childId = $node->parent_code;
        if($completedLevel==0){
            break;
        }
    }

    // Return the full upline list as a response
    return response()->json([
        'statusCode' => 1,
        'data' => $uplineList
    ], 200);
}

public function uplineListBreakFirstZero(Request $request) {
    // Start with the child node
   // $user = auth()->guard('api')->user();
    $request->validate([
        'id' => 'required',
        'typeStatus' => 'nullable'
    ]);
    $req = $request->only(['id']);
    $childId =$req['id'];

   // $childId = 103;
   // $uplineList = [];
    
    // Fetch the parent nodes until parent_code is 0
    while ($childId != 0) {
        // Get the parent node for the current child
        $result = DB::select("SELECT id, name, parent_code FROM usermlms WHERE id = ?", [$childId]);

        // If no result found, break the loop
        if (empty($result)) {
            break;
        }

        // Get the first result (assuming there's only one result)
        $node = $result[0];
      //  print_r($node);
        
        $completedLevel=$this->minCompleteLevels1StatusBreak($node->id);

        // Add the current node to the upline list
        $uplineList[] = [
            'id' => $node->id,
            'name' => $node->name,
            'completeLevel'=>$completedLevel,
            'parent_code' => $node->parent_code
        ];

        DB::table('usermlms')->where('id', $node->id)->update(['level' => $completedLevel]);

        // Set the next childId to the parent_code for the next iteration
        $childId = $node->parent_code;
        if($completedLevel==0 && $node->id!=$req['id']){
            break;
        }
    }

    // Return the full upline list as a response
    return response()->json([
        'statusCode' => 1,
        'data' => $uplineList
    ], 200);
}

public function checkCompleteLevels1Status($rootId) {
    return $this->minCompleteLevels1Status($rootId);
}

public function minCompleteLevels1Status222($rootId) {
    $currentLevelNodes = [$rootId];  // Start with the root node
    $completedLevels = 0;

    while (!empty($currentLevelNodes)) {
        $nextLevelNodes = [];
        $levelNodeCount = count($currentLevelNodes);  // Get the number of nodes in the current level

        // Check if this level is complete
        if ($levelNodeCount != pow(2, $completedLevels)) {
            break;  // If the current level doesn't match the expected number of nodes, stop
        }

        // Traverse through the nodes in the current level and get their children
        foreach ($currentLevelNodes as $nodeId) {
            $children = DB::select("
                SELECT child_left, child_right 
                FROM usermlms 
                WHERE id = ? AND status = 1", 
                [$nodeId]
            );

            if (!empty($children)) {
                $child_left = $children[0]->child_left;
                $child_right = $children[0]->child_right;

                // Check if child_left and child_right have status 1
                if (!is_null($child_left) && $child_left > 0) {
                    $left_child_status = DB::select("
                        SELECT status 
                        FROM usermlms 
                        WHERE id = ?", [$child_left]);

                    if (!empty($left_child_status) && $left_child_status[0]->status == 1) {
                        $nextLevelNodes[] = $child_left;
                    }
                }

                if (!is_null($child_right) && $child_right > 0) {
                    $right_child_status = DB::select("
                        SELECT status 
                        FROM usermlms 
                        WHERE id = ?", [$child_right]);

                    if (!empty($right_child_status) && $right_child_status[0]->status == 1) {
                        $nextLevelNodes[] = $child_right;
                    }
                }
            }
        }
        $currentLevelNodes = $nextLevelNodes;
        $completedLevels++;
    }

    return $completedLevels;
}


public function minCompleteLevels1StatusBreak($rootId) {
    $currentLevelNodes = [$rootId];  // Start with the root node
    $completedLevels = 0;

    while (!empty($currentLevelNodes)) {
        $nextLevelNodes = [];
        $levelNodeCount = count($currentLevelNodes);  // Get the number of nodes in the current level

        // Check if this level is complete by comparing node count with 2^completedLevels
        if ($levelNodeCount != pow(2, $completedLevels)) {
            break;  // Stop if the current level doesn't have the expected number of nodes
        }

        // Initialize a flag to check if all nodes in the level have valid children
        $allChildrenComplete = true;

        // Traverse through the nodes in the current level and get their children
        foreach ($currentLevelNodes as $nodeId) {
            $children = DB::select("
                SELECT child_left, child_right 
                FROM usermlms 
                WHERE id = ? AND status = 1", 
                [$nodeId]
            );

            if (!empty($children)) {
                $child_left = $children[0]->child_left;
                $child_right = $children[0]->child_right;
                $hasValidChildren = true; // Flag for checking current node's child status

                // Check left child
                if (!is_null($child_left) && $child_left > 0) {
                    $left_child_status = DB::select("
                        SELECT status 
                        FROM usermlms 
                        WHERE id = ?", [$child_left]);

                    if (empty($left_child_status) || $left_child_status[0]->status != 1) {
                        $hasValidChildren = false; // Mark as invalid if left child isn't active
                    } else {
                        $nextLevelNodes[] = $child_left; // Add valid left child to next level
                    }
                } else {
                    $hasValidChildren = false; // Mark as invalid if left child doesn't exist
                }

                // Check right child
                if (!is_null($child_right) && $child_right > 0) {
                    $right_child_status = DB::select("
                        SELECT status 
                        FROM usermlms 
                        WHERE id = ?", [$child_right]);

                    if (empty($right_child_status) || $right_child_status[0]->status != 1) {
                        $hasValidChildren = false; // Mark as invalid if right child isn't active
                    } else {
                        $nextLevelNodes[] = $child_right; // Add valid right child to next level
                    }
                } else {
                    $hasValidChildren = false; // Mark as invalid if right child doesn't exist
                }

                // Check if both children are valid for the current node
                if (!$hasValidChildren) {
                    $allChildrenComplete = false; // If any node lacks valid children, stop level completion
                }
            } else {
                $allChildrenComplete = false; // No children found, so level cannot be complete
            }
        }

        // Increment completed levels only if all nodes in the current level have valid children
        if ($allChildrenComplete) {
            $completedLevels++;
        } else {
            break;  // If the current level isn't complete, stop the loop
        }

        // Update current level nodes for the next iteration
        $currentLevelNodes = $nextLevelNodes;
    }

    return $completedLevels;
}

public function minCompleteLevels1Status($rootId) {
    $currentLevelNodes = [$rootId];  // Start with the root node
    $completedLevels = 0;

    while (!empty($currentLevelNodes)) {
        $nextLevelNodes = [];
        $levelNodeCount = count($currentLevelNodes);  // Get the number of nodes in the current level

        // Check if this level is complete by comparing node count with 2^completedLevels
        if ($levelNodeCount != pow(2, $completedLevels)) {
            break;  // Stop if the current level doesn't have the expected number of nodes
        }

        // Initialize a flag to check if all nodes in the level have valid children
        $allChildrenComplete = true;

        // Traverse through the nodes in the current level and get their children
        foreach ($currentLevelNodes as $nodeId) {
            $children = DB::select("
                SELECT child_left, child_right 
                FROM usermlms 
                WHERE id = ? AND status = 1", 
                [$nodeId]
            );

            if (!empty($children)) {
                $child_left = $children[0]->child_left;
                $child_right = $children[0]->child_right;
                $hasValidChildren = true; // Flag for checking current node's child status

                // Check left child
                if (!is_null($child_left) && $child_left > 0) {
                    $left_child_status = DB::select("
                        SELECT status 
                        FROM usermlms 
                        WHERE id = ?", [$child_left]);

                    if (empty($left_child_status) || $left_child_status[0]->status != 1) {
                        $hasValidChildren = false; // Mark as invalid if left child isn't active
                    } else {
                        $nextLevelNodes[] = $child_left; // Add valid left child to next level
                    }
                } else {
                    $hasValidChildren = false; // Mark as invalid if left child doesn't exist
                }

                // Check right child
                if (!is_null($child_right) && $child_right > 0) {
                    $right_child_status = DB::select("
                        SELECT status 
                        FROM usermlms 
                        WHERE id = ?", [$child_right]);

                    if (empty($right_child_status) || $right_child_status[0]->status != 1) {
                        $hasValidChildren = false; // Mark as invalid if right child isn't active
                    } else {
                        $nextLevelNodes[] = $child_right; // Add valid right child to next level
                    }
                } else {
                    $hasValidChildren = false; // Mark as invalid if right child doesn't exist
                }

                // Check if both children are valid for the current node
                if (!$hasValidChildren) {
                    $allChildrenComplete = false; // If any node lacks valid children, stop level completion
                }
            } else {
                $allChildrenComplete = false; // No children found, so level cannot be complete
            }
        }

        // Increment completed levels only if all nodes in the current level have valid children
        if ($allChildrenComplete) {
            $completedLevels++;
        } else {
            break;  // If the current level isn't complete, stop the loop
        }

        // Update current level nodes for the next iteration
        $currentLevelNodes = $nextLevelNodes;
    }

    return $completedLevels;
}



public function minCompleteLevels1Status22211($rootId) {
    echo $rootId;
    echo "KKKK";
    $currentLevelNodes = [$rootId];  // Start with the root node
    $completedLevels = 0;
     

    while (!empty($currentLevelNodes)) {
        $nextLevelNodes = [];
        $levelNodeCount = count($currentLevelNodes);  // Get the number of nodes in the current level

        // Check if this level is complete
        if ($levelNodeCount != pow(2, $completedLevels)) {
            break;  // If the current level doesn't match the expected number of nodes, stop
        }

        // Initialize a flag to check if both children are present for all nodes
        $allChildrenComplete = true;
         
       // print_r($currentLevelNodes); die("ADfasdf");
        // Traverse through the nodes in the current level and get their children
        foreach ($currentLevelNodes as $nodeId) {
            // echo $nodeId;
            // echo "FFF";
            $children = DB::select("
                SELECT child_left, child_right 
                FROM usermlms 
                WHERE id = ? AND status = 1", 
                [$nodeId]
            );

            if (!empty($children)) {
                 $child_left = $children[0]->child_left;
                 $child_right = $children[0]->child_right;

                // print_r($children); die("ADfasdf");

                //if($child_left && $child_right){
                  $hasValidChildren = true; // Flag for the current node's children status
                // }else{
                //   $hasValidChildren = false; 
                // }

                // Check left child
                if (!is_null($child_left) && $child_left > 0) {
                    $left_child_status = DB::select("
                        SELECT status 
                        FROM usermlms 
                        WHERE id = ?", [$child_left]);

                    if (empty($left_child_status) || $left_child_status[0]->status != 1) {
                        $hasValidChildren = false; // Mark as invalid if the left child isn't active
                    } else {
                        $nextLevelNodes[] = $child_left; // Add valid left child to next level
                    }
                } else {
                    $hasValidChildren = false; // Mark as invalid if left child does not exist
                }

                // Check right child
                if (!is_null($child_right) && $child_right > 0) {
                    $right_child_status = DB::select("
                        SELECT status 
                        FROM usermlms 
                        WHERE id = ?", [$child_right]);

                    if (empty($right_child_status) || $right_child_status[0]->status != 1) {
                        $hasValidChildren = false; // Mark as invalid if the right child isn't active
                    } else {
                        $nextLevelNodes[] = $child_right; // Add valid right child to next level
                    }
                } else {
                    $hasValidChildren = false; // Mark as invalid if right child does not exist
                }

                // Check if both children are valid
                if (!$hasValidChildren) {
                    $allChildrenComplete = false; // If any node lacks valid children, break the level completion
                }
            }
            if ($allChildrenComplete) {
               
                echo "GGG-";
                $completedLevels++;
            }
        }

        // Increment completed levels only if all nodes had valid children
       

        // Update current level nodes for the next iteration
        $currentLevelNodes = $nextLevelNodes;
    }

    return $completedLevels;
}

public function updateUserDetails(Request $request, $user_id)
{
    // Fetch the user based on user_id
    $user = Usermlm::find($user_id);

    if (!$user) {
        return response()->json(['statusCode'=>0,'error' => 'User not found'], 200);
    }

    // Update the fields only if they are present in the request
    if ($request->has('name')) {
        $user->name = $request->input('name');
    }

    if ($request->has('mobile')) {
        $user->mobile = $request->input('mobile');
    }

    if ($request->has('email')) {
        $user->email = $request->input('email');
    }

    if ($request->has('whatsapp')) {
        $user->whatsapp = $request->input('whatsapp');
    }

    if ($request->has('pan')) {
        $user->pan = $request->input('pan');
    }

    if ($request->has('adhar')) {
        $user->adhar = $request->input('adhar');
    }

    if ($request->has('relation')) {
        $user->relation = $request->input('relation');
    }

    if ($request->has('relation_name')) {
        $user->relation_name = $request->input('relation_name');
    }

    if ($request->has('gender')) {
        $user->gender = $request->input('gender');
    }

    if ($request->has('dob')) {
        $user->dob = $request->input('dob');
    }

    if ($request->has('password')) {
        // Hash the password before storing
        $user->password = Hash::make($request->input('password'));
    }

    // Save the updated user data
    $user->save();

    return response()->json([
        'statusCode' => 1,
        'message' => 'User information updated successfully',
        'data' => $user
    ], 200);
}

public function findUpline($childId)
{
    $upline = []; // To store the upline hierarchy

    while ($childId) {
        // Fetch user details based on child ID
        $result = DB::select("SELECT id, name, parent_code FROM usermlms WHERE id = ?", [$childId]);

        if (empty($result)) {
            // Break the loop if no user is found
            break;
        }

        // Get the user's information
        $user = $result[0];

        // Add the user to the upline list
        $upline[] = [
            'id' => $user->id,
            'name' => $user->name,
            'parent_code' => $user->parent_code,
        ];

        // Update the childId to the parent_code of the current user
        $childId = $user->parent_code; // Assuming parent_code is the ID of the parent
    }

    return $upline; // Return the upline hierarchy
}

public function adminCheckPin(Request $request)
{
    // Validate the incoming request
    $request->validate([
        'pin_code' => 'required',
        'user_id' => 'required',   //childId
    ]);

     $uplines=$this->findUpline($request->user_id);
     $buyerIds = array_column($uplines, 'id');
    // Check if the PIN exists for the given user_id and that it hasn't been used
    $pin = Pin::where('pin', $request->pin_code)
        ->whereIn('buyer_id', $buyerIds) 
        ->first(); // Get the first matching record
    // Return a response based on the existence of the PIN
    if ($pin) {
        if ($pin->used_by === 0) { // Check if the PIN hasn't been used
            return response()->json(['statusCode' => 1, 'message' => 'PIN is valid and unused.'], 200);
        } else {
            return response()->json(['statusCode' => 0, 'message' => 'PIN is already use    d.'], 200);
        }
    } else {
        return response()->json(['statusCode' => 0, 'message' => 'PIN is invalid.'], 200);
    }
}




public function adminGeneratePins(Request $request)
{
    $request->validate([
        'numberOfPins' => 'required|integer|min:1',
        'generated_by' => 'required|integer',
        'buyer' => 'required|integer',
    ]);
    $numberOfPins = $request->numberOfPins;
    $generatedBy = $request->generated_by;
    $buyer = $request->buyer;
    $pinsData = [];
    $generatedCount = 0; // Counter for generated unique pins

    $buyer_id = Usermlm::find($buyer);

    if(!$buyer_id){
        return response()->json([
            'statusCode' => 0,
            'message' => "User does not exist.",
            'data' => null,
        ], 200); // You might want to change the status code as per your API design
    }


    while ($generatedCount < $numberOfPins) {
        do {
            // Generate a unique PIN code
            $pinCode = 'GGB' . strtoupper(Str::random(5));

            // Check if the PIN already exists in the database
            $exists = DB::table('pins')->where('pin', $pinCode)->exists();
        } while ($exists); // Repeat if the PIN already exists

        // If unique, add it to the pinsData array
        $pinsData[] = [
            'pin' => $pinCode,
            'buyer_id' => $buyer,
            'generated_by' => $generatedBy,
            'used_by'=>0,
            'created_at' => NOW(),
            'updated_at' => NOW()
        ];

        $generatedCount++; // Increment the count of successfully generated unique pins
    }
    
    DB::table('pins')->insert($pinsData);
    return response()->json(['statusCode'=>1,'message' => "$numberOfPins pins have been generated successfully.","data"=>$pinsData], 200);
}

public function adminDashboard(Request $request) {
    // Fetch total users
     $today = Carbon::today()->toDateString();
    //die("ASDFA");

    $totalUsers = DB::table('usermlms')->count();
    $todayUsers = DB::select("SELECT COUNT(*) as sums FROM usermlms WHERE DATE(created_at) = ?", [$today]);


    // Fetch total active users
    $totalActive = DB::table('usermlms')->where('status', 1)->count();
    $todayActive = DB::select("SELECT COUNT(*) as sums FROM usermlms WHERE status = 1 AND DATE(created_at) = ?", [$today]);

    // Fetch total inactive users
    $totalInactive = DB::table('usermlms')->where('status', 0)->count();
    $todayInactive = DB::select("SELECT COUNT(*) as sums FROM usermlms WHERE status = 0 AND DATE(created_at) = ?", [$today]);

    // Fetch total business (sum of all payments' amount)
    $totalBusiness = DB::table('payments')->where('status', 1)->sum('amount');
    $todayBusiness = DB::select("SELECT SUM(amount) as sums FROM payments WHERE status = 1 AND DATE(created_at) = ?", [$today]);

    // Fetch total commissions (sum of all commissions' amount)
    $totalComm = DB::table('commissions')->sum('payable_amount');
    //$todayComm = DB::table('commissions')->sum('payable_amount')->whereDate('created_at5', Carbon::today())->count();
    $todayComm = DB::select("SELECT SUM(payable_amount) as sums FROM commissions WHERE DATE(created_at) = '$today'");

    $totalCommUnpaid = DB::table('commissions')->where('status', 1)->sum('payable_amount');
    $todayCommUnpaid = DB::select("SELECT SUM(payable_amount) as sums FROM commissions WHERE status = 1 AND DATE(created_at) = ?", [$today]);

    $totalCommPaid = DB::table('commissions')->where('status', 2)->sum('payable_amount');
    $todayCommPaid = DB::select("SELECT SUM(payable_amount) as sums FROM commissions WHERE status = 2 AND DATE(created_at) = ?", [$today]);

    $totalkitRequest = DB::table('payments')->count();
    $todaykitRequest = DB::table('payments')->whereDate('created_at', Carbon::today())->count();
    //$todaykitRequest =0;

    // Prepare data for the dashboard
    $ds = [];
    $ds['totalUser'] = $totalUsers-1 ?? 0;  //for admin
    $ds['todayUser'] = $todayUsers[0]->sums?? 0;  //for admin

    $ds['totalActive'] = $totalActive?? 0;  
    $ds['todayActive'] =  $todayActive[0]->sums?? 0;  

    $ds['totalInactive'] = $totalInactive?? 0;  
    $ds['todayInactive'] = $todayInactive[0]->sums?? 0;  

    $ds['totalBusiness'] = $totalBusiness?? 0;  
    $ds['todayBusiness'] = $todayBusiness[0]->sums?? 0;  

    $ds['totalComm'] = $totalComm?? 0;  
    $ds['todayComm'] = $todayComm[0]->sums?? 0;  

    $ds['totalCommPaid'] = $totalCommPaid?? 0;  
    $ds['todayCommPaid'] = $todayCommPaid[0]->sums??0;  // $todayComm[0]->sums;

    $ds['totalCommUnpaid'] = $totalCommUnpaid?? 0;  
    $ds['todayCommUnpaid'] = $todayCommUnpaid[0]->sums?? 0;   

    $ds['totalkitRequest'] = $totalkitRequest?? 0;  
    $ds['todaykitRequest'] = $todaykitRequest?? 0;  

    return response()->json([
        'statusCode' => 1,
        'data'=>$ds
    ], 200); 
}

public function dashboard(Request $request){

    // $request->validate([
    //     'user_id' => 'required'        
    // ]);

    // if ($validator->fails()) {
    //     return response()->json(['error' => 'Validation failed', 'message' => $validator->errors()], 200);
    // }


    $validator = Validator::make($request->all(), [
        'user_id' => 'required'
    ]);

    // Check if validation fails
    if ($validator->fails()) {
        return response()->json(['statusCode' => 0,'error' => 'Validation failed', 'message' => $validator->errors()], 200);
    }

   
    $users = Usermlm::select('usermlms.name', 'usermlms.id', 'usermlms.child_left', 'usermlms.child_right', 'usermlms.self_code', 'usermlms.parent_code', 'usermlms.status')
    ->join('payments', 'payments.user_id', '=', 'usermlms.id')
    ->where('usermlms.id', $request->user_id)
    ->where('payments.status', 1)
    ->get();

    if ($users->isEmpty()) {
        // return response()->json(['statusCode'=>0,'message' => 'No users found with active payments.','data'=>$request->user_id], 200);
        $users = Usermlm::select('name', 'id', 'child_left', 'child_right', 'self_code', 'parent_code', 'status')
            ->where('id', $request->user_id)
            ->get();
    }

   
   
    $LDownline['status_0']=[];
    $LDownline['status_1']=[];

    $LDownline1['status_0']=[];
    $LDownline1['status_1']=[];


    $RDownline['status_0']=[];
    $RDownline['status_1']=[];


    $RDownline1['status_0']=[];
    $RDownline1['status_1']=[];


    if($users[0]->child_left){
        $LDownline = $this->MyDown($users[0]->child_left); 
        $LDownline1 = $this->MyDownStatus1($users[0]->child_left); 

        $LDownlineToday = $this->MyDownToday($users[0]->child_left); 
        $LDownline1Today = $this->MyDownStatus1Today($users[0]->child_left); 
    }
    if($users[0]->child_right){
        $RDownline = $this->MyDown($users[0]->child_right);
        $RDownline1 = $this->MyDownStatus1($users[0]->child_right);
        $RDownlineToday = $this->MyDownToday($users[0]->child_right);
        $RDownline1Today = $this->MyDownStatus1Today($users[0]->child_right);
    }


    
  // Initialize the total team, left side, right side, and inactive counts
  $totalTeam=(empty($LDownline['status_0']) ? 0 : count($LDownline['status_0'])) +
  (empty($LDownline['status_1']) ? 0 : count($LDownline['status_1'])) +
  (empty($RDownline['status_0']) ? 0 : count($RDownline['status_0'])) +
  (empty($RDownline['status_1']) ? 0 : count($RDownline['status_1']));

  $totalTeamToday=(empty($LDownlineToday['status_0']) ? 0 : count($LDownlineToday['status_0'])) +
  (empty($LDownlineToday['status_1']) ? 0 : count($LDownlineToday['status_1'])) +
  (empty($RDownlineToday['status_0']) ? 0 : count($RDownlineToday['status_0'])) +
  (empty($RDownlineToday['status_1']) ? 0 : count($RDownlineToday['status_1']));


  

$rsm['today_total_team']=$totalTeamToday;
$rsm['today_active_left_side']=empty($LDownlineToday['status_1']) ? 0 : count($LDownlineToday['status_1']);
$rsm['today_active_right_side']=empty($RDownlineToday['status_1']) ? 0 : count($RDownlineToday['status_1']);




$rsm['total_team'] =$totalTeam;

$rsm['active_left_side'] = empty($LDownline['status_1']) ? 0 : count($LDownline['status_1']);
$rsm['active_right_side'] = empty($RDownline['status_1']) ? 0 : count($RDownline['status_1']);
 
$rsm['active'] = (empty($LDownline1['status_1']) ? 0 : count($LDownline1['status_1'])) +
                 (empty($RDownline1['status_1']) ? 0 : count($RDownline1['status_1']));
$rsm['inactive'] = $totalTeam - ((empty($LDownline1['status_1']) ? 0 : count($LDownline1['status_1'])) +
                 (empty($RDownline1['status_1']) ? 0 : count($RDownline1['status_1'])));


$rsm['today_active']=(empty($LDownline1Today['status_1']) ? 0 : count($LDownline1Today['status_1'])) +
(empty($RDownline1Today['status_1']) ? 0 : count($RDownline1Today['status_1']));
$rsm['today_inactive']= $totalTeamToday - ((empty($LDownline1Today['status_1']) ? 0 : count($LDownline1Today['status_1'])) +
(empty($RDownline1Today['status_1']) ? 0 : count($RDownline1Today['status_1'])));

// Assuming $totalUsers is an array of user IDs, you need to join them into a comma-separated string
$totalUsers = implode(',', array_merge($LDownline['status_1'], $RDownline['status_1']));
    // Base query
        $query = "SELECT 
        usermlms.id AS userId,
        payments.id AS payId,
        payments.amount AS pamount,
        usermlms.status AS userStatus, 
        payments.status AS payStatus 
        FROM 
        payments
        JOIN 
        usermlms ON payments.user_id = usermlms.id";

        // Add conditions based on `$totalUsers`
        $conditions = [];
        if (!empty($totalUsers)) {
        $conditions[] = "usermlms.id IN ($totalUsers)";
        }
        $conditions[] = "payments.status = 1";

        // Append conditions if any exist
        if (!empty($conditions)) {
        $query .= " WHERE " . implode(" AND ", $conditions);
        }

        // Execute the query and calculate the total business
        $results = DB::select($query);
        $rsm['total_business'] = array_sum(array_column($results, 'pamount'));
        
        $rsm['total_businessToday'] = array_sum(array_column($results, 'pamount'));

    $rs = DB::select("SELECT * FROM commissions WHERE user_id = $request->user_id");
    $total_paid = [];
    $total_unpaid = [];

    // Loop through each commission record
    foreach ($rs as $record) {
        // Check the status and categorize commissions
        if ($record->status == 1) {
            $total_unpaid[] = $record->level_commission; // Collect paid commissions
        } else if ($record->status == 2) {
            $total_paid[] = $record->level_commission; // Collect unpaid commissions
        }
    }

    // Calculate total paid and unpaid commissions separately
    $total_paid_amount = array_sum($total_paid); // Total of paid commissions
    $total_unpaid_amount = array_sum($total_unpaid); // Total of unpaid commissions

    // Calculate overall total
    $totalcomm = $total_paid_amount + $total_unpaid_amount;

    $rsm['total']=$totalcomm;
    $rsm['paid']=$total_paid_amount;
    $rsm['unpaid']=$total_unpaid_amount;

    $rsm['today_total']=0;
    $rsm['today_paid']=0;
    $rsm['today_unpaid']=0;

    return response()->json([
        'statusCode' => 1,
        'data'=>$rsm,
        'users'=>$users[0]      
    ], 200); 
}


public function dashboard22(Request $request){

    $request->validate([
        'user_id' => 'required'        
    ]);

    // $users = Usermlm::select('name', 'id', 'child_left', 'child_right', 'self_code', 'parent_code', 'status')
    // ->where('id', $request->user_id)
    // ->get();
    $users = Usermlm::select('usermlms.name', 'usermlms.id', 'usermlms.child_left', 'usermlms.child_right', 'usermlms.self_code', 'usermlms.parent_code', 'usermlms.status')
    ->join('payments', 'payments.user_id', '=', 'usermlms.id')
    ->where('usermlms.id', $request->user_id)
    ->where('payments.status', 1)
    ->get();

    if ($users->isEmpty()) {
        return response()->json(['statusCode'=>0,'message' => 'No users found with active payments.','data'=>$request->user_id], 200);
    }

    $LDownline = $this->MyDown($users[0]->child_left); 
    $RDownline = $this->MyDown($users[0]->child_right);
    
  // Initialize the total team, left side, right side, and inactive counts
$rsm['total_team'] = (empty($LDownline['status_0']) ? 0 : count($LDownline['status_0'])) +
                    (empty($LDownline['status_1']) ? 0 : count($LDownline['status_1'])) +
                    (empty($RDownline['status_0']) ? 0 : count($RDownline['status_0'])) +
                    (empty($RDownline['status_1']) ? 0 : count($RDownline['status_1']));

$rsm['active_left_side'] = empty($LDownline['status_1']) ? 0 : count($LDownline['status_1']);
$rsm['active_right_side'] = empty($RDownline['status_1']) ? 0 : count($RDownline['status_1']);
$rsm['inactive_left_side'] = empty($LDownline['status_0']) ? 0 : count($LDownline['status_0']);
$rsm['inactive_right_side'] = empty($RDownline['status_0']) ? 0 : count($RDownline['status_0']);
$rsm['active'] = (empty($LDownline['status_1']) ? 0 : count($LDownline['status_1'])) +
(empty($RDownline['status_1']) ? 0 : count($RDownline['status_1']));
$rsm['inactive'] = (empty($LDownline['status_0']) ? 0 : count($LDownline['status_0'])) +
(empty($RDownline['status_0']) ? 0 : count($RDownline['status_0']));

// Assuming $totalUsers is an array of user IDs, you need to join them into a comma-separated string
$totalUsers = implode(',', array_merge($LDownline['status_1'], $RDownline['status_1']));
    $query = "SELECT 
        usermlms.id AS userId,
        payments.id AS payId,
        payments.amount AS pamount,
        usermlms.status AS userStatus, 
        payments.status AS payStatus 
    FROM 
        payments
    JOIN 
        usermlms ON payments.user_id = usermlms.id
    WHERE 
        usermlms.id IN ($totalUsers) 
        AND payments.status = 1";
    $results = DB::select($query);
   // $rsm['total_business']=$results;
    $rsm['total_business'] = array_sum(array_column($results, 'pamount'));

    // $rsm['inactive ']=$total_unpaid_amount;

    // $rsm['total_business']=$total_unpaid_amount;
    // $rsm['myTotalCommission']=$total_unpaid_amount;
    // $rsm['myPendingCommission']=$total_unpaid_amount;
    // $rsm['myPaidCommission']=$total_unpaid_amount;

    return response()->json([
        'statusCode' => 1,
        'data'=>$rsm,
        'users'=>$users      
    ], 200); 
}



public function MyDown($parent_code) {
    // Arrays to hold child IDs for each status
    $results_status_0 = [];
    $results_status_1 = [];

    // Initialize the stack with the given parent code
    $stack = [$parent_code];

    while (!empty($stack)) {
        // Pop the last parent from the stack
        $current_parent = array_pop($stack);
        // Fetch the children details from the database

        $children = DB::select("SELECT child_left, child_right, status FROM usermlms WHERE id = ?", [$current_parent]);

        // $children = DB::select("SELECT 
        //     usermlms.child_left, 
        //     usermlms.child_right, 
        //     usermlms.status, 
        //     payments.status AS payment_status 
        // FROM 
        //     usermlms
        // LEFT JOIN 
        //     payments ON payments.user_id = usermlms.id
        // WHERE 
        //     usermlms.id = $current_parent and payments.status=1");

        // Check if children were found
        if (!empty($children)) {
            // Get child IDs and current status
            $child_left = $children[0]->child_left;
            $child_right = $children[0]->child_right;
            $current_status = $children[0]->status; 

            // Add the current parent to the respective results based on its status
            if ($current_status == 0) {
                $results_status_0[] = $current_parent; // Add to status 0 array
            } else if ($current_status == 1) {
                $results_status_1[] = $current_parent; // Add to status 1 array
            }

            // Add children to the stack for further processing
            if (!is_null($child_right) && $child_right > 0) {
                $stack[] = $child_right;
            }
            if (!is_null($child_left) && $child_left > 0) {
                $stack[] = $child_left;
            }
        }
    }

    // Return both arrays as part of an associative array
    return [
        'status_0' => $results_status_0,
        'status_1' => $results_status_1,
    ];
}




public function MyDownToday($parent_code) {
    // Arrays to hold child IDs for each status
    $results_status_0 = [];
    $results_status_1 = [];

    // Initialize the stack with the given parent code
    $stack = [$parent_code];

    while (!empty($stack)) {
        // Pop the last parent from the stack
        $current_parent = array_pop($stack);
        // Fetch the children details from the database

        $children = DB::select("SELECT child_left, child_right, status FROM usermlms WHERE id = ? AND DATE(created_at) = CURDATE()", [$current_parent]);

        // $children = DB::select("SELECT 
        //     usermlms.child_left, 
        //     usermlms.child_right, 
        //     usermlms.status, 
        //     payments.status AS payment_status 
        // FROM 
        //     usermlms
        // LEFT JOIN 
        //     payments ON payments.user_id = usermlms.id
        // WHERE 
        //     usermlms.id = $current_parent and payments.status=1");

        // Check if children were found
        if (!empty($children)) {
            // Get child IDs and current status
            $child_left = $children[0]->child_left;
            $child_right = $children[0]->child_right;
            $current_status = $children[0]->status; 

            // Add the current parent to the respective results based on its status
            if ($current_status == 0) {
                $results_status_0[] = $current_parent; // Add to status 0 array
            } else if ($current_status == 1) {
                $results_status_1[] = $current_parent; // Add to status 1 array
            }

            // Add children to the stack for further processing
            if (!is_null($child_right) && $child_right > 0) {
                $stack[] = $child_right;
            }
            if (!is_null($child_left) && $child_left > 0) {
                $stack[] = $child_left;
            }
        }
    }

    // Return both arrays as part of an associative array
    return [
        'status_0' => $results_status_0,
        'status_1' => $results_status_1,
    ];
}


public function MyDownStatus1($parent_code) {
    // Arrays to hold child IDs for each status
    $results_status_0 = [];
    $results_status_1 = [];

    // Initialize the stack with the given parent code
    $stack = [$parent_code];

    while (!empty($stack)) {
        // Pop the last parent from the stack
        $current_parent = array_pop($stack);
        // Fetch the children details from the database

        //$children = DB::select("SELECT child_left, child_right, status FROM usermlms WHERE id = ?", [$current_parent]);

        $children = DB::select("SELECT 
            usermlms.child_left, 
            usermlms.child_right, 
            usermlms.status, 
            payments.status AS payment_status 
        FROM 
            usermlms
        LEFT JOIN 
            payments ON payments.user_id = usermlms.id
        WHERE 
            usermlms.id = $current_parent and payments.status=1");

        // Check if children were found
        if (!empty($children)) {
            // Get child IDs and current status
            $child_left = $children[0]->child_left;
            $child_right = $children[0]->child_right;
            $current_status = $children[0]->status; 

            // Add the current parent to the respective results based on its status
            if ($current_status == 0) {
                $results_status_0[] = $current_parent; // Add to status 0 array
            } else if ($current_status == 1) {
                $results_status_1[] = $current_parent; // Add to status 1 array
            }

            // Add children to the stack for further processing
            if (!is_null($child_right) && $child_right > 0) {
                $stack[] = $child_right;
            }
            if (!is_null($child_left) && $child_left > 0) {
                $stack[] = $child_left;
            }
        }
    }

    // Return both arrays as part of an associative array
    return [
        'status_0' => $results_status_0,
        'status_1' => $results_status_1,
    ];
}



public function MyDownStatus1Today($parent_code) {
    // Arrays to hold child IDs for each status
    $results_status_0 = [];
    $results_status_1 = [];

    // Initialize the stack with the given parent code
    $stack = [$parent_code];

    while (!empty($stack)) {
        // Pop the last parent from the stack
        $current_parent = array_pop($stack);
        // Fetch the children details from the database

        //$children = DB::select("SELECT child_left, child_right, status FROM usermlms WHERE id = ?", [$current_parent]);

        $children = DB::select("SELECT 
            usermlms.child_left, 
            usermlms.child_right, 
            usermlms.status, 
            payments.status AS payment_status 
        FROM 
            usermlms
        LEFT JOIN 
            payments ON payments.user_id = usermlms.id
        WHERE 
            usermlms.id = $current_parent and payments.status=1 AND DATE(payments.created_at) = CURDATE()");

        // Check if children were found
        if (!empty($children)) {
            // Get child IDs and current status
            $child_left = $children[0]->child_left;
            $child_right = $children[0]->child_right;
            $current_status = $children[0]->status; 

            // Add the current parent to the respective results based on its status
            if ($current_status == 0) {
                $results_status_0[] = $current_parent; // Add to status 0 array
            } else if ($current_status == 1) {
                $results_status_1[] = $current_parent; // Add to status 1 array
            }

            // Add children to the stack for further processing
            if (!is_null($child_right) && $child_right > 0) {
                $stack[] = $child_right;
            }
            if (!is_null($child_left) && $child_left > 0) {
                $stack[] = $child_left;
            }
        }
    }

    // Return both arrays as part of an associative array
    return [
        'status_0' => $results_status_0,
        'status_1' => $results_status_1,
    ];
}


public function adminGetPins(Request $request)
{

    $request->validate([
        'buyer_id' => 'required|integer',
    ]);

    $buyerId = $request->buyer_id; // Get buyer_id from the request


    // Perform a raw SQL join query to get pins with user information
    $pins = DB::table('pins')
        ->leftJoin('usermlms', 'pins.used_by', '=', 'usermlms.id') // Join on the used_by column
        ->select(
            'pins.id',
            'pins.buyer_id',
            'pins.created_at',
            'pins.generated_by',
            'pins.pin',
            'pins.updated_at',
            'usermlms.name as user_name',      // Select user name
            'usermlms.self_code as user_code'  // Select user self_code
        )
        ->where('pins.buyer_id', $buyerId) // Filter by buyer_id
        ->get();

    // Map the results to include used_by field structure
    $pins = $pins->map(function ($pin) {
        return [
            'id' => $pin->id,
            'buyer_id' => $pin->buyer_id,
            'created_at' => $pin->created_at,
            'generated_by' => $pin->generated_by,
            'pin' => $pin->pin,
            'updated_at' => $pin->updated_at,
            'used_by_name' => $pin->user_name??0,
            'used_by_self_code' => $pin->user_code??0
        ];
    });

    // Return the pins as a JSON response
    return response()->json([
        'statusCode' => 1,
        'data' => $pins,
        'message' => 'Pins retrieved successfully!'
    ], 200); // 200 OK
}


public function adminGenAmountPin(Request $request)
{
    // Validate the incoming request
    $request->validate([
        'numberOfPins' => 'required|integer|min:1', // Ensure it's a positive integer
    ]);

    // Get the number of pins from the request
    $numberOfPins = $request->input('numberOfPins');

    // Fetch the amount from the kit_amounts table where status is 1
    $amount = DB::table('kit_amounts')
                ->where('status', 1)
                ->value('amount'); // This will return the first row's amount

    // Check if amount was found
    if ($amount === null) {
        return response()->json([
            'statusCode' => 0,
            'message' => 'No active amounts found.',
            'data' => null,
        ], 200);
    }

    // Calculate the total amount
    $totalAmount = $numberOfPins * $amount;

    // Return the total amount in a JSON response
    return response()->json([
        'statusCode' => 1,
        'message' => 'Total amount calculated successfully.',
        'totalAmount' => $totalAmount,
    ], 200);
}


public function myChild(Request $request) {
    // Validate the incoming request
    $validator = Validator::make($request->all(), [
        'id' => 'required|integer'
    ]);

    // Return validation errors if any
    if ($validator->fails()) {
        return response()->json(['statusCode' => 0, 'message' => 'Validation failed', 'errors' => $validator->errors()], 400);
    }

  $parent_code = $request->id;

    $RDownline=$this->LeftDownline($request->id);

    // Initialize results arrays
    $right_results = [];
    $left_results = [];
    $LDownline = 0;
    
    // Loop to find right children
    do {
        // Use parameter binding to prevent SQL injection
        $get = DB::select("SELECT child_right FROM usermlms WHERE id = ?", [$parent_code]);
        
        if (!empty($get)) {
            $child_right = $get[0]->child_right;

            if ($child_right !== null && $child_right > 0) {
                // Fetch additional details about the right child
                $userDetails = DB::select("SELECT id, name, self_code, status, mobile FROM usermlms WHERE id = ?", [$child_right]);

                // Ensure userDetails is not empty before accessing
                if (!empty($userDetails)) {
                    // Add user details to the right results array
                    $right_results[] = [
                        'child_right' => $child_right,
                        'user_details' => $userDetails[0] // Assuming you want the first result
                    ];
                }

                // Update the parent_code for the next iteration
                $parent_code = $child_right; 
            } else {
                // If child_right is null or not greater than 0, exit the loop
                break;
            }
        } else {
            // If no records found, exit the loop
            break;
        }
    } while (true);

    // Reset parent_code to the original ID for left child retrieval
    $parent_code = $request->id;

    // Loop to find left children
    do {
        // Use parameter binding to prevent SQL injection
        $get = DB::select("SELECT child_left FROM usermlms WHERE id = ?", [$parent_code]);
        
        if (!empty($get)) {
            $child_left = $get[0]->child_left;

            if ($child_left !== null && $child_left > 0) {
                // Fetch additional details about the left child
                $userDetails = DB::select("SELECT id, name, self_code, status, mobile FROM usermlms WHERE id = ?", [$child_left]);

                // Ensure userDetails is not empty before accessing
                if (!empty($userDetails)) {
                    // Add user details to the left results array
                    $left_results[] = [
                        'child_left' => $child_left,
                        'user_details' => $userDetails[0] // Assuming you want the first result
                    ];
                }

                // Update the parent_code for the next iteration
                $parent_code = $child_left; 
            } else {
                // If child_left is null or not greater than 0, exit the loop
                break;
            }
        } else {
            // If no records found, exit the loop
            break;
        }
    } while (true);

    // Return the results in the response
    return response()->json([
        'statusCode' => 1,
        'message' => 'Tree successfully retrieved',
        'left_child' => $left_results,
        'right_child' => $right_results,
        'rightCh'=>$RDownline,
    ], 200);
}






}
