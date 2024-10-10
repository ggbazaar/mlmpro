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
        // Sample binary tree data
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

        //die("ASDFASDF");



        
// Your data array
$array = [
    [
        'id' => '1',
        'children' => [
            [
                'id' => '2',
                'children' => [
                    [
                        'id' => '2.1',
                        'children' => [
                            [
                                'id' => '4',
                                'children' => [
                                    ['id' => '2.1.2.1'],
                                    ['id' => '2.1.2.2']
                                ]
                            ],
                            [
                                'id' => '5',
                                'children' => [
                                    ['id' => '2.1.2.1'],
                                    ['id' => '2.1.2.2']
                                ]
                            ]
                        ]
                    ],
                    [
                        'id' => '2.2',
                        'children' => [
                            [
                                'id' => '2.2.1',
                                'children' => [
                                    [
                                        'id' => '4',
                                        'children' => [
                                            ['id' => '4.1'],
                                            [
                                                'id' => '4.2',
                                                'children' => [
                                                    ['id' => '4.2.1']
                                                ]
                                            ]
                                        ]
                                    ],
                                    [
                                        'id' => '4',
                                        'children' => [
                                            ['id' => '4.1'],
                                            [
                                                'id' => '4.2',
                                                'children' => [
                                                    ['id' => '4.2.1']
                                                ]
                                            ]
                                        ]
                                    ]
                                ]
                            ],
                            [
                                'id' => '2.2.2',
                                'children' => [
                                    ['id' => '2.1.2.1'],
                                    ['id' => '2.1.2.2']
                                ]
                            ]
                        ]
                    ]
                ]
            ],
            [
                'id' => '3',
                'children' => [
                    [
                        'id' => '3.1',
                        'children' => [
                            [
                                'id' => '3.1.1',
                                'children' => [
                                    ['id' => '3.1.1.1'],
                                    ['id' => '3.1.1.2']
                                ]
                            ],
                            [
                                'id' => '3.1.2',
                                'children' => [
                                    ['id' => '2.1.2.1'],
                                    ['id' => '2.1.2.2']
                                ]
                            ]
                        ]
                    ],
                    [
                        'id' => '3.2',
                        'children' => [
                            [
                                'id' => '3.2.1',
                                'children' => [
                                    ['id' => '2.1.2.1'],
                                    ['id' => '2.1.2.2']
                                ]
                            ],
                            [
                                'id' => '3.2.2',
                                'children' => [
                                    ['id' => '3.2.2.1'],
                                    ['id' => '3.2.2.2']
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ]
];

// // Generate the menu
// buildMenu($array);
       

   // echo "<pre>";
        $tree1=$this->getBinaryTreeStructureJson('1');
        // print_r($tree1);

        // foreach($tree11[0] as $key=>$val){
        //     print_r($val);
        //     foreach($val as $key=>$val1){
        //         print_r($val1);
        //     }
        // }

      // $brrr= $this->buildNestedArray($tree11);

       // $tree1=$this->buildMenu($brrr); 
            
       //$tree1='';
        


        // echo "<pre>";
        // print_r($tree1);
        // die("ASDFA");

        return view('tree-view', compact('tree','tree1'));
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


    // public function getBinaryTreeStructureJson($rootId) {
    //     $treeLevels = [];  // Array to hold all levels of the tree
    
    //     // Start level-order traversal from the root node
    //     $this->retrieveLevelNodes([$rootId], $treeLevels);
    
    //     // Convert the result to JSON format
    //     //return json_encode($treeLevels, JSON_PRETTY_PRINT);
    //     return $treeLevels;
    // }


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


public function renderTree11($nodes) {
    if (empty($nodes)) {
        return;
    }


    




    // echo "<ul>";
    // foreach ($nodes as $level) {
    //     foreach ($level as $node) {
    //         echo "<li> <a href='#'>".htmlspecialchars($node['id'])."</a>";
            
    //         // // echo '' . htmlspecialchars($node['id']);
    //         // // Check if the left or right child exists and print them
    //         // if (!empty($node['left'])) {
    //         //    echo 'L' . htmlspecialchars($node['left']);
    //         // }
    //         // if (!empty($node['right'])) {
    //         //    echo 'R' . htmlspecialchars($node['right']);
    //         // }
    //         // Recursive call for children
    //         // if (!empty($node['left']) || !empty($node['right'])) {
    //         //     $children = [];
    //         //     if (!empty($node['left'])) {
    //         //         $children[] = ['id' => $node['left'], 'left' => null, 'right' => null];
    //         //     }
    //         //     if (!empty($node['right'])) {
    //         //         $children[] = ['id' => $node['right'], 'left' => null, 'right' => null];
    //         //     }
    //         //     $this->renderTree([$children]); // Recursively call with children
    //         // }
    //         echo '</li>';
    //     }
    // }
    // echo '</ul>';
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

        // Add to the output structure
        $output[] = $temp;
    }

    return $output;
}


 
public function buildMenu($items) {

// print_r($items);


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


 






}
