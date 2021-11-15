$(document).ready(function(){
    //variables
    const email = $('#email');
    const pass = $('#password');
    const logInForm = $('#button-id')

    var emailcheck = false;
    var passwordcheck = false;

    $(signInButton[0]).click(function(){
    
        validateEmail(email);
        confirmPassword();

        if(emailcheck == false){
            alert("email invalid")
        }
        if(passwordcheck ==false){
            alert("password invalid")
        }
        if(emailcheck && passwordcheck){
          logInForm.submit()
        }
              
    });

    function validateEmail(emailval) {
        var emailValue = emailval.val();
        if (
          emailValue.length > 5 &&
          emailValue.lastIndexOf(".") > emailValue.lastIndexOf("@") &&
          emailValue.lastIndexOf("@") != -1
        ) {
          emailcheck = true;
        }else{
            emailcheck = false
        }
      }
      function confirmPassword() {
        if (pass.val().length > 5) {
          passwordcheck = true;
        }else{
            passwordcheck = false;
        }
    
      }
});