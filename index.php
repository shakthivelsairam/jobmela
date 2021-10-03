<?php
require "session_user_utils.php";
?>
<html>
<head>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
<!------ Include the above in your HEAD tag ---------->
<style>
body {
  margin: 0;
  padding: 0;
  background-color: #17a2b8;
  height: 100vh;
}
#login .container #login-row #login-column #login-box {
  margin-top: 120px;
  max-width: 600px;
  height: 320px;
  border: 1px solid #9C9C9C;
  background-color: #EAEAEA;
}
#login .container #login-row #login-column #login-box #login-form {
  padding: 20px;
}
#login .container #login-row #login-column #login-box #login-form #register-link {
  margin-top: -85px;
}
#snackbar {
  visibility: hidden;
  min-width: 250px;
  margin-left: -125px;
  background-color: #333;
  color: #fff;
  text-align: center;
  border-radius: 2px;
  padding: 16px;
  position: fixed;
  z-index: 1;
  left: 50%;
  top: 50px;
  font-size: 17px;
}

#snackbar.show {
  visibility: visible;
  -webkit-animation: fadein 0.5s, fadeout 0.5s 3.5s;
  animation: fadein 0.5s, fadeout 0.5s 3.5s;
}

@-webkit-keyframes fadein {
  from {top: 0; opacity: 0;} 
  to {top: 50px; opacity: 1;}
}

@keyframes fadein {
  from {top: 0; opacity: 0;}
  to {top: 50px; opacity: 1;}
}

@-webkit-keyframes fadeout {
  from {top: 50px; opacity: 1;} 
  to {top: 0; opacity: 0;}
}

@keyframes fadeout {
  from {top: 50px; opacity: 1;}
  to {top: 0; opacity: 0;}
}

</style>
<body>
   <section class="vh-100 gradient-custom">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-12 col-md-8 col-lg-6 col-xl-5">
        <div class="card bg-dark text-white" style="border-radius: 1rem;">
          <div class="card-body p-5 text-center" style="height:500px">

            <div class="mb-md-5 mt-md-4 pb-5">

              <h2 class="fw-bold mb-2 text-uppercase">Portal Login</h2>
              <p class="text-white-50 mb-5">Please enter your login and password!</p>

              <div class="form-outline form-white mb-4">
                <input type="email" id="username" value="" class="form-control form-control-lg" placeholder="Enter User Name" />
              </div>

              <div class="form-outline form-white mb-4">
                <input type="password" id="password" value="" class="form-control form-control-lg" placeholder="Enter Password" />
                
              </div>
              <button class="btn btn-outline-light loginButton btn-lg px-5" type="submit">Login</button>
				<br/></br>
              <p class="small pb-lg-2"><a href="#!">Forgot password?</a></p>
			<div id="errormessage1"></div>

            </div>

           <div id="snackbar"></div>

          </div>
        </div>
      </div>
    </div>
  </div>
</section>
</body>
</html>
<script>

  $('.loginButton').click(function() {
    var ferror = 0;
    $('#username').css("border", "1px solid black");
    $('#password').css("border", "1px solid black");
    var username = $('#username').val();
    var password = $('#password').val();
    if (username === '') {  $('#username').css("border", "2px solid red"); ferror=1}
    if (password === '') {  $('#password').css("border", "2px solid red"); ferror=1}
	//var regex = /^(0|[1-9][0-9]*)$/;
    //var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
	var msg="";
	if((username.length==0))
    {
      ferror=1;
      $('#username').css("border", "1px solid red");
	  msg="Enter User Name";
    }
	if(password.length==0)
    {
      ferror=1;
      $('#password').css("border", "1px solid red");
	  if (msg=="") msg="Enter password";
    }
	
    	
    if (ferror) {
		var x = document.getElementById("snackbar");
		x.className = "show";
		$("#snackbar").html(msg);
		$("#snackbar").css('background-color','#DF2909');
		$("#snackbar").css('color','#FFFFFF');
		setTimeout(function(){ x.className = x.className.replace("show", ""); }, 4000);
		return false;
	}
	var pwdformat = password.substr(4,4)+"-"+password.substr(2,2)+"-"+password.substr(0,2);

    //
    // save the user details and trigger email
    $.ajax({
          url : 'login_ajax.php',
          type : 'POST',
          data : {
              'username' : username,
              'password' : password,
              'zproflag' : 710
          },
          dataType:'json',
          success : function(data) {
              if (data['status']==0)
              {
				  
				  if ((data['firsttime']=="")||(data['firsttime']==null))
				  {
					  window.location.replace("basicinfo.php");
				  }
				  else
				  {
					window.location.replace("search.php");
				  }
              }
			  else if (data['status']==99)
			  {
				  //window.location.replace("dashboard.php");
			  }
              else
              {
               var x = document.getElementById("snackbar");
				x.className = "show";
				$("#snackbar").html(data['msg']);
				$("#snackbar").css('background-color','#DF2909');
				$("#snackbar").css('color','#FFFFFF');
				setTimeout(function(){ x.className = x.className.replace("show", ""); }, 5000);
              }
              // clearPrompts();
          },
          error : function(request,error)
          {
            $("#errormessage1").css('display', 'block');
            $('#errormessage1').html("Failed to login, please contact admin"+error);
			$("#errormessage1").css('color', 'red');
            $('#errormessage1').delay(9000).fadeOut();
          }
      });
    //
    return false;
  });
</script>
