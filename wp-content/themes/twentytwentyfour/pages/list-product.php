<?php
/*
Template Name: List Product
*/


get_header();
echo do_shortcode("[hfe_template id='98']");
?>

<div id="header__product" class="flex flex-row"> </div>



<section class="filter__product flex justify-center flex-col items-center my-8 p-8">
    <h3 class="mt-8 mb-8">EXPLORE OUR OUTDOOR FURNITURE</h3>
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

<div class="list-product container mx-auto" id="product__collections">

</div>

<script>
    $(document).ready(function () {
        let category = [];

        $.ajax({
            url: "http://192.168.88.178:82/?rest_route=/wp/v2/product_service",
            type: "GET",
            success: (res) => {
                category.push(res)

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

        function loadAllProduct(page) {
            const all_product = [39, 30, 36, 32, 37, 23, 25, 28, 15, 31, 24];

            $.ajax({
                url: `https://platform.indospacegroup.com/v1_categories_det/${all_product[page]}/`,
                type: 'GET',
                headers: {
                    'Authorization': 'Token 09633df1426fce26fc53de676e8bb65f47a0dcf1'
                },
                beforeSend: () => {
                    // TODO :: ADD SKELETON
                },
                success: (res) => {
                    let findCategory = category[0].find(o => o.id.includes(all_product[page]))

                    let checkElement = $(`#cat-${findCategory.slug}`)


                    if (checkElement.length === 0) {
                        $('#product__collections').append(`<div class="mt-5 mb-5" id="cat-${findCategory.slug}">
                            <h3 class="text-center text-3xl uppercase mb-3">${findCategory.name}</h3>
    
                            <div id="list__cat-${findCategory.slug}" class="grid gap-4 grid-cols-3"></div>
                        </div>`)

                        // Append Filter
                        $('#filter_child').append(`
                            <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer" data-value="${findCategory.slug}">${findCategory.name}</li>
                        `)
                    }


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

                    $(`#list__cat-${findCategory.slug}`).append(product);

                    if (typeof all_product[page] !== undefined) {
                        loadAllProduct(page + 1)
                    } else {
                        stop = true
                    }
                },
                error: () => {
                    stop = true;
                }
            })
        }

        loadAllProduct(page)


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

            let getAllElement = $('#product__collections > div')
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
                    let idCat = $(getAllElement[key]).attr('id')
                    console.log(idselected)
                    if (idCat !== `cat-${idselected}`) {
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

    }) 
</script>