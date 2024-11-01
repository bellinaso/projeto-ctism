<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookease - Estabelecimentos</title>
    <link rel="stylesheet" href="/public/css/establishments.css">
    <link rel="stylesheet" href="/public/css/components/red_button.css">
    <link rel="stylesheet" href="/public/css/components/header.css">
    <script src="../config.js"></script>
</head>

<body>
    <header>
        <div class="header">
            <div class="logo">
                <a href="/view/index.php">
                    <img src="/public/images/logos_horizontal/logo1_white.svg" alt="" class="logo_image">
                </a>
            </div>
            <div class="header_buttons">
                <div class="account_pages">
                    <a href="/view/myaccount.php">
                        <img class="profile_picture" src="/public/images/profile_picture.svg" alt="">
                    </a>
                    <div>
                        <?php
                            require_once '../controller/map_controller.php';
                            require_once '../controller/establishments_controller.php';
                            require_once '../controller/category_controller.php';
                
                            
                            $establishments = get_establishments();
                            $categories = get_category();
                            $jsonLocations = json_encode(get_locations());


                            if(!isset($_SESSION['login'])) {
                                echo '
                                    <span class="account_buttons">
                                        <a href="/view/login.php">
                                            ENTRE
                                        </a>
                                        <span>ou</span>
                                    </span>
                                    <span class="account_buttons">
                                        <a href="/view/register.php">
                                            CADASTRE-SE
                                        </a>
                                    </span>
                                ';
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main>
        <div class="search_bar_section">
            <h2>Economize seu tempo, agende agora!</h2>
            <form action="">
                <input type="search" name="" id="" placeholder="Pesquisar..." class="search_bar">
                <button type="submit" class="search_button">
                    <img src="/public/images/search_icon.svg" alt="">
                </button>
            </form>
            <div class="categories_section">
                <?php
                    foreach($categories as $c) {
                        echo '
                            <a href="">
                                <div class="category">
                                    '.$c['name'].'
                                </div>
                            </a>
                        ';
                    }
                ?>
            </div>
        </div>

        <div class="establishments_section">
            <div class="establishments_map" id="map">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2380.7735064094045!2d-53.81585528907984!3d-29.70293949589504!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9503cb7a4a7f533f%3A0xe441de11746b83df!2sR.%20C%C3%A2ndida%20Vargas%2C%2030%20-%20Nossa%20Sra.%20Medianeira%2C%20Santa%20Maria%20-%20RS%2C%2097060-100!5e0!3m2!1spt-BR!2sbr!4v1730141735726!5m2!1spt-BR!2sbr" width="90%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>

            <div class="establishments_list">
                <?php
                    foreach($establishments as $e) {
                        echo '
                            <div class="establishment">

                                <div class="establishment_image">
                                    <a href="#">
                                        <img src="/public/images/image_icon.svg" alt="" class="image_icon">
                                    </a>
                                </div>

                                <div class="establishment_info">
                                    <h3>
                                        <a href="#">
                                        '.$e['name'].'
                                        </a>
                                    </h3>
                                    <p>
                                        <span>Descrição: </span>
                                        '.$e['description'].'
                                    </p>
                                    <p>
                                        <span>Categoria: </span>
                                        '.$e['category'].'
                                    </p>
                                    <p>
                                        <span>Endereço: </span>
                                        '.$e['address'].'
                                    </p>
                                </div>

                                <div class="open_establishment">
                                    <a href="#">
                                        <img src="/public//images/open_in_new_window.svg" alt="">
                                    </a>
                                </div>

                        </div>
                        ';
                    }
                ?>
                
                <!-- <div class="establishment">

                    <div class="establishment_image">
                        <a href="#">
                            <img src="/public/images/image_icon.svg" alt="" class="image_icon">
                        </a>
                    </div>

                    <div class="establishment_info">
                        <h3>
                            <a href="#">Restaurante Tal</a>
                        </h3>
                        <p>
                            <span>Descrição: </span>
                            Oferecemos uma experiência única, com pratos que celebram o melhor da culinária nacional em um ambiente acolhedor. Sabores frescos para momentos inesquecíveis.
                        </p>
                        <p>
                            <span>Categoria: </span>
                            Gastronomia
                        </p>
                        <p>
                            <span>Endereço: </span>
                            Rua Presidente Fulanilson, 30
                        </p>
                    </div>

                    <div class="open_establishment">
                        <img src="/public//images/open_in_new_window.svg" alt="">
                    </div>

                </div> -->

            </div>
        </div>
    </main>
    
    <footer>
        <script>
            addEventListener("DOMContentLoaded", (event) => {
                const search_button = document.querySelector(".search_button");

                const search_bar = document.querySelector(".search_bar");
                
                search_button.addEventListener("mouseenter", () => {
                    search_button.style.borderLeft = "1px solid var(--gray-3";
                    search_button.style.borderRadius = "2rem";
                    search_button.style.marginLeft = "1rem";
                    search_bar.style.borderRadius = "2rem";
                })

                // Search button hover
                search_button.addEventListener("mouseleave", () => {
                    search_button.style.borderLeft = "0px solid var(--gray-3";
                    search_button.style.borderTopLeftRadius = "0";
                    search_button.style.borderTopRightRadius = "1rem";
                    search_button.style.borderBottomLeftRadius = "0";
                    search_button.style.borderBottomRightRadius = "1rem";
                    
                    search_bar.style.borderTopLeftRadius = "1rem";
                    search_bar.style.borderTopRightRadius = "0";
                    search_bar.style.borderBottomLeftRadius = "1rem";
                    search_bar.style.borderBottomRightRadius = "0";
                    
                    search_button.style.marginLeft = "0";
                })
                
                
                // Search bar hover
                // search_bar.addEventListener("mouseenter", () => {
                //     search_button.style.borderLeft = "1px solid var(--gray-3";
                //     search_button.style.borderRadius = "2rem";
                //     search_bar.style.marginRight = "1rem";
                //     search_bar.style.borderRadius = "2rem";
                // })
                
                // search_bar.addEventListener("mouseleave", () => {
                //     search_button.style.borderLeft = "0px solid var(--gray-3";
                //     search_button.style.borderTopLeftRadius = "0";
                //     search_button.style.borderTopRightRadius = "1rem";
                //     search_button.style.borderBottomLeftRadius = "0";
                //     search_button.style.borderBottomRightRadius = "1rem";

                //     search_bar.style.borderTopLeftRadius = "1rem";
                //     search_bar.style.borderTopRightRadius = "0";
                //     search_bar.style.borderBottomLeftRadius = "1rem";
                //     search_bar.style.borderBottomRightRadius = "0";

                //     search_bar.style.marginRight = "0";
                // })
                
            });
        </script>

        <!-- <script>
            (g => {
                var h, a, k, p = "The Google Maps JavaScript API",
                    c = "google",
                    l = "importLibrary",
                    q = "__ib__",
                    m = document,
                    b = window;
                b = b[c] || (b[c] = {});
                var d = b.maps || (b.maps = {}),
                    r = new Set,
                    e = new URLSearchParams,
                    u = () => h || (h = new Promise(async (f, n) => {
                        await (a = m.createElement("script"));
                        e.set("libraries", [...r] + "");
                        for (k in g) e.set(k.replace(/[A-Z]/g, t => "_" + t[0].toLowerCase()), g[k]);
                        e.set("callback", c + ".maps." + q);
                        a.src = `https://maps.${c}apis.com/maps/api/js?` + e;
                        d[q] = f;
                        a.onerror = () => h = n(Error(p + " could not load."));
                        a.nonce = m.querySelector("script[nonce]")?.nonce || "";
                        m.head.append(a)
                    }));
                d[l] ? console.warn(p + " only loads once. Ignoring:", g) : d[l] = (f, ...n) => r.add(f) && u().then(() => d[l](f, ...n))
            })({
                key: API_KEY,
                v: "weekly",
                // Use the 'v' parameter to indicate the version to use (weekly, beta, alpha, etc.).
                // Add other bootstrap parameters as needed, using camel case.
            });
        </script>
    
        <script>
            const locations = <?= $jsonLocations ?>;
    
            let map;
    
            // const pinIcon = 'data:image/svg+xml;utf-8, <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="32" height="32" viewBox="0 0 24 24" enable-background="new 0 0 24 24" xml:space="preserve"><path d="M14,11.5c1.4,0,2.5-1.1,2.5-2.5S15.4,6.5,14,6.5S11.5,7.6,11.5,9S12.6,11.5,14,11.5 M14,2c3.9,0,7,3.1,7,7c0,5.2-7,13-7,13 S7,14.2,7,9C7,5.1,10.1,2,14,2 M5,9c0,4.5,5.1,10.7,6,11.8L10,22c0,0-7-7.8-7-13c0-3.2,2.1-5.8,5-6.7C6.2,3.9,5,6.3,5,9z"/> <rect fill="none" width="24" height="24"/> </svg>';
    
            async function initMap() {
                // Request needed libraries.
                const { Map } = await google.maps.importLibrary("maps");
    
                const { AdvancedMarkerElement } = await google.maps.importLibrary("marker");
    
                const map = new Map(document.getElementById("map"), {
                    center: {
                        lat: -29.7173,
                        lng: -29.7173
                    },
                    zoom: 4,
                    gestureHandling: "cooperative",
                    mapId: "4504f8b37365c3d0",
                });
                
                locations.forEach(location => {
                    const marker = new google.maps.Marker({
                        map: map,
                        position: {
                            lat: parseFloat(location.latitude),
                            lng: parseFloat(location.longitude)
                        },
                        title: location.title,
                        // icon: pinIcon,
                        optmized: false
                    });
    
                    // Opcional: Adiciona uma janela de informação para cada marcador
                    const infoWindow = new google.maps.InfoWindow({
                        content: `<h3>${location.title}</h3><p>${location.address}</p>`
                    });
    
                    // Exibe a infoWindow ao clicar no marcador
                    marker.addListener("click", () => {
                        infoWindow.open(map, marker);
                    });
                });
            }
    
            window.onload = initMap;
        </script> -->
    </footer>

</body>

</html>