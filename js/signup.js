$(document).ready(function(){
// variables
   const firstName = $("#first_name");
   const lastName = $("#last_name") ;
   const phoneNumber = $('#phone_number');
   const email = $('#email');
   const pass = $('#password');
   const confPass = $('#confirmpass');
   const signInButton = $('.signup_button');
   const signUpForm = $('#signupForm');

    //conditions
    var fN = false;
    var lSN = false;
    var pN = false;
    var e = false;
    var cP = false;

    
    $(signInButton[0]).click(function(){
    

        firstNameCheck(firstName);
        lastNameCheck(lastName);
        numberCheck(phoneNumber);
        validateEmail(email);
        confirmPassword();
        

        if(pN == false){
            alert("number invalid")
        }

        if(fN == false){
            alert("first name invalid")
        }

        if(lSN == false){
            alert("last name invalid")
        }

        if(e == false){
            alert("email invalid")
        }
        if(cP==false){
            alert("confirm password invalid")
        }
        if(pN && fN && lSN && e && cP){
            signUpForm.submit()
        }
    });
    
    function firstNameCheck(name){
        if (name.val().length>3){
            fN = true;
        }else{
            fN = false;
        }
    }

    function lastNameCheck(name){
        if (name.val().length>3){
             lSN= true
        }else{
            lSN = false
        }
    }

    function numberCheck(number){
    var phoneValue = number.val().split(" ").join("");
  if (
    (phoneValue.length == 12 || phoneValue.length == 11) &&
    phoneValue.indexOf("+961") == 0
  ) {
    pN = true;
  }else{
      pN = false
  }

}
function validateEmail(emailval) {
    var emailValue = emailval.val();
    if (
      emailValue.length > 5 &&
      emailValue.lastIndexOf(".") > emailValue.lastIndexOf("@") &&
      emailValue.lastIndexOf("@") != -1
    ) {
      e= true;
    }else{
        e = false
    }
  }
  function confirmPassword() {
    if (pass.val() == confPass.val() && pass.val().length > 5) {
      cP = true;
    }else{
        cP = false;
    }

  }
    });


    

  