<?php
    include('config/db_connect.php');

    $email = $fname = $lname = $password = $gender = $username = $dateOfBirth  = '';
    
    $errors = array('email' => '', 'fname' => '', 'lname' => '' ,'password' => '', 'gender' => '', 'username' => '', 'dateOfBirth' => '');
    if(isset($_POST['submit'])){
		// check email
		if(empty($_POST['email'])){
			$errors['email'] = 'An email is required';
		} else{
			$email = $_POST['email'];
			if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
				$errors['email'] = 'Email must be a valid email address';
			}
        }

		// check first name
		if(empty($_POST['fname'])){
			$errors['fname'] = 'A First Name is required';
		} else{
			$fname = $_POST['fname'];
			if(!preg_match('/^[a-zA-Z\s]+$/', $fname)){
				$errors['fname'] = 'First Name must be letters and spaces only';
			}
        }
		// check last name
		if(empty($_POST['lname'])){
			$errors['lname'] = 'A Last Name is required';
		} else{
			$lname = $_POST['lname'];
			if(!preg_match('/^[a-zA-Z\s]+$/', $lname)){
				$errors['lname'] = 'Last Name must be letters and spaces only';
			}
        }
		// check gender
		if(empty($_POST['gender'])){
			$errors['gender'] = 'Gender is required';
		} else{
			$gender = $_POST['gender'];
			if(!preg_match('/^[a-zA-Z\s]+$/', $gender)){
				$errors['gender'] = 'gender must be letters and spaces only';
			}
        }
		// check username
		if(empty($_POST['username'])){
			$errors['username'] = 'A username is required';
		} else{
			$username = $_POST['username'];
			if(!preg_match('/^[a-z\d]{5,12}$/i', $username)){
				$errors['username'] = 'username must be letters and spaces only';
			}
        }
		// check password
		if(empty($_POST['password'])){
			$errors['password'] = 'A password is required';
		} else{
			$password = $_POST['password'];
			if(!preg_match('/^[\d\w@-]{8,20}$/i', $password)){
				$errors['password'] = 'password must be valid';
			}
        }if(array_filter($errors)){
            //echo 'errors in form';
		} else {
			// escape sql chars
			$email = mysqli_real_escape_string($conn, $_POST['email']);
			$fname = mysqli_real_escape_string($conn, $_POST['fname']);
			$lname = mysqli_real_escape_string($conn, $_POST['lname']);
			$gender = mysqli_real_escape_string($conn, $_POST['gender']);
			$password = mysqli_real_escape_string($conn, $_POST['password']);
            $username = mysqli_real_escape_string($conn, $_POST['username']);

			// create sql
			$sql = "INSERT INTO gamers(username,fname,lname,email,gender, password ) VALUES('$username','$fname','$lname','$email','$gender','$password')";

			// save to db and check
			if(mysqli_query($conn, $sql)){
				// success
				header('Location: index.php');
			} else {
				echo 'query error: '. mysqli_error($conn);
			}
			
		}

	} // end POST check

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">    
    <link rel="stylesheet" href="sign.css">
    <script src="jq.js"></script>
    <script>
        $(document).ready(function(){
            $("#cont").click(function() {
                  $('html , body').animate({
                        scrollTop:$(document).height()
                        },1000);
                        return false;
            });
        });
    </script>
    <title>Signup Page</title>
</head>
<body class="bg-dark" id="boo">
    <div class="pos-f-t">  
        <nav class="navbar navbar-expand-sm bg-dark navbar-dark fixed-top">
            <div class="container">
                <button class="navbar-toggler" data-toggle="collapse" data-target="#mainNav2">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="mainNav2">
                <div class="navbar-nav">    
                <div class="navbar-headwer vl">
                    <a href="#" class="navbar-brand text-warning">Evolve</a>
                </div>
                        <a class="nav-link mx-5" href="index.php">Landing Page</a>
                        <a class="nav-item nav-link mx-5" href="">Why Evolve?</a>
                        <a id="cont" class="nav-item nav-link mx-5" href="3">Contact</a>
                    </div> 
                </div>
            </div>
        </nav>
    </div>
    <div class="container">
        <div class="m-4">
            <div class="m-4">
                <div class="text-light">
                    <h1 class="display-1">Create YOUR <br>Account Here!</h1>
                </div>
        <div class="m-4">
                <div class="jumbotron bg-dark text-light">

                        <form action="signup.php" method="POST">
                            <div class="form-group">
                                <p class="text-muted">What's your email?</p>
                                <p class="text-muted">Don't worry we won't tell anyone.</p>
                                <hr class="my-4">
                                <input type="email" class="form-control" name="email" id="email1" aria-describedby="emailHelp"
                                    placeholder="Email">
                                <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                            </div>
                            <div class="form-group">
                                <p class="text-muted">Your Name?</p>
                                <p class="text-muted">Name is important</p>
                                <hr class="my-4">
                                <input type="text" class="form-control" name="fname" id="firstName" placeholder="First Name">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="lname" id="lastName" placeholder="Last Name">
                            </div>
                                <p class="text-light">What's your gender?</p>
                                <p class="text-muted">Are you an alien?</p>
                                <hr class="my-4">
                                <div class="form-group form-inline">
                                    <input type="radio" class="mx-1" id="male" name="gender" value="male">
                                    <label for="male" class="mr-2">Male</label><br>
                                    <input type="radio" class="mx-1" id="female" name="gender" value="female">
                                    <label for="female" class="mr-2">Female</label><br>
                                    <input type="radio" class="mx-1" id="other" name="gender" value="other">
                                    <label for="other" class="mr-2">Other</label>
                                </div>
                                <div class="form-group">
                                    <p class="text-light">When were you born?</p>
                                    <p class="text-muted">Let's find out how old you are.</p>
                                    <hr class="my-4">
                                    <input type="date" id="birthDay" name="birthday" min="1980-01-01">
                                </div>
                                <div class="form-group">
                                    <p class="text-light">Choose a username</p>
                                    <p class="text-muted">Used for sign in to evolve world.</p>
                                    <hr class="my-4">
                                    <input type="text" class="form-control" name="username" id="Username" placeholder="ENTER USERNAME" aria-describedby="pass">
                                    <small id="uname" class="form-text text-muted">
                                        Use a cool username.<br>
                                        Username will be used by others to find you.<br>
                                        Username cannot be same
                                    </small> 
                                </div>
                            <p class="text-light">Choose a password</p>
                            <p class="text-muted">Make sure it's a good one.</p>
                            <hr class="my-4">
                            <div class="form-group">
                                <input type="password" name="password" class="form-control" id="passw" placeholder="Password" aria-describedby="pass">
                                <small id="pass" class="form-text text-muted">
                                    Must be Okay strength or better.<br>
                                    Password is at least 8 characters long.<br>
                                    Password contains at least one letter or number
                                </small> 
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" id="cpassw" placeholder="Confirm Password" >
                            </div>
                            <button type="submit" name="submit" id="sub" class="btn btn-outline-warning my-2">Submit</button>
                        </form>
                    </div>
            </div>
            </div>
            </div>

        </div>
    </div>
    <div class="footer">
        <div class="jumbotron jumbotron-fluid my-0 bg-dark text-muted">
            <div class="container">
                <div class="shadow">
                    <h3 class="text-center">Want to inbox us?</h1>
                        <hr>
                </div>
                <form class="form-inline justify-content-center">
                    <input type="email" name="join" placeholder="Type your email" class="form-control" required>
                    <button type="button" class="btn mx-2 btn-outline-warning">Submit</button>
                </form>
                <div class="row my-4">
                    <div class="col-md-6">
                        <h1 class="display-3">Quiries</h1>
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link text-warning shadow-sm" href="#">Support</a>
                                <hr>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-warning shadow-sm" href="#">Contact</a>
                                <hr>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-warning shadow-sm" href="#">FAQs</a>
                                <hr>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h1 class="display-3">Social Media</h1>

                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <li class="nav-item">
                                    <a class="nav-link text-warning shadow-sm" href="https://www.instagram.com/makesomericeballs/">Instagram</a>
                                    <hr>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-warning shadow-sm" href="https://www.facebook.com/feezghost/">Facebook</a>
                                    <hr>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-warning shadow-sm" href="https://discord.gg/mC4sfE">Twiter</a>
                                    <hr>
                                </li>
                        </ul>
                    </div>

                </div>
                <div class="text-center">
                    <span>Site By Ghosts</span>
                    <br>
                    <span>Copyright Ghost Company 2020</span>
                    <hr class="my-4">
                    <div class="text-warning">

                    </div>
                </div>

            </div>
        </div>
    </div>
    
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
</body>
</html>