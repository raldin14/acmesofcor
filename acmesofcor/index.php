<?php //require 'inc/header.php';
require 'init.php';
session_start();

if(isset($_POST['submit'])){
    $gifSearch = $_POST['searchGIF'];
    $url = "http://api.giphy.com/v1/gifs/search?api_key=P2oCKJO7QKeaqYFHiRVFV0BEf5VpPygi&q=".$gifSearch;
    $giphy = json_decode(file_get_contents($url));
    $gif = $giphy->data;
    
    if(isset($_SESSION["username"])){
      $userid = $_SESSION["userId"];
        $date = date("Y-m-d h:i:sa");
        $sql = "INSERT INTO history (id_user, searchstring, searchdate, searchkey) VALUES ('$userid','$url','$date','$gifSearch')";
        $result = $mysqli->query($sql);
    }
}

if(isset($_POST['addtofav'])){
    if(!session_start()){
        $gifPath = $_POST['gifFav'];
        echo $gifPath;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="css/lightbox.css">
	  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" >
    <title>Document</title>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-primary">
      <a class="navbar-brand loginlink" href="#">ACME</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarText">
          <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
              <a class="nav-link loginlink" href="#">Home <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
              <a class="nav-link" id="history" href="#">History</a>
          </li>
          <li class="nav-item">
              <a class="nav-link" id="favorite" href="#">Favorites</a>
          </li>
          </ul>
          <?php 
              if(isset($_SESSION["username"])){
                  ?>
                  <a href="#" id="logout"  class="navbar-text btn btn-primary" >Logout</a>
                  <?php
              }else{
          ?>
          <span class="navbar-text btn btn-primary" id="loginbtn">
          Login
          </span>
          <?php                 
      }
      ?>
      </div>
  </nav>

  <div class="container mt-5">
    <div id="searchView" class="row">
      <div class="col col-md-12">
        <h1 class="text-center">Search for ACME GIFs</h1>
      </div> 
      <div class="row">
      <div class="col col-md-12">
      <form method="POST">
          <div class="row">              
            <div class="col col-md-10">
                <input type="text" name="searchGIF" placeholder="Search for GIFs" class="form-control" id="searchGIF">
            </div>
            <div class="col col-md-2">
                <input type="submit" name="submit" class="btn btn-success" value="Get GIF">
            </div>            
          </div>
      </form>
      </div>
      </div>
      <div class="row gallery">
          <?php
              if(!empty($gif)){
                  foreach($gif as $gifs){
                      echo '<div class="row">';
                          echo '<div class="col col-mid-3">';
                          echo '<a href="'.$gifs->images->fixed_width->url.'" class="gal_link">';
                              echo '<img class="img-thumbnail" id="'.$gifs->id.'" onclick="myFunction(event)" src="'.$gifs->images->fixed_width->url.'">';
                          echo '</a><br>';
                          echo '<button type="button" name="'.$gifs->id.'" class="btn btn-primary btn-sm">Add to Favorite</button>';
                          echo '</div>';
                      echo '</div>';
                  }
              }                
          ?>
      </div>
    </div>

    <div id="LoginView">
        <div class="row">
          <div class="col col-md-10 offset-sm-3 text-center">
            <form action="action.php" method="post">
                <div class="row">                
                  <div class="form-group col col-md-6">
                      <input type="text" name="username" placeholder="username" class="form-control" id="username">
                  </div>
                </div>
                <div class="row">
                  <div class="form-group col col-md-6">
                      <input type="password" name="password" placeholder="password" class="form-control" id="usepasswordrname">
                  </div>           
              </div>
              <div class="row">                
                  <div class="col col-md-6">
                    <input type="submit" value="Login" style="width: 100%" class="btn btn-success">
                   </div> 
              </div>
            </form>
          </div>
        </div>
    </div>
    <div id="historyView">
      <div class="row">
        <?php 
          if(isset($_SESSION["username"])){
            $query = "SELECT * FROM history WHERE id_user = '".$_SESSION["userId"]."'";
            $result = $mysqli->query($query);
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()) { 
                  ?>
                  <div class="form-group col col-md-12">
                  <h1><?php echo $row["searchkey"]?></h1>
                </div>
                <div class="row gallery">
                <?php
                $url = $row["searchstring"];
                $giphy = json_decode(file_get_contents($url."&limit=10"));
                $gif = $giphy->data;
                    if(!empty($gif)){
                        foreach($gif as $gifs){
                            echo '<div class="row">';
                                echo '<div class="col col-mid-3">';
                                echo '<a href="'.$gifs->images->fixed_width->url.'" class="gal_link">';
                                    echo '<img class="img-thumbnail" id="'.$gifs->id.'" onclick="myFunction(event)" src="'.$gifs->images->fixed_width->url.'">';
                                echo '</a>';
                                echo '</div>';
                            echo '</div>';
                        }
                    }                
                ?>
            </div>
                <?php
                  }
            }
          }else{
            ?>
          <div class="form-group col col-md-12">
            <h1>Please login first to see your search history</h1>
            <form action="action.php" method="post">
                <div class="row">                
                  <div class="form-group col col-md-6">
                      <input type="text" name="username" placeholder="username" class="form-control" id="username">
                  </div>
                </div>
                <div class="row">
                  <div class="form-group col col-md-6">
                      <input type="password" name="password" placeholder="password" class="form-control" id="usepasswordrname">
                  </div>           
              </div>
              <div class="row">                
                  <div class="col col-md-6">
                    <input type="submit" value="Login" style="width: 100%" class="btn btn-success">
                   </div> 
              </div>
            </form>
          </div>
            <?php
          }
        ?>
      </div>
    </div>

    <div id="favoriteView">
    <div class="row">
    <div class="form-group col col-md-12">
                  <h1>Favorites GIFs</h1>
                </div>
        <?php 
          if(isset($_SESSION["username"])){
            $query = "SELECT * FROM favorites WHERE id_user = '".$_SESSION["userId"]."'";
            $result = $mysqli->query($query);
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()) { 
                  ?>                  
                <div class="row gallery">
                <?php
                $src = $row["img_src"];
                  echo '<div class="row">';
                      echo '<div class="col col-mid-3">';
                      echo '<a href="'.$src.'" class="gal_link">';
                          echo '<img class="img-thumbnail" onclick="myFunction(event)" src="'.$src.'">';
                      echo '</a>';
                      echo '</div>';
                  echo '</div>';
                ?>
            </div>
                <?php
                  }
            }
          }else{
            ?>
          <div class="form-group col col-md-12">
            <h1>Please login first to see your search favorites</h1>
            <form action="action.php" method="post">
                <div class="row">                
                  <div class="form-group col col-md-6">
                      <input type="text" name="username" placeholder="username" class="form-control" id="username">
                  </div>
                </div>
                <div class="row">
                  <div class="form-group col col-md-6">
                      <input type="password" name="password" placeholder="password" class="form-control" id="usepasswordrname">
                  </div>           
              </div>
              <div class="row">                
                  <div class="col col-md-6">
                    <input type="submit" value="Login" style="width: 100%" class="btn btn-success">
                   </div> 
              </div>
            </form>
          </div>
            <?php
          }
        ?>
      </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="js/modals.js"></script>
<script src="js/jquery.js"></script>
<script src="js/main.js"></script>
<script src="js/jquery.lightbox.js"></script>
	<script src="js/lightbox.js"></script>
  <script>
  $(function(){
   $('button').click(function(){
     var btn = $(this).attr('name');
    $('.gallery  img').each(function() {
        if(btn == $(this).attr('id')){
          //alert($(this).attr('src'))
          var srcimg = $(this).attr('src');
          $.ajax({
            url:"action.php",
            method:"POST",
            data:{srcimg:srcimg},
            success:function(data){
              if(data == 'True'){
                alert("Saved to favorite");
                return true;
              }else{
                $('#LoginView').show();
                $('#searchView').hide();
                $('#historyView').hide();
                return false;
              }
              
            }
          });          
        }        
    });
   });

   $('#logout').click(function(){
          var action = "logout";
            $.ajax({
              url:"action.php",
              method:"POST",
              data:{action:action},
              success:function(){
                
                  location.reload();
              }
            });
        });
    });    
  </script>
  </body>
</html>