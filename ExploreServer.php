<?php
include('config/db_connect.php');
$id;
$gamer;
$gamer_servers;
$total_servers;
$total_interested_servers;
$gamer_interested_servers;
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
                    Gamers_idGamers <> $id 
                    )";

    // get the query result
    $result = mysqli_query($conn, $sql);

    $gamer_servers = mysqli_fetch_all($result, MYSQLI_ASSOC);

    $total_servers = sizeof($gamer_servers);

    mysqli_free_result($result);
    

    $sql = "SELECT Servers_idServers
                FROM interested_servers
                WHERE (
                    Gamers_idGamers = $id 
                    )";
    $result = mysqli_query($conn, $sql);

    $gamer_interested_servers = mysqli_fetch_all($result, MYSQLI_ASSOC);

    $total_interested_servers = sizeof($gamer_interested_servers);

    mysqli_free_result($result);
}
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
  <ul class="nav nav-tabs" role="tablist">
    <li class="nav-item">
      <a class="nav-link text-warning active" data-toggle="tab" href="#home">Explore</a>
    </li>
    <li class="nav-item">
      <a class="nav-link text-warning" data-toggle="tab" href="#menu1">Interested</a>
    </li>
  </ul>
  
  <div class="tab-content">
    <div id="home" class="container tab-pane active"><br>
      <?php if ($total_servers == 0) : ?>
                    <h5 class="my-4">No Servers To Explore Yet </h5>
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
                        <form action="ExploreServer.php?id=<?php echo $id; ?>" method="POST">
                        <button type="submit" name="interested" class="btn btn-dark stretched-link">Interested</button>
                    </form>
                    <?php  
                    
        if(isset($_POST['interested'])){
            // create sql
            $gamerUsername = $gamer['username'];
			$sql = "INSERT INTO interested_servers(Gamers_idGamers,Gamers_username,Servers_idServers) VALUES('$id','$gamerUsername','$idServer')";

			// save to db and check
			if(mysqli_query($conn, $sql)){
				// success
				header("Location: mainpage.php?id=$id");
			} else {
				echo 'query error: '. mysqli_error($conn);
			}
    }// end POST check
                    ?>
                    </div>
                </div>
                    <?php endforeach; ?>
                <?php
                    // close connection
                endif; ?>
    </div>
    <div id="menu1" class="container tab-pane fade"><br>
    <?php if ($total_interested_servers == 0) : ?>
                    <h5 class="my-4">Not Interested In Any Server Yet </h5>
                <?php else : ?>
                    <?php
                    
                    foreach ($gamer_interested_servers as $gamer_interested_server) :
                        $idServer = $gamer_interested_server['Servers_idServers'];
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
  </div>
        </main>
        <nav>
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