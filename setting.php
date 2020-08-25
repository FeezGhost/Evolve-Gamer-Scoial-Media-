<?php
include('config/db_connect.php');
$id;
$gamer;
$gamer_servers;
$total_servers;
// check GET request username param
if (isset($_GET['id'])) {

    // escape sql chars
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    // make sql
    $sql = "SELECT * FROM gamers WHERE idGamers = $id";

    // get the query result
    $result = mysqli_query($conn, $sql);

    // fetch result in array format
    $gamer = mysqli_fetch_assoc($result);

    mysqli_free_result($result);

    $sql = "SELECT Servers_idServers
                FROM gamers_has_servers
                WHERE (
                    Gamers_idGamers = $id 
                    )";

    // get the query result
    $result = mysqli_query($conn, $sql);

    $gamer_servers = mysqli_fetch_all($result, MYSQLI_ASSOC);

    $total_servers = sizeof($gamer_servers);

    mysqli_free_result($result);
}
$email = $fname = $lname = '';
    
    $errors = array('email' => '', 'fname' => '', 'lname' => '' );
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
        if(array_filter($errors)){
            //echo 'errors in form';
		} else {
			// escape sql chars
			$email = mysqli_real_escape_string($conn, $_POST['email']);
			$fname = mysqli_real_escape_string($conn, $_POST['fname']);
			$lname = mysqli_real_escape_string($conn, $_POST['lname']);
            echo ($id);
            echo ($email);

			// create sql
			$sql = "UPDATE `gamers` SET `fname` = '$fname', `lname` = '$lname',  `email` = '$email' WHERE `gamers`.`idGamers` = $id";
			// save to db and check
			if(mysqli_query($conn, $sql)){
				// success
				header("Location: mainpage.php?id=$id");
			} else {
				echo 'query error: '. mysqli_error($conn);
			}
			
		}

	} // end POST check
    $password;
        
        $errors = array('email' => '', 'fname' => '', 'lname' => '' );
        if(isset($_POST['change'])){
            // check password
            if(empty($_POST['password'])){
                $errors['password'] = 'A password is required';
            } else{
                $password = $_POST['password'];
                if(!preg_match('/^[\d\w@-]{8,20}$/i', $password)){
                    $errors['password'] = 'password must be valid';
                }
            if(array_filter($errors)){
                //echo 'errors in form';
            } else {
                // escape sql chars
                $password = mysqli_real_escape_string($conn, $_POST['password']);
    
                // create sql
                $sql = "UPDATE `gamers` SET `password` = '$password' WHERE `gamers`.`idGamers` = $id";
                // save to db and check
                if(mysqli_query($conn, $sql)){
                    // success
                    header("Location: mainpage.php?id=$id");
                } else {
                    echo 'query error: '. mysqli_error($conn);
                }
                
            }
    
        } 
    }// end POST check
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="setting.css">
    <script src="jq.js"></script>
    <style>
        .foot{
            
          position: sticky !important;
          bottom: 0 !important;
        }
    </style>
    <title>Evolve</title>
</head>
<body class="bg-dark text-lead">
    <div id="content">

        <main>
            <div class="tab-content px-5 mx-5 text-muted text">
                <div class="tab-pane active text-white" id="cute">
                    <div id="gen_set">
                        <h1 class="display-4">General</h1>
                        <form action="setting.php?id=<?php echo $id; ?>" method="POST">
                            <div class="form-group container">
                                <hr>
                                <p class="text-muted">Your Name</p>
                                <hr>
                                <input type="text" name="fname" class="form-control" id="firstName" placeholder="First Name">
                            </div>
                            <div class="form-group container">
                                <input type="text" name="lname" class="form-control" id="lastName" placeholder="Last Name">
                            </div>
                            <div class="container form-group">
                                <hr>
                                <p class="text-muted">Your Email</p>
                                <hr>
                                <input type="email" name="email" class="form-control" id="email1" aria-describedby="emailHelp"
                                    placeholder="Email">
                            </div>
                            <button type="submit" name="submit" class="btn btn-outline-warning">Submit</button>
                        </form>
                            <button type="button"  class="btn btn-outline-warning b1">Change Password</button>
                    </div>
                </div>
                <div class="tab-pane text-white" id="shy">
                    <h3>COMING SOON</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quos libero dolore qui atque, corrupti odio
                        tenetur
                        aliquid inventore aliquam rerum. Hic officiis veniam ipsam veritatis adipisci eius quos, ducimus
                        numquam.</p>
        
                </div>
            </div>
        </main>
        <nav>
            <nav class="nav justify-content-center nav-pills flex-column">
            <a class="nav-link bg-dark text-white active my-4" href="#cute" data-toggle="tab">General</a>
            <a class="nav-link bg-dark text-white" href="#shy" data-toggle="tab">Privacy</a>
        </nav>
        </nav>
    </div>
    
    <div class="popup-wrapper">
        <div class="popup">
            <div class="popup-content jumbotron bg-dark">
                <div class="popup-close">X</div>
                <form action="setting.php?id=<?php echo $id; ?>" method="POST">
                <div class="form-group">
                    <p class="text-muted">New Password</p>
                    <hr class="my-4">
                    <input type="password"  name="password" class="form-control" id="pass">
                </div>
                <div class="form-group">
                    
                <button type="submit" name="change" class="px-5 mx-4 btn btn-outline-warning">Change</button>
                </div>
            </form>
            </div>
        </div>
    </div>  
    <nav class="foot navbar navbar-expand-sm navbar-dark">
        <button class="navbar-toggler" data-toggle="collapse" data-target="#mainNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
            <div class="navbar-nav">
                <div class="navbar-headwer vl">
                    <a href="#" class="navbar-brand text-warning">Evolve</a>
                </div>

                <a class="nav-item nav-link mx-5" href="">
                    <img class="rounded-circle" id="mainpage_pro_pic" style="width: 12%;" src="https://ptetutorials.com/images/user-profile.png" alt="profile_pic"> 
                    <?php echo($gamer['username']); ?>
                </a>
            <a class="nav-item nav-link mx-5 text-white" href="chat.php?id=<?php echo ($id); ?>">
                Chat
            </a>
            <a class="nav-item nav-link mx-5 text-white" href="mainpage.php?id=<?php echo ($id); ?>">
                Mainpage
            </a>
            </div>
            <a class="nav-item nav-link mx-5 text-white" href="index.php">
                Logout
            </a>
        </div>
    </nav>
    
    <!-- Optional JavaScript -->
    <script src="sandbox.js"></script>

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
</body>
</html>