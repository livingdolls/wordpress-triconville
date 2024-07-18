<?php
/*
Template Name: List Product
*/


 get_header();
 echo do_shortcode("[hfe_template id='98']");
?>

<div id="header__product" class="flex flex-row"> </div>
<div class="list-product container mx-auto grid gap-4 grid-cols-3" id="product__collections">

</div>

<script>
    $(document).ready(function(){
        $.ajax({
            url: "http://192.168.88.178:82/?rest_route=/wp/v2/product_service",
            type: "GET",
            success : (res) => {
                console.log(res)

                res.forEach(e => {
                    const head_product = `
                        <div class="p-3">
                            <a href="http://192.168.88.178:82/selected/${e.id}">${e.name}</a>
                        </div>
                    `                

                    $('#header__product').append(head_product)
                });

            }
        })

        let page = 0;
        let stop = false;

        function loadAllProduct(page){
            const all_product = [39,30,36,32,37,23,25,28,15,31,24];
    
            $.ajax({
                url: `https://platform.indospacegroup.com/v1_categories_det/${all_product[page]}/`,
                type: 'GET',
                headers: {
                    'Authorization': 'Token 09633df1426fce26fc53de676e8bb65f47a0dcf1'
                },
                beforeSend : () => {
                    // TODO :: ADD SKELETON
                },
                success : (res) => {

                    let product = res.product_list.filter(k => k.brand === 3).map(pro => {
                        return `<a href="http://192.168.88.178:82/products/${pro.id}" class="product__card gap-2 product__id-${pro.id}">
                            <div class="container__image bg-gray-100 h-[384px] flex flex-col items-center justify-center">
                                <img src="${pro.product_image}" height="384px" width="384px" />
                            </div>

                            <div class="product__card-content p-2">
                                <h3>${pro.name}</h3>
                                <span>${pro.sku}</span>
                            </div>
                        </a>`;
                    }).join('')

                    $('#product__collections').append(product)

                    if(typeof all_product[page] !== undefined){
                        loadAllProduct(page + 1)
                    }else {
                        stop = true
                    }
                },
                error: () => {
                    stop = true;
                }
            })
        }

        loadAllProduct(page)

    }) 
</script>