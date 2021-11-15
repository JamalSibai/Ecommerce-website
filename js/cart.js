if (document.readyState == 'loading') {
    document.addEventListener('DOMContentLoaded', ready)
} else {
    ready()
}
function ready(){
    var removeCartItemButtons = document.getElementsByClassName("btn btn-main btn-large btn-round ja");
    for (var i = 0; i < removeCartItemButtons.length; i++) {
        var button = removeCartItemButtons[i];
        button.addEventListener('click', removeCartItem);
    }
    var quantityInputs = document.getElementsByClassName('cart_quantity')
    for (var i = 0; i < quantityInputs.length; i++) {
        var input = quantityInputs[i]
        input.addEventListener('change', quantityChanged)
    }
    
    var addToCartButtons = document.getElementsByClassName('shop_item_button')
    for (var i = 0; i < addToCartButtons.length; i++) {
        var button = addToCartButtons[i]
        button.addEventListener('click', addToCartClicked)
    }
    var checkOutButton = document.getElementById("checkout")
    checkOutButton.addEventListener('click',checkingOut)

     
}
function checkingOut(){
    const xhr = new XMLHttpRequest();
        var cartProductsId = document.getElementsByClassName('cart-product-id')
        var cartItemsQuantity = document.getElementsByClassName('cart_quantity')
        var arrayOfItems = [];
        for(i=0;i<cartProductsId.length;i++){
            arrayOfItems[i] = [cartProductsId[i].innerHTML,cartItemsQuantity[i].value];
        }
        
        

        xhr.onload = function(){
            const serverResponse = document.getElementById("resultAjax");
            serverResponse.innerHTML = this.responseText;
        };

        xhr.open("POST","php/AJAXCart.php");
        xhr.setRequestHeader("content-type", "application/x-www-form-urlencoded");
        console.log(arrayOfItems)
        xhr.send(arrayOfItems)
        let toDelete = document.getElementById("all-delete")
            toDelete.innerHTML = ""
            
        

        
        
    
}


function removeCartItem(event){
    var buttonClicked = event.target
    buttonClicked.parentElement.parentElement.remove()

}

function quantityChanged(event) {
    var input = event.target
    if (isNaN(input.value) || input.value <= 0) {
        input.value = 1
    }
    
}

function addToCartClicked(event) {
    var button = event.target
    var shopItem = button.parentElement.parentElement
    var title = shopItem.getElementsByClassName('shop-item-title')[0].innerText
    var imageSrc = shopItem.getElementsByClassName('shop-item-image')[0].src
    var cartItemsId = shopItem.getElementsByClassName('prodoct-id')[0].innerHTML
    addItemToCart(title, imageSrc,cartItemsId)
}

function addItemToCart(title, imageSrc, cartItemsId) {
    var cartRow = document.createElement('tr')
    cartRow.classList.add('cart-row')
    var cartItems = document.getElementsByClassName('cart-items')[0]
    var cartRowContents =  `
    
    <td class="in-cart-items">
      <div class="product-info">
        <img class = "cart_image" width="80" src="${imageSrc}" alt="" />
        <span class="item">${title}</span>
      </div>
    </td>
    <td class="cart-product-id" type="number">${cartItemsId}</td>
    <td class="quantity" type="number"><input class = "cart_quantity" type="number" value = "1"></td>
    <td class="">
    <button type ="button" class="btn btn-main btn-large btn-round ja" id="remove_btn">
      <span id="icon"><i >Remove</i></span>
      </button>
    </td>
  </tr>`
    cartRow.innerHTML = cartRowContents
    cartItems.append(cartRow)
    cartRow.getElementsByClassName("btn btn-main btn-large btn-round ja")[0].addEventListener('click', removeCartItem)
    cartRow.getElementsByClassName('cart_quantity')[0].addEventListener('change', quantityChanged)
    
    

    
}