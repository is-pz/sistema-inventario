window.onload = function (e){

    let selectProducts = document.querySelector('#idProducto')
    let inputPrice = document.querySelector('#precioVenta')

   selectProducts.addEventListener('change', () =>{
        let priceProduct = selectProducts.options[selectProducts.selectedIndex].getAttribute('data-precio')
        inputPrice.value = priceProduct
   })

}