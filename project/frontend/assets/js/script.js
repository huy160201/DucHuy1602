// frontend/assets/css/js/script.js
// - Gọi ajax khi click Thêm vào giỏ
$(document).ready(function() {
    $('.add-to-cart').click(function () {

        var product_id = $(this).attr('data-id');
        // Gọi ajax để thêm sp với id trên vào giỏ
        $.ajax({
            url: 'index.php?controller=cart&action=add',
            method: 'GET',
            data: {
                product_id: product_id
            },
            success: function(data) {
                $('.ajax-message').html('Thêm sản phẩm vào giỏ thành công').addClass('ajax-message-active');

                setTimeout(function(){
                    $('.ajax-message').removeClass('ajax-message-active');
                }, 3000);

                var cart_total = $('.cart-amount').html();
                // Tăng số lượng lên 1
                cart_total++;
                // Set lại kết quả mới số lượng hiện tại
                $('.cart-amount').html(cart_total);
                // TEmplate còn có trên mobile
                $('.cart-amount-mobile').html(cart_total);
            }
        });
    });
    /*$(".pagination").on("click", "li a", function (event) {
        event.preventDefault();
        var page = $(this).text();
        $.ajax({
            url: 'index.php?controller=product&action=ajaxPagination',
            method: 'GET',
            data: {page: page},
            success: function (data) {
                $('.product-wrap').html(data);
            }
        })
    })*/
});