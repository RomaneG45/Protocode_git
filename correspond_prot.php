<?php
/*This file read the content of the corresponding protocole in the text file "correspond_prot.txt"
Return : JSON file containing name and descrption of the corresponding protocols
exemple: [["name1","descr1"],["name2","descr2"]]
HTML file : "correspond_prot.html"
JS file : "correspond_prot.js*/

//File to read
$file = "correspond_prot.txt";

if (file_exists($file)){
    //Read the file
    $correspond_prot = file_get_contents($file);
    // Return data as JSON
    echo $correspond_prot;
}
else{
    echo "File doesn't exists";
}

?>