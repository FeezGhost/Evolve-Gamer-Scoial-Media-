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
$name = $area = $platform  = '';
    
    $errors = array('name' => '', 'area' => '', 'platform' => '' );
    if(isset($_POST['submit'])){

		// check name
		if(empty($_POST['name'])){
			$errors['name'] = 'A Name is required';
		} else{
			$name = $_POST['name'];
			if(!preg_match('/^[a-zA-Z\s]+$/', $name)){
				$errors['name'] = 'Name must be letters and spaces only';
			}
        }
		// check platform
		if(empty($_POST['platform'])){
			$errors['platform'] = 'A Server must have a Platform';
		} else{
			$platform = $_POST['platform'];
			if(!preg_match('/^[a-zA-Z\s]+$/', $platform)){
				$errors['platform'] = 'Platform Name must be letters and spaces only';
			}
        }
		// check area
		if(empty($_POST['area'])){
			$errors['area'] = 'A Server must have an Area';
		} else{
			$area = $_POST['area'];
			if(!preg_match('/^[a-zA-Z\s]+$/', $area)){
				$errors['area'] = 'Area must be letters and spaces only';
			}
        }
        if(array_filter($errors)){
            //echo 'errors in form';
		} else {
			// escape sql chars
			$name = mysqli_real_escape_string($conn, $_POST['name']);
			$area = mysqli_real_escape_string($conn, $_POST['area']);
			$platform = mysqli_real_escape_string($conn, $_POST['platform']);

			// create sql
			$sql = "INSERT INTO `servers`(name, platform, area, adminID) VALUES('$name','$platform','$area','$id')";

			// save to db and check
			if(mysqli_query($conn, $sql)){
                // success 1
                $sql = "SELECT idServers
                FROM servers
                WHERE (
                    name = '$name' 
                    AND
                    platform = '$platform'
                    AND
                    area = '$area'
                    )";
                 
                // get the query result
                $result = mysqli_query($conn, $sql);
                
                $serverId=mysqli_fetch_assoc($result);

                $gamerUsername = $gamer['username'];

                $sID = $serverId['idServers'];

                // create sql
                $sql = "INSERT INTO `gamers_has_servers`(Gamers_idGamers, Gamers_username, 	Servers_idServers) VALUES($id,'$gamerUsername',$sID)";
                
                if(mysqli_query($conn, $sql)){
                    // sucess;
                }
                else{
                    echo 'query error: '. mysqli_error($conn);
                }
			} else {
				echo 'query error: '. mysqli_error($conn);
			}
			
		}

	} // end POST check
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="mainpage.css">

    <script src="jq.js"></script>
    <script>
        $(document).ready(function() {});
    </script>
    
	<style>
        body{
            color: white;
            font-family: 'Nunito Semibold';
            text-align: center;
            }
#gen_set{
  max-width: 50%;
}
        #content{
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            max-width: 100px;
            height: 100vh;
            margin: 0;
            grid-template-areas:
                "header header header header"
                "footer footer footer footer"
                "main main main main"
                "main main main main"
                "aside aside nav nav"
                "section section section section"
                "section section section section";
        }
        /* desktop grid */
        @media screen and (min-width: 760px){
    		#content{
    			display: grid;
                grid-template-columns: repeat(7, 1fr);
                height: 100vh;
                max-width: 100%;
                margin: 0 0;
                grid-template-areas:
                    "aside aside main main main main main"
                    "aside aside main main main main main"
                    "footer footer footer footer footer footer footer";
    		}
        }
		#content > *{
			background-color: #22222291;
			padding: 30px;
		}
        main{
            background-color: #26262791 !important;
            grid-area: main;
        }
        aside{
            grid-area: aside;
        }
        footer{
            position: sticky !important;
            bottom: 0 !important;
            background-color: #202020 !important;
            grid-area: footer;
        }
	</style>
    <title>Evolve</title>
</head>

<body class="bg-dark text-lead">
    <div id="content">

        <main>
            <div class="col">
                <button type="button" id="b1" class="px-5 mx-5 btn btn-lg btn-outline-warning b1">Create Server</button>
                <?php if ($total_servers == 0) : ?>
                    <h5 class="my-4">No Servers Joined Yet </h5>
                <?php else : ?>
                    <?php
                    
                    foreach ($gamer_servers as $gamer_server) :
                        $idServer = $gamer_server['Servers_idServers'];
                        $sql = "SELECT *
                                    FROM servers
                                    WHERE (
                                        idServers = $idServer
                                    )";
                        $result = mysqli_query($conn, $sql);

                        $server = mysqli_fetch_assoc($result);

                        mysqli_free_result($result);
                    ?>
                <div class="card m-4 text-dark" style="width:400px">
                    <img class="card-img-top" src="img_avatar1.png" alt="Card image" style="width:100%">
                    <div class="card-body">
                        <h4 class="card-title"><?php echo($server['name']); ?></h4>
                        <p class="card-text">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><?php echo($server['platform']); ?></li>
                                <li class="list-group-item"><?php echo($server['area']); ?></li>
                            </ul>
                        </p>
                        <a href="#" class="btn btn-primary stretched-link">Open</a>
                    </div>
                </div>
                    <?php endforeach; ?>
                <?php
                    // close connection
                    mysqli_close($conn);
                endif; ?>
            </div>
        </main>
        <aside>
            <p class="text-lead">Home</p>
            <div class="ml-4">
            <div class="ml-4">
            <form class="form-inline ml-4">
                <input type="email" name="join" placeholder="Type your email" class="form-control" required>
            </form></div></div>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link text-white" href="https://www.instagram.com/makesomericeballs/">Explore Server</a>
                    <hr>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="https://www.facebook.com/feezghost/">Explore Players</a>
                    <hr>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="https://discord.gg/mC4sfE">Find a Server</a>
                    <hr>
                </li>
            </ul>
        </aside>
        
        <footer>
            
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
            <a class="nav-item nav-link mx-5 text-white" href="setting.php?id=<?php echo ($id); ?>">
                Setting
            </a>
            </div>
            <a class="nav-item nav-link mx-5 text-white" href="index.php">
                Logout
            </a>
        </div>
    </nav>
        </footer>
    </div>
    
    <div class="popup-wrapper">
        <div class="popup">
            <div class="popup-content jumbotron bg-dark">
                <div class="popup-close">X</div><form action="mainpage.php?id=<?php echo $id; ?>" method="POST">
                            <div class="form-group">
                                <p class="text-muted">Server Name?</p>
                                <hr class="my-4">
                                <input type="text" class="form-control" name="name" id="serveName" placeholder="Enter Serve Name">
                            </div>
                            <div class="form-group">
                                <p class="text-muted">Choose a Platform</p>
                                <hr class="my-4">
                                <input type="text" class="form-control" name="platform" id="serverPlatform" placeholder="ENTER Platform" aria-describedby="pass">
                            </div>
                            <div class="form-group">
                                <p class="text-muted">Choose an Area</p>
                                <hr class="my-4">
                                <input type="text" class="form-control" name="area" id="serverArea" placeholder="ENTER Area" aria-describedby="pass">
                            </div>
                            <br>
                            <button type="submit" name="submit" id="sub" class="btn btn-outline-warning my-2">Submit</button>
                        </form>
            </div>
        </div>
    </div>
    <!-- Optional JavaScript -->
    <script src="sandbox.js"></script>

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>