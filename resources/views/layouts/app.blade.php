<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" style="height: 100vh;">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link rel = "icon" type = "image/ico" sizes = "16x16" href = "/images/MyApp.ico">
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{config("app.name", "LSAPP1")}}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/skripta.js') }}" defer></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Open+Sans'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  </head>
<body onload="startTime()">
        <div id="app" class="DisplayNone"></div>
        <?php
          $conflu = "";
        ?>
        @if(Route::getFacadeRoot()->current()->uri()=="profile/{id}")
          <?php
            $conflu = "-fluid";
          ?>
        @endif
        
        @include("inc.navbar")
        <div class="container mainContainer" style="margin-top: 70px;">
          @include("inc.messages")
          @yield("content")
        </div>
        
    
    <script src="/ckeditor/ckeditor.js"></script>
    <script>
        if(document.getElementById("ckeditor")){
            CKEDITOR.replace("ckeditor");
        }
    </script>

    <div class="footer navbar-dark bg-dark" style="z-index: 999;">
        <p class="mt-1" class="footCompany">© 2017-2019 Company Name</p>
        <ul class="list-inline">
            <li class="list-inline-item"><a class="footLinks" href="#">Privacy</a></li>
            <li class="list-inline-item"><a class="footLinks" href="#">Terms</a></li>
            <li class="list-inline-item"><a class="footLinks" href="#">Support</a></li>
        </ul>
    </div>

<script type="text/javascript">
  function startTime() {
    var today = new Date();
    var h = today.getHours();
    var m = today.getMinutes();
    var s = today.getSeconds();
    m = checkTime(m);
    s = checkTime(s);
    
    document.getElementById('clock').innerHTML = h + ":" + m + ":" + s;
    if(document.getElementById('clock')){

      document.getElementById('clock').innerHTML = h + ":" + m + ":" + s;

    }
    
    var t = setTimeout(startTime, 500);
  }

  function checkTime(i) {
    if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
    return i;
  }
  

</script>

<?php 
$route = Route::getFacadeRoot()->current()->uri();

if(isset($route) && ($route=="posts/{post}" || $route=="profile/{id}") && isset($comms) && isset($replies)){
?>
<script type="text/javascript" defer>
    
  let comments = {!!$comms!!}.filter((item) => {
    if(item.parent_id===0){
      return item;
    }
  });

  let replies = {!!$replies!!}.filter((item) =>{
    if(item.parent_id!==0){
      return item;
    }
  });
  
  for(i=0;i<comments.length;i++){

    if(comments[i].parent_id===0){
      document.getElementById(""+comments[i].id).style.marginLeft = "0px";
    }
    
    for(j=i;j<replies.length;j++){
      
      if(comments[i].id===replies[j].parent_id){

        let br1=document.getElementById(""+comments[i].id).style.marginLeft.substr(0, document.getElementById(""+comments[i].id).style.marginLeft.length-2);
        document.getElementById(""+replies[j].id).style.marginLeft = (Number(br1) + 10) + "px";
        
      }
      
      for(k=j;k<replies.length;k++){

        if(replies[k].parent_id===replies[j].id){

          let br2=document.getElementById(""+replies[j].id).style.marginLeft.substr(0, document.getElementById(""+replies[j].id).style.marginLeft.length-2);
          document.getElementById(""+replies[k].id).style.marginLeft = (Number(br2) + 10) + "px";

        }

      }

    }

  }
      
</script>
<?php
  }
?>  
<script>
// Accordion
function myFunction(id) {
  var elem = document.getElementById(id);
  if(elem){

    if (elem.className.indexOf("w3-show") == -1) {
      elem.className += " w3-show";
      elem.previousElementSibling.className += " w3-theme-d1";
    }
    else{ 
      elem.className = elem.className.replace("w3-show", "");
      elem.previousElementSibling.className = 
      elem.previousElementSibling.className.replace(" w3-theme-d1", "");
    }

  }
  
}

// Used to toggle the menu on smaller screens when clicking on the menu button
function openNav() {
  let navDemo = document.getElementById("navDemo");

  if(navDemo){

    if (navDemo.className.indexOf("w3-show") == -1) {
      navDemo.className += " w3-show";
    }
    else { 
      navDemo.className = navDemo.className.replace(" w3-show", "");
    }

  }
  
}

document.addEventListener("focus",function(e){

  if(CKEDITOR.instances["editable"]){
    if(e.target.id == "editable"){
        CKEDITOR.replace('editable');
    }
    else{
        CKEDITOR.instances["editable"].destroy();
    }
  }
    

}, true);

</script>
</body>
</html>