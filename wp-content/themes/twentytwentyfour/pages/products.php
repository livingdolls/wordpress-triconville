<?php
get_header();
echo do_shortcode("[hfe_template id='98']");
$character_slug = get_query_var('product');
?>
<div style='background-color:rgba(0, 0, 0, 0)'>
    <div class="container px-5 py-24 mx-auto" style="cursor: auto;">
        <div class="lg:w-4/5 mx-auto flex flex-wrap">
            <img id="main__image" alt="ecommerce" class="lg:w-1/2 w-full lg:h-auto h-64 object-cover object-center rounded"
                src="https://stackdiary.com/140x100.png" style="cursor: auto;">
            <div class="lg:w-1/2 w-full lg:pl-10 lg:py-6 mt-6 lg:mt-0" style="cursor: auto;">
                <h2 class="text-sm title-font text-gray-500 tracking-widest" style="cursor: auto;">ON SALE</h2>
                <h1 id="product__name" class="text-gray-900 text-3xl title-font font-medium mb-1" style="cursor: auto;"></h1>
                <div class="flex mb-4">
                    <span class="flex items-center">
                        <svg fill="currentColor" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2" class="w-4 h-4 text-indigo-500" viewBox="0 0 24 24">
                            <path
                                d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z">
                            </path>
                        </svg>
                        <svg fill="currentColor" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2" class="w-4 h-4 text-indigo-500" viewBox="0 0 24 24">
                            <path
                                d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z">
                            </path>
                        </svg>
                        <svg fill="currentColor" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2" class="w-4 h-4 text-indigo-500" viewBox="0 0 24 24">
                            <path
                                d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z">
                            </path>
                        </svg>
                        <svg fill="currentColor" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2" class="w-4 h-4 text-indigo-500" viewBox="0 0 24 24">
                            <path
                                d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z">
                            </path>
                        </svg>
                        <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2" class="w-4 h-4 text-indigo-500" viewBox="0 0 24 24">
                            <path
                                d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z">
                            </path>
                        </svg>
                        <span class="text-gray-600 ml-3">20 Reviews</span>
                    </span>
                    <span class="flex ml-3 pl-3 py-2 border-l-2 border-gray-200 space-x-2s">
                        <a class="text-gray-500">
                            <svg fill="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                class="w-5 h-5" viewBox="0 0 24 24">
                                <path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"></path>
                            </svg>
                        </a>
                        <a class="text-gray-500">
                            <svg fill="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                class="w-5 h-5" viewBox="0 0 24 24">
                                <path
                                    d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z">
                                </path>
                            </svg>
                        </a>
                        <a class="text-gray-500">
                            <svg fill="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                class="w-5 h-5" viewBox="0 0 24 24">
                                <path
                                    d="M21 11.5a8.38 8.38 0 01-.9 3.8 8.5 8.5 0 01-7.6 4.7 8.38 8.38 0 01-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 01-.9-3.8 8.5 8.5 0 014.7-7.6 8.38 8.38 0 013.8-.9h.5a8.48 8.48 0 018 8v.5z">
                                </path>
                            </svg>
                        </a>
                    </span>
                </div>
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
            },
            error: (xhr, status, error) => {
                console.error('Error fetching data:', error);
            }
        });
    });
</script>
