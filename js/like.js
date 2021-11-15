 $(document).ready(function(){
    let likeBtn = $('.like_btn')
    let clicked = []
    for (var i = 0; i<likeBtn.length;i++ ){
      clicked[i] = false;
    }
    likeBtn.click(clickedbtn)
  
    
    
    function clickedbtn(){
    let index = $(this).attr("id")
    console.log(index)
    if (clicked[index] == false)
      {
        clicked[index] = true;
        $(".count-like")[index].textContent++;
        }else{
          clicked[index] = false;
          $(".count-like")[index].textContent--;
    
  
    }
  }
})

  



