<?php
    get_header();
    echo do_shortcode("[hfe_template id='98']");
    $character_slug = get_query_var( 'collection' );
?>

<script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js "></script>
<link href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.css " rel="stylesheet">

<div id="collection__header" class="w-full flex flex-row gapx-5"></div>

<div id="container__<?=$character_slug ?>"></div>

<script>
    $(document).ready(function(){
        $.ajax({
            url: `https://platform.indospacegroup.com/v1_collections_det/<?= $character_slug ?>/`,
            type: 'GET',
            headers: {
                'Authorization' : 'Token 09633df1426fce26fc53de676e8bb65f47a0dcf1',
            },
            beforeSend: () => {
                // TODO ::SKELETON
            },
                success: function(res) {
                console.log(res);
                $('#container__<?= $character_slug ?>').append(`
                    <section class="banner relative">
                        <picture class="w-full">
                            <source media="(min-width:1920px)" srcset="${res.image_1920}">
                            <source media="(min-width:1024px)" srcset="${res.image_1024}">
                            <source media="(min-width:768px)" srcset="${res.image_768}">
                            <source media="(min-width:512px)" srcset="${res.image_512}">
                            <source media="(min-width:384px)" srcset="${res.image_384}">
                            <img src="${res.image}" alt="${res.name}" class="w-full">
                        </picture> 
                        <h1>${res.name}</h1>
                    </section>

                    <section class="collection__description mt-5 mb-5 grid grid-cols-2 gap-4">
                        <div class="collection__description-img">
                            <img class="w-full object-cover" src="${res.image_1024}" alt="${res.name}">
                        </div>
                        <div class="collection__description-content">
                            <h3>${res.name}</h3>
                            <p>${res.description}</p>
                        </div>
                    </section>

                    <section class="collection__ambience mt-5 mb-5">
                        ${res.ambience_image.map(am => `<div><img src="${am.image_1920}" alt="${am.alt_text}"></div>`).join('')}
                    </section>

                    <section class="collection__product relative">
                        <h3 class="text-center uppercase font-bold">${res.name} Collections</h3>
                        <button id="product__next"></button>
                        <div class="list__card grid grid-cols-3 mt-5 gap-4 container mx-auto">
                            ${res.product_list.map(pr => `<a href="http://192.168.88.178:82/products/${pr.id}" class="collection__product-card border">
                                <img src="${pr.product_image}" alt="${pr.alt_text}">    
                                <div class="px-5 py-3">
                                    <h3>${pr.name}</h3>
                                </div>
                            </a>`).join('')}
                        </div>
                        <button id="product__prev"></button>
                    </section>
                `);

                $('.collection__ambience').slick({
                    slidesToShow: 1, 
                    slidesToScroll: 1, 
                });

                $('.list__card').slick({
                    slidesToShow: 4, 
                    slidesToScroll: 1, 
                    prevArrow: $('#product__prev'),
                    nextArrow: $('#product__next'),
                });
            },
            error: function(xhr, status, error) {
                console.error('Error fetching data:', error);
            }
        });


        
    });
</script>



<style>
    section.banner > picture > img {
        max-height: 900px;
        object-fit: cover;
    }

    section.banner > h1 {
        color: white;
        font-size: 50px;
        font-weight: 300;
        letter-spacing: .30rem;
        text-align: center;
        left: 0;
        right: 0;
        z-index: 1;
        bottom: 50vh;
        line-height: 0;
        position: absolute;
    }

     .collection__product-card {
        height: auto;
        margin-left: 1rem;
        border-radius: 4px;
        box-shadow: 0 0 10px rgba(0,0,0,.2);
    }

    .collection__product-card:nth-child(1) {
        margin-left: 0.5rem;
    }

    .collection__product-card > img {
        height: 384px;
        width: 384px;
        object-fit: contain;
    }

    #product__prev, #product__next {
        height: 30px;
        width: 30px;
        position: absolute;
        margin: auto 0px;
        bottom: 0;
        top: 0;
    }

    #product__prev {
        background: url('https://triconville.co.id/static/version1720147324/frontend/Ammar/customtheme/en_US/css/slick/arrow-left.svg');
        left: 120px;
        background-size: cover;
    }

    #product__next {
        background: url('https://triconville.co.id/static/version1720147324/frontend/Ammar/customtheme/en_US/css/slick/arrow-right.svg');
        right: 120px;
        background-size: cover;
    }
</style>