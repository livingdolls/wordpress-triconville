<?php


get_header();
echo do_shortcode("[hfe_template id='98']");
$character_slug = get_query_var('selected');
?>
<div id="header__product" class="flex flex-row bg-gray-100"> </div>


<section id="header__banner" class="banner relative"></section>

<section class="filter__product flex justify-center flex-col items-center my-8 p-8">
    <h3 id="title__page" class="uppercase mt-8 mb-8">EXPLORE OUR OUTDOOR </h3>
    <div class="relative inline-block w-64">
        <button id="dropdownButton"
            class="w-full flex flex-row justify-between bg-white border border-gray-950 text-gray-950 py-2 px-4 focus:outline-none focus:shadow-outline">
            All Types
            <svg class="w-5 h-5 float-right mt-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </button>
        <ul id="filter_child"
            class="absolute hidden w-full bg-white border border-gray-300 rounded mt-1 shadow-lg z-10">
        </ul>
    </div>
</section>

<section class="list__product">
    <div id="list__product" class="container mx-auto grid gap-4 grid-cols-3"></div>
</section>

<script>
    $(document).ready(function () {
        let parseFilter = "<?= $character_slug ?>".split("-");

        let check_ids = parseFilter[0].split(",");

        // BUILD SUB CATEGORY PRODUCT
        $.ajax({
            url: "http://192.168.88.178:82/?rest_route=/wp/v2/product_service",
            type: "GET",
            success: (res) => {

                res.forEach(e => {
                    const head_product = `
                        <div class="p-3">
                            <a href="http://192.168.88.178:82/selected/${e.id}">${e.name}</a>
                        </div>
                    `

                    $('#header__product').append(head_product)
                });

                // Get Category Page

                let findPosition = res.find(o => o.id.includes(parseFilter[0]))

                $('#header__banner').append(`
                    <img src="${findPosition.image}" alt="${findPosition.name}" width="1920" height="1079" />                
                    <h1 class="absolute inset-0 flex items-center justify-center text-white text-4xl md:text-6xl">${findPosition.name}</h1>
                `)

                $('#title__page').append(`${findPosition.name}`)

                // PUSH FILTER
                let findChild = res.find(e => e.id == parseFilter[0]);

                if (typeof findChild === 'object') {
                    let appendFilter = findChild.children.map(el => {
                        return `
                            <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer" data-value="${el.id}">${el.name}</li>
                        `;
                    }).join('');
                    $('#filter_child').append(appendFilter);
                }
            }
        })


        if (check_ids.length <= 1) {

            $.ajax({
                url: `https://platform.indospacegroup.com/v1_categories_det/${parseFilter[0]}/`,
                type: 'GET',
                headers: {
                    'Authorization': 'Token 09633df1426fce26fc53de676e8bb65f47a0dcf1',
                },
                beforeSend: () => {
                    // TODO ::SKELETON
                },
                success: function (res) {
                    if (parseFilter.length > 1) {
                        let pecah = parseFilter[1].split(",");

                        let makeFilter = res.product_list.filter(product => {
                            for (let filter of pecah) {
                                if (!product.name.toLowerCase().includes(filter.toLowerCase())) {
                                    return false;
                                }
                            }
                            return true;
                        });

                        buildProduct(res.product_list, parseFilter[0])
                    } else {
                        buildProduct(res.product_list, parseFilter[0])
                    }


                },
                error: function (xhr, status, error) {
                    console.error('Error fetching data:', error);
                }
            });
        } else {
            // REKURSIF
            let po = 0;
            let stop = false;

            function loadSelectionProduct(position) {
                $.ajax({
                    url: `https://platform.indospacegroup.com/v1_categories_det/${check_ids[position]}/`,
                    type: 'GET',
                    headers: {
                        'Authorization': 'Token 09633df1426fce26fc53de676e8bb65f47a0dcf1',
                    },
                    beforeSend: () => {
                        // TODO ::SKELETON
                    },
                    success: (res) => {
                        buildProduct(res.product_list, check_ids[position])

                        if (typeof check_ids[position] !== undefined) {
                            loadSelectionProduct(position + 1)
                        } else {
                            stop = true
                        }
                    },
                    error: () => {
                        stop = true;
                    }
                })
            }

            loadSelectionProduct(po)
        }

        const buildProduct = (product, id) => {
            let productCards = product.filter(k => k.brand === 3).map(pro => {
                return `<a href="http://192.168.88.178:82/products/${pro.id}" data-category="${id}" class="product__card border gap-2 product__id-${pro.id}">
                                        <div class="container__image h-[384px] flex flex-col items-center justify-center">
                                            <img src="${pro.product_image}" height="384px" width="384px" />
                                        </div>
            
                                        <div class="product__card-content p-2">
                                            <h3>${pro.name}</h3>
                                            <span>${pro.sku}</span>
                                        </div>
                                    </a>`;
            }).join('');
            $('#list__product').append(productCards);
        }

        // DROPDOWN
        $('#dropdownButton').click(function () {
            $('#filter_child').toggleClass('hidden');
        });

        $('#filter_child').on('click', 'li', function () {

            let checkReset = $('#filter_child li:first-child').attr('data-value')


            if (checkReset != 0) {
                $('#filter_child').prepend(
                    `<li class="px-4 py-2 hover:bg-gray-100 cursor-pointer" data-value="0">Reset Filter</li>`
                )
            }

            $('#filter_child').addClass('hidden');

            let getAllElement = $('#list__product .product__card')
            let idselected = $(this).attr('data-value')

            if (idselected == 0) {

                $('#filter_child li:first-child').remove();
                $('#dropdownButton').text('All Types').append('<svg class="w-5 h-5 float-right mt-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>');

                Object.keys(getAllElement).forEach((key) => {
                    $(getAllElement[key]).removeClass("hidden")
                })
            } else {
                var selectedText = $(this).text();
                $('#dropdownButton').text(selectedText).append(' <svg class="w-5 h-5 float-right mt-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>');
                Object.keys(getAllElement).forEach((key) => {
                    let idCat = $(getAllElement[key]).attr('data-category')
                    if (idCat !== idselected) {
                        $(getAllElement[key]).addClass("hidden")
                    } else {
                        $(getAllElement[key]).removeClass("hidden")
                    }
                })
            }


        });

        $(document).click(function (event) {
            if (!$(event.target).closest('#dropdownButton, #filter_child').length) {
                $('#filter_child').addClass('hidden');
            }
        });

    });
</script>

<style>
    .product__card {
        border-radius: 4px;
        transition: 0.3s;
    }
    
    .product__card:hover {
        box-shadow: 0 0 10px rgba(0,0,0,.2);
    }
</style>