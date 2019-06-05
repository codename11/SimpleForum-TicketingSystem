function reply(elem){
    console.log(elem);
    var x = document.getElementById(elem);
    if (x.style.display == "block") {
        x.style.display = "none";
    } 
    else {
        x.style.display = "block";
    }


}

$(document).ready( () => {

    let comments = document.getElementsByClassName("commBody");
    
    for(i=0;i<comments.length;i++){

        //.attr('parent_id')
        let parent = $(comments[i]);
        let child = $(comments[i]);
        
        //console.log(parent.css("marginLeft"));
        //console.log(parent.css({"marginLeft" : "20px"}));
        //console.log(child.attr("id"));
 
    }

});