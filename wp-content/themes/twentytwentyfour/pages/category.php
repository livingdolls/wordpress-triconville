<?php
    get_header();
    echo do_shortcode("[hfe_template id='98']");
    $character_slug = get_query_var( 'category' );
?>

<section class="header__category w-full flex flex-col">
    <h1 id="category__name" class="text-center text-3xl text-indigo-500"></h1>
    <p id="category__description" class="text-center"></p>
</section>

<section class="list__product">
    <div id="list__product" class="container mx-auto grid gap-4 grid-cols-3"></div>
</section>

<script>
$(document).ready(function () {
    $.ajax({
        url: `https://platform.indospacegroup.com/v1_categories_det/<?= $character_slug; ?>/`,
        type: 'GET',
        headers: {
            'Authorization': 'Token 09633df1426fce26fc53de676e8bb65f47a0dcf1'
        },
        beforeSend : () => {
            // TODO :: ADD SKELETON
        },
        success: (res) => {
            $('#category__name').append(res.name);
            $('#category__description').append(res.description);
            
            let productCards = res.product_list.filter(k => k.brand === 3).map(pro => {
                return `<a href="http://192.168.88.178:82/products/${pro.id}" class="product__card gap-2 product__id-${pro.id}">
                            <div class="container__image bg-gray-100 h-[384px] flex flex-col items-center justify-center">
                                <img src="${pro.product_image}" height="384px" width="384px" />
                            </div>

                            <div class="product__card-content p-2">
                                <h3>${pro.name}</h3>
                                <span>${pro.sku}</span>
                            </div>
                        </a>`;
            }).join('');
            
            $('#list__product').append(productCards);
        },
        error: (xhr, status, error) => {
            console.error('Error fetching data:', error);
        }
    });
});

</script>
