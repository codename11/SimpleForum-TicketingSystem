function toggleForm(elem){
    console.log(elem);
    var x = document.getElementById(elem);
    if (x.style.display == "block") {
        x.style.display = "none";
    } 
    else {
        x.style.display = "block";
    }

}

function funk(){
    alert();
}

$(document).ready( () => {

    /*let comments = document.getElementsByClassName("commBody");
    
    for(i=0;i<comments.length;i++){

        //.attr('parent_id')
        let parent = $(comments[i]);
        let child = $(comments[i]);
        
        console.log(parent.css("marginLeft"));
        console.log(parent.css({"marginLeft" : "20px"}));
        console.log(child.attr("id"));
 
    }*/

});

function ajax(me){

    let var1 = "gg";
    let var2 = "bruh";
    let token = document.querySelector("meta[name='csrf-token']").getAttribute("content");
    let url = "/posts";
  
    $.ajax({
      type: "POST",
      url: url,
      headers:{
              "X-CSRF-TOKEN": token
          },
      data: {
          var1: var1,
          var2: var2,
          elem: {
              id: me.id ? me.id : null,
              class: me.className ? me.className : null,
              value: me.value ? me.value : null,
              innerHTML: me.innerHTML ? me.innerHTML : null,
          }
      },
      success: (data) => {
          console.log(data);
      },
      error: (data) => {
        console.log(data);
      }
    });         
  
}