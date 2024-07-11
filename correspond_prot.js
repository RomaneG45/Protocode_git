/* This file manages the dynamic actions of the "correspond_prot.html" page.
Function correspond_list : Displays the options available in the database in drop-down menus for each category (job, department and hospital name).
Function reload_CSS : Reads the css file from the html page
Function display_protocol : Assigns html tags to different parts of the protocol text to display it in an attractive format 
Function hide_list : Hides the list of matching protocols, if too many, when pressing a button 
HTML file : "correspond_prot.html"
Php file : "correspond_prot.php" */


let xhr = new XMLHttpRequest();
xhr.open('GET', 'correspond_prot.php');

function correspond_list(response){
    let ajout = "";
    for(let idx_protocol_suggest=0; idx_protocol_suggest<=response.length-1; idx_protocol_suggest++){
        let name_protocole = response[idx_protocol_suggest][0].replace(/ /g, "&nbsp;");
        if(name_protocole != "No&nbsp;results&nbsp;found"){
            console.log(name_protocole);
            ajout += `<br> <input type='button' class='container' id=${idx_protocol_suggest} value="${name_protocole}"></input> <br>`;
        }
        else{
            ajout += "<p>No result found</p>";
        }
        
        document.getElementById("list_protocole").innerHTML = ajout;
    }
}

function reloadCSS() {
    let links = document.getElementsByTagName("link");
    for (let i = 0; i < links.length; i++) {
        let link = links[i];
        if (link.rel === "stylesheet") {
            link.href += "?timestamp=" + new Date().getTime();
        }
    }
}

function display_protocol(prot_selected, response) {
    let idx_protocol = prot_selected.id;
    let ajout = "";

    // Add a line break for each new step described
    let nb_replace = /(\d+\.)/g;
    let prot_line_break = response[idx_protocol][1].replace(nb_replace, '</div><div id="nb">$1</div><div id="step">');

    console.log("After nb_replace: ", prot_line_break);

    // Correctly replace titles
    let title_replace = /([A-Z]+:|[A-Z]\s[A-Z]+:)/g;
    prot_line_break = prot_line_break.replace(title_replace, function(match, p1) {
        return `</div><br><div id="step_title">${p1}</div><br><div id="step">`;
    });

    console.log("After title_replace: ", prot_line_break);

    // Display the protocol description 
    ajout += `<div id="title">${response[idx_protocol][0]}</div><br><div>${prot_line_break}</div>`;
    
    // Log the final HTML content to be inserted
    console.log("ajout: ", ajout);
    document.getElementById("display_protocol").innerHTML = ajout;

    // Afficher les éléments avec la classe step_title dans la console
    const stepTitles = document.querySelectorAll('#step_title');
    stepTitles.forEach(el => console.log(el));
}

function hide_list(){
    let src_img = this.id;

    if(src_img == "up_arrow"){
        //Hide the list of corresponding protocols
        document.getElementById("down_arrow").style = "";
        document.getElementById("up_arrow").style = "display : none;";
        document.getElementById("list_protocole").style = "display : none;"; 
        document.getElementById("line").style = "";
    } else {
        //Show the list of corresponding protocols
        document.getElementById("up_arrow").style = "";
        document.getElementById("down_arrow").style = "display : none;";
        document.getElementById("list_protocole").style = "";
        document.getElementById("line").style = "display : none;";
    }
}

xhr.onload = () => {
    switch (xhr.status) {
        case 200:
            let response = JSON.parse(xhr.responseText);
            correspond_list(response);

            //List all the <input> protocols
            let list_prot = document.getElementsByTagName("input");
            for(let idx=0; idx<=response.length-1; idx++){
                list_prot[idx].addEventListener("click", function(idx){
                    display_protocol(idx.target, response);
                });
            }

            let hide = document.getElementsByTagName("img");
            for (let idx = 0; idx < hide.length; idx++) {
                hide[idx].addEventListener("click", hide_list);
            }
            break;
        case 201:
            console.log(xhr.responseText);
            break;
        default:
            console.log('HTTP error:' + xhr.status);
    }
};

xhr.send();