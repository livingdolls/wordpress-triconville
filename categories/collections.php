<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.tailwindcss.com"></script>
<section class="container__collections">
    <div class="list__collections grid grid-cols-3 gap-4" id="list__collections"></div> 
</section>

<script>
        $(document).ready(function(){
            let page = 1;
            let isLoading = false;
            let stop = false;

            function loadCollections(page) {
                isLoading = true;
                $.ajax({
                    url: `https://platform.indospacegroup.com/v1_collections/?page=${page}`,
                    type: 'GET',
                    headers: {
                        'Authorization' : 'Token 09633df1426fce26fc53de676e8bb65f47a0dcf1',
                    },
                    success: function(res) {
                        res.results.forEach(e => {
                            const collectionCard = `
                                <a href="http://192.168.88.178:82/collections/${e.id}" class="card__collections">
                                    <img class="w-full object-cover" src="${e.collection_image_512}" alt="${e.name}" />
                                    <div class="card__content px-3 py-5">
                                        <h3>${e.name}</h3>
                                        <p>${e.description}</p>
                                    </div>
                                </a>
                            `;
                            $('#list__collections').append(collectionCard);
                        });
                        isLoading = false;
                    },
                    error: function(xhr, status, error) {
                        isLoading = false;
                        stop = true;
                    }
                });
            }

            // Initial load
            loadCollections(page);

            $(window).scroll(function() {
                if ($(window).scrollTop() + $(window).height() >= $(document).height() - 100) {
                    if (!isLoading && !stop) {
                        page++;
                        loadCollections(page);
                    }
                }
            });
        });
    </script>

<style>
    .container__collections {
        max-width: 1440px;
        margin: 0px auto;
    }

    .card__collections {
        border-radius: 4px;
        box-shadow: 0 0 10px rgba(0,0,0,.2);
        margin-bottom: 1rem;
        display: block;
        color: inherit;
        background-color: #fff;
        text-decoration: none;
        overflow: hidden;
        transition: .5s all ease-in-out;
    }

    .card__collections > img {
        max-height: 262px;
    }

    .card__collections > .card__content > h3 {
        font-size: 28px;
        font-weight: 500;
        line-height: 40px;
        text-align: left;
        color: #000;
    }

    .card__collections > .card__content > p {
        font-size: 16px;
        font-weight: 400;
        line-height: 24px;
        text-align: left;
        color: #000;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        display: -webkit-box;
        overflow: hidden;
    }
</style>