
<?php
    if (!isset($_GET['id'])) {
        return "<h1>Hello World</h1>";
    }
    ?>

<!DOCTYPE html>
<html lang="">
    
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <title>Category</title>

</head>

<body>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <style>
        /* Your CSS styles */
        .navbar {
            overflow: hidden;
            background-color: #333;
            font-family: Arial;
        }
        .navbar a {
            float: left;
            font-size: 16px;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }
        .dropdown {
            float: left;
            overflow: hidden;
        }
        .dropdown .dropbtn {
            font-size: 16px;
            border: none;
            outline: none;
            color: white;
            padding: 14px 16px;
            background-color: inherit;
            font-family: inherit;
            margin: 0;
        }
        .navbar a:hover, .dropdown:hover .dropbtn {
            background-color: red;
        }
        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
        }
        .dropdown-content a {
            float: none;
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            text-align: left;
        }
        .dropdown-content a:hover {
            background-color: #ddd;
        }
        .dropdown:hover .dropdown-content {
            display: block;
        }

        .child__category__list {
            position:absolute;
            left: 100%;
            width: 100%;
            top: 0;
            bottom: 0;
            z-index: 99;
        }
    </style>

<div class="navbar" id="navbar__category"></div> 

<script>
    $(document).ready(function(){
        $.ajax({
            url: "http://192.168.88.178:82/?rest_route=/wp/v2/top-nav",
            type: 'GET',
            success: function(res) {
                res.forEach(e => {
                    if (e.name === 'Categories') {
                        $.ajax({
                            url: "https://platform.indospacegroup.com/v1_categories/",
                            type: 'GET',
                            headers: {
                                'Authorization' : 'Token 09633df1426fce26fc53de676e8bb65f47a0dcf1',
                            },
                            success: function(categoriesRes) {
                                let categoriesHtml = '<div id="categories__dropdown" class="dropdown-content">';
                                categoriesRes.results.forEach(k => {
                                    categoriesHtml += `
                                        <div class="child__category">
                                            <a>${k.name}</a>
                                            <ul class="child__category__list" style="display:none;">`;
                                    k.child_categories.forEach(l => {
                                        categoriesHtml += `<li><a href="http://192.168.88.178:82/categories?id=${l.id}">${l.name}</a></li>`;
                                    });

                                    categoriesHtml += `</ul></div>`;
                                });
                                categoriesHtml += '</div>';

                                $('#navbar__category').append(`
                                    <div class="dropdown categories__nav">
                                        <button class="dropbtn">${e.name}
                                            <i class="fa fa-caret-down"></i>
                                        </button>
                                        ${categoriesHtml}
                                    </div>
                                `);

                                $('.navbar').on('mouseover', '.child__category', function(){
                                    $(this).find('.child__category__list').show();
                                }).on('mouseout', '.child__category', function(){
                                    $(this).find('.child__category__list').hide();
                                });
                            },
                            error: function(xhr, status, error) {
                                console.error('Error fetching categories:', error);
                            }
                        });
                    } else {
                        $('#navbar__category').append(`
                            <div class="dropdown">
                                <a href="${e.href}" class="dropbtn">${e.name}
                                    <i class="fa fa-caret-down"></i>
                                </a>
                            </div>
                        `);
                    }
                });
            },
            error: function(xhr, status, error) {
                console.error('Error fetching top navigation items:', error);
            }
        });
    });
</script>
    <section style="display:flex; flex-direction:column">
        <h1 id="category__name"></h1>
        <p id="category__description"></p>
    
        <div class="container" style="display:flex; flex-direction:row;gap:5px; flex-wrap:wrap;">
    </section>
    </div>

</body>

</html>

<script>
    $(window).on('load',function(){
        let url = new URL(window.location.href);
        let c = url.searchParams.get("id");

        $.ajax({
            url: `https://platform.indospacegroup.com/v1_categories_det/${c}/`,
            type: 'GET',
            headers: {
                'Authorization' : 'Token 09633df1426fce26fc53de676e8bb65f47a0dcf1'
            },
            success: function(res) {
                $('#category__name').html(res.name)
                $('#category__description').html(res.description)
                res.product_list.forEach(e => {
                    $('.container').append(`
                                <div class="card">
                                <div class="imgBx">
                                    <img src="${e.product_image}" alt="nike-air-shoe">
                                </div>

                                <div class="contentBx">
                                    <h2>${e.name}</h2>
                                    <div class="size">
                                        <h3>Size :</h3>
                                        <span>7</span>
                                        <span>8</span>
                                        <span>9</span>
                                        <span>10</span>
                                    </div>

                                    <div class="color">
                                        <h3>Color :</h3>
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                    </div>
                                    <a href="http://localhost:82/categories/product.php?id=${e.id}">${e.name}</a>
                                </div>
                            </div>
                    `)
                });
            }
        });
    }); 
</script>

<style>
    @import url('https://fonts.googleapis.com/css?family=Poppins:100,300,400,500,600,700,800, 800i, 900&display=swap');

* {
    padding: 0;
    margin: 0;
    font-family: 'Poppins', sans-serif;
}

body {
    min-height: 100vh;
    /* background: #131313; */
}

.container {
    position: relative;
}

.container .card {
    position: relative;
    width: 320px;
    height: 450px;
    background: #232323;
    border-radius: 20px;
    overflow: hidden;
}

.container .card:before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: #1BBFE9;
    clip-path: circle(150px at 80% 20%);
    transition: 0.5s ease-in-out;
}

.container .card:hover:before {
    clip-path: circle(300px at 80% -20%);
}

.container .card .imgBx {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    z-index: 1000;
    width: 100%;
    height: 100%;
    transition: .5s;
}

.container .card:hover .imgBx {
    top: 0%;
    transform: translateY(-25%);
    /* bug  */
}

.container .card .imgBx img {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 270px;
}

.container .card .contentBx {
    position: absolute;
    bottom: 0;
    width: 100%;
    height: 100px;
    text-align: center;
    transition: 1s;
    z-index: 90;
}

.container .card:hover .contentBx {
    height: 210px;
}

.container .card .contentBx h2 {
    position: relative;
    font-weight: 600;
    letter-spacing: 1px;
    color: #fff;
}

.container .card .contentBx .size,
.container .card .contentBx .color {
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 8px 20px;
    transition: .5s;
    opacity: 0;
    visibility: hidden;
}

.container .card:hover .contentBx .size {
    opacity: 1;
    visibility: visible;
    transition-delay: .5s;
}

.container .card:hover .contentBx .color {
    opacity: 1;
    visibility: visible;
    transition-delay: .6s;
}

.container .card .contentBx .size h3,
.container .card .contentBx .color h3 {
    color: white;
    font-weight: 300;
    font-size: 14px;
    text-transform: uppercase;
    letter-spacing: 2px;
    margin-right: 10px;
}

.container .card .contentBx .size span {
    width: 26px;
    height: 26px;
    text-align: center;
    line-height: 26px;
    font-size: 14px;
    display: inline-block;
    color: #111;
    background: #fff;
    margin: 0 5px;
    transition: .5s;
    color: #111;
    border-radius: 4px;
    cursor: pointer;
}

.container .card .contentBx .size span:hover {  /* other bug */
    background: #B90000;
}

.container .card .contentBx .color span {
    width: 20px;
    height: 20px;
    background: #ff0;
    border-radius: 50%;
    margin: 0 5px;
    cursor: pointer;
}

.container .card .contentBx .color span:nth-child(2) {
     background: #1BBFE9;
}

.container .card .contentBx .color span:nth-child(3) {
     background: #1B2FE9;
}

.container .card .contentBx .color span:nth-child(4) {
     background: #080481;
}

.container .card .contentBx a {
    display: inline-block;
    padding: 10px 20px;
    background: #fff;
    border-radius: 4px;
    margin-top: 10px;
    text-decoration: none;
    font-weight: 600;
    color: #111;
    opacity: 0;
    transform: translateY(50px);
    transition: .5s;
}

.container .card:hover .contentBx a {
    opacity: 1;
    transform: translateY(0px);
    transition-delay: .7s;
} 
</style>