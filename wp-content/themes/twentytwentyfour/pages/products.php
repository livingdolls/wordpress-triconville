<?php
get_header();
echo do_shortcode("[hfe_template id='98']");
$character_slug = get_query_var('product');
?>
<script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js "></script>
<link href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.css " rel="stylesheet">
<!-- Fancybox -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css">
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
<div>
    <div class="px-5 py-24 mx-auto" style="cursor: auto;">
        <div class="lg:w-4/5 mx-auto flex flex-row">
            <div class="image__gallery" style="max-width:960px">
                <div class="grid gap-4">
                    <div id="main_slider" class="slick-slider">
                    </div>

                    <!-- Thumbnail Navigation -->
                    <div id="thumbnail_slider" class="slick-slider mt-2 grid grid-cols-5 gap-4">
                    </div>
                </div>
            </div>
            <div class="lg:w-1/2 w-full lg:pl-10 lg:py-6 mt-6 lg:mt-0" style="cursor: auto;">
                <h1 id="product__name" class="text-gray-900 text-3xl title-font font-medium mb-1" style="cursor: auto;"></h1>
                <p id="product__sku" class="mb-3"></p>
                <p class="leading-relaxed" id="product__desc"></p>
                <div class="flex flex-col align mt-6 pb-5 border-b-2 border-gray-100 mb-5">
                    <div class="flex gap-1" id="option_1">
                        <span class="mr-3" id="label_1"></span>
                    </div>

                    <div class="flex gap-1" id="option_2">
                        <span class="mr-3" id="label_2"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="specification__section grid grid-cols-2 container mx-auto gap-4">
        <div>
            <h3 class="font-bold text-3xl mb-3">Product Specification</h3>
            <table class="product__spec w-full" id="table__spec"></table>
        </div>
        <div class="image__spec"></div>
    </div>

    <div class="ambience__section container mt-8 mb-8 mx-auto">
        <div class="ambience__img"></div>
    </div>

    <div class="inthis__section container mx-auto">
        <h3 class="text-center font-bold mb-3 text-3xl">IN THIS COLLECTIONS</h3>
        <div class="collection__product grid grid-cols-4 gap-4"></div>
    </div>
</div>

<script>
    jQuery(document).ready(function ($) {
        $.ajax({
            url: `https://platform.indospacegroup.com/v1_products_det/<?= $character_slug ?>/`,
            type: 'GET',
            headers: {
                'Authorization': 'Token 09633df1426fce26fc53de676e8bb65f47a0dcf1',
            },
            beforeSend: () => {
                // TODO ::SKELETON
            },
            success: (res) => {
                console.log(res);
                $('#product__name').html(res.name);
                $('#main__image').attr('src', res.product_image);
                $('#product__desc').html(res.description)
                $('#product__sku').html(res.sku)

                let allImages = [...res.technical_image, ...res.ambience_image];

                console.log(allImages)

                allImages.forEach((url) => {
                    $('#main_slider').append(`
                        <div>
                            <a href="${url}" data-fancybox="gallery" data-caption="Image">
                                <img src="${url}" alt="Image" class="w-full h-auto">
                            </a>
                        </div>
                    `);

                    $('#thumbnail_slider').append(`
                        <div>
                            <img src="${url}" alt="Thumbnail" class="w-[100px] h-[100px] object-contain mr-5 cursor-pointer">
                        </div>
                    `);
                });

                $('#main_slider').slick({
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    arrows: false,
                    fade: true,
                    asNavFor: '#thumbnail_slider'
                });

                $('#thumbnail_slider').slick({
                    slidesToShow: 4,
                    slidesToScroll: 1,
                    asNavFor: '#main_slider',
                    focusOnSelect: true,
                    arrows: false,
                    centerMode: true,
                    centerPadding: '0',
                    variableWidth: true
                });

                if (res.option1 && Array.isArray(res.option1)) {
                    $('#label_1').text(res.label1)
                    res.option1.forEach(opt => {
                        $('#option_1').append(
                            `<button class="w-5 h-5 rounded-full" style="background-image:url(${opt.img_link})"></button>`
                        );
                    });
                }

                if (res.option2 && Array.isArray(res.option2)) {
                    $('#label_2').text(res.label2)
                    res.option2.forEach(opt2 => {
                        $('#option_2').append(
                            `<button class="w-5 h-5 rounded-full" style="background-image:url(${opt2.img_link})"></button>`
                        );
                    });
                }

                // APPEND DIMENSION
                let dimensions = res.dimension;

                // Append overall dimensions
                if (dimensions.ps_overal_dimension) {
                    dimensions.ps_overal_dimension.forEach((e) => {
                        $('#table__spec').append(`<tr><td class="border-b p-2">Overall - ${e.description}</td><td class="border-b p-2"> ${e.width} x ${e.depth} x ${e.height} CM</td></tr>`);
                    });
                }

                // Append box dimensions
                if (dimensions.ps_box_dimension) {
                    dimensions.ps_box_dimension.forEach((e) => {
                        $('#table__spec').append(`<tr><td class="border-b p-2">Box - ${e.description}</td><td class="border-b p-2">${e.width} x ${e.depth} x ${e.height} CM</td></tr>`);
                    });
                }

                // Append other properties
                if (dimensions.ps_clearance_from_floor) {
                    $('#table__spec').append(`<tr><td class="border-b p-2">Clearance from Floor</td><td class="border-b p-2">${dimensions.ps_clearance_from_floor}</td></tr>`);
                }
                if (dimensions.ps_table_top_thickness) {
                    $('#table__spec').append(`<tr><td class="border-b p-2">Table Top Thickness</td><td class="border-b p-2">${dimensions.ps_table_top_thickness}</td></tr>`);
                }
                if (dimensions.ps_distance_between_legs) {
                    $('#table__spec').append(`<tr><td class="border-b p-2">Distance Between Legs</td><td class="border-b p-2">${dimensions.ps_distance_between_legs}</td></tr>`);
                }
                if (dimensions.ps_arm_height) {
                    $('#table__spec').append(`<tr><td class="border-b p-2">Arm Height</td><td class="border-b p-2">${dimensions.ps_arm_height}</td></tr>`);
                }
                if (dimensions.ps_seat_height) {
                    $('#table__spec').append(`<tr><td class="border-b p-2">Seat Height</td><td class="border-b p-2">${dimensions.ps_seat_height}</td></tr>`);
                }
                if (dimensions.ps_seat_depth) {
                    $('#table__spec').append(`<tr><td class="border-b p-2">Seat Depth</td><td class="border-b p-2">${dimensions.ps_seat_depth}</td></tr>`);
                }
                if (dimensions.ps_nett_weight) {
                    $('#table__spec').append(`<tr><td class="border-b p-2">Nett Weight</td><td class="border-b p-2">${dimensions.ps_nett_weight}</td></tr>`);
                }
                if (dimensions.ps_gross_weight) {
                    $('#table__spec').append(`<tr><td class="border-b p-2">Gross Weight</td><td class="border-b p-2">${dimensions.ps_gross_weight}</td></tr>`);
                }
                if (dimensions.ps_pax) {
                    $('#table__spec').append(`<tr><td class="border-b p-2">PAX</td><td class="border-b p-2">${dimensions.ps_pax}</td></tr>`);
                }
                if (dimensions.ps_20ft_container) {
                    $('#table__spec').append(`<tr><td class="border-b p-2">20ft Container</td><td class="border-b p-2">${dimensions.ps_20ft_container}</td></tr>`);
                }
                if (dimensions.ps_40hq_container) {
                    $('#table__spec').append(`<tr><td class="border-b p-2">40HQ Container</td><td class="border-b p-2">${dimensions.ps_40hq_container}</td></tr>`);
                }
                if (dimensions.cbm) {
                    $('#table__spec').append(`<tr><td class="border-b p-2">CBM</td><td class="border-b p-2">${dimensions.cbm}</td></tr>`);
                }

                $('.image__spec').append(`<img src="${res.spec_image}" alt="specification product" height="512" width="512" />`)

                res.ambience_image.forEach((e) => {
                    $('.ambience__img').append(`
                        <img src="${e}" class="mr-5 max-h-[430px] cover" />
                    `)
                })

                $('.ambience__img').slick({
                    slidesToShow: 2,
                    slidesToScroll: 1,
                    arrows: false,
                });

                res.collection_product.forEach((pr) => {
                    $('.collection__product').append(`
                    <a href="http://192.168.88.178:82/products/${pr.id}" class="collection__product-card mr-5 border">
                                        <img src="${pr.product_image}" class="h-[384px] w-[384px] object-contain" alt="${pr.alt_text}">    
                                        <div class="px-5 py-3">
                                            <h3>${pr.name}</h3>
                                        </div>
                                    </a>
                    `)
                })

                $('.collection__product').slick({
                    slidesToShow: 4,
                    slidesToScroll: 1,
                    arrows: false,
                });
            },
            error: (xhr, status, error) => {
                console.error('Error fetching data:', error);
            }
        });
    });
</script>

<style>
    .slick-slider {
        max-width: 100vw;
        width: 100%;
        overflow: hidden !important;
    }


    #main_slider img {
        border-radius: 8px;
        max-height: 630px;
        object-fit: contain;
    }

    #thumbnail_slider img {
        border-radius: 8px;
        border: 1px solid #c8c8c8;
        transition: border-color 0.3s ease;
    }

    #thumbnail_slider .slick-current img {
        border-color: #4a90e2;
    }

    .collection__product-card:hover {
        box-shadow: 0 0 10px rgba(0,0,0,.2);
    }

    .collection__product-card {
        transition: 0.3s;
    }
</style>