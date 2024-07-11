/*This file read the JSON content from the text file "correspond_prot.txt" and add an anchor element 
from the corresponding protocols names in the html page.
HTML page: "correspond_prot.html"
PHP page: "correspond_prot.php"*/

let xhr = new XMLHttpRequest();
xhr.open('GET', 'correspond_prot.php');

function correspond_list(response){
    let ajout = "";
    for(idx_protocol_suggest=0;idx_protocol_suggest<=response.length-1;idx_protocol_suggest++){
        let name_protocole = response[idx_protocol_suggest][0].replace(/ /g, "&nbsp;");
        if(name_protocole != "No&nbsp;results&nbsp;found"){
            console.log(name_protocole);
            ajout += "<br> <input type = 'button' class = 'container' style = '' id = "+idx_protocol_suggest+" value = "+ name_protocole +"></input> <br>"
        }
        else{
            ajout += "<p> No result found </p>"
        }
        
        document.getElementById("list_protocole").innerHTML = ajout;
    }
}

xhr.onload = () => {
    switch (xhr.status) {
        case 200:
            let response = JSON.parse(xhr.responseText);
            correspond_list(response);
            break;
        case 201: console.log(xhr.responseText);
        break;
        default: console.log('HTTP error:' + xhr.status);
    }
};

xhr.send(); 