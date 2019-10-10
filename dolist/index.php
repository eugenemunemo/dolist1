<?php
session_start();

if (!isset($_SESSION['UUID']) and !isset($_SESSION['username'])) {
    header('Location: ./login.php');
}

?>

<!DOCTYPE html>
<html>
   <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="./includes/css/style.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
        <?php 
            $UUID = $_SESSION['UUID'];
            echo "<script>var authUUID='".$UUID."'; var idsToTitle = {"; 
            include('./includes/db.inc.php');
            $us = $_SESSION['username'];
            $sort = $_COOKIE['sortBy'];
            switch ($sort){
                case "newOld":
                    $r = $conn->prepare("SELECT * FROM `notes` WHERE authorUUID = :uuid ORDER BY `created` DESC");        
                    break;
                case "oldNew":
                    $r = $conn->prepare("SELECT * FROM `notes` WHERE authorUUID = :uuid ORDER BY `created` ASC");        
                    break;
                case "az":
                    $r = $conn->prepare("SELECT * FROM `notes` WHERE authorUUID = :uuid ORDER BY `title` ASC");        
                    break;
                case "za":
                    $r = $conn->prepare("SELECT * FROM `notes` WHERE authorUUID = :uuid ORDER BY `title` DESC");        
                    break;
                default:
                    $r = $conn->prepare("SELECT * FROM `notes` WHERE authorUUID = :uuid");

            }
            $r->bindValue(':uuid',$UUID);
            $r->execute();
            if ($r->rowCount() == 0){
                echo "};</script>";
                $empty = true;
            }else{
                $i = 0;
                while ($row = $r->fetch(PDO::FETCH_ASSOC)){
                    $i +=1;
                    if ($i == $r->rowCount()){echo "'".htmlspecialchars($row['title'])."':'".$row['UUID']."'";}else{
                        echo "'".htmlspecialchars($row['title'])."':'".$row['UUID']."',";
                    }
                }
                echo "};</script>";
            }

             ?>
   </head>
   <body class="mainBody c-s-loaded">
    <div class="main">
      <div id="myDIV" class="header">
         <h2 style="margin:5px">To Do List</h2>
         <input type="text" id="myInput" name="Item" placeholder="Eat Lunch....">
         <span onclick="newElement()" class="addBtn btn btn-primary">Add</span>
                     
         <select onchange="newSort()" class="changeSort" id="changeSort">
            <option value="newOld" <?php if ($sort == "newOld"){echo "selected";} ?> >Newest - Oldest</option>
            <option value="oldNew" <?php if ($sort == "oldNew"){echo "selected";} ?> >Oldest - Newest</option>
            <option value="az" <?php if ($sort == "az"){echo "selected";} ?> >A - Z</option>
            <option value="za" <?php if ($sort == "za"){echo "selected";} ?> >Z - A</option>
        </select>
         <p id="error"></p>
      </div>
      <ul id="myUL">
        <?php 
            include('./includes/getTodos.php');
         ?>
      </ul>
      <p>
        
        <a href="logout.php" class="btn btn-danger">SIGN OUT</a>
    </p>
  </div>
  <form>

<ol class="list-group list_of_items">

</ol>
</form>


 

<?php
if($_POST){
    $any = $_POST['Item'];
    if(isset($_SESSION['items'])){
        $_SESSION['items'][] = $any;
        
    }else{
        $_SESSION['items'] = [];
    }
displaylist();
    
}
// this function populate the  $_SESSION//
$time = time();    
function displaylist(){
 $time = time();
 //$date = date('Y-m-d',$item);
 
  echo "<ul>";
  foreach($_SESSION['items'] as $item){
      echo "<li id=\"do\">".$item."</li><br>";
  };
  echo "</ul>";
  
}
       
?>
       



      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js">
    </script>
      <script>

      
     
        function escapeHtml(text) {
          var map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
          };

          return text.replace(/[&<>"']/g, function(m) { return map[m]; });
        }
        function htmlspecialchars(str) {
         if (typeof(str) == "string") {
          str = str.replace(/&/g, "&amp;"); /* must do &amp; first */
          str = str.replace(/"/g, "&amp;quot;");
          str = str.replace(/'/g, "&#039;");
          str = str.replace(/</g, "&lt;");
          str = str.replace(/>/g, "&gt;");
          }
         return str;
         }

         function newSort() {
            var x = document.getElementById("changeSort").value;
            document.cookie = "sortBy="+x+";";
            window.location.reload(false);
         }


         var myNodelist = document.getElementsByTagName("LI");
         var i;
         for (i = 0; i < myNodelist.length; i++) {
           var span = document.createElement("SPAN");
           var txt = document.createTextNode("\u00D7");
           span.className = "close";
           span.appendChild(txt);
           myNodelist[i].appendChild(span);

         }
         
         // Click on a close button to hide the current list item
         var close = document.getElementsByClassName("close");
         var i;
         for (i = 0; i < close.length; i++) {
           close[i].onclick = function() {
             var div = this.parentElement;
             var arr = (div.innerHTML).split("<span");
             var uuid = idsToTitle[htmlspecialchars(arr[0].replace("\\",""))];
             $.post( "./includes/deleteTodo.php", { "UUID": uuid} )
                .done(function(data) {
                    window.location.reload(false); 
                });
           }
         }

        
         // Add a "checked" symbol when clicking on a list item
         var list = document.querySelector('ul');
         list.addEventListener('click', function(ev) {
           if (ev.target.tagName === 'LI') {
             ev.target.classList.toggle('checked');
           }
         }, false);
         
         // Create a new list item when clicking on the "Add" button
         function newElement() {
           var li = document.createElement("li");
           var inputValue = document.getElementById("myInput").value;
           inputValue = escapeHtml(inputValue);
           var t = document.createTextNode(inputValue);
           li.appendChild(t);
           if (inputValue === '') {
             document.getElementById("error").innerHTML = "Error: Please Enter a Value!"; 
             document.getElementById("error").style.marginTop = "10%";
             function removeErr() {
                setTimeout(function(){
                    document.getElementById("error").innerHTML = ""; 
                    document.getElementById("error").style.marginTop = "0%";
                }, 3000);
             }
             removeErr();
           } else {
            var keys = Object.keys(idsToTitle);
            for (var key in keys){
                if (key.toUpperCase() == inputValue.toUpperCase()){
                    document.getElementById("myInput").value = "";                    
                    document.getElementById("error").innerHTML = "Error: You Already Have a Note With That Name!"; 
                    document.getElementById("error").style.marginTop = "10%";
                    function removeErr() {
                       setTimeout(function(){
                           document.getElementById("error").innerHTML = ""; 
                           document.getElementById("error").style.marginTop = "0%";
                       }, 3000);
                    }
                    var copy = true;
                }
            }
            if (copy == true){
                removeErr();
            }else{
                 $.post( "./includes/addTodo.php", {"authUUID" : authUUID, "title" : inputValue} )
                    .done(function(data) {
                        window.location.reload(false); 
                    });
               }
               document.getElementById("myInput").value = "";
             
               var span = document.createElement("SPAN");
               var txt = document.createTextNode("\u00D7");
               span.className = "close";
               span.appendChild(txt);
               li.appendChild(span);
             
               for (i = 0; i < close.length; i++) {
                 close[i].onclick = function() {
                   var div = this.parentElement;
                   div.style.display = "none";
                 }
               }
           }
         }
      </script>
   </body>
</html>
