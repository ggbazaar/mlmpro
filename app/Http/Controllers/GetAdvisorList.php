<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usermlm;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class GetAdvisorList extends Controller
{

    public function find(Request $request)
    {
        $user = auth()->guard('api')->user();
        print_r($user);
        die("A1Sdf");

        $request->validate([
            'id' => 'required',
        ]);
        $req = $request->only(['id']);
        

        $user = Usermlm::where('id', $req['id'])->first();
        //  $request->user()->token()->revoke();
        $req1 = json_decode($request->getContent());
       // print_r($req1);
        $user1 = auth()->guard('api')->user();
       // print_r($user1);
      //  die("ADfa");


        $getBinaryTreeStructureJson=$this->getBinaryTreeStructureJson($user->id);

      // print_r($getBinaryTreeStructureJson);


      

 
        //die("ASdfas");

       //
        return response()->json([
            'statusCode' => 1,
            'data'=>$getBinaryTreeStructureJson,
            'message' => 'Successfully getadvisorlist fetch out'
        ]);
    }



    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'statusCode' => 0,
            'message' => 'Successfully logged out'
        ]);
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

        // print_r($credentials);  
        // die("ADASDD");

        // Find the user by their contact (or email)
        $user = Usermlm::where('email', $credentials['mobile'])
                        ->orWhere('mobile', $credentials['mobile'])
                        ->first();

        // print_r($user);  
        // die("ADASDD");

        // Check if the user exists and if the password is correct
        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            throw new Exception("Invalid Credentials");
        }

        // Create token
        $tokenResult = $user->createToken('Personal Access Token');
        $accessToken = $tokenResult->plainTextToken; // for Sanctum
        // $accessToken = $tokenResult->accessToken;  // for Passport

        return response()->json([
            'message' => 'Login successful',
            'user' => $user,
            'access_token' => [
                'full'=>$tokenResult,
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
            'error' => $e->getMessage()
        ], 401);
    }
}




    public function signin22BBNNMM(Request $request)
    {
        $customErr = "";
        try {
            $request->validate([
                'email' => 'required|string',
                'password' => 'required|string',
                'remember_me' => 'boolean'
            ]);
            $credentials = request(['email', 'password']);

            // if (!Auth::attempt($credentials))
            //     throw new Exception("Invalid Credentials");

            $det = Usermlm::where('contact', $credentials)->first();

            $user = $request->user();
            $tokenResult = $user->createToken('Personal Access Token');
            $token = $tokenResult->token;

            if ($request->remember_me)
                $token->expires_at = Carbon::now()->addWeeks(1);

            $token->save();
           
            $det = [
                'access_token' => $tokenResult->accessToken,
                'token_type' => 'Bearer',
                'expires_at' => Carbon::parse(
                    $tokenResult->token->expires_at
                )->toDateTimeString(),
                'name' => $user->name,
                'email' => $user->email,
                'type' => $user->user_type,
                'contact' => $user->contact_number
            ];
            return response()->json(["statusCode" => 0, "message" => "Success", "data" => $det], 200);
        } catch (Exception $e) {
            return response()->json(["statusCode" => 1, "message" => "Error", "err" => $e->getMessage()], 200);
        }
    }



    public function signin2233333(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'emailOrMobile' => 'required|string', // Change 'email' to 'identifier'
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);
    
        // Determine whether the identifier is an email or mobile
        $identifier = $request->input('emailOrMobile');
        $fieldType = filter_var($identifier, FILTER_VALIDATE_EMAIL) ? 'email' : 'mobile';
    
        // Prepare credentials for authentication
        $credentials = [$fieldType => $identifier, 'password' => $request->password];

        // print_r($credentials);
        // die("ASDfa");
    
        // // Attempt to authenticate the user
        // if (!Auth::attempt($credentials)) {
        //     throw new Exception("Invalid Credentials");
        // }
    
        // Retrieve the authenticated user
        // $user = Auth::user();

        // print_r($user);
        // die("ASFASDF");

    
        // Create a token for the authenticated user
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
    
        // Set token expiration if remember me is checked
        if ($request->remember_me) {
            $token->expires_at = Carbon::now()->addWeeks(1);
        }
    
        $token->save();
    
        // Initialize additional counters or variables as needed
        $counterslogin = [];
        $idWarehouse = 0;
    
        // Return the success response
        return response()->json([
            'message' => 'Login successful',
            'user' => $user,
            'token' => $token->plainTextToken, // Return the token
        ], 200);
    }



    public function signin333(Request $request)
    {
        $customErr = "";
        try {
            $request->validate([
                'email' => 'required|string|email',
                'password' => 'required|string',
                'remember_me' => 'boolean'
            ]);
            $credentials = request(['email', 'password']);

            if (!Auth::attempt($credentials))
                throw new Exception("Invalid Credentials");

            $user = $request->user();
            $tokenResult = $user->createToken('Personal Access Token');
            $token = $tokenResult->token;

            if ($request->remember_me)
                $token->expires_at = Carbon::now()->addWeeks(1);

            $token->save();
            $counterslogin = [];
            $idWarehouse = 0;
            $aLvlStore = 1;
            $SWname = '';
            $address = '';
            $city = '';
            $pin = '';
            $contact = '';
            
            $det = [
                'access_token' => $tokenResult->accessToken,
                'token_type' => 'Bearer',
                'expires_at' => Carbon::parse(
                    $tokenResult->token->expires_at
                )->toDateTimeString(),
                'name' => $user->name,
                'email' => $user->email,
                'type' => $user->user_type,
                'contact' => $user->contact_number,
                'counter_detail' => $counterslogin,
                'is_store' => $aLvlStore,
                'idwarehouse' => $idWarehouse,
                'sw_name' => $SWname,
                'sw_address' => $address,
                'sw_city' => $city,
                'sw_state' => $state ?? '',
                'sw_pin' => $pin,
                'sw_contact' => $contact,

            ];
            return response()->json(["statusCode" => 0, "message" => "Success", "data" => $det], 200);
        } catch (Exception $e) {
            return response()->json(["statusCode" => 1, "message" => "Error", "err" => $e->getMessage()], 200);
        }
    }



    public function signin22(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'email_or_mobile' => 'required',
            'password' => 'required',
        ]);

        // Check whether the input is an email or mobile
        $fieldType = filter_var($request->email_or_mobile, FILTER_VALIDATE_EMAIL) ? 'email' : 'mobile';

        // Retrieve the user using email or mobile
        $user = Usermlm::where($fieldType, $request->email_or_mobile)->first();

       if ($user && Hash::check($request->password, $user->password)) {
            // Create a token for the user
            $token = $user->createToken('API Token')->plainTextToken;

            return response()->json([
                'message' => 'Login successful',
                'token' => $token,
                'user' => $user
            ], 200);
        }

        // Invalid login attempt
        return response()->json([
            'message' => 'Invalid credentials'
        ], 401);
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

      return response()->json(['message' => 'Tree successfully', 'PairMatches' => $PairMatches,'CompleteLevels'=> $CompleteLevels,"RDownline"=>$RDownline,"RUpline"=>$RUpline,"LDownline"=>$LDownline,"LUpline"=>$LUpline,"getAllDescendants"=>$getAllDescendants,"getBinaryTreeStructureJson"=>$getBinaryTreeStructureJson], 201);
    }

    public function store(Request $request)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255'
        //     'mobile' => 'required|string|max:15',
        //     'email' => 'required|email|max:255|unique:users',
        //     'whatsapp' => 'required|string|max:15',
        //     'pan' => 'required|string|max:10',
        //     'adhar' => 'required|string|max:12',
        //     'relation' => 'required|string|max:255',
        //     'relation_name' => 'required|string|max:255',
        //     'gender' => 'required|string|in:male,female,other',
        //     'dob' => 'required|date',
        //     'referral_code' => 'nullable|string|max:255',
        //     'used_code' => 'required',
        //     'status' => 'required',
        //     'password' => 'required|string|min:8', // password confirmation rule
        //     'level' => 'required|integer',
        //     'added_below'=>'required'
        ]);


       

        // 'password' => 'required|string|min:8|confirmed', // password confirmation rule

        // Handle validation failure
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $lastUser = Usermlm::latest('id')->first();
        $id = $lastUser ? $lastUser->id + 1 : 1;

        if($request->side==null){
            $request->side=1;
          //  die("ASDFA");
        }

        // Create the user
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
            'referral_code' => "GGB" . $id . "2024",
            'used_code' => $request->used_code,
            'side' => $request->side,
            'status' => 0,
            'password' =>Hash::make($request->password), // Password encryption
            'level' => $request->level,
            'added_below' => $request->added_below,
        ]);

       $Tuser = Usermlm::latest('id')->first();
       $get = DB::select("SELECT * FROM usermlms WHERE id = $request->parent_code");
       $pr=$get[0];
       $uid=$usermlm->id;

     
        // Example tree
        $tree5 = [
            1,  // Root node
            [   // Left subtree of root
                2, 
                [4,  // Left subtree of node 2
                    [8, [16, null, null], [17, null, null]],  // Left subtree of node 4
                    [9, [18, null, null], [19, null, null]]   // Right subtree of node 4
                ], 
                [5,  // Right subtree of node 2
                    [10, [20, null, null], [21, null, null]],  // Left subtree of node 5
                    [11, [22, null, null], [23, null, null]]   // Right subtree of node 5
                ]
            ],
            [   // Right subtree of root
                3, 
                [6,  // Left subtree of node 3
                    [12, [24, null, null], [25, null, null]],  // Left subtree of node 6
                    [13, [26, null, null], [27, null, null]]   // Right subtree of node 6
                ], 
                [7,  // Right subtree of node 3
                    [14, [28, null, null], [29, null, null]],  // Left subtree of node 7
                    [15, [30, null, null], [31, null, null]]   // Right subtree of node 7
                ]
            ]
        ];

// Output the result
        //echo $this->checkCompleteLevels($tree5);

        

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
           // $levelg=$this->getTreeDepth($usermlm->id);

        }else{
            $Downline=$this->RightDownline($request->parent_code);
            $Upline= $this->RightUpline($request->parent_code);
            $results_string = $Downline.",".$Upline;
            DB::update("UPDATE usermlms SET last_right = $usermlm->id WHERE id in($results_string)");

            //DB::update("UPDATE usermlms SET last_right = $usermlm->id WHERE id = $request->parent_code");
            if($pr->child_right==''){
              DB::update("UPDATE usermlms SET child_right = $usermlm->id WHERE id = $request->parent_code");
            }else{
              DB::update("UPDATE usermlms SET child_right = $usermlm->id WHERE id = $pr->last_right");
            }
           // $levelg=$this->getTreeDepth($usermlm->id);
        }
       
        return response()->json(['message' => 'User created successfully', 'user' => $usermlm,'Downline'=> $Downline,'Upline'=>$Upline], 201);
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
        $children = DB::select("SELECT id, child_left,child_right,mobile,name,referral_code FROM usermlms WHERE id = ?", [$nodeId]);

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
            $currentLevel[] = [
                'id' => $node->id,
                'left' => $node->child_left,
                'right' => $node->child_right,
                'referral_code'=>$node->referral_code,
                'name'=> $node->name,
                'mobile'=> $node->mobile,
                'empty'=>$empt,
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







}
