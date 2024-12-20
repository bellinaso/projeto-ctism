<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookease - Estabelecimentos</title>
    <link rel="stylesheet" href="/public/css/establishments.css">
    <link rel="stylesheet" href="/public/css/components/red_button.css">
    <link rel="stylesheet" href="/public/css/components/header.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://kit.fontawesome.com/0aaabe9207.js" crossorigin="anonymous"></script>
    <script src="../config.js"></script>
</head>

<body>
    <?php
        include '../config.php';
        require_once '../controller/establishments_controller.php';
        require_once '../controller/categories_controller.php';

        
        $establishments = get_establishments();
        $categories = get_subcategory();
        $jsonEstablishments = json_encode($establishments);



        @session_start();
        $_SESSION['last_page'] = 'establishments.php';
    ?>
    <header>
        <div class="header">
            <div class="logo">
                <a href="/view/index.php">
                    <img src="/public/images/logos_horizontal/logo1_white.svg" alt="" class="logo_image">
                </a>
            </div>
            <div class="header_buttons">
                <div class="account_pages">
                    <a href="/view/myaccount.php" class="profile_picture">
                        <i class="fa-regular fa-user"></i>
                    </a>
                    <div>
                        <?php
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
                            else {
                                echo '
                                    <a href="/view/myaccount.php">
                                        <span>MINHA CONTA</span>
                                    </a>
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
            <div class="categories_slider">
                <button class="slider_button left"><i class="fa-solid fa-chevron-left"></i></button>
                <div class="categories_section">
                    <?php
                        foreach($categories as $c) {
                            echo '
                                <a href="" class="category">
                                    <span>
                                        '.$c['name'].'
                                    </span>
                                </a>
                            ';
                        }
                    ?>
                </div>
                <button class="slider_button right"><i class="fa-solid fa-chevron-right"></i></button>
            </div>
        </div>
        <div class="establishments_section">
            <div class="establishments_map" id="map"></div>

            <div class="establishments_list">
                <?php
                    if($establishments != null) {
                        foreach($establishments as $e) {
                            echo '
                            <div class="establishment">
    
                                <div class="establishment_image">
                                    <a href="/view/establishment_page.php?id='.$e['id'].'">
                                        <img src="../controller/uploads/'.$e['cnpj'].'.jpg" alt="" class="image_icon">
                                    </a>
                                </div>
    
                                <div class="establishment_info">
                                    <h3>
                                        <a href="/view/establishment_page.php?id='.$e['id'].'">
                                        '.$e['name'].'
                                        </a>
                                    </h3>
                                    <p>
                                        <span>Descrição: </span>
                                        '.$e['description'].'
                                    </p>
                                    <p>
                                        <span>Categoria: </span>
                                        '.$e['category_name'].'
                                    </p>
                                    <p>
                                        <span>Subcategoria: </span>
                                        '.$e['subcategory_name'].'
                                    </p>
                                    <p>
                                        <span>Endereço: </span>
                                        '.$e['address'].'
                                    </p>
                                </div>
    
                                <div class="open_establishment">
                                    <a href="/view/establishment_page.php?id='.$e['id'].'">
                                        <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                    </a>
                                </div>
    
                            </div>
                            ';
                        }
                    }
                    else {
                        echo '
                            <div class="not_found">
                                <i class="fa-solid fa-circle-exclamation"></i>
                                <h1>
                                    Ops!
                                </h1>
                                <h2>
                                    Parece que nenhum<br>
                                    estabelecimento<br>
                                    foi encontrado!
                                </h2>
                            </div>
                        ';
                    }
                ?>
            </div>
        </div>
    </main>
    
    <footer>
        
    </footer>
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
        });
    </script>


    <script>
        const leftButton = document.querySelector('.slider_button.left');
        const rightButton = document.querySelector('.slider_button.right');
        const categoriesSection = document.querySelector('.categories_section');

        // Função para rolar o slider
        function scrollSlider(direction) {
            const scrollAmount = 350; // Ajuste o valor para controlar a distância da rolagem
            categoriesSection.scrollBy({
                left: direction === 'right' ? scrollAmount : -scrollAmount,
                behavior: 'smooth',
            });
        }

        // Eventos de clique para as setas de navegação
        leftButton.addEventListener('click', () => scrollSlider('left'));
        rightButton.addEventListener('click', () => scrollSlider('right'));
    </script>


    <script>
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
        const locations = <?= $jsonEstablishments ?>;

        let map;

        async function initMap() {
            // Request needed libraries.
            const { Map } = await google.maps.importLibrary("maps");

            const { AdvancedMarkerElement } = await google.maps.importLibrary("marker");

            const map = new Map(document.getElementById("map"), {
                center: {
                    lat: -29.6870867,
                    lng: -53.8169043
                },
                zoom: 13,
                gestureHandling: "cooperative",
                mapId: "4504f8b37365c3d0",

                streetViewControl: false,
                mapTypeControl: false,
                fullscreenControl: false,
            });

            
            locations.forEach(location => {
                const marker = new google.maps.Marker({
                    map: map,
                    position: {
                        lat: parseFloat(location.latitude),
                        lng: parseFloat(location.longitude)
                    },
                    title: location.title,
                    // label: {
                    //     // text: `${location.title}`,
                    //     text: `teste`,
                    //     color: "#BD2A2E",
                    //     fontSize: "14px",
                    //     fontWeight: "bold"
                    // },
                    optmized: false
                });

                // Opcional: Adiciona uma janela de informação para cada marcador
                const infoWindow = new google.maps.InfoWindow({
                    content: `
                    <div style='float: left; object-fit: cover;'>
                        <img style="width: 6rem; heigth: 6rem;" src='../controller/uploads/${location.image}.jpg'>
                    </div>
                    <div style='float:right; padding: 10px;'>
                        <h3><a href="/view/establishment_page.php?id=${location.id}">${location.name}</a></h3>
                        <p>${location.address}</p>
                    </div>`
                });

                // Exibe a infoWindow ao clicar no marcador
                marker.addListener("click", () => {
                    infoWindow.open(map, marker);
                });
            });
        }

        window.onload = initMap;
    </script>
</body>

</html>