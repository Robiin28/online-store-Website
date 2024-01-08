const form = document.getElementById("form");
const password = document.getElementById("password");
const errorMessage = document.querySelector("small");
 


form.addEventListener("submit", function(e) {

        if (password.value.length < 6) {
            errorMessage.textContent = "Passwords must be at least 6 characters long";
            errorMessage.style.visibility = "visible";
        } 
        else {
            // form can be submitted here
             form.submit()
        }
        e.preventDefault();
    });


      // Get the password input elements
    var passwordInput = document.getElementById("password");
    
    // Create the eye icons
    var passwordEye = document.createElement("i");
    passwordEye.classList.add("fa", "fa-eye");
   

    // Add the eye icons to the password input elements
    passwordInput.parentNode.appendChild(passwordEye);
    // confirmPasswordInput.parentNode.appendChild(confirmPasswordEye);

    // Add event listeners to toggle the visibility of the passwords
    passwordEye.addEventListener("click", function() {
        togglePasswordVisibility(passwordInput);
    });
    
    function togglePasswordVisibility(passwordInput) {
        // Check if the input type is currently "password"
        if (passwordInput.type === "password") {
            // Change the input type to "text"
            passwordInput.type = "text";
            // Change the eye icon to a closed eye
            passwordInput.nextSibling.classList.remove("fa-eye");
            passwordInput.nextSibling.classList.add("fa-eye-slash");
        } else {
            // Change the input type back to "password"
            passwordInput.type = "password";
            // Change the eye icon back to an open eye
            passwordInput.nextSibling.classList.remove("fa-eye-slash");
            passwordInput.nextSibling.classList.add("fa-eye");
        }
    }