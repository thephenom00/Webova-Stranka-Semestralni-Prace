const input = document.querySelector(".search");
input.addEventListener("keyup", function() {
    hint(input.value);
})


function hint(text) {
    if (text.length == 0) {
        document.getElementById("suggestion").innerHTML = "";
    } else {
        // NEW REQUEST
        var xmlhttp = new XMLHttpRequest(); 
        
        // IF THE REQUEST IS READY
        xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("suggestion").innerHTML = this.responseText;
        }
        };

        // SEND THE REQUEST
        xmlhttp.open("GET", "../../lib/suggestions.php?q=" + text, true);
        xmlhttp.send();
    }
    }