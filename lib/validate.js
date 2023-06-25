function init() {
    // GET ALL THE ELEMENTS
    const formEl = document.querySelector('.regForm')
    email = document.querySelector("#email")
    username = document.querySelector("#user")
    password = document.querySelector("#pass")
    confirmPassword = document.querySelector("#confirmpass")
    username_input = document.querySelector("#user")

    // ADD EVENT LISTENER TO FORM
    formEl.addEventListener('submit', validate)
    username_input.addEventListener('keyup', function(){
        usernameCheck(username_input.value)
    })
}


function validate(event) {
    const usernameResult = validateUsername()
    const emailResult = validateEmail()
    const passwordResult = validatePassword()

    // IF RESULT IS TRUE, SUBMIT THE FORM
    if(usernameResult && emailResult && passwordResult){
        return true
    }else{
        // IF NOT PREVENT DEFAULT, EMPTY THE PASSWORD FIELDS
        event.preventDefault()
        document.querySelector("#confirmpass").value = "";
        document.querySelector("#pass").value = "";
    }
}


function validateUsername(){
    // GET THE ELEMENTS
    const intUsername = document.querySelector("#intUsername")
    const span = document.createElement("span")
    const paragraph = document.createElement("p")

    // USERNAME MUSTNT BE EMPTY, MUSTNT CONTAIN SPACES, MUSTNT CONTAIN SPECIAL CHARACTERS
    if(username.value.length >= 5 && !username.value.match(" ") && !username.value.match(/[^A-Za-z0-9]/)){
        if (username.parentElement.querySelector('.error')) {
        	username.parentElement.removeChild(username.parentElement.querySelector('.error'));
	    }
        return true

    }else{
        // IF THE SPAN IS EMPTY, CREATE THE ERROR MESSAGE
        if(username.parentElement.querySelector('span') == null){
            span.classList.add("error")
            paragraph.innerText = "Uživatelské jméno není validní"
            span.appendChild(paragraph)
            intUsername.appendChild(span)

        }
    }
}

function validateEmail() {
    // GET THE ELEPEMNTS
    const intEmail = document.querySelector("#intEmail")
    const span = document.createElement("span")
    const paragraph = document.createElement("p")

    // EMAIL MUSTNT BE EMPTY, MUSTNT CONTAIN SPACES, MUSTNT CONTAIN SPECIAL CHARACTERS
    if (email.value.match(/^[A-Za-z0-9@.]*$/) && email.value.length >= 6 && !email.value.match(" ")) {
        if (email.parentElement.querySelector('.error')) {
        	email.parentElement.removeChild(email.parentElement.querySelector('.error'));
	    }
        return true
    }else{
        // IF THE SPAN IS EMPTY, CREATE THE ERROR MESSAGE
        if (email.parentElement.querySelector('span') == null){
            span.classList.add("error")
            paragraph.innerText = "Email není validní"
            span.appendChild(paragraph)
            intEmail.appendChild(span)

    }
    return false;
}}


function validatePassword() {
    // GET THE ELEMENTS
    const intPassword1 = document.querySelector("#intPassword1")
    const span = document.createElement("span")
    const paragraph = document.createElement("p")

    // PASSWORD MUSTNT BE EMPTY, MUST BE LONGER THAN 3 CHARACTERS
    if (password.value == confirmPassword.value && password.value != "" && password.value.length >= 4) {
        if (password.parentElement.querySelector('.error')) {
        	password.parentElement.removeChild(password.parentElement.querySelector('.error'));
            confirmPassword.parentElement.removeChild(confirmPassword.parentElement.querySelector('.error'));
	    }
        return true

    } else {
        // IF THE SPAN IS EMPTY, CREATE THE ERROR MESSAGE
        if (password.parentElement.querySelector('span') == null){
            span.classList.add("error")
            paragraph.innerText = "Heslo není v pořádku"
            span.appendChild(paragraph)
            intPassword1.appendChild(span)

    }


}}



// XML

function usernameCheck(text) {
    // IF TEXT IS EMPTY, DO NOTHING
    if (text.length == 0) { 
        document.getElementById("sameUser").innerHTML = "";
    } else {
        // NEW REQUEST
        
        var xmlhttp = new XMLHttpRequest(); 

        // IF EVERYTHING IS OK, CHANGE THE RESPONSE TEXT
        xmlhttp.onreadystatechange = function() { 
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("sameUser").innerHTML = this.responseText;
        }
    };
        // XML OPENS THE PHP FILE
        xmlhttp.open("GET", "../../lib/usernameChecker.php?q=" + text, true); 
        
        // XML SENDS THE REQUEST
        xmlhttp.send(); 
    }
    }