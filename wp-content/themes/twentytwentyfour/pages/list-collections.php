<?php
/*
Template Name: List Collections
*/

    get_header();
    echo do_shortcode("[hfe_template id='98']");
?>

<div id="collection__header" class="w-full flex flex-row gapx-5"></div>

<section class="container__collections">
    <div class="list__collections flex flex-col" id="list__collections"></div> 
</section>

    <script>
        $(document).ready(function(){
            let page = 1;
            let isLoading = false;
            let stop = false;
    
            function loadCollections(page) {
                isLoading = true;
                $('#loadingIndicator').show();

                let tcv_collection = [4,9,24,17,2,15,19,20,11,14,22,5];
    
                $.ajax({
                    url: `https://platform.indospacegroup.com/v1_collections/?page=${page}`,
                    type: 'GET',
                    headers: {
                        'Authorization' : 'Token 09633df1426fce26fc53de676e8bb65f47a0dcf1',
                    },
                    success: function(res) {

                        let filterCollection = res.results.filter(k => {
                            return tcv_collection.includes(k.id)
                        })                    

                        filterCollection.forEach(e => {                            
                            const collectionCard = `
                                <a href="http://192.168.88.178:82/collections/${e.id}" class="card__collections relative my-5">
                                    <img class="w-full object-cover" src="${e.collection_image_1920}" alt="${e.name}" width="1920" height="1079" />

                                    <div class="card__content absolute px-3 py-5">
                                        <h2 class="text-8xl text-white font-bold">${e.name}</h2>
                                    </div>
                                </a>
                            `;
                            $('#list__collections').append(collectionCard);

                            const head__col = `
                                <div class="p-3">
                                    <a href="http://192.168.88.178:82/collections/${e.id}">${e.name}</a>    
                                </div>
                            `

                            $('#collection__header').append(head__col)
                        });
    
                        if (res.next) {
                            loadCollections(page + 1);
                        } else {
                            stop = true;
                            // $('#loadingIndicator').hide(); 
                        }
    
                        isLoading = false;
                    },
                    error: function(xhr, status, error) {
                        isLoading = false;
                        stop = true;
                        // $('#loadingIndicator').hide();
                        // $('#errorIndicator').show(); 
                    }
                });
            }
    
            loadCollections(page);
        });
    </script>
    
<style>
    .card__content {
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }
</style>