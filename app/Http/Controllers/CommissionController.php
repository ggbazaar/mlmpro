<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usermlm;
use App\Models\Payment;
use App\Models\Kitamount;
use App\Models\Commission;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CommissionController extends Controller
{


    public function generateLevel(Request $request)
    {
        $user = auth()->guard('api')->user();
        // if(!$user){
        //     return response()->json([
        //         "statusCode"=> 1,
        //         'error' => "Unauthorized User"
        //     ], 401);

        // }
        $userIds = Usermlm::where('status', 1)->pluck('id'); // Assuming 'id' is the primary key
        $insertedCount = 0; 
        foreach ($userIds as $userId) {
            $completeLevels = $this->checkCompleteLevels1Status($userId) - 1; // Calculate complete levels
            if ($completeLevels >= 0 && $completeLevels <=6 ) {
                DB::table('usermlms')
                    ->where('id', $userId)
                    ->where('status', 1) // Only update users with status = 1
                    ->update(['level' => $completeLevels]); // Update the level
                $totalAmount = 300; //$completeLevels * 300;
                $serviceCharge = $totalAmount * 0.10; // 10% of total amount
                $payableAmount = $totalAmount - $serviceCharge; // Subtract service charge from total amount
                if ($userId && $completeLevels) {
                    $existingCommission = DB::table('commissions')
                        ->where('user_id', $userId)
                        ->where('level', $completeLevels)
                        ->first();
                    if (!$existingCommission) {
                        $result=DB::table('commissions')->insert([
                            'user_id' => $userId,
                            'purchase_id' => $request->pay_id ?? "11", // Default to "11" if pay_id is not provided
                            'level' => $completeLevels, // Assuming 'level' is a field in the commissions table
                            'level_commission' => $totalAmount,
                            'total_amount' => $totalAmount,
                            'service_charge' => $serviceCharge,
                            'payable_amount' => $payableAmount,
                            'status' => 1, // 1: Approve, 2: Paid, 3: Reject, 4: Pending
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                        if ($result) {
                            $insertedCount++;
                        }
                    } else {
                        // You can handle the case where a commission entry already exists
                        // For example, you might want to update the record instead
                        // DB::table('commissions')->where('id', $existingCommission->id)->update([...]);
                    }
                }
            }
        }
    
        // Assuming you want to return some data about the commission structure
        $getBinaryTreeStructureJson = []; // Populate this if necessary
    
        return response()->json([
            'statusCode' => 1,
            'data' => $insertedCount,
            'message' => 'Successfully generated commissions for all users'
        ],200);
    }
    


    public function genLevel(Request $request)
    {
        // Authenticate the user
        $user = auth()->guard('api')->user();
        // if(!$user){
        //     return response()->json([
        //         "statusCode"=> 1,
        //         'error' => "Unauthorized User"
        //     ], 401);

        // }
        //print_r($user); die("Asdadff");
    
        // Validate the request input (if necessary)
        // $request->validate([
        //     'pay_id' => 'required',
        // ]);
    
        // Fetch user IDs with status = 1 and level > 0
        $userIds = Usermlm::where('status', 1)
                          ->where('level', '>', 0)
                          ->pluck('id'); // Assuming 'id' is the primary key
    
        // Process each user to update their level based on their complete levels
        foreach ($userIds as $userId) {
            $completeLevels = $this->checkCompleteLevels1Status($userId) - 1; // Calculate complete levels
    
            if ($completeLevels >= 0) {
                // Update usermlms where status = 1 for the specific user
                DB::table('usermlms')
                    ->where('id', $userId)
                    ->where('status', 1) // Only update users with status = 1
                    ->update(['level' => $completeLevels]); // Update the level
    
                // Calculate commission details
                $totalAmount = 300; //$completeLevels * 300;
                $serviceCharge = $totalAmount * 0.10; // 10% of total amount
                $payableAmount = $totalAmount - $serviceCharge; // Subtract service charge from total amount
    
                // Insert commission record
                if ($userId && $completeLevels) {
    
                    // Select the commission entry based on user_id and level
                    $existingCommission = DB::table('commissions')
                        ->where('user_id', $userId)
                        ->where('level', $completeLevels)
                        ->first();
                
                    // Check if the commission entry exists
                    if (!$existingCommission) {
                        // If no existing record is found, insert the new commission data
                        DB::table('commissions')->insert([
                            'user_id' => $userId,
                            'purchase_id' => $request->pay_id ?? 0, // Default to "11" if pay_id is not provided
                            'level' => $completeLevels, // Assuming 'level' is a field in the commissions table
                            'level_commission' => $totalAmount,
                            'total_amount' => $totalAmount,
                            'service_charge' => $serviceCharge,
                            'payable_amount' => $payableAmount,
                            'status' => 1, // 1: Approve, 2: Paid, 3: Reject, 4: Pending
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    } else {
                        // You can handle the case where a commission entry already exists
                        // For example, you might want to update the record instead
                        // DB::table('commissions')->where('id', $existingCommission->id)->update([...]);
                    }
                }
            }
        }
    
        // Assuming you want to return some data about the commission structure
        $getBinaryTreeStructureJson = []; // Populate this if necessary
    
        return response()->json([
            'statusCode' => 1,
            'data' => $getBinaryTreeStructureJson,
            'message' => 'Successfully generated commissions for all users'
        ],200);
    }
    




public function updateLevel(Request $request)
{
    // Authenticate the user
    $user = auth()->guard('api')->user();

    // // Validate the request input
    // $request->validate([
    //     'pay_id' => 'required',
    // ]);

    // Fetch all user IDs
    $userIds = Usermlm::where('status', 1)->pluck('id'); // Assuming 'id' is the primary key

    // Process each user to update their level based on their complete levels
    foreach ($userIds as $userId) {
        $completeLevels = $this->checkCompleteLevels1Status($userId) - 1; // Calculate complete levels
        if ($completeLevels >= 0) {
            // Update usermlms where status = 1 for the specific user
            DB::table('usermlms')
                ->where('id', $userId)
                ->where('status', 1) // Only update users with status = 1
                ->update(['level' => $completeLevels]); // Update the level
        }
    }

    // Assuming you want to return some data about the commission structure
    $getBinaryTreeStructureJson = []; // Populate this if necessary

    return response()->json([
        'statusCode' => 1,
        'data' => $getBinaryTreeStructureJson,
        'message' => 'Successfully generated commissions for all users'
    ],200);
}




public function generate_commission11(Request $request)
{
    // Authenticate the user
    $user = auth()->guard('api')->user();

    // Validate the request input
    $request->validate([
        'pay_id' => 'required',
    ]);

    // Example values for commission calculation
    // You'll need to adjust this logic based on your business rules
    $levelCommission = 0; // This should be calculated based on your commission structure
    $totalAmount = 0; // Total amount involved in the commission
    $serviceCharge = 0; // Calculate any service charges if applicable
    $payableAmount = $totalAmount - $serviceCharge; // Calculate payable amount
    $status = 1; // Initial status, you can change based on your logic

    // Assuming you have a way to get all users and their related data
    //$users = User::all(); // Fetch all users (adjust if you want to filter users)

    $userIds = [1,220,217,216,212,193];
    foreach ($userIds as $user) {

        $CompleteLevels = $this->checkCompleteLevels2($user) - 1;
        echo $user;
        echo "KKK";
        echo  $CompleteLevels;

       // $PairMatches = pow(2, $CompleteLevels) - 1;

        // // Create the commission record for each user
        // DB::table('commissions')->insert([
        //     'user_id' => $user->id,
        //     'purchase_id' => $request->pay_id, // Use the provided payment ID
        //     'level_commission' => $levelCommission,
        //     'total_amount' => $totalAmount,
        //     'service_charge' => $serviceCharge,
        //     'payable_amount' => $payableAmount,
        //     'status' => $status,
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ]);
    }

    // Assuming you want to return some data about the commission structure
    $getBinaryTreeStructureJson = []; // Populate this with your binary tree structure if necessary

    return response()->json([
        'statusCode' => 1,
        'data' => $getBinaryTreeStructureJson,
        'message' => 'Successfully generated commissions for all users'
    ],200);
}




public function getkitamount(Request $request)
{
    // Fetching all records from Kitamount
    $rs = Kitamount::all(); // Added missing semicolon

    return response()->json([
        'statusCode' => 1,
        'data' => $rs,
        'message' => 'Successfully fetched kit amount data' // Updated message to match function purpose
    ],200);
}


    public function downline(Request $request)
    {
        $user = auth()->guard('api')->user();
        $request->validate([
            'id' => 'required',
            'typeStatus' => 'nullable',
        ]);
        $req = $request->only(['id']);
        $umlm = Usermlm::where('id', $req['id'])->first();
        $req1 = json_decode($request->getContent());
        $typeStatus = $request->input('typeStatus', '2');
        $getBinaryTreeStructureJson3=$this->getBinaryTreeStructureJson3($umlm->id,$typeStatus);

        return response()->json([
            'statusCode' => 1,
            'data'=>$getBinaryTreeStructureJson3,
            'message' => 'Successfully getadvisorlist fetch out'
        ],200);
    }

 


    public function payment(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'user_id' => 'required|integer',
            'amount' => 'required|numeric|min:0.01',
            'pay_type' => 'required|string|max:50',
            'remark' => 'required|string'
        ]);
    
        try {
            // Create a new payment record
            Payment::create([
                'user_id' => $request->user_id, // User ID
                'amount' => $request->amount, // Amount in decimal
                'pay_type' => $request->pay_type, // Payment type
                'remark' => $request->remark, // Any remark
                'date' => now(), // Set current date and time for the payment
                'status'=>0,
            ]);
    
            // Return a success response
            return response()->json([
                'statusCode' => 1,
                'message' => 'Payment added successfully'
            ],200);
    
        } catch (\Exception $e) {
            // Return an error response if something goes wrong
            return response()->json([
                'statusCode' => 0,
                'message' => 'Failed to add payment',
                'error' => $e->getMessage() // For debugging, remove in production
            ], 200);
        }
    }



public function payment_approvedxxx(Request $request)
{   
    // Validate incoming request
    $request->validate([
        'pay_id' => 'required|integer',      // Payment ID
        'approve_by' => 'required|integer',  // Approving user ID
    ]);

    try {
        // Check if the approving user exists
        $approver = DB::table('usermlms')->where('id', $request->approve_by)->first();
        if (!$approver) {
            return response()->json([
                'statusCode' => 0,
                'message' => 'Approver not found'
            ], 200);  // 404 Not Found
        }

        // Find the payment by ID
        $payment = Payment::find($request->pay_id);

        if (!$payment) {
            return response()->json([
                'statusCode' => 0,
                'message' => 'Payment not found'
            ], 200);  // 404 Not Found
        }

        // Update the payment details
        $payment->approve_by = $approver->name;
        $payment->status = 1;  // Approve status
        $payment->approve_date = now();  // Set approval date
        $payment->save();

        // Return a success response
        return response()->json([
            'statusCode' => 1,
            'message' => 'Payment approved successfully'
        ],200);

    } catch (\Exception $e) {
        // Return an error response if something goes wrong
        return response()->json([
            'statusCode' => 0,
            'message' => 'Failed to approve payment',
            'error' => $e->getMessage()  // For debugging, remove in production
        ], 200);
    }
}


public function pairlevel(Request $request)
{
    // Validate request data
    $request->validate([
        'id' => 'required',
        'typeStatus' => 'nullable',
    ]);

    // Retrieve the children (child_left, child_right, parent_code) from DB
    $children = DB::select("SELECT child_left, child_right, parent_code FROM usermlms WHERE id = ?", [$request->id]);

    

    // Initialize default values
    $child_left = null;
    $child_right = null;
    $parent_code = null;

    if (!empty($children)) {
        $child_left = $children[0]->child_left;
        $child_right = $children[0]->child_right;
        $parent_code = $children[0]->parent_code;
    }

    // Ensure typeStatus has a default value of 1 if null or empty
    // if (is_null($request->typeStatus) || empty($request->typeStatus)) {
    //     $request->typeStatus = 1;
    // }

    // Initialize variables to be returned
    $LDownline = null;
    $RDownline = null;
    $CompleteLevels = 0;
    $PairMatches = 0;

    // Process based on typeStatus
    if ($request->typeStatus == 2) {
        $LDownline = $this->MyDownline2Sts($child_left);
        $RDownline = $this->MyDownline2Sts($child_right);
        $CompleteLevels = $this->checkCompleteLevels2($request->id) - 1;
        $PairMatches = pow(2, $CompleteLevels) - 1;
    } else if ($request->typeStatus == 1) {
        $LDownline = $this->MyDownline1Sts($child_left);
        $RDownline = $this->MyDownline1Sts($child_right);
        $CompleteLevels = $this->checkCompleteLevels1Status($request->id) - 1;
        $PairMatches = pow(2, $CompleteLevels) - 1;
    }else if ($request->typeStatus == 0) {
        $LDownline = $this->MyDownline0Sts($child_left);
        $RDownline = $this->MyDownline0Sts($child_right);
        $CompleteLevels = $this->checkCompleteLevels0Status($request->id) - 1;
        $PairMatches = pow(2, $CompleteLevels) - 1;
    }  else {
        return response()->json(['statusCode' => 0,'message' => 'Invalid typeStatus value should be only 1 for active,2 for both'], 200);
    }

    $Tree=$this->Tree($request->id);
    // Return the response as JSON
    return response()->json([
        'statusCode' => 0,
        'message' => 'Tree successfully',
        'LDownline' => $LDownline,
        'RDownline' => $RDownline,
        'parent_code' => $parent_code,
        'PairMatches' => $PairMatches,
        'CompleteLevels' => $CompleteLevels,
        'Tree' => $Tree,
    ], 200);
}

    

public function pairlevel222(Request $request)
{
    
    $validator = Validator::make($request->all(), [
        'id' => 'required'
    ]);

  $RDownline=$this->RightDownline($request->id);
//   $RUpline= $this->RightUpline($request->id);

  $LDownline=$this->LeftDownline($request->id);
//   $LUpline= $this->LeftUpline($request->id);

  $PairMatches= $this->checkPairMatches($request->id);
  $CompleteLevels= $this->checkCompleteLevels2($request->id)-1;


  $getAllDescendants=$this->getAllDescendants($request->id);

  $getBinaryTreeStructureJson=$this->getBinaryTreeStructureJson($request->id);
  

 // $getAllLeftDescendants=$this->getAllLeftDescendants($request->id);

  //$getAllLeftDescendantsWithSubChildren=$this->getAllLeftDescendantsWithSubChildren($request->id);

//   return response()->json(['message' => 'Tree successfully', 'PairMatches' => $PairMatches,'CompleteLevels'=> $CompleteLevels,"RDownline"=>$RDownline,"RUpline"=>$RUpline,"LDownline"=>$LDownline,"LUpline"=>$LUpline,"getAllDescendants"=>$getAllDescendants,"getBinaryTreeStructureJson"=>$getBinaryTreeStructureJson], 201);

  return response()->json(['statusCode' => 0,'message' => 'Tree successfully', 'PairMatches' => $PairMatches,'CompleteLevels'=> $CompleteLevels,"RDownline"=>$RDownline,"LDownline"=>$LDownline,"getAllDescendants"=>$getAllDescendants,"getBinaryTreeStructureJson"=>$getBinaryTreeStructureJson], 200);

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

    public function MyDownline1Status($parent_code) {
        $results = [];
        $initial_parent = $parent_code;
    
        // Use a stack to traverse both left and right children
        $stack = [$parent_code];
    
        while (!empty($stack)) {
            $current_parent = array_pop($stack);
    
            // Add current parent to results
            $results[] = $current_parent;
    
            // Fetch child_left, child_right, and their statuses for the current parent
            $children = DB::select("SELECT child_left, child_right FROM usermlms WHERE id = ? AND status = 1", [$current_parent]);
    
            if (!empty($children)) {
                $child_left = $children[0]->child_left;
                $child_right = $children[0]->child_right;
    
                // Check status 1 for both child_left and child_right and push them to stack accordingly
                if (!is_null($child_right) && $child_right > 0) {
                    $child_right_status = DB::select("SELECT status FROM usermlms WHERE id = ?", [$child_right]);
                    if (!empty($child_right_status) && $child_right_status[0]->status == 1) {
                        $stack[] = $child_right;  // Push right child to stack if status is 1
                    }
                }
    
                if (!is_null($child_left) && $child_left > 0) {
                    $child_left_status = DB::select("SELECT status FROM usermlms WHERE id = ?", [$child_left]);
                    if (!empty($child_left_status) && $child_left_status[0]->status == 1) {
                        $stack[] = $child_left;   // Push left child to stack if status is 1
                    }
                }
            }
        }
    
        // Convert the results array into a string of ids
        $results_string = implode(', ', $results);
    
        // Optionally, update the database for the gathered results (if needed).
        // DB::update("UPDATE usermlms SET last_processed = ? WHERE id IN($results_string)", [$uid]);
    
        return $results_string;
    }


    public function MyDownline0Status($parent_code) {
        
      
        $results = [];
        $initial_parent = $parent_code;
    
        // Use a stack to traverse both left and right children
        $stack = [$parent_code];
    
        while (!empty($stack)) {
            $current_parent = array_pop($stack);
    
            // Add current parent to results
            $results[] = $current_parent;
    
            // Fetch child_left, child_right, and their statuses for the current parent
           // echo "SELECT child_left, child_right FROM usermlms WHERE id = $current_parent";
            $children = DB::select("SELECT child_left, child_right FROM usermlms WHERE id = ?", [$current_parent]);
    
            if (!empty($children)) {
                $child_left = $children[0]->child_left;
                $child_right = $children[0]->child_right;
    
                // Check status 1 for both child_left and child_right and push them to stack accordingly
                if (!is_null($child_right) && $child_right > 0) {
                    echo "SELECT status FROM usermlms WHERE id = $child_right";

                    $child_right_status = DB::select("SELECT status FROM usermlms WHERE id = ?", [$child_right]);
                    if (!empty($child_right_status) && $child_right_status[0]->status == 0) {
                        $stack[] = $child_right;  // Push right child to stack if status is 1
                    }
                }
    
                if (!is_null($child_left) && $child_left > 0) {
                    $child_left_status = DB::select("SELECT status FROM usermlms WHERE id = ?", [$child_left]);
                    if (!empty($child_left_status) && $child_left_status[0]->status == 0) {
                        $stack[] = $child_left;   // Push left child to stack if status is 1
                    }
                }
            }
        }
    
        // Convert the results array into a string of ids
        $results_string = implode(', ', $results);
    
        // Optionally, update the database for the gathered results (if needed).
        // DB::update("UPDATE usermlms SET last_processed = ? WHERE id IN($results_string)", [$uid]);
    
        return $results_string;
    }


    public function MyDownline($parent_code) {
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
                if($current_status==0){
                    $results[] = "$current_parent (Status: $current_status)";
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
        $results_string = implode(', ', $results);
    
        // Optionally, update the database for the gathered results (if needed).
        // DB::update("UPDATE usermlms SET last_processed = ? WHERE id IN($results_string)", [$uid]);
    
        return $results_string;
    }



    public function MyDownline0Sts($parent_code) {
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
                if($current_status==0){
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
        $results_string = implode(', ', $results);
    
        // Optionally, update the database for the gathered results (if needed).
        // DB::update("UPDATE usermlms SET last_processed = ? WHERE id IN($results_string)", [$uid]);
    
        return $results_string;
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
        $results_string = implode(', ', $results);
    
        // Optionally, update the database for the gathered results (if needed).
        // DB::update("UPDATE usermlms SET last_processed = ? WHERE id IN($results_string)", [$uid]);
    
        return $results_string;
    }


    public function MyDownline2Sts($parent_code) {
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
               // if($current_status==1){
                    //$results[] = "$current_parent (Status: $current_status)";
                    $results[] = $current_parent;
               // }
    
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
        $results_string = implode(', ', $results);
    
        // Optionally, update the database for the gathered results (if needed).
        // DB::update("UPDATE usermlms SET last_processed = ? WHERE id IN($results_string)", [$uid]);
    
        return $results_string;
    }
    

    public function MyDownlineBB($parent_code){
        $results = [];
    $initial_parent = $parent_code;

    // Use a stack to traverse both left and right children
    $stack = [$parent_code];

    while (!empty($stack)) {
        $current_parent = array_pop($stack);

        // Add current parent to results
        $results[] = $current_parent;

        // Fetch child_left and child_right for the current parent
        $children = DB::select("SELECT child_left, child_right FROM usermlms WHERE id = ?", [$current_parent]);

        if (!empty($children)) {
            $child_left = $children[0]->child_left;
            $child_right = $children[0]->child_right;

            // Push right child first so left child is processed first (DFS)
            if (!is_null($child_right) && $child_right > 0) {
                $stack[] = $child_right;
            }
            if (!is_null($child_left) && $child_left > 0) {
                $stack[] = $child_left;
            }
        }
    }

        // Convert the results array into a string of ids
        $results_string = implode(', ', $results);

        // Optionally, update the database for the gathered results (if needed).
        // DB::update("UPDATE usermlms SET last_processed = ? WHERE id IN($results_string)", [$uid]);

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




// Method to check total pair matches starting from the root user
public function checkPairMatches($rootUserId)
{
    return $pairMatches = $this->countPairMatches($rootUserId);
    
    // return response()->json([
    //     'message' => "The tree has $pairMatches fully matched pairs (both left and right children)."
    // ]);
}


public function minCompleteLevels1Status($rootId) {
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

        //echo json_encode($nextLevelNodes);

        // Move to the next level
        $currentLevelNodes = $nextLevelNodes;
        $completedLevels++;
    }

    return $completedLevels;
}

public function minCompleteLevels0Status($rootId) {
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
                WHERE id = ? AND status = 0", 
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

                    if (!empty($left_child_status) && $left_child_status[0]->status == 0) {
                        $nextLevelNodes[] = $child_left;
                    }
                }

                if (!is_null($child_right) && $child_right > 0) {
                    $right_child_status = DB::select("
                        SELECT status 
                        FROM usermlms 
                        WHERE id = ?", [$child_right]);

                    if (!empty($right_child_status) && $right_child_status[0]->status == 0) {
                        $nextLevelNodes[] = $child_right;
                    }
                }
            }
        }

        //echo json_encode($nextLevelNodes);

        // Move to the next level
        $currentLevelNodes = $nextLevelNodes;
        $completedLevels++;
    }

    return $completedLevels;
}


public function minCompleteLevels2mmm($rootId) {
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
            $children = DB::select("SELECT child_left, child_right FROM usermlms WHERE id = ? AND status = 1", [$nodeId]);

            if (!empty($children)) {
                $child_left = $children[0]->child_left;
                $child_right = $children[0]->child_right;

                // Add valid children to the next level's node list
                if (!is_null($child_left) && $child_left > 0) {
                    $nextLevelNodes[] = $child_left;
                }
                if (!is_null($child_right) && $child_right > 0) {
                    $nextLevelNodes[] = $child_right;
                }
            }
        }

        // Move to the next level
        $currentLevelNodes = $nextLevelNodes;
        $completedLevels++;
    }

    return $completedLevels;
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
        HAVING COUNT(*) = POWER(2, level - 1)  
        ORDER BY level
    ";
    $completedLevels = DB::select($query, ['rootId' => $rootId]);
    return count($completedLevels);
}

public function checkCompleteLevels2($rootId) {
    return $this->minCompleteLevels2($rootId);
}


public function checkCompleteLevels1Status($rootId) {
    return $this->minCompleteLevels1Status($rootId);
}

public function checkCompleteLevels0Status($rootId) {
    return $this->minCompleteLevels0Status($rootId);
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
    // Retrieve the children of the current node
    $children = DB::select("SELECT id, child_left, child_right, status FROM usermlms WHERE id = ?", [$node]);
    
    // Check if children are found
    if (!empty($children)) {
        $child_left = $children[0]->child_left;
        $child_right = $children[0]->child_right;
        $status = $children[0]->status ?? 0;

        // Only proceed if the current node has status 1
        if ($status == 1) {
            // Check left child
            if ($child_left !== null && $child_left > 0) {
                $childLeftStatus = DB::table('usermlms')->where('id', $child_left)->value('status'); // Check left child's status
                if ($childLeftStatus == 1) {
                    $results[] = $child_left; // Add left child to results
                    $this->retrieveDescendants($child_left, $results); // Recursive call for left child
                }
            }

            // Check right child
            if ($child_right !== null && $child_right > 0) {
                $childRightStatus = DB::table('usermlms')->where('id', $child_right)->value('status'); // Check right child's status
                if ($childRightStatus == 1) {
                    $results[] = $child_right; // Add right child to results
                    $this->retrieveDescendants($child_right, $results); // Recursive call for right child
                }
            }
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

    // Append the current level nodes to the tree structure
    if($currentLevel){
        $treeLevels[] = $currentLevel;
    }
    

    // Recursive call for the next level
    $this->retrieveLevelNodes($nextLevelNodes, $treeLevels);
}


public function getBinaryTreeStructureJson3($rootId,$typeStatus=2) {
    $treeLevels = [];  // Array to hold all levels of the tree

    // Start level-order traversal from the root node
    $this->retrieveLevelNodes3([$rootId], $treeLevels,$typeStatus);

    // Convert the result to JSON format
    //return json_encode($treeLevels, JSON_PRETTY_PRINT);
    return $treeLevels;
}

// Helper function to retrieve nodes level-wise
private function retrieveLevelNodes3($currentLevelNodes, &$treeLevels,$typeStatus=2) {
    if (empty($currentLevelNodes)) {
        return;  // Base case: if there are no nodes at this level, stop recursion
    }

    $nextLevelNodes = []; // Array to hold the next level nodes
    $currentLevel = [];   // Array to hold current level nodes in structured format

    foreach ($currentLevelNodes as $nodeId) {
        // Query to fetch left and right children of the current node
        $children = DB::select("SELECT id, child_left,child_right,mobile,name,self_code,status FROM usermlms WHERE id = ?", [$nodeId]);

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

          //  if($empt!=4){
            if($node->status==$typeStatus){
                $currentLevel[] = [
                    'id' => $node->id,
                    'left' => $node->child_left ?? '', 
                    'right' => $node->child_right ?? '', 
                    'self_code'=>$node->self_code ?? '', 
                    'name'=> $node->name ?? '', 
                    'mobile'=> $node->mobile ?? '', 
                    'empty'=>$empt,
                    'status'=>$node->status?? 0,
                ];
            }if($typeStatus==2){
                $currentLevel[] = [
                    'id' => $node->id,
                    'left' => $node->child_left ?? '', 
                    'right' => $node->child_right ?? '', 
                    'self_code'=>$node->self_code ?? '', 
                    'name'=> $node->name ?? '', 
                    'mobile'=> $node->mobile ?? '', 
                    'empty'=>$empt,
                    'status'=>$node->status?? 0,
                ];
            }

           // }

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
    if($currentLevel){
        $treeLevels[] = $currentLevel;
    }
    // Recursive call for the next level
    $this->retrieveLevelNodes3($nextLevelNodes, $treeLevels,$typeStatus);
}


public function countPairMatches($userId, $level = 1)
{
    $currentMatch = 0;
    $leftMatches = 0;
    $rightMatches = 0;

    // Retrieve the user node
    $user = DB::selectOne("SELECT child_left, child_right, status FROM usermlms WHERE id = ?", [$userId]);

    // If user not found or has no children with status 1, return 0
    if (!$user || ($user->child_left === null && $user->child_right === null)) {
        return 0;
    }

    // Proceed only if the current user has status 1
    if ($user->status == 1) {
        // Check if both children are present and have status 1
        if ($user->child_left !== null) {
            $leftChild = DB::selectOne("SELECT status FROM usermlms WHERE id = ?", [$user->child_left]);
            if ($leftChild && $leftChild->status == 1) {
                $leftMatches = $this->countPairMatches($user->child_left, $level + 1);
            }
        }

        if ($user->child_right !== null) {
            $rightChild = DB::selectOne("SELECT status FROM usermlms WHERE id = ?", [$user->child_right]);
            if ($rightChild && $rightChild->status == 1) {
                $rightMatches = $this->countPairMatches($user->child_right, $level + 1);
            }
        }

        // Check if both left and right children exist and have status 1
        if ($user->child_left !== null && $user->child_right !== null) {
            $currentMatch = 1; // Both children are present
        }
    }

    // Total matches at current and subsequent levels
    return $currentMatch + $leftMatches + $rightMatches;
}


public function commissionlist(Request $request) {
    $request->validate([
        'user_id' => 'required'        
    ]);
     
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
    $total = $total_paid_amount + $total_unpaid_amount;

    $rsm['total']=$total;
    $rsm['paid']=$total_paid_amount;
    $rsm['unpaid']=$total_unpaid_amount;

    return response()->json([
        'statusCode' => 1,
        'data'=>$rsm      
    ], 200); 


    //die("ASDFASDf");
   // $tree = $this->buildTree($rootId);
    // Return the result as an array or JSON if needed
   // return $tree;  // Or json_encode($tree, JSON_PRETTY_PRINT) for JSON format
}




public function Tree($rootId) {
    $tree = $this->buildTree($rootId);
    // Return the result as an array or JSON if needed
    return $tree;  // Or json_encode($tree, JSON_PRETTY_PRINT) for JSON format
}


// Helper function to recursively build the tree
private function buildTree($nodeId) {
    // Fetch the node and its children from the database
    $nodeData = DB::select("SELECT id, child_left, child_right FROM usermlms WHERE id = ?", [$nodeId]);

    if (empty($nodeData)) {
        return null; // If no node found, return null
    }

    $node = $nodeData[0];

    // Build the current node structure
    $treeNode = [
        'id' => $node->id,
        'children' => []
    ];

    // Recursively add left and right children
    if ($node->child_left !== null) {
        $treeNode['children'][] = $this->buildTree($node->child_left);
    }
    if ($node->child_right !== null) {
        $treeNode['children'][] = $this->buildTree($node->child_right);
    }

    return $treeNode;
}


}