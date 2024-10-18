<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Usermlm;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TreeController extends Controller
{

    public function showTree()
    {
        $tree = [
            'value' => 'Root',
            'left' => [
                'value' => 'Left Child 1',
                'left' => [
                    'value' => 'Left Child ggg 1.1',
                    'left' => null,
                    'right' => null,
                ],
                'right' => [
                    'value' => 'Left Child 1.2',
                    'left' => null,
                    'right' => null,
                ],
            ],
            'right' => [
                'value' => 'Right Child 2',
                'left' => [
                    'value' => 'Right Child 2.1',
                    'left' => null,
                    'right' => null,
                ],
                'right' => [
                    'value' => 'Right Child 2.2',
                    'left' => null,
                    'right' => null,
                ],
            ],
        ];

        // Fetch the binary tree structure
        $tree12 = $this->getBinaryTreeStructureJson('1');
        // Initialize an array to hold the fetched tree structure
        $ttf = array($tree12); // Use array() for compatibility
        // Build the menu from the fetched tree structure
        $tree1 = $this->buildMenu($ttf);
        // Pass the variables to the view
        return view('tree-view', compact('tree', 'tree1'));
    }

    public function getBinaryTreeStructureJson($rootId) {
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

public  function buildNestedArray($inputArray) {
    $output = [];

    // Loop through the levels of the input array
    foreach ($inputArray as $level) {
        $temp = [];
        $tt='';
        $tt1='';
        
        // Loop through each entry in the current level
        foreach ($level as $entry) {
            if(isset($entry['id'])){
                $tt=$entry['id'];
            }

            $item = [
                'id' => $tt,
                'children' => [] // Initialize empty children array
            ];

            // Check if 'left' and 'right' exist, and are non-empty, to assume it has children
            if (!empty($entry['left']) && !empty($entry['right'])) {
                // Add child item as a placeholder for now, will be filled in recursion if necessary
                $item['children'][] = [
                    'id' => "{$entry['id']}.1",
                    'children' => [] // Additional structure if necessary
                ];

                if(isset($entry['id'])){
                    $tt1=$entry['id'];
                }

                $item['children'][] = [
                    'id' => "{$tt1}.2",
                    'children' => [] // Additional structure if necessary
                ];
            }

            $temp[] = $item;
        }
        $output[] = $temp;
    }

    return $output;
}


// <div class="node">
// <div class="bg-white border rounded-lg p-4 shadow-lg flex flex-col items-center active-node">
//     <h2 class="text-lg font-semibold">ID: 3</h2>
//     <p class="text-gray-700">Name: Node 3</p>
//     <p class="text-green-500 font-bold">Status: Active</p>
// </div>
// </div>

public function buildMenu($items) {

    //print_r($items);
   
   
       $r = "<ul>";
       $yy="";
   
       foreach ($items as $item) {
           if(isset($item['id'])){
               $yy=$item['id'];
           }
           $r .= "<li><a href='#'>" . $yy . "</a>";
   
           // If the item has children, recursively build the submenu
           if (isset($item['children'])) {
               $r .= $this->buildMenu($item['children']); // Capture the returned submenu
           }
   
           $r .= "</li>";
       }
   
       $r .= "</ul>";
       return $r;
   }

   
   
public function buildMenu11($items) {



    $r = "<ul class='node L16'>";
    $yy="";
    foreach ($items as $item) {
        if(isset($item['id'])){
            $yy=$item['id'];
        }
        $r .= "<li class='L15'><div class='L18 border rounded-lg p-4 active-node' href='#'>" . $yy ;

        // $r.="<div class='node'>";
        // $r .="<div class='L19'>";
        // $r .="<div class='bg-red L22  w-[200px]  border rounded-lg p-4 shadow-lg flex flex-col items-center active-node' style='width: 200px;'>";
        $r .= "<h2 class='text-lg font-semibold'>ID: $yy </h2>";
        $r .= "<p class='text-gray-700'>Name: Node 1</p>";
        $r .= "<p class='text-green-500 font-bold'>Status: Active</p>";
        // $r .= "</div>";
        // $r .= "</div>";
         $r .= "</div>";

        if (isset($item['children'])) {
            $r .= $this->buildMenu($item['children']); // Capture the returned submenu
        }

        $r .= "</li>";
    }
    $r .= "</ul>";
    return $r;
}

}