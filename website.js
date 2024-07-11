/*This file read the JSON content form the php file "website.php", and add the information of the 
database to the the drop-down menus of the html page.
HTML page : "home.html"
PHP page : "website.php"*/

let xhr = new XMLHttpRequest();
xhr.open('GET', 'website.php');


function liste_deroulantes(response){
    let colonnes=["department","hospital_name","job"];
    for(cat_id=0;cat_id<colonnes.length;cat_id++){
        let ajout="";
        let list_option = [];
        //Loop through the various drop-down menus
        for(j=0;j<response.length;j++){
            //loop over the options offered in 1 drop-down menu
            if(!list_option.includes(response[j][colonnes[cat_id]])){
                let without_space= response[j][colonnes[cat_id]].replace(/ /g, "");
                ajout += "<option value="+without_space+">"+response[j][colonnes[cat_id]]+"</option>"; 
                document.getElementById(colonnes[cat_id]).innerHTML = ajout;
                //Refresh to avoid displaying the same name twice
                list_option.push(response[j][colonnes[cat_id]]);
            }
        }
    }
}

xhr.onload = () => {
    switch (xhr.status) {
        case 200:
            let response = JSON.parse(xhr.responseText);
            liste_deroulantes(response);
            break;
        case 201: console.log(xhr.responseText);
        break;
        default: console.log('HTTP error:' + xhr.status);
    }
};

xhr.send(); 