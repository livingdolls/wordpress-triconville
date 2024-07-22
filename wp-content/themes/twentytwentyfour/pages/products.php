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
            <div class="image__gallery" style="max-width:900px">
                <div class="grid gap-4">
                    <div id="main_slider" class="slick-slider">
                    </div>

                    <!-- Thumbnail Navigation -->
                    <div id="thumbnail_slider" class="slick-slider mt-2 grid grid-cols-5 gap-4">
                    </div>
                </div>
            </div>
            <div class="lg:w-1/2 w-full lg:pl-10 lg:py-6 mt-6 lg:mt-0" style="cursor: auto;">
                <h1 id="product__name" class="text-gray-900 text-3xl title-font font-medium mb-1" style="cursor: auto;">
                </h1>
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
        
        <div class="specification__section grid grid-cols-2 container mx-auto">
            <div class="product__spec" id="table__spec"></div>
            <div class="image__spec"></div>
        </div>

        <div class="ambience__section">
            <div class="ambience__img grid grid-cols-3 gap-4"></div>
        </div>

        <div class="inthis__section">
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
                            <img src="${url}" alt="Thumbnail" class="w-40 h-auto cursor-pointer">
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
                        $('#table__spec').append(`<tr><td>Overall - ${e.description}</td><td> ${e.width} x ${e.depth} x ${e.height} CM</td></tr>`);
                    });
                }

                // Append box dimensions
                if (dimensions.ps_box_dimension) {
                    dimensions.ps_box_dimension.forEach((e) => {
                        $('#table__spec').append(`<tr><td>Box - ${e.description}</td><td>${e.width} x ${e.depth} x ${e.height} CM</td></tr>`);
                    });
                }

                // Append other properties
                if (dimensions.ps_clearance_from_floor) {
                    $('#table__spec').append(`<tr><td>Clearance from Floor</td><td>${dimensions.ps_clearance_from_floor}</td></tr>`);
                }
                if (dimensions.ps_table_top_thickness) {
                    $('#table__spec').append(`<tr><td>Table Top Thickness</td><td>${dimensions.ps_table_top_thickness}</td></tr>`);
                }
                if (dimensions.ps_distance_between_legs) {
                    $('#table__spec').append(`<tr><td>Distance Between Legs</td><td>${dimensions.ps_distance_between_legs}</td></tr>`);
                }
                if (dimensions.ps_arm_height) {
                    $('#table__spec').append(`<tr><td>Arm Height</td><td>${dimensions.ps_arm_height}</td></tr>`);
                }
                if (dimensions.ps_seat_height) {
                    $('#table__spec').append(`<tr><td>Seat Height</td><td>${dimensions.ps_seat_height}</td></tr>`);
                }
                if (dimensions.ps_seat_depth) {
                    $('#table__spec').append(`<tr><td>Seat Depth</td><td>${dimensions.ps_seat_depth}</td></tr>`);
                }
                if (dimensions.ps_nett_weight) {
                    $('#table__spec').append(`<tr><td>Nett Weight</td><td>${dimensions.ps_nett_weight}</td></tr>`);
                }
                if (dimensions.ps_gross_weight) {
                    $('#table__spec').append(`<tr><td>Gross Weight</td><td>${dimensions.ps_gross_weight}</td></tr>`);
                }
                if (dimensions.ps_pax) {
                    $('#table__spec').append(`<tr><td>PAX</td><td>${dimensions.ps_pax}</td></tr>`);
                }
                if (dimensions.ps_20ft_container) {
                    $('#table__spec').append(`<tr><td>20ft Container</td><td>${dimensions.ps_20ft_container}</td></tr>`);
                }
                if (dimensions.ps_40hq_container) {
                    $('#table__spec').append(`<tr><td>40HQ Container</td><td>${dimensions.ps_40hq_container}</td></tr>`);
                }
                if (dimensions.cbm) {
                    $('#table__spec').append(`<tr><td>CBM</td><td>${dimensions.cbm}</td></tr>`);
                }

                $('.image__spec').append(`<img src="${res.spec_image}" alt="specification product" height="512" width="512" />`)

                res.ambience_image.forEach((e) => {
                    $('.ambience__img').append(`
                        <img src="${e}" class="mr-2" />
                    `)
                })

                $('.ambience__img').slick({
                    slidesToShow: 3,
                    slidesToScroll: 1,
                    arrows: false,
                });

                res.collection_product.forEach((e) => {
                    $('.collection__product').append(`
                        <div class="product__card">
                            <img src="${e.product_image}" />
                        </div>                    
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
    }

    #thumbnail_slider img {
        border-radius: 8px;
        border: 2px solid transparent;
        transition: border-color 0.3s ease;
    }

    #thumbnail_slider .slick-current img {
        border-color: #4a90e2;
    }
</style>