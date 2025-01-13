<?php
// Inclure les articles
include_once 'articles.php';

// Appliquer un filtre pour afficher uniquement les articles de la catégorie "vetement"
$filteredArticles = array_filter($articles, function ($article) {
    $desiredCategories = ["lunette", "homme"]; // Les catégories que vous voulez filtrer
    return isset($article['category']) 
        && is_array($article['category']) 
        && !array_diff($desiredCategories, $article['category']);
});

// Appliquer des filtres supplémentaires si des paramètres GET sont fournis
if (!empty($_GET)) {
    // Filtrage par catégorie
    if (!empty($_GET['category'])) {
        $selectedCategories = is_array($_GET['category']) ? $_GET['category'] : [$_GET['category']];
        $filteredArticles = array_filter($filteredArticles, function ($article) use ($selectedCategories) {
            // Vérifier si l'article a une catégorie qui correspond à une catégorie sélectionnée
            return isset($article['category']) && is_array($article['category']) &&
                !empty(array_intersect($article['category'], $selectedCategories));
        });
    }

    // Filtrage par couleur
    if (!empty($_GET['color'])) {
        $selectedColors = $_GET['color']; // Les couleurs sélectionnées par l'utilisateur
        $filteredArticles = array_filter($filteredArticles, function($article) use ($selectedColors) {
            // Vérifier si l'article contient au moins une couleur correspondant aux couleurs sélectionnées
            return !empty(array_intersect($selectedColors, $article['colors']));
        });
    }

    // Filtrage par marque
    if (!empty($_GET['brand'])) {
        $selectedBrands = $_GET['brand']; // Les marques sélectionnées par l'utilisateur
        $filteredArticles = array_filter($filteredArticles, function($article) use ($selectedBrands) {
            // Vérifier si l'article correspond à une marque sélectionnée
            return isset($article['brand']) && in_array($article['brand'], $selectedBrands);
        });
    }

    // Filtrage par prix maximum
    if (!empty($_GET['max_price']) && is_numeric($_GET['max_price'])) {
        $filteredArticles = array_filter($filteredArticles, function ($article) {
            return isset($article['price']) && $article['price'] <= $_GET['max_price'];
        });
    }
}

?>
<!DOCTYPE html>
<html lang="fr">


<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Produits</title>
<link rel="stylesheet" href="./assets/css/main.css" />
<link rel="stylesheet" href="./assets/css/global/header-bis.css" />
<link rel="stylesheet" href="./assets/css/global/vitrine.css">

<body>
    <header class="header">
        <a href="index.html" class="logo"><img src="./assets/img/logo/logo.png" alt="Logo Kaizen" />Kaizen</a>
        <input class="menu-btn" type="checkbox" id="menu-btn" />
        <label class="menu-icon" for="menu-btn"><span class="navicon"></span></label>
        <ul class="menu">
            <li class="dropdown">
                <a href="vetement_all.php" class="dropdown-link">
                    <svg width="32px" height="32px" fill="currentColor" viewBox="0 0 512.02 512.02"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M70.784,270.575c1.664,1.664,3.849,2.5,6.033,2.5s4.369-0.836,6.033-2.5c3.336-3.337,3.336-8.73,0-12.066l-51.2-51.2
              c-8.141-8.141-14.566-14.566-14.566-28.1s6.426-19.959,14.566-28.1l128-128c4.864-4.864,16.051-6.016,19.567-6.033h179.2v153.609
              H196.326h-0.085H42.735c-4.719,0-8.533,3.823-8.533,8.533c0,4.71,3.814,8.533,8.533,8.533h150.025l48.691,48.691
              c1.664,1.664,3.849,2.5,6.033,2.5c2.185,0,4.369-0.836,6.033-2.5c3.337-3.337,3.337-8.73,0-12.066l-36.625-36.625h201.31
              c4.719,0,8.533-3.823,8.533-8.533c0-4.71-3.814-8.533-8.533-8.533h-42.718v-17.075h42.667c4.719,0,8.533-3.823,8.533-8.533
              c0-4.71-3.814-8.533-8.533-8.533h-42.667v-17.067h42.667c4.719,0,8.533-3.823,8.533-8.533s-3.814-8.533-8.533-8.533h-42.667
              V85.342h42.667c4.719,0,8.533-3.823,8.533-8.533s-3.814-8.533-8.533-8.533h-42.667V51.209h42.667
              c4.719,0,8.533-3.823,8.533-8.533c0-4.71-3.814-8.533-8.533-8.533h-42.667V17.075h42.667c4.719,0,8.533-3.823,8.533-8.533
              s-3.814-8.533-8.533-8.533H179.217c-2.108,0-20.907,0.307-31.633,11.034l-128,128c-8.713,8.721-19.567,19.567-19.567,40.166
              s10.854,31.445,19.567,40.166L70.784,270.575z" />
                        <path d="M494.95,411.179v-27.17c0-72.363-56.115-134.912-128.512-150.059c-2.432-16.444-16.503-29.141-33.621-29.141
              s-31.189,12.698-33.621,29.141c-72.397,15.147-128.512,77.696-128.512,150.059c0,4.71,3.814,8.533,8.533,8.533
              c4.719,0,8.533-3.823,8.533-8.533c0-64.794,53.845-122.377,120.218-134.195c0.068-0.009,0.128-0.009,0.196-0.009
              c0.06-0.009,0.102-0.043,0.162-0.043c8.013-1.408,16.179-2.287,24.491-2.287c77.278,0,145.067,63.804,145.067,136.533v34.133
              c0,4.71,3.814,8.533,8.533,8.533c4.71,0,8.533,3.831,8.533,8.533v51.2c0,4.702-3.823,8.533-8.533,8.533h-8.533v-42.667
              c0-4.71-3.814-8.533-8.533-8.533c-4.719,0-8.533,3.823-8.533,8.533v42.667H443.75v-42.667c0-4.71-3.814-8.533-8.533-8.533
              s-8.533,3.823-8.533,8.533v42.667h-17.067v-42.667c0-4.71-3.814-8.533-8.533-8.533s-8.533,3.823-8.533,8.533v42.667h-17.067
              v-42.667c0-4.71-3.814-8.533-8.533-8.533s-8.533,3.823-8.533,8.533v42.667H341.35v-42.667c0-4.71-3.814-8.533-8.533-8.533
              s-8.533,3.823-8.533,8.533v42.667h-17.067v-42.667c0-4.71-3.814-8.533-8.533-8.533c-4.719,0-8.533,3.823-8.533,8.533v42.667
              h-17.067v-42.667c0-4.71-3.814-8.533-8.533-8.533s-8.533,3.823-8.533,8.533v42.667H238.95v-42.667
              c0-4.71-3.814-8.533-8.533-8.533c-4.719,0-8.533,3.823-8.533,8.533v42.667h-17.067v-42.667c0-4.71-3.814-8.533-8.533-8.533
              s-8.533,3.823-8.533,8.533v42.667h-8.533c-4.71,0-8.533-3.831-8.533-8.533v-51.2c0-4.702,3.823-8.533,8.533-8.533h273.067
              c4.719,0,8.533-3.823,8.533-8.533s-3.814-8.533-8.533-8.533H179.217c-14.114,0-25.6,11.486-25.6,25.6v51.2
              c0,14.114,11.486,25.6,25.6,25.6h307.2c14.114,0,25.6-11.486,25.6-25.6v-51.2C512.017,424.098,504.858,414.72,494.95,411.179z
               M332.817,230.409c-5.086,0-10.12,0.29-15.095,0.751c2.833-5.487,8.499-9.284,15.095-9.284c6.545,0,12.177,3.746,15.019,9.276
              C342.878,230.699,337.877,230.409,332.817,230.409z" />
                        <path d="M128.017,460.809H68.284v-153.6h93.867c4.719,0,8.533-3.823,8.533-8.533s-3.814-8.533-8.533-8.533H8.533
              c-4.719,0-8.533,3.823-8.533,8.533s3.814,8.533,8.533,8.533h42.684v17.067H8.533c-4.719,0-8.533,3.823-8.533,8.533
              c0,4.71,3.814,8.533,8.533,8.533h42.684v17.067H8.533c-4.719,0-8.533,3.823-8.533,8.533s3.814,8.533,8.533,8.533h42.684v17.067
              H8.533c-4.719,0-8.533,3.823-8.533,8.533s3.814,8.533,8.533,8.533h42.684v17.067H8.533c-4.719,0-8.533,3.823-8.533,8.533
              s3.814,8.533,8.533,8.533h42.684v17.067H8.533c-4.719,0-8.533,3.823-8.533,8.533s3.814,8.533,8.533,8.533h119.484
              c4.719,0,8.533-3.823,8.533-8.533S132.736,460.809,128.017,460.809z" />
                    </svg>
                    Vêtements
                </a>
                <ul class="sub">
                    <li class="sub-dropdown">
                        <span>Homme <span>˅</span></span>
                        <ul class="sub-submenu">
                            <li><a href="homme.php">Homme - Tout voir</a></li>
                            <li><a href="vetement_homme.php">Vêtements</a></li>
                            <li><a href="sous-vetement-homme.php">Sous-vêtements</a></li>
                            <li><a href="lunette-homme.php">Lunettes</a></li>
                            <li><a href="gants-homme.php">Gants</a></li>
                            <li><a href="chaussure-homme.php">Chaussures</a></li>
                        </ul>
                    </li>
                    <li class="sub-dropdown">
                        <span>Femme <span>˅</span></span>
                        <ul class="sub-submenu">
                            <li><a href="femme.php">Femme - Tout voir</a></li>
                            <li><a href="vetement_femme.php">Vêtements</a></li>
                            <li><a href="sous-vetement-femme.php">Sous-vêtements</a></li>
                            <li><a href="lunette-femme.php">Lunettes</a></li>
                            <li><a href="gants-femme.php">Gants</a></li>
                            <li><a href="chaussure-femme">Chaussures</a></li>
                        </ul>
                    </li>
                    <li class="sub-dropdown">
                        <span>Enfant <span>˅</span></span>
                        <ul class="sub-submenu">
                            <li><a href="enfant.php">Enfant - Tout voir</a></li>
                            <li><a href="vetement_enfant.php">Vêtements</a></li>
                            <li><a href="sous-vetement-enfant.php">Sous-vêtements</a></li>
                            <li><a href="lunette-enfant.php">Lunettes</a></li>
                            <li><a href="gants-enfant.php">Gants</a></li>
                            <li><a href="chaussure-enfant.php">Chaussures</a></li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="accessoire.php" class="dropdown-link">
                    <svg viewBox="0 0 45 45" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="currentColor"
                        class="menu-svg-accessories">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path
                                d="M26.2409 33.633L31.3639 35.498C33.0209 36.101 34.8379 35.375 35.6459 33.864L36.5919 34.209C35.6189 36.177 33.3389 37.17 31.2169 36.504L31.0169 36.436L24.2609 33.978L24.2519 33.974L24.2429 33.97L7.99988 28.058L8.34188 27.118L26.2409 33.633Z"
                                fill="currentColor"></path>
                            <path
                                d="M26.2409 33.633L31.3639 35.498C33.0209 36.101 34.8379 35.375 35.6459 33.864L36.5919 34.209C35.6189 36.177 33.3389 37.17 31.2169 36.504L31.0169 36.436L24.2609 33.978L24.2519 33.974L24.2429 33.97L7.99988 28.058L8.34188 27.118L26.2409 33.633Z"
                                stroke="currentColor"></path>
                            <path
                                d="M24.8639 32.733L29.2689 26.781C29.6909 26.212 29.6519 25.434 29.2009 24.91L29.1899 24.897L29.1789 24.886L29.0899 24.796L29.0789 24.785L29.0679 24.774L26.3989 22.371C26.2339 22.221 26.1889 21.984 26.2809 21.787L26.3259 21.71L29.0999 17.546L30.2979 18.345V18.356L30.3019 18.388L30.3339 18.634L30.3349 18.647C30.3479 18.726 30.3609 18.801 30.3759 18.867C30.6079 19.873 31.1419 20.663 32.0179 21.196C32.8339 21.691 33.9089 21.941 35.2339 21.99V22.99C32.2709 22.883 30.4319 21.806 29.6609 19.916L29.3049 19.044L28.7819 19.828L27.6299 21.557L27.3899 21.916L27.7109 22.207L29.7369 24.031C30.6519 24.855 30.8249 26.216 30.1689 27.238L30.0689 27.382L25.6179 33.294M20.6019 31.208L23.8249 26.992L24.1149 26.613L23.7499 26.307L20.7489 23.774C20.2659 23.366 19.9949 22.788 19.9649 22.19L21.0829 22.61C21.1299 22.705 21.1889 22.796 21.2599 22.878L21.2729 22.893L21.2869 22.906L21.3659 22.983L21.3799 22.998L21.3939 23.009L25.1239 26.158C25.3089 26.313 25.3529 26.575 25.2389 26.781L25.1899 26.854L21.3149 31.759M17.6749 16.692L18.0579 16.835L18.2739 16.49L19.1509 15.089C19.3119 14.832 19.4899 14.586 19.6849 14.354C21.5839 12.092 24.6969 11.449 27.2719 12.578L28.1049 12.944L27.9679 12.046C27.8489 11.269 27.9909 10.449 28.4269 9.72199C29.4229 8.06499 31.5729 7.52899 33.2299 8.52399C34.8869 9.51999 35.4229 11.669 34.4279 13.326C33.9679 14.09 33.2649 14.615 32.4759 14.863L32.3149 14.914L32.2179 15.052L31.7529 15.709L30.9089 15.147L31.6679 14.013C32.4279 13.939 33.1459 13.517 33.5699 12.811C34.2809 11.628 33.8989 10.093 32.7149 9.38199C31.5319 8.66999 29.9959 9.05299 29.2849 10.237C28.8629 10.938 28.8259 11.763 29.1109 12.466L28.0629 14.21C25.7389 12.381 22.3659 12.717 20.4509 14.998C20.3409 15.129 20.2369 15.264 20.1399 15.404L20.1329 15.414L20.0049 15.61L19.9989 15.619L19.3379 16.677L19.0129 17.194L19.5859 17.41"
                                fill="currentColor"></path>
                            <path
                                d="M24.8639 32.733L29.2689 26.781C29.6909 26.212 29.6519 25.434 29.2009 24.91L29.1899 24.897L29.1789 24.886L29.0899 24.796L29.0789 24.785L29.0679 24.774L26.3989 22.371C26.2339 22.221 26.1889 21.984 26.2809 21.787L26.3259 21.71L29.0999 17.546L30.2979 18.345V18.356L30.3019 18.388L30.3339 18.634L30.3349 18.647C30.3479 18.726 30.3609 18.801 30.3759 18.867C30.6079 19.873 31.1419 20.663 32.0179 21.196C32.8339 21.691 33.9089 21.941 35.2339 21.99V22.99C32.2709 22.883 30.4319 21.806 29.6609 19.916L29.3049 19.044L28.7819 19.828L27.6299 21.557L27.3899 21.916L27.7109 22.207L29.7369 24.031C30.6519 24.855 30.8249 26.216 30.1689 27.238L30.0689 27.382L25.6179 33.294M20.6019 31.208L23.8249 26.992L24.1149 26.613L23.7499 26.307L20.7489 23.774C20.2659 23.366 19.9949 22.788 19.9649 22.19L21.0829 22.61C21.1299 22.705 21.1889 22.796 21.2599 22.878L21.2729 22.893L21.2869 22.906L21.3659 22.983L21.3799 22.998L21.3939 23.009L25.1239 26.158C25.3089 26.313 25.3529 26.575 25.2389 26.781L25.1899 26.854L21.3149 31.759M17.6749 16.692L18.0579 16.835L18.2739 16.49L19.1509 15.089C19.3119 14.832 19.4899 14.586 19.6849 14.354C21.5839 12.092 24.6969 11.449 27.2719 12.578L28.1049 12.944L27.9679 12.046C27.8489 11.269 27.9909 10.449 28.4269 9.72199C29.4229 8.06499 31.5729 7.52899 33.2299 8.52399C34.8869 9.51999 35.4229 11.669 34.4279 13.326C33.9679 14.09 33.2649 14.615 32.4759 14.863L32.3149 14.914L32.2179 15.052L31.7529 15.709L30.9089 15.147L31.6679 14.013C32.4279 13.939 33.1459 13.517 33.5699 12.811C34.2809 11.628 33.8989 10.093 32.7149 9.38199C31.5319 8.66999 29.9959 9.05299 29.2849 10.237C28.8629 10.938 28.8259 11.763 29.1109 12.466L28.0629 14.21C25.7389 12.381 22.3659 12.717 20.4509 14.998C20.3409 15.129 20.2369 15.264 20.1399 15.404L20.1329 15.414L20.0049 15.61L19.9989 15.619L19.3379 16.677L19.0129 17.194L19.5859 17.41"
                                stroke="currentColor"></path>
                            <path d="M8.60785 14.061L24.6138 20.065" stroke="currentColor" stroke-width="2"></path>
                        </g>
                    </svg>
                    Accessoirs</a>
                <ul class="sub">
                    <li class="sub-dropdown">
                        <span>Voir plus <span>˅</span></span>
                        <ul class="sub-submenu">
                            <li><a href="ski.php">Ski Alpin</a></li>
                            <li><a href="snow.php">Snowboard</a></li>
                            <li><a href="luge.php">Luge</a></li>
                            <li><a href="raquette.php">Raquettes</a></li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li>
                <a href="tutoriel.html"><svg width="21" height="21" viewBox="0 0 21 21" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M16.8958 5.5L2.5625 9.66667L1.8125 7.66667C1.5625 6.75 2.0625 5.83333 2.89584 5.58333L14.1458 2.25C15.0625 2 15.9792 2.5 16.2292 3.33334L16.8958 5.5Z"
                            stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M5.22913 4.91669L7.81246 8.16669" stroke="currentColor" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <path d="M10.3959 3.33331L12.9792 6.66665" stroke="currentColor" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <path
                            d="M2.5625 9.66669H17.5625V16.3334C17.5625 16.7754 17.3869 17.1993 17.0743 17.5119C16.7618 17.8244 16.3379 18 15.8958 18H4.22917C3.78714 18 3.36322 17.8244 3.05066 17.5119C2.73809 17.1993 2.5625 16.7754 2.5625 16.3334V9.66669Z"
                            stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    Tutoriels</a>
            </li>
            <li>
                <a href="contact.html" aria-label="Menu Vêtements">
                    <svg width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M15.8958 18V16.3333C15.8958 15.4493 15.5446 14.6014 14.9195 13.9763C14.2944 13.3512 13.4465 13 12.5625 13H7.56246C6.6784 13 5.83056 13.3512 5.20544 13.9763C4.58032 14.6014 4.22913 15.4493 4.22913 16.3333V18"
                            stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
                        <path
                            d="M10.0625 9.66667C11.9034 9.66667 13.3958 8.17428 13.3958 6.33333C13.3958 4.49238 11.9034 3 10.0625 3C8.22151 3 6.72913 4.49238 6.72913 6.33333C6.72913 8.17428 8.22151 9.66667 10.0625 9.66667Z"
                            stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>

                    Contact</a>
            </li>
            <li>
                <a href="panier.php">
                    <svg width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M7.22921 18.8334C7.68944 18.8334 8.06254 18.4603 8.06254 18C8.06254 17.5398 7.68944 17.1667 7.22921 17.1667C6.76897 17.1667 6.39587 17.5398 6.39587 18C6.39587 18.4603 6.76897 18.8334 7.22921 18.8334Z"
                            stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
                        <path
                            d="M16.3958 18.8334C16.8561 18.8334 17.2292 18.4603 17.2292 18C17.2292 17.5398 16.8561 17.1667 16.3958 17.1667C15.9356 17.1667 15.5625 17.5398 15.5625 18C15.5625 18.4603 15.9356 18.8334 16.3958 18.8334Z"
                            stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
                        <path
                            d="M2.27087 2.20831H3.93754L6.15421 12.5583C6.23552 12.9374 6.44643 13.2762 6.75063 13.5165C7.05483 13.7568 7.4333 13.8836 7.82087 13.875H15.9709C16.3502 13.8744 16.7179 13.7444 17.0134 13.5065C17.3088 13.2686 17.5143 12.9371 17.5959 12.5666L18.9709 6.37498H4.82921"
                            stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>

                    Panier</a>
            </li>
        </ul>
    </header>
    <div class="main-container">
        <div class="sidebar">
            <h1>Filtrer les produits</h1>
            <form method="GET" action="">
                <details open>
                    <summary><strong>Catégorie :</strong></summary>
                    <label>
                        <input type="checkbox" name="category[]" value="homme"
                            <?php if (!empty($_GET['category']) && in_array('homme', $_GET['category'])) echo 'checked'; ?>>
                        Homme
                    </label><br>
                    <label>
                        <input type="checkbox" name="category[]" value="femme"
                            <?php if (!empty($_GET['category']) && in_array('femme', $_GET['category'])) echo 'checked'; ?>>
                        Femme
                    </label><br>
                    <label>
                        <input type="checkbox" name="category[]" value="enfant"
                            <?php if (!empty($_GET['category']) && in_array('enfant', $_GET['category'])) echo 'checked'; ?>>
                        Enfant
                    </label><br>
                    <label>
                        <input type="checkbox" name="category[]" value="vetement"
                            <?php if (!empty($_GET['category']) && in_array('vetement', $_GET['category'])) echo 'checked'; ?>>
                        Vêtements
                    </label><br>
                    <label>
                        <input type="checkbox" name="category[]" value="sous-vetement"
                            <?php if (!empty($_GET['category']) && in_array('sous-vetement', $_GET['category'])) echo 'checked'; ?>>
                        Sous-vêtement
                    </label><br>
                    <label>
                        <input type="checkbox" name="category[]" value="lunette"
                            <?php if (!empty($_GET['category']) && in_array('lunette', $_GET['category'])) echo 'checked'; ?>>
                        Lunette
                    </label><br>
                    <label>
                        <input type="checkbox" name="category[]" value="gants"
                            <?php if (!empty($_GET['category']) && in_array('gants', $_GET['category'])) echo 'checked'; ?>>
                        Gants
                    </label><br>
                    <label>
                        <input type="checkbox" name="category[]" value="chaussures"
                            <?php if (!empty($_GET['category']) && in_array('chaussures', $_GET['category'])) echo 'checked'; ?>>
                        Chaussures
                    </label><br>
                </details>

                <details>
                    <summary><strong>Marque :</strong></summary>
                    <label>
                        <input type="checkbox" name="brand[]" value="Wedze"
                            <?php if (!empty($_GET['brand']) && in_array('Wedze', $_GET['brand'])) echo 'checked'; ?>>
                        Wedze
                    </label><br>
                    <label>
                        <input type="checkbox" name="brand[]" value="Kipsta"
                            <?php if (!empty($_GET['brand']) && in_array('Kipsta', $_GET['brand'])) echo 'checked'; ?>>
                        Kipsta
                    </label><br>
                    <label>
                        <input type="checkbox" name="brand[]" value="Quecha"
                            <?php if (!empty($_GET['brand']) && in_array('Quecha', $_GET['brand'])) echo 'checked'; ?>>
                        Quecha
                    </label><br>
                </details>

                <details>
                    <summary><strong>Couleur :</strong></summary>
                    <label>
                        <input type="checkbox" name="color[]" value="#FF0000"> Rouge
                    </label>
                    <label>
                        <input type="checkbox" name="color[]" value="#000000"> Noir
                    </label>
                    <label>
                        <input type="checkbox" name="color[]" value="#0000FF"> Bleu
                    </label><br>
                </details>


                <label for="price">Prix maximum :</label>
                <input type="number" name="max_price" id="price" placeholder="Ex: 100"
                    style="width: 100%; margin-top: 5px;"
                    value="<?php if (!empty($_GET['max_price'])) echo htmlspecialchars($_GET['max_price']); ?>"><br><br>

                <button type="submit">Appliquer les filtres</button>
            </form>

        </div>
        <div class="container">
            <?php if (empty($filteredArticles)): ?>
            <p>Aucun produit ne correspond à vos critères.</p>
            <?php else: ?>
            <?php foreach ($filteredArticles as $article): ?>
            <div class="card">
                <a href="produit-bis.php?id=<?= $article['id'] ?>" class="card-link">
                    <!-- Carousel d'images -->
                    <div class="carousel">
                        <?php if (!empty($article['images']) && is_array($article['images'])): ?>
                        <input type="radio" id="slide1-<?= $article['id'] ?>" name="carousel-<?= $article['id'] ?>"
                            checked>
                        <input type="radio" id="slide2-<?= $article['id'] ?>" name="carousel-<?= $article['id'] ?>">
                        <input type="radio" id="slide3-<?= $article['id'] ?>" name="carousel-<?= $article['id'] ?>">

                        <div class="carousel-images">
                            <?php foreach ($article['images'] as $index => $image): ?>
                            <div class="carousel-image">
                                <img src="<?= $image ?>" alt="Image produit <?= $index + 1 ?>">
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <label for="slide1-<?= $article['id'] ?>" class="prev">&#10094;</label>
                        <label for="slide2-<?= $article['id'] ?>" class="next">&#10095;</label>
                        <?php endif; ?>
                    </div>
                    <h1><?=htmlspecialchars($article['brand'])?></h1>
                    <h2><?= htmlspecialchars($article['name']) ?></h2>
                    <div class="price">
                        <?= $article['price'] ?>€
                        <?php if (!empty($article['old_price'])): ?>
                        <span class="old-price"><?= $article['old_price'] ?>€</span>
                        <?php endif; ?>
                    </div>
                </a>
                <form method="POST" action="panier.php">
                    <input type="hidden" name="product_name" value="<?= htmlspecialchars($article['name']) ?>">
                    <input type="hidden" name="product_price" value="<?= htmlspecialchars($article['price']) ?>">

                    <label for="size-<?= $article['id'] ?>">Taille :</label>
                    <select name="product_size" id="size-<?= $article['id'] ?>" required>
                        <option value="" disabled selected>Sélectionnez une taille</option>
                        <?php foreach ($article['sizes'] as $size): ?>
                        <option value="<?= htmlspecialchars($size) ?>"><?= htmlspecialchars($size) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <br>
                    <div class="color-swatches">
                        <?php foreach ($article['colors'] as $color): ?>
                        <div class="color-swatch">
                            <input type="radio" id="color-<?= htmlspecialchars($color) ?>-<?= $article['id'] ?>"
                                name="product_color" value="<?= htmlspecialchars($color) ?>" required
                                style="display: none;">
                            <label for="color-<?= htmlspecialchars($color) ?>-<?= $article['id'] ?>"
                                style="width: 30px; height: 30px; border-radius: 50%; background-color: <?= htmlspecialchars($color) ?>; cursor: pointer; border: 2px solid #ccc; display: inline-block;">
                            </label>
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <label class="quantity" for="quantity-<?= $article['id'] ?>">Quantité :</label>
                    <input type="number" name="quantity" id="quantity-<?= $article['id'] ?>" value="1" min="1" required>
                    <br>
                    <button type="submit" name="add_to_cart">Ajouter au panier</button>
                </form>
            </div>
            <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
    <footer>
        <div class="footer-settings">
            <div class="language-selector">
                <label for="language">Langue :</label>
                <select id="language" name="language">
                    <option value="fr">Français</option>
                    <option value="en">English</option>
                </select>
            </div>
            <div class="vision-mode-toggle">
                <label for="vision-mode">Mode malvoyant :</label>
                <button id="vision-mode">Activer</button>
            </div>
        </div>
        <div class="footer-container">
            <div class="footer-section">
                <input type="checkbox" id="discover" class="toggle" />
                <label for="discover">Notre entreprise <span>˅</span></label>
                <ul class="content">
                    <h2 class="section-title">Notre entreprise</h2>
                    <li><a href="temporaire.html">Qui sommes-nous ?</a></li>
                    <li><a href="temporaire.html">La vie de nos produits</a></li>
                    <li><a href="temporaire.html">Engagement durable</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <input type="checkbox" id="help" class="toggle" />
                <label for="help">Besoin d'aide <span>˅</span></label>
                <ul class="content">
                    <h2 class="section-title">Besoin d'aide</h2>
                    <li><a href="temporaire.html">Mode de livraison</a></li>
                    <li><a href="temporaire.html">Moyens de paiement</a></li>
                    <li><a href="temporaire.html">Comment choisir votre produit</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <input type="checkbox" id="sport" class="toggle" />
                <label for="sport">Faire du sport <span>˅</span></label>
                <ul class="content">
                    <h2 class="section-title">Faire du sport</h2>
                    <li><a href="tutoriel.html">Tutoriels</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <input type="checkbox" id="follow" class="toggle" />
                <label for="follow">Suivez-nous <span>˅</span></label>
                <div class="content social-media">
                    <a href="temporaire.html" class="social-icon facebook">
                        <svg width="21" height="21" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M12 2.03998C6.5 2.03998 2 6.52998 2 12.06C2 17.06 5.66 21.21 10.44 21.96V14.96H7.9V12.06H10.44V9.84998C10.44 7.33998 11.93 5.95998 14.22 5.95998C15.31 5.95998 16.45 6.14998 16.45 6.14998V8.61998H15.19C13.95 8.61998 13.56 9.38998 13.56 10.18V12.06H16.34L15.89 14.96H13.56V21.96C15.9164 21.5878 18.0622 20.3855 19.6099 18.57C21.1576 16.7546 22.0054 14.4456 22 12.06C22 6.52998 17.5 2.03998 12 2.03998Z"
                                fill="currentColor" />
                        </svg>
                        Facebook
                    </a>
                    <a href="temporaire.html" class="social-icon instagram">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" width="21" height="21">
                            <path
                                d="M7.75 2H16.25C19.35 2 22 4.65 22 7.75V16.25C22 19.35 19.35 22 16.25 22H7.75C4.65 22 2 19.35 2 16.25V7.75C2 4.65 4.65 2 7.75 2ZM7.75 4C5.68 4 4 5.68 4 7.75V16.25C4 18.32 5.68 20 7.75 20H16.25C18.32 20 20 18.32 20 16.25V7.75C20 5.68 18.32 4 16.25 4H7.75ZM12 7C14.76 7 17 9.24 17 12C17 14.76 14.76 17 12 17C9.24 17 7 14.76 7 12C7 9.24 9.24 7 12 7ZM12 9C10.34 9 9 10.34 9 12C9 13.66 10.34 15 12 15C13.66 15 15 13.66 15 12C15 10.34 13.66 9 12 9ZM17.5 6C18.33 6 19 6.67 19 7.5C19 8.33 18.33 9 17.5 9C16.67 9 16 8.33 16 7.5C16 6.67 16.67 6 17.5 6Z"
                                fill="currentColor" />
                        </svg>
                        Instagram
                    </a>
                </div>
            </div>
        </div>
        <div class="footer-bottom-container">
            <div class="footer-bottom">
                <h3>&copy; 2024 Kaizen - Tous droits réservés.</h3>
            </div>
            <div class="footer-bottom-link">
                <ul>
                    <li><a href="temporaire.html">Transparence des produit</a></li>
                    <li><a href="temporaire.html">Condition Générales</a></li>
                    <li><a href="temporaire.html">Mention légales</a></li>
                    <li><a href="temporaire.html">Données personnelles</a></li>
                    <li><a href="temporaire.html">Gestion des cookies</a></li>
                    <li><a href="contact.html">Contact</a></li>
                </ul>
            </div>
        </div>
    </footer>
</body>

</html>