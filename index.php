
<?php 
    include('config/db_connect.php');
    $email = $fname = $lname = $gender = $username = $password = $id  = '';
    $flag=0;
    if(isset($_POST['submit'])){
		// check username
		if(empty($_POST['username'])){
            $flag=0;
		} else{
            $username = $_POST['username'];
            $flag=1;
        }
		// check gender
		if(empty($_POST['password'])){
            $flag=0;
		} else{
            $password = $_POST['password'];
            $flag=1;
        }
        if($flag===1){
            $sql = 'SELECT * FROM gamers';
            
            // get the result set (set of rows)
            $result = mysqli_query($conn, $sql);
        
            // fetch the resulting rows as an array
            $gamers = mysqli_fetch_all($result, MYSQLI_ASSOC);
        
            // free the $result from memory (good practise)
            mysqli_free_result($result);
            
            // close connection
            mysqli_close($conn);

            foreach ($gamers as $gamer) {
                if(($password === $gamer['password'])&&($username === $gamer['username'])){
                    $id=$gamer['idGamers'];
                    $fname=$gamer['fname'];
                    $lname=$gamer['lname'];
                    $email=$gamer['email'];
                    $gender=$gamer['gender'];
                    $flag=2;
                break;
                }
            }
            if($flag===2){
				header("Location: mainpage.php?id=$id");
            }
            else{
                echo("not found");
            }
        }
        else{
            echo("please fill the data");
            // close connection
            mysqli_close($conn);
        }
}
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
    <link rel="stylesheet" href="style.css">
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
    <title>Evolve</title>
</head>

<body id="boo">
    <div class="pos-f-t">
        <nav class="navbar navbar-expand-sm bg-dark navbar-dark fixed-top">
            <div class="container">
                <button class="navbar-toggler" data-toggle="collapse" data-target="#mainNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="mainNav">
                    <div class="navbar-nav">
                        <div class="navbar-headwer vl">
                            <a href="#" class="navbar-brand text-warning">Evolve</a>
                        </div>
                        
                        <a class="nav-item nav-link mx-5" href="signup.php">Signup</a>
                        <a class="nav-item nav-link mx-5" href="">Why Evolve?</a>
                        <a id="cont" class="nav-item nav-link mx-5" href="#">Contact</a>
                    </div>
                </div>
            </div>
        </nav>
    </div>
    <div class="jumbotron jumbotron-fluid bg-dark text-muted" id="jumbo">
        <div class="container">
            <h1 class="display-1">Welcome to Evolve</h1>
            <p class="lead text-center">We stalk at night</p>
        </div>
    </div>
    <div class="container">
        <div class="container text-white text-center">
            <h1 class="display-3">A new way to chat with your communities and friends.</h1>
            <p class="lead text-center">Evolve is the easiest way to communicate over voice, video, and text, whether
                you’re part of a school club, a nightly gaming group, a worldwide art community, or just a handful of
                friends that want to hang out</p>
            <div class="container my-5">
                <button type="button"  class="px-5 mx-5 btn btn-lg btn-outline-warning b1">LogIn</button>
                <button type="button" class="px-5 mx-5 btn btn-lg btn-outline-warning" onclick="window.location.href = 'signup.php'"> Signup</button>
            </div>
        </div>
    </div>
    <h2 class="display-4 text-center py-5 my-5 text-white">Meet The Ghosts</h2>
    <nav class="nav justify-content-center nav-pills flex-column flex-md-row">
        <a class="nav-link bg-dark text-white active " href="#cute" data-toggle="tab">The Cute</a>
        <a class="nav-link bg-dark text-white" href="#shy" data-toggle="tab">The Shy</a>
        <a class="nav-link bg-dark text-white" href="#angry" data-toggle="tab">The Angry</a>
        <a class="nav-link bg-dark text-white" href="#lost" data-toggle="tab">The Lost</a>
    </nav>
    <div class="tab-content py-5 px-5 mx-5 text-muted text">
        <div class="tab-pane active text-white" id="cute">
            <h3>The Cute One</h3>

            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quos libero dolore qui atque, corrupti odio
                tenetur
                aliquid inventore aliquam rerum. Hic officiis veniam ipsam veritatis adipisci eius quos, ducimus
                numquam.</p>
            <ul class="myImages">
                <li><img src="img\zT4Ekgz.png" alt="" class="mx-auto img-fluid"></li>
            </ul>


        </div>
        <div class="tab-pane text-white" id="shy">
            <h3>The Shy One</h3>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quos libero dolore qui atque, corrupti odio
                tenetur
                aliquid inventore aliquam rerum. Hic officiis veniam ipsam veritatis adipisci eius quos, ducimus
                numquam.</p>
            <ul class="myImages">
                <li><img src="img\unnamed.jpg" alt="" class="mx-auto img-fluid"></li>
            </ul>

        </div>
        <div class="tab-pane text-white" id="angry">
            <h3>The Angry One</h3>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quos libero dolore qui atque, corrupti odio
                tenetur
                aliquid inventore aliquam rerum. Hic officiis veniam ipsam veritatis adipisci eius quos, ducimus
                numquam.</p>
            <ul class="myImages">
                <li><img src="img\800px_COLOURBOX35667834.jpg" alt="" class="mx-auto img-fluid"></li>
            </ul>

        </div>
        <div class="tab-pane text-white" id="lost">
            <h3>The Lost One</h3>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quos libero dolore qui atque, corrupti odio
                tenetur
                aliquid inventore aliquam rerum. Hic officiis veniam ipsam veritatis adipisci eius quos, ducimus
                numquam.</p>
            <ul class="myImages">
                <li><img src="img\one.jpg" alt="" class="mx-auto img-fluid"></li>
            </ul>

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
    
    <div class="popup-wrapper">
        <div class="popup">
            <div class="popup-content jumbotron bg-dark">
                <div class="popup-close">X</div>
                <form action="index.php" method="POST">
                <div class="form-group">
                    <p class="text-muted">What's your Username?</p>
                    <hr class="my-4">
                    <input type="text" class="form-control" name="username" id="userNAME"
                        placeholder="Username">
                </div>
                <div class="form-group">
                    <p class="text-muted">Your Password?</p>
                    <hr class="my-4">
                    <input type="password" name="password" class="form-control" id="passWorD" >
                </div>
                <div class="form-group">
                    
                <button type="submit" id="b1" name="submit" class="px-5 mx-4 btn btn-outline-warning">LogIn</button>
                </div>
            </form>
            </div>
        </div>
    </div>
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